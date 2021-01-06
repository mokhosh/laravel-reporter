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

        $this->assertContains('email', $data);
        $this->assertNotContains('name', $data);
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
    }

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
