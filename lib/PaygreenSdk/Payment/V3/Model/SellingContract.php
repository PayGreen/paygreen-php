<?php

namespace Paygreen\Sdk\Payment\V3\Model;

class SellingContract implements SellingContractInterface
{
    /**
     * The number, or identifier, of the selling contract you have with your bank - check with your bank for more information
     *
     * @var string
     */
    private $number;

    /**
     * Merchant Category Code (ISO-18245)
     *
     * @var int
     */
    private $mcc;

    /**
     * The maximum amount allowed by your selling contract
     *
     * @var int
     */
    private $maxAmount;

    /**
     * @var string
     */
    private $type;

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     *
     * @return void
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return int
     */
    public function getMcc()
    {
        return $this->mcc;
    }

    /**
     * @param int $mcc
     *
     * @return void
     */
    public function setMcc($mcc)
    {
        $this->mcc = $mcc;
    }

    /**
     * @return int
     */
    public function getMaxAmount()
    {
        return $this->maxAmount;
    }

    /**
     * @param int $maxAmount
     *
     * @return void
     */
    public function setMaxAmount($maxAmount)
    {
        $this->maxAmount = $maxAmount;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     *
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }
}
