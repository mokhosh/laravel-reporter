<?php

namespace Mokhosh\Reporter\Tests;

use Mokhosh\Reporter\ReporterServiceProvider;
use Illuminate\Foundation\Auth\User;
use Orchestra\Testbench\TestCase;
use Mokhosh\Reporter\Reporter;

class BaseTest extends TestCase
{

    protected function getPackageProviders($app): array
    {
        return [ReporterServiceProvider::class];
    }

    /** @test */
    public function it_can_return_itself()
    {
        $reporter = Reporter::report(User::query());

        $this->assertTrue($reporter instanceof Reporter);
    }
}
