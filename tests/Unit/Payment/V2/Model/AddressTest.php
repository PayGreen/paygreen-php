<?php

namespace Paygreen\Tests\Unit\Payment\Model;

use Paygreen\Sdk\Payment\Model\Address;
use PHPUnit\Framework\TestCase;

final class AddressTest extends TestCase
{
    /**
     * @return void
     */
    public function testCanGetAndSetPostCode()
    {
        $address = new Address();
        $address->setPostcode('76000');

        $this->assertEquals('76000', $address->getPostcode());
    }

    /**
     * @return void
     */
    public function testCanGetAndSetCity()
    {
        $address = new Address();
        $address->setCity('Rouen');

        $this->assertEquals('Rouen', $address->getCity());
    }

    /**
     * @return void
     */
    public function testCanGetAndSetCountryCode()
    {
        $address = new Address();
        $address->setCountryCode('FR');

        $this->assertEquals('FR', $address->getCountryCode());
    }

    /**
     * @return void
     */
    public function testCanGetAndSetStreetLineOne()
    {
        $address = new Address();
        $address->setStreetLineOne('Ma rue');

        $this->assertEquals('Ma rue', $address->getStreetLineOne());
    }

    /**
     * @return void
     */
    public function testCanGetAndSetStreetLineTwo()
    {
        $address = new Address();
        $address->setStreetLineTwo('Escalier B');

        $this->assertEquals('Escalier B', $address->getStreetLineTwo());
    }

    /**
     * @return void
     */
    public function testCanGetStreet()
    {
        $address = new Address();
        $address->setStreetLineOne('Ma rue');

        $this->assertEquals('Ma rue', $address->getStreet());

        $address->setStreetLineTwo('Escalier B');

        $this->assertEquals('Ma rue Escalier B', $address->getStreet());
    }
}