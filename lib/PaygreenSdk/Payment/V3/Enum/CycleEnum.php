<?php

namespace Paygreen\Sdk\Payment\V3\Enum;

class CycleEnum
{
    const NONE = 'none';
    const DAILY = 'daily';
    const WEEKLY = 'weekly';
    const MONTHLY = 'monthly';

    /**
     * @return array<string>
     */
    public static function getCycles()
    {
        return [
            self::NONE,
            self::DAILY,
            self::WEEKLY,
            self::MONTHLY
        ];
    }
}
