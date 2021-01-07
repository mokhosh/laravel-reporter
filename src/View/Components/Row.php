<?php

namespace Mokhosh\Reporter\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;

class Row extends Component
{
    public function __construct(
        public Model $row,
        public array $columns,
        public bool $isEven,
    ) {}

    public function formattedRow(): array
    {
        $columns = [];

        foreach ($this->columns as $title => $modifier) {
            $columns[] = (object) [
                'class' => is_array($modifier)
                    ? $modifier['class']
                    : '',
                'title' => is_array($modifier)
                    ? $modifier['transform']($this->row->{$title})
                    : $this->row->{$title},
            ];
        }

        return $columns;
    }

    public function render(): View
    {
        return view('laravel-reporter::components.row');
    }
}
