<?php

namespace SolarSystem;

final class AstronomicalUnit
{
    public function __construct(float $distance)
    {
        $distance = abs($distance); //Distances are always positive numbers
        $this->distance = $distance;
    }
    public static function getValue()
    {
        return $this->distance;
    }
    public function __toString(): string
    {
        return $this->distance;
    }
}
