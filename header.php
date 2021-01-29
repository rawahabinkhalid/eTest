<?php
// include_once "conn.php";
// echo $_SESSION['userid'];
if (!isset($_SESSION['userid'])) {
    echo '<script>window.open("Login/", "_self");</script>';
} ?>

<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
<!-- overlayScrollbars -->
<link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="dist/css/adminlte.min.css">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<link rel="stylesheet" href="dist/css/owl.carousel.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="dist/js/adminlte_sidebar_responsive.js"></script>
<style>
    @media only screen and (min-width: 800px) {
        #nav-menu {
            display: none;

        }

        #desktop_emp {
            display: block;
        }

        #desktop_random {
            display: block;
        }

        #desktop_pref {
            display: block;
        }

        #mobile_emp {
            display: none;
        }

        #mobile_random {
            display: none;
        }

        #mobile_pref {
            display: none;
        }
    }

    @media only screen and (max-width: 800px) {
        #nav-menu {
            /* display: none; */

        }

        #desktop_random {
            display: none;
        }

        #desktop_emp {
            display: none;
        }

        #desktop_pref {
            display: none;
        }

        #mobile_random {
            display: block;
        }

        #mobile_emp {
            display: block;
        }

        #mobile_pref {
            display: block;
        }

        /* 
    #btn_add_employees {
        padding-left: 5px;
        padding-right: 5px;
    }

    #btn_add_preferences {
        padding-left: 5px;
        padding-right: 5px;
    } */

        .nav-item .nav-link {
            padding-left: 5px !important;
            padding-right: 5px !important;
        }
    }

    /* Style the tab */
    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }

    /* Style the buttons that are used to open the tab content */
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }

    .tabcontent {
        animation: fadeEffect 0.5s;
        /* Fading effect takes 1 second */
    }

    /* Go from zero to full opacity */
    @keyframes fadeEffect {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .my-row-4-label label,
    .my-row-5-label label {
        font-size: 12px;
        padding: 3px 0px;
    }

    .my-row-8-input input,
    .my-row-7-input input {
        font-size: 12px !important;
        height: calc(1.75rem + 0px) !important;
        padding: 3px 10px !important;
    }

    .my-row-8-input select,
    .my-row-7-input select {
        font-size: 12px !important;
        height: calc(1.75rem + 0px) !important;
        padding: 3px 10px !important;
    }

    .validation-error {
        border-color: red !important;
    }
</style>
<ul class="navbar-nav col-md-8">
    <li class="nav-item">
        <a class="nav-link" id="nav-menu" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item col-md-12">
        <?php if ($_SESSION['usertype'] == 'admin') { ?>
            <div class="form-inline">
                <div class="form-inline" id="selected_filter_div" style="display: none">
                    <label><input type="radio" id="selected_filter_all" name="selected_filter" value="All">&nbsp;All</label>
                    <label><input type="radio" id="selected_filter_selected" name="selected_filter" value="Selected" checked>&nbsp;Selected</label>
                </div>
                <select class="form-control" id="accounts_select">
                    <option selected disabled>Please select Account</option>
                    <?php
                    $sql = 'SELECT * FROM accounts ORDER BY account_nm';
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' .
                                $row['account_id'] .
                                '">' .
                                $row['account_nm'] .
                                '</option>';
                        }
                    }
                    ?>
                </select>
            </div>
        <?php } elseif ($_SESSION['usertype'] == 'accounts' || $_SESSION['usertype'] == 'guest') { ?>
            <!-- <select class="form-control" id="accounts_select">
                <?php
                // $sql =
                //     'SELECT * FROM accounts WHERE account_id=' .
                //     $_SESSION['accountid'];
                // $result = $conn->query($sql);
                // if ($result->num_rows > 0) {
                //     while ($row = $result->fetch_assoc()) {
                //         echo '<option selected value="' .
                //             $row['account_id'] .
                //             '">' .
                //             $row['account_nm'] .
                //             '</option>';
                //     }
                // }
                ?>
            </select> -->
            <select class="form-control" id="accounts_select">
                <?php
                $sql = 'SELECT * FROM accounts WHERE account_id = ' .
                    $_SESSION['accountid'] . ' ORDER BY account_nm';
                echo $sql;
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' .
                            $row['account_id'] .
                            '">' .
                            $row['account_nm'] .
                            '</option>';
                    }
                }
                ?>
            </select>

        <?php } ?>
    </li>
</ul>


<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
    <?php if ($_SESSION['usertype'] == 'admin') { ?>
        <li class="nav-item">
            <a href="randomemployees.php" class="nav-link nav-link-disabler">
                <!-- <a href="" class="nav-link nav-link-disabler" data-toggle="modal" data-target="#myModal_Employee_Import" id="btn_add_employees"> -->
                <p id="desktop_random">Random</p>
                <p id="mobile_random">Rand</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="" class="nav-link nav-link-disabler" data-toggle="modal" data-target="#myModal_Employee" id="btn_add_employees">
                <!-- <a href="" class="nav-link nav-link-disabler" data-toggle="modal" data-target="#myModal_Employee_Import" id="btn_add_employees"> -->
                <p id="desktop_emp">Employee</p>
                <p id="mobile_emp">Emp</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="" class="nav-link nav-link-disabler" data-toggle="modal" data-target="#myModal_Preferences" id="btn_add_preferences">
                <p id="desktop_pref">Preferences</p>
                <p id="mobile_pref">Pref</p>
            </a>
        </li>
    <?php } ?>

    <!-- <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="#" class="dropdown-item">
                    <div class="media">
                        <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Brad Diesel
                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">Call me whenever you can...</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <div class="media">
                        <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                John Pierce
                                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">I got your message bro</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <div class="media">
                        <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                Nora Silvester
                                <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">The subject goes here</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">15</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">15 Notifications</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i> 8 friend requests
                    <span class="float-right text-muted text-sm">12 hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i> 3 new reports
                    <span class="float-right text-muted text-sm">2 days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
        </li> -->
    <li class="nav-item">
        <a class="nav-link" data-slide="true" href="signout.php"><i class="fas fa-sign-out-alt"></i></a>
    </li>
</ul>
</nav>
<!-- /.navbar -->
<?php // if ($_SESSION['usertype'] == 'guest') { 
?>


