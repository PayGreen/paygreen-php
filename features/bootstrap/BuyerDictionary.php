<?php

use Behat\Behat\Tester\Exception\PendingException;
use Paygreen\Sdk\Payment\V3\Model\Address;
use Paygreen\Sdk\Payment\V3\Model\Buyer;
use PHPUnit\Framework\Assert;

/**
 * Defines buyer related features.
 */
trait BuyerDictionary
{
    /**
     * @var Buyer
     */
    private $buyer;


    /**
     * @Given /^A buyer object$/
     */
    public function aBuyerObject()
    {
        $address = new Address();
        $address->setCity('Paris');
        $address->setCountryCode('FR');
        $address->setStreetLineOne('1 rue de la paix');
        $address->setStreetLineTwo('2ème étage');
        $address->setPostalCode('75001');
        $address->setState('Normandie');

        $this->buyer = new Buyer();
        $this->buyer->setReference('sdk-behat-buyer');
        $this->buyer->setEmail('test@test.fr');
        $this->buyer->setFirstName('John');
        $this->buyer->setLastName('Doe');
        $this->buyer->setBillingAddress($address);
    }

    /**
     * @When /^I create a buyer$/
     */
    public function iCreateABuyer()
    {
        $this->client->createBuyer($this->buyer);
    }

    /**
     * @Then /^I receive a response with the buyer$/
     */
    public function iReceiveAResponseWithTheBuyer()
    {
        $response = $this->client->getLastResponse();
        $data = json_decode((string)$response->getBody())->data;

        Assert::assertEquals('buyer', $data->object);
        Assert::assertEquals($this->buyer->getEmail(), $data->email);
        Assert::assertEquals($this->buyer->getFirstName(), $data->first_name);
        Assert::assertEquals($this->buyer->getLastName(), $data->last_name);
        Assert::assertEquals($this->buyer->getReference(), $data->reference);
    }

    /**
     * @Then /^I add the buyer_id to the buyer object$/
     */
    public function iAddTheBuyerIdToTheBuyerObject()
    {
        $response = $this->client->getLastResponse();
        $data = json_decode((string)$response->getBody())->data;

        $this->buyer->setId($data->id);
        print $this->buyer->getId();
    }


    /**
     * @When /^I get all buyers$/
     */
    public function iGetAllBuyers()
    {
        throw new PendingException();
    }

    /**
     * @Given /^I receive a response with all buyers$/
     */
    public function iReceiveAResponseWithAllBuyers()
    {
        throw new PendingException();
    }

    /**
     * @When /^I update the buyer$/
     */
    public function iUpdateTheBuyer()
    {
        $this->buyer->setFirstName('Blank');
        $this->buyer->setLastName('Aux');

        $this->client->updateBuyer($this->buyer);
    }

    /**
     * @When /^I delete the buyer$/
     */
    public function iDeleteTheBuyer()
    {
        throw new PendingException();
    }

}
