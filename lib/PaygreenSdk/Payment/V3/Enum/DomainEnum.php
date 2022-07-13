<?php

namespace Paygreen\Sdk\Payment\V3\Enum;

class DomainEnum
{
    const ECOMMERCE = 'ecommerce';
    const TRAVEL = 'travel';
    const FOOD = 'food';

    /**
     * @return array<array<string>>
     */
    public static function getDomains()
    {
        return [
            self::ECOMMERCE => self::getEcommercePlatforms(),
            self::TRAVEL => self::getTravelPlatforms(),
            self::FOOD => self::getFoodPlatforms(),
        ];
    }


    /**
     * @return array<string>
     */
    public static function getEcommercePlatforms()
    {
        return [
            PlatformEnum::AMEX,
            PlatformEnum::BANK_CARD,
            PlatformEnum::LCF,
            PlatformEnum::MCV
        ];
    }

    /**
     * @return array<string>
     */
    public static function getTravelPlatforms()
    {
        return [
            PlatformEnum::ANCV
        ];
    }

    /**
     * @return array<string>
     */
    public static function getFoodPlatforms()
    {
        return [
            PlatformEnum::CONECS,
            PlatformEnum::SWILE,
            PlatformEnum::WEDOOFOOD,
            PlatformEnum::RESTOFLASH
        ];
    }
}