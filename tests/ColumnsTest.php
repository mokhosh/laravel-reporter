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

        $this->assertArrayHasKey('email', $data);
        $this->assertArrayNotHasKey('password', $data);
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

        $expected = [
            'id' => 'Id',
            'name' => 'Name',
            'email' => 'Email',
            'created_at' => 'Created At',
        ];

        $actual = Reporter::report(User::query(), columns: $filter)->getColumns();

        $this->assertEquals($expected, $actual);
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

        $actual = Reporter::report(User::query(), columns: $filter)->getColumns();

        $this->assertEquals($filter, $actual);
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

        $expected = [
            'id' => 'Id',
            'name' => 'Name',
            'email' => [
                'title' => 'Email',
                'transform' => fn($email) => strtolower($email),
                'class' => 'text-green-700 bg-green-100',
            ],
            'created_at' => [
                'title' => 'Created At',
                'transform' => fn($date) => $date->format('Y-m'),
                'class' => '',
            ],
        ];

        $actual = Reporter::report(User::query(), columns: $filter)->getColumns();

        $this->assertEquals($expected, $actual);

        $filter = [
            'id' => 'ID',
            'name',
            'email' => ['title' => '@'],
            'created_at' => fn($date) => $date->format('Y-m'),
        ];

        $expected = [
            'id' => 'ID',
            'name' => 'Name',
            'email' => [
                'title' => '@',
                'transform' => fn($email) => $email,
                'class' => '',
            ],
            'created_at' => [
                'title' => 'Created At',
                'transform' => fn($date) => $date->format('Y-m'),
                'class' => '',
            ],
        ];

        $actual = Reporter::report(User::query(), columns: $filter)->getColumns();

        $this->assertEquals($expected, $actual);
    }
}
