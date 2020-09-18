<?php

require_once('config_mission.php');

// checkSystemsEngineer();
require_once('functions/retrieveVarsElementData.php');


if($_SESSION['user']['IdUser'] == $_SESSION['mission']['IdManager']){

    try{
      
      
        require("connection.php");
    
        $sql_unsub = "DELETE FROM subscriptions WHERE IdVariable = ?";
    
        $query_unsub = $base->prepare($sql_unsub);
    
        if(isset($_GET['IdVariable'])){
          
          $query_unsub->execute([$_GET['IdVariable']]);
    
          $sql = "DELETE FROM variables WHERE IdVariable = ".$_GET['IdVariable'];
          
          $string = date('Y-m-d H:i:s')."  Variable ".$_GET['IdVariable']." DELETED by ".$_SESSION['user']['IdUser'].",".$_SESSION['user']['User'].".\n";
    
    
        }elseif(isset($_GET['IdElement'])){
    
          $vars = retrieveVarsElementData($_GET['IdElement']);
    
          while($var = $vars->fetch(PDO::FETCH_ASSOC)){
            $query_unsub->execute([$var['IdVariable']]);
          }
    
            $sql = "DELETE FROM elements WHERE IdElement = ".$_GET['IdElement'].";
                    DELETE FROM variables WHERE IdElement = ".$_GET['IdElement'];
    
            
          $string = date('Y-m-d H:i:s')."  Element ".$_GET['IdElement']." and contained variables DELETED by ".$_SESSION['user']['IdUser'].",".$_SESSION['user']['User'].".\n";
    
    
          
        }
    
        $query_element = $base->prepare($sql);
      
        $query_element->execute();
      
        $datas = $query_element->rowCount();
      
        if(!$datas){
            echo("No values found.");
            exit;
        }
    
        //Record in LOG
        file_put_contents("logs/".$_SESSION['mission']['IdMission'].".log", $string, FILE_APPEND);   
        
      }catch(Exception $e){
    
        die("Error: ".$e->getMessage());
    
    
      }finally{
        //echo "ERASING BASE";
        $base=NULL;
      }
    

}
      

header("Location:mission_main.php?Delete=auth");

die;
?>