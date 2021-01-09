# Create PDF and Excel reports in Laravel and style them with Tailwind CSS

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mokhosh/laravel-reporter.svg?style=flat-square)](https://packagist.org/packages/mokhosh/laravel-reporter)
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
This is the simplest way to get a PDF. This will report all non-hidden columns:

```php
use Mokhosh\Reporter\Reporter;

$users = User::query();

Reporter::report($users)->pdf(); // view in browser, aka inline
```
If you prefer to download the PDF file instead of showing it in the browser you can do this:
```php
Reporter::report($users)->download()->pdf(); // download, aka attachment
```
### Styles and Transforms
You can filter the columns like this
```php
$filter = [
    'id',
    'name',
    'email',
    'created_at',
];
Reporter::report($users, $filter)->pdf();
```
That will use a Title Case version of column names for your table headers. If you wish to use custom table headers you can do so like this:
```php
$filter = [
    'id' => 'ID',
    'email' => '@',
    'created_at' => 'Joined',
];
```
You can also transform the data by passing a closure:
```php
$filter = [
    'created_at' => fn($date) => $date->format('Y-m'),
];
```
You can add Tailwind CSS classes to your table cells if you want. Cool, right?
```php
$filter = [
    'id' => [
        'class' => 'font-bold text-gray-600 bg-gray-50'
    ],
];
```
You can also mix and match in a million ways:
```php
$filter = [
    'id' => 'ID',
    'name',
    'email' => [
        'transform' => fn($email) => strtoupper($email),
        'class' => 'text-green-700 bg-green-100',
    ],
    'created_at' => fn($date) => $date->format('Y-m'),
    'updated_at' => [
        'title' => 'Last Seen',
        'class' => 'text-red-400',
    ],
];
````
You can also change the Title of the generated pdf and add metadata and footer
```php
$title = 'Users Report';
$meta = [
    'Admin' => 'Mo Khosh',
];

Reporter::report($query, $columns, $title, $meta, footer: true)->pdf();
```
## TODO
- [ ] Hopefully we'll add excel exports as well
```php
Reporter::report($users)->excel();
```
- [ ] I'm thinking of adding header classes
```php
$filter = [
    'id' => 'ID',
    'email' => [
        'class' => 'text-green-700 bg-green-100',
        'header-class' => 'text-green-100 bg-green-700',
    ],
];
```
I'm also thinking of conditional classes that are added to a cell when its content meets a condition passed through a closure that returns a boolean value.
```php
$filter = [
    'created_at' => [
        'conditional-classes' => [
            [
                'class' => 'text-red-600',
                'condition' => fn($date) => $date->gt(now()->subWeek()),
            ],
            [
                'class' => 'text-green-600',
                'condition' => fn($date) => $date->lt(now()->subYear()),
            ],
        ],
    ],
];
```
- [ ] A good API for is passing default styles for the table header, and even/odd rows
- [ ] Add headers and footers with page number, date, etc.

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
