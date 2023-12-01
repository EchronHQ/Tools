# Echron PHP Tool library

[![Unit Tests](https://github.com/EchronHQ/Tools/actions/workflows/php.yml/badge.svg)](https://github.com/EchronHQ/Tools/actions/workflows/php.yml)
[![Latest Stable Version](https://img.shields.io/packagist/v/echron/tools.svg)](https://packagist.org/packages/echron/tools)

## About

[Echron](https://echron.com) PHP Tool library offers a set of handy classes and methods to simplify PHP development.

## Installation

Install the latest version with

```bash
composer require echron/tools
```

## Usage

### Output seconds as human-readable string

```php
echo \Echron\Tools\Time::readableSeconds(60 * 24);
>> 24 minutes
echo \Echron\Tools\Time::readableSeconds(60 + 3.4221580028534);
>> 1 minute, 3.42 seconds
echo \Echron\Tools\Time::readableSeconds(3.455669555);
>> 3.46 seconds
```

### Check if array has duplicates

```php
$a = ArrayHelper::hasDuplicates(['red', 'green', 'purple']);
print_r($a)
>> false

$b = ArrayHelper::hasDuplicates(['red', 'green', 'purple','red]);
print_r($b)
>> true
```

### Filter array by unique values

```php
$a = ArrayHelper::unique(['red', 'green', 'purple'],['orange','red']);
print_r($a)
>> ['red','green','purple','orange']
```
