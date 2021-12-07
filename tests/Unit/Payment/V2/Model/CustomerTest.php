<?php

namespace Paygreen\Tests\Unit\Payment\V2\Model;

use Paygreen\Sdk\Payment\V2\Model\Customer;
use PHPUnit\Framework\TestCase;

final class CustomerTest extends TestCase
{    
    /**
     * @return void
     */
    public function testCanGetAndSetId()
    {
        $customer = new Customer();
        $customer->setId('customer-1');

        $this->assertEquals('customer-1', $customer->getId());
    }

    /**
     * @return void
     */
    public function testCanGetAndSetCompanyName()
    {
        $customer = new Customer();
        $customer->setCompanyName('PayGreen');

        $this->assertEquals('PayGreen', $customer->getCompanyName());
    }

    /**
     * @return void
     */
    public function testCanGetAndSetFirstname()
    {
        $customer = new Customer();
        $customer->setFirstname('Laurent');

        $this->assertEquals('Laurent', $customer->getFirstname());
    }

    /**
     * @return void
     */
    public function testCanGetAndSetLastname()
    {
        $customer = new Customer();
        $customer->setLastname('Barre');

        $this->assertEquals('Barre', $customer->getLastname());
    }

    /**
     * @return void
     */
    public function testCanGetAndSetEmail()
    {
        $customer = new Customer();
        $customer->setEmail('customer@test.fr');

        $this->assertEquals('customer@test.fr', $customer->getEmail());
    }

    /**
     * @return void
     */
    public function testCanGetAndSetCountryCode()
    {
        $customer = new Customer();
        $customer->setCountryCode('FR');

        $this->assertEquals('FR', $customer->getCountryCode());
    }
}