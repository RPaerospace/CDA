<?php



require_once("config_mission.php");

if(isset($_POST['Subsystem']) && isset($_POST['IdSubsystem'])){

    try{

        require("connection.php");

        
  
    $sql_subs = "UPDATE subsystems SET Subsystem = '".$_POST['Subsystem']."',  Description = '".$_POST['Description']."'
    WHERE IdSubsystem = " . $_POST['IdSubsystem'];
  
  
  
  
    $query_subs = $base->prepare($sql_subs); 
  
    $query_subs->execute();        
  
  
  
  }catch(Exception $e){
  
    die("Error: ".$e->getMessage());
  
  
  }finally{
  //echo "ERASING BASE";
   $base=NULL;
  }
  
  
}

header("Location:mission_main.php?edit=auth");//?active_subsystem=".$_GET['active_subsystem']."&IdSubsystem=.$_GET['IdSubsystem']

?>