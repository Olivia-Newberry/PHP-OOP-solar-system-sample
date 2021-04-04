<?php
namespace SolarSystem;
require_once(__DIR__.'/../vendor/autoload.php');
echo '<link rel="stylesheet" type="text/css" href="../css/style.css">';

//check if system is included as a POST or GET variable
if (isset($_REQUEST['system'])) 
{
    //load or generate specific solarSystem
    $solarSystem = new SolarSystem($_REQUEST['system']);

    if(isset($_REQUEST['addEntity']))
    {
        $solarSystem->addEntity();
    }
}

//check if a field was edited
if (isset($_REQUEST['field'],$_REQUEST['value']))
{
    //user edited field
    //separate components of "field"
    $field = explode('.',$_REQUEST['field']);
    
    //remove any whitespace
    $value = trim($_REQUEST['value']);
    
    switch(count($field)){
        case 2: //change SolarSystem element
            $tempSystem = new SolarSystem($field[0]);
            $tempSystem->{'set'.$field[1]}($value);
            $tempSystem->save();
            break;
        case 3: //change AstronomicalEntity element
            $solarSystem->getEntity($field[1])->{'set'.$field[2]}($value);
            $solarSystem->save();
            break;
    }
}

/*************************
 * list all solar systems
 *************************/
echo '<h1>Solar Systems</h1>';
echo '<p>Note: all distances are in Astronomical Units (AU)</p>';

//components to display for each solarsystem
$items = array('Id','Name','Mass','Diameter');

//using a css grid over a table for ease of display
echo '<div class="grid-4">';
foreach ($items as $item)
{
    echo "<span>$item</span>\n";
}

//grab list of each known solarsystem
$solarSystems = new SolarSystems;
$solarSystemList = $solarSystems->list();

foreach ($solarSystemList as $entry)
{
    foreach ($items as $item)
    {
        switch($item){
            case 'Id'://each ID will include a link adding the system ID to get URI
                $id = $entry->{'get'.$item}();
                echo "<span><a href = '?system=$id'>$id</a></span>\n";
                break;
            case 'Name'://Names will allow the user to enter a friendly name for the solarsystem and call a JS function to add to URI on the change event
                $value = htmlentities($entry->{'get'.$item}());
                $id = $entry->getId().".".$item;
                echo "<span><input id='$id' onChange='updateField(this)' value='$value'></span>\n";
                break;
            default://Display just data in read only format
                echo "<span>".htmlentities($entry->{'get'.$item}())."</span>\n";
                break;
        }
    }
}
//Add a link to add a new solar system by adding the get variable but leaving it empty to be treated as a null value
echo '<span><a href="?system=">New Solar System</a></span>';
echo '</div>';

/*********************************
 * Display specific Solar System
 *********************************/
if(isset($_REQUEST['system'])){
    echo '<h1>SolarSystem:'.$solarSystem->getName().'</h1>';
    echo "";
    echo "<p>Total Mass: ".$solarSystem->getMass()."</p>";
    echo "<p>Total Diameter: ".$solarSystem->getDiameter()."</p>";

    echo "Astronomical Entities";
    echo "<div class='grid-4'>";
    //items to be displayed for each entity
    $items = array('Name','Mass','Radius','Orbit');
    foreach($items as $item)
    {
        echo "<span>$item</span>\n";
    }
    foreach($solarSystem->getEntities() as $id => $entity)
    {
        foreach($items as $item){
            $value = $entity->{'get'.$item}();
            $temp = $solarSystem->getId().'.'.$id.'.'.$item;//used as identifyer for updating fields
            if (is_a($value, 'SolarSystem\AstronomicalUnit')) 
            {
                //cell is an astronomical unit
                echo '<span><input id="'.$temp.'" onChange="updateField(this)" type="number" value = "'.htmlentities($value).'"></span>'."\n";
            }
            else
            {
                //cell will be the Name
                echo '<span><input id="'.$temp.'" onChange="updateField(this)" value="'.htmlentities($value).'"></span>'."\n";
            }
        }
    }
    //Add a link to add a new entity by adding the get variable but leaving it empty to be treated as a null value
    echo '<span><a href="?system='.$solarSystem->getId().'&addEntity">New entry</a></span>';
    echo "</div>";

}
?>
<script>
    function updateField(element)//function adds the currently selected solarsystem to URI if it is currently selected and the id and value of edited field
    {
        window.location.href='?'<?php 
        if(isset($solarSystem))echo '+"system='.$solarSystem->getId().'&"';
        ?>
        +'field='+encodeURIComponent(element.id)
        +'&value='+encodeURIComponent(element.value);
    }
</script>
