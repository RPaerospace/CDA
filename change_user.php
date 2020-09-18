<?php

require_once('functions/retrieveUsers.php');

//Verify logged user

session_start();

if(!isset($_SESSION["user"])){

    header("Location:index.php");

    die;
}

if(!isset($_POST['user']) or !isset($_POST['IdSubsystem']) or $_SESSION['user']['IdUser'] != $_SESSION['mission']['IdManager']){
    header("Location:main.php");
    die;
}



$users = retrieveUsers()->fetchAll(PDO::FETCH_COLUMN);

    if(!in_array($_POST['user'],$users)){
        header("location:mission_main.php?user=failed");
    
        die;
    }


    





    $IdMission = $_SESSION['mission']['IdMission'];
    


try{

    require("connection.php");


    




    
    $sql_subsystems = "UPDATE subsystems SET IdUser = :IdManager
    WHERE IdSubsystem = :IdSubsystem";

    $query_subsystems = $base->prepare($sql_subsystems);
    

    $id_users = [];


    
        
        //$managers[$subs_name] =  $subs_manager;

        $IdManager = $base->prepare("SELECT IdUser FROM users WHERE User='".$_POST['user']."'");
        $IdManager->execute();
        $IdManager = $IdManager->fetch()[0];
        
        
        $query_subsystems->bindValue(":IdSubsystem", $_POST['IdSubsystem']);
        $query_subsystems->bindValue(":IdManager", $IdManager);
        
        $query_subsystems->execute();

        //$IdSubsystem[$base->lastInsertId()]=["'".$subs_name."'",$IdManager.",".$subs_manager];

        //if(!in_array($IdManager,$id_users)){
            $insert_usermission = $base->prepare("INSERT INTO usermission ( IdUser, IdMission )
            VALUES ($IdManager, $IdMission)");
            $insert_usermission->execute();
    
            
            //array_push($id_users,$IdManager);

        //}

    //INSERT SYSTEM ENGINEER INTO usermission
    
    // if(!in_array($IdManager,$id_users)){
        // $insert_usermission = $base->prepare("INSERT INTO usermission ( IdUser, IdMission )
        //     VALUES (".$_SESSION['user']['IdUser'].", $IdMission)");
        // $insert_usermission->execute();
        //array_push($id_users,$IdManager);
    // }
    //$Id = $base->lastInsertId();


    //CREATE LOG FILE
    $string = date('Y-m-d H:i:s')."  Subsystem ".$_POST['IdSubsystem']." CHANGED USER to ".$IdManager.",".$_POST['user'].".\n";// Subsystems appended:\n

        //$string = $string ."                     ". .",". implode(":",$subsystem_info) . "\n";

    file_put_contents("logs/"."$IdMission.log", $string, FILE_APPEND);


    //STORE in SESSION
/* 
    $mission_data = $base->prepare("SELECT * FROM missions WHERE IdMission = $IdMission");
    $mission_data->execute();
    $_SESSION['mission'] = $mission_data->fetch(PDO::FETCH_ASSOC);
 */
    header("Location: mission_main.php?change_user=auth");
    
    


}catch(Exception $e){

         die("Error: ".$e->getMessage());


}finally{
       //ERASING BASE
        $base=NULL;
}




?>