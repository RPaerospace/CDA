<?php


require_once('config_mission.php');

// checkSystemsEngineer();


if($_SESSION['user']['IdUser'] == $_SESSION['mission']['IdManager']){

    try{
      
      
        require("connection.php");


        $sql_issue = "CALL StartIssue(?)";
    
        $query_issue = $base->prepare($sql_issue);
    
          
        $query_issue->execute([$_SESSION['mission']['IdMission']]);
    

        $sql_issue = "INSERT INTO issues (IdMission,Issue) VALUES (".$_SESSION['mission']['IdMission'].",".$_SESSION['mission']['IssueVersion']." +1 );";

        $query_issue = $base->prepare($sql_issue);
    
          
        $query_issue->execute();


    
        //Record in LOG
        
        $string = date('Y-m-d H:i:s')."  Mission ".$_SESSION['mission']['IdMission'].",'".$_SESSION['mission']['Mission']."' STARTED NEW ISSUE: v. ".($_SESSION['mission']['IssueVersion']+1).".\n";
    
    
        file_put_contents("logs/".$_SESSION['mission']['IdMission'].".log", $string, FILE_APPEND);   
        
      }catch(Exception $e){
    
        die("Error: ".$e->getMessage());
    
    
      }finally{
        //echo "ERASING BASE";
        $base=NULL;
      }
    

}
      

header("Location:mission_main.php?Issue=auth");

die;





?>