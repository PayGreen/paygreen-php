<?php

namespace Paygreen\Sdk\Payment\V3;

class Environment extends \Paygreen\Sdk\Core\Environment
{
    const ENDPOINT_V3_SANDBOX = 'https://sb-api.paygreen.fr';
    const ENDPOINT_V3_RECETTE = 'https://rc-api.paygreen.dev';
    const ENDPOINT_V3_PRODUCTION = 'https://api.paygreen.fr';

    /** @var string */
    private $shopId;

    /** @var string */
    private $secretKey;

    /**
     * @param string     $shopId
     * @param string     $secretKey
     */
    public function __construct($shopId, $secretKey, $environment, $apiVersion = \Paygreen\Sdk\Core\Environment::API_VERSION_3)
    {
        parent::__construct($environment, 'payment', $apiVersion);
        
        $this->shopId = $shopId;
        $this->secretKey = $secretKey;
    }

    /**
     * @return string
     */
    public function getShopId()
    {
        return $this->shopId;
    }

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        if (self::ENVIRONMENT_SANDBOX === $this->getEnvironment()) {
            return self::ENDPOINT_V3_SANDBOX;
        }

        if (self::ENVIRONMENT_RECETTE === $this->getEnvironment()) {
            return self::ENDPOINT_V3_RECETTE;
        }

        return self::ENDPOINT_V3_PRODUCTION;
    }
}
