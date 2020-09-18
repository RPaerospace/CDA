<?php
/////////////////////////
//Returns last date of connection of provided user ID for current mission SESSION (so SESSION['mission'] must be set)
function retrieveLastMissionConnection($IdUser){
  
  try{
    require("connection.php");

    //Retrieveing user(s) name(s)

    $sql = "SELECT LastDate FROM usermission WHERE IdUser = $IdUser AND IdMission = ".$_SESSION['mission']['IdMission'];

    $query_users = $base->prepare($sql);

    $query_users->execute();

    $users = $query_users->rowCount();

    if(!$users){
        //echo("Error connecting to database. No users found.");
    }



  }catch(Exception $e){

    die("Error: ".$e->getMessage());



  }finally{

    //ERASING BASE
    $base=NULL;
  }

  return $query_users->fetch(PDO::FETCH_ASSOC)['LastDate'];

}
//////////////////////

?>