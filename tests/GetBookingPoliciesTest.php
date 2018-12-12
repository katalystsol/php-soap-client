<?php

namespace Katalystsol\PhpSoapClient\Test;

use Katalystsol\PhpSoapClient\Test\Consumers\ExampleConsumer as Consumer;
use Katalystsol\PhpSoapClient\SoapClientLogger;
use Mockery;

/**
 * Class GetBookingPoliciesTest
 *
 * Tests an example method
 *
 * @package Katalystsol\PhpSoapClient\Test
 */
class GetBookingPoliciesTest extends TestCase
{
    /** @test */
    public function it_gets_booking_policies()
    {
        $wdsl = 'https://secure.instantsoftwareonline.com/StayUSA/ChannelPartners/wsWeblinkPlusAPI.asmx?WSDL';
        $soapClientOptions = [
            'trace' => true,
        ];
        $soapClientLogger = new SoapClientLogger(new \SoapClient($wdsl, $soapClientOptions));

        $client = Mockery::mock($soapClientLogger)
            ->shouldReceive('getBookingPolicies')
            ->once()
            ->andReturn(simplexml_load_string($this->getXml()))
            ->getMock();

        $params = [
            'strUserId' => 'testUserId',
            'strPassword' => 'testPassword',
            'strCOID' => '1234',
        ];

        $response = (new Consumer($client))->getBookingPolicies($params);

        $this->assertEquals('string', $response->strCancellationPolicy);
        $this->assertContains('cancel free of charge', $response->strRentalAgreement);
        $this->assertContains('cancel free of charge', $response->strReservationContract);
    }

    protected function getXml()
    {
        return <<<XML
<getBookingPoliciesResponse xmlns="http://www.instantsoftware.com/SecureWeblinkPlusAPI">
    <getBookingPoliciesResult>
        <strCancellationPolicy>string</strCancellationPolicy>
        <strRentalAgreement>VacationPros has a very fair and flexible Guest Contract. All guests can cancel free of charge within 72 hours - so you can first review our Guest Contract. Thank you and we look forward to your stay. VacationPros</strRentalAgreement>
        <strReservationContract>VacationPros has a very fair and flexible Guest Contract. All guests can cancel free of charge within 72 hours - so you can first review our Guest Contract. Thank you and we look forward to your stay. VacationPros</strReservationContract>
    </getBookingPoliciesResult>
</getBookingPoliciesResponse>
XML;
    }
}
