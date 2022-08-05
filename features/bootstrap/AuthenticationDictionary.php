<?php

use Paygreen\Sdk\Payment\V3\Utils;
use PHPUnit\Framework\Assert;

/**
 * Defines authentication related features.
 */
trait AuthenticationDictionary
{
    /**
     * @When /^I authenticate the Client$/
     */
    public function iAuthenticateTheClient()
    {
        $response = $this->client->authenticate();

        Assert::assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents())->data;
        $bearer = $data->token;
        $this->client->setBearer($bearer);
    }

    /**
     * @Then /^I should be able to make authenticated requests$/
     */
    public function iShouldBeAbleToMakeAuthenticatedRequests()
    {
        $response = $this->client->listPaymentConfig();

        Assert::assertEquals(200, $response->getStatusCode());
    }

    /**
     * @Then /^I should be able to retrieve public key information$/
     */
    public function iShouldBeAbleToRetrievePublicKeyInformation()
    {
        $response = $this->client->getPublicKey(getenv('PUBLIC_KEY'));

        Assert::assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents())->data;

        Assert::assertEquals(getenv('PUBLIC_KEY'), $data->id);
        Assert::assertEquals(getenv('SHOP_ID'), $data->shop);
        Assert::assertEquals(null, $data->revoked_at);
    }

    /**
     * @Then /^I should be able to retrieve the expiration date of the bearer token$/
     */
    public function iShouldBeAbleToRetrieveTheExpirationDateOfTheBearerToken()
    {
        $bearer = $this->client->getEnvironment()->getBearer();

        Assert::assertNotNull($bearer);

        $data = Utils::decodeJWT($bearer);

        Assert::assertTrue(is_int($data->exp));
    }
}
