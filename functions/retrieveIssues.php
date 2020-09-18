<?php



function retrieveIssues($IdMission){

    if($IdMission==""){return;}
  
    try{
      
      
      require("connection.php");
  
      $sql = "SELECT * FROM issues WHERE IdMission = ".$IdMission." ORDER BY Timestamp DESC";
  
      $query_element = $base->prepare($sql);
    
      $query_element->execute();
    
      $datas = $query_element->rowCount();
    
      if(!$datas){
          echo("Error. IdMission not found.");
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