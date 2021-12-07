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
                'access_token',
                'refresh_token',
                'SANDBOX',
                2
            ))
        );
    }

    public function testCannotBeCreatedFromInvalidParameters()
    {
        $this->expectException(InvalidArgumentException::class);

        new GreenEnvironment(
            'access_token',
            'refresh_token',
            'SANDBOX',
            'INVALID_API_VERSION'
        );
    }

    public function testEnvironmentAccessors()
    {
        $environment = new GreenEnvironment(
            'access_token',
            'refresh_token',
            'production',
            2
        );

        $this->assertEquals(
            'access_token',
            $environment->getBearer()
        );

        $this->assertEquals(
            'refresh_token',
            $environment->getRefreshToken()
        );
    }

    public function testEnvironmentEndpointDefinition()
    {
        $environment = new GreenEnvironment(
            'access_token',
            'refresh_token',
            Environment::ENVIRONMENT_SANDBOX,
            2
        );

        $this->assertEquals(
            GreenEnvironment::ENDPOINT_V2_SANDBOX,
            $environment->getEndpoint()
        );

        $environment = new GreenEnvironment(
            'access_token',
            'refresh_token',
            Environment::ENVIRONMENT_PRODUCTION,
            2
        );

        $this->assertEquals(
            GreenEnvironment::ENDPOINT_V2_PRODUCTION,
            $environment->getEndpoint()
        );
    }
}