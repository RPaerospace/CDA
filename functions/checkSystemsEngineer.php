<?php

require("functions/isSystemsEngineer.php");

function checkSystemsEngineer(){
  
  $access = isSystemsEngineer();
  //Head index if no access
  if(!$access){

    header("Location:index.php");

    die;
  }
  return $access;
  
}
?>