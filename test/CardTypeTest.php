<?php

use Cybersource\Enums\CardTypeEnum;
use Cybersource\Helpers\CybersourceHelper;
use PHPUnit\Framework\TestCase;

class CardTypeTest extends TestCase
{

    public function testBasicVisaCard()
    {
        $result = CybersourceHelper::getCardType('4111111111111111');
        $this->assertTrue($result == CardTypeEnum::VISA, 'Method returned '.$result);
    }

    public function testBasicMasterCard()
    {
        $result = CybersourceHelper::getCardType('5500000000000004');
        $this->assertTrue($result == CardTypeEnum::MASTER_CARD, 'Method returned '.$result);
    }

    public function testBasicAMEXCard()
    {
        $result = CybersourceHelper::getCardType('340000000000009');
        $this->assertTrue($result == CardTypeEnum::AMERICAN_EXPRESS, 'Method returned '.$result);
    }

    public function testBasicDinersCard()
    {
        $result = CybersourceHelper::getCardType('30000000000004');
        $this->assertTrue($result == CardTypeEnum::DINERS_CLUB, 'Method returned '.$result);
    }

    public function testBasicDiscoverCard()
    {
        $result = CybersourceHelper::getCardType('6011000000000004');
        $this->assertTrue($result == CardTypeEnum::DISCOVER, 'Method returned '.$result);
    }

    public function testBasicJCBCard()
    {
        $result = CybersourceHelper::getCardType('3588358850584166');
        $this->assertTrue($result == CardTypeEnum::JCB, 'Method returned '.$result);
    }

    public function testBasicChinaUnionPayCard()
    {
        $result = CybersourceHelper::getCardType('6208311534256563');
        $this->assertTrue($result == CardTypeEnum::CHINA_UNIONPAY, 'Method returned '.$result);
    }

    public function testBasicChinaUnionPayCard2()
    {
        $result = CybersourceHelper::getCardType('62600094752489245');
        $this->assertTrue($result == CardTypeEnum::CHINA_UNIONPAY, 'Method returned '.$result);
    }


}
