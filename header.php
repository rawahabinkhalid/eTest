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
<!-- <script src="jquery-3.4.1.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="col-md-6 col-sm-6">
    <div class="input-group input-group-sm">
        <?php if ($_SESSION['usertype'] == 'admin') { ?>

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
        <?php } else if ($_SESSION['usertype'] == 'accounts') { ?>
        <select class="form-control" id="accounts_select">
            <?php
                        $sql = 'SELECT * FROM accounts WHERE account_id=' . $_SESSION['accountid'];
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option selected value="' .
                                    $row['account_id'] .
                                    '">' .
                                    $row['account_nm'] .
                                    '</option>';
                            }
                        }
                        ?>
        </select>

        <?php } ?>
    </div>
</div>
<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
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
<?php if ($_SESSION['usertype'] == 'guest') { ?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
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
                <li class="nav-item">
                    <a href="personal.php" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Personal
                        </p>
                    </a>
                </li>
                <!-- <li class="nav-item has-treeview">
                    <a href="landingscreen.php" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            MRO review / New Test
                        </p>
                    </a>
                </li> -->


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>


<?php } else if ($_SESSION['usertype'] == 'accounts') { ?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
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


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>


<?php } else if ($_SESSION['usertype'] == 'admin') { ?>





<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
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
                    <a href="landingscreen.php" class="nav-link">
                        <!-- <a href="" class="nav-link"> -->
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            MRO review / New Test
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="viewInvoice.php" class="nav-link">
                        <!-- <a href="" class="nav-link"> -->
                        <i class="nav-icon fas fa-copy "></i>
                        <p>
                            Invoice
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
                        <li class="nav-item" style="pointer-events: none;">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New</p>
                            </a>
                        </li>
                        <li class="nav-item" style="pointer-events: none;">
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
                        </li>
                        <li class="nav-item" style="pointer-events: none;">
                            <a href="" class="nav-link">
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
                                    <a href="" class="nav-link" data-toggle="modal" data-target="#myModal_Employee"
                                        id="btn_add_employees">
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
                                    <a href="invoice.php" class="nav-link">
                                        &emsp;&emsp;<i class="far fa-circle nav-icon"></i>
                                        <p>&emsp;&emsp;Invoices</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item" style="pointer-events: none;">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Retrieve...</p>
                            </a>
                        </li>
                        <li class="nav-item" style="pointer-events: none;">
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
                        </li>
                        <li class="nav-item" style="pointer-events: none;">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Printer Setup...</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link" data-toggle="modal" data-target="#myModal_Preferences"
                                id="btn_add_preferences">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Preferences</p>
                            </a>
                        </li>
                        <li class="nav-item" style="pointer-events: none;">
                            <a href="" class="nav-link">
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
                        <li class="nav-item" style="pointer-events: none;">
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
                        </li>
                        <li class="nav-item" style="pointer-events: none;">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Refresh</p>
                            </a>
                        </li>
                        <li class="nav-item" style="pointer-events: none;">
                            <a href="" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sort</p>
                            </a>
                        </li>
                        <li class="nav-item" style="pointer-events: none;">
                            <a href="" class="nav-link">
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
                            <a href="" class="nav-link">
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
                            <a href="practitioners.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Practitioners</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="laboratories.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Laboritories</p>
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
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a onclick="openURL('accounts_fees.php');" href="javascript:void();" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Accounts Fees Report</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a onclick="openURL('bedsReport.php');" href="javascript:void();" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Monthly Beds Report</p>
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
                            <a onclick="openURL('weeklyReport.php');" href="javascript:void();" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Weekly Funding Test</p>
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
                            <a onclick="openURL('labelsBillingReport.php');" href="javascript:void();" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Labels For Billing Report</p>
                            </a>
                        </li>
                    </ul>
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
                            <a onclick="openURL('frandReport.php');" href="javascript:void();" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Frandomdotemplqry</p>
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
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a onclick="openURL('misReport.php');" href="javascript:void();" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>MIS Report</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a onclick="openURL('revenueReport.php');" href="javascript:void();" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Revenue Report</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a onclick="openURL('testResult.php');" href="javascript:void();" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Alere Report</p>
                            </a>
                        </li>
                    </ul>
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
                <li class="nav-item">
                    <a href="accountsManagement.php" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Accounts Management
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<?php
}?>

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
                    if($resultPreferences->num_rows > 0) {
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
                                        $sqlPractitioner = 'SELECT * FROM `practitioner` ORDER BY `practitioner`.`practitioner_nm` ASC';
                                        $resultPractitioner = $conn->query($sqlPractitioner);
                                        if($resultPractitioner->num_rows > 0) {
                                            while($rowPractitioner = $resultPractitioner->fetch_assoc()) {
                                                echo '<option value="'.$rowPractitioner['practitioner_id'].'"';
                                                if(isset($rowPreferences['practitioner_id']))
                                                    if($rowPractitioner['practitioner_id'] == $rowPreferences['practitioner_id'])
                                                        echo 'selected';
                                                echo '>'.$rowPractitioner['practitioner_nm'].'</option>';
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
                                        $sqlLab = 'SELECT * FROM `lab` ORDER BY `lab`.`lab_nm` ASC';
                                        $resultLab = $conn->query($sqlLab);
                                        if($resultLab->num_rows > 0) {
                                            while($rowLab = $resultLab->fetch_assoc()) {
                                                echo '<option value="'.$rowLab['lab_id'].'"';
                                                if(isset($rowPreferences['lab_id']))
                                                    if($rowLab['lab_id'] == $rowPreferences['lab_id'])
                                                        echo 'selected';
                                                echo '>'.$rowLab['lab_nm'].'</option>';
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
                                        $sqlSampleType = 'SELECT * FROM `sampletype` ORDER BY `sampletype`.`sample_nm` ASC';
                                        $resultSampleType = $conn->query($sqlSampleType);
                                        if($resultSampleType->num_rows > 0) {
                                            while($rowSampleType = $resultSampleType->fetch_assoc()) {
                                                echo '<option value="'.$rowSampleType['sample_id'].'"';
                                                if(isset($rowPreferences['sample_id']))
                                                    if($rowSampleType['sample_id'] == $rowPreferences['sample_id'])
                                                        echo 'selected';
                                                echo '>'.$rowSampleType['sample_nm'].'</option>';
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
                                        $sqlTestType = 'SELECT * FROM `testtype` ORDER BY `testtype`.`type_nm` ASC';
                                        $resultTestType = $conn->query($sqlTestType);
                                        if($resultTestType->num_rows > 0) {
                                            while($rowTestType = $resultTestType->fetch_assoc()) {
                                                echo '<option value="'.$rowTestType['type_id'].'"';
                                                if(isset($rowPreferences['type_id']))
                                                    if($rowTestType['type_id'] == $rowPreferences['type_id'])
                                                        echo 'selected';
                                                echo '>'.$rowTestType['type_nm'].'</option>';
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
                                        $sqlTestReason = 'SELECT * FROM `reasons` ORDER BY `reasons`.`reason_nm` ASC';
                                        $resultTestReason = $conn->query($sqlTestReason);
                                        if($resultTestReason->num_rows > 0) {
                                            while($rowTestReason = $resultTestReason->fetch_assoc()) {
                                                echo '<option value="'.$rowTestReason['reason_id'].'"';
                                                if(isset($rowPreferences['reason_id']))
                                                    if($rowTestReason['reason_id'] == $rowPreferences['reason_id'])
                                                        echo 'selected';
                                                echo '>'.$rowTestReason['reason_nm'].'</option>';
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
                <button type="button" class="btn btn-default" data-dismiss="modal"
                    onclick="selected_fees = -1;">Close</button>
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
                        <div class="col-md-2" style="display: inline-block">Employee ID (SSN): </div>
                        <div class="col-md-7" style="display: inline-block">
                            <input type="hidden" id="employeesindex" name="employeesindex" value="">
                            <input class="form-control" id="emp_id" name="emp_id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2" style="display: inline-block">First Name / Req No: </div>
                        <div class="col-md-7" style="display: inline-block">
                            <input class="form-control" id="first_nm" name="first_nm">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2" style="display: inline-block">Last Name: </div>
                        <div class="col-md-7" style="display: inline-block">
                            <input class="form-control" id="last_nm" name="last_nm">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2" style="display: inline-block">Location: </div>
                        <div class="col-md-7" style="display: inline-block">
                            <select class="form-control" id="division_id" name="division_id">
                                <!-- <option value="">Select Location</option> -->
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2" style="display: inline-block"></div>
                        <div class="col-md-7" style="display: inline-block">
                            <fieldset style="border: 1px solid lightgray; padding: 10px">
                                <legend>Status</legend>
                                <label for="status_pre_employment"><input type="radio" id="status_pre_employment"
                                        name="status">&emsp;Pre-Employment</label><br>
                                <label for="status_active"><input type="radio" id="status_active"
                                        name="status">&emsp;Active</label><br>
                                <label for="status_terminated"><input type="radio" id="status_terminated"
                                        name="status">&emsp;Terminated</label><br>
                            </fieldset>
                        </div>
                        <!-- <div class="col-md-2" style="display: inline-block">Location: </div><div class="col-md-7" style="display: inline-block"><select class="form-control"><option value="">Select Location</option></select></div> -->
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" onclick="addEmployees();">OK</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"
                    onclick="selected_fees = -1;">Close</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Help</button>
            </div>
        </div>

    </div>
</div>



<script>
if (sessionStorage.getItem('account_selected') != undefined && sessionStorage.getItem('account_selected') != null &&
    sessionStorage.getItem('account_selected') != '') {
    $.ajax({
        type: "GET",
        url: "get_location_testinfo.php",
        data: 'account_id_location=' + sessionStorage.getItem('account_selected'),
        success: function(resultData) {
            $('#division_id').html(resultData);
            // window.open("accounts.php", "_self");
        }
    });

}
// })

function addEmployees() {
    $('#myModal_Employee').modal('hide');
    var temp = {};
    temp['emp_id'] = $('#emp_id').val();
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

    $('#emp_id').val('');
    $('#first_nm').val('');
    $('#last_nm').val('');
    $('#division_id').val('');
    $('#status_pre_employment').prop('checked', false);
    $('#status_active').prop('checked', false);
    $('#status_terminated').prop('checked', false);
    $('#employeesindex').val('');

    $.ajax({
        type: "POST",
        url: "insert_employee.php",
        data: 'employeeData=' + JSON.stringify(temp),
        success: function(resultData) {
            console.log(resultData);
            alert(resultData);
            location.reload();
            // window.open("accounts.php", "_self");
        }
    });
}

function addPreferences() {
    $('#myModal_Preferences').modal('hide');
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
            // window.open("accounts.php", "_self");
        }
    });
}
</script>



<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="dist/js/demo.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/world_countries.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
<script src="dist/js/pages/dashboard2.js"></script>
<script src="dist/js/owl.carousel.min.js"></script>
<script>
if (sessionStorage.getItem('account_selected') != undefined && sessionStorage.getItem('account_selected') != null &&
    sessionStorage.getItem('account_selected') != '')
    $('#accounts_select').val(sessionStorage.getItem('account_selected'));
$('#accounts_select').on('change', function() {
    sessionStorage.setItem('account_selected', $(this).val());
    // console.log(location)
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