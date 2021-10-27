<?php

namespace PayGreenSdk\Core\Components;

class Environment
{
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
        $this->environment = $environment;
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
        return strtoupper($this->environment);
    }
}