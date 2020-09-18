<?php


require_once('config_mission.php');

require_once('functions/retrieveUsers.php');



if(isset($_POST["User"]) && $_POST["User"]!=$_SESSION['user']["User"] ){

    //Check if user already exists
    $users = retrieveUsers()->fetchAll(PDO::FETCH_COLUMN);


if(in_array($_POST["User"],$users)){

    header("location:main.php?usr=failed");

    die;
}

//Create user
try{

    require("connection.php");

    $sql = "UPDATE users SET User = :login WHERE IdUser = :id";

    $query_result = $base->prepare($sql);

    $query_result->bindValue(":login", $_POST["User"]);
    $query_result->bindValue(":id", $_SESSION['user']["IdUser"]);

    $query_result->execute();

    $query_success = $query_result->rowCount();

    if($query_success){

        $_SESSION["user"]['User']=$_POST["User"];
        $_SESSION["user"]['Last']=date('Y-m-d H:i:s');
        
        header("location:main.php");

        die;

    }else{

        echo "Connection failed to database.<br>";
        

        //header("location:index.php");

        
        die;
    }

}catch(Exception $e){

    die("Error: ".$e->getMessage());


}finally{
    //echo "ERASING BASE";
    $base=NULL;
}





}


header("location:main.php?usr=failed");




?>