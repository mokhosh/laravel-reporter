<?php

namespace Mokhosh\LaravelReporter;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mokhosh\LaravelReporter\Skeleton\SkeletonClass
 */
class LaravelReporterFacade extends Facade
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
