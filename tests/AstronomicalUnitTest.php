<?php

namespace SolarSystem;

use PHPUnit\Framework\TestCase;

class AstronomicalUnit extends TestCase
{
    public function test_an_astronomical_unit_can_not_be_negative()
    {
        $distance = new AstronomicalUnit(-5);
        $this->assertInstanceOf(AstronomicalUnit::class, $distance);
        var_dump($distance);
        $this->assertEquals((float)1,$distance::getValue());
    }
}
