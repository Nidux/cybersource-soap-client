<?php

namespace Cybersource\SOAP;


/**
 * NVPClient
 *
 * An implementation of SOAPClient class for making CyberSource name-value pair
 * requests.
 */
class CybersourceNVPClient extends CyberSourceClient
{

    function __construct($options, $propertiesOrFilePath)
    {
        if(!is_array($propertiesOrFilePath))
        {
            if(is_file($propertiesOrFilePath))
            {
                $properties = parse_ini_file($propertiesOrFilePath);
            }
            else{
                throw new \Exception('You must provide either an array with the required information or an accesible filepath .ini file');
            }

        }
        else
        {
            $properties = $propertiesOrFilePath;
        }

        parent::__construct($options, $properties, true);
    }

    /**
     * Runs a transaction from a name-value pair array
     *
     * @param string $request An array of name-value pairs
     * @return string Response of name-value pairs delimited by a new line
     * @throws \Exception
     */
    public function runTransaction($request)
    {
        if (!is_array($request)) {
            throw new \Exception('Name-value pairs must be in array');
        }
        if (!array_key_exists('merchantID', $request)) {
            $request['merchantID'] = $this->getMerchantId();
        }
        $nvpRequest = "";
        foreach($request as $k => $v) {
            $nvpRequest .= ($k . "=" . $v ."\n");
        }
        return parent::runTransaction($nvpRequest);
    }
}
