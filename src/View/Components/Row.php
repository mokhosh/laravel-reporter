<?php

namespace Mokhosh\Reporter\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Component;
use JetBrains\PhpStorm\Pure;
use Stringable;

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
                    ? $modifier['transform']($this->row->{$title}, $this->row)
                    : $this->stringify($this->row->{$title}),
                'format' => is_array($modifier)
                    ? $modifier['format']
                    : '@',
            ];
        }

        return $columns;
    }

    #[Pure]
    public function stringify(mixed $mixed): string
    {
        if (is_array($mixed)) return implode($mixed);
        if (is_object($mixed) && !!! $mixed instanceof Stringable) return '-';
        return (string) $mixed;
    }

    public function render(): View
    {
        return view('laravel-reporter::components.row');
    }
}
