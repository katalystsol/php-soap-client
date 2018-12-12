<?php

namespace Katalystsol\PhpSoapClient\Test\Consumers\Methods;

use Katalystsol\PhpSoapClient\ConsumerMethod;

/**
 * Class GetBookingPolicies
 *
 * This is an example method for testing the ConsumerMethod class
 *
 * @package Katalystsol\PhpSoapClient\Test\Methods
 */
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
