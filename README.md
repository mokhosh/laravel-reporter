# Create Pdf and Excel reports in Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mokhosh/laravel-reporter.svg?style=flat-square)](https://packagist.org/packages/mokhosh/laravel-reporter)
[![Build Status](https://img.shields.io/travis/mokhosh/laravel-reporter/master.svg?style=flat-square)](https://travis-ci.org/mokhosh/laravel-reporter)
[![Quality Score](https://img.shields.io/scrutinizer/g/mokhosh/laravel-reporter.svg?style=flat-square)](https://scrutinizer-ci.com/g/mokhosh/laravel-reporter)
[![Total Downloads](https://img.shields.io/packagist/dt/mokhosh/laravel-reporter.svg?style=flat-square)](https://packagist.org/packages/mokhosh/laravel-reporter)

This is basically going to be a wrapper for an Excel generator and a Pdf generator. For the time being these generators are Maatweb and Barry's snappy, that might change in the future.

There is already a package that does this, but I didn't like the API, the coding style and the overall design, with all due respect of course.

## Installation

You can install the package via composer. Make sure to run the Artisan install command to install npm dependencies.

```bash
composer require mokhosh/laravel-reporter
php artisan reporter:install
```

## Usage

``` php
// This is the simplest form of using it.
// This will report all non-hidden columns
// with Title Case column names:
$users = User::query();
Reporter::report($users)->pdf(); // view in browser, aka inline
Reporter::report($users)->download()->pdf(); // download, aka attachment

// You can filter the columns like this
$filter = [
    'id',
    'name',
    'email',
    'created_at',
];
Reporter::report($users, $filter)->pdf();

// Or even transform the data and add Tailwindcss classes
$filter = [
    'id' => 'ID',
    'name',
    'email' => [
        'transform' => fn($email) => strtoupper($email),
        'class' => 'text-green-700 bg-green-100',
    ],
    'created_at' => fn($date) => $date->format('Y-m'),
];
Reporter::report($users, $filter)->pdf();

// You can also change the Title of the generated pdf and add metadata
$title = 'Users Report';
$meta = [
    'Admin' => 'Mo Khosh',
];

Reporter::report($query, $columns, $title, $meta)->pdf();

// Hopefully we'll add excel exports as well
Reporter::report($users)->excel();

// I'm thinking of adding header classes
$filter = [
    'id' => 'ID',
    'email' => [
        'class' => 'text-green-700 bg-green-100',
        'header-class' => 'text-green-100 bg-green-700',
    ],
];

// I'm also thinking of conditional classes that are added to
// a cell when its content meets a condition passed through
// a closure that returns a boolean
$filter = [
    'created_at' => [
        'conditional-classes' => [
            [
                'class' => 'text-red-600',
                'condition' => fn($date) => $date->gt(now->subWeek()),
            ],
            [
                'class' => 'text-green-600',
                'condition' => fn($date) => $date->lt(now->subYear()),
            ],
        ],
    ],
];

// Another thing I have to think of a good API for is passing
// default styles for header, and even/odd rows
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Mo Khosh](https://github.com/mokhosh)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
