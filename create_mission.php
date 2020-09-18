<?php

//require_once('functions/retrieveUsers.php');

//Verify logged user

session_start();

if(!isset($_SESSION["user"])){

    header("Location:index.php");

    die;
}

if(!isset($_POST['name'])){
    header("Location:main.php");
    die;
}


/* 
$users = retrieveUsers();
for ($i=1;isset($_POST["manager_$i"]);$i++){

    if(!in_array($_POST["manager_$i"],$users)){
            echo("<h1 align='center'>Error: User '".$_POST["manager_$i"]."' doesn't exist.</h1><br>");
            $e=1;
    }

    $subsystem_manager[$_POST["subsystem_name_$i"]]=$_POST["manager_$i"];

}

if(isset($e)){

    echo("<form name='go_back' method='post' action='new_mission.php'> <button type='submit'>Go back</button>
    </form>");
    die;
}
 */

    








    


try{

    require("connection.php");


    


    //CREATE RECORD IN missions

    $sql_missionsdata = "INSERT INTO missions (Mission,description,IdManager)
    VALUES (:mission, :description, :admin)";

    $query_insert = $base->prepare($sql_missionsdata);  

    $query_insert->bindValue(":description", $_POST['description']);
    $query_insert->bindValue(":mission", $_POST['name']);
    $query_insert->bindValue(":admin", $_SESSION['user']['IdUser']);
    
    $query_insert->execute(); 

    $IdMission =  $base->lastInsertId();



    $sql_issue = "INSERT INTO issues (IdMission,Issue) VALUES (".$IdMission.",1  );";

    $query_issue = $base->prepare($sql_issue);

      
    $query_issue->execute();



    /* 
    $sql_subsystems = "INSERT INTO subsystems ( Subsystem, IdMission, Description, IdUser)
    VALUES (:subsystem, $IdMission, :description, :IdManager)";

    $query_subsystems = $base->prepare($sql_subsystems);
    

    $id_users = [];

    $i=1;

    
    foreach($subsystem_manager as $subs_name => $subs_manager){

        
        //$managers[$subs_name] =  $subs_manager;

        $IdManager = $base->prepare("SELECT IdUser FROM users WHERE User='$subs_manager'");
        $IdManager->execute();
        $IdManager = $IdManager->fetch()[0];
        
        
        $query_subsystems->bindValue(":subsystem", $subs_name);
        $query_subsystems->bindValue(":IdManager", $IdManager);
        $query_subsystems->bindValue(":description", $_POST["subsystem_description_$i"]);
        $i++;
        
        $query_subsystems->execute();

        $IdSubsystem[$base->lastInsertId()]=["'".$subs_name."'",$IdManager.",".$subs_manager];

        if(!in_array($IdManager,$id_users)){
            $insert_usermission = $base->prepare("INSERT INTO usermission ( IdUser, IdMission )
            VALUES ($IdManager, $IdMission)");
            $insert_usermission->execute();
    
            
            array_push($id_users,$IdManager);

        }
    } */

    //INSERT SYSTEM ENGINEER INTO usermission
    
    // if(!in_array($IdManager,$id_users)){
        $insert_usermission = $base->prepare("INSERT INTO usermission ( IdUser, IdMission )
            VALUES (".$_SESSION['user']['IdUser'].", $IdMission)");
        $insert_usermission->execute();
        //array_push($id_users,$IdManager);
    // }


    $dir = 'logs/';
   
    // create new directory with 744 permissions if it does not exist yet
    // owner will be the user/group the PHP script is run under
    if ( !file_exists($dir) ) {
        mkdir ($dir, 0744);
    }


    //CREATE LOG FILE
    $string = date('Y-m-d H:i:s')."  Mission $IdMission,'".$_POST['name']."' CREATED by ".$_SESSION['user']['IdUser'].",".$_SESSION['user']['User'].". Description: '".$_POST['description']."'.\n";// Subsystems appended:\n

    /* foreach($IdSubsystem as $Id => $subsystem_info){
        $string = $string ."                     ". $Id .",". implode(":",$subsystem_info) . "\n";
    } */

    file_put_contents("logs/"."$IdMission.log", $string, FILE_APPEND);


    //STORE in SESSION

    $mission_data = $base->prepare("SELECT * FROM missions WHERE IdMission = $IdMission");
    $mission_data->execute();
    $_SESSION['mission'] = $mission_data->fetch(PDO::FETCH_ASSOC);

    header("Location: mission_main.php");
    
    


}catch(Exception $e){

         die("Error: ".$e->getMessage());


}finally{
       //ERASING BASE
        $base=NULL;
}




?>