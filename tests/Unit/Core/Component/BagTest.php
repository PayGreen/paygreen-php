<?php

namespace Paygreen\Tests\Unit\Core\Component;

use Exception;
use Paygreen\Sdk\Core\Component\Bag;
use PHPUnit\Framework\TestCase;

final class BagTest extends TestCase
{
    public function testCanGetData()
    {
        $bag = new Bag();
        $bag->merge(['key' => 'value']);

        $this->assertEquals('value', $bag['key']);
    }

    public function testCanMergeData()
    {
        $bag = new Bag();

        $this->assertEquals(null, $bag['key']);

        $bag->merge(['key' => 'value']);

        $this->assertEquals('value', $bag['key']);
    }


    public function testToArrayConvertion()
    {
        $bag = new Bag();
        $bag->merge(['key' => 'value']);

        $this->assertTrue(is_array($bag->toArray()));
    }

    public function testCantSetOffset()
    {
        $this->expectException(Exception::class);

        $bag = new Bag();
        $bag->merge(['key' => 'value']);

        $bag->offsetSet('configKey', 'newConfigValue');
    }

    public function testCantUnsetOffset()
    {
        $this->expectException(Exception::class);

        $bag = new Bag();
        $bag->merge(['key' => 'value']);

        $bag->offsetUnset('configKey');
    }

    public function testCanSetDotSeparator()
    {
        $bag = new Bag();
        $bag->merge(['key' => ['sub_key' => 'value']]);

        $this->assertEquals('value', $bag->get('key.sub_key'));

        $bag->setDotSeparator(false);

        $this->assertEquals(null, $bag->get('key.sub_key'));

        $bag->setDotSeparator(false);
    }

    public function testCanGetAllData()
    {
        $bag = new Bag();
        $bag->merge(['key' => ['sub_key' => 'value']]);

        $data = $bag->get(false);

        $this->assertTrue(is_array($data));

        $this->assertEquals('value', $data['key']['sub_key']);
    }
}