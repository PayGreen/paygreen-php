<?php

namespace Paygreen\Tests\Core\Components;

use InvalidArgumentException;
use Paygreen\Sdk\Core\Components\Environment;
use PHPUnit\Framework\TestCase;

final class EnvironmentTest extends TestCase
{
    public function testCanBeCreatedFromValidParameters()
    {
        $this->assertInstanceOf(
            Environment::class,
            (new Environment('public_key', 'private_key', 'SANDBOX'))
        );
    }

    public function testCannotBeCreatedFromInvalidParameters()
    {
        $this->expectException(InvalidArgumentException::class);

        new Environment('public_key', 'private_key', 'INVALID_ENVIRONMENT');
    }

    public function testEnvironmentFormat()
    {
        $environment = new Environment('public_key', 'private_key', 'production');

        $this->assertEquals(
            Environment::ENVIRONMENT_PRODUCTION,
            $environment->getEnvironment()
        );
    }
}