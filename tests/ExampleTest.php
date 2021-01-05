<?php

namespace Mokhosh\LaravelReporter\Tests;

use Orchestra\Testbench\TestCase;
use Mokhosh\LaravelReporter\LaravelReporterServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelReporterServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
