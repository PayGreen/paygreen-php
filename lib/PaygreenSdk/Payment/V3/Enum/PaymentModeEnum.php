<?php

namespace Paygreen\Sdk\Payment\V3\Enum;

class PaymentModeEnum
{
    const INSTANT = 'instant';
    const SPLIT = 'split';
    const RECURRING = 'recurring';

    /**
     * @return array<string>
     */
    public static function getPaymentModes()
    {
        return [
            self::INSTANT,
            self::SPLIT,
            self::RECURRING
        ];
    }
}