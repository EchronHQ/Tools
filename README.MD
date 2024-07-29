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
$a = \Echron\Tools\ArrayHelper::hasDuplicates(['red', 'green', 'purple']);
print_r($a);
>> false

$b = \Echron\Tools\ArrayHelper::hasDuplicates(['red', 'green', 'purple','red]);
print_r($b);
>> true
```

### Filter array by unique values

```php
$a = \Echron\Tools\ArrayHelper::unique(['red', 'green', 'purple'],['orange','red']);
print_r($a);
>> ['red','green','purple','orange']
```

### Limit a string without cutting of words

```php
$a = \Echron\Tools\StringHelper::limitWords('This is a basic string', 20);
print_r($a);
>> "This is a basic"
```

It is possible to pass along an end marker that will be added to the endof the string when the string is truncated.
The end marker is included in the maximum character string, the result will not be longer than the maximum characters
even when the end marker is added.

```php
$result = \Echron\Tools\StringHelper::limitWords('This is a basic string', 20, ' ...');
print_r($result);
>> "This is a basic ..."
```

### Limit a string

```php
$result = \Echron\Tools\StringHelper::limit('This is a basic string', 20);
print_r($result);
>> "This is a basic stri"
```

Add an end marker

```php
$result = \Echron\Tools\StringHelper::limit('This is a basic string', 20, ' ...');
print_r($result);
>> "This is a basic  ...', $result)"
```

### CSV

- Read out CSV file into an array

```php
$result = \Echron\Tools\CsvHelper::parseCSVFile('file.csv');
```

- Write a CSV file based on an array

```php
$result = \Echron\Tools\CsvHelper::toCSVFile(['field'=> 'value'], 'file.csv');
```
