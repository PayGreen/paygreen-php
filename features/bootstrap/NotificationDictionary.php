<?php

use Behat\Behat\Tester\Exception\PendingException;
use Paygreen\Sdk\Payment\V3\Model\Listener;
use PHPUnit\Framework\Assert;

/**
 * Defines notification related features.
 */
trait NotificationDictionary
{
    /**
     * @var string|null
     */
    private $listenerId = null;

    /**
     * @var Listener
     */
    private $listener;

    /**
     * @Given /^A listener object$/
     */
    public function aListenerObject()
    {
        $this->listener = new Listener();
        $this->listener->setType('webhook');
        $this->listener->setEvents([\Paygreen\Sdk\Payment\V3\Enum\EventEnum::PAYMENT_ORDER_SUCCESSED]);
        $this->listener->setUrl('https://localhost:80/' . time());
    }

    /**
     * @When /^I create a listener$/
     */
    public function iCreateAListener()
    {
        $response = $this->client->createListener($this->listener, getenv('SHOP_ID'));
    }

    /**
     * @Then /^I receive a response with the listener$/
     */
    public function iReceiveAResponseWithTheListener()
    {
        $response = $this->client->getLastResponse();
        $data = json_decode((string) $response->getBody())->data;

        Assert::assertEquals(getenv('SHOP_ID'), $data->shop_id);
        Assert::assertEquals($this->listener->getType(), $data->type);
        Assert::assertEquals($this->listener->getEvents(), $data->events);
        Assert::assertEquals($this->listener->getUrl(), $data->url);
        Assert::assertObjectHasAttribute('hmac_key', $data);

        $this->listenerId = $data->id;
    }

    /**
     * @When /^I update the listener$/
     */
    public function iUpdateTheListener()
    {
        $this->client->updateListener($this->listenerId, 'https://localhost:80/' . time());
    }

    /**
     * @When /^I get the listener$/
     */
    public function iGetTheListener()
    {
        $this->client->getListener($this->listenerId);
    }

    /**
     * @When /^I delete the listener$/
     */
    public function iDeleteTheListener()
    {
        $this->client->deleteListener($this->listenerId);
    }

    /**
     * @When /^I get all listeners$/
     */
    public function iGetAllListeners()
    {
        $this->client->listListener(getenv('SHOP_ID'));
    }

    /**
     * @Given /^I receive a response with all listeners$/
     */
    public function iReceiveAResponseWithAllListeners()
    {
        $response = $this->client->getLastResponse();
        $listeners = json_decode((string) $response->getBody())->data;

        foreach ($listeners as $listener) {
            Assert::assertEquals(getenv('SHOP_ID'), $listener->shop_id);
            Assert::assertObjectHasAttribute('type', $listener);
            Assert::assertObjectHasAttribute('events', $listener);
            Assert::assertObjectHasAttribute('url', $listener);
            Assert::assertObjectHasAttribute('hmac_key', $listener);
        }
    }

    /**
     * @When /^I get all notifications$/
     */
    public function iGetAllNotifications()
    {
        $this->client->listNotification($this->listenerId);
    }

    /**
     * @Given /^I receive a response with all notifications$/
     */
    public function iReceiveAResponseWithAllNotifications()
    {
        $response = $this->client->getLastResponse();
        $notifications = json_decode((string) $response->getBody())->data;

        foreach ($notifications as $notification) {
            Assert::assertObjectHasAttribute('subject_id', $notification);
            Assert::assertObjectHasAttribute('response_code', $notification);
            Assert::assertObjectHasAttribute('executed_at', $notification);
        }
    }

    /**
     * @When /^I replay the notification$/
     */
    public function iReplayTheNotification()
    {
        throw new PendingException();
    }
}
