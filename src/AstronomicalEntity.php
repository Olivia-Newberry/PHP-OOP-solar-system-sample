<?php

namespace SolarSystem;

final class AstronomicalEntity
{
    public $id;
    public $name = '';
    public $mass = 0;
    public $radius = 0;
    public $orbit = 0;

    public function __construct(array $entity = null)
    {
        if($entity){
            //used to populate AstronomicalEntity
            foreach ($entity as $key => $value) 
            {
                if(in_array($key,array('id','name','mass','radius','orbit')))
                    $this->{$key} = $value;
            }
        }
        //verify every internal variable by assigning appropriate classes
        $this->id = new identity($this->id);
        if(!$this->name) $this->name = (string)$this->id;//used to give non empty names for new entities
        $this->mass = new AstronomicalUnit($this->mass);
        $this->radius = new AstronomicalUnit($this->radius);
        $this->orbit = new AstronomicalUnit($this->orbit);
    }

    public function getId(): Identity
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getMass(): AstronomicalUnit
    {
        return $this->mass;
    }

    public function getRadius(): AstronomicalUnit
    {
        return $this->radius;
    }

    public function getOrbit(): AstronomicalUnit
    {
        return $this->orbit;
    }
    
    public function setName($value)
    {
        $this->name = $value;
    }
    
    public function setMass($value)
    {
        $this->mass = new AstronomicalUnit($value);
    }
    
    public function setRadius($value)
    {
        $this->radius = new AstronomicalUnit($value);
    }
    
    public function setOrbit($value)
    {
        $this->orbit = new AstronomicalUnit($value);
    }
}
