<?php

namespace Paygreen\Sdk\Payment\V2\Model;

class MultiplePayment implements MultiplePaymentInterface
{
    /** @var int */
    private $cycle;

    /** @var int */
    private $count;

    /** @var int */
    private $day;

    /** @var int */
    private $startAt;

    /** @var int */
    private $firstAmount;

    /**
     * @return int
     */
    public function getCycle()
    {
        return $this->cycle;
    }

    /**
     * @param int $cycle
     */
    public function setCycle($cycle)
    {
        $this->cycle = $cycle;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param int $day
     */
    public function setDay($day)
    {
        $this->day = $day;
    }

    /**
     * @return int
     */
    public function getStartAt()
    {
        return $this->startAt;
    }

    /**
     * @param int $startAt
     */
    public function setStartAt($startAt)
    {
        $this->startAt = $startAt;
    }

    /**
     * @return int
     */
    public function getFirstAmount()
    {
        return $this->firstAmount;
    }

    /**
     * @param int $firstAmount
     */
    public function setFirstAmount($firstAmount)
    {
        $this->firstAmount = $firstAmount;
    }
}
