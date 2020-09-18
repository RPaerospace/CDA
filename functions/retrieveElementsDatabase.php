<?php



function retrieveElementsDatabase(){
  
    try{
      
      
      require("connection.php");
  
  
      $query_db = $base->prepare("SELECT * FROM elements WHERE IsNew = TRUE");
    
      $query_db->execute();
    
      $datas = $query_db->rowCount();
    
      if(!$datas){
          //echo("No values found.");
          //exit;
      }
  
      while($data = $query_db->fetch(PDO::FETCH_ASSOC)){
  
        $element[$data['IdElement']] = $data;
  
        $element[$data['IdElement']]['Variables'] = retrieveVarsElementData($data['IdElement'])->fetchAll(PDO::FETCH_ASSOC);
        
        $element[$data['IdElement']]['Subsystem'] = retrieveSubsystemName($data['IdSubsystem']);
      }
    
      
    }catch(Exception $e){
  
      die("Error: ".$e->getMessage());
  
  
    }finally{
      //echo "ERASING BASE";
      $base=NULL;
    }
  
    return $element;
  
  }

  
  ?>