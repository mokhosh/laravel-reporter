<?php


namespace Mokhosh\Reporter\Tests;


use Mokhosh\Reporter\Reporter;

class ReporterTest extends BaseTest
{
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
    public function it_generates_filename_based_on_meta()
    {
        $title = 'User Report';
        $meta = ['Admin' => 'Nothing'];

        $reporter = Reporter::report(User::query(), title: $title, meta: $meta);

        $this->assertEquals('user-report-admin-nothing', $reporter->getFileName());
    }

    // todo orientation
    // todo limit and group
    // todo show total
    // todo paper size
    // todo simple version
    // todo header and footer
    // todo manual number column?
}
