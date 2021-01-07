<?php


namespace Mokhosh\Reporter\Tests;


use Mokhosh\Reporter\Reporter;
use Mokhosh\Reporter\View\Components\Row;

class HtmlTest extends BaseTest
{
    /** @test */
    public function it_renders_data_to_html()
    {
        User::create([
            'name' => 'Mo Khosh',
            'email' => 'mskhoshnazar@gmail.com',
            'password' => 'password',
        ]);

        $data = Reporter::report(User::query(), columns: ['id', 'email'])->getHtml()->render();

        $this->assertStringContainsString('mskhoshnazar', $data);
        $this->assertStringNotContainsString('Mo Khosh', $data);

        $data = Reporter::report(User::query(), columns: ['id', 'name', 'email'])->getHtml()->render();

        $this->assertStringContainsString('mskhoshnazar', $data);
        $this->assertStringContainsString('Mo Khosh', $data);
    }

    /** @test */
    public function it_renders_title_and_meta_to_html()
    {
        $title = 'Title';
        $meta = ['Something' => 'Nothing'];

        $data = Reporter::report(User::query(), title: $title, meta: $meta)->getHtml()->render();

        $this->assertStringContainsString($title, $data);
        $this->assertStringContainsString(reset($meta), $data);
    }

    /** @test */
    public function it_formats_rows_correctly()
    {
        $user = User::create([
            'name' => 'Mo Khosh',
            'email' => 'mskhoshnazar@gmail.com',
            'password' => 'password',
        ]);

        $filter = [
            'id',
            'name',
            'email' => [
                'transform' => fn($email) => strtoupper($email),
                'class' => 'text-green-700 bg-green-100',
                'title' => 'Email',
            ],
            'created_at' => fn($date) => $date->format('Y-m'),
        ];

        $columns = Reporter::report(User::query(), columns: $filter)->getColumns();

        $expected = [
            0 => (object) [
                "class" => "",
                "title" => 1,
            ],
            1 => (object) [
                "class" => "",
                "title" => "Mo Khosh",
            ],
            2 => (object) [
                "class" => "text-green-700 bg-green-100",
                "title" => "MSKHOSHNAZAR@GMAIL.COM",
            ],
            3 => (object) [
                "class" => "",
                "title" => now()->format('Y-m'),
            ],
        ];

        $actual = (new Row($user, $columns, isEven: false))->formattedRow();

        $this->assertEquals($expected, $actual);
    }

    // todo css and styles
}
