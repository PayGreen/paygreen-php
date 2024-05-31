<?php

namespace Paygreen\Sdk\Payment\V3\Model;

class SellingContract
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $shopId;

    /**
     * @var string
     */
    private $number;

    /**
     * @var int
     */
    private $mcc;

    /**
     * @var int
     */
    private $maxAmount;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string|null
     */
    private $iban;

    /**
     * @var string|null
     */
    private $bic;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getShopId()
    {
        return $this->shopId;
    }

    /**
     * @param string $shopId
     * @return self
     */
    public function setShopId($shopId)
    {
        $this->shopId = $shopId;

        return $this;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return self
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
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
     * @return self
     */
    public function setMcc($mcc)
    {
        $this->mcc = $mcc;

        return $this;
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
     * @return self
     */
    public function setMaxAmount($maxAmount)
    {
        $this->maxAmount = $maxAmount;

        return $this;
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
     * @return self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * @param string $iban
     * @return self
     */
    public function setIban($iban)
    {
        $this->iban = $iban;

        return $this;
    }

    /**
     * @return string
     */
    public function getBic()
    {
        return $this->bic;
    }

    /**
     * @param string $bic
     * @return self
     */
    public function setBic($bic)
    {
        $this->bic = $bic;

        return $this;
    }
}