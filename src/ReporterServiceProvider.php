<?php

namespace Mokhosh\Reporter;

use Illuminate\Support\ServiceProvider;
use Mokhosh\Reporter\Console\Commands\InstallCommand;
use Mokhosh\Reporter\View\Components\Row;

class ReporterServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-reporter');
        $this->loadViewComponentsAs('laravel-reporter', [
            Row::class,
        ]);

        if ($this->app->runningInConsole()) {

            $this->commands([
                InstallCommand::class,
            ]);

            // Publishing the configs.
            /*$this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-reporter.php'),
            ], 'config');*/
            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-reporter'),
            ], 'views');*/
        }
    }

    public function register()
    {
        // Automatically apply the package configuration
        // $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-reporter');

        // Register the main class to use with the facade
        // $this->app->singleton('laravel-reporter', function () {
        //     return new Reporter;
        // });
    }
}
