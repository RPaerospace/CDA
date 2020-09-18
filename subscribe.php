<?php

require_once('functions/check_access_subsystem.php');

//Verify logged user

session_start();

if(!isset($_SESSION["user"])){

    header("Location:index.php");

    die;
}

if(!isset($_POST['IdSubsystem'])){
    header("Location:main.php");
    //print_r($_POST);
    die;
}


//Check access

check_access_subsystem($_POST['IdSubsystem']);



//Insert SUBSCRIPTIONs into TABLE
try{

  
    require("connection.php");
  
  
  
    $sql_subs = "INSERT IGNORE INTO subscriptions (IdSubscription,IdSubsystem,IdVariable)
    VALUES (:IdSubscription,".$_POST['IdSubsystem']." , :IdVariable)";
  
  
  
  
    $query_subs = $base->prepare($sql_subs); 
  
  
    $i=1;
    //echo $_POST["sub_$i"];
  //print_r($_POST);
  
    foreach($_POST as $sub => $id){
      if($sub=='IdSubsystem'){continue;}
    
      $query_subs->bindValue(":IdVariable", $id);
      $query_subs->bindValue(":IdSubscription", $_POST['IdSubsystem'].".".$id);
      $query_subs->execute();        
  
      $i++;
    }
  
  
    header("Location:subsystem_database.php?IdSubsystem=".$_GET['IdSubsystem']."&subs=auth");//?active_subsystem=".$_GET['active_subsystem']."&IdSubsystem=.$_GET['IdSubsystem']
  
  }catch(Exception $e){
  
    die("Error: ".$e->getMessage());
  
  
  }finally{
  //echo "ERASING BASE";
   $base=NULL;
  }
  
  
  
  ?>