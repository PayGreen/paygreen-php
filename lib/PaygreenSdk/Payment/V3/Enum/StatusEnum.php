<?php

namespace Paygreen\Sdk\Payment\V3\Enum;

class StatusEnum
{
    const PENDING = 'pending';
    const AUTHORIZED = 'authorized';
    const SUCCESSED = 'successed';
    const ONGOING = 'ongoing';
    const INTERRUPTED = 'interrupted';
    const EXPIRED = 'expired';
    const COMPLETED = 'completed';
    const CANCELED = 'canceled';
    const REFUSED = 'refused';
    const ERROR = 'error';
    const REFUNDED = 'refunded';
}