<?php

require_once('config_mission.php');

require_once('functions/retrieveVariableData.php');
require_once('functions/checkElement.php');
require_once('functions/check_access_subsystem.php');
require_once('functions/cancelRequestVariableDeletion.php');
require_once('functions/requestVariableDeletion.php');
require_once('functions/retrieveElementData.php');
require_once('functions/cancelRequestElementDeletion.php');
require_once('functions/requestElementDeletion.php');



if(isset($_GET['IdVariable'])){

    $var = retrieveVariableData($_GET['IdVariable'])->fetch(PDO::FETCH_ASSOC);
    //Check element access
    checkElement($var["IdElement"]);

    if($var['Deletion']==1){
      cancelRequestVariableDeletion($_GET['IdVariable']);

      //LOG ENTRY
      
      $string = date('Y-m-d H:i:s')."  Variable ".$var["IdElement"].",".$_GET['IdVariable'].",'".$var["Variable"].
      "' CANCEL DELETION REQUEST by ".$_SESSION['user']['IdUser'].",".$_SESSION['user']['User']."\n";
      file_put_contents("logs/".$_SESSION['mission']['IdMission'].".log", $string, FILE_APPEND);  

    
      header("Location:subsystem_main.php?IdSubsystem=".$_GET['IdSubsystem']."&col=".$var['IdElement']."&cancelVar=auth");
      die;
    }else{
      requestVariableDeletion($_GET['IdVariable']);

      
      //LOG ENTRY

      $string = date('Y-m-d H:i:s')."  Variable ".$var["IdElement"].",".$_GET['IdVariable'].",'".$var["Variable"].
      "' REQUESTED DELETION by ".$_SESSION['user']['IdUser'].",".$_SESSION['user']['User']."\n";
      file_put_contents("logs/".$_SESSION['mission']['IdMission'].".log", $string, FILE_APPEND);  
      
    
  header("Location:subsystem_main.php?IdSubsystem=".$_GET['IdSubsystem']."&col=".$var['IdElement']."&delvar=auth");
  die;
    }




}elseif(isset($_GET['IdElement'])){

  
    //Check element access
    checkElement($_GET['IdElement']);

    $ele = retrieveElementData($_GET['IdElement'])->fetch(PDO::FETCH_ASSOC);

    
    if($ele['Deletion']==1){
      cancelRequestElementDeletion($_GET['IdElement']);
      
      //LOG ENTRY
  
      $string = date('Y-m-d H:i:s')."  Element ".$_GET['IdElement'].",'".$ele['Element'].
          "' CANCEL DELETION REQUEST by ".$_SESSION['user']['IdUser'].",".$_SESSION['user']['User']."\n";
      file_put_contents("logs/".$_SESSION['mission']['IdMission'].".log", $string, FILE_APPEND);  

    
      header("Location:subsystem_main.php?IdSubsystem=".$_GET['IdSubsystem']."&col=".$_GET['IdElement']."&cancelEle=auth");
      die;
    }else{
      requestElementDeletion($_GET['IdElement']);
      
      //LOG ENTRY
  
      $string = date('Y-m-d H:i:s')."  Element ".$_GET['IdElement'].",'".$ele['Element'].
          "' REQUESTED DELETION by ".$_SESSION['user']['IdUser'].",".$_SESSION['user']['User']."\n";
      file_put_contents("logs/".$_SESSION['mission']['IdMission'].".log", $string, FILE_APPEND);  

    
      header("Location:subsystem_main.php?IdSubsystem=".$_GET['IdSubsystem']."&col=".$_GET['IdElement']."&delele=auth");
      die;
    }


}







?>