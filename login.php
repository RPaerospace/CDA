<?php

try{

    require("connection.php");

    $sql = "SELECT IdUser,User,Creation,Last FROM users WHERE User= :login AND Pass= :password";

    $query_result = $base->prepare($sql);

    $req_user = htmlentities(addslashes($_POST["user_field"]));
    $req_pass = htmlentities(addslashes($_POST["password_field"]));

    $query_result->bindValue(":login", $req_user);
    $query_result->bindValue(":password", $req_pass);

    $query_result->execute();

    $query_success = $query_result->rowCount();

    if($query_success){
        //STARTS SESSION

        session_start();
        $_SESSION["user"]=$query_result->fetch(PDO::FETCH_ASSOC);
        //print_r($_SESSION['user']);
        header("location:./main.php");


    }


}catch(Exception $e){

    die("Error: ".$e->getMessage());


}finally{
    //echo "ERASING BASE";
    $base=NULL;
}

header("location:index.php?auth=failed");



?>