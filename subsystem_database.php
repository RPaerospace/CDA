<?php


require_once('config_mission.php');

require_once('functions/retrieveUsers.php');
require_once('functions/retrieveLastMissionConnection.php');
require_once('functions/retrieveDeletionRequests.php');
require_once('functions/retrieveVarsElementData.php');


if(!isset($_GET['IdSubsystem'])){
    
  header("Location:mission_main.php");

  die;
}


//Returns all $subsystems, $data and descriptions

require_once('functions/obtain_subsystems.php');

[$subsystems, $data, $subsystem_descriptions] = obtain_subsystems();

?>
<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./assets/images/favicon.png">
    <title>CDA web - Subsystem Database</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="./assets/libs/select2/dist/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/libs/jquery-minicolors/jquery.minicolors.css">
    <link rel="stylesheet" type="text/css" href="./assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/libs/quill/dist/quill.snow.css">
    <link href="./assets/libs/toastr/build/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="./assets/extra-libs/multicheck/multicheck.css">
    <link href="./assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="./dist/css/style.min.css" rel="stylesheet">
    <link href="./assets/libs/flot/css/float-chart.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style>
#toast-container > div {
    opacity:1;
}
</style>
<style>
/* width */
::-webkit-scrollbar {
  width: 5px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555; 
}
</style>
</head>

