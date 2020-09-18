<?php

require_once('config_mission.php');

require_once('functions/check_access_subsystem.php');
// checkSystemsEngineer();



if($_SESSION['user']['IdUser'] == $_SESSION['mission']['IdManager'] or check_access_subsystem($_SESSION['subsystem']['IdSubsystem'])){
      
require("connection.php");

if(isset($_GET['IdVariable'])){




    function cancelRequestVariableDeletion($IdVariable){
    
        if($IdVariable==""){return;}
      
        try{
          
          
          require("connection.php");
      
          $sql = "UPDATE variables
          SET Deletion = 0
          WHERE IdVariable = ".$IdVariable;
      
          $query_element = $base->prepare($sql);
        
          $query_element->execute();
        
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
      
        return $query_element;
      
      
      
    }
    cancelRequestVariableDeletion($_GET['IdVariable']);
    
    
header("Location:mission_main.php?cancelVar=auth");
if(isset($_GET['IdSubsystem'])){
  
  header("Location:subsystem_main.php?IdSubsystem=".$_GET['IdSubsystem']."&col=".$_GET['IdElement']."&cancelVar=auth");
  
}else{
  header("Location:mission_main.php?cancelEle=auth");
}
die;
    

}elseif(isset($_GET['IdElement'])){


    
    function cancelRequestElementDeletion($IdElement){

        if($IdElement==""){return;}
    
        try{
        
        
          require("connection.php");
        
          $sql = "UPDATE elements
          SET Deletion = 0, IsNew = 1
          WHERE IdElement = ".$IdElement;
    
          $query_element = $base->prepare($sql);
        
          $query_element->execute();
        
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
    
        return $query_element;
    
    
    
    }

    cancelRequestElementDeletion($_GET['IdElement']);
}

if(isset($_GET['IdSubsystem'])){
  
  header("Location:subsystem_main.php?IdSubsystem=".$_GET['IdSubsystem']."&col=".$_GET['IdElement']."&cancelEle=auth");
  
}else{
  header("Location:mission_main.php?cancelEle=auth");
}

die;
}
header("Location:mission_main.php?");
?>