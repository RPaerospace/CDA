<?php

require_once('config_mission.php');

require_once('functions/check_access_subsystem.php');

check_access_subsystem($_GET['IdSubsystem']);

try{

    require("connection.php");

    //Head index if no form data
    if(!isset($_POST['Element'])){
        header("mission_main.php");
        die;
    }elseif(!isset($_POST['description'])){
        $_POST['description']='';
    }
    if(!isset($_POST['list_name'])){
        $_POST['list_name']='';
    }
    //Insert entry into elements table
    $sql_element="INSERT INTO elements (Element, Description, List, IdSubsystem)
        VALUES ('".$_POST['Element']."' ,'".$_POST['Description']."', '".$_POST['List']."' ,".$_GET['IdSubsystem'].")";
    
    $query_db = $base->prepare($sql_element);
    $query_db->execute();
    
    $IdElement =  $base->lastInsertId();
    $string = date('Y-m-d H:i:s')."  Element $IdElement,'".$_POST['Element']."' CREATED by ".$_SESSION['user']['IdUser'].",".$_SESSION['user']['User']."\n";
    file_put_contents("logs/".$_SESSION['mission']['IdMission'].".log", $string, FILE_APPEND);
    //Insert VARIABLE(S) into TABLE version  and first VERSION entry into variablesversions







    header("Location:subsystem_main.php?IdSubsystem=".$_GET['IdSubsystem']."&col=".$IdElement);


    }catch(Exception $e){

        die("Error: ".$e->getMessage());


   }finally{
      //echo "ERASING BASE";
       $base=NULL;
   }







?>