<?php

namespace Katalystsol\PhpSoapClient\Test;

use Katalystsol\PhpSoapClient\Test\ComplexTypes\ClsAddress;

class ClsAddressTest extends TestCase
{
    /** @test */
    public function it_initializes_values_and_returns_array()
    {
        $values = [
            'strAddress1' => '123 Anystreet',
            'strAddress2' => 'Apt #100',
            'strCity' => 'Anytown',
            'strState' => 'TX',
            'strProvince' => '',
            'strZip' => '76111',
            'strCountry' => 'USA',
            'strHomePhone' => '817-555-1212',
            'strWorkPhone' => '214-555-1212',
        ];

        $clsAddress = new ClsAddress($values);
        $clsAddressArray = $clsAddress->toArray();

        $this->assertTrue(is_array($clsAddressArray));
        $this->assertEquals('123 Anystreet', $clsAddressArray['strAddress1']);
        $this->assertEquals('TX', $clsAddressArray['strState']);
    }
}
