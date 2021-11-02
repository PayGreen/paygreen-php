<?php

namespace Paygreen\Tests\Core\Components;
use Paygreen\Sdk\Core\Components\Bag;
use PHPUnit\Framework\TestCase;

final class BagTest extends TestCase
{
    public function testCanGetData()
    {
        $bag = new Bag();
        $bag['key'] = 'value';

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