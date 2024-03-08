<?php

namespace Paygreen\Sdk\Payment\V3\Model;

interface SellingContractInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @param string $id
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getShopId();

    /**
     * @param string $shopId
     */
    public function setShopId($shopId);

    /**
     * @return string
     */
    public function getNumber();

    /**
     * @param string $number
     */
    public function setNumber($number);

    /**
     * @return int
     */
    public function getMcc();

    /**
     * @param int $mcc
     */
    public function setMcc($mcc);

    /**
     * @return int
     */
    public function getMaxAmount();

    /**
     * @param int $maxAmount
     */
    public function setMaxAmount($maxAmount);

    /**
     * @return string
     */
    public function getType();

    /**
     * @param string $type
     */
    public function setType($type);

    /**
     * @return string
     */
    public function getIban();

    /**
     * @param string $iban
     */
    public function setIban($iban);

    /**
     * @return string
     */
    public function getBic();

    /**
     * @param string $bic
     */
    public function setBic($bic);
}