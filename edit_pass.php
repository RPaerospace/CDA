<?php

require_once('config_mission.php');

require_once('functions/retrieveUsers.php');



if(isset($_POST["Pass"]) && isset($_POST["NewPass"]) && $_POST["NewPass"]==$_POST["NewPassC"] ){



//Create user
try{

    require("connection.php");

    $sql = "UPDATE users SET Pass = :pass WHERE IdUser = :id AND Pass = :oldpass";

    $query_result = $base->prepare($sql);

    $query_result->bindValue(":oldpass", $_POST["Pass"]);
    $query_result->bindValue(":pass", $_POST["NewPass"]);
    $query_result->bindValue(":id", $_SESSION['user']["IdUser"]);

    $query_result->execute();

    $query_success = $query_result->rowCount();

    if($query_success){

        $_SESSION["user"]['Last']=date('Y-m-d H:i:s');
        
        header("location:main.php?pass=auth");

        die;

    }else{

        header("location:main.php?passer=auth");
        

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


header("location:main.php?passer=auth");





?>