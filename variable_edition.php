
<?php
session_start();


function retrieveVariableData($IdVariable){

    if($IdVariable==""){return;}
  
    try{
      
      
      require("connection.php");
  
      $sql = "SELECT * FROM variables WHERE IdVariable = ".$IdVariable;
  
      $query_element = $base->prepare($sql);
    
      $query_element->execute();
    
      $datas = $query_element->rowCount();
    
      if(!$datas){
          echo("No values found.");
          //exit;
      }
    
      
    }catch(Exception $e){
  
      die("Error: ".$e->getMessage());
  
  
    }finally{
      //echo "ERASING BASE";
      $base=NULL;
    }
  
    return $query_element;
  
  
}

$variable = retrieveVariableData($_POST['IdVariable'])->fetch();

?>

<input type="hidden" name="IdVariable" value="<?php echo $variable['IdVariable'] ?>">
<input type="hidden" name="IdElement" value="<?php echo $variable['IdElement'] ?>">

<div class="card-body">
    <div class="form-group row">
        <label for="Variable" class="col-sm-3 text-right control-label col-form-label" >Variable name</label>
        <div class="col-sm-9">
            <input name="Variable" type="text" class="form-control" placeholder="Variable Name Here" value="<?php echo $variable['Variable'] ?>" required>
        </div>
    </div><div class="form-group row">
        <label for="UnitMeasurement" class="col-sm-3 text-right control-label col-form-label">Measurement units</label>
        <div class="col-sm-9">
            <input name="UnitMeasurement" type="text" class="form-control" placeholder="Measurement units Here" value="<?php echo $variable['UnitMeasurement'] ?>">
        </div>
    </div><div class="form-group row">
        <label for="Value" class="col-sm-3 text-right control-label col-form-label">Value</label>
        <div class="col-sm-9">
            <input name="Value" type="number" step="any" class="form-control" placeholder="Value Here" value="<?php echo $variable['Value'] ?>" required>
        </div>
    </div>
</div>

