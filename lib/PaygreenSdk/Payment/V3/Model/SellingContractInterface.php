<?php

namespace Paygreen\Sdk\Payment\V3\Model;

interface SellingContractInterface
{
    /**
     * @return string
     */
    public function getNumber();

    /**
     * @param string $number
     *
     * @return void
     */
    public function setNumber($number);

    /**
     * @return int
     */
    public function getMcc();

    /**
     * @param int $mcc
     *
     * @return void
     */
    public function setMcc($mcc);

    /**
     * @return int
     */
    public function getMaxAmount();

    /**
     * @param int $maxAmount
     *
     * @return void
     */
    public function setMaxAmount($maxAmount);

    /**
     * @return string
     */
    public function getType();

    /**
     * @param string $type
     *
     * @return void
     */
    public function setType($type);
}
