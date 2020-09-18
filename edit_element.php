<?php

require_once('config_mission.php');


require_once('functions/checkElement.php');
require_once('functions/check_access_subsystem.php');
require_once('functions/updateElement.php');


checkElement($_POST['IdElement']);


if(isset($_POST["Element"])){
    
    updateElement($_POST['IdElement'], $_POST["List"], $_POST["Element"], $_POST["Description"]);

}

header("Location:subsystem_main.php?IdSubsystem=".$_GET['IdSubsystem']."&col=".$_POST['IdElement']."&editele=auth");

die;
?>