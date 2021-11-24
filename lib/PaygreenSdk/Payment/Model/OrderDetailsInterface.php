<?php

namespace Paygreen\Sdk\Payment\Model;

interface OrderDetailsInterface
{
    /**
     * @return int
     */
    public function getCycle();

    /**
     * @param int $cycle
     */
    public function setCycle($cycle);

    /**
     * @return int
     */
    public function getCount();

    /**
     * @param int $count
     */
    public function setCount($count);

    /**
     * @return int
     */
    public function getDay();

    /**
     * @param int $day
     */
    public function setDay($day);

    /**
     * @return int
     */
    public function getStartAt();

    /**
     * @param int $startAt
     */
    public function setStartAt($startAt);

    /**
     * @return int
     */
    public function getFirstAmount();

    /**
     * @param int $firstAmount
     */
    public function setFirstAmount($firstAmount);
}
