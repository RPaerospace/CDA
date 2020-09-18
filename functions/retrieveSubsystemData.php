<?php
//Returns elements from provided subsystem ID
//
function retrieveSubsystemData($IdSubsystem){


    try{
      
      require("connection.php");
  
  
    //Retrieveng data available for active subsystem
  
    $sql = "SELECT * FROM elements WHERE IdSubsystem = $IdSubsystem ORDER BY list, IdElement";
  
    $query_data = $base->prepare($sql);
  
    $query_data->execute();
  
    $datas = $query_data->rowCount();
  
    if(!$datas){
        //echo("No elements found.");
        //exit;
    }
  
  
    
    }catch(Exception $e){
  
        die("Error: ".$e->getMessage());
  
  
    }finally{
        //echo "ERASING BASE";
        $base=NULL;
    }
    
    return $query_data;
  
  
}
?>