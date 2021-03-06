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

        $data = Reporter::report(User::query(), columns: ['id', 'email'])->getHtml();

        $this->assertStringContainsString('mskhoshnazar', $data);
        $this->assertStringNotContainsString('Mo Khosh', $data);

        $data = Reporter::report(User::query(), columns: ['id', 'name', 'email'])->getHtml();

        $this->assertStringContainsString('mskhoshnazar', $data);
        $this->assertStringContainsString('Mo Khosh', $data);
    }

    /** @test */
    public function it_renders_title_and_meta_to_html()
    {
        $title = 'Title';
        $meta = ['Something' => 'Nothing'];

        $data = Reporter::report(User::query(), title: $title, meta: $meta)->getHtml();

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

    /** @test */
    public function it_renders_logo()
    {
        $html = Reporter::report(User::query(), logo: 'https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png')->getHtml();

        $this->assertStringContainsString('<img', $html);
        $this->assertStringContainsString('google.com/images', $html);
    }

    /** @test */
    public function it_passes_the_whole_model()
    {
        $user = User::create([
            'name' => 'Mo Khosh',
            'email' => 'mskhoshnazar@gmail.com',
            'password' => 'password',
        ]);

        $filter = [
            'email' => [
                'transform' => fn($email, $model) => $model->name,
            ],
        ];

        $columns = Reporter::report(User::query(), columns: $filter)->getColumns();

        $expected = [
            0 => (object) [
                "class" => "",
                "title" => "Mo Khosh",
            ],
        ];

        $actual = (new Row($user, $columns, isEven: false))->formattedRow();

        $this->assertEquals($expected, $actual);
    }

    /** @test */
    public function it_can_handle_madeup_columns()
    {
        $user = User::create([
            'name' => 'Mo Khosh',
            'email' => 'mskhoshnazar@gmail.com',
            'password' => 'password',
        ]);

        $filter = [
            'something' => [
                'transform' => fn($_, $model) => $model->name,
            ],
        ];

        $columns = Reporter::report(User::query(), columns: $filter)->getColumns();

        $expected = [
            0 => (object) [
                "class" => "",
                "title" => "Mo Khosh",
            ],
        ];

        $actual = (new Row($user, $columns, isEven: false))->formattedRow();

        $this->assertEquals($expected, $actual);
    }
}
