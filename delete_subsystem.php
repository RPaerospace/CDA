<?php

require_once('functions/retrieveUsers.php');

//Verify logged user

session_start();

if(!isset($_SESSION["user"])){

    header("Location:index.php");

    die;
}

if(!isset($_GET['IdSubsystem']) or $_SESSION['user']['IdUser'] != $_SESSION['mission']['IdManager']){
    header("Location:main.php");
    die;
}



    






    


try{

    require("connection.php");


    $sql_subsystem = "SELECT * FROM subsystems 
    WHERE IdSubsystem = ".$_GET['IdSubsystem'];

    $query_subsystem = $base->prepare($sql_subsystem);

    $query_subsystem->execute();

    $subsystem_info = $query_subsystem->fetch(PDO::FETCH_ASSOC);
    

    if($_SESSION['user']['IdUser'] != $_SESSION['mission']['IdManager'] or $subsystem_info['IdMission'] != $_SESSION['mission']['IdMission']){
        //header("location:mission_main.php");
        
        die;
    }
    



    
    $sql_subsystems = "DELETE FROM subsystems 
    WHERE IdSubsystem = ".$_GET['IdSubsystem'];

    $query_subsystems = $base->prepare($sql_subsystems);

    $query_subsystems->execute();




    //CREATE LOG FILE
    $string = date('Y-m-d H:i:s')."  Subsystem ".$_GET['IdSubsystem'].",'".$subsystem_info['Subsystem']."' DELETED by manager.\n";// Subsystems appended:\n

        //$string = $string ."                     ". .",". implode(":",$subsystem_info) . "\n";

    file_put_contents("logs/".$subsystem_info['IdMission'].".log", $string, FILE_APPEND);


    //STORE in SESSION
/* 
    $mission_data = $base->prepare("SELECT * FROM missions WHERE IdMission = $IdMission");
    $mission_data->execute();
    $_SESSION['mission'] = $mission_data->fetch(PDO::FETCH_ASSOC);
 */
    header("Location: mission_main.php");
    
    


}catch(Exception $e){

         die("Error: ".$e->getMessage());


}finally{
       //ERASING BASE
        $base=NULL;
}




?>