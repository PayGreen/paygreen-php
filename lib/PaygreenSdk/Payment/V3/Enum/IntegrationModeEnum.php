<?php

namespace Paygreen\Sdk\Payment\V3\Enum;

class IntegrationModeEnum
{
    const HOSTED_FIELDS = 'hosted_fields';
    const INSITE = 'insite';
    const REDIRECT = 'redirect';
    const DIRECT = 'direct';

    /**
     * @return array<string>
     */
    public static function getIntegrationsModes()
    {
        return [
            self::HOSTED_FIELDS,
            self::INSITE,
            self::REDIRECT,
            self::DIRECT
        ];
    }
}
