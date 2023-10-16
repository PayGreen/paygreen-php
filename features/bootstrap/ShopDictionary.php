<?php

use Paygreen\Sdk\Payment\V3\Model\Shop;
use PHPUnit\Framework\Assert;

/**
 * Defines shop related features.
 */
trait ShopDictionary
{
    /**
     * @var Shop
     */
    private $shop;

    /**
     * @When /^I get a shop$/
     */
    public function iGetAShop()
    {
        $this->client->getShop(getenv('SHOP_ID_OWNED_BY_MARKETPLACE'));
    }

    /**
     * @Then /^I receive a response with the shop$/
     */
    public function iReceiveAResponseWithTheShop()
    {
        $response = $this->client->getLastResponse();
        $data = json_decode((string)$response->getBody())->data;

        Assert::assertEquals(1, preg_match('`^sh_[[:xdigit:]]{32}$`', $data->id));
        if (!is_null($data->marketplace_shop_id)) {
            Assert::assertEquals(1, preg_match('`^sh_[[:xdigit:]]{32}$`', $data->marketplace_shop_id));
        }
        Assert::assertTrue(!empty($data->head_office));
        Assert::assertTrue(!empty($data->address));
        Assert::assertEquals(1, preg_match('`^add_[[:xdigit:]]{32}$`', $data->address->id));
        Assert::assertEquals(1, preg_match('`^acc_[[:xdigit:]]{32}$`', $data->account_id));
        Assert::assertObjectHasAttribute('activity_categories', $data);
        Assert::assertObjectHasAttribute('economic_model', $data);
        Assert::assertObjectHasAttribute('lang', $data);
        Assert::assertObjectHasAttribute('status', $data);
    }

    /**
     * @When /^I update this shop$/
     */
    public function iUpdateThisShop()
    {
        $this->client->getShop('sh_c34402949c9d47f48b883d1c7ddd3ce2');
    }
}
