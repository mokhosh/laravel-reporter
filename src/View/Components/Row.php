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

    public function formattedRow(): object
    {
        foreach ($this->columns as $title => $modifier) {
            $columns = [];
            $class = $this->isEven ? 'even-classes ' : 'odd-classes ';

            if (is_object($modifier) && $modifier instanceof Closure) {
                $columns[$title] = $modifier($this->row);
            } else if (is_string($modifier)) {
                $columns[$title] = $this->row->{$modifier};
            } else if (is_array($modifier)) {
                $class .= $modifier['class'] ?? '';

                if (isset($modifier['transform'])) {
                    $columns[$title] = $modifier['transform']($this->row);
                }
            }
        }

        return (object) [
            'columns' => $columns ?? null,
            'class' => $class ?? null,
        ];
    }

    public function render(): View
    {
        return view('laravel-reporter::components.row');
    }
}
