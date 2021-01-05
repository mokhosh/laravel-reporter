<?php

namespace Mokhosh\Reporter;

use Illuminate\Database\Eloquent\Builder;

class Reporter
{
    public function __construct(public Builder $query) {}

    public static function report(Builder $query): static { return new static($query); }
}
