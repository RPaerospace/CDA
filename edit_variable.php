<?php

require_once('config_mission.php');

require_once('functions/checkElement.php');
require_once('functions/check_access_subsystem.php');
require_once('functions/updateVariable.php');

checkElement($_POST['IdElement']);


if(isset($_POST["Variable"])){
    
    updateVariable($_POST['IdElement'], $_POST["IdVariable"], $_POST["Variable"], $_POST["UnitMeasurement"], $_POST["Value"]);

    
  //RECORD in LOG
    $string = date('Y-m-d H:i:s')."  Variable ".$_POST['IdElement'].",".$_POST["IdVariable"].",'". $_POST["Variable"]."' EDITED by ".$_SESSION['user']['IdUser'].",".$_SESSION['user']['User']."\n";
    file_put_contents("logs/".$_SESSION['mission']['IdMission'].".log", $string, FILE_APPEND);   


}

header("Location:subsystem_main.php?IdSubsystem=".$_GET['IdSubsystem']."&col=".$_POST['IdElement']."&editvar=auth");

die;
?>