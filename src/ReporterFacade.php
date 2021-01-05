<?php

namespace Mokhosh\LaravelReporter;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mokhosh\LaravelReporter\Skeleton\SkeletonClass
 */
class ReporterFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-reporter';
    }
}
