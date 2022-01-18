<?php

namespace Paygreen\Sdk\Climate\V2\Enum;

class FootprintStatusEnum
{
    const CLOSED = 'CLOSED';
    const CREATED = 'CREATED';
    const OFFSET_FROM_ANOTHER_VENDOR = 'OFFSET_FROM_ANOTHER_VENDOR';
    const ONGOING = 'ONGOING';
    const PURCHASED = 'PURCHASED';
    const USER_CONTRIBUTED = 'USER_CONTRIBUTED';

    /**
     * @return array
     */
    public static function getFootprintStatus()
    {
        return [
            self::CLOSED,
            self::CREATED,
            self::OFFSET_FROM_ANOTHER_VENDOR,
            self::ONGOING,
            self::PURCHASED,
            self::USER_CONTRIBUTED
        ];
    }
}
