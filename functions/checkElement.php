<?php
function checkElement($IdElement){

try{
  require("connection.php");
  
  $element_data = $base->prepare("SELECT IdSubsystem FROM elements WHERE IdElement = $IdElement");
  $element_data->execute();
  
  
  //Head index if no access
  if(!$element_data->rowCount()){

    header("Location:index.php");

    die;
  }
  check_access_subsystem($element_data->fetch()[0]);




}catch(Exception $e){

    die("Error: ".$e->getMessage());



}finally{

    //ERASING BASE
    $base=NULL;
}

}
?>