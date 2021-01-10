<?php

namespace Mokhosh\Reporter\Tests;

use Barryvdh\Snappy\ServiceProvider;
use Mokhosh\Reporter\Reporter;
use Mokhosh\Reporter\ReporterServiceProvider;
use Mokhosh\Reporter\Services\PdfService;
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
    public function it_will_send_download_response_with_download()
    {
        User::create([
            'name' => 'Mo Khosh',
            'email' => 'mskhoshnazar@gmail.com',
            'password' => 'password',
        ]);

        $users = User::query();

        $response = Reporter::report($users)->download()->pdf();

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertStringContainsString('attachment', (string) $response);

        $response = Reporter::report($users, download: true)->pdf();

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertStringContainsString('attachment', (string) $response);
    }

    /** @test */
    public function it_will_show_pdf_without_download()
    {
        User::create([
            'name' => 'Mo Khosh',
            'email' => 'mskhoshnazar@gmail.com',
            'password' => 'password',
        ]);

        $users = User::query();

        $response = Reporter::report($users)->pdf();

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertStringContainsString('inline', (string) $response);
        $this->assertStringContainsString('application/pdf', (string) $response);
    }

    /** @test */
    public function it_will_name_files_with_correct_extension()
    {
        $service = new PdfService(html: '<div></div>', filename: 'some-file-name');

        $this->assertEquals('some-file-name.pdf', $service->getFilename());
    }
}
