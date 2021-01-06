<?php

namespace Mokhosh\Reporter\Tests;

use Barryvdh\Snappy\ServiceProvider;
use Mokhosh\Reporter\Reporter;
use Mokhosh\Reporter\ReporterServiceProvider;
use Orchestra\Testbench\TestCase;

class PdfTest extends TestCase
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
    public function it_will_send_download_response_with_pdf()
    {
        User::create([
            'name' => 'Mo Khosh',
            'email' => 'mskhoshnazar@gmail.com',
            'password' => 'password',
        ]);

        $users = User::query();

        $response = Reporter::report($users)->pdf();

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertStringContainsString('attachment', (string) $response);
    }

    /** @test */
    public function it_will_show_pdf_with_stream()
    {
        User::create([
            'name' => 'Mo Khosh',
            'email' => 'mskhoshnazar@gmail.com',
            'password' => 'password',
        ]);

        $users = User::query();

        $response = Reporter::report($users)->stream()->pdf();

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertStringContainsString('inline', (string) $response);
        $this->assertStringContainsString('application/pdf', (string) $response);
    }
}
