<?php

namespace SolarSystem;

final class SolarSystem
{
    public $id;
    public $name = '';//friendly name
    public $entities = array();//array to store each astronomical entity

    public function __construct(string $id = null)
    {
        if ($id) {//load from datastore if passed an id
            $this->load($id);
        }
        $this->id = new identity($id);
        if(!$this->name)$this->name = (string)$this->id;//populate friendly name if no name is provided
        $this->save();//save new entity to datastore
    }

    public function getDiameter()
    {
        $diameter = 0;
        foreach($this->entities as $entity){//check for largest combined radius and orbit diameter
            $tempDiameter = $entity->orbit->getDiameter() + $entity->radius->getDiameter();
            if($tempDiameter > $diameter)
                $diameter = $tempDiameter;
        }
        return $diameter;
    }

    public function getId(): Identity
    {
        return $this->id;
    }

    public function addEntity()
    {
        $temp = new AstronomicalEntity;
        $this->entities[(string)$temp->getID()] = $temp;//add new entity to the array key representing entity id
        $this->save();//save after altering SolarSystem
    }

    public function getEntities()
    {
        return $this->entities;
    }

    public function getEntity($id):AstronomicalEntity
    {
        return $this->entities[$id];
    }

    public function getMass()
    {
        $mass = 0;//add the mass of each entity
        foreach($this->entities as $entity){
            $mass += $entity -> mass -> getValue();
        }
        return $mass;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        $this->save();
    }

    public function save()//save to datastore
    {
        file_put_contents("..\\datastore\\".$this->id.'.json', json_encode($this, JSON_PRETTY_PRINT));//using JSON_PRETTY_PRINT for JSON readability
    }

    private function load(string $id)
    {
        $filePath = '..\\datastore\\'.$id.'.json';
        if (file_exists($filePath)) {
            $file = json_decode(file_get_contents($filePath), true);
            foreach ($file as $key => $value) 
            {
                if($key === 'entities')//entities require to be parsed slightly differently
                {
                    foreach ($value as $entity) 
                    {
                        $import = array(
                            'id' => $entity['id']['value'],
                            'name' => $entity['name'],
                            'mass' => $entity['mass']['value'],
                            'radius' => $entity['radius']['value'],
                            'orbit' => $entity['orbit']['value']
                        );
                        $this->entities[$import['id']] = new AstronomicalEntity($import);
                    }
                }
                else
                {
                    $this->{$key} = $value;
                }
            }
        } 
        else 
        {
            throw new \InvalidArgumentException('SolarSystem: '.$id.' Not found');
        }
    }
}
