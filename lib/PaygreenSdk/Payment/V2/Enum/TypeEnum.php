<?php

namespace Paygreen\Sdk\Payment\V2\Enum;

class TypeEnum
{
    const CASH = 'CASH';
    const RECURRING = 'RECURRING';
    const XTIME = 'XTIME';
    const TOKENIZE = 'TOKENIZE';

    /**
     * @return array<string>
     */
    public static function getTypes()
    {
        return [
            self::CASH,
            self::RECURRING,
            self::XTIME,
            self::TOKENIZE,
        ];
    }
}