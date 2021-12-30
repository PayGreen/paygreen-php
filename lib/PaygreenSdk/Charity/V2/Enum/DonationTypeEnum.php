<?php

namespace Paygreen\Sdk\Charity\V2\Enum;

class DonationTypeEnum
{
    const ROUNDING = 'ROUNDING';
    const CCARBON = 'CCARBON';
    const MECENAT = 'MECENAT';

    /**
     * @return array<string>
     */
    public static function getDonationsTypes()
    {
        return [
            self::ROUNDING,
            self::CCARBON,
            self::MECENAT,
        ];
    }
}