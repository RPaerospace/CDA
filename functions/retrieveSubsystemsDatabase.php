<?php



function retrieveSubsystemsDatabase(){
  
    try{
      
      
      require("connection.php");
  
  
      $query_db = $base->prepare("SELECT * FROM subsystems");
    
      $query_db->execute();
    
      $datas = $query_db->rowCount();
    
      if(!$datas){
          //echo("No values found.");
          //exit;
      }
  
      while($data = $query_db->fetch(PDO::FETCH_ASSOC)){
  
        $element[$data['IdSubsystem']] = $data;
  
        $element[$data['IdSubsystem']]['Elements'] = retrieveSubsystemData($data['IdSubsystem'])->fetchAll(PDO::FETCH_ASSOC);
        
        $element[$data['IdSubsystem']]['Mission'] = retrieveMissionName($data['IdMission']);
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