<?php

namespace Paygreen\Tests\Core\Component;
use Exception;
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

    public function testCanGetConfigFiles()
    {
        $config = new Config();
        
        $this->assertTrue(is_array($config->getConfigFiles()));
    }

    public function testCanGetOffset()
    {
        $config = new Config();
        $config->getBag()->merge(['configKey' => 'configValue']);

        $this->assertEquals('configValue', $config->offsetGet('configKey'));
    }

    public function testCantSetOffset()
    {
        $this->expectException(Exception::class);

        $config = new Config();
        $config->getBag()->merge(['configKey' => 'configValue']);

        $config->offsetSet('configKey', 'newConfigValue');
    }

    public function testCantUnsetOffset()
    {
        $this->expectException(Exception::class);

        $config = new Config();
        $config->getBag()->merge(['configKey' => 'configValue']);

        $config->offsetUnset('configKey');
    }

    public function testIfOffsetExist()
    {
        $config = new Config();
        $config->getBag()->merge(['configKey' => 'configValue']);

        $this->assertTrue($config->offsetExists('configKey'));
    }
}