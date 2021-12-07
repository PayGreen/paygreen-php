<?php

namespace Paygreen\Sdk\Payment\V2\Enum;

class PaymentTypeEnum
{
    const CB = 'CB';
    const AMEX = 'AMEX';
    const ANCV = 'ANCV';
    const ECV = 'ECV';
    const RESTOFLASH = 'RESTOFLASH';
    const SWILE = 'SWILE';
    const CBTRD = 'CBTRD';
    const TRD = 'TRD';
    const SEPA = 'SEPA';

    /**
     * @return array<string>
     */
    public static function getPaymentTypes()
    {
        return [
            self::CB,
            self::AMEX,
            self::ANCV,
            self::ECV,
            self::RESTOFLASH,
            self::SWILE,
            self::CBTRD,
            self::TRD,
            self::SEPA,
        ];
    }
}