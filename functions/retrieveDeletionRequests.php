<?php

function retrieveDeletionRequests($subsystems,$data){

  
  
try{
    
  require("connection.php");


  foreach($subsystems as $subsystem){
    $sql = "SELECT * FROM elements WHERE IdSubsystem = ".$subsystem['IdSubsystem']." AND Deletion = TRUE";

    $query_data = $base->prepare($sql);

    $query_data->execute();

    //$deleting_elements=[];
    if($query_data->rowCount()){
      $deleting_elements[$subsystem['Subsystem']] = $query_data->fetchAll(PDO::FETCH_ASSOC);
    }
  }
  //print_r($deleting_elements);

  foreach($data as $IdSubsystem=>$elements){ 
    foreach($elements as $element){
      $sql = "SELECT * FROM variables WHERE IdElement = ".$element['IdElement']." AND Deletion = TRUE";
    
      $query_data = $base->prepare($sql);
    
      $query_data->execute();

      if($query_data->rowCount()){
        $deleting_variables[$element['IdElement']]['variables'] = $query_data->fetchAll(PDO::FETCH_ASSOC);
        $deleting_variables[$element['IdElement']]['subsystem'] = $subsystems[$IdSubsystem]['Subsystem'];
        $deleting_variables[$element['IdElement']]['element'] = $element['Element'];
        $deleting_variables[$element['IdElement']]['IdElement'] = $element['IdElement'];
      }

    }
    
  }



}catch(Exception $e){

  die("Error: ".$e->getMessage());


}finally{
  //echo "ERASING BASE";
  $base=NULL;
}

if(isset($deleting_elements)&&isset($deleting_variables)){
  return([$deleting_elements,$deleting_variables]);
}elseif(isset($deleting_elements)){
  return([$deleting_elements,""]);
}elseif(isset($deleting_variables)){
  //print_r($deleting_variables);
  return(["",$deleting_variables]);
}


}

?>