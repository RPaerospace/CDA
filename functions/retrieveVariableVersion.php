<?php

function retrieveVariableVersion($IdVariable, $version){

try{
  require("connection.php");
  
  $variable_version = $base->prepare("SELECT * FROM variablesversions WHERE IdVariable = $IdVariable AND VarVersion = $version");
  $variable_version->execute();




}catch(Exception $e){

    die("Error: ".$e->getMessage());



}finally{

    //ERASING BASE
    $base=NULL;
}


return $variable_version;
}

?>