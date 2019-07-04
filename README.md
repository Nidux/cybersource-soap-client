# Nidux SOAP Client for Cybersource SOAP
This is an Unofficial SOAP client for the [CyberSource SOAP Toolkit API](http://www.cybersource.com/developers/getting_started/integration_methods/soap_toolkit_api) but with some adjustments made by Nidux.

## Packagist
The nidux/cybersource-soap-client is available at [Packagist](https://packagist.org/packages/cybersource/sdk-php).
If you want to install SDK from Packagist,add the following dependency to your application's 'composer.json'.
```json
"require": {
  "nidux/cybersource-soap-client": "*"
  }, 
```
## Prerequisites

- PHP 7.0 or above
   - [curl](http://php.net/manual/en/book.curl.php), 
   - [openssl](http://php.net/manual/en/book.openssl.php), 
   - [soap](http://php.net/manual/en/book.soap.php) 
   - [simplexml](http://php.net/manual/en/book.simplexml.php) 
   - These extensions must be enabled
- A CyberSource account. You can create an evaluation account [here](http://www.cybersource.com/register/).
- A CyberSource transaction key.

## Installation
You can install the client either via [Composer](https://getcomposer.org/) or manually. 
You can provide either a the location of a file with the merchant ID, transaction key, and the appropriate WSDL file URL in ````cybs.ini```` (the latest when this package was updated). Here are the latest WSDL available, you can use SOAPUI if you want to manually test it:

- [test](https://ics2wstesta.ic3.com/commerce/1.x/transactionProcessor/CyberSourceTransaction_1.153.wsdl)
- [live](https://ics2ws.ic3.com/commerce/1.x/transactionProcessor/CyberSourceTransaction_1.153.wsdl)

### Installing with Composer
You'll first need to make sure you have Composer installed. You can follow the instructions on the [official web site](https://getcomposer.org/download/). Once Composer is installed, you can enter the project root and run:
```
composer.phar install
```
Then, to use the client, you'll need to include the Composer-generated autoload file:

```php
require_once('/path/to/project/vendor/autoload.php');
```


## Getting Started
The PHP client will generate the request message headers for you, and will contain the methods specified by the WSDL file.

### Creating a simple request
The main method you'll use is ````runTransaction()````. To run a transaction, you'll first need to construct a client to generate a request object, which you can populate with the necessary fields (see [documentation](http://www.cybersource.com/developers/integration_methods/simple_order_and_soap_toolkit_api/soap_api/html/wwhelp/wwhimpl/js/html/wwhelp.htm#href=Intro.04.4.html) for sample requests). The object will be converted into XML, so the properties of the object will need to correspond to the correct XML format.

```php
$client = new CybersourceSoapClient();
$request = $client->createRequest();

$card = new stdClass();
$card->accountNumber = '4111111111111111';
$card->expirationMonth = '12';
$card->expirationYear = '2020';
$request->card = $card;

// Populate $request here with other necessary properties

$reply = $client->runTransaction($request);
```

### Creating a request from XML
You can create a request from XML either in a file or from an XML string. The XML request format is described in the **Using XML** section [here](http://apps.cybersource.com/library/documentation/dev_guides/Simple_Order_API_Clients/Client_SDK_SO_API.pdf). Here's how to run a transaction from an XML file:

```php
$referenceCode = 'your_merchant_reference_code';
$client = new CybersourceSoapClient();
$reply = $client->runTransactionFromFile('path/to/my.xml', $referenceCode);
```

Or, you can create your own XML string and use that instead:

```php
$xml = "";
// Populate $xml
$client = new CybersourceSoapClient();
$client->runTransactionFromXml($xml);
```

### Using name-value pairs
In order to run transactions using name-value pairs, make sure to set the value for the WSDL for the NVP transaction processor in ````cybs.ini````. Then use the ````CybsNameValuePairClient```` as so:

```php
$client = new CybersourceNVPClient();
$request = array();
$request['ccAuthService_run'] = 'true';
$request['merchantID'] = 'my_merchant_id';
$request['merchantReferenceCode'] = $'my_reference_code';
// Populate $request
$reply = $client->runTransaction($request);
```

### How to obtain the CardType
A helper class is available with the method  ````getCardType($cardNumber)````. You need to provide card number and you will obtain the right CardType value to use in the XML/Object, it will return Null when cannot detect the brand of the card.


```php
$cardTypeValue = CybersourceHelper::getCardType('4111111111111111'); //it will return 001 
```