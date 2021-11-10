<?php

namespace Paygreen\Tests\Unit\Payment\Component\Builder;

use Paygreen\Sdk\Core\Component\Environment;
use Paygreen\Sdk\Payment\Component\Builder\RequestBuilder;
use Paygreen\Sdk\Payment\Exception\InvalidApiVersionException;
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
}