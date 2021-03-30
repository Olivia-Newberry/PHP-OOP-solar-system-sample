<?php
namespace SolarSystem;

require(__DIR__.'/../vendor/autoload.php');

$uuid =  new Identity('00000000-0000-4000-8000-000000000000');
$test =  new Identity;
var_dump(''.$test);

$distance = new AstronomicalUnit(-5);
var_dump($distance->distance);
var_dump($distance);
$table = new SolarSystem;
var_dump($table);
