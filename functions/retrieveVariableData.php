<?php

function retrieveVariableData($IdVariable){

    if($IdVariable==""){return;}
  
    try{
      
      
      require("connection.php");
  
      $sql = "SELECT * FROM variables WHERE IdVariable = ".$IdVariable;
  
      $query_element = $base->prepare($sql);
    
      $query_element->execute();
    
      $datas = $query_element->rowCount();
    
      if(!$datas){
          echo("No values found.");
          //exit;
      }
    
      
    }catch(Exception $e){
  
      die("Error: ".$e->getMessage());
  
  
    }finally{
      //echo "ERASING BASE";
      $base=NULL;
    }
  
    return $query_element;
  
  
  
  
  
}
  
  
?>