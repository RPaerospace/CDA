<?php

function retrieveVariableRequests($subsystem){

  
  
try{
    
  require("connection.php");


    $sql = "SELECT * FROM reqvariables WHERE ToIdSubsystem = $subsystem ORDER BY FromIdSubsystem";

    $query_data = $base->prepare($sql);

    $query_data->execute();

    //$deleting_elements=[];
    if($query_data->rowCount()){
        $variables = $query_data->fetchAll(PDO::FETCH_ASSOC);
    }

}catch(Exception $e){

  die("Error: ".$e->getMessage());


}finally{
  //echo "ERASING BASE";
  $base=NULL;
}



if($query_data->rowCount()){
  return($variables);

}

}

?>