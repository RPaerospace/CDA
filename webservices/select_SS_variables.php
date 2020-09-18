<?php
if(!isset($_POST['IdSubsystem']) or !isset($_POST['User']) or !isset($_POST['Pass'])){
    die;
}


try{
      
      
    require("../connection.php");

    $sql = "CALL select_SS_variables(  ". $_POST['IdSubsystem'] .",'". $_POST['User'] ."','". $_POST['Pass'] ."'  );";

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
 echo json_encode($query_element->fetchAll(PDO::FETCH_ASSOC) );

exit;



?>