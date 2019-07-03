<?php


namespace Cybersource\Helpers;


use Cybersource\Enums\CardTypeEnum;

class CybersourceHelper
{

    public static function getCardType($cardNumber)
    {

        $cardRegexps = [
            CardTypeEnum::VISA => '/^4[0-9]{0,15}$/',
            CardTypeEnum::MASTER_CARD => '/^(5[1-5][0-9]{5,}|222[1-9][0-9]{3,}|22[3-9][0-9]{4,}|2[3-6][0-9]{5,}|27[01][0-9]{4,}|2720[0-9]{3,})$/',
            CardTypeEnum::AMERICAN_EXPRESS => '/^3$|^3[47][0-9]{0,13}$/',
            CardTypeEnum::DISCOVER => '/^6$|^6[05]$|^601[1]?$|^65[0-9][0-9]?$|^6(?:011|5[0-9]{2})[0-9]{0,12}$/',
            CardTypeEnum::DINERS_CLUB  => '/^3(?:0[0-5]|[68][0-9])[0-9]{4,}$/',
            CardTypeEnum::JCB => '/^(?:2131|1800|35[0-9]{3})[0-9]{3,}$/',
            CardTypeEnum::CHINA_UNIONPAY => '/^(62[0-9]{14,17})$/',
        ];

        foreach ($cardRegexps as $cardType => $regExpToValidate)
        {
            if(preg_match($regExpToValidate, $cardNumber))
            {
                return $cardType;
            }
        }

        return null;
    }
}