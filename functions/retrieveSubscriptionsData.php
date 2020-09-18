<?php


function retrieveSubscriptionsData($IdSubsystem){

if($IdSubsystem==""){return;}

try{
  
  
  require("connection.php");

  $sql = "SELECT * FROM subscriptions WHERE IdSubsystem = ".$IdSubsystem;

  $query_variable = $base->prepare($sql);

  $query_variable->execute();

  $datas = $query_variable->rowCount();
  
  if(!$datas){
    //echo "No subscriptions";
    return NULL;
  }

  
}catch(Exception $e){

  die("Error: ".$e->getMessage());


}finally{
  //echo "ERASING BASE";
  $base=NULL;
}


while($sub = $query_variable->fetch(PDO::FETCH_ASSOC)){

    $var = retrieveVariableData($sub['IdVariable'])->fetch(PDO::FETCH_ASSOC);
    $ele_query = retrieveElementData($var['IdElement']);
    $ele = $ele_query->fetch(PDO::FETCH_ASSOC);
        

    //CREATE ARRAY OF SUBSCRIPTIONS  $subscriptions[IdSubsystem][IdElement] = [IdVariable1, IdVariable2, ...]
    if(!isset($subscriptions) or !array_key_exists($ele['IdSubsystem'],$subscriptions) ){
        $subscriptions[$ele['IdSubsystem']]=[$var['IdElement']=>[$sub['IdVariable']]];
    }elseif(!array_key_exists($var['IdElement'],$subscriptions[$ele['IdSubsystem']])){
        $subscriptions[$ele['IdSubsystem']][$var['IdElement']]=[$sub['IdVariable']];
    }elseif(array_key_exists($var['IdElement'],$subscriptions[$ele['IdSubsystem']])){
        array_push($subscriptions[$ele['IdSubsystem']][$var['IdElement']],$sub['IdVariable']);
    }




}


if(!isset($subscriptions)){
    //echo "No subscriptions";
    return NULL;
}



return $subscriptions;

}


?>