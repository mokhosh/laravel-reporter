<?php

namespace Mokhosh\Reporter\Tests;

use Mokhosh\Reporter\Reporter;
use Mokhosh\Reporter\Services\PdfService;

class PdfTest extends BaseTest
{
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
