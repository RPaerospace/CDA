<?php



function check_access_subsystem($IdSubsystem){

    try{
  
    if($IdSubsystem == 0){checkSystemsEngineer();}else{
      require("connection.php");
      
      $subsystem_data = $base->prepare("SELECT * FROM subsystems WHERE IdSubsystem = $IdSubsystem AND IdMission = ".$_SESSION['mission']['IdMission']." AND IdUser = ".$_SESSION['user']['IdUser']);
      $subsystem_data->execute();
      
      
      //Head index if no access
      if(!$subsystem_data->rowCount()){
  
        header("Location:index.php");
  
        die;
      }

    $_SESSION['subsystem'] = $subsystem_data->fetch(PDO::FETCH_ASSOC);

      return $subsystem_data;
    }
  
    
  
  
    }catch(Exception $e){
  
    die("Error: ".$e->getMessage());
  
  
  
    }finally{
  
    //ERASING BASE
    $base=NULL;
    }
  
  return TRUE;
  
}

?>