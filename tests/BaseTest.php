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
    public function it_has_title_and_meta()
    {
        $title = 'Title';
        $meta = ['Something' => 'Nothing'];

        $reporter = Reporter::report(User::query(), title: $title, meta: $meta);

        $this->assertEquals($title, $reporter->getTitle());
        $this->assertEquals($meta, $reporter->getMeta());
    }

    /** @test */
    public function it_contains_query_data_and_respects_hidden_attributes()
    {
        User::create([
            'name' => 'Mo Khosh',
            'email' => 'mskhoshnazar@gmail.com',
            'password' => 'password',
        ]);

        $data = Reporter::report(User::query())->getColumns();

        $this->assertContains('email', $data);
        $this->assertNotContains('password', $data);
    }

    /** @test */
    public function it_filters_query_data()
    {
        User::create([
            'name' => 'Mo Khosh',
            'email' => 'mskhoshnazar@gmail.com',
            'password' => 'password',
        ]);

        $data = Reporter::report(User::query(), columns: ['id', 'email'])->getColumns();

        $this->assertArrayHasKey('email', $data);
        $this->assertArrayNotHasKey('name', $data);
    }

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
    public function ir_renders_title_and_meta_to_html()
    {
        $title = 'Title';
        $meta = ['Something' => 'Nothing'];

        $data = Reporter::report(User::query(), title: $title, meta: $meta)->getHtml()->render();

        $this->assertStringContainsString($title, $data);
        $this->assertStringContainsString(reset($meta), $data);
    }

    // test that works without passing columns
    // test that gives with numeric columns too
    // test that gives all columns correctly
    // test that Row::formattedRow returns correct rows

    // todo css and styles
    // todo orientation
    // todo limit and group
    // todo show total
    // todo paper size
    // todo simple version
    // todo header and footer
    // todo manual number column?
}

Class User extends BaseUser
{
    protected $guarded = [];
    protected $hidden = ['password'];
}
