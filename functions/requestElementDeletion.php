<?php

function requestElementDeletion($IdElement){
    
    if($IdElement==""){return;}
  
    try{
      
      
      require("connection.php");
  
      $sql = "UPDATE elements
      SET Deletion = 1, IsNew = 0 
      WHERE IdElement = ".$IdElement;
  
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