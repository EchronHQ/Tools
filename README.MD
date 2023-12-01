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

## Run PHPStan

```bash
docker run -it -v .:/app -w /app --rm attlaz/php:8.1 composer run-script phpstan
```
