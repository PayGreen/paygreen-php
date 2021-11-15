<?php

namespace Paygreen\Tests\Unit\Core\Component;

use InvalidArgumentException;
use Paygreen\Sdk\Core\Environment;
use PHPUnit\Framework\TestCase;

final class EnvironmentTest extends TestCase
{
    public function testCanBeCreatedFromValidParameters()
    {
        $this->assertInstanceOf(
            Environment::class,
            (new Environment(
                'public_key',
                'private_key',
                'SANDBOX',
                2
            ))
        );
    }

    public function testCannotBeCreatedFromInvalidParameters()
    {
        $this->expectException(InvalidArgumentException::class);

        new Environment(
            'public_key',
            'private_key',
            'INVALID_ENVIRONMENT',
            2
        );
    }

    public function testEnvironmentAccessors()
    {
        $environment = new Environment(
            'public_key',
            'private_key',
            'production',
            2
        );

        $this->assertEquals(
            'public_key',
            $environment->getPublicKey()
        );

        $this->assertEquals(
            'private_key',
            $environment->getPrivateKey()
        );

        $this->assertEquals(
            Environment::ENVIRONMENT_PRODUCTION,
            $environment->getEnvironment()
        );

        $this->assertEquals(
            2,
            $environment->getApiVersion()
        );
    }

    public function testEnvironmentEndpointDefinition()
    {
        $environment = new Environment(
            'public_key',
            'private_key',
            Environment::ENVIRONMENT_SANDBOX,
            2
        );

        $this->assertEquals(
            Environment::ENDPOINT_V2_SANDBOX,
            $environment->getEndpoint()
        );

        $environment = new Environment(
            'public_key',
            'private_key',
            Environment::ENVIRONMENT_PRODUCTION,
            2
        );

        $this->assertEquals(
            Environment::ENDPOINT_V2_PRODUCTION,
            $environment->getEndpoint()
        );

        $environment = new Environment(
            'public_key',
            'private_key',
            Environment::ENVIRONMENT_SANDBOX,
            3
        );

        $this->assertEquals(
            Environment::ENDPOINT_V3_SANDBOX,
            $environment->getEndpoint()
        );

        $environment = new Environment(
            'public_key',
            'private_key',
            Environment::ENVIRONMENT_PRODUCTION,
            3
        );

        $this->assertEquals(
            Environment::ENDPOINT_V3_PRODUCTION,
            $environment->getEndpoint()
        );
    }
}