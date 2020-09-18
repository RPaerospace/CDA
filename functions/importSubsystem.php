<?php


function importSubsystem($IdMission, $IdSubsystem){

    try{
  
      require("connection.php");
      
      $query_ss = $base->prepare("SELECT * FROM subsystems WHERE IdSubsystem = $IdSubsystem"); 
      
      $query_ss->execute();
      $ss= $query_ss->fetch(PDO::FETCH_ASSOC);
  
      
      //Copy SS into TABLE
  
      $copy_ss =  $base->prepare("INSERT INTO subsystems (Subsystem, Description, IdMission, IdUser)
          VALUES ('".$ss['Subsystem']."' ,'".$ss['Description']."' ,$IdMission, ".$_SESSION['user']['IdUser'].")");
  
      $copy_ss->execute();
  
      $IdNewSS = $base->lastInsertId();
      
      $string = date('Y-m-d H:i:s')."  Subsystem $IdNewSS,'".$ss['Subsystem']."' IMPORTED to mission $IdMission,'".retrieveMissionName($IdMission)."' from Subsystem $IdSubsystem,'".$ss['Subsystem']."'\n";
      file_put_contents("logs/".$_SESSION['mission']['IdMission'].".log", $string, FILE_APPEND);   
  
      $query_elements = $base->prepare("SELECT * FROM elements WHERE IdSubsystem = $IdSubsystem"); 
  
      $query_elements->execute();
  
      
      //Copy VARIABLE(S) into TABLE
  
      $copy_elements = $base->prepare("INSERT INTO elements (Element, Description, List, IdSubsystem, IsNew)
      VALUES (:element, :description, :list ,$IdNewSS, 0)");
  
      while($element = $query_elements->fetch(PDO::FETCH_ASSOC)){
  
  
          $copy_elements->bindValue(":element", $element['Element']);
          $copy_elements->bindValue(":description", $element['Description']);
          $copy_elements->bindValue(":list", $element['List']);
          $copy_elements->execute();     
          
          $IdElement =  $base->lastInsertId();
  
          $string = date('Y-m-d H:i:s')."      Element $IdNewSS,$IdElement,'".$element['Element']."' IMPORTED to mission $IdMission,'".retrieveMissionName($IdMission)."'from subsystem $IdSubsystem,".$ss['Subsystem']."\n";
          file_put_contents("logs/".$_SESSION['mission']['IdMission'].".log", $string, FILE_APPEND);   
  
  
      $query_variables = $base->prepare("SELECT * FROM variables WHERE IdElement = ".$element['IdElement']); 
  
      $query_variables->execute();
  
      
      //Copy VARIABLE(S) into TABLE
  
      $copy_variables = $base->prepare("INSERT INTO variables (Variable,UnitMeasurement,Value,IdElement)
                                        VALUES (:variable, :description, :value, $IdElement)");
  

      $sql_versions = "INSERT INTO variablesversions (IdVariable,Variable,UnitMeasurement,Value,IdElement, VarVersion, IssueVersion)
      VALUES (:id, :variable, :description, :value, $IdElement, 1, ".$_SESSION['mission']['IssueVersion'].")";//        ON DUPLICATE KEY UPDATE variable= :variable IF NOT EXISTS(SELECT * FROM ".str_replace(' ', '_', $_POST['element_name'])." WHERE variable= :variable)

      $query_versions = $base->prepare($sql_versions); 

      while($variable = $query_variables->fetch(PDO::FETCH_ASSOC)){
  
  
          $copy_variables->bindValue(":variable", $variable['Variable']);
          $copy_variables->bindValue(":description", $variable['UnitMeasurement']);
          $copy_variables->bindValue(":value", $variable['Value']);
          $copy_variables->execute();     
          
          $IdVariable =  $base->lastInsertId();
  
          $string = date('Y-m-d H:i:s')."          Variable $IdElement,$IdVariable,'".$variable['Variable']."' IMPORTED to subsystem $IdNewSS,'".retrieveSubsystemName($IdNewSS)."'from Variable ".$element['IdElement'].",".$variable['IdVariable']."\n";
          file_put_contents("logs/".$_SESSION['mission']['IdMission'].".log", $string, FILE_APPEND);   
  
  
        $query_versions->bindValue(":id", $IdVariable);
        $query_versions->bindValue(":variable", $variable['Variable']);
        $query_versions->bindValue(":description", $variable["UnitMeasurement"]);
        $query_versions->bindValue(":value", $variable["Value"]);
        $query_versions->execute(); 


  
      }
  
  
  
      }
  
  
  
    }catch(Exception $e){
  
          die("Error: ".$e->getMessage());
  
  
    }finally{
        //echo "ERASING BASE";
         $base=NULL;
    }
  
  return $IdNewSS;
  }
  
?>  