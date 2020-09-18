<?php
if(!isset($_POST['IdVariable'])){
    die;
}


try{
      
      
    require("../connection.php");

    $sql = "SELECT * FROM variables WHERE IdVariable = ". $_POST['IdVariable'] ." ;";

    $query_element = $base->prepare($sql);
  
    $query_element->execute();
  
    $datas = $query_element->rowCount();
  
    // if(!$datas){
    //     echo("No values found.");
    //     //exit;
    // }
  
    
  }catch(Exception $e){

    die("Error: ".$e->getMessage());


  }finally{
    //echo "ERASING BASE";
    $base=NULL;
  }
 echo json_encode($query_element->fetch(PDO::FETCH_ASSOC) );

exit;



?>