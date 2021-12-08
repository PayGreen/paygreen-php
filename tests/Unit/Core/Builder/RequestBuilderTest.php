<?php

namespace Paygreen\Tests\Unit\Core\Builder;

use Paygreen\Sdk\Core\Factory\RequestFactory;
use Paygreen\Sdk\Payment\V2\Environment;
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
            RequestFactory::class,
            (new RequestFactory($environment))
        );
    }
}