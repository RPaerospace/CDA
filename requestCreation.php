<?php

require_once('functions/check_access_subsystem.php');
require_once('functions/checkSystemsEngineer.php');
//Verify logged user

session_start();

if(!isset($_SESSION["user"])){

    header("Location:index.php");

    die;
}

if(!isset($_POST['IdSubsystem']) or !isset($_GET['IdSubsystem'])){
    header("Location:main.php");
    //print_r($_POST);
    die;
}


//Check access

check_access_subsystem($_POST['IdSubsystem']);

if($_POST['IdSubsystem']=="Select..."){$_POST['IdSubsystem'] =0;}


//Insert SUBSCRIPTIONs into TABLE
try{

  
    require("connection.php");
  
  
  
    $sql_req = "INSERT INTO reqvariables (FromIdSubsystem, ToIdSubsystem, Variable, UnitMeasurement, Description)
    VALUES (".$_POST['IdSubsystem'].",".$_GET['IdSubsystem']." , '".$_POST['Variable']."', '".$_POST['UnitMeasurement']."', '".$_POST['Description']."')";
  
  
  
  
    $query_req = $base->prepare($sql_req); 
  
    $query_req->execute();        
  
  
    header("Location:subsystem_database.php?IdSubsystem=".$_GET['IdSubsystem']."&req=auth");//?active_subsystem=".$_GET['active_subsystem']."&IdSubsystem=.$_GET['IdSubsystem']
  
  }catch(Exception $e){
  
    die("Error: ".$e->getMessage());
  
  
  }finally{
  //echo "ERASING BASE";
   $base=NULL;
  }
  
  
  
  ?>