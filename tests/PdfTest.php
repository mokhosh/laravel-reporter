<?php

namespace Mokhosh\Reporter\Tests;

use Barryvdh\Snappy\ServiceProvider;
use Illuminate\Foundation\Auth\User;
use Mokhosh\Reporter\Reporter;
use Mokhosh\Reporter\ReporterServiceProvider;
use Orchestra\Testbench\TestCase;

class PdfTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            ReporterServiceProvider::class,
            ServiceProvider::class,
        ];
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
