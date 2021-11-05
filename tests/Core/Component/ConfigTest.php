<?php

namespace Paygreen\Tests\Core\Component;
use Paygreen\Sdk\Core\Component\Bag;
use Paygreen\Sdk\Core\Component\Config;
use PHPUnit\Framework\TestCase;

final class ConfigTest extends TestCase
{
    public function testBagFormat()
    {
        $config = new Config();

        $this->assertInstanceOf(Bag::class, $config->getBag());
    }

    public function testCanGetConfig()
    {
        $config = new Config();
        $config->getBag()->merge(['configKey' => 'configValue']);

        $this->assertEquals('configValue', $config['configKey']);
    }
}