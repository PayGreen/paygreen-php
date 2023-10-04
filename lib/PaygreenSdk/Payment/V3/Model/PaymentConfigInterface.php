<?php

namespace Paygreen\Sdk\Payment\V3\Model;

interface PaymentConfigInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param string $status
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getCurrency();

    /**
     * @param string $currency
     */
    public function setCurrency($currency);

    /**
     * @return string
     */
    public function getPlatform();

    /**
     * @param string $platform
     */
    public function setPlatform($platform);

    /**
     * @return string|null
     */
    public function getSellingContractId();

    /**
     * @param string|null $sellingContractId
     */
    public function setSellingContractId($sellingContractId);

    /**
     * @return array
     */
    public function getConfig();

    /**
     * @param array<string> $config
     */
    public function setConfig(array $config);
}