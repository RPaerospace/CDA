<?php

require_once('config_mission.php');
require_once('functions/retrieveVariableData.php');
require_once('functions/check_access_subsystem.php');


$var = retrieveVariableData($_GET['IdVariable'])->fetch(PDO::FETCH_ASSOC);

check_access_subsystem($_SESSION['subsystem']['IdSubsystem']);



try{
    
    require("connection.php");
  
  
  
    $sql_unsub = "DELETE FROM subscriptions WHERE IdSubscription=".$_SESSION['subsystem']['IdSubsystem'].".".$_GET['IdVariable'];
  
    $query_unsub = $base->prepare($sql_unsub); 
  
    $query_unsub->execute();        
  
  }catch(Exception $e){
  
    die("Error: ".$e->getMessage());
  
  
  }finally{
  //echo "ERASING BASE";
   $base=NULL;
  }

  header("location:subsystem_main.php?IdSubsystem=".$_SESSION['subsystem']['IdSubsystem']."&unsub=auth");


?>  
