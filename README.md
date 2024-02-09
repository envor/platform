# Platform

[![Latest Version on Packagist](https://img.shields.io/packagist/v/envor/platform.svg?style=flat-square)](https://packagist.org/packages/envor/platform)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/envor/platform/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/envor/platform/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/envor/platform/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/envor/platform/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/envor/platform.svg?style=flat-square)](https://packagist.org/packages/envor/platform)

Configure your platform

## Installation

You can install the package via composer:

```bash
composer require envor/platform
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="platform-config"
```

This is the contents of the published config file:

```php
return [
    'platform_database_connection' => env('PLATFORM_DATABASE_CONNECTION', 'platform_sqlite'),
];
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [inmanturbo](https://github.com/envor)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
