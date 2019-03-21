<?php

use PHPUnit\Framework\TestCase;

class CyberSourceSoapClientTest extends TestCase
{


    public function testBasicPaymentWithArray()
    {
        $properties = [
            //Place the values here
        ];

        $this->assertNotEquals(false, $properties);
        $client = new \Cybersource\SOAP\CybersourceSoapClient([], $properties);
        $request = $client->createRequest('123456789');

        $ccAuthService = new stdClass();
        $ccAuthService->run = 'true';
        $request->ccAuthService = $ccAuthService;

        $ccCaptureService = new stdClass();
        $ccCaptureService->run = 'true';
        $request->ccCaptureService = $ccCaptureService;

        $billTo = new stdClass();
        $billTo->firstName = 'John';
        $billTo->lastName = 'Doe';


        $billTo->street1 = 'N/A';
        $billTo->city = 'N/A';
        $billTo->state = 'N/A';
        $billTo->postalCode = 'N/A';

        $billTo->country = 'CR';

        $billTo->email = 'null@cybersource.com';

        $billTo->ipAddress = '10.7.111.111';
        $request->billTo = $billTo;

        $card = new stdClass();
        $card->accountNumber = '4111111111111111';
        $card->expirationMonth = '11';
        $card->expirationYear = '2020';
        $card->cvNumber = '123';
        $card->cardType = '001';
        $request->card = $card;

        $purchaseTotals = new stdClass();
        $purchaseTotals->currency = 'USD';
        $purchaseTotals->grandTotalAmount = '90.01';
        $request->purchaseTotals = $purchaseTotals;

        //$request->ics_applications = 'ics_ecp_debit';
        // Populate $request here with other necessary properties


        $reply = $client->runTransaction($request);
        print_r($reply);
    }
}
