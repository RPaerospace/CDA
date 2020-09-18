<?php
//////////////////////
function isSystemsEngineer(){
  
  try{

  require("connection.php");
    
  $access = $base->prepare("SELECT * FROM missions WHERE IdMission = ".$_SESSION['mission']['IdMission']." AND IdManager = ".$_SESSION['user']['IdUser']);
  $access->execute();
  
  


  }catch(Exception $e){

      die("Error: ".$e->getMessage());



  }finally{

      //ERASING BASE
      $base=NULL;
  }



  return $access->rowCount();
}
/////////////////////////////
?>