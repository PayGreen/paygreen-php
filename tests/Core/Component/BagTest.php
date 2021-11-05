<?php

namespace Paygreen\Tests\Core\Component;

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
}