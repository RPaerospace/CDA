<?php


function importElement($IdSubsystem, $IdElement){

    try{
  
      require("connection.php");
      
      $query_element = $base->prepare("SELECT * FROM elements WHERE IdElement = $IdElement"); 
      
      $query_element->execute();
      $element= $query_element->fetch(PDO::FETCH_ASSOC);
  
      
      //Copy ELEMENT into TABLE
  
      $copy_element =  $base->prepare("INSERT INTO elements (Element, Description, List, IdSubsystem, IsNew)
          VALUES ('".$element['Element']."' ,'".$element['Description']."', '".$element['List']."' ,$IdSubsystem, 0)");
  
      $copy_element->execute();
  
      $IdNewElement = $base->lastInsertId();
      
      $string = date('Y-m-d H:i:s')."  Element $IdNewElement,'".$element['Element']."' IMPORTED to subsystem $IdSubsystem,'".retrieveSubsystemName($IdSubsystem)."' from Element $IdElement,'".$element['Element']."'\n";
      file_put_contents("logs/".$_SESSION['mission']['IdMission'].".log", $string, FILE_APPEND);   
  
      $query_variables = $base->prepare("SELECT * FROM variables WHERE IdElement = $IdElement"); 
  
      $query_variables->execute();
  
      
      //Copy VARIABLE(S) into TABLE
  
      $copy_variables = $base->prepare("INSERT INTO variables (Variable,UnitMeasurement,Value,IdElement)
                                        VALUES (:variable, :description, :value, $IdNewElement)");
  
  $sql_versions = "INSERT INTO variablesversions (IdVariable,Variable,UnitMeasurement,Value,IdElement, VarVersion, IssueVersion)
  VALUES (:id, :variable, :description, :value, $IdNewElement, 1, ".$_SESSION['mission']['IssueVersion'].")";//        ON DUPLICATE KEY UPDATE variable= :variable IF NOT EXISTS(SELECT * FROM ".str_replace(' ', '_', $_POST['element_name'])." WHERE variable= :variable)

  $query_versions = $base->prepare($sql_versions); 

  
      while($variable = $query_variables->fetch(PDO::FETCH_ASSOC)){
  
  
          $copy_variables->bindValue(":variable", $variable['Variable']);
          $copy_variables->bindValue(":description", $variable['UnitMeasurement']);
          $copy_variables->bindValue(":value", $variable['Value']);
          $copy_variables->execute();     
          
          $IdVariable =  $base->lastInsertId();
  
          $string = date('Y-m-d H:i:s')."  Variable $IdNewElement,$IdVariable,'".$variable['Variable']."' IMPORTED to subsystem $IdSubsystem,'".retrieveSubsystemName($IdSubsystem)."'from Variable $IdElement,".$variable['IdVariable']."\n";
          file_put_contents("logs/".$_SESSION['mission']['IdMission'].".log", $string, FILE_APPEND);   
  
  

          $sql_versions = "INSERT INTO variablesversions (IdVariable,Variable,UnitMeasurement,Value,IdElement, VarVersion, IssueVersion)
          VALUES (:id, :variable, :description, :value, $IdNewElement, 1, ".$_SESSION['mission']['IssueVersion'].")";//        ON DUPLICATE KEY UPDATE variable= :variable IF NOT EXISTS(SELECT * FROM ".str_replace(' ', '_', $_POST['element_name'])." WHERE variable= :variable)
      
          $query_versions = $base->prepare($sql_versions); 
      
          

          $query_versions->bindValue(":id", $IdVariable);
          $query_versions->bindValue(":variable", $variable["Variable"]);
          $query_versions->bindValue(":description", $variable["UnitMeasurement"]);
          $query_versions->bindValue(":value", $variable["Value"]);
          $query_versions->execute(); 


  
      }
  
  
  
    }catch(Exception $e){
  
          die("Error: ".$e->getMessage());
  
  
    }finally{
        //echo "ERASING BASE";
         $base=NULL;
    }
  
  return $IdNewElement;
  }
  
?>  