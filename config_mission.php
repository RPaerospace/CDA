<?php

require_once('functions/basics.php');
require_once('functions/check_access.php');
require_once('functions/check_access_subsystem.php');

//Verify logged user

session_start();

if(!isset($_SESSION["user"])){

    header("Location:index.php");

    die;
}

//Check mission and subsystem access
if(isset($_GET['IdMission'])){

  check_access($_GET['IdMission']);

}

//Head index if no access
if(!isset($_SESSION['mission'])){

  header("Location:index.php");

  die;
}else{
  
  check_access($_SESSION['mission']['IdMission']);
}

  updateConnectedUser();

  updateConnectedUserMission();
?>