<?php

namespace Katalystsol\PhpSoapClient\Test\ComplexTypes;

use Katalystsol\PhpSoapClient\ComplexType;

/**
 * Class ClsAddress
 *
 * This is an example method used for testing ComplexTypes
 *
 * @package Katalystsol\PhpSoapClient\Test\ComplexTypes
 */
class ClsAddress extends ComplexType
{
    protected function setPropertyKeys()
    {
        $this->propertyKeys = [
            'strAddress1',
            'strAddress2',
            'strCity',
            'strState',
            'strProvince',
            'strZip',
            'strCountry',
            'strHomePhone',
            'strWorkPhone',
        ];
    }

    protected function setComplexTypes()
    {
        $this->complexTypes = [];
    }

    protected function setComplexTypeClassName()
    {
        $this->complexTypeClassName = get_class();
    }
}
