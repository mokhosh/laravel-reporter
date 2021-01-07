# Create Pdf and Excel reports in Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mokhosh/laravel-reporter.svg?style=flat-square)](https://packagist.org/packages/mokhosh/laravel-reporter)
[![Build Status](https://img.shields.io/travis/mokhosh/laravel-reporter/master.svg?style=flat-square)](https://travis-ci.org/mokhosh/laravel-reporter)
[![Quality Score](https://img.shields.io/scrutinizer/g/mokhosh/laravel-reporter.svg?style=flat-square)](https://scrutinizer-ci.com/g/mokhosh/laravel-reporter)
[![Total Downloads](https://img.shields.io/packagist/dt/mokhosh/laravel-reporter.svg?style=flat-square)](https://packagist.org/packages/mokhosh/laravel-reporter)

This is basically going to be a wrapper for an Excel generator and a Pdf generator. For the time being these generators are Maatweb and Barry's snappy, that might change in the future.

There is already a package that does this, but I didn't like the API, the coding style and the overall design, with all due respect of course.

## Installation

You can install the package via composer:

```bash
composer require mokhosh/laravel-reporter
```

## Usage

``` php
// This is the simplest form of using it.
// This will report all non-hidden columns
// with Title Case column names:
$users = User::query();
Reporter::report($users)->pdf(); // download
Reporter::report($users)->stream()->pdf(); // view in browser, aka stream

// Hopefully we'll add excel exports as well
Reporter::report($users)->excel();

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
