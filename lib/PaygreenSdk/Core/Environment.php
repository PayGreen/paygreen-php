<?php

namespace Paygreen\Sdk\Core;

use InvalidArgumentException;

class Environment
{
    const API_VERSION_2 = 2;
    const API_VERSION_3 = 3;

    const ENVIRONMENT_SANDBOX = 'SANDBOX';
    const ENVIRONMENT_PRODUCTION = 'PRODUCTION';

    const ENDPOINT_V2_SANDBOX = 'https://sandbox.paygreen.fr';
    const ENDPOINT_V2_PRODUCTION = 'https://paygreen.fr';
    const ENDPOINT_V3_SANDBOX = 'https://rc-api.paygreen.fr';
    const ENDPOINT_V3_PRODUCTION = 'https://api.paygreen.fr';

    /** @var string */
    private $publicKey;

    /** @var string */
    private $privateKey;

    /** @var string */
    private $bearer;

    /** @var string */
    private $environment;

    /** @var int */
    private $apiVersion;

    /** @var string */
    private $applicationName = 'sdk';

    /** @var string */
    private $applicationVersion = '1.0.0';

    /**
     * @param string     $publicKey
     * @param string     $privateKey
     * @param string     $environment
     * @param int|string $apiVersion
     */
    public function __construct($publicKey, $privateKey, $environment, $apiVersion)
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
        $this->environment = strtoupper($environment);
        $this->apiVersion = (int) $apiVersion;
        $availableEnvironments = [self::ENVIRONMENT_PRODUCTION, self::ENVIRONMENT_SANDBOX];

        if (!in_array($this->environment, $availableEnvironments)) {
            throw new InvalidArgumentException('Environment only accept: '.implode(', ', $availableEnvironments).'. Current: "'.$environment.'"');
        }

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
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @return int
     */
    public function getApiVersion()
    {
        return $this->apiVersion;
    }

    /**
     * @return string
     */
    public function getApplicationName()
    {
        return $this->applicationName;
    }

    /**
     * @return string
     */
    public function getApplicationVersion()
    {
        return $this->applicationVersion;
    }


    /**
     * @return string
     */
    public function getEndpoint()
    {
        if (2 === $this->getApiVersion()) {
            if (self::ENVIRONMENT_SANDBOX === $this->getEnvironment()) {
                return self::ENDPOINT_V2_SANDBOX;
            }

            return self::ENDPOINT_V2_PRODUCTION;
        }

        if (self::ENVIRONMENT_SANDBOX === $this->getEnvironment()) {
            return self::ENDPOINT_V3_SANDBOX;
        }

        return self::ENDPOINT_V3_PRODUCTION;
    }

    /**
     * @return string
     */
    public function getBearer()
    {
        return $this->bearer;
    }

    /**
     * @param string $bearer
     */
    public function setBearer($bearer)
    {
        $this->bearer = $bearer;
    }

    /**
     * @param string $applicationName
     */
    public function setApplicationName($applicationName)
    {
        $this->applicationName = $applicationName;
    }

    /**
     * @param string $applicationVersion
     */
    public function setApplicationVersion($applicationVersion)
    {
        $this->applicationVersion = (string) $applicationVersion;
    }
}
