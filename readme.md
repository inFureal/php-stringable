# PHP Stringable class

![Packagist License](https://img.shields.io/packagist/l/infureal/php-stringable?style=flat)
![Packagist Version](https://img.shields.io/packagist/v/infureal/php-stringable)
![Packagist Downloads](https://img.shields.io/packagist/dt/infureal/php-stringable)
![Packagist PHP Version Support](https://img.shields.io/packagist/php-v/infureal/php-stringable)
![GitHub code size in bytes](https://img.shields.io/github/languages/code-size/infureal/php-stringable)

This package is inspired by [laravel/laravel](https://github.com/laravel/laravel) facade `Str` 

## Install

`composer require infureal/php-stringable`

## How to use
```php

$str = \Infureal\Str::of('HELLO')
    ->lower();

echo $str; // hello
echo $str->upperFirst(); // Hello

```
