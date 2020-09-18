<?php
if(!isset($_POST['jsonvars']) or !isset($_POST['User']) or !isset($_POST['Pass'])){
    die;
}

$vars = json_decode($_POST['jsonvars']);
try{
      
      
    require("../connection.php");

    $sql = "CALL update_variable_value(  ".$vars[0]."  ,  ".$vars[1]." );";

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
 //echo json_encode($query_element->fetchAll(PDO::FETCH_ASSOC) );
echo $sql;
exit;



?>