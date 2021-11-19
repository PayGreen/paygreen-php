<?php

namespace Paygreen\Sdk\Payment\Model;

class OrderDetails implements OrderDetailsInterface
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
     * @return void
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
     * @return void
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
     * @return void
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
     * @return void
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
     * @return void
     */
    public function setFirstAmount($firstAmount)
    {
        $this->firstAmount = $firstAmount;
    }
}