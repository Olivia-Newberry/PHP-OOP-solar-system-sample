<?php

namespace SolarSystem;

interface SolarSystems
{
    public function add(SolarSystem $solarSystem);
    public function find(Identity $solarSystemId): SolarSystem;
}