<?php if ($_SESSION['usertype'] == 'accounts' || $_SESSION['usertype'] == 'guest') { ?>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">RN Expertise</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar" style="height:90% !important;">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <!--  <div class="image">
                    <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div> -->
                <div class="info">
                    <a href="#" class="d-block" style="font-size: 1.1em;"><b><?php echo ucwords(
                                                                                    $_SESSION['username']
                                                                                ); ?></b></a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- <li class="nav-item">
                    <a href="personal.php" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Personal
                        </p>
                    </a>
                </li> -->
                    <li class="nav-item has-treeview">
                        <a href="landingscreen.php" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                MRO review / New Test
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="personal.php" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Personal
                            </p>
                        </a>
                    </li>


                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>


<?php } elseif ($_SESSION['usertype'] == 'admin') { ?>





    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">RN Expertise</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar" style="height:90% !important;">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <!-- <div class="image">
                    <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                </div> -->
                <div class="info">
                    <a href="#" class="d-block" style="font-size: 1.1em;"><b><?php echo ucwords(
                                                                                    $_SESSION['username']
                                                                                ); ?></b></a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                    <!-- <li class="nav-item has-treeview menu-open">
                    <a href="dashboard.php" class="nav-link active"> -->
                    <!-- <li class="nav-item has-treeview">
                        <a href="dashboard.php" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li> -->
                    <li class="nav-item has-treeview">
                        <a onclick="openURL('landingscreen.php');" href="javascript:void();" class="nav-link">
                            <!-- <a href="" class="nav-link"> -->
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                MRO review / New Test
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a onclick="openURL('invoice.php');" href="javascript:void();" class="nav-link">
                            <!-- <a href="" class="nav-link"> -->
                            <i class="nav-icon fas fa-copy "></i>
                            <p>
                                Invoice
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a onclick="openURL('randomemployees.php');" href="javascript:void();" class="nav-link">
                            <!-- <a href="" class="nav-link"> -->
                            <i class="nav-icon fas fa-copy "></i>
                            <p>
                                Random
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                File
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="" class="nav-link" id="new_form" style="pointer-events: none;">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>New</p>
                                </a>
                            </li>
                            <!-- <li class="nav-item" style="pointer-events: none;">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Delete</p>
                            </a>
                        </li>
                        <li class="nav-item" style="pointer-events: none;">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Save</p>
                            </a>
                        </li> -->
                            <li class="nav-item">
                                <a href="landingscreen.php" class="nav-link" id="cancel_form" style="pointer-events: none;">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Cancel</p>
                                </a>
                            </li>
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>
                                        Account
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <!-- <li class="nav-item" style="pointer-events: none;">
                                         <a href="" class="nav-link">
                                         &emsp;&emsp;<i class="far fa-circle nav-icon"></i>
                                              <p>&emsp;&emsp;Properties</p>
                                          </a>
                                     </li> -->
                                    <li class="nav-item">
                                        <a href="" class="nav-link" data-toggle="modal" data-target="#myModal_Employee" id="btn_add_employees">
                                            &emsp;&emsp;<i class="far fa-circle nav-icon"></i>
                                            <p>&emsp;&emsp;Add Employee</p>
                                        </a>
                                    </li>
                                    <!-- <li class="nav-item" style="pointer-events: none;">
                                         <a href="" class="nav-link">
                                         &emsp;&emsp;<i class="far fa-circle nav-icon"></i>
                                              <p>&emsp;&emsp;Transfer Data</p>
                                          </a>
                                     </li> -->
                                    <li class="nav-item">
                                        <a href="randomemployees.php" class="nav-link">
                                            &emsp;&emsp;<i class="far fa-circle nav-icon"></i>
                                            <p>&emsp;&emsp;Random Employee Listing</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a onclick="openURL('invoice.php');" href="javascript:void();" class="nav-link">
                                            &emsp;&emsp;<i class="far fa-circle nav-icon"></i>
                                            <p>&emsp;&emsp;Invoices</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a onclick="openURL('retrievetest.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Retrieve...</p>
                                </a>
                            </li>
                            <!-- <li class="nav-item" style="pointer-events: none;">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Clear Results</p>
                            </a>
                        </li>
                        <li class="nav-item" style="pointer-events: none;">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Print...</p>
                            </a>
                        </li> -->
                            <!-- <li class="nav-item" style="pointer-events: none;">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Printer Setup...</p>
                            </a>
                        </li> -->
                            <li class="nav-item">
                                <a href="" class="nav-link" data-toggle="modal" data-target="#myModal_Preferences" id="btn_add_preferences">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Preferences</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="signout.php" class="nav-link nav-link-signout">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Exit</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <!-- <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            View
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                    </ul>
                </li> -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Results
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <!-- <li class="nav-item" style="pointer-events: none;">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Select All</p>
                            </a>
                        </li>
                        <li class="nav-item" style="pointer-events: none;">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Deselect All</p>
                            </a>
                        </li>
                        <li class="nav-item" style="pointer-events: none;">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Group</p>
                            </a>
                        </li>
                        <li class="nav-item" style="pointer-events: none;">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Ungroup</p>
                            </a>
                        </li> -->
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Refresh</p>
                                </a>
                            </li>
                            <!-- <li class="nav-item" style="pointer-events: none;">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sort</p>
                            </a>
                        </li> -->
                            <li class="nav-item" style="pointer-events: none;">
                                <a href="" class="nav-link" data-toggle="modal" data-target="#myModal_Send" id="btn_add_send">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Send</p>
                                </a>
                            </li>
                            <li class="nav-item" style="pointer-events: none;">
                                <a href="" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Download</p>
                                </a>
                            </li>
                            <li class="nav-item" style="pointer-events: none;">
                                <a href="" class="nav-link" data-toggle="modal" data-target="#myModal_Billing" id="btn_add_billing">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Billing</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                System
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="users.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="systemids.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>System IDs</p>
                                </a>
                            </li>
                            <!-- <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Database
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="bank.php" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Properties</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Import</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Export</p>
                                    </a>
                                </li>

                            </ul>
                        </li> -->
                            <li class="nav-item">
                                <a href="accounts.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Accounts</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="employees.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Employees</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="practitioners.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Practitioners</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="laboratories.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Laboratories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="testtype.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Test Types</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="sampletype.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sample Types</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="testreason.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Test Reasons</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="drugs.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Drugs</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="form.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Forms</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="randomemployees.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Random Employees</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="randomemployeeslisting.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Random Employees Listing</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="companyInfo.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Company Information</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Reports
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <!-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('accounts_fees.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Accounts Fees Report</p>
                                </a>
                            </li>
                        </ul> -->
                        <!-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('bedsReport.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Monthly Beds Report</p>
                                </a>
                            </li>
                        </ul> -->
                        <!-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('notBilledReport.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Items Not Billed</p>
                                </a>
                            </li>
                        </ul> -->
                        <!-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('weeklyReport.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Weekly Funding Test</p>
                                </a>
                            </li>
                        </ul> -->
                        <!-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('billingReport.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Billing Report</p>
                                </a>
                            </li>
                        </ul> -->
                        <!-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('labelsBillingReport.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Labels For Billing Report</p>
                                </a>
                            </li>
                        </ul> -->
                        <!-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('postBilledReport.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Post Billed Report</p>
                                </a>
                            </li>
                        </ul> -->

                        <!-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('frandReport.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon" style="margin: 0;
    position: absolute;
    top: 50%;
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);"></i>
                                    <p style="margin-left: 35px;">Active Employees for a<br>Random Account</p>
                                </a>
                            </li>
                        </ul>                         -->
                        <!-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('unpaidInvoiceReport.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Unpaid Invoice Report</p>
                                </a>
                            </li>
                        </ul> -->
                        <!-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('misReport.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>MIS Report</p>
                                </a>
                            </li>
                        </ul> -->
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('revenueReport.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Revenue Report</p>
                                </a>
                            </li>
                        </ul>
                        <!-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('testResult.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Alere Report</p>
                                </a>
                            </li>
                        </ul> -->
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('peopleSoftInfo.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>WP Peoplesoft Info</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('mroReport.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>MRO Reports</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Account Reports
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('frandReport.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon" style="margin: 0;
    position: absolute;
    top: 50%;
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);"></i>
                                    <p style="margin-left: 35px;">Active Employees for a<br>Random Account</p>
                                </a>
                            </li>
                        </ul>                        
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('accounts_fees.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Fees Report</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Billing Reports
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('weeklyReport.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>AR Funding Report</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('billingReport.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Billing Report</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('notBilledReport.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Items Not Billed</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('labelsBillingReport.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Labels For Billing Report</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Company Reports
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('annualSalesReport.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Annual Sales Report</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('misReport.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>MIS Report</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy" style="margin: 0;
    position: absolute;
    top: 50%;
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);"></i>
                            <p style="margin-left: 35px">
                                Past Due Invoice<br>Reports
                                <i class="fas fa-angle-left right" style="margin: 0;
    position: absolute;
    top: 50%;
    -ms-transform: translateY(-50%);
    transform: translateY(-50%);
    right: 15px;"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('postBilledReport.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Post Billed Report</p>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="openURL('unpaidInvoiceReport.php');" href="javascript:void();" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Unpaid Invoice Report</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Help
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="aboutus.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>About Us</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="query.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Execute Query</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="personal.php" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Personal
                            </p>
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="accountsManagement.php" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Accounts Management
                            </p>
                        </a>
                    </li> -->
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
<?php } ?>

<div id="myModal_Preferences" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Preferences</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="display: inline-block">
                <fieldset style="border: 1px solid lightgray; padding: 10px;">
                    <legend>Test Defaults</legend>
                    <?php
                    $sqlPreferences = 'SELECT * FROM `preferences`';
                    $resultPreferences = $conn->query($sqlPreferences);
                    if ($resultPreferences->num_rows > 0) {
                        $rowPreferences = $resultPreferences->fetch_assoc();
                        // print_r($rowPreferences);
                    }
                    ?>
                    <div id="main_div">
                        <div class="row">
                            <div class="col-md-2" style="display: inline-block">Practitioner: </div>
                            <div class="col-md-7" style="display: inline-block">
                                <select class="form-control" id="practitioner_default" name="practitioner_default">
                                    <option selected disabled value="">Please select a Practitioner</option>
                                    <?php
                                    $sqlPractitioner =
                                        'SELECT * FROM `practitioner` ORDER BY `practitioner`.`practitioner_nm` ASC';
                                    $resultPractitioner = $conn->query(
                                        $sqlPractitioner
                                    );
                                    if ($resultPractitioner->num_rows > 0) {
                                        while (
                                            $rowPractitioner = $resultPractitioner->fetch_assoc()
                                        ) {
                                            echo '<option value="' .
                                                $rowPractitioner['practitioner_id'] .
                                                '"';
                                            if (
                                                isset($rowPreferences['practitioner_id'])
                                            ) {
                                                if (
                                                    $rowPractitioner['practitioner_id'] ==
                                                    $rowPreferences['practitioner_id']
                                                ) {
                                                    echo 'selected';
                                                }
                                            }
                                            echo '>' .
                                                $rowPractitioner['practitioner_nm'] .
                                                '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2" style="display: inline-block">Lab: </div>
                            <div class="col-md-7" style="display: inline-block">
                                <select class="form-control" id="lab_default" name="lab_default">
                                    <option selected disabled value="">Please select a Lab</option>
                                    <?php
                                    $sqlLab =
                                        'SELECT * FROM `lab` ORDER BY `lab`.`lab_nm` ASC';
                                    $resultLab = $conn->query($sqlLab);
                                    if ($resultLab->num_rows > 0) {
                                        while (
                                            $rowLab = $resultLab->fetch_assoc()
                                        ) {
                                            echo '<option value="' .
                                                $rowLab['lab_id'] .
                                                '"';
                                            if (
                                                isset($rowPreferences['lab_id'])
                                            ) {
                                                if (
                                                    $rowLab['lab_id'] ==
                                                    $rowPreferences['lab_id']
                                                ) {
                                                    echo 'selected';
                                                }
                                            }
                                            echo '>' .
                                                $rowLab['lab_nm'] .
                                                '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2" style="display: inline-block">Sample Type: </div>
                            <div class="col-md-7" style="display: inline-block">
                                <select class="form-control" id="sampleType_default" name="sampleType_default">
                                    <option selected disabled value="">Please select a Sample Type</option>
                                    <?php
                                    $sqlSampleType =
                                        'SELECT * FROM `sampletype` ORDER BY `sampletype`.`sample_nm` ASC';
                                    $resultSampleType = $conn->query(
                                        $sqlSampleType
                                    );
                                    if ($resultSampleType->num_rows > 0) {
                                        while (
                                            $rowSampleType = $resultSampleType->fetch_assoc()
                                        ) {
                                            echo '<option value="' .
                                                $rowSampleType['sample_id'] .
                                                '"';
                                            if (
                                                isset($rowPreferences['sample_id'])
                                            ) {
                                                if (
                                                    $rowSampleType['sample_id'] ==
                                                    $rowPreferences['sample_id']
                                                ) {
                                                    echo 'selected';
                                                }
                                            }
                                            echo '>' .
                                                $rowSampleType['sample_nm'] .
                                                '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2" style="display: inline-block">Test Type: </div>
                            <div class="col-md-7" style="display: inline-block">
                                <select class="form-control" id="testType_default" name="testType_default">
                                    <option selected disabled value="">Please select a Test Type</option>
                                    <?php
                                    $sqlTestType =
                                        'SELECT * FROM `testtype` ORDER BY `testtype`.`type_nm` ASC';
                                    $resultTestType = $conn->query(
                                        $sqlTestType
                                    );
                                    if ($resultTestType->num_rows > 0) {
                                        while (
                                            $rowTestType = $resultTestType->fetch_assoc()
                                        ) {
                                            echo '<option value="' .
                                                $rowTestType['type_id'] .
                                                '"';
                                            if (
                                                isset($rowPreferences['type_id'])
                                            ) {
                                                if (
                                                    $rowTestType['type_id'] ==
                                                    $rowPreferences['type_id']
                                                ) {
                                                    echo 'selected';
                                                }
                                            }
                                            echo '>' .
                                                $rowTestType['type_nm'] .
                                                '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2" style="display: inline-block">Test Reason: </div>
                            <div class="col-md-7" style="display: inline-block">
                                <select class="form-control" id="testReason_default" name="testReason_default">
                                    <option selected disabled value="">Please select a Test Reason</option>
                                    <?php
                                    $sqlTestReason =
                                        'SELECT * FROM `reasons` ORDER BY `reasons`.`reason_nm` ASC';
                                    $resultTestReason = $conn->query(
                                        $sqlTestReason
                                    );
                                    if ($resultTestReason->num_rows > 0) {
                                        while (
                                            $rowTestReason = $resultTestReason->fetch_assoc()
                                        ) {
                                            echo '<option value="' .
                                                $rowTestReason['reason_id'] .
                                                '"';
                                            if (
                                                isset($rowPreferences['reason_id'])
                                            ) {
                                                if (
                                                    $rowTestReason['reason_id'] ==
                                                    $rowPreferences['reason_id']
                                                ) {
                                                    echo 'selected';
                                                }
                                            }
                                            echo '>' .
                                                $rowTestReason['reason_nm'] .
                                                '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="addPreferences();">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="selected_fees = -1;">Close</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Help</button>
            </div>
        </div>

    </div>
</div>

<div id="myModal_Employee" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">New Employee</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="display: inline-block">
                <div id="main_div">
                    <div class="row">
                        <div class="col-md-3" style="display: inline-block">Specimen ID: </div>
                        <div class="col-md-7" style="display: inline-block">
                            <input class="form-control" id="specimen_id" name="specimen_id">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3" style="display: inline-block">Employee ID (SSN): </div>
                        <div class="col-md-7" style="display: inline-block">
                            <input type="hidden" id="employeesindex" name="employeesindex" value="">
                            <input class="form-control" id="emp_id" name="emp_id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3" style="display: inline-block">First Name / Req No: </div>
                        <div class="col-md-7" style="display: inline-block">
                            <input class="form-control" id="first_nm" name="first_nm">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3" style="display: inline-block">Last Name: </div>
                        <div class="col-md-7" style="display: inline-block">
                            <input class="form-control" id="last_nm" name="last_nm">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3" style="display: inline-block">Location: </div>
                        <div class="col-md-7" style="display: inline-block">
                            <select class="form-control" id="division_id" name="division_id">
                                <!-- <option value="">Select Location</option> -->
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3" style="display: inline-block"></div>
                        <div class="col-md-7" style="display: inline-block">
                            <fieldset style="border: 1px solid lightgray; padding: 10px">
                                <legend>Status</legend>
                                <label for="status_pre_employment"><input type="radio" id="status_pre_employment" name="status">&emsp;Pre-Employment</label><br>
                                <label for="status_active"><input type="radio" id="status_active" name="status">&emsp;Active</label><br>
                                <label for="status_terminated"><input type="radio" id="status_terminated" name="status">&emsp;Terminated</label><br>
                            </fieldset>
                        </div>
                        <!-- <div class="col-md-2" style="display: inline-block">Location: </div><div class="col-md-7" style="display: inline-block"><select class="form-control"><option value="">Select Location</option></select></div> -->
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="addEmployee" onclick="addEmployees();">OK</button>
                <button type="button" class="btn btn-default" id="editEmployee" onclick="editEmployees();" style="display: none;">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" onclick="selected_fees = -1;" id="closeButton">Close</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Help</button>
            </div>
        </div>

    </div>
</div>

<div id="myModal_Employee_Import" class="modal fade" role="dialog" style="z-index: 99999999;">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Import Employees</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="display: inline-block">
                <div class="row">
                    <div class="col-md-8">
                        <fieldset style="border: 1px solid silver; padding: 10px;">
                            <legend style="padding-left: 10px; padding-right: 10px; width: auto; font-size: 12px; margin-bottom: 0rem;">Source File</legend>
                            <div class="row">
                                <div class="col-md-9">
                                    <input type="file" accept=".txt" id="input_file_to_import_employees" class="form-control">
                                </div>
                                <div class="col-md-3">

                                    <button class="btn btn-info" id="preview_now" disabled>Preview now</button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-md-4">
                        <fieldset style="border: 1px solid silver; padding: 10px;">
                            <legend style="padding-left: 10px; padding-right: 10px; width: auto; font-size: 12px; margin-bottom: 0rem;">Field Delimiter</legend>
                            <div class="form-group mb-0">
                                <div class="row">
                                    <div class="col-md-6 pr-0"><label class="mb-0" for="field_delimiter_tab"><input type="radio" checked name="field_delimiter" id="field_delimiter_tab">&emsp;TAB</label></div>
                                    <div class="col-md-6 pr-0"><input style="height: calc(2.00rem + 0px); width:100px; visibility: hidden" class="form-control"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 pr-0"><label for="field_delimiter_comma"><input type="radio" name="field_delimiter" id="field_delimiter_comma">&emsp;Comma</label>
                                    </div>
                                    <div class="col-md-6 pr-0"><input style="height: calc(2.00rem + 0px); width: 100px; visibility: hidden" class="form-control"></div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-md-6 pr-0"><label for="field_delimiter_f_width"><input type="radio" name="field_delimiter" id="field_delimiter_f_width">&emsp;Fixed Width :</label>
                                    </div>
                                    <div class="col-md-6 pr-0"><input style="height: calc(2.00rem + 0px)" class="form-control" id="field_delimiter_f_width_text" disabled type="number"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 pr-0"><label for="field_delimiter_other"><input type="radio" name="field_delimiter" id="field_delimiter_other">&emsp;Other:</label>
                                    </div>
                                    <div class="col-md-6 pr-0"><input style="height: calc(2.00rem + 0px)" class="form-control" id="field_delimiter_other_text" disabled type="text"></div>
                                </div> -->
                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <fieldset style="border: 1px solid silver; padding: 10px;">
                            <legend style="padding-left: 10px; padding-right: 10px; width: auto; font-size: 12px; margin-bottom: 0rem;">Data Mapping</legend>
                            <div class="row">
                                <div class="col-md-6"><label for="field_delimiter_tab">Field to be used for Employee ID / SSN</label></div>
                                <div class="col-md-6"><select class="form-control" id="field_map_employee_id" style="height: calc(2.00rem + 0px)">
                                        <option value=""></option>
                                    </select></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><label for="field_delimiter_tab">Field to be used for Employee First Name</label></div>
                                <div class="col-md-6"><select class="form-control" id="field_map_employee_first_name" style="height: calc(2.00rem + 0px)">
                                        <option value=""></option>
                                    </select></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><label for="field_delimiter_tab">Field to be used for Employee Last Name</label></div>
                                <div class="col-md-6"><select class="form-control" id="field_map_employee_last_name" style="height: calc(2.00rem + 0px)">
                                        <option value=""></option>
                                    </select></div>
                            </div>

                        </fieldset>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <fieldset style="border: 1px solid silver; padding: 10px;">
                            <legend style="padding-left: 10px; padding-right: 10px; width: auto; font-size: 12px; margin-bottom: 0rem;">Options</legend>
                            <div class="row">
                                <div class="col-md-6"><label for="field_delimiter_tab">Import to location</label></div>
                                <div class="col-md-6"><select class="form-control" style="height: calc(2.00rem + 0px)" id="division_id_import"></select></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><label for="field_delimiter_tab">Start import at row</label></div>
                                <div class="col-md-6"><input class="form-control" id="start_import_at_row" style="height: calc(2.00rem + 0px)" type="number" value="1" min="1" max="1"></div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <fieldset style="border: 1px solid silver; padding: 10px;">
                            <div class="row">
                                <div class="col-md-12 table-responsive" style="height: 150px; overflow: auto;">
                                    <table class="table table-striped" id="employee_imported_table">
                                        <thead id="import_employee_header"></thead>
                                        <tbody id="import_employee_body"></tbody>
                                    </table>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="importEmployee" onclick="importEmployees();" disabled>Import</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="closeButton">Close</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Help</button>
            </div>
        </div>

    </div>
</div>

<div id="myModal_Employee_Clear" class="modal fade" role="dialog" style="z-index: 99999999;">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Clear All Employees</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="display: inline-block">
                <div class="row">
                    <div class="col-md-12">
                        WARNING!!! Deleting employees will also delete all TESTS and INVOICE line items and everything else associated with the employees.
                        ARE YOU ABSOLUTELY SURE YOU WANT TO DELETE THE EMPLOYEES??
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="clearEmployees" onclick="clearEmployees();">Yes</button>
                <button type="button" class="btn btn-default" data-dismiss="modal" id="closeButtonClearEmployee">No</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Help</button>
            </div>
        </div>

    </div>
</div>


<div id="myModal_Send" class="modal fade" role="dialog">
    <div class="modal-dialog modal-xl">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Send Results</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <?php
            $contact_send = '';
            $email_send = '';
            if (
                isset($_GET['account']) &&
                $_GET['account'] != null &&
                $_GET['account'] != 'null' &&
                $_GET['account'] != ''
            ) {
                $sqlSend =
                    'SELECT * FROM acctsforemail WHERE (contact IS NOT NULL OR email IS NOT NULL) AND account_id = ' .
                    $_GET['account'];
                // echo $sqlSend;
                $resultSend = $conn->query($sqlSend);
                if ($resultSend->num_rows > 0) {
                    $rowSend = $resultSend->fetch_assoc();
                    $contact_send = $rowSend['contact'];
                    $email_send = $rowSend['email'];
                }
            }
            ?>
            <form id="form_send_email">
                <div class="modal-body" style="display: inline-block; width: 100%">
                    <div id="main_div">
                        <div class="row">
                            <div class="col-md-10" style="display: inline-block">
                                <div class="row">
                                    <div class="col-md-3" style="display: inline-block">Location: </div>
                                    <div class="col-md-9" style="display: inline-block">
                                        <select class="form-control" id="division_id_send" name="division_id_send" required></select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3" style="display: inline-block">Contact: </div>
                                    <div class="col-md-9" style="display: inline-block">
                                        <input class="form-control" id="contact_send" name="contact_send" required value="<?php echo $contact_send; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3" style="display: inline-block">Email Address: </div>
                                    <div class="col-md-9" style="display: inline-block">
                                        <input class="form-control" id="email_send" name="email_send" required value="<?php echo $email_send; ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3" style="display: inline-block">Message Subject: </div>
                                    <div class="col-md-9" style="display: inline-block">
                                        <input class="form-control" id="message_subject_send" required name="message_subject_send" value="Drug Test Results">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3" style="display: inline-block">Message Body: </div>
                                    <div class="col-md-9" style="display: inline-block">
                                        <textarea class="form-control" id="message_body_send" required name="message_body_send">(See Attached)</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3" style="display: inline-block">Format: </div>
                                    <div class="col-md-9" style="display: inline-block">
                                        <select class="form-control" id="format_send" required name="format_send">
                                            <option value="Text">Text</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2" style="display: inline-block">
                                <div class="row" style="visibility: hidden">
                                    <div class="col-md-3" style="display: inline-block">Location: </div>
                                    <div class="col-md-9" style="display: inline-block">
                                        <select class="form-control"></select>
                                    </div>
                                </div>

                                <div class="row" style="visibility: hidden">
                                    <div class="col-md-3" style="display: inline-block">Contact: </div>
                                    <div class="col-md-9" style="display: inline-block">
                                        <input class="form-control">
                                    </div>
                                </div>
                                <span style="font-size:11px;">For multiple email address, separate them with commas, for e.g. "xyz@abc.co,pqr@klm.com"</span>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default">OK</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="selected_fees = -1;" id="closeButton">Close</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Help</button>
                </div>
            </form>

        </div>

    </div>
</div>

<div id="myModal_Billing" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Billing Information</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="form_send_billing">
                <div class="modal-body" style="display: inline-block; width: 100%">
                    <div id="main_div">
                        <div class="row" id="billing_info_background">
                            <div class="col-md-6">
                                <fieldset style="border: 1px solid silver;padding: 0px 15px;">
                                    <legend style="font-size: 1rem;width:auto;padding:0px 10px;">Options</legend>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="doNotBill"><input type="radio" checked id="doNotBill" name="billedType" value="do_not_bill">&emsp;Do not bill selected tests</label>
                                            <label for="billNewInvoice"><input type="radio" id="billNewInvoice" name="billedType" value="new_invoice">&emsp;Bill on a new invoice</label>
                                            <label for="billExistingInvoice"><input type="radio" id="billExistingInvoice" name="billedType" value="existing_invoice">&emsp;Bill on an existing invoice</label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-md-6">
                                <fieldset style="border: 1px solid silver;padding: 0px 15px;">
                                    <legend style="font-size: 1rem;width:auto;padding:0px 10px;">Select Invoice</legend>
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <label for="invoiceNoBill">Invoice No:</label>
                                            <select class="form-control" id="invoiceNoBilled" name="invoiceNoBilled" disabled>
                                                <option selected disabled value="">Please select Invoice No</option>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <br>
                        <div class="row" id="rowBilledItemDiv" style="pointer-events: none; opacity: 0.7;">
                            <div class="col-md-12">
                                <!-- Tab links -->
                                <div class="tab">
                                    <button type="button" id="button_general" class="tablinks active" onclick="openCity(event, 'London')">General</button>
                                    <button type="button" id="button_tests_billed" class="tablinks" onclick="openCity(event, 'Paris')">Tests billed on this invoice</button>
                                </div>

                                <!-- Tab content -->
                                <div id="London" class="tabcontent" style="display: block; min-height: 200px;">
                                    <div class="row" style="display: none;">
                                        <div class="col-md-6" style="display: inline-block;">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <fieldset style="border: 1px solid silver;padding: 0px 15px;">
                                                        <legend style="font-size: 1rem;width:auto;padding:0px 10px;">Details</legend>
                                                        <div class="row">
                                                            <div class="col-md-4 my-row-4-label">
                                                                <label>Invoice No: </label>
                                                            </div>
                                                            <div class="col-md-8 my-row-8-input">
                                                                <input class="form-control" id="invoiceNoBill" name="invoiceNoBill" value="New Invoice" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 my-row-4-label">
                                                                <label>Invoice Date: </label>
                                                            </div>
                                                            <div class="col-md-8 my-row-8-input">
                                                                <input type="date" id="invoiceDateBill" name="invoiceDateBill" class="form-control" value="<?php echo date(
                                                                                                                                                                'Y-m-d'
                                                                                                                                                            ); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 my-row-4-label">
                                                                <label>Location: </label>
                                                            </div>
                                                            <div class="col-md-8 my-row-8-input">
                                                                <select class="form-control" id="division_id_bill" name="division_id_bill">
                                                                    <!-- <option value="">Select Location</option> -->
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 my-row-4-label">
                                                                <label>Reference: </label>
                                                            </div>
                                                            <div class="col-md-8 my-row-8-input">
                                                                <input id="invoiceReferenceBill" name="invoiceReferenceBill" class="form-control">
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <fieldset style="border: 1px solid silver;padding: 0px 15px;">
                                                        <legend style="font-size: 1rem;width:auto;padding:0px 10px;">Due</legend>
                                                        <div class="row">
                                                            <div class="col-md-4 my-row-4-label">
                                                                <label>Terms: </label>
                                                            </div>
                                                            <div class="col-md-8 my-row-8-input">
                                                                <select id="invoiceTermsBill" name="invoiceTermsBill" class="form-control">
                                                                    <option selected disabled value="">Please select Terms</option>
                                                                    <option value="30">30 Days</option>
                                                                    <option value="60">60 Days</option>
                                                                    <option value="90">90 Days</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 my-row-4-label">
                                                                <label>Due Date: </label>
                                                            </div>
                                                            <div class="col-md-8 my-row-8-input">
                                                                <input id="invoiceDueDateBill" name="invoiceDueDateBill" type="date" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 my-row-4-label">
                                                                <label for="sentBill"><input type="checkbox" id="sentBill" name="sentBill" value="T">&emsp;Sent</label>
                                                            </div>
                                                            <div class="col-md-8 my-row-8-input">
                                                                <input type="date" class="form-control" id="sentBillDate" name="sentBillDate" readonly>
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5" style="display: inline-block;">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <fieldset style="border: 1px solid silver;padding: 0px 15px;">
                                                        <legend style="font-size: 1rem;width:auto;padding:0px 10px;">Payment</legend>
                                                        <div class="row">
                                                            <div class="col-md-5 my-row-5-label">
                                                                <label>Amount Due: </label>
                                                            </div>
                                                            <div class="col-md-7 my-row-7-input">
                                                                <input type="number" id="invoiceAmountDueBill" name="invoiceAmountDueBill" class="form-control" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-5 my-row-5-label">
                                                                <label>Amount Paid: </label>
                                                            </div>
                                                            <div class="col-md-7 my-row-7-input">
                                                                <input type="number" id="invoiceAmountPaidBill" name="invoiceAmountPaidBill" class="form-control" value="0.00">
                                                            </div>
                                                        </div>
                                                        <br><br>
                                                        <div class="row">
                                                            <div class="col-md-5 my-row-5-label">
                                                                <label>Check No: </label>
                                                            </div>
                                                            <div class="col-md-7 my-row-7-input">
                                                                <input type="number" id="invoiceCheckNoBill" name="invoiceCheckNoBill" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-5 my-row-5-label">
                                                                <label>Check Date: </label>
                                                            </div>
                                                            <div class="col-md-7 my-row-7-input">
                                                                <input type="date" id="invoiceCheckDateBill" name="invoiceCheckDateBill" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-5 my-row-5-label">
                                                                <label>Pay Date: </label>
                                                            </div>
                                                            <div class="col-md-7 my-row-7-input">
                                                                <input type="date" id="invoicePayDateBill" name="invoicePayDateBill" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-5 my-row-5-label">
                                                            </div>
                                                            <div class="col-md-7 my-row-7-input">
                                                                <label for="paidInFull"><input type="checkbox" id="paidInFull" name="paidInFull" value="T">&emsp;Paid in Full</label>
                                                                <input type="hidden" id="test_id_added" name="test_id_added" value="">
                                                            </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="Paris" class="tabcontent" style="">
                                    <div class="table-responsive">
                                        <table id="tests_billed" class="table table-hover">
                                            <thead>
                                                <th>S.No</th>
                                                <th>Test No</th>
                                                <th>Emp Id</th>
                                                <th>First</th>
                                                <th>Last</th>
                                                <th>Type</th>
                                                <th>Test Date</th>
                                                <th>Amount</th>
                                            </thead>
                                            <tbody id="tbody_table_bill"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default">OK</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="selected_fees = -1;" id="closeButton">Close</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Help</button>
                </div>
            </form>

        </div>

    </div>
</div>
<script src="dist/js/adminlte.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
    const my_url = new URL(location.href);
    var my_url_location = my_url.pathname.split('/');
    my_url_location = my_url_location[my_url_location.length - 1];
    // console.log(my_url_location[my_url_location.length - 1])
    if (my_url_location == 'notBilledReport.php' || my_url_location == 'weeklyReport.php' ||
        my_url_location == 'billingReport.php' || my_url_location == 'labelsBillingReport.php' ||
        my_url_location == 'postBilledReport.php' ||
        my_url_location == 'unpaidInvoiceReport.php' || my_url_location == 'revenueReport.php' ||
        my_url_location == 'peopleSoftInfo.php') {
        $('#accounts_select').attr('disabled', true);
        $('#accounts_select').hide();
    }
</script>

<script>
    $('#btn_add_billing').click(function() {
        $('#test_id_added').val(new URL(location.href).searchParams.get("id"))

        $('#tbody_table_bill').html('');
        let id = new URL(location.href).searchParams.get("id");
        $.ajax({
            type: "GET",
            url: "getTestData.php?test_id=" + id + "&counter=1",
            success: function(resultData) {
                $('#tbody_table_bill').html(resultData);
            }
        });

    })
</script>
<script>
    var invoices_data = [];
    $('#sentBill').on('click', function() {
        if ($(this).is(':checked')) {
            $('#sentBillDate').attr('readonly', false);
        } else {
            $('#sentBillDate').attr('readonly', true);
            $('#sentBillDate').val('');
        }
    })
</script>
<script>
    $('#doNotBill').click(function() {
        $('#invoiceNoBill').val("");
        $('#invoiceDateBill').val("");
        $('#division_id_bill').val("");
        $('#invoiceReferenceBill').val("");
        $('#invoiceTermsBill').val("");
        $('#invoiceDueDateBill').val("");
        $('#sentBillDate').val("");
        $('#sentBill').attr("checked", false);
        $('#invoiceAmountDueBill').val("");
        $('#invoiceAmountPaidBill').val("0.00");
        $('#invoiceCheckNoBill').val("");
        $('#invoiceCheckDateBill').val("");
        $('#invoicePayDateBill').val("");
        $('#paidInFull').attr("checked", false);

        $('#rowBilledItemDiv').css('pointer-events', 'none');
        $('#rowBilledItemDiv').css('opacity', '0.7');
        // $('#London').html('');
        $('#London > .row').css('display', 'none');
        $('#London').css('display', 'block');
        $('#Paris').css('display', 'none');
        $('#button_general').addClass('active');
        $('#button_tests_billed').removeClass('active');
        $('#invoiceNoBilled').attr('disabled', 'disabled');
        $('#invoiceNoBilled').val('');
        $('#invoiceNoBilled').html('<option selected="" disabled="" value="">Please select Invoice No</option>');
        $('#invoiceNoBilled').trigger('change');

        let id = new URL(location.href).searchParams.get("id");
        console.log("id")
        console.log(id)
        $('#test_id_added').val(new URL(location.href).searchParams.get("id"))
    });
</script>
<script>
    $('#billNewInvoice').click(function() {
        $('#invoiceNoBill').val("");
        $('#invoiceDateBill').val("");
        // $('#division_id_bill').val("");
        $('#invoiceReferenceBill').val("");
        $('#invoiceTermsBill').val("");
        $('#invoiceDueDateBill').val("");
        $('#sentBillDate').val("");
        $('#sentBill').attr("checked", false);
        $('#invoiceAmountDueBill').val($('#getFeeAmount').val());
        $('#invoiceAmountPaidBill').val("0.00");
        $('#invoiceCheckNoBill').val("");
        $('#invoiceCheckDateBill').val("");
        $('#invoicePayDateBill').val("");
        $('#paidInFull').attr("checked", false);

        $('#rowBilledItemDiv').css('pointer-events', 'all');
        $('#rowBilledItemDiv').css('opacity', '1.0');
        $('#London > .row').css('display', 'block');
        $('#invoiceNoBill').val('New Invoice');
        // $('#London').html('');
        $('#London').css('display', 'block');
        $('#Paris').css('display', 'none');
        $('#button_general').addClass('active');
        $('#button_tests_billed').removeClass('active');
        $('#invoiceNoBilled').attr('disabled', 'disabled');
        $('#invoiceNoBilled').html('<option selected="" disabled="" value="">Please select Invoice No</option>');
        $('#invoiceNoBilled').trigger('change');
        let id = new URL(location.href).searchParams.get("id");
        console.log("id")
        console.log(id)
        $('#test_id_added').val(new URL(location.href).searchParams.get("id"))
    });
</script>
<script>
    $('#billExistingInvoice').click(function() {
        $('#rowBilledItemDiv').css('pointer-events', 'all');
        $('#rowBilledItemDiv').css('opacity', '1.0');
        $('#invoiceNoBill').val('');
        // $('#London').html('');
        $('#London > .row').css('display', 'block');
        $('#London').css('display', 'block');
        $('#Paris').css('display', 'none');
        $('#button_general').addClass('active');
        $('#button_tests_billed').removeClass('active');
        let id = new URL(location.href).searchParams.get("id");
        console.log("id")
        console.log(id)
        $('#test_id_added').val(new URL(location.href).searchParams.get("id"))
        let account = new URL(location.href).searchParams.get("account");
        $.ajax({
            type: "GET",
            url: "getInvoicesForBilling.php?account=" + account,
            success: function(resultData) {
                // $('#invoiceNoBilled').html(resultData);
                // $('#invoiceNoBilled').trigger('change');
                var content = '';
                let obj = JSON.parse(resultData);
                console.log(obj);
                for (i = 0; i < obj.length; i++) {
                    content += '<option value="' + obj[i].invoice_id + '">' + obj[i].invoice_id + '</option>';
                }
                $('#invoiceNoBilled').html(content);
                $('#invoiceNoBilled').trigger('change');
                invoices_data = obj;
                getDataForInvoice(invoices_data)
            }
        });

        $('#invoiceNoBilled').attr('disabled', false);
    });
</script>
<script>
    $('#btn_add_send').on('click', function() {
        // console.log('clicked');
        $('#division_id_send').val($("#location_select").val())
    })
</script>
<script>
    $('#status_pre_employment').prop('checked', true);
    if (sessionStorage.getItem('account_selected') != undefined && sessionStorage.getItem('account_selected') != null &&
        sessionStorage.getItem('account_selected') != '') {
        $.ajax({
            type: "GET",
            url: "get_location_testinfo.php",
            data: 'account_id_location=' + sessionStorage.getItem('account_selected'),
            success: function(resultData) {
                $('#division_id').html(resultData);
                $('#division_id_bill').html(resultData);
                $('#division_id_import').html(resultData);
                // window.open("accounts.php", "_self");
            }
        });

    }
    // })
</script>
<script>
    $('#specimen_id').on('change', function() {
        $('#specimen_id').removeClass('validation-error')
    });
    $('#emp_id').on('change', function() {
        $('#emp_id').removeClass('validation-error')
    });
    $('#first_nm').on('change', function() {
        $('#first_nm').removeClass('validation-error')
    });
    $('#last_nm').on('change', function() {
        $('#last_nm').removeClass('validation-error')
    });
    $('#division_id').on('change', function() {
        $('#division_id').removeClass('validation-error')
    });
    $('#accounts_select').on('change', function() {
        $('#accounts_select').removeClass('validation-error')
    });
</script>
<script>
    function addEmployees() {
        error_validateForm = validateEmployee();
        if (!error_validateForm) {
            var temp = {};
            temp['emp_id'] = $('#emp_id').val();
            temp['specimen_id'] = $('#specimen_id').val();
            temp['first_nm'] = $('#first_nm').val();
            temp['last_nm'] = $('#last_nm').val();
            temp['division_id'] = $('#division_id').val();
            temp['account_id'] = $('#accounts_select').val();
            temp['status'] = '';
            if ($('#status_pre_employment').is(':checked'))
                temp['status'] = 'P';
            else if ($('#status_active').is(':checked'))
                temp['status'] = 'A';
            else if ($('#status_terminated').is(':checked'))
                temp['status'] = 'T';

            // $('#emp_id').val('');
            // $('#specimen_id').val('');
            // $('#first_nm').val('');
            // $('#last_nm').val('');
            // $('#division_id').val('');
            // $('#status_pre_employment').prop('checked', false);
            // $('#status_active').prop('checked', false);
            // $('#status_terminated').prop('checked', false);
            // $('#employeesindex').val('');

            $.ajax({
                type: "POST",
                url: "insert_employee.php",
                data: 'employeeData=' + JSON.stringify(temp),
                success: function(resultData) {
                    resultData = JSON.parse(resultData);
                    console.log(resultData);
                    console.log("" + resultData.id);
                    alert(resultData.message);
                    if (resultData.id !== undefined)
                        window.open(location.pathname.split('/')[location.pathname.split('/').length - 1] + '?account=' + sessionStorage.getItem('account_selected') + '&employee=' + resultData.id, '_self');
                    else {
                        // $('#closeButton').click();
                        //    $('#myModal_Employee').modal('toggle');
                        //     $('#myModal_Employee').css('display', 'block');
                    }

                    // location.reload();
                    // window.open("accounts.php", "_self");
                }
            });
        }
    }

    function editEmployees() {
        error_validateForm = validateEmployee();
        if (!error_validateForm) {
            var temp = {};
            temp['emp_id'] = $('#emp_id').val();
            temp['specimen_id'] = $('#specimen_id').val();
            temp['first_nm'] = $('#first_nm').val();
            temp['last_nm'] = $('#last_nm').val();
            temp['division_id'] = $('#division_id').val();
            temp['account_id'] = $('#accounts_select').val();
            temp['status'] = '';
            if ($('#status_pre_employment').is(':checked'))
                temp['status'] = 'P';
            else if ($('#status_active').is(':checked'))
                temp['status'] = 'A';
            else if ($('#status_terminated').is(':checked'))
                temp['status'] = 'T';

            // $('#emp_id').val('');
            // $('#specimen_id').val('');
            // $('#first_nm').val('');
            // $('#last_nm').val('');
            // $('#division_id').val('');
            // $('#status_pre_employment').prop('checked', false);
            // $('#status_active').prop('checked', false);
            // $('#status_terminated').prop('checked', false);
            // $('#employeesindex').val('');

            $.ajax({
                type: "POST",
                url: "insert_employee.php",
                data: 'employeeData=' + JSON.stringify(temp),
                success: function(resultData) {
                    resultData = JSON.parse(resultData);
                    console.log(resultData);
                    console.log("" + resultData.id);
                    alert(resultData.message);
                    if (resultData.id !== undefined)
                        window.open(location.pathname.split('/')[location.pathname.split('/').length - 1] + '?account=' + sessionStorage.getItem('account_selected') + '&employee=' + resultData.id, '_self');
                    else {
                        // $('#closeButton').click();
                        //    $('#myModal_Employee').modal('toggle');
                        //     $('#myModal_Employee').css('display', 'block');
                    }

                    // location.reload();
                    // window.open("accounts.php", "_self");
                }
            });
        }
    }

    function validateEmployee() {
        var error_validateForm = false;
        // $('#myModal_Employee').modal('hide');
        if ($('#specimen_id').val() == '') {
            // $('#specimen_id').focus();
            // alert('Kindly enter Specimen Id.');
            // return;
            $('#specimen_id').addClass('validation-error')
            error_validateForm = true;
        }
        if ($('#emp_id').val() == '') {
            $('#emp_id').addClass('validation-error')
            // $('#emp_id').focus();
            // alert('Kindly enter Employee Id.');
            // return;
            error_validateForm = true;
        }
        if ($('#first_nm').val() == '') {
            $('#first_nm').addClass('validation-error')
            // $('#first_nm').focus();
            // alert('Kindly enter First Name.');
            // return;
            error_validateForm = true;
        }
        if ($('#last_nm').val() == '') {
            $('#last_nm').addClass('validation-error')
            // $('#last_nm').focus();
            // alert('Kindly enter Last Name.');
            // return;
            error_validateForm = true;
        }
        if ($('#division_id').val() == '') {
            $('#division_id').addClass('validation-error')
            // $('#division_id').focus();
            // alert('Kindly select Location.');
            // return;
            error_validateForm = true;
        }
        if ($('#accounts_select').val() == '') {
            $('#accounts_select').addClass('validation-error')
            // $('#accounts_select').focus();
            // alert('Kindly select Account.');
            // return;
            error_validateForm = true;
        }
        if (!$('#status_pre_employment').is(':checked') && !$('#status_active').is(':checked') && !$('#status_terminated').is(':checked')) {
            $('#status_pre_employment').focus();
            alert('Kindly select status of Employee.');
            // return;
            error_validateForm = true;
        }
        return error_validateForm;
    }
</script>
<script>
    $('#form_send_email').on('submit', function(e) {
        let id = new URL(location.href).searchParams.get("id");
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: "viewMROReportSend.php?id=" + id,
            data: $("#form_send_email").serialize(),
            success: function(resultData) {
                console.log($("#form_send_email").serialize())
                console.log(resultData)
                alert(resultData);
                location.reload();
                // window.open("landingscreen.php", "_self");
            }
        });

    })
</script>
<script>
    function addPreferences() {
        // $('#myModal_Preferences').modal('hide');
        var temp = {};
        temp['practitioner_default'] = $('#practitioner_default').val();
        temp['lab_default'] = $('#lab_default').val();
        temp['sampleType_default'] = $('#sampleType_default').val();
        temp['testType_default'] = $('#testType_default').val();
        temp['testReason_default'] = $('#testReason_default').val();
        console.log(temp);
        $.ajax({
            type: "POST",
            url: "insert_preferences.php",
            data: 'preferencesData=' + JSON.stringify(temp),
            success: function(resultData) {
                console.log(resultData);
                alert(resultData);
                location.reload();
                // window.open(location.pathname.split('/')[location.pathname.split('/').length - 1] + '?account=' + sessionStorage.getItem('account_selected'), '_self') + '&employee=' + resultData;
                // window.open("accounts.php", "_self");
            }
        });
    }
</script>



<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<!-- <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
<!-- overlayScrollbars -->
<!-- <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script> -->
<!-- AdminLTE App -->
<!-- <script src="dist/js/adminlte.js"></script> -->

<!-- OPTIONAL SCRIPTS -->
<!-- <script src="dist/js/demo.js"></script> -->

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<!-- <script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script> -->
<!-- <script src="plugins/raphael/raphael.min.js"></script> -->
<!-- <script src="plugins/jquery-mapael/jquery.mapael.min.js"></script> -->
<!-- <script src="plugins/jquery-mapael/maps/world_countries.min.js"></script> -->
<!-- ChartJS -->
<!-- <script src="plugins/chart.js/Chart.min.js"></script> -->

<!-- PAGE SCRIPTS -->
<!-- <script src="dist/js/pages/dashboard2.js"></script> -->
<!-- <script src="dist/js/owl.carousel.min.js"></script> -->
<script src="plugins/select2/js/select2.min.js"></script>
<script>
    function openCity(evt, cityName) {
        // Declare all variables
        var i, tabcontent, tablinks;

        // Get all elements with class="tabcontent" and hide them
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
<script>
    let account = new URL(location.href).searchParams.get("account");

    if (sessionStorage.getItem('account_selected') != undefined && sessionStorage.getItem('account_selected') != null && sessionStorage.getItem('account_selected') != 'null' &&
        sessionStorage.getItem('account_selected') != '') {
        $('#accounts_select').val(sessionStorage.getItem('account_selected'));
        $('#accounts_select').trigger('change');
    } else if ($('#accounts_select').val() != '' && $('#accounts_select').val() != null) {
        sessionStorage.setItem('account_selected', $('#accounts_select').val());
    } else if (account != '' && account != 'null' && account != undefined && account != null) {
        sessionStorage.setItem('account_selected', account);
        $('#accounts_select').val(account);
        $('#accounts_select').trigger('change');
    } else {
        $('.btn').css('pointer-events', 'none');
        $('.sidebar').css('pointer-events', 'none');
        $('.nav-link-disabler').css('pointer-events', 'none');
    }
    $('#accounts_select').on('change', function() {
        sessionStorage.setItem('account_selected', $(this).val());
        window.open(location.pathname.split('/')[location.pathname.split('/').length - 1] + '?account=' +
            sessionStorage.getItem('account_selected'), '_self');
    })
</script>
<script>
    function openURL(url) {
        if (sessionStorage.getItem('account_selected') != undefined && sessionStorage.getItem('account_selected') != null &&
            sessionStorage.getItem('account_selected') != '')
            window.open(url + '?account=' + sessionStorage.getItem('account_selected'), '_self');
        else
            window.open(url, '_self');
    }
</script>
<script>
    if ((account == null || account == '') && $('#accounts_select').val() != '') {
        window.open(location.pathname.split('/')[location.pathname.split('/').length - 1] + '?account=' + $('#accounts_select').val(), '_self');
    }
</script>
<script>
    $(window).resize(function() {

        if ($(window).width() > 800) {
            $("body").removeClass('sidebar-collapse');
            $("body").addClass('sidebar-expand');
        } else {
            $("body").removeClass('sidebar-expand');
            $("body").addClass('sidebar-collapse');
        }
    });

    $('#field_delimiter_tab').on('click', function() {
        $('#field_delimiter_other_text').val();
        $('#field_delimiter_other_text').prop('disabled', true);
        $('#field_delimiter_f_width_text').val();
        $('#field_delimiter_f_width_text').prop('disabled', true);
        validateImportEmployee();
    })

    $('#field_delimiter_comma').on('click', function() {
        $('#field_delimiter_other_text').val();
        $('#field_delimiter_other_text').prop('disabled', true);
        $('#field_delimiter_f_width_text').val();
        $('#field_delimiter_f_width_text').prop('disabled', true);
        validateImportEmployee();
    })

    $('#field_delimiter_f_width').on('click', function() {
        $('#field_delimiter_other_text').val();
        $('#field_delimiter_other_text').prop('disabled', true);
        $('#field_delimiter_f_width_text').val();
        $('#field_delimiter_f_width_text').prop('disabled', false);
        validateImportEmployee();
    })

    $('#field_delimiter_other').on('click', function() {
        $('#field_delimiter_other_text').val();
        $('#field_delimiter_other_text').prop('disabled', false);
        $('#field_delimiter_f_width_text').val();
        $('#field_delimiter_f_width_text').prop('disabled', true);
        validateImportEmployee();
    })

    var text;
    $('#input_file_to_import_employees').on('change', function(event) {
        console.log($('#preview_now').prop('disabled'))
        var input = event.target;
        if ($(this).prop('files')[0].type == 'text/plain')
            $('#preview_now').prop('disabled', false);
        else
            $('#preview_now').prop('disabled', true);
        console.log($(this).prop('files')[0]);
        var reader = new FileReader();
        reader.onload = function() {
            text = reader.result;
        };
        reader.readAsText(input.files[0]);
        validateImportEmployee();
    })

    $('#field_map_employee_id').on('change', function() {
        validateImportEmployee();
    });
    $('#field_map_employee_first_name').on('change', function() {
        validateImportEmployee();
    });
    $('#field_map_employee_last_name').on('change', function() {
        validateImportEmployee();
    });

    var import_employees_data = [];

    $('#preview_now').on('click', function() {
        var max_columns = 0;
        var delimiter = ($('#field_delimiter_tab').is(':checked')) ? '\t' : ',';
        var lines = text.split('\n');
        for (var line = 0; line < lines.length; line++) {
            var tabs = lines[line].split(delimiter);
            if (tabs.length > max_columns)
                max_columns = tabs.length;
        }

        var header_content = '';
        var body_content = '';
        var data_mapping_content = '<option value=""></option>';
        for (i = 1; i <= max_columns; i++) {
            header_content += '<th>Field ' + i + '</th>';
            data_mapping_content += '<option value="Field ' + i + '">Field ' + i + '</option>';
        }

        $('#import_employee_header').html(header_content)
        $('#field_map_employee_id').html(data_mapping_content)
        $('#field_map_employee_first_name').html(data_mapping_content)
        $('#field_map_employee_last_name').html(data_mapping_content)

        console.log("length: " + max_columns)

        var lines = text.split('\n');
        for (var line = 0; line < lines.length; line++) {
            var tabs = lines[line].split(delimiter);
            if (tabs.length > 0) {
                $('#start_import_at_row').prop('max', line);

                body_content += '<tr>';
                var employee_row = [];
                for (var tab = 0; tab < tabs.length; tab++) {
                    body_content += '<td>';
                    body_content += tabs[tab];

                    console.log(tabs[tab]);
                    employee_row.push(tabs[tab].replace('\r', ''));
                    body_content += '</td>';

                }
                import_employees_data[line] = employee_row;
            }
            body_content += '</tr>';
        }
        $('#import_employee_body').html(body_content)
        console.log(import_employees_data);
        validateImportEmployee();
    })

    $('#start_import_at_row').on('change', function() {
        if (parseInt($(this).val()) < parseInt($(this).prop('min')))
            $(this).val($(this).prop('min'))
        if (parseInt($(this).val()) > parseInt($(this).prop('max')))
            $(this).val($(this).prop('max'))
        validateImportEmployee();
    })

    function validateImportEmployee() {
        $('#importEmployee').prop('disabled', true);
        if ($('#preview_now').prop('disabled') == true)
            return false;
        if ($('#field_map_employee_id').val() == '')
            return false;
        if ($('#field_map_employee_first_name').val() == '')
            return false;
        if ($('#field_map_employee_last_name').val() == '')
            return false;
        if ($('#start_import_at_row').val() == '')
            return false;

        $('#importEmployee').prop('disabled', false);
    }
</script>

<script>
    function exportEmployees() {
        var content = '';
        $('#table_employees').find('tr').each(function() {
            // console.log($(this)[0].childElementCount)
            var maxRowChild = $(this)[0].childElementCount;
            console.log("$(this)[0].childElementCount: " + $(this)[0].childElementCount)
            if ($(this)[0].childElementCount > 1) {
                $(this).find('td').each(function() {
                    console.log("$(this)[0].cellIndex: " + $(this)[0].cellIndex)
                    var textval = $(this).text(); // this will be the text of each <td>
                    // console.log("textval: " + textval);
                    content += textval;
                    if (maxRowChild - 1 != $(this)[0].cellIndex)
                        content += '\t';
                });
                content += '\n';
            }
        });

        let filename = "employee_export.txt";
        let text = content;
        let blob = new Blob([text], {
            type: 'text/plain'
        });
        let link = document.createElement("a");
        link.download = filename;
        //link.innerHTML = "Download File";
        link.href = window.URL.createObjectURL(blob);
        document.body.appendChild(link);
        link.click(); 
        setTimeout(() => {
            document.body.removeChild(link);
            window.URL.revokeObjectURL(link.href);
        }, 100);
    }
</script>
<script>
    function importEmployees() {
        importData = {
            'employee_id': $('#field_map_employee_id').val(),
            'employee_first_nm': $('#field_map_employee_first_name').val(),
            'employee_last_nm': $('#field_map_employee_last_name').val(),
            'account': $('#account_id').val(),
            'location': $('#division_id_import').val(),
            'start_at_row': $('#start_import_at_row').val(),
            'employees_data': import_employees_data
        };
        console.log('importData', importData);
        console.log('importData=' + JSON.stringify(importData))
        $.ajax({
            type: "POST",
            url: "import_employees.php",
            data: 'importData=' + JSON.stringify(importData),
            success: function(resultData) {
                console.log(resultData);
                propertiesClicked();
                // alert(resultData);
                // // windo
                // window.open("accounts.php", "_self");
            }
        });
    }

    function clearEmployees() {
        $.ajax({
            type: "POST",
            url: "clear_employees.php",
            data: 'data=' + selected_accounts,
            success: function(resultData) {
                console.log(resultData);
                $('#closeButtonClearEmployee').click();
                // $('#myModal_Employee_Clear').modal('toggle');
                // $('body').removeClass('modal-open');
                propertiesClicked();
                // alert(resultData);
                // // windo
                // window.open("accounts.php", "_self");
            }
        });
    }
</script>
<script>
    $('#form_send_billing').on('submit', function(event) {
        event.preventDefault();
        let formData = $(this).serialize();
        formData += '&account_id_bill=' + $('#accounts_select').val() + '&invoiceNoBilled=' + $('#invoiceNoBilled').val()
        console.log(formData);
        $.ajax({
            type: "POST",
            url: "insert_invoice.php",
            data: formData,
            success: function(resultData) {
                console.log(resultData);
                alert(resultData);
                window.open('invoice.php', '_self');
                // console.log(location.pathname.split('/')[location.pathname.split('/').length - 1])
                // if(location.pathname.split('/')[location.pathname.split('/').length - 1] == 'invoice.php') {
                //     location.reload();
                // }
                // $('#myModal_Billing').modal('hide');
                // $('body').removeClass('modal-open');
                // $('.modal-backdrop').remove();
                // refreshBillingModal();
                // // windo
                // window.open("accounts.php", "_self");
            }
        });
    })

    function refreshBillingModal() {
        $('#invoiceNoBill').val("");
        $('#invoiceDateBill').val("");
        // $('#division_id_bill').val("");
        $('#invoiceReferenceBill').val("");
        $('#invoiceTermsBill').val("");
        $('#invoiceDueDateBill').val("");
        $('#sentBillDate').val("");
        $('#sentBill').attr("checked", false);
        $('#invoiceAmountDueBill').val('');
        $('#invoiceAmountPaidBill').val("0.00");
        $('#invoiceCheckNoBill').val("");
        $('#invoiceCheckDateBill').val("");
        $('#invoicePayDateBill').val("");
        $('#paidInFull').attr("checked", false);

        $('#rowBilledItemDiv').css('pointer-events', 'all');
        $('#rowBilledItemDiv').css('opacity', '1.0');
        $('#London > .row').css('display', 'block');
        $('#invoiceNoBill').val('New Invoice');
        // $('#London').html('');
        $('#London').css('display', 'block');
        $('#Paris').css('display', 'none');
        $('#button_general').addClass('active');
        $('#button_tests_billed').removeClass('active');
        $('#invoiceNoBilled').attr('disabled', 'disabled');
        $('#invoiceNoBilled').html('<option selected="" disabled="" value="">Please select Invoice No</option>');
        $('#invoiceNoBilled').trigger('change');
        $('#test_id_added').val('')
        $('#tbody_table_bill').html('');
    }
</script>