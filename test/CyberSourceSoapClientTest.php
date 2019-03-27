<?php

use PHPUnit\Framework\TestCase;

class CyberSourceSoapClientTest extends TestCase
{
    var $defaultProperties = [
        'merchant_id' => 'PUT MERCHANT ID HERE',
        'transaction_key' => 'PLACE YOUR TRANSACTION KEY HERE',
        'wsdl' => 'https://ics2wstest.ic3.com/commerce/1.x/transactionProcessor/CyberSourceTransaction_1.153.wsdl',
        'nvp_wsdl' => 'https://ics2wstest.ic3.com/commerce/1.x/transactionProcessor/CyberSourceTransaction_NVP_1.153.wsdl',
    ];

    private function generatePayment($properties, $auth = true, $captura = false, $customerName = 'normal')
    {
        $client = new \Cybersource\SOAP\CybersourceSoapClient([], $properties);
        $request = $client->createRequest('123456789');

        $ccAuthService = new stdClass();
        $ccAuthService->run = ($auth) ? 'true' : 'false';
        $request->ccAuthService = $ccAuthService;

        $ccCaptureService = new stdClass();
        $ccCaptureService->run = ($captura) ? 'true' : 'false';
        $request->ccCaptureService = $ccCaptureService;

        $billTo = new stdClass();
        $billTo->firstName = $customerName;
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


        return $client->runTransaction($request);
    }

    public function testBasicPaymentWithArray()
    {
        $returnData = $this->generatePayment($this->defaultProperties, true, false);
        $this->assertIsNumeric($returnData->requestID);
    }

    public function testBasicReverseWithArray()
    {
        $returnData = $this->generatePayment($this->defaultProperties, true, false, 'reverseMe');
        $this->assertIsNumeric($returnData->requestID);

        $client = new \Cybersource\SOAP\CybersourceSoapClient([], $this->defaultProperties);
        $request = $client->createRequest('123456789');

        $ccAuthReversalService = new stdClass();
        $ccAuthReversalService->run = 'true';
        $ccAuthReversalService->authRequestID = $returnData->requestID;
        $request->ccAuthReversalService = $ccAuthReversalService;


        $purchaseTotals = new stdClass();
        $purchaseTotals->currency = 'USD';
        $purchaseTotals->grandTotalAmount = '90.01';
        $request->purchaseTotals = $purchaseTotals;

        //$request->ics_applications = 'ics_ecp_debit';


        $result = $client->runTransaction($request);

        $this->assertEquals('100', $result->reasonCode);
    }

    public function testBasicCaptureWithArray()
    {
        $returnData = $this->generatePayment($this->defaultProperties, true, false, 'captureAfter');
        $this->assertIsNumeric($returnData->requestID);

        $client = new \Cybersource\SOAP\CybersourceSoapClient([], $this->defaultProperties);
        $request = $client->createRequest('123456789');

        $ccCaptureService = new stdClass();
        $ccCaptureService->run = 'true';
        $ccCaptureService->authRequestID = $returnData->requestID;
        $request->ccCaptureService = $ccCaptureService;


        $purchaseTotals = new stdClass();
        $purchaseTotals->currency = 'USD';
        $purchaseTotals->grandTotalAmount = '90.01';
        $request->purchaseTotals = $purchaseTotals;

        //$request->ics_applications = 'ics_ecp_debit';


        $result = $client->runTransaction($request);

        $this->assertEquals('100', $result->reasonCode);
    }
}
