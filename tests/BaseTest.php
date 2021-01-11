<?php

namespace Mokhosh\Reporter\Tests;

use Illuminate\Foundation\Auth\User as BaseUser;
use Mokhosh\Reporter\ReporterServiceProvider;
use Maatwebsite\Excel\ExcelServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class BaseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadLaravelMigrations();
    }

    protected function getPackageProviders($app): array
    {
        return [
            ReporterServiceProvider::class,
            ExcelServiceProvider::class,
        ];
    }
}

Class User extends BaseUser
{
    protected $guarded = [];
    protected $hidden = ['password'];
}
