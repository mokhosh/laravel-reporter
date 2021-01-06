<?php


namespace Mokhosh\Reporter\Tests;


use Mokhosh\Reporter\Reporter;

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

    // test that Row::formattedRow returns correct rows
    // todo css and styles
}
