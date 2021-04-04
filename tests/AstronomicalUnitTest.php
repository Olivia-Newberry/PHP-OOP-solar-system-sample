<?php

namespace SolarSystem;

use PHPUnit\Framework\TestCase;

class AstronomicalUnitTest extends TestCase
{
    public function test_an_astronomical_unit_can_not_be_negative()
    {
        $test = new AstronomicalUnit(-1);//expect value to now be a float of 1
        $this->assertInstanceOf(AstronomicalUnit::class, $test);
        $this->assertEquals((float)1,$test->value);
    }
}
