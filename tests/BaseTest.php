<?php

namespace Mokhosh\Reporter\Tests;

use Barryvdh\Snappy\ServiceProvider;
use Mokhosh\Reporter\ReporterServiceProvider;
use Illuminate\Foundation\Auth\User;
use Orchestra\Testbench\TestCase;
use Mokhosh\Reporter\Reporter;

class BaseTest extends TestCase
{

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
    public function it_will_send_download_response_with_pdf()
    {
        $users = User::query();

        $response = Reporter::report($users)->pdf();

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertStringContainsString('attachment', (string) $response);
    }

    /** @test */
    public function it_will_show_pdf_with_stream()
    {
        $users = User::query();

        $response = Reporter::report($users)->stream()->pdf();

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertStringContainsString('inline', (string) $response);
        $this->assertStringContainsString('application/pdf', (string) $response);
    }
}
