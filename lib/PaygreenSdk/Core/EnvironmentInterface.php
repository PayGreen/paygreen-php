<?php

namespace Paygreen\Sdk\Core;

interface EnvironmentInterface
{
    /**
     * @return string
     */
    public function getEnvironment();

    /**
     * @return int
     */
    public function getApiVersion();

    /**
     * @return string
     */
    public function getApplicationName();

    /**
     * @return string
     */
    public function getApplicationVersion();

    /**
     * @return string
     */
    public function getBearer();

    /**
     * @param string $bearer
     */
    public function setBearer($bearer);

    /**
     * @param string $applicationName
     */
    public function setApplicationName($applicationName);

    /**
     * @param string $applicationVersion
     */
    public function setApplicationVersion($applicationVersion);

    /**
     * @return bool 
     */
    public function isTestMode();

    /**
     * @param bool $testMode 
     */
    public function setTestMode($testMode);
    
    /**
     * @return string
     */
    public function getEndpoint();
}
