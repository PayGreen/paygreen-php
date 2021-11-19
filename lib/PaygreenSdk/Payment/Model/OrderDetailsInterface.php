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
     * @return void
     */
    public function setCycle($cycle);

    /**
     * @return int
     */
    public function getCount();

    /**
     * @param int $count
     * @return void
     */
    public function setCount($count);

    /**
     * @return int
     */
    public function getDay();

    /**
     * @param int $day
     * @return void
     */
    public function setDay($day);

    /**
     * @return int
     */
    public function getStartAt();

    /**
     * @param int $startAt
     * @return void
     */
    public function setStartAt($startAt);

    /**
     * @return int
     */
    public function getFirstAmount();

    /**
     * @param int $firstAmount
     * @return void
     */
    public function setFirstAmount($firstAmount);
}