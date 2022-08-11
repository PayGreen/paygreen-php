<?php

namespace Paygreen\Tests\Unit\Payment\V3\Model;

use Paygreen\Sdk\Payment\V3\Model\Address;
use PHPUnit\Framework\TestCase;

final class AddressTest extends TestCase
{
    public function testCanGetAndSetPostalCode()
    {
        $address = new Address();
        $address->setPostalCode('76000');

        $this->assertEquals('76000', $address->getPostalCode());
    }

    public function testCanGetAndSetState()
    {
        $address = new Address();
        $address->setState('Normandie');

        $this->assertEquals('Normandie', $address->getState());
    }

    public function testCanGetAndSetCity()
    {
        $address = new Address();
        $address->setCity('Rouen');

        $this->assertEquals('Rouen', $address->getCity());
    }

    public function testCanGetAndSetCountryCode()
    {
        $address = new Address();
        $address->setCountryCode('FR');

        $this->assertEquals('FR', $address->getCountryCode());
    }

    public function testCanGetAndSetStreetLineOne()
    {
        $address = new Address();
        $address->setStreetLineOne('Ma rue');

        $this->assertEquals('Ma rue', $address->getStreetLineOne());
    }

    public function testCanGetAndSetStreetLineTwo()
    {
        $address = new Address();
        $address->setStreetLineTwo('Escalier B');

        $this->assertEquals('Escalier B', $address->getStreetLineTwo());
    }

    public function testCanGetStreet()
    {
        $address = new Address();
        $address->setStreetLineOne('Ma rue');

        $this->assertEquals('Ma rue', $address->getStreet());

        $address->setStreetLineTwo('Escalier B');

        $this->assertEquals('Ma rue Escalier B', $address->getStreet());
    }
}
