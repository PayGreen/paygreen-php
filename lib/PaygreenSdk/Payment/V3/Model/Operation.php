<?php

namespace Paygreen\Sdk\Payment\V3\Model;

class Operation
{
    /**
     * @var int|null
     */
    private $amount = null;

    /**
     * @return int|null
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int|null $amount
     * @return Operation
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }
}