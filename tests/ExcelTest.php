<?php


namespace Mokhosh\Reporter\Tests;


use Mokhosh\Reporter\Reporter;
use Illuminate\Support\Facades\View;
use Mokhosh\Reporter\Services\ExcelService;

class ExcelTest extends BaseTest
{
    /** @test */
    public function it_will_send_download_response_with_or_without_download()
    {
        User::create([
            'name' => 'Mo Khosh',
            'email' => 'mskhoshnazar@gmail.com',
            'password' => 'password',
        ]);

        $users = User::query();

        $response = Reporter::report($users)->download()->excel();

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertStringContainsString('attachment', (string) $response);

        $response = Reporter::report($users, download: true)->excel();

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertStringContainsString('attachment', (string) $response);

        $response = Reporter::report($users)->excel();

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertStringContainsString('attachment', (string) $response);

        $response = Reporter::report($users, download: false)->excel();

        $this->assertEquals($response->getStatusCode(), 200);
        $this->assertStringContainsString('attachment', (string) $response);
    }

    /** @test */
    public function it_will_name_files_with_correct_extension()
    {
        $service = new ExcelService(view: View::make('laravel-reporter::pdf'), filename: 'some-file-name');

        $this->assertEquals('some-file-name.xlsx', $service->getFilename());
    }
}