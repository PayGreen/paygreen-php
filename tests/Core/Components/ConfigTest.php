<?php

namespace Paygreen\Tests\Core\Components;
use Paygreen\Sdk\Core\Components\Bag;
use Paygreen\Sdk\Core\Components\Config;
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