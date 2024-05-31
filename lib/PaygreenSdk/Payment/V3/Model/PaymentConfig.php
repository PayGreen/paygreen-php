<?php

namespace Paygreen\Sdk\Payment\V3\Model;

class PaymentConfig implements PaymentConfigInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $platform;

    /**
     * @var string|null
     */
    private $sellingContractId = null;

    /**
     * @var array
     */
    private $config = array();

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     *
     * @return self
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return string
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param string $platform
     *
     * @return self
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSellingContractId()
    {
        return $this->sellingContractId;
    }

    /**
     * @param string|null $sellingContractId
     *
     * @return self
     */
    public function setSellingContractId($sellingContractId)
    {
        $this->sellingContractId = $sellingContractId;

        return $this;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     *
     * @return self
     */
    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }
}