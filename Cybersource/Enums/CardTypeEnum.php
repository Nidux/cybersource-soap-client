<?php

namespace Cybersource\Enums;

use MyCLabs\Enum\Enum;

class CardTypeEnum extends Enum
{
    //So far I will set these 10 as the most active ones, others will be supported eventually
    const VISA                          = '001';
    const MASTER_CARD                   = '002';
    const AMERICAN_EXPRESS              = '003';
    const DISCOVER                      = '004';
    const DINERS_CLUB                   = '005';
    const JCB                           = '007';
    const CHINA_UNIONPAY                = '062';

    //Unsupported for now
    const CARTE_BLANCHE                 = '006';
    const ENROUTE                       = '014';
    const JAL                           = '021';
    const MAESTRO                       = '024';
    const DELTA                         = '031';
    const VISA_ELECTRON                 = '033';
    const DANKORT                       = '034';
    const CARTES_BANCAIRES              = '036';
    const CARTA_SI                      = '037';
    const ENCODED_ACCOUNT_NUMBER        = '039';
    const UATP                          = '040';
    const MAESTRO_INTERNATIONAL         = '042';
    const HIPERCARD                     = '050';
    const AURA                          = '051';
    const ELO                           = '054';
    const RUPAY                         = '061';
}