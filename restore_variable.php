<?php

require_once('config_mission.php');
require_once('functions/checkVariable.php');
require_once('functions/retrieveVariableData.php');
require_once('functions/retrieveVariableVersion.php');
require_once('functions/updateVariable.php');


checkVariable($_GET['IdSubsystem'],$_POST['IdVariable']);


$variable_data = retrieveVariableData($_POST['IdVariable'])->fetch(PDO::FETCH_ASSOC);



if(isset($_POST["select"])){
    
    $new_variable = retrieveVariableVersion($_POST['IdVariable'], $_POST["select"])->fetch(PDO::FETCH_ASSOC);


    updateVariable($new_variable['IdElement'], $_POST["IdVariable"], $new_variable['Variable'], $new_variable['UnitMeasurement'], $new_variable['Value']);

    
  //RECORD in LOG
    $string = date('Y-m-d H:i:s')."  Variable ".$_POST['IdElement'].",".$_POST["IdVariable"].",'". $new_variable['Variable']."' EDITED FROM PREVIOUS VARVERSION by ".$_SESSION['user']['IdUser'].",".$_SESSION['user']['User']."\n";
    file_put_contents("logs/".$_SESSION['mission']['IdMission'].".log", $string, FILE_APPEND);   


    header("Location:subsystem_main.php?IdSubsystem=".$_GET['IdSubsystem']."&col=".$_POST['IdElement']."&hist=auth");

    die;
}




?>