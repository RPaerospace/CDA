<?php

function check_access($IdMission){

try{
  require("connection.php");
  
  $mission_data = $base->prepare("SELECT * FROM missions WHERE IdMission = $IdMission");
  $mission_data->execute();
  

  //Check user mission access
  $access = $base->prepare("SELECT * FROM usermission WHERE IdMission = $IdMission AND IdUser = ".$_SESSION["user"]['IdUser']);
  $access->execute();

  
  //Head index if no access
  if(!$access->rowCount()){

    header("Location:index.php");

    die;
  }
  $_SESSION['mission'] = $mission_data->fetch(PDO::FETCH_ASSOC);

  


}catch(Exception $e){

  die("Error: ".$e->getMessage());



}finally{

  //ERASING BASE
  $base=NULL;
}

}

?>