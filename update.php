<?php

require_once('config_mission.php');

require_once('functions/checkElement.php');
require_once('functions/updateVariable.php');


checkElement($_POST['IdElement']);


for($i=1;isset($_POST["variable_name_$i"]);$i++){


  
  $updated = updateVariable($_POST['IdElement'], $_POST["id_$i"], $_POST["variable_name_$i"], $_POST["unit_measurement_$i"], $_POST["value_$i"]);
  if($updated){
      $string = date('Y-m-d H:i:s')."  Variable ".$_POST['IdElement'].",".$_POST["id_$i"].",'".$_POST["variable_name_$i"]."' value UPDATED by ".$_SESSION['user']['IdUser'].",".$_SESSION['user']['User'].". Value: ".$_POST["value_$i"]."\n";
      file_put_contents("logs/".$_SESSION['mission']['IdMission'].".log", $string, FILE_APPEND);   
  }
}









header("Location:subsystem_main.php?IdSubsystem=".$_GET['IdSubsystem']."&col=".$_POST['IdElement']."&upd=auth");




?>