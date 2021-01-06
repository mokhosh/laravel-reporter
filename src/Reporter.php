<?php

namespace Mokhosh\Reporter;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use JetBrains\PhpStorm\Pure;

class Reporter
{

    public function __construct(
        protected Builder $query,
        protected array $columns = [],
        protected string $title = 'Report',
        protected array $meta = [],
        protected bool $header = true,
        protected bool $stream = false,
    ) {}

    #[Pure]
    public static function report(...$args): static
    {
        return new static(...$args);
    }

    public function pdf()
    {
        $snappy = App::make('snappy.pdf.wrapper');
        $snappy->loadHtml($this->getHtml());
        return $this->stream ? $snappy->stream() : $snappy->download();
    }

    public function stream($stream = true): static
    {
        $this->stream = $stream;

        return $this;
    }

    public function getColumns(): array
    {
        if (empty($this->columns)) return $this->getColumnsFromModel();

        $columns = [];
        foreach ($this->columns as $key => $value) {
            if (is_numeric($key) && is_string($value)) {
                $columns[] = $value;
            } elseif (is_string($key)) {
                $columns[] = $key;
            } else {
                throw new Exception('Wrong set of columns');
            }
        }

        return $columns;
    }

    public function getData()
    {
        return [];
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

    public function getHtml()
    {
        // todo differentiate between columns and formatter?
        return View::make('laravel-reporter::pdf', [
            'query' => $this->query,
            'columns' => $this->columns,
            'title' => $this->title,
            'meta' => $this->meta,
            'header' => $this->header,
        ]);
    }
}
