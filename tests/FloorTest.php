<?php

namespace Phrity\Util;

use Phrity\Util\Numerics;
use PHPUnit_Framework_TestCase;

class FloorTest extends PHPUnit_Framework_TestCase
{
    public function testFloorWithPrecision()
    {
        $this->assertEquals(1234.5678, Numerics::floor(1234.5678, 4));
        $this->assertEquals(1234.5670, Numerics::floor(1234.5678, 3));
        $this->assertEquals(1234.5600, Numerics::floor(1234.5678, 2));
        $this->assertEquals(1234.5000, Numerics::floor(1234.5678, 1));
        $this->assertEquals(1234.0000, Numerics::floor(1234.5678, 0));
        $this->assertEquals(1230.0000, Numerics::floor(1234.5678, -1));
        $this->assertEquals(1200.0000, Numerics::floor(1234.5678, -2));
        $this->assertEquals(1000.0000, Numerics::floor(1234.5678, -3));
        $this->assertEquals(0.0000, Numerics::floor(1234.5678, -4));
    }

    public function testCombability()
    {
        $this->assertEquals(\floor(1234.5678), Numerics::floor(1234.5678));
        $this->assertEquals(\floor(1234.5680), Numerics::floor(1234.5680));
        $this->assertEquals(\floor(1234.5700), Numerics::floor(1234.5700));
        $this->assertEquals(\floor(1234.6000), Numerics::floor(1234.6000));
        $this->assertEquals(\floor(1235.0000), Numerics::floor(1235.0000));
        $this->assertEquals(\floor(1240.0000), Numerics::floor(1240.0000));
        $this->assertEquals(\floor(1300.0000), Numerics::floor(1300.0000));
        $this->assertEquals(\floor(1300.0000), Numerics::floor(1300.0000));
    }
}
