# php-soap-client
A generic SOAP client

This was originally written as a SOAP Client in Laravel to access the HomeAway SOAP API. This is a work-in-progress to 
migrate that code to be a simple-to-use, generic SOAP client.

## Goals

* Create a simple approach to interacting with a SOAP API
* Create a Class for each API endpoint method that only requires minimal data parameters for required and optional parameters.
* Have ability to support complex types / objects.
* Adhere as closely as possible to the Single Responsibility principle.
    - Each SOAP API endpoint/method will be its own Class, which configures the required, optional parameters and/or 
    complex types. It should only change if the SOAP API changes.

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

It requires the following PHP extensions:
* JSON
* SimpleXML
* SOAP

## Documentation

under development

### Example SOAP Method class

```php
use Katalystsol\PhpSoapClient\ConsumerMethod;

class GetBookingPolicies extends ConsumerMethod
{
    protected $requiredParameters = [
        'strUserId',
        'strPassword',
        'strCOID',
    ];

    protected $optionalParameters = [
        'strProperty',
    ];
}

```

### Example Complex Type

This would be a credit card class. It would also reference a separate complex type class "ClsAddress".

```php
use Katalystsol\PhpSoapClient\ComplexType;

class ClsCreditCard extends ComplexType
{
    protected function setPropertyKeys()
    {
        $this->propertyKeys = [
            'strToken',
            'strCCType',
            'intExpMonth',
            'intExpYear',
            'strName',
            'objBillingAddress',
            'strEmail',
        ];
    }

    protected function setComplexTypes()
    {
        $this->complexTypes = [
            'objBillingAddress' => ClsAddress::class,
        ];
    }

    protected function setComplexTypeClassName()
    {
        $this->complexTypeClassName = get_class();
    }
}
```

- See the tests for more examples.

## TODOs
- should I include psr/log middleware?
- finish writing the tests
- write the documentation


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
