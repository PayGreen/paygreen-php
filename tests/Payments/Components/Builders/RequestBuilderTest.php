<?php

use Paygreen\Sdk\Payments\Components\Builders\RequestBuilder;
use Paygreen\Sdk\Payments\Exceptions\InvalidApiVersion;
use PHPUnit\Framework\TestCase;

final class RequestBuilderTest extends TestCase
{
    public function testCanBeCreatedFromValidParameters()
    {
        $this->assertInstanceOf(
            RequestBuilder::class,
            (new RequestBuilder('2', 'private_key', 'https://sandbox.paygreen.fr'))
        );
    }

    public function testCannotBeCreatedFromInvalidParameters()
    {
        $this->expectException(InvalidApiVersion::class);

        new RequestBuilder('INVALID_API_KEY', 'private_key', 'https://sandbox.paygreen.fr');
    }
}