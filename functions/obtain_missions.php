<?php
//Returns array [Mission ID] => [ array:[1:[mission info],2:[subsystem 1], 3:[subsystem 2], ...] ] for which session user has access (mission and subsystems)
function obtain_missions(){

    try{

        require("connection.php");


        $sql = "SELECT IdMission FROM usermission WHERE IdUser= :login ORDER BY LastDate DESC";

        $query_result = $base->prepare($sql);

        $query_result->bindValue(":login", $_SESSION['user']['IdUser']);

        $query_result->execute();

        $query_success = $query_result->rowCount();

        if($query_success){

            while($mission_id=$query_result->fetch(PDO::FETCH_ASSOC)){
                
                $missions_info[$mission_id['IdMission']] = obtain_mission_info($mission_id['IdMission']);//['IdMission']

            }
        }else{

            $missions_info='';
        }

    }catch(Exception $e){

        die("Error: ".$e->getMessage());


    }finally{

        //ERASING BASE;
        $base=NULL;
    }

    return $missions_info;

}


//Returns array: [1:[mission info],2:[subsystem 1], 3:[subsystem 2], ...] of provided mission ID for subsystems to which user has access
function obtain_mission_info($mission_id){

    try{
      require('connection.php');
  
      $sql = "SELECT * FROM missions WHERE IdMission= :mission";
  
      $query_mission = $base->prepare($sql);
  
      $query_mission->bindValue(":mission", $mission_id);
  
      $query_mission->execute();
  
      $query_mission_success = $query_mission->rowCount();
  
      if($query_mission_success){
          
          $mission_entry = $query_mission->fetchAll(PDO::FETCH_ASSOC)[0];
          
          $sql_subsystem = "SELECT * FROM subsystems WHERE IdMission = " . $mission_entry['IdMission'];// . " AND IdUser = " . $_SESSION['user']['IdUser']
  
          $query_subsystems = $base->prepare($sql_subsystem);
  
          $query_subsystems->execute();
  
      }else{
  
          echo "Fatal error: Available mission with no subsystem(s) asigned.";
  
      }
  
    }catch(Exception $e){
  
      die("Error: ".$e->getMessage());
    }finally{
  
      //ERASING BASE
      $base=NULL;
    }
  
  
  
      return [$mission_entry, $query_subsystems->fetchAll(PDO::FETCH_ASSOC)];
  
  }
  
?>