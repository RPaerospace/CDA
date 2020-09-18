<?php

require_once('config_mission.php');

require_once('functions/retrieveUsers.php');

require_once('functions/retrieveSubsystemsDatabase.php');
require_once('functions/obtain_subsystems.php');
require_once('functions/retrieveSubsystemData.php');
require_once('functions/retrieveMissionName.php');
require_once('functions/importSubsystem.php');
require_once('functions/retrieveSubsystemName.php');

//Returns all $subsystems, $data and descriptions

[$subsystems, $data, $subsystem_descriptions] = obtain_subsystems();


if(isset($_POST['IdSubsystem'])){

    $IdNewSS = importSubsystem($_SESSION['mission']['IdMission'],$_POST['IdSubsystem']);

  header("Location:mission_main.php?imp=auth");
  die;
}


?>






                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="padding:0.5rem;padding-right:30px">Subsystem Id</th>
                                                <th style="padding:0.5rem;padding-right:30px">Mission</th>
                                                <th style="padding:0.5rem;padding-right:30px">Subsystem</th>
                                                <th style="padding:0.5rem;padding-right:30px">Description</th>
                                                <th style="padding:0.5rem;padding-right:30px">Elements</th>
                                                <th style="padding:0.5rem;padding-right:30px">User</th>
                                                <th style="padding:0.5rem;padding-right:30px">Import</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $subsystemDatabase = retrieveSubsystemsDatabase();

                                            $i=0;
                                            foreach($subsystemDatabase as $IdSubsystem => $SubsystemData){
                                            
                                              $i++;
                                                ?>
                                                <tr>
                                                    <td style="padding:0.5rem"><?php echo $IdSubsystem ?></td>
                                                    <td style="padding:0.5rem"><?php echo $SubsystemData['Mission'] ?></td>
                                                    <td style="padding:0.5rem"><?php echo $SubsystemData['Subsystem'] ?></td>
                                                    <td style="padding:0.5rem"><?php echo $SubsystemData['Description'] ?></td>
                                                    <?php 
                                                    $j=0;
                                                    
                                                    foreach($SubsystemData['Elements'] as $id=>$ele){
                                                        $elements[$id] = $ele['Element'];
                                                        $j++;
                                                        if($j==10){break;}
                                                    } ?>
                                                    <td style="padding:0.5rem"><?php echo implode(", ",$elements) ?></td>
                                                    <td style="padding:0.5rem"><?php echo retrieveUsers($SubsystemData['IdUser'])->fetch()[0] ?></td>
                                                    <td style="padding:0.5rem"><div class="custom-control custom-radio">
                                                        <input style="vertical-align:middle" type="radio" name="IdSubsystem" value="<?php echo $IdSubsystem; ?>" required>
                                                    </div></td>
                                                </tr>
                                                <?php $elements = []; 
                                            } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Subsystem Id</th>
                                                <th>Mission</th>
                                                <th>Subsystem</th>
                                                <th>Description</th>
                                                <th>Elements</th>
                                                <th>User</th>
                                                <th>Import</th>
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
    