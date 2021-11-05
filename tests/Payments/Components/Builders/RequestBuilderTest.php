<?php

use Paygreen\Sdk\Core\Component\Environment;
use Paygreen\Sdk\Payment\Components\Builders\RequestBuilder;
use Paygreen\Sdk\Payment\Exception\InvalidApiVersion;
use PHPUnit\Framework\TestCase;

final class RequestBuilderTest extends TestCase
{
    public function testCanBeCreatedFromValidParameters()
    {
        $environment = new Environment(
            'public_key',
            'private_key',
            'sandbox',
            2
        );

        $this->assertInstanceOf(
            RequestBuilder::class,
            (new RequestBuilder($environment))
        );
    }

    public function testCannotBeCreatedFromInvalidParameters()
    {
        $environment = new Environment(
            'public_key',
            'private_key',
            'sandbox',
            'INVALID_API_VERSION'
        );

        $this->expectException(InvalidApiVersion::class);

        new RequestBuilder($environment);
    }
}