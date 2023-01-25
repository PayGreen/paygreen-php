<?php

namespace Paygreen\Sdk\Climate\V2;

use InvalidArgumentException;

class Environment extends \Paygreen\Sdk\Core\Environment
{
    const ENDPOINT_V2_SANDBOX = 'https://sb-api-climatekit.paygreen.fr';
    const ENDPOINT_V2_PRODUCTION = 'https://solidaire.paygreen.fr';
    const ENDPOINT_V2_RECETTE = 'https://rc-api-climatekit.paygreen.fr';
    
    /** @var string */
    private $clientId;
    
    /**
     * @param string $clientId
     */
    public function __construct($clientId, $environment, $apiVersion)
    {
        parent::__construct($environment, 'climate', $apiVersion);
        
        $this->clientId = $clientId;
        $availableApiVersions = [self::API_VERSION_2];

        if (!in_array($this->apiVersion, $availableApiVersions)) {
            throw new InvalidArgumentException('Api version only accept: '.implode(', ', $availableApiVersions).'. Current: "'.$this->apiVersion.'"');
        }
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return string
     */
    public function getEndpoint()
    {
        switch ($this->getEnvironment()) {
            case self::ENVIRONMENT_SANDBOX:
                return self::ENDPOINT_V2_SANDBOX;
            case self::ENVIRONMENT_RECETTE:
                return self::ENDPOINT_V2_RECETTE;
            default:
                return self::ENDPOINT_V2_PRODUCTION;
        }
    }
}
