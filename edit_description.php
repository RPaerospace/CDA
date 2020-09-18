<?php

require_once('functions/check_access_subsystem.php');

//Verify logged user

session_start();

if(!isset($_SESSION["user"])){

    header("Location:index.php");

    die;
}

if(!isset($_GET['IdSubsystem']) or !isset($_POST['description'])){
    //header("Location:main.php");
    //print_r($_POST);
    die;
}


//Check access

check_access_subsystem($_GET['IdSubsystem']);



//Insert SUBSCRIPTIONs into TABLE
try{

  
    require("connection.php");
  
  
  
    $sql_subs = "UPDATE subsystems SET Description = '".$_POST['description']."'
    WHERE IdSubsystem = " . $_GET['IdSubsystem'];
  
  
  
  
    $query_subs = $base->prepare($sql_subs); 
  
    $query_subs->execute();        
  
  
    header("Location:subsystem_main.php?IdSubsystem=".$_GET['IdSubsystem']."&descr=auth");//?active_subsystem=".$_GET['active_subsystem']."&IdSubsystem=.$_GET['IdSubsystem']
  
  }catch(Exception $e){
  
    die("Error: ".$e->getMessage());
  
  
  }finally{
  //echo "ERASING BASE";
   $base=NULL;
  }
  
  
  
  ?>