<?php

namespace Mokhosh\Reporter\Tests;

use Barryvdh\Snappy\ServiceProvider;
use Illuminate\Foundation\Auth\User as BaseUser;
use Mokhosh\Reporter\Reporter;
use Mokhosh\Reporter\ReporterServiceProvider;
use Orchestra\Testbench\TestCase;

class BaseTest extends TestCase
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
            ServiceProvider::class,
        ];
    }

    /** @test */
    public function it_can_return_itself()
    {
        $reporter = Reporter::report(User::query());

        $this->assertTrue($reporter instanceof Reporter);
    }

    /** @test */
    public function it_contains_query_data()
    {
        User::create([
            'name' => 'Mo Khosh',
            'email' => 'mskhoshnazar@gmail.com',
            'password' => 'password',
        ]);

        $data = Reporter::report(User::query(), columns: ['name', 'email', 'password'])->getColumns();

        $this->assertContains('email', $data);

        $data = Reporter::report(User::query())->getColumns();

        $this->assertContains('email', $data);
    }
}

Class User extends BaseUser
{
    protected $guarded = [];
}
