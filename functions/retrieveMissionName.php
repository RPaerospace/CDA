<?php

function retrieveMissionName($IdMission){

if($IdMission==""){return;}

try{
  
  
  require("connection.php");

  $sql = "SELECT * FROM missions WHERE IdMission = ".$IdMission;

  $query_element = $base->prepare($sql);

  $query_element->execute();

  $datas = $query_element->rowCount();

  if(!$datas){
      //echo("No values found.");
      //exit;
      return;
  }

  
}catch(Exception $e){

  die("Error: ".$e->getMessage());


}finally{
  //echo "ERASING BASE";
  $base=NULL;
}

return $query_element->fetch(PDO::FETCH_ASSOC)['Mission'];





}



?>