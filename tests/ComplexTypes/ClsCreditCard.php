<?php

namespace Katalystsol\PhpSoapClient\Test\ComplexTypes;

use Katalystsol\PhpSoapClient\ComplexType;

/**
 * Class ClsCreditCard
 *
 * This is an example method used for testing ComplexTypes
 *
 * @package Katalystsol\PhpSoapClient\Test\ComplexTypes
 */
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
