# Laravel Nationalize

[![Packagist](https://img.shields.io/packagist/v/faicchia/laravel-nationalize)](https://packagist.org/packages/faicchia/laravel-nationalize/)
[![Tests](https://github.com/faicchia/laravel-nationalize/actions/workflows/run-tests.yaml/badge.svg)](https://github.com/faicchia/laravel-nationalize/actions/workflows/run-tests.yaml)
[![Style](https://github.com/faicchia/laravel-nationalize/actions/workflows/php-cs-fixer.yaml/badge.svg)](https://github.com/faicchia/laravel-nationalize/actions/workflows/php-cs-fixer.yaml)
[![License](https://img.shields.io/badge/License-MIT-yellow.svg)](https://github.com/faicchia/laravel-nationalize/blob/main/LICENSE.md)

A service wrapper around [nationalize.io](https://nationalize.io/)

## Installation

```bash
composer require faicchia/laravel-nationalize
```

The package will automatically register itself.

### Configuration

If you wish to edit the package configuration, you can run the following command to publish it into your `config/` folder:

```bash
php artisan vendor:publish --provider="Faicchia\Nationalize\NationalizeServiceProvider"
```

### Environment

If you purchased an API Key, add the following line to your `.env` file

```bash
NATIONALIZE_API_KEY=...
```

## Usage
### Single name

```php
$response = Nationalize::name('Michael')->get()

print $response->status // 200 - HTTP response code

print $response->limit // 1000 - The amount of names available in the current time window

print $response->remaining // 728 - The number of names left in the current time window

print $response->reset // 15281 - Seconds remaining until a new time window opens

print $response->error // null - Error string

print $response->result->name // Michael

print $response->result->countries 
//  [
//    "US" => 0.08986482266532715,
//    "AU" => 0.05976757527083082,
//    "NZ" => 0.04666974820852911
//  ]
```

### Multiple names
```php
$response = Nationalize::name(['Michael', 'Kevin'])->get()
// or
$response = Nationalize::names(['Michael', 'Kevin'])->get()

foreach ($response->result as $prediction) {
    print $prediction->name
    print $prediction->countries 
}
```

### Error
```php
// e.g. Invalid API Key
$response = Nationalize::name('Michael')->get()

print $response->status // 401 
print $response->error // "Invalid API key"
```