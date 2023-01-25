<?php

namespace Paygreen\Sdk\Payment\V2;

class Environment extends \Paygreen\Sdk\Core\Environment
{
    const ENDPOINT_V2_SANDBOX = 'https://sandbox.paygreen.fr';
    const ENDPOINT_V2_PRODUCTION = 'https://paygreen.fr';

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
        parent::__construct($environment, 'payment', $apiVersion);
        
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;

        if (self::API_VERSION_2 === $this->getApiVersion()) {
            $this->setBearer($this->getPrivateKey());
        }
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
            return self::ENDPOINT_V2_SANDBOX;
        }
    
        return self::ENDPOINT_V2_PRODUCTION;
    }
}
