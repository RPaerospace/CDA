<?php


function updateElement($IdElement, $List, $Element, $Description){
  
    if($IdElement==""){return;}
  
    try{
      
      
      require("connection.php");
  
      $sql = "UPDATE elements
      SET Element = \"$Element\", Description = \"$Description\", List = \"$List\", IsNew = 1
      WHERE IdElement = $IdElement";
  
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
  
    
    //RECORD in LOG
    $string = date('Y-m-d H:i:s')."  Element $IdElement,'$Element' EDITED by ".$_SESSION['user']['IdUser'].",".$_SESSION['user']['User']."\n";
    file_put_contents("logs/".$_SESSION['mission']['IdMission'].".log", $string, FILE_APPEND);   
  
  
  
  
    return $query_element;
  
  
  }
  
?>  