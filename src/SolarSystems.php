<?php

namespace SolarSystem;

final class SolarSystems
{
    public $solarSystems = array();
    public function list()
    {
        $filePath = '..\\datastore\\';
        if ($handle = opendir($filePath)) //go through file folder and check for all known SolarSystems
        {
            while (false !== ($file = readdir($handle)))
            {
                if ($file != "." && $file != "..")
                {
                    $this->solarSystems[] = new SolarSystem(explode('.',$file)[0]); //filename is {solarsystem ID}.json, explode on '.' extracts SolarSystem Id for loading
                }
            }
            closedir($handle);
        }
        return $this->solarSystems;
    }
}
