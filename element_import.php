<?php

require_once('config_mission.php');

require_once('functions/retrieveElementsDatabase.php');
require_once('functions/obtain_subsystems.php');
require_once('functions/retrieveVarsElementData.php');
require_once('functions/retrieveSubsystemName.php');
require_once('functions/importElement.php');
//Returns all $subsystems, $data and descriptions

[$subsystems, $data, $subsystem_descriptions] = obtain_subsystems();

unset($_POST["zero_config_length"]);
foreach($_POST as $name=>$id){
    $IdNewElement = importElement($_GET['IdSubsystem'],$id);
}
if(isset($id)){
  header("Location:subsystem_main.php?IdSubsystem=".$_GET['IdSubsystem']."&col=".$IdNewElement."&imp=auth");
  die;
}


?>






                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="padding:0.5rem;padding-right:30px">Element Id</th>
                                                <th style="padding:0.5rem;padding-right:30px">Subsystem</th>
                                                <th style="padding:0.5rem;padding-right:30px">List</th>
                                                <th style="padding:0.5rem;padding-right:30px">Element</th>
                                                <th style="padding:0.5rem;padding-right:30px">Variables</th>
                                                <th style="padding:0.5rem;padding-right:30px">Description</th>
                                                <th style="padding:0.5rem;padding-right:30px">Import</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $elementsDatabase = retrieveElementsDatabase();

                                            $i=0;
                                            foreach($elementsDatabase as $IdElement => $ElementData){
                                            
                                              $i++;
                                                ?>
                                                <tr>
                                                    <td style="padding:0.5rem"><?php echo $IdElement ?></td>
                                                    <td style="padding:0.5rem"><?php echo $ElementData['Subsystem'] ?></td>
                                                    <td style="padding:0.5rem"><?php echo $ElementData['List'] ?></td>
                                                    <td style="padding:0.5rem"><?php echo $ElementData['Element'] ?></td>
                                                    <?php 
                                                    foreach($ElementData['Variables'] as $id=>$var){
                                                        $variables[$id] = $var['Variable'];
                                                    } ?>
                                                    <td style="padding:0.5rem"><?php echo implode(", ",$variables) ?></td>
                                                    <td style="padding:0.5rem"><?php echo $ElementData['Description'] ?></td>
                                                    <td style="padding:0.5rem"><?php echo "<input type='checkbox' name=\"import_$i\" value='$IdElement'>" ?></td>
                                                </tr>
                                                <?php $variables = []; 
                                            } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th style="padding:0.5rem">Element Id</th>
                                                <th style="padding:0.5rem">Subsystem</th>
                                                <th style="padding:0.5rem">List</th>
                                                <th style="padding:0.5rem">Element</th>
                                                <th style="padding:0.5rem">Variables</th>
                                                <th style="padding:0.5rem">Description</th>
                                                <th style="padding:0.5rem">Import</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>


    <script src="./assets/extra-libs/multicheck/datatable-checkbox-init.js"></script>
    <script src="./assets/extra-libs/multicheck/jquery.multicheck.js"></script>
    <script src="./assets/extra-libs/DataTables/datatables.min.js"></script>

    <script>
        /****************************************
         *       Basic Table                   *
         ****************************************/
        $('#zero_config').DataTable();
    </script>
    