<body <?php if(isset($_GET['subs'])){echo 'onload="subs()"';} ?> <?php if(isset($_GET['req'])){echo 'onload="req()"';} ?>>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin5" style='position:fixed;top: 0;  width: 100%'>
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header" data-logobg="skin5">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="index.php" style='height:64px; padding:10px;font-size: xx-large;'>
                        <!-- Logo icon -->
                        <!-- <b class="logo-icon p-l-10" style="height: 85%;margin-bottom: 5%;margin-right: 40px;"> -->
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="./assets/images/logo-icon.png" alt="homepage" class="light-logo" style="height: 100%;"/>
                           
                        <!-- </b> -->
                        <!--End Logo icon -->
                         <!-- Logo text -->
                        <span class="logo-text" style="height: 100%;">
                             <!-- dark Logo text -->
                             <!-- <img src="./assets/images/logo-text.png" alt="homepage" class="light-logo" style="height: 95%;margin-bottom: 5%;" /> -->
                            <b> CDA<small>web</small></b>
                        </span>
                        <!-- Logo icon -->
                        <!-- <b class="logo-icon"> -->
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <!-- <img src="./assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->
                            
                        <!-- </b> -->
                        <!--End Logo icon -->
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                   
                    <ul class="navbar-nav float-left mr-auto">
                        <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                        <li class="nav-item d-none d-md-block"> 
                            <?php if(isset($_SESSION['mission'])){ ?>

                                <a class="nav-link waves-effect waves-light" href="mission_main.php" style="font-size: large;"><span class="fas fa-hdd"></span> <?php echo $_SESSION["mission"]["Mission"] ?></a>
                            <?php }?>
                            
                        
                        </li>
                        <!-- ==============================================================<a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a> -->
                        <!-- create new -->
                        <!-- ============================================================== -->
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <span class="d-none d-md-block">Create New <i class="fa fa-angle-down"></i></span>
                             <span class="d-block d-md-none"><i class="fa fa-plus"></i></span>   
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li> -->
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <!-- <li class="nav-item search-box"> <a class="nav-link waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                            <form class="app-search position-absolute">
                                <input type="text" class="form-control" placeholder="Search &amp; enter"> <a class="srh-btn"><i class="ti-close"></i></a>
                            </form>
                        </li> -->
                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell font-24"></i>
                            </a>
                             <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li> -->
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" id="chat_button" onclick="openChat()" aria-haspopup="true" aria-expanded="false"> <i class="font-24 mdi mdi-comment-processing"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown" id="chat" aria-labelledby="2" style="min-width:500px;max-height:80vh">
                                        <div class=""><div class="card-body" style="max-height:50vh">
                                <h4 class="card-title">Mission Chat</h4>
                                <div class="chat-box " id="chat_container" style="height:40vh;">
                                    <!--chat Row -->
                                    <ul class="chat-list" id="chat_history_">
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body border-top" style="max-height:30vh">
                                <div class="row">
                                    <div class="col-9">
                                        <div class="input-field m-t-0 m-b-0">
                                            <textarea id="chat_message_" name="chat_message_" placeholder="Type and enter" class="form-control border-0"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <a type="button" class="btn-circle btn-lg btn-cyan float-right text-white send_chat" id="send_chat" name="send_chat"><i class="fas fa-paper-plane"></i></a>
                                    </div>
                                </div>
                            </div>
                                        </div>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style='font-size:initial'><?php echo $_SESSION['user']['User']; ?> <span class="fas fa-angle-down"></span></a>
                            <div class="dropdown-menu dropdown-menu-right user-dd animated">
                                <p class='m-20'> User ID: <?php echo $_SESSION['user']['IdUser']; ?> </p>
                                <a class="dropdown-item" href="#" type="button" data-toggle="modal" data-target="#settings"><i class="ti-settings m-r-5 m-l-5"></i> Account Settings</a>

                                <a class="dropdown-item" href="#" type="button" data-toggle="modal" data-target="#about"><i class="fas fa-info " style="font-size:15px;margin-right:9px; margin-left:9px"></i> About...</a>


                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="destroy_session.php"><i class="fa fa-power-off m-r-5 m-l-5"></i> Log out</a>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- User profile and search -->
                        <!-- ============================================================== -->
                    </ul>
                </div>
            </nav>
        </header>
                                    <!-- Modal -->
                                    <div class="modal fade" id="settings" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
                                        <div class="modal-dialog" role="document ">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Account settings</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true ">&times;</span>
                                                    </button>
                                                </div>
                                                <form class="form-horizontal" action="edit_user.php" method="post">
                                                    <div class="modal-body">
                                                        <h6>Change user name</h6>
                                                        <div class="card-body" style="padding-bottom:0px">
                                                            <div class="form-group row">
                                                                <label for="usr" class="col-sm-3 text-right control-label col-form-label">User Name</label>
                                                                <div class="col-sm-9">
                                                                    <input name='User' type="text" class="form-control" id="usr" placeholder="New user name here" value="<?php echo $_SESSION['user']['User'] ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="display: -webkit-box; display: -ms-flexbox; display: flex; -webkit-box-align: center; -ms-flex-align: center; align-items: center; -webkit-box-pack: end;-ms-flex-pack: end;justify-content: flex-end;padding: 1rem;padding-top=0rem;border-bottom: 1px solid #e9ecef;">
                                                            <button type="submit" class="btn btn-primary" >Save changes</button>
                                                    </div>
                                                </form>
                                                <form class="form-horizontal" action="edit_pass.php" method="post">
                                                    <div class="modal-body">
                                                        <h6>Change password</h6>
                                                        <div class="card-body" style="padding-bottom:0px">
                                                            <div class="form-group row">
                                                                <label for="pss" class="col-sm-3 text-right control-label col-form-label">Current password</label>
                                                                <div class="col-sm-9">
                                                                    <input name='Pass' type="password" class="form-control" id="pss" placeholder="Old password" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="newpass" class="col-sm-3 text-right control-label col-form-label">New password</label>
                                                                <div class="col-sm-9">
                                                                    <input name='NewPass' type="password" class="form-control" id="newpass" placeholder="New password here" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label for="newpass" class="col-sm-3 text-right control-label col-form-label">Confirm new password</label>
                                                                <div class="col-sm-9">
                                                                    <input name='NewPassC' type="password" class="form-control" id="newpassc" placeholder="Confirm new password here" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="display: -webkit-box; display: -ms-flexbox; display: flex; -webkit-box-align: center; -ms-flex-align: center; align-items: center; -webkit-box-pack: end;-ms-flex-pack: end;justify-content: flex-end;padding: 1rem;padding-top=0rem;border-bottom: 1px solid #e9ecef;">
                                                            <button type="submit" class="btn btn-primary" >Change password</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="about" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
                                        <div class="modal-dialog" role="document ">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">About CDA web</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true ">&times;</span>
                                                    </button>
                                                </div>
                                                    <div class="modal-body bg-dark">
                                                        <div class="card-body" style="padding-bottom:0px">
                                                            <div class="text-center p-t-20 p-b-20">
                                                            <img src="./assets/images/logo.png" alt="logo" style='isplay: block; margin-left: auto; margin-right: auto; width: 100%;'/>
                                                                <p class="db" style="font-size: large;color: #fff;margin-bottom:50px;margin-top:50px"><b>CDA<small>web</small></b>, by Pablo Ruiz Royo.<br>June 2020</p>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <img src="./assets/images/logoidr.jpg" alt="logo" style='isplay: block; margin-left: auto; margin-right: auto; width: 100%;'/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin5" style="position:fixed;top: 0;">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" style="overflow: auto;">
                <!-- Sidebar navigation-->
                 <nav class="sidebar-nav">
                    <ul id="sidebarnav" class="p-t-30">
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="mission_main.php" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Mission Overview</span></a></li> <!-- ?IdMission=<?php //echo $_SESSION['mission']['IdMission']; ?> -->
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="charts.html" aria-expanded="false"><i class="fas fa-database"></i><span class="hide-menu">Mission Database</span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <?php
                                    foreach($subsystems as $subsystem){
                                        ?>
                                        <li class="sidebar-item"><a href="subsystem_database.php?IdSubsystem=<?php echo $subsystem['IdSubsystem'] ?>" class="sidebar-link"><i class="fas fa-hockey-puck"></i><span class="hide-menu"><?php echo $subsystem['Subsystem'] ?> </span></a></li>
                                        <?php
                                    }
                                ?>
                            </ul>
                        </li>
                        <?php
                            foreach($subsystems as $subsystem){
                                if($subsystem['IdUser']==$_SESSION['user']['IdUser']){
                                    ?>
                                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="subsystem_main.php?IdSubsystem=<?php echo $subsystem['IdSubsystem'] ?>" aria-expanded="false"><i class="mdi mdi-equal-box"></i><span class="hide-menu"><?php echo $subsystem['Subsystem'] ?></span></a></li>
                                    <?php
                                }
                            }
                        ?>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper" style='padding-top:64px;min-height:100vh;'>
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="page-breadcrumb" >
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title"><?php echo $subsystems[$_GET['IdSubsystem']]['Subsystem'] ?> Database <small>ID: <?php echo $_GET['IdSubsystem'] ?></small></h4>
                        
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                            <h5>Subsystem Overview</h5>
                            <b>User:</b> <?php echo retrieveUsers($subsystems[$_GET['IdSubsystem']]['IdUser'])->fetch()['User'] ?><br>
                            <b>User ID:</b> <?php echo $subsystems[$_GET['IdSubsystem']]['IdUser'] ?><br>
                            <b>Subsystem description:</b> <?php echo $subsystem_descriptions[$_GET['IdSubsystem']]?>
                            </div>
                        </div>
                        <div class="card">
                            <form class="form-horizontal" action="requestCreation.php?IdSubsystem=<?php echo $_GET['IdSubsystem']; ?>" method="POST">
                                <div class="card-body">
                                    <h5>Variable Request</h5>
                                    <div class="form-group row">
                                        <label  class="col-sm-3 text-right control-label col-form-label">Request from </label>
                                        <div class="col-md-9">
                                            <select class="select2 form-control custom-select select2-hidden-accessible" style="width: 100%; height:36px;" data-select2-id="1" name="IdSubsystem">
                                                <!-- <option>Select... </option> -->
                                                    <?php
                                                        foreach($subsystems as $subsystem){
                                                            if($subsystem['IdUser']==$_SESSION['user']['IdUser']){ ?>
                                                                <option value="<?php echo $subsystem['IdSubsystem'] ?>"><?php echo $subsystem['Subsystem'] ?></option> 
                                                                <?php
                                                            }
                                                        }
                                                    ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Variable Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" name='Variable' class="form-control" id="fname" placeholder="Variable Name Here">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Measurement Units</label>
                                        <div class="col-sm-9">
                                            <input type="text" name='UnitMeasurement' class="form-control" id="lname" placeholder="Units Here">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="desc" class="col-sm-3 text-right control-label col-form-label">Description</label>
                                        <div class="col-sm-9">
                                            <input type="text" name='Description' class="form-control" id="desc" placeholder="Description for Subsystem Manager">
                                        </div>
                                    </div>
                                    <div class="border-top">
                                        <div class="card-body">
                                            <button type="submit" class="btn btn-primary">Send Request</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6">
                    <form action="subscribe.php?IdSubsystem=<?php echo $_GET['IdSubsystem']; ?>" method="POST">
                        <div class="card">
                            <div class="card-body">
                                <h5>Subscriptions</h5>
                                <div class="form-group row">
                                    <label class="col-md-3 m-t-10">Subscribe from </label>
                                    <div class="col-md-9">
                                        <select class="select2 form-control custom-select select2-hidden-accessible" style="width: 100%; height:36px;" data-select2-id="1" name="IdSubsystem">
                                            <!-- <option>Select... </option> -->
                                                <?php
                                                    foreach($subsystems as $subsystem){
                                                        if($subsystem['IdUser']==$_SESSION['user']['IdUser']){ ?>

                                                            <option value="<?php echo $subsystem['IdSubsystem'] ?>"><?php echo $subsystem['Subsystem'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-info btn-block btn-sm m-t-10 float-right">
                                    Subscribe to checked variables
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">

                            <?php

                            $i=0;
                            $j=0;
                            //foreach($data as $IdSubsystem=>$rows){//DISPLAY ONE SUBSYSTEM
                                //echo "<h3 style='margin-bottom:0px;'><b>".$subsystems[$IdSubsystem]['Subsystem']." <small>Id: $IdSubsystem</small></b></h3>";
                                //echo $subsystem_descriptions[$IdSubsystem];
                                $rows = $data[$_GET['IdSubsystem']];
                                foreach($rows as $row){
                                    $j++;


                                    if(!isset($column_list)){//DISPLAY LIST OF SUBSYSTEMS

                                        ?>
                                        <div class='card'>
                                            <div class='card-body'>
                                                <h5><?php echo $row['List'] ?></h5>
                                            </div>
                                        <?php
                                    }elseif($column_list!=$row['List']){
                                        ?>
                                        </div>
                                            <div class='card'>
                                                <div class='card-body'>
                                                    <h5><?php echo $row['List'] ?></h5>
                                                </div>
                                        <?php

                                    }

                                    if(isset($row['Element'])&&$row['Element']!=NULL){//DISPLAY ELEMENT VARIABLES


                                        ?>
                                            <a class="card-header link border-top" data-toggle="collapse" data-parent="#accordian-4" href="#Toggle-<?php echo $j ?>" aria-expanded="true" aria-controls="Toggle-<?php echo $j ?>">
                                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                                <span><?php echo $row["Element"] ?><span style="float:right;text-align:right;">ID: <?php echo $row["IdElement"] ?></span></span>
                                            </a>
                                            <div id="Toggle-<?php echo $j ?>" class="collapse multi-collapse">

                                            <?php
                                            if(isset($row['Description'])&& $row['Description'] !=''){ ?>
                                                <div class="card-body p-b-0">
                                                    <?php echo $row['Description'] ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                            
                                            <div class="card-body widget-content">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" style="width:5%">Subscribe</th>
                                                                <th scope="col">Variable ID</th>
                                                                <th scope="col">Variable</th>
                                                                <th scope="col">Version</th>
                                                                <th scope="col">Units</th>
                                                                <th scope="col">Value</th>
                                                                <th class="p-1" style="text-align:center" scope="col">Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="customtable">
                                                
                                                
                                            <?php 
                                            $elementData = retrieveVarsElementData($row['IdElement']);

                                            $variables = $elementData->fetchAll(PDO::FETCH_ASSOC);

                                            foreach($variables as $variable){

                                                $i++;
                                                ?>
                                                    <tr title='<?php echo $variable["UnitMeasurement"] ?>'>
                                                    <th style='text-align:center'>
                                                        <label class='customcheckbox' style='text-align: center;'>
                                                            <input type='checkbox' class='listCheckbox' name="sub_<?php echo $i ?>" value='<?php echo $variable["IdVariable"] ?>'>
                                                            <span class='checkmark' style='text-align: center;'></span>
                                                        </label>
                                                    </th>
                                                        <td><?php echo $variable["IdVariable"] ?></td>
                                                        <td><?php echo $variable["Variable"] ?></td>
                                                        <td><?php echo $variable["VarVersion"] ?></td>
                                                        <td><?php echo $variable["UnitMeasurement"] ?></td>
                                                        <td><?php echo $variable["Value"] ?></td>
                                                        <td style="text-align:center; vertical-align:middle; padding:0px;">
                                                                                                <a href="#" data-toggle="modal" style="height:100%;vertical-align:middle" data-target="#Hist" onclick="history(<?php echo $variable['IdVariable']; ?>)" title="Variable history" >
                                                                                                    <!-- <a href="#" data-toggle="tooltip" data-placement="auto" data-boundary="viewport" title="" data-original-title="Variable history"> -->
                                                                                                        <i class="fas fa-history" style="height:100%;font-size:20px"></i>
                                                                                                    <!-- </a> -->
                                                                                                </a>
                                                    </tr>
                                                <?php
                                            }
                                            ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>



                                        <?php
                                        $column_list=$row['List'];

                                    }

                                    //echo "</table><hr>";
                                    //$column_list = NULL;
                                }
                                
                                //echo "</div></form><br><br><br><br><br><br><br>";

                            //}


                            ?>
                        </div>
                    </div>
                </div>
                
                    <!-- Modal -->
                    <div class="modal fade" id="Hist" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
                        <div class="modal-dialog" role="document " style="max-width:1000px;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Variable history</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true ">&times;</span>
                                    </button>
                                </div>
                                <form action="restore_variable.php?IdSubsystem=<?php echo $_GET['IdSubsystem'] ?>" method="post" style="width:100%">
                                    <div class="modal-body" id="variable_history" style="width:100%">
                                    </div>
                                    <!-- <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Restore variable</button>
                                    </div> -->
                                </form>
                            </div>
                        </div>
                    </div>
                <!-- <div class="row">
                    <div class="col-8">
                        <div class="card">
                        </div>
                    </div>  

                </div> -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </form>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <!-- <footer class="footer text-center">
                All Rights Reserved by Matrix-admin. Designed and Developed by <a href="https://wrappixel.com">WrapPixel</a>.
            </footer> -->
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="./assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="./assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="./assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="./assets/extra-libs/sparkline/sparkline.js"></script>
    <!--Wave Effects -->
    <script src="./dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="./dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="./dist/js/custom.min.js"></script>
    <!-- This Page JS -->
    <script src="./assets/libs/inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <script src="./dist/js/pages/mask/mask.init.js"></script>
    <script src="./assets/libs/select2/dist/js/select2.full.min.js"></script>
    <script src="./assets/libs/select2/dist/js/select2.min.js"></script>
    <script src="./assets/libs/jquery-asColor/dist/jquery-asColor.min.js"></script>
    <script src="./assets/libs/jquery-asGradient/dist/jquery-asGradient.js"></script>
    <script src="./assets/libs/jquery-asColorPicker/dist/jquery-asColorPicker.min.js"></script>
    <script src="./assets/libs/jquery-minicolors/jquery.minicolors.min.js"></script>
    <script src="./assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="./assets/libs/quill/dist/quill.min.js"></script>
    <script src="./assets/libs/toastr/build/toastr.min.js"></script>
    <script src="./assets/libs/chart/matrix.interface.js"></script>
    <script src="./assets/libs/chart/excanvas.min.js"></script>
    <script src="./assets/libs/flot/jquery.flot.js"></script>
    <script src="./assets/libs/flot/jquery.flot.pie.js"></script>
    <script src="./assets/libs/flot/jquery.flot.time.js"></script>
    <script src="./assets/libs/flot/jquery.flot.stack.js"></script>
    <script src="./assets/libs/flot/jquery.flot.crosshair.js"></script>
    <script src="./assets/libs/chart/jquery.peity.min.js"></script>
    <script src="./assets/libs/chart/matrix.charts.js"></script>
    <script src="./assets/libs/chart/jquery.flot.pie.min.js"></script>
    <script src="./assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
    <script src="./assets/libs/chart/turning-series.js"></script>

    <script src="functions/plot_history.js"></script>
    <script>
        //***********************************//
        // For select 2
        //***********************************//
        $(".select2").select2();

        /*colorpicker*/
        $('.demo').each(function() {
        //
        // Dear reader, it's actually very easy to initialize MiniColors. For example:
        //
        //  $(selector).minicolors();
        //
        // The way I've done it below is just for the demo, so don't get confused
        // by it. Also, data- attributes aren't supported at this time...they're
        // only used for this demo.
        //
        $(this).minicolors({
                control: $(this).attr('data-control') || 'hue',
                position: $(this).attr('data-position') || 'bottom left',

                change: function(value, opacity) {
                    if (!value) return;
                    if (opacity) value += ', ' + opacity;
                    if (typeof console === 'object') {
                        console.log(value);
                    }
                },
                theme: 'bootstrap'
            });

        });
        /*datwpicker*/
        jQuery('.mydatepicker').datepicker();
        jQuery('#datepicker-autoclose').datepicker({
            autoclose: true,
            todayHighlight: true
        });


    // Error User
    function subs() {
        
        
        toastr.success('Subscription successfull.', 'Subscriptions');
    }
    function change_user() {
        
        
        toastr.success('Subsystem user change successful.', 'Subsystem change');
    }
    function req() {
        
        
        toastr.success('Variable creation request sent successfully.', 'Variable Request');
    }

    jQuery( function(){
   var pre = jQuery("#logs");
    pre.scrollTop( pre.prop("scrollHeight") );
    });

    </script>

    <script>
    function onEnterChange() {
        var key = window.event.keyCode || window.event.which ;

        // If the user has pressed enter
        if (key === 13) {
          var chat_message = $('#chat_message_').val();
          $.ajax({
            url:"retrieveSubsystems.php",
            method:"POST",
            data:{chat_message:chat_message},
            success:function(data)
          {
          $('#chat_message_').val('');
          $('#chat_history_').html(data);
          }
          })
        }
        else {
            return true;
        }
    }
    </script>



<script>
function history(IdVariable) {

      $.ajax({
        url:"functions/retrieveVariableHistory.php?sub=auth",
        method:"POST",
        data:{IdVariable:IdVariable},
        success:function(data)
      {
      $('#variable_history').html(data);
      }
      })
}
</script>



<!-- Chat scripts -->

<script>
function openChat() {
  document.getElementById("chat").style.display = "block";
  
   var pre = jQuery("#chat_container");
    pre.scrollTop( pre.prop("scrollHeight") );
    
    document.getElementById("chat_button").style.background = "";
}

// function closeForm() {
//   document.getElementById("chat").style.display = "none";
// }
</script>







<script>  
$(document).ready(function(){



    update_chat_history_data_first_time();


    $(document).on('click', '.send_chat', function(){
        var chat_message = $('#chat_message_').val();
        if(chat_message!= "" && chat_message!= "<br>"){
            $.ajax({
                url:"insert_chat.php",
                method:"POST",
                data:{chat_message:chat_message},
                success:function(data)
                {
                    $('#chat_message_').val('');
                    $('#chat_history_').html(data);
                    jQuery( function(){
                        var pre = jQuery("#chat_container");
                        pre.scrollTop( pre.prop("scrollHeight") );
                    });
                }
            })
        }
    });
 

    $(document).on('click', '#chat_history', function(){
            $.ajax({
                url:"insert_chat.php?hist=auth",
                method:"POST",
                success:function(data)
                {
                    $('#chat_history_').html(data);
                }
            })
    });

$('body').click(function (event) 
{
    
   if((!$(event.target).closest('#chat').length && !$(event.target).is('#chat')) && (!$(event.target).closest('#chat_button').length && !$(event.target).is('#chat_button'))) {
    $("#chat").hide();
   }     
});



setInterval(function(){
  update_last_activity();
  update_chat_history_data();
 }, 3000);

 
 function update_last_activity()
 {
  $.ajax({
   url:"config_mission.php",
   success:function()
   {

   }
  })
 }

 var current;
 
 

 function update_chat_history_data_first_time()
 {
    $.ajax({
        url:"insert_chat.php",
        method:"POST",
        success:function(data){
            if(current != data){
                $('#chat_history_').html(data);
                // console.log(document.getElementById("chat").style);
            }
            current = data;
        }
    })
 }

 


 function update_chat_history_data()
 {
    $.ajax({
        url:"insert_chat.php",
        method:"POST",
        success:function(data){
            if(current != data){
                var pre = jQuery("#chat_container");
                if(pre.scrollTop() >= pre.prop("scrollHeight")-1000){
                        $('#chat_history_').html(data);
                        pre.scrollTop( pre.prop("scrollHeight") );
                }else{
                    $('#chat_history_').html(data);
                }
                // console.log(document.getElementById("chat").style);
                if(document.getElementById("chat").style.display == "" || document.getElementById("chat").style.display == "none"){
                    var cm = toastr.info('', 'New message');
                    document.getElementById("chat_button").style.background = "darkorange";
                }
            }
            current = data;
        }
    })
 }

 
});  
</script>




<script>
    var input = document.getElementById("chat_message_");
    input.addEventListener("keydown", function(event) {
        // Number 13 is the "Enter" key on the keyboard
        if (event.keyCode === 13) {
          // Cancel the default action, if needed
          event.preventDefault();
          // Trigger the button element with a click
          document.getElementById("send_chat").click();
    }
});
    </script>






</body>

</html>