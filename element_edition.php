
<?php
session_start();


require_once('functions/checkElement.php');
require_once('functions/check_access_subsystem.php');

require_once('functions/obtain_subsystems.php');

[$subsystems, $data, $subsystem_descriptions] = obtain_subsystems();


function retrieveElementData($IdElement){

    if($IdElement==""){return;}
  
    try{
      
      
      require("connection.php");
  
      $sql = "SELECT * FROM elements WHERE IdElement = ".$IdElement;
  
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

checkElement($_POST['IdElement']);
$element = retrieveElementData($_POST['IdElement'])->fetch();

?>

<input type="hidden" name="IdElement" value="<?php echo $element['IdElement'] ?>">

<div class="card-body">
    <div class="form-group row">
        <label for="List" class="col-sm-3 text-right control-label col-form-label" >List</label>
        <div class="col-sm-9">
            <input name="List" list='lists' type="text" class="form-control" placeholder="New or existing list here" value="<?php echo $element['List'] ?>">
        </div>
    </div><div class="form-group row">
        <label for="Element" class="col-sm-3 text-right control-label col-form-label">Element Name</label>
        <div class="col-sm-9">
            <input name="Element" type="text" class="form-control" placeholder="Element name Here" value="<?php echo $element['Element'] ?>" required>
        </div>
    </div><div class="form-group row">
        <label for="desc" class="col-sm-3 text-right control-label col-form-label">Description</label>
        <div class="col-sm-9">
            <textarea name='Description' id="desc" placeholder="Description of element" class="form-control"><?php echo $element['Description'] ?></textarea>
        </div>
    </div>
</div>

