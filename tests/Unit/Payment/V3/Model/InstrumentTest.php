<?php

namespace Paygreen\Tests\Unit\Payment\V3\Model;

use Paygreen\Sdk\Payment\V3\Model\Instrument;
use PHPUnit\Framework\TestCase;

final class InstrumentTest extends TestCase
{
    public function testCanGetAndSetReference()
    {
        $instrument = new Instrument();
        $instrument->setReference('reference-1');

        $this->assertEquals('reference-1', $instrument->getReference());
    }

    public function testCanGetAndSetType()
    {
        $instrument = new Instrument();
        $instrument->setType('type-1');

        $this->assertEquals('type-1', $instrument->getType());
    }

    public function testCanGetAndSetToken()
    {
        $instrument = new Instrument();
        $instrument->setToken('token-1');

        $this->assertEquals('token-1', $instrument->getToken());
    }

    public function testCanGetAndSetAuthorization()
    {
        $instrument = new Instrument();
        $instrument->setWithAuthorization(true);

        $this->assertEquals(true, $instrument->isWithAuthorization());
    }
}
