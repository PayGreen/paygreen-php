<?php

namespace Paygreen\Sdk\Core;

use InvalidArgumentException;

abstract class Environment implements EnvironmentInterface
{
    const API_VERSION_2 = 2;
    const API_VERSION_3 = 3;

    const ENVIRONMENT_SANDBOX = 'SANDBOX';
    const ENVIRONMENT_PRODUCTION = 'PRODUCTION';
    const ENVIRONMENT_RECETTE = 'RECETTE';
    
    /** @var string */
    protected $bearer;

    /** @var string */
    protected $environment;

    /** @var string */
    protected $apiName;

    /** @var int */
    protected $apiVersion;

    /** @var string */
    protected $applicationName;

    /** @var string */
    protected $applicationVersion;

    /** @var string */
    protected $cmsName;

    /** @var string */
    protected $cmsVersion;
    
    /** @var bool */
    protected $testMode = false;

    /**
     * @param string     $environment
     * @param string     $apiName
     * @param int|string $apiVersion
     */
    public function __construct($environment, $apiName, $apiVersion)
    {
        $this->environment = strtoupper($environment);
        $this->apiName = $apiName;
        $this->apiVersion = (int) $apiVersion;
        $availableEnvironments = [self::ENVIRONMENT_PRODUCTION, self::ENVIRONMENT_SANDBOX, self::ENVIRONMENT_RECETTE];

        if (!in_array($this->environment, $availableEnvironments)) {
            throw new InvalidArgumentException('Environment only accept: '.implode(', ', $availableEnvironments).'. Current: "'.$environment.'"');
        }
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @return string
     */
    public function getApiName()
    {
        return $this->apiName;
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
    public function getCmsName()
    {
        return $this->cmsName;
    }

    /**
     * @return string
     */
    public function getCmsVersion()
    {
        return $this->cmsVersion;
    }

    /**
     * @return string
     */
    public function getSdkVersion()
    {
        $composerJson = json_decode(file_get_contents(__DIR__ . '/../../../composer.json'));

        return $composerJson->version;
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

    /**
     * @param string $cmsName
     */
    public function setCmsName($cmsName)
    {
        $this->cmsName = $cmsName;
    }

    /**
     * @param string $cmsVersion
     */
    public function setCmsVersion($cmsVersion)
    {
        $this->cmsVersion = (string) $cmsVersion;
    }

    /**
     * @return bool
     */
    public function isTestMode()
    {
        return $this->testMode;
    }

    /**
     * @param bool $testMode
     */
    public function setTestMode($testMode)
    {
        $this->testMode = $testMode;
    }

    /**
     * @return string
     */
    abstract public function getEndpoint();
}
