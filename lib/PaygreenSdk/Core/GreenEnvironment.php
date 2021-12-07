<?php

namespace Paygreen\Sdk\Core;

use InvalidArgumentException;

class GreenEnvironment extends Environment
{
    const ENDPOINT_V2_SANDBOX = 'https://sb-api-climatekit.paygreen.fr';
    const ENDPOINT_V2_PRODUCTION = 'https://solidaire.paygreen.fr';

    /** @var string */
    private $refreshToken;

    /**
     * @param string     $accessToken
     * @param string     $refreshToken
     */
    public function __construct($accessToken, $refreshToken, $environment, $apiVersion)
    {
        parent::__construct($environment, $apiVersion);
        
        $this->bearer = $accessToken;
        $this->refreshToken = $refreshToken;
        $availableApiVersions = [self::API_VERSION_2];

        if (!in_array($this->apiVersion, $availableApiVersions)) {
            throw new InvalidArgumentException('Api version only accept: '.implode(', ', $availableApiVersions).'. Current: "'.$this->apiVersion.'"');
        }
    }

    /**
     * @return string
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @param string $refreshToken
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;
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
