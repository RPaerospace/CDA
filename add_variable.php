<?php

require_once('config_mission.php');


require_once('functions/checkElement.php');
require_once('functions/check_access_subsystem.php');

//Returns all $subsystems, $data and descriptions

// [$subsystems, $data, $subsystem_descriptions] = obtain_subsystems();



try{

    require("connection.php");

    if(!isset($_POST['IdElement'])){

        header("mission_main.php");
        die;
    }

    checkElement($_POST['IdElement']);
    $IdElement = $_POST['IdElement'];


        //Insert VARIABLE into TABLE version  and first VERSION entry into variablesversions
    

    $sql_variables = "INSERT INTO variables (Variable,UnitMeasurement,Value,IdElement)
    VALUES (:variable, :description, :value, $IdElement)";//        ON DUPLICATE KEY UPDATE variable= :variable IF NOT EXISTS(SELECT * FROM ".str_replace(' ', '_', $_POST['element_name'])." WHERE variable= :variable)

    $query_variables = $base->prepare($sql_variables); 
    


    $sql_versions = "INSERT INTO variablesversions (IdVariable,Variable,UnitMeasurement,Value,IdElement, VarVersion, IssueVersion)
    VALUES (:id, :variable, :description, :value, $IdElement, 1, ".$_SESSION['mission']['IssueVersion'].")";//        ON DUPLICATE KEY UPDATE variable= :variable IF NOT EXISTS(SELECT * FROM ".str_replace(' ', '_', $_POST['element_name'])." WHERE variable= :variable)

    $query_versions = $base->prepare($sql_versions); 

    

    
        $query_variables->bindValue(":variable", $_POST["Variable"]);
        $query_variables->bindValue(":description", $_POST["UnitMeasurement"]);
        $query_variables->bindValue(":value", $_POST["Value"]);
        $query_variables->execute();     
        
        $IdVariable =  $base->lastInsertId();

        $string = date('Y-m-d H:i:s')."  Variable $IdElement,$IdVariable,'".$_POST["Variable"]."' CREATED by ".$_SESSION['user']['IdUser'].",".$_SESSION['user']['User'].". Value: ".$_POST["Value"]."\n";
        file_put_contents("logs/".$_SESSION['mission']['IdMission'].".log", $string, FILE_APPEND);   


        $query_versions->bindValue(":id", $IdVariable);
        $query_versions->bindValue(":variable", $_POST["Variable"]);
        $query_versions->bindValue(":description", $_POST["UnitMeasurement"]);
        $query_versions->bindValue(":value", $_POST["Value"]);
        $query_versions->execute(); 



        if(isset($_POST['IdRequest'])){

            $sql_variables = "DELETE FROM reqvariables WHERE IdRequest = ". $_POST['IdRequest'];//        ON DUPLICATE KEY UPDATE variable= :variable IF NOT EXISTS(SELECT * FROM ".str_replace(' ', '_', $_POST['element_name'])." WHERE variable= :variable)
        
            $query_variables = $base->prepare($sql_variables); 
            
            $query_variables->execute();     
        

        }






    header("Location:subsystem_main.php?IdSubsystem=".$_GET['IdSubsystem']."&col=$IdElement"."&add_info=auth");


    }catch(Exception $e){

        die("Error: ".$e->getMessage());


   }finally{
      //echo "ERASING BASE";
       $base=NULL;
   }







?>