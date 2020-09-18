<?php
function obtain_subsystems($IdSubsystem = NULL){
    require_once('functions/retrieveSubsystemData.php');
    try{
        
        require("connection.php");

        $sql = "SELECT * FROM subsystems WHERE IdMission = ".$_SESSION['mission']['IdMission'];//." AND IdUser = ".$_SESSION['user']['IdUser']

        if(isset($IdSubsystem)){
            $sql.= " AND IdSubsystem = $IdSubsystem";
        }
        $query_result = $base->prepare($sql);
        
        $query_result->execute();

        while($subsystem = $query_result->fetch(PDO::FETCH_ASSOC)){
            $subsystems[$subsystem['IdSubsystem']] = $subsystem;
        }
        
        



        $sql = "SELECT * FROM usermission WHERE IdMission = ".$_SESSION['mission']['IdMission']." AND IdUser = ".$_SESSION['user']['IdUser'];

        $query_result = $base->prepare($sql);

        $query_result->execute();


        if(!$query_result->rowCount()){
            header("Location:index.php");
            
        die;
        }

        // if(isset($_GET['IdSubsystem'])&&$_GET['IdSubsystem']){
        //     $sql = "SELECT * FROM subsystems WHERE IdSubsystem = ".$_GET['IdSubsystem']." AND IdUser = ".$_SESSION['user']['IdUser'];

        //     $query_result = $base->prepare($sql);

        //     $query_result->execute();

        //     if(!$query_result->rowCount()){
        //         header("Location:index.php");
                
        //         die;
        //     }
        // }

    }catch(Exception $e){
    
        die("Error: ".$e->getMessage());
    
    
    }finally{
        $base=NULL;
    }
    
    //CREATE $data and $subsystem_descriptions

    $i=0;
    if(isset($subsystems)){
    foreach($subsystems as $id=>$subsystem){
        $i++;
        $data[$subsystem['IdSubsystem']] = retrieveSubsystemData($subsystem['IdSubsystem'])->fetchAll(PDO::FETCH_ASSOC);
        $subsystem_descriptions[$subsystem['IdSubsystem']] = $subsystem['Description'];
    }
    }else{
        return [[],[],[]];
    }

    return [$subsystems, $data, $subsystem_descriptions];

}

?>