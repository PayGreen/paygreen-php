<?php

namespace Paygreen\Tests\Unit\Core;

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
                2,
                'sylius',
                '5.0.0'
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
            2,
            'sylius',
            '5.0.0'
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

        $environment->setApplicationName("sylius");
        $environment->setApplicationVersion("5.0.0");

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

        $this->assertEquals(
            'sylius',
            $environment->getApplicationName()
        );

        $this->assertEquals(
            '5.0.0',
            $environment->getApplicationVersion()
        );
    }

    public function testEnvironmentEndpointDefinition()
    {
        $environment = new Environment(
            'public_key',
            'private_key',
            Environment::ENVIRONMENT_SANDBOX,
            2,
            'sylius',
            '5.0.0'
        );

        $this->assertEquals(
            Environment::ENDPOINT_V2_SANDBOX,
            $environment->getEndpoint()
        );

        $environment = new Environment(
            'public_key',
            'private_key',
            Environment::ENVIRONMENT_PRODUCTION,
            2,
            'sylius',
            '5.0.0'
        );

        $this->assertEquals(
            Environment::ENDPOINT_V2_PRODUCTION,
            $environment->getEndpoint()
        );

        $environment = new Environment(
            'public_key',
            'private_key',
            Environment::ENVIRONMENT_SANDBOX,
            3,
            'sylius',
            '5.0.0'
        );

        $this->assertEquals(
            Environment::ENDPOINT_V3_SANDBOX,
            $environment->getEndpoint()
        );

        $environment = new Environment(
            'public_key',
            'private_key',
            Environment::ENVIRONMENT_PRODUCTION,
            3,
            'sylius',
            '5.0.0'
        );

        $this->assertEquals(
            Environment::ENDPOINT_V3_PRODUCTION,
            $environment->getEndpoint()
        );
    }
}