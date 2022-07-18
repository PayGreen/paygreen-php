<?php

namespace Paygreen\Sdk\Payment\V3\Enum;

class PlatformEnum
{
    const BANK_CARD = 'bank_card';
    const AMEX = 'amex';
    const ANCV = 'ancv';
    const LCF = 'lcf';
    const WEDOOFOOD = 'wedoofood';
    const MCV = 'mcv';
    const SWILE = 'swile';
    const MONIZZE = 'monizze';
    const RESTOFLASH = 'restoflash';
    const CONECS = 'conecs';

    /**
     * @return array<string>
     */
    public static function getPlatforms()
    {
        return [
            self::BANK_CARD,
            self::AMEX,
            self::ANCV,
            self::LCF,
            self::WEDOOFOOD,
            self::MCV,
            self::SWILE,
            self::MONIZZE,
            self::RESTOFLASH,
            self::CONECS
        ];
    }
}