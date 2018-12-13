<?php
/**
 * @author  donaldcranford
 * @created 12/12/18 3:08 PM
 */

namespace Katalystsol\PhpSoapClient\Test;

use Katalystsol\PhpSoapClient\Test\ComplexTypes\ClsCreditCard;

class ClsCreditCardTest extends TestCase
{
    /** @test */
    public function it_initializes_values_and_returns_array()
    {
        $values = [
            'strCCNumber' => '4111111111111111',
            'strToken' => 'lasfpoilkjlkwerjiofdsiojw9834sjlkw9',
            'strCCType' => 'VISA',
            'intExpMonth' => '01',
            'intExpYear' => '2020',
            'strName' => 'John Smith',
            'objBillingAddress' => null,
            'strEmail' => 'john.smith@example.com',
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

        $clsCreditCard = new ClsCreditCard($values);
        $clsCreditCardArray = $clsCreditCard->toArray();

        $this->assertTrue(is_array($clsCreditCardArray));
        $this->assertTrue(is_array($clsCreditCardArray['objBillingAddress']));
        $this->assertEquals('4111111111111111', $clsCreditCardArray['strCCNumber']);
        $this->assertEquals('123 Anystreet', $clsCreditCardArray['objBillingAddress']['strAddress1']);
        $this->assertEquals('TX', $clsCreditCardArray['objBillingAddress']['strState']);
    }
}
