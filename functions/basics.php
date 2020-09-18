<?php

function updateConnectedUser(){
  
    try{
      
      
      require("connection.php");
  
  
      $update_time = $base->prepare("UPDATE users SET Last = CURRENT_TIMESTAMP WHERE IdUser = ".$_SESSION['user']['IdUser']);
    
      $update_time->execute();
    
      $datas = $update_time->rowCount();
    
      if(!$datas){
          //echo("No values found.");
          //exit;
      }
    
      
    }catch(Exception $e){
  
      die("Error: ".$e->getMessage());
  
  
    }finally{
      //echo "ERASING BASE";
      $base=NULL;
    }
  
  }

  
////////////////////////// basics
function updateConnectedUserMission(){
  
    try{
      
      
      require("connection.php");
  
  
      $update_time = $base->prepare("UPDATE usermission SET LastDate = CURRENT_TIMESTAMP 
                                    WHERE IdUser = ".$_SESSION['user']['IdUser'].
                                    " AND IdMission = ".$_SESSION['mission']['IdMission']);
    
      $update_time->execute();
    
      $datas = $update_time->rowCount();
    
      if(!$datas){
          //echo("No values found.");
          //exit;
      }
    
      
    }catch(Exception $e){
  
      die("Error: ".$e->getMessage());
  
  
    }finally{
      //echo "ERASING BASE";
      $base=NULL;
    }
  
  }
  //////////////////////////
  
  
?>