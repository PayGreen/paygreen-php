<?php

namespace Paygreen\Sdk\Core\Components;

use InvalidArgumentException;

class Environment
{
    const ENVIRONMENT_SANDBOX = 'SANDBOX';
    const ENVIRONMENT_PRODUCTION = 'PRODUCTION';

    /** @var string */
    private $publicKey;

    /** @var string */
    private $privateKey;

    /** @var string */
    private $environment;

    /**
     * @param string $publicKey
     * @param string $privateKey
     * @param string $environment
     */
    public function __construct($publicKey, $privateKey, $environment)
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
        $this->environment = strtoupper($environment);

        $availableEnvironments = [self::ENVIRONMENT_PRODUCTION, self::ENVIRONMENT_SANDBOX];

        if (!in_array($this->environment, $availableEnvironments)) {
            throw new InvalidArgumentException('Environment only accept: ' . implode(', ', $availableEnvironments));
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
}