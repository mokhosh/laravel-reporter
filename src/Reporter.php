<?php

namespace Mokhosh\Reporter;

use Closure;
use Exception;
use Illuminate\Contracts\View\View as Renderable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;
use Mokhosh\Reporter\Services\PdfService;
use Mokhosh\Reporter\Services\ExcelService;

class Reporter
{

    public function __construct(
        protected Builder $query,
        protected array $columns = [],
        protected string $title = 'Report',
        protected array $meta = [],
        protected ?string $logo = null,
        protected bool $header = true,
        protected bool $footer = false,
        protected bool $download = false,
        protected array $formats = [],
    ) {}

    #[Pure]
    public static function report(...$args): static
    {
        return new static(...$args);
    }

    public function pdf()
    {
        $service = new PdfService(html: $this->getHtml(), filename: $this->getFileName(), options: $this->getOptions());
        return $this->download ? $service->download() : $service->inline();
    }

    public function excel()
    {
        $service = new ExcelService(view: $this->getView(), filename: $this->getFileName());
        return $service->download();
    }

    public function download($download = true): static
    {
        $this->download = $download;

        return $this;
    }

    public function getColumns(): array
    {
        if (empty($this->columns)) $this->columns = $this->getColumnsFromModel();

        $columns = [];
        foreach ($this->columns as $key => $value) {
            if (is_numeric($key) && is_string($value)) {
                $columns[$value] = $this->getTitleFromColumnName($value);
            } elseif (is_string($key)) {
                $columns[$key] = $value;
                if (is_object($value) && $value instanceof Closure) $columns[$key] = ['transform' => $value];
                if (is_array($columns[$key])) {
                    $columns[$key]['title'] ??= $this->getTitleFromColumnName($key);
                    $columns[$key]['class'] ??= '';
                    $columns[$key]['transform'] ??= fn($a) => $a;
                    $columns[$key]['format'] ??= '@';
                }
            } else {
                throw new Exception('Wrong set of columns');
            }
        }

        return $columns;
    }

    public function getColumnsFromModel(): array
    {
        return array_diff(
            Schema::getColumnListing($this->query->getQuery()->from),
            $this->query->getModel()->getHidden()
        );
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getMeta(): array
    {
        return $this->meta;
    }

    public function getView(): Renderable
    {
        return View::make('laravel-reporter::pdf', [
            'query' => $this->query,
            'columns' => $this->getColumns(),
            'title' => $this->title,
            'meta' => $this->meta,
            'logo' => $this->logo,
            'header' => $this->header,
        ]);
    }

    public function getHtml(): string
    {
        return $this->getView()->render();
    }

    protected function getTitleFromColumnName(string $value): string
    {
        return (string)Str::of($value)->title()->replace('_', ' ');
    }

    protected function getOptions(): array
    {
        return [
            'format' => 'a4',
            'margin' => [
                'top' => '36px',
                'right' => '36px',
                'bottom' => '56px',
                'left' => '36px',
            ],
            'displayHeaderFooter' => $this->footer,
            'footerTemplate' => $this->getFooterTemplate(),
            'headerTemplate' => '<span></span>',
        ];
    }

    protected function getFooterTemplate(): string
    {
        return View::make('laravel-reporter::footer')->render();
    }

    public function getFileName()
    {
        $fileName = $this->title;

        foreach ($this->meta as $key => $value) {
            $fileName = $fileName.'-'.$key.'-'.$value;
        }

        return Str::kebab($fileName);
    }
}
