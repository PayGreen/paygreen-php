<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given A new Environment
     */
    public function aNewEnvironment()
    {
        $this->environment = new Environment();
    }

    /**
     * @Given A shop id is added to the Environment
     */
    public function aShopIdIsAddedToTheEnvironment()
    {
        throw new PendingException();
    }

    /**
     * @Given A secret key is added to the Environment
     */
    public function aSecretKeyIsAddedToTheEnvironment()
    {
        throw new PendingException();
    }

    /**
     * @Given An endpoint is added to the Environment
     */
    public function anEndpointIsAddedToTheEnvironment()
    {
        throw new PendingException();
    }

    /**
     * @Then The Environment is ready to use
     */
    public function theEnvironmentIsReadyToUse()
    {
        throw new PendingException();
    }

    /**
     * @Given A ready to use Environment
     */
    public function aReadyToUseEnvironment()
    {
        throw new PendingException();
    }

    /**
     * @Given A PSR7 http client
     */
    public function aPsrHttpClient()
    {
        throw new PendingException();
    }

    /**
     * @Then The Client is ready to use but not authenticated
     */
    public function theClientIsReadyToUseButNotAuthenticated()
    {
        throw new PendingException();
    }
}
