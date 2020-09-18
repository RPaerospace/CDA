<?php

require_once('config_mission.php');

require_once('functions/retrieveUsers.php');
require_once('functions/retrieveLastMissionConnection.php');
require_once('functions/isSystemsEngineer.php');
require_once('functions/retrieveDeletionRequests.php');
require_once('functions/retrieveIssues.php');


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
    <title>CDA web - Mission Overview</title>
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="./assets/libs/select2/dist/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/libs/jquery-minicolors/jquery.minicolors.css">
    <link rel="stylesheet" type="text/css" href="./assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="./assets/libs/quill/dist/quill.snow.css">
    <link href="./assets/libs/toastr/build/toastr.min.css" rel="stylesheet">
    <link href="./assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="./assets/libs/flot/css/float-chart.css" rel="stylesheet">
    <link href="./dist/css/style.min.css" rel="stylesheet">
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

<body onload="startTime(); <?php if(isset($_GET['user'])){echo 'error_user();"' ; } ?> 
        <?php if(isset($_GET['change_user'])){echo 'change_user();"';} ?> 
        <?php if(isset($_GET['cancelVar'])){echo 'cancelVar();"';} ?>
        <?php if(isset($_GET['cancelEle'])){echo 'cancelEle();"';} ?>
        <?php if(isset($_GET['Delete'])){echo 'Delete();"';} ?> 
        <?php if(isset($_GET['imp'])){echo 'imp();"';} ?> 
        <?php if(isset($_GET['Issue'])){echo 'Issue();"';} ?> 
        <?php if(isset($_GET['edit'])){echo 'edit();"';} ?> 
        <?php if(isset($_GET['create_subsystem'])){echo 'create_subsystem();"';} ?>">
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
                            <?php if(isset($_SESSION['mission'])){ 
                                echo '<a class="nav-link waves-effect waves-light" href="mission_main.php" style="font-size: large;"><span class="fas fa-hdd"></span> '.$_SESSION["mission"]["Mission"].'</a>'; }?>
                            
                        
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
                                        <button type="button" href="#" class="btn-circle btn-lg btn-cyan float-right text-white send_chat" id="send_chat" name="send_chat"><i class="fas fa-paper-plane"></i></button>
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
                                        echo '<li class="sidebar-item"><a href="subsystem_database.php?IdSubsystem='.$subsystem['IdSubsystem'].'" class="sidebar-link"><i class="fas fa-hockey-puck"></i><span class="hide-menu"> '. $subsystem['Subsystem'].' </span></a></li>';
                                    
                                    }
                                ?>
                            </ul>
                        </li>
                        <?php
                            foreach($subsystems as $subsystem){
                                if($subsystem['IdUser']==$_SESSION['user']['IdUser']){
                                    echo '<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="subsystem_main.php?IdSubsystem='.$subsystem['IdSubsystem'].'" aria-expanded="false"><i class="mdi mdi-equal-box"></i><span class="hide-menu">'.$subsystem['Subsystem'].'</span></a></li>';
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
                        <h4 class="page-title">Mission Overview</h4>
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title m-b-0">Subsystems
                                    <span class='float-right'>
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#Modal1" <?php if($_SESSION['user']['IdUser'] != $_SESSION['mission']['IdManager']){echo "disabled";}?>>Create subsystem</button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="Modal1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
                                                <div class="modal-dialog" role="document ">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">New Subsystem Form</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true ">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form class="form-horizontal" action="create_subsystem.php" method="post">
                                                            <div class="modal-body">
                                                                <div class="card-body">
                                                                    <div class="form-group row">
                                                                        <label for="fname1" class="col-sm-3 text-right control-label col-form-label">Subsystem Name</label>
                                                                        <div class="col-sm-9">
                                                                            <input name='name' type="text" class="form-control" id="fname1" placeholder="Subsystem Name Here" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="cono1" class="col-sm-3 text-right control-label col-form-label">Description</label>
                                                                        <div class="col-sm-9">
                                                                            <textarea name='description' placeholder="Subsystem Description" class="form-control"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="user1" class="col-sm-3 text-right control-label col-form-label">User</label>
                                                                        <div class="col-sm-9">
                                                                            <!-- <input name='user' list='users' type="text" class="form-control" id="user1" placeholder="User Name Here" required>
                                                                            <datalist id='users'>

                                                                                <?php
                                                                                // $query_users = retrieveUsers();
                                                                                // while($users_entry=$query_users->fetch(PDO::FETCH_ASSOC)){
                                                                                //     echo("<option value='".$users_entry["User"]."'>Id: ".$users_entry["IdUser"]."</option>");
                                                                                // }
                                                                                ?>
                                                                            </datalist> -->
                                                                            <select class="select2 form-control custom-select select2-hidden-accessible" id="select0" style="width: 100%; height:36px;" data-select2-id="0" name="user">
                                                                                <option>Select... </option>
                                                                                    <?php
                                                                                        $query_users = retrieveUsers();
                                                                                        while($users_entry=$query_users->fetch(PDO::FETCH_ASSOC)){?>

                                                                                                <option value="<?php echo $users_entry["User"] ?>"><?php echo $users_entry["User"] ?></option>
                                                                                            <?php
                                                                                        
                                                                                        }
                                                                                    ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary" >Create subsystem</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        <button type="button" class="btn btn-cyan btn-sm" data-toggle="modal" data-target="#imports" onclick="import_ss()" <?php if($_SESSION['user']['IdUser'] != $_SESSION['mission']['IdManager']){echo "disabled";}?>>Import subsystem</button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="imports" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
                                            <div class="modal-dialog" role="document " style="max-width:1000px; width:1000px">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Import subsystems</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true ">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form class="form-horizontal" action="subsystem_import.php" method="post">
                                                        <div class="modal-body" id="import_subsystem">
                                                        </div>
                                                        <div class="modal-footer">

                                                            <button type="submit" class="btn btn-primary">Import subsystem</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                    </span>
                                </h5>
                                
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Subsystem</th>
                                            <th scope="col">Subsystem ID</th>
                                            <th scope="col">User</th>
                                            <th scope="col">User ID</th>
                                            <th scope="col">Status</th>
                                            <?php if($_SESSION['user']['IdUser'] == $_SESSION['mission']['IdManager']){echo '<th scope="col">Actions</th>';} ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr title="Main responsible of the mission">
                                            <td>Systems Engineering</td>
                                            <td> - </td>
                                            <td><?php echo retrieveUsers($_SESSION['mission']['IdManager'])->fetch()[0] ?></td>
                                            <td><?php echo $_SESSION['mission']['IdManager'] ?></td>
                                            <td><?php 
                                                        if((time() - strtotime(retrieveLastMissionConnection($_SESSION['mission']['IdManager']))+7200) < 300){
                                                            echo "<span class='badge badge-success'>Online</span>";
                                                        }else{
                                                            echo "<span class='badge badge-danger'>Offline</span>";
                                                        } ?><!-- </td>
                                                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Change subsystem user">
                                                <i class="mdi mdi-account-edit"></i>
                                            </a><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
                                                <i class="fas fa-times"></i>
                                            </a></td> -->
                                        </tr>
                                        <?php 
                                            foreach($subsystems as $subsystem){
                                                echo "<tr title='".$subsystem['Description']."'>
                                                        <td style='vertical-align: middle;'>".$subsystem['Subsystem']."</td>
                                                        <td style='vertical-align: middle;'>".$subsystem['IdSubsystem']."</td>
                                                        <td style='vertical-align: middle;'>".retrieveUsers($subsystem['IdUser'])->fetch()[0]."</td>
                                                        <td style='vertical-align: middle;'>".$subsystem['IdUser']."</td>";
                                                    if((time() - strtotime(retrieveLastMissionConnection($subsystem['IdUser']))+7200) < 300){
                                                        echo "<td style='vertical-align: middle;'><span class='badge badge-success'>Online</span></td>";
                                                    }else{
                                                        echo "<td style='vertical-align: middle;'><span class='badge badge-danger'>Offline</span></td>";
                                                    }
                                                    if($_SESSION['user']['IdUser'] == $_SESSION['mission']['IdManager']){echo '<td style="vertical-align: middle;">

                                                                                                    <span data-toggle="modal" data-target="#editSS'.$subsystem['IdSubsystem'].'" style="vertical-align: middle;">
                                                                                                        <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit subsystem">
                                                                                                            <i class="fas fa-edit" style="font-size:16px;vertical-align: middle;margin-bottom:4px"></i>
                                                                                                        </a>
                                                                                                    </span>

                                                                                                        
                                                                                                    <!-- Modal -->
                                                                                                    <div class="modal fade" id="editSS'.$subsystem['IdSubsystem'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
                                                                                                        <div class="modal-dialog" role="document ">
                                                                                                            <div class="modal-content">
                                                                                                                <div class="modal-header">
                                                                                                                    <h5 class="modal-title" id="exampleModalLabel">Edit subsystem</h5>
                                                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                                        <span aria-hidden="true ">&times;</span>
                                                                                                                    </button>
                                                                                                                </div>
                                                                                                                <form class="form-horizontal" action="edit_subsystem.php" method="post">
                                                                                                                    <div class="modal-body">
                                                                                                                        <div class="card-body">
                                                                                                                            <div class="form-group row">
                                                                                                                                <label for="Subsystem" class="col-sm-3 text-right control-label col-form-label">User</label>
                                                                                                                                <div class="col-sm-9">
                                                                                                                                    <input name="Subsystem" type="text" class="form-control" placeholder="Subsystem Name Here" value="'.$subsystem['Subsystem'].'" required>

                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                            <div class="form-group row">
                                                                                                                                <label for="Description" class="col-sm-3 text-right control-label col-form-label">Description</label>
                                                                                                                                <div class="col-sm-9">
                                                                                                                                    <textarea name="Description" placeholder="Subsystem Description" class="form-control" >'.$subsystem['Description'].'</textarea>
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="modal-footer">
                                                                                                                        <input type="hidden" name="IdSubsystem" value="'.$subsystem['IdSubsystem'].'">
                                                                                                                        <button type="submit" class="btn btn-primary">Edit subsystem</button>
                                                                                                                    </div>
                                                                                                                </form>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <span data-toggle="modal" data-target="#ModalSS'.$subsystem['IdSubsystem'].'" style="vertical-align: middle;">
                                                                                                        <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Change subsystem user">
                                                                                                            <i class="mdi mdi-account-edit" style="font-size:20px;vertical-align: middle;""></i>
                                                                                                        </a>
                                                                                                    </span>

                                                                                                        
                                                                                                    <!-- Modal -->
                                                                                                    <div class="modal fade" id="ModalSS'.$subsystem['IdSubsystem'].'" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
                                                                                                        <div class="modal-dialog" role="document ">
                                                                                                            <div class="modal-content">
                                                                                                                <div class="modal-header">
                                                                                                                    <h5 class="modal-title" id="exampleModalLabel">Change subsystem user</h5>
                                                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                                        <span aria-hidden="true ">&times;</span>
                                                                                                                    </button>
                                                                                                                </div>
                                                                                                                <form class="form-horizontal" action="change_user.php" method="post">
                                                                                                                    <div class="modal-body">
                                                                                                                        <div class="card-body">
                                                                                                                            <div class="form-group row">
                                                                                                                                <label for="user" class="col-sm-3 text-right control-label col-form-label">User</label>
                                                                                                                                <div class="col-sm-9">
                                                                                                                                    
                                                                                                                                    <select class="select2 form-control custom-select select2-hidden-accessible" id="select_'.$subsystem['IdSubsystem'].'" style="width: 100%; height:36px;" data-select2-id="'.$subsystem['IdSubsystem'].'" name="user">
                                                                                                                                        <option>Select... </option>';
                                                                                                                                            $query_users = retrieveUsers();
                                                                                                                                            while($users_entry=$query_users->fetch(PDO::FETCH_ASSOC)){?>
                                                    
                                                                                                                                                    <option value="<?php echo $users_entry["User"] ?>"><?php echo $users_entry["User"] ?></option>
                                                                                                                                                <?php
                                                                                                                                            
                                                                                                                                            }
                                                                                                                                        echo '
                                                                                                                                    </select>

                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="modal-footer">
                                                                                                                        <input type="hidden" name="IdSubsystem" value="'.$subsystem['IdSubsystem'].'">
                                                                                                                        <button type="submit" class="btn btn-primary">Change user</button>
                                                                                                                    </div>
                                                                                                                </form>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                    <span data-toggle="modal" data-target="#Erase'.$subsystem['IdSubsystem'].'" style="vertical-align: middle;">
                                                                                                        <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete subsystem" style="vertical-align: middle;">
                                                                                                            <i class="fas fa-times" style="font-size:20px;vertical-align: middle;margin-bottom: 2px;"></i>
                                                                                                        </a>
                                                                                                    </span>
                                                                                                    <!-- Modal -->
                                                                                                    <div class="modal fade" id="Erase'.$subsystem['IdSubsystem'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
                                                                                                        <div class="modal-dialog" role="document ">
                                                                                                            <div class="modal-content">
                                                                                                                <div class="modal-header">
                                                                                                                    <h5 class="modal-title" id="exampleModalLabel">WARNING: Deleting subsystem</h5>
                                                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                                        <span aria-hidden="true ">&times;</span>
                                                                                                                    </button>
                                                                                                                </div>
                                                                                                                <div class="modal-body">
                                                                                                                    Are you sure that you want to delete the subsystem "'.$subsystem['Subsystem'].'" (ID: '.$subsystem['IdSubsystem'].')?
                                                                                                                    <br>
                                                                                                                    The elements from this subsystem will still be restorable by importing them to another subsystem.
                                                                                                                </div>
                                                                                                                <div class="modal-footer">
                                                                                                                    <a href="delete_subsystem.php?IdSubsystem='.$subsystem['IdSubsystem'].'" type="button" class="btn btn-danger">Delete subsystem</a>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    </td>';}
                                                echo "</tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                             <?php

                                $file = "logs/".$_SESSION['mission']['IdMission'].".log";

                                $contents = file($file,FILE_IGNORE_NEW_LINES);

                            ?>
                            <div class="card-body">
                                <h5 class="card-title">Mission Log
                                <span class='float-right'><a href="<?php echo $_SESSION['mission']['IdMission'].".log" ?>" title='Download log' download style='float:right;height:10px'> 
                                    <span class='fas fa-download'></span></a></span>
                                </h5>
                                <pre id="logs" style="text-align:left;height:450px; overflow-y: scroll; word-wrap: break-word; white-space: pre-wrap;"><?php if($contents){echo implode("&#13;&#10;",$contents);} ?></pre >
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Issue History</h5>

                                            
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Issue</th>
                                                <th scope="col">Start Datetime</th>
                                                <th scope="col">Total Issue Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $Issues = retrieveIssues($_SESSION['mission']['IdMission'])->fetchAll(PDO::FETCH_ASSOC);
                                            foreach($Issues as $Issue){
                                                ?>
                                                <tr>
                                                    <td style='vertical-align: middle;'><?php echo $Issue['Issue'] ?></td>    
                                                    <td style='vertical-align: middle;'><?php echo $Issue['Timestamp'] ?></td>  
                                                    <td style='vertical-align: middle;'><?php if($Issue['Issue']!=$_SESSION['mission']['IssueVersion']){echo date_diff(date_create($Issue['Timestamp']),date_create($prev_date))->format('%a days  %H:%I:%S');}else{echo "-";}; ?></td>  
                                                
                                                </tr>
                                                <?php
                                                $prev_date = $Issue['Timestamp'];
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Issue Version</h5>
                                <?php
                                    echo '<div class="border-bottom"><h1 class="text-center" style="width:100%; font-size:xxx-large;">'.$_SESSION['mission']['IssueVersion'].'</h1>';
                                    if($_SESSION['user']['IdUser'] == $_SESSION['mission']['IdManager']){
                                        echo '
                                            <a type="button" href="issueNew.php" class="btn btn-info btn-block btn-sm m-t-10">
                                                Start New Issue
                                            </a><br>
                                            ';
                                    }
                                    echo '
                                    </div>
                                            <b>Issue Time</b>: <span id="issuetime"> </span><br>
                                            <b>Mission Time</b>: <span id="time"> </span><br>
                                            <b>Issue Start Datetime</b>: '.$Issues[0]['Timestamp'].'<br>
                                            <b>Mission Start Datetime</b>: '.$_SESSION['mission']['Creation'].'
                                        ';//'.$_SESSION['mission']['Creation'].'

                                ?>
                            </div>
                        </div>


                        <?php
                            if($_SESSION['user']['IdUser'] == $_SESSION['mission']['IdManager']){
                                echo '

                                    <!-- Deletion Card -->
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">Deletion Requests</h5>
                                            </div>
                                            <div class="comment-widgets scrollable ps-container ps-theme-default">
                                                <!-- Comment Row -->
                                                ';
                            

                                
                
                                                // echo "              
                                                //     <div class='card-body'>
                                                //         <h6>Elements</h6>
                                                //     </div>";
                                                // echo '
                                                //     <a  class="d-flex flex-row comment-row m-t-0" href="mission_main.php" data-toggle="modal" data-target="#Delete">
                                                //         <div class="comment-text w-100">
                                                //             <h6 class="font-medium">Subsystem</h6><span class="m-b-15 d-block">Element <small>Id: ID</small></span>

                                                //         </div>
                                                //     </a>';
                                                // echo "
                                                //     <div class='card-body'>
                                                //         <hr><h6>Variables</h6>
                                                //     </div>";
                                                // echo '
                                                //     <a  class="d-flex flex-row comment-row m-t-0" href="mission_main.php" data-toggle="modal" data-target="#Delete">
                                                //         <div class="comment-text w-100">
                                                //             <h6 class="font-medium">Subsystem: aaaaaaaaaaaaaaaaaaaaaa</h6><span class="m-b-15 d-block">Element <small>Id: ID</small></span>
                                                //             <div class="comment-text w-100">
                                                //                 <span class="m-b-15 d-block">Variable <small>Id: ID</small></span>

                                                //             </div>
                                                //         </div>
                                                //     </a>';

                                                $deletions = retrieveDeletionRequests($subsystems,$data);
                                                if(!isset($deletions)){
                                                    echo "
                                                        <div class='card-body'>
                                                            No current requests
                                                        </div>
                                                    ";
                                                }

                                                if(isset($deletions)&&$deleting_elements=$deletions[0]){
                    
                                                    echo "
                                                        <div class='card-body'>
                                                            <h6>Elements</h6>
                                                        </div>
                                                    ";

                                                    foreach($deleting_elements as $subsystem=>$elements){
                                                        foreach($elements as $element){
                                                            // echo "<a href='deletion.php?IdElement=".$element['IdElement']."&Element=".$element['Element']."' type='button' class='btn btn-warning btn-block'>
                                                            //     <span valign='top'  style='text-align: left; width:100%;  display: inline-block;'>".$subsystem."<br><b>".$element['Element']." <small>Id: ".$element['IdElement']."</small></b></span>
                                                            //     </a>";
                                                        
                                                            echo '
                                                                <a class="d-flex flex-row comment-row m-t-0" href="#" data-toggle="modal" data-target="#Ele'.$element['IdElement'].'">
                                                                    <div class="comment-text w-100">
                                                                        <h6 class="font-medium">Subsystem: '.$subsystem.'</h6><span class="m-b-15 d-block">Element: '.$element['Element'].' <small>ID: '.$element['IdElement'].'</small></span>

                                                                    </div>
                                                                </a>

                                                                <!-- Modal -->
                                                                <div class="modal fade" id="Ele'.$element['IdElement'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
                                                                    <div class="modal-dialog" role="document " style="max-width:1000px">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="exampleModalLabel">Delete element</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true ">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                History log:
                                                                                <br>

                                                                                ';
                               

                                                                                $file = "logs/".$_SESSION['mission']['IdMission'].".log";
                                                                                $searchfor = "Element ".$element['IdElement'];


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
                                                                                    <pre style="height:50vh; margin:1.25rem; overflow-y: scroll; word-wrap: break-word; white-space: pre-wrap;">'; 
                                                                                        if(preg_match_all($pattern, $contents, $matches)){
                                                                                            //echo "Found matches:\n";
                                                                                            echo implode("<br>", $matches[0]);
                                                                                        }else{
                                                                                            echo "No entries in log found.";
                                                                                        } 
                                                                                        echo '
                                                                                    </pre >

                                                                                Are you sure that you want to delete the element "'.$element['Element'].'" (ID: '.$element['IdElement'].')?
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <a href="cancel_deletion.php?IdElement='.$element['IdElement'].'" type="button" class="btn btn-success">Cancel deletion request</a>
                                                                                <a href="delete.php?IdElement='.$element['IdElement'].'" type="button" class="btn btn-danger">Delete element</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            ';
                                                        }
                                                    }//<span style='text-align: right; width:60%;  display: inline-block;'>RIGHT</span>   echo "Subsystem: ".$variables['subsystem'];          <span valign='top' style='text-align: left; width:28%; display: inline-block;'>Id: ".$variable['IdVariable']."</span>
                                                }//<span valign='top'  style='text-align: left; width:28%; display: inline-block;'>Id: ".$element['IdElement']."</span>

                                                if(isset($deletions)&&$deleting_variables=$deletions[1]){
                                                    echo "<div class='card-body'>
                                                            <hr><h6>Variables</h6>
                                                          </div>";

                                                    foreach($deleting_variables as $IdElement=>$variables){
                                                        foreach($variables['variables'] as $variable){
                                                            // echo "<a href='deletion.php?IdVariable=".$variable['IdVariable']."&Variable=".$variable['Variable']."' type='button' class='btn btn-warning btn-block'>
                                                            //     <span valign='top' style='text-align: left; width:100%;  display: inline-block;'>".$variables['subsystem']."<br><b>".$variables['element']."<br>".$variable['Variable']." <small>Id: ".$variable['IdVariable']."</small></b></span>
                                                            //     </a>";
                                                        
                                                                echo '
                                                                    <a class="d-flex flex-row comment-row m-t-0" href="#" data-toggle="modal" data-target="#Var'.$variable['IdVariable'].'">
                                                                        <div class="comment-text w-100">
                                                                            <h6 class="font-medium">Subsystem: '.$variables['subsystem'].'</h6><span class="m-b-15 d-block">Element: '.$variables['element'].' <small>ID: '.$variables['IdElement'].'</small></span>

                                                                            <div class="comment-text w-100">
                                                                                <span class="m-b-15 d-block">Variable: '.$variable['Variable'].' <small>ID: '.$variable['IdVariable'].'</small></span>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                    
                                                                    

                                                                    <!-- Modal -->
                                                                    <div class="modal fade" id="Var'.$variable['IdVariable'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
                                                                        <div class="modal-dialog" role="document " style="max-width:1000px">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="exampleModalLabel">Delete variable</h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true ">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    History log:
                                                                                    <br>';
                               

                                                                                    $file = "logs/".$_SESSION['mission']['IdMission'].".log";
                                                                                    $searchfor = $variables['IdElement'].",".$variable['IdVariable'];


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
                                                                                        <pre style="height:50vh; margin:1.25rem; overflow-y: scroll; word-wrap: break-word; white-space: pre-wrap;">'; 
                                                                                            if(preg_match_all($pattern, $contents, $matches)){
                                                                                                //echo "Found matches:\n";
                                                                                                echo implode("<br>", $matches[0]);
                                                                                            }else{
                                                                                                echo "No entries in log found.";
                                                                                            } 
                                                                                        echo '
                                                                                        </pre >
                                                                                        Are you sure that you want to delete the variable "'.$variable['Variable'].'" (ID: '.$variable['IdVariable'].')?
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                        <a href="cancel_deletion.php?IdVariable='.$variable['IdVariable'].'" type="button" class="btn btn-success">Cancel deletion request</a>
                                                                                        <a href="delete.php?IdVariable='.$variable['IdVariable'].'" type="button" class="btn btn-danger">Delete variable</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                ';
                                                        }
                                                    }
                                                }
                                         
                                                echo '
                                            </div>
                                        </div>
                                ';
                                            
                            }
                        ?>
                    </div> 
                </div>
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
    <script>
        //***********************************//
        // For select 2
        //***********************************//
        $("#select0").select2();
        <?php
        foreach($subsystems as $subsystem){
            echo '$("#select_'.$subsystem["IdSubsystem"].'").select2();';
        }
        ?>
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
    function error_user() {
        
        
        toastr.error('Username does not exist.', 'Subsystem creation error');
    }
    function change_user() {
        
        
        toastr.success('Subsystem user change successful.', 'Subsystem change');
    }
    function cancelVar() {
        
        
        toastr.success('Variable deletion request cancelled.', 'Deletion request');
    }

    function cancelEle() {
        
        
        toastr.success('Element deletion request cancelled.', 'Deletion request');
    }

function Delete() {
    
    
    toastr.info('Element or variable deleted successfully.', 'Deletion request');
}

function create_subsystem() {
    
    
    toastr.success('Subsystem created successfully.', 'Subsystem creation');
}

function imp() {
    
    
    toastr.success('Subsystem imported successfully.', 'Subsystem imported');
}


function Issue() {
    
    
    toastr.success('All existing and new variables now belongs to new issue.', 'New issue started');
}


function edit() {
    
    
    toastr.success('Subsystem edited successfully.', 'Subsystem edited');
}


jQuery( function(){
   var pre = jQuery("#logs");
    pre.scrollTop( pre.prop("scrollHeight") );
    });
    </script>


    <script>
        function startTime() {
          var time = new Date();
          var creation = new Date(<?php echo strtotime($_SESSION['mission']['Creation']); ?>*1000 );
          var issue = new Date(<?php echo strtotime($Issues[0]['Timestamp']); ?>*1000 );

          var diff = Math.abs(time - creation +7200000);
          var d = Math.floor(diff/1000/60/60/24) ;
          var h = Math.floor(diff/1000/60/60 - d*24) ;
          var m = Math.floor(diff/1000/60 - d*24*60 - h*60) ;
          var s = Math.floor(diff/1000 - d*24*60*60 - h*60*60 - m*60) ;

          var diffi = Math.abs(time - issue +7200000);
          var di = Math.floor(diffi/1000/60/60/24) ;
          var hi = Math.floor(diffi/1000/60/60 - di*24) ;
          var mi = Math.floor(diffi/1000/60 - di*24*60 - hi*60) ;
          var si = Math.floor(diffi/1000 - di*24*60*60 - hi*60*60 - mi*60) ;

          m = checkTime(m);
          s = checkTime(s);
          mi = checkTime(mi);
          si = checkTime(si);

          document.getElementById('time').innerHTML =
          d + " Days " + h + ":" + m + ":" + s;
          var t = setTimeout(startTime, 500);

          document.getElementById('issuetime').innerHTML =
          di + " Days " + hi + ":" + mi + ":" + si;
        }
        function checkTime(i) {
          if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
          return i;
        }
    </script>


<script>
function import_ss() {

      $.ajax({
        url:"subsystem_import.php",
        method:"POST",
        success:function(data)
      {
      $('#import_subsystem').html(data);
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