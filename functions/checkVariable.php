<?php

function checkVariable($IdSubsystem, $IdVariable){

try{
  require("connection.php");
  
  $variable_data = $base->prepare("CALL select_SS_IdVariables($IdSubsystem)");
  $variable_data->execute();
  $data = $variable_data->fetchAll(PDO::FETCH_ASSOC);

  $access = 0;
  foreach ($data as $var){
    if ($var['IdVariable']== $IdVariable){
      $access = 1;
      break;
    }
  }
  
  //Head index if no access
  if(!$access){

    header("Location:index.php");

    die;
  }
  //check_access_subsystem($element_data->fetch()[0]);




}catch(Exception $e){

    die("Error: ".$e->getMessage());



}finally{

    //ERASING BASE
    $base=NULL;
}

}

?>