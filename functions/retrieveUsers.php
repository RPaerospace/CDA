<?php

//INPUT: user ID (optional)
//OUTPUT: query (dictionary): [User,IdUser] of input ID, or every user if user ID not provided

function retrieveUsers($user_id = NULL){


    try{
        require("connection.php");

        //Retrieveing user(s) name(s)

        $sql = "SELECT User,IdUser FROM users";

        if(isset($user_id)){$sql = $sql . " WHERE IdUser = $user_id";}

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

    return $query_users;

}

?>

