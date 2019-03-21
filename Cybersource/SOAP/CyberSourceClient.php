<?php

namespace Cybersource\SOAP;

use SoapClient;
use SoapHeader;
use SoapVar;

/**
 * CyberSourceClient
 *
 * An implementation of PHP's SOAPClient class for making either name-value pair
 * or XML CyberSource requests.
 *
 * @method static mixed runTransaction(string $nvpRequest)
 */
abstract class CyberSourceClient extends SoapClient
{
    const CLIENT_LIBRARY_VERSION = "Nidux CyberSource SOAP CLient 1.0.0";

    private $merchantId;
    private $transactionKey;

    /**
     * CyberSourceClient constructor.
     * @param array $options
     * @param array $properties
     * @param bool $nvp
     * @throws \Exception
     */
    function __construct($options = [], $properties = [], $nvp = false)
    {
        $this->validateProperties($properties);
        $wsdl = ($nvp === true) ? $properties['nvp_wsdl'] : $properties['wsdl'];

        parent::__construct($wsdl, $options);
        $this->merchantId = $properties['merchant_id'];
        $this->transactionKey = $properties['transaction_key'];

        $nameSpace = "http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd";

        $soapUsername = new SoapVar(
            $this->merchantId,
            XSD_STRING,
            NULL,
            $nameSpace,
            NULL,
            $nameSpace
        );

        $soapPassword = new SoapVar(
            $this->transactionKey,
            XSD_STRING,
            NULL,
            $nameSpace,
            NULL,
            $nameSpace
        );

        $auth = new \stdClass();
        $auth->Username = $soapUsername;
        $auth->Password = $soapPassword; 

        $soapAuth = new SoapVar(
            $auth,
            SOAP_ENC_OBJECT,
            NULL, $nameSpace,
            'UsernameToken',
            $nameSpace
        ); 

        $token = new \stdClass();
        $token->UsernameToken = $soapAuth; 

        $soapToken = new SoapVar(
            $token,
            SOAP_ENC_OBJECT,
            NULL,
            $nameSpace,
            'UsernameToken',
            $nameSpace
        );

        $security =new SoapVar(
            $soapToken,
            SOAP_ENC_OBJECT,
            NULL,
            $nameSpace,
            'Security',
            $nameSpace
        );

        $header = new SoapHeader($nameSpace, 'Security', $security, true); 
        $this->__setSoapHeaders(array($header)); 
    }


    /**
     * @param array $properties
     * @throws \Exception
     */
    private function validateProperties($properties = [])
    {
        $expectedKeys = ['merchant_id', 'transaction_key', 'nvp_wsdl', 'wsdl'];
        foreach ($expectedKeys as $keyToCheck)
        {
            if(!isset($properties[$keyToCheck]) || empty($properties[$keyToCheck]))
            {
                throw new \Exception($keyToCheck.' is missing. Please define this value on you ini file or make sure you are sending this on your constructor');
            }
        }
    }

    /**
     * @return string The client's merchant ID.
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @return string The client's transaction key.
     */
    public function getTransactionKey()
    {
        return $this->transactionKey;
    }
}