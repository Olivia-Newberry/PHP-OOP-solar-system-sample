<?php

namespace SolarSystem;

final class AstronomicalUnit
{
    public function __construct(float $value)
    {
        $value = abs($value); //values are always positive numbers
        $this->value = $value;
    }
    public function getValue()
    {
        return $this->value;
    }
    public function getDiameter() //Distances are stored as radius or distance to central point
    {
        return $this->value*2;
    }
    public function __toString(): string
    {
        return $this->value;
    }
}
