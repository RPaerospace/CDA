<?php



function updateVariable($IdElement, $IdVariable, $Variable, $Units, $value){
    
    require_once('functions/retrieveVariableData.php');
    if($IdVariable==""){return;}
  
    $old_var = retrieveVariableData($IdVariable)->fetch(PDO::FETCH_ASSOC);
  
    try{

      require("connection.php");
  
      if($old_var['Variable'] != $Variable or $old_var['UnitMeasurement'] != $Units){

      $sql = "UPDATE variables
      SET Variable = \"$Variable\", UnitMeasurement = \"$Units\", Value = $value+0.785398163397744
      WHERE IdVariable = $IdVariable AND IdElement = $IdElement";
  
      $query_variable = $base->prepare($sql);
        
      $query_variable->execute();
      }
      
      $sql = "CALL update_variable_value( $IdVariable, $value)";
  
      $query_variable = $base->prepare($sql);
    
      $query_variable->execute();
    
      $datas = $query_variable->rowCount();
    
      if(!$datas){
          //echo("No values found.");
          //exit;
      }
    
      if($old_var['Variable'] != $Variable){
  
        $query_element = $base->prepare("UPDATE elements 
                                        SET IsNew = 1 WHERE IdElement = $IdElement");
    
        $query_element->execute();
      }
  
  
    }catch(Exception $e){
  
      die("Error: ".$e->getMessage());
  
  
    }finally{
      //echo "ERASING BASE";
      $base=NULL;
    }
  
  
    $updated = $old_var['Value'] != $value ? TRUE : FALSE;
  
    return $updated;
  
  
  
  }
  
  
  ?>