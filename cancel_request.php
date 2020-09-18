<?php

require_once('config_mission.php');

require_once('functions/check_access_subsystem.php');
// checkSystemsEngineer();



if(check_access_subsystem($_SESSION['subsystem']['IdSubsystem'])){
      
require("connection.php");

if(isset($_GET['IdRequest'])){


        try{
          
          
          require("connection.php");
      
          $sql = "DELETE FROM reqvariables WHERE IdRequest = ?";
      
          $query_element = $base->prepare($sql);
        
          $query_element->execute([$_GET['IdRequest']]);
        
          $datas = $query_element->rowCount();
        
          if(!$datas){
              echo("No values found.");
              //exit;
          }
        
          
        }catch(Exception $e){
      
          die("Error: ".$e->getMessage());
      
      
        }finally{
          //echo "ERASING BASE";
          $base=NULL;
        }
      
    
}

if(isset($_SESSION['subsystem']['IdSubsystem'])){
  
  header("Location:subsystem_main.php?IdSubsystem=".$_SESSION['subsystem']['IdSubsystem']);
  
die;
}

}
header("Location:mission_main.php?");
?>