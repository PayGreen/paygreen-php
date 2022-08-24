<?php

namespace Paygreen\Sdk\Payment\V3\Enum;

class EventEnum
{
    const PAYMENT_ORDER_PENDING = 'payment_order.pending';
    const PAYMENT_ORDER_AUTHORIZED = 'payment_order.authorized';
    const PAYMENT_ORDER_SUCCESSED = 'payment_order.successed';
    const PAYMENT_ORDER_EXPIRED = 'payment_order.expired';
    const PAYMENT_ORDER_CANCELED = 'payment_order.canceled';
    const PAYMENT_ORDER_REFUSED = 'payment_order.refused';
    const PAYMENT_ORDER_ERROR = 'payment_order.error';
    const PAYMENT_ORDER_REFUNDED = 'payment_order.refunded';

    const TRANSACTION_PENDING = 'transaction.pending';
    const TRANSACTION_EXPIRED = 'transaction.expired';
    const TRANSACTION_CANCELED = 'transaction.canceled';
    const TRANSACTION_AUTHORIZED = 'transaction.authorized';
    const TRANSACTION_PARTLY_CAPTURED = 'transaction.partly_captured';
    const TRANSACTION_CAPTURED = 'transaction.captured';
    const TRANSACTION_SUCCESSED = 'transaction.successed';
    const TRANSACTION_ERROR = 'transaction.error';
    const TRANSACTION_REFUSED = 'transaction.refused';
    const TRANSACTION_REFUNDED = 'transaction.refunded';
    const TRANSACTION_PARTLY_REFUNDED = 'transaction.partly_refunded';


    /**
     * @return array<string>
     */
    public static function getEvents()
    {
        return [
            self::PAYMENT_ORDER_PENDING,
            self::PAYMENT_ORDER_AUTHORIZED,
            self::PAYMENT_ORDER_SUCCESSED,
            self::PAYMENT_ORDER_EXPIRED,
            self::PAYMENT_ORDER_CANCELED,
            self::PAYMENT_ORDER_REFUSED,
            self::PAYMENT_ORDER_ERROR,
            self::PAYMENT_ORDER_REFUNDED,
            self::TRANSACTION_PENDING,
            self::TRANSACTION_EXPIRED,
            self::TRANSACTION_CANCELED,
            self::TRANSACTION_AUTHORIZED,
            self::TRANSACTION_PARTLY_CAPTURED,
            self::TRANSACTION_CAPTURED,
            self::TRANSACTION_SUCCESSED,
            self::TRANSACTION_ERROR,
            self::TRANSACTION_REFUSED,
            self::TRANSACTION_REFUNDED,
            self::TRANSACTION_PARTLY_REFUNDED
        ];
    }
}
