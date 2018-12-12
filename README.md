# php-soap-client
A generic SOAP client

This was originally written as a SOAP Client in Laravel to access the HomeAway SOAP API. This is a work-in-progress to 
migrate that code to be a simple-to-use, generic SOAP client.

## Goals

* Create a simple approach to interacting with a SOAP API
* Create a Class for each API endpoint method that only requires minimal data parameters for required and optional parameters.
* Have ability to support complex types / objects.

This package is compliant with [PSR-1], [PSR-2] and [PSR-4]. If you notice compliance oversights,
please send a patch via pull request.

[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md

## Install

Via Composer
``` bash
$ composer require katalystsol/php-soap-client
```

## Requirements
The following versions of PHP are supported by this version.

* PHP 5.6
* PHP 7.0
* PHP 7.1
* PHP 7.2
* PHP 7.3

## Documentation

under development

## TODOs
- should I include psr/log middleware?
- write the tests


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
