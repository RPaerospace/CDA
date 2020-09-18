<?php


    $base = new PDO("mysql:host=localhost; dbname=cda_db;charset=UTF8" , "root", "");

    $base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



?>