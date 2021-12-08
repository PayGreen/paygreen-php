<?php

namespace Paygreen\Tests\Unit\Core;

use InvalidArgumentException;
use Paygreen\Sdk\Core\Environment;
use Paygreen\Sdk\Core\GreenEnvironment;
use PHPUnit\Framework\TestCase;

final class GreenEnvironmentTest extends TestCase
{
    public function testCanBeCreatedFromValidParameters()
    {
        $this->assertInstanceOf(
            GreenEnvironment::class,
            (new GreenEnvironment(
                'client_id',
                'SANDBOX',
                2
            ))
        );
    }

    public function testCannotBeCreatedFromInvalidParameters()
    {
        $this->expectException(InvalidArgumentException::class);

        new GreenEnvironment(
            'client_id',
            'SANDBOX',
            'INVALID_API_VERSION'
        );
    }

    public function testEnvironmentAccessors()
    {
        $environment = new GreenEnvironment(
            'client_id',
            'production',
            2
        );

        $this->assertEquals(
            'client_id',
            $environment->getClientId()
        );
    }

    public function testEnvironmentEndpointDefinition()
    {
        $environment = new GreenEnvironment(
            'client_id',
            Environment::ENVIRONMENT_SANDBOX,
            2
        );

        $this->assertEquals(
            GreenEnvironment::ENDPOINT_V2_SANDBOX,
            $environment->getEndpoint()
        );

        $environment = new GreenEnvironment(
            'client_id',
            Environment::ENVIRONMENT_PRODUCTION,
            2
        );

        $this->assertEquals(
            GreenEnvironment::ENDPOINT_V2_PRODUCTION,
            $environment->getEndpoint()
        );
    }
}