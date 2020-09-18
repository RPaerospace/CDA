<?php

require_once('config_mission.php');

//checkElement($_GET['IdElement']);



try{

    require("connection.php");

    $IdElement = $_GET['IdElement'];
    
    $query_element = $base->prepare("SELECT * FROM elements WHERE IdElement = $IdElement"); 
    
    $query_element->execute();
    $element= $query_element->fetch(PDO::FETCH_ASSOC);

    
    //Copy ELEMENT into TABLE

    $copy_element =  $base->prepare("INSERT INTO elements (Element, Description, List, IdSubsystem, IsNew)
        VALUES ('".$element['Element']."' ,'".$element['Description']."', '".$element['List']."' ,".$element['IdSubsystem'].", 0)");

    $copy_element->execute();

    $IdNewElement = $base->lastInsertId();
    
    $string = date('Y-m-d H:i:s')."  Element $IdNewElement,'".$element['Element']."' COPIED from element $IdElement by ".$_SESSION['user']['IdUser'].",".$_SESSION['user']['User']."\n";
    file_put_contents("logs/".$_SESSION['mission']['IdMission'].".log", $string, FILE_APPEND);   

    $query_variables = $base->prepare("SELECT * FROM variables WHERE IdElement = $IdElement"); 

    $query_variables->execute();

    
    //Copy VARIABLE(S) into TABLE

    $copy_variables = $base->prepare("INSERT INTO variables (Variable,UnitMeasurement,Value,IdElement)
    VALUES (:variable, :description, :value, $IdNewElement)");

    $start_versions = $base->prepare("INSERT INTO variablesversions (IdVariable, Variable,UnitMeasurement,Value,IdElement, IssueVersion)
    VALUES (:id, :variable, :description, :value, $IdNewElement, ".$_SESSION['mission']['IssueVersion'].")");

    while($variable = $query_variables->fetch(PDO::FETCH_ASSOC)){


        $copy_variables->bindValue(":variable", $variable['Variable']);
        $copy_variables->bindValue(":description", $variable['UnitMeasurement']);
        $copy_variables->bindValue(":value", $variable['Value']);
        $copy_variables->execute();     
        
        $IdVariable =  $base->lastInsertId();

        $start_versions->bindValue(":id", $IdVariable);
        $start_versions->bindValue(":variable", $variable['Variable']);
        $start_versions->bindValue(":description", $variable['UnitMeasurement']);
        $start_versions->bindValue(":value", $variable['Value']);
        $start_versions->execute();     
        
        
        $string = date('Y-m-d H:i:s')."  Variable $IdNewElement,$IdVariable'".$variable['Variable']."' COPIED from other element by ".$_SESSION['user']['IdUser'].",".$_SESSION['user']['User'].". Value: ".$variable['Value']."\n";
        file_put_contents("logs/".$_SESSION['mission']['IdMission'].".log", $string, FILE_APPEND);   



    }


    header("Location:subsystem_main.php?IdSubsystem=".$_GET['IdSubsystem']."&col=".$IdNewElement."&copy=auth");

}catch(Exception $e){

        die("Error: ".$e->getMessage());


}finally{
      //echo "ERASING BASE";
       $base=NULL;
}






?>