<?php

namespace Mokhosh\Reporter;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\App;

class Reporter
{
    protected bool $stream = false;

    public function __construct(
        public Builder $query,
    ) {}

    public static function report(Builder $query): static
    {
        return new static($query);
    }

    public function pdf()
    {
        $snappy = App::make('snappy.pdf.wrapper');
        $snappy->loadView('laravel-reporter::pdf', $this->getData());
        return $this->stream ? $snappy->stream() : $snappy->download();
    }

    public function stream($stream = true): static
    {
        $this->stream = $stream;

        return $this;
    }

    protected function getData()
    {
        return [];
    }
}
