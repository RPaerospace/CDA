<?php

session_start();


function retrieveVariableHistory($IdVariable){

try{
  require("../connection.php");
  
  $variable_history = $base->prepare("SELECT * FROM variablesversions WHERE IdVariable = $IdVariable ORDER BY VarVersion DESC");
  $variable_history->execute();

  return $variable_history;



}catch(Exception $e){

    die("Error: ".$e->getMessage());



}finally{

    //ERASING BASE
    $base=NULL;
}


}

function retrieveVariableData($IdVariable){

    if($IdVariable==""){return;}
  
    try{
      
      
      require("../connection.php");
  
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
$history = retrieveVariableHistory($_POST['IdVariable'])->fetchAll(PDO::FETCH_ASSOC);

?>
        
    <div class="table-responsive" style="overflow-y:auto;height:20vh">
    <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="p-1" scope="col">Restore</th>
                    <th class="p-1" scope="col">Version</th>
                    <th class="p-1" scope="col">Issue</th>
                    <th class="p-1" scope="col">Name</th>
                    <th class="p-1" scope="col">Units</th>
                    <th class="p-1" scope="col">Value</th>
                    <th class="p-1" scope="col">Timestamp</th>
                </tr>
            </thead>
            <tbody class="customtable">
            <input type="hidden" name="IdVariable" value="<?php echo $variable['IdVariable'] ?>">
            <input type="hidden" name="IdElement" value="<?php echo $variable['IdElement'] ?>">
            <?php 
            foreach($history as $var){ ?>
                <tr>
                    <th class="p-1">
                        <div class="custom-control custom-radio">
                            <input style="vertical-align:middle" type="radio" name="select" value="<?php echo $var['VarVersion']; ?>" required <?php if(isset($_GET['sub'])){echo "disabled";} ?>>
                        </div>
                    </th>
                    <td class="p-1"><?php echo $var['VarVersion']; ?></td>
                    <td class="p-1"><?php echo $var['IssueVersion']; ?></td>
                    <td class="p-1"><?php echo $var['Variable']; ?></td>
                    <td class="p-1"><?php echo $var['UnitMeasurement']; ?></td>
                    <td class="p-1"><?php echo $var['Value']; ?></td>
                    <td class="p-1"><?php echo $var['Timestamp']; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <h5 class="card-title">Variable evolution</h5>
    <div class="flot-chart" style="width:100%; text-align:-webkit-center;height:20vh">
        <div class="flot-chart-content" id="history_chart"  style="position: relative; height:20vh; width:950px"></div>
    </div><br>
<h5 class="card-title">History log:</h5>








<?php 
$file = "../logs/".$_SESSION['mission']['IdMission'].".log";
$searchfor = $variable['IdElement'].",".$variable['IdVariable'];
// the following line prevents the browser from parsing this as HTML.
//header('Content-Type: text/plain');
// get the file contents, assuming the file to be readable (and exist)
$contents = file_get_contents($file);
// escape special characters in the query
$pattern = preg_quote($searchfor, '/');
// finalise the regular expression, matching the whole line
$pattern = "/^.*$pattern.*\$/m";
// search, and store all matching occurences in $matches
/* if(preg_match_all($pattern, $contents, $matches)){
    //echo "Found matches:\n";
    echo implode("<br>", $matches[0]);
}else{
    echo "No matches found";
} */


echo'
    <pre style="height:20vh; margin:1.25rem; overflow-y: scroll; word-wrap: break-word; white-space: pre-wrap;">'; 
        if(preg_match_all($pattern, $contents, $matches)){
            //echo "Found matches:\n";
            echo implode("<br>", $matches[0]);
        }else{
            echo "No entries in log found.";
        } 
        echo '
    </pre>'; ?>
    
<script>
var vals = [<?php foreach($history as $var){ echo "[".$var['VarVersion'].",".$var['Value']."],";} ?>];
vals.reverse();
plot_history(vals);

</script>