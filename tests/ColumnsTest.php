<?php


namespace Mokhosh\Reporter\Tests;


use Mokhosh\Reporter\Reporter;

class ColumnsTest extends BaseTest
{
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
    public function it_interprets_simple_columns_correctly()
    {
        $filter = [
            'id',
            'name',
            'email',
            'created_at',
        ];

        $this->markTestIncomplete();
    }

    /** @test */
    public function it_interprets_associative_columns_correctly()
    {
        $filter = [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'created_at' => 'Created',
        ];

        $this->markTestIncomplete();
    }

    /** @test */
    public function it_interprets_complex_columns_correctly()
    {
        $filter = [
            'id',
            'name',
            'email' => [
                'transform' => fn($email) => strtolower($email),
                'class' => 'text-green-700 bg-green-100',
            ],
            'created_at' => fn($date) => $date->format('Y-m'),
        ];

        $this->markTestIncomplete('just start by imagining your input columns argument, and test its outputs');
    }

    // test that works without passing columns
    // test that gives with numeric columns too
    // test that gives all columns correctly
}
