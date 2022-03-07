<?php

namespace Paygreen\Sdk\Payment\V3;

class Environment extends \Paygreen\Sdk\Core\Environment
{
    const ENDPOINT_V3_SANDBOX = 'https://rc-api.paygreen.dev';
    const ENDPOINT_V3_PRODUCTION = 'https://api.paygreen.fr';

    /** @var string */
    private $publicKey;

    /** @var string */
    private $privateKey;

    /**
     * @param string     $publicKey
     * @param string     $privateKey
     */
    public function __construct($publicKey, $privateKey, $environment, $apiVersion)
    {
        parent::__construct($environment, $apiVersion);
        
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
    }

    /**
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        if (self::ENVIRONMENT_SANDBOX === $this->getEnvironment()) {
            return self::ENDPOINT_V3_SANDBOX;
        }

        return self::ENDPOINT_V3_PRODUCTION;
    }
}
