<?php

namespace Mokhosh\Reporter;

use Closure;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;
use Mokhosh\Reporter\Services\PdfService;

class Reporter
{

    public function __construct(
        protected Builder $query,
        protected array $columns = [],
        protected string $title = 'Report',
        protected array $meta = [],
        protected bool $header = true,
        protected bool $download = false,
    ) {}

    #[Pure]
    public static function report(...$args): static
    {
        return new static(...$args);
    }

    public function pdf()
    {
        $service = new PdfService($this->getHtml(), $this->getOptions());
        return $this->download ? $service->download() : $service->inline();
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

    public function getHtml(): string
    {
        return View::make('laravel-reporter::pdf', [
            'query' => $this->query,
            'columns' => $this->getColumns(),
            'title' => $this->title,
            'meta' => $this->meta,
            'header' => $this->header,
        ])->render();
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
                'bottom' => '36px',
                'left' => '36px',
            ],
            'displayHeaderFooter' => true,
            'footerTemplate' => $this->getFooterTemplate(),
            'headerTemplate' => $this->getFooterTemplate(),
        ];
    }

    protected function getFooterTemplate(): string
    {
        return View::make('laravel-reporter::footer')->render();
    }
}
