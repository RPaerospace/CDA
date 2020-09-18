<?php


require_once('functions/retrieveUsers.php');



if(isset($_POST["user_field"]) && $_POST["password_field"]==$_POST["passwordc_field"] ){

    //Check if user already exists
    $users = retrieveUsers()->fetchAll(PDO::FETCH_COLUMN);


if(in_array($_POST["user_field"],$users)){

    header("location:index.php?user=failed");

    die;
}

//Create user
try{

    require("connection.php");

    $sql = "INSERT INTO users (User,Pass) VALUES(:login,:password)";

    $query_result = $base->prepare($sql);

    $req_user = htmlentities(addslashes($_POST["user_field"]));
    $req_pass = htmlentities(addslashes($_POST["password_field"]));

    $query_result->bindValue(":login", $req_user);
    $query_result->bindValue(":password", $req_pass);

    $query_result->execute();

    $query_success = $query_result->rowCount();

    if($query_success){

        session_start();
        $_SESSION["user"]['IdUser']=$base->lastInsertId();;
        $_SESSION["user"]['User']=$req_user;
        $_SESSION["user"]['Creation']=date('Y-m-d H:i:s');
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


header("location:index.php?pass=failed");




?>