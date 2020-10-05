<?php
include_once 'conn.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>eTest</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="dist/css/daterangepicker.css" />

    <style>
    label {
        /* Other styling... */
        text-align: right;
        clear: both;
        float: left;
        margin-right: 15px;
    }

    tbody>tr:hover {
        background-color: rgba(0, 0, 0, .35);
    }

    @media print {    
        .no-print, .no-print *
        {
            display: none !important;
        }
    }
    </style>
    
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to to the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

<body class="sidebar-mini layout-fixed sidebar-expand">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <!-- <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li> -->
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="index.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> -->
            </ul>

            <!-- SEARCH FORM -->
            <!-- <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form> -->

            <?php include 'header.php'; ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark"><b>Accounts Fees Report</b></h1>
                                <h6 class="m-0 text-dark">As of <?php echo date(
                                    'd-M-Y H:i:s'
                                ); ?></h6>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Accounts Fees Report
                                    </li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        <form action="" method="POST" class="">
                            <div class="row no-print">
                                <div class="col-md-4">
                                    Account&emsp;
                                    <select name="account_filter" class="form-control" required style="width: calc(100% - 80px); display: inline-block;"><option value="">Please select an Account</option>
                                    <?php
                                    $sql = 'SELECT * FROM accounts';
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<option value="' .
                                                $row['account_id'] .
                                                '"';
                                            if (
                                                isset(
                                                    $_POST['account_filter']
                                                ) &&
                                                $row['account_id'] ==
                                                    $_POST['account_filter']
                                            ) {
                                                echo ' selected ';
                                            }
                                            echo '>' .
                                                $row['account_nm'] .
                                                '</option>';
                                        }
                                    }
                                    ?>
                                    </select>
                                </div>
                                <div class="col-md-5">
                                    <!-- Date Range&emsp; -->
                                    <!-- <select class="form-control" style="width: calc(100% - 100px); display: inline-block;"><option>Please select Date Range</option> -->
                                    <!-- <input type="hidden" class="form-control" name="daterange" id="daterange" style="width: calc(100% - 100px); display: inline-block;" />
                                    <div id="reportrange" style="width: calc(100% - 100px) !important; display: inline-block; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> <i class="fa fa-caret-down"></i>
                                    </div> -->
                                </div>
                                <div class="col-md-3" style="text-align: right">
                                    <button type="submit" name="filterData" class="btn mt-2"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100px;">Filter</button>
                                    <button type="button" id="deleteButton" class="btn mt-2"
                                    onclick="window.open('accounts_fees.php', '_self');" style="background-color:#E7D7B7; border-radius:5px; width: 100px;">Reset</button>
                                </div>
                            </div>
                            
                        <!-- </form> -->
                        <!-- <br><br> -->
                        <?php if (
                            isset($_POST['filterData']) &&
                            isset($_POST['account_filter'])
                        ) { ?>
                        <!-- <form action="" method="POST" class=""> -->
                            <div class="row no-print">
                                <div class="col-md-12" style="text-align: right">
                                    <button type="submit"  name="filterData" class="btn mt-2"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100px;">Retrieve</button>
                                    <button type="button" id="deleteButton" class="btn mt-2"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100px;"
                                        onclick="window.print();">Print</button>
                                </div>
                                <br>
                                <br>
                                <br>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                    $account_filter = $_POST['account_filter'];
                                    if (
                                        isset($_POST['daterange']) &&
                                        count(
                                            explode(' - ', $_POST['daterange'])
                                        ) > 1
                                    ) {
                                        $date_start_filter = explode(
                                            ' - ',
                                            $_POST['daterange']
                                        )[0];
                                        $date_end_filter = explode(
                                            ' - ',
                                            $_POST['daterange']
                                        )[1];
                                    }
                                    $sql =
                                        'SELECT * FROM accounts WHERE account_id = ' .
                                        $account_filter;
                                    $result = $conn->query($sql);
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<h4><b>' .
                                                $row['account_nm'] .
                                                '</b> - <b>' .
                                                $row['account_code'] .
                                                '</b></h4>'; ?>
                                    <table id="table_users" class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Test Type</th>
                                                <th scope="col">Fees</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql1 =
                                                'SELECT * FROM fees JOIN testtype ON testtype.type_id = fees.type_id WHERE account_id = ' .
                                                $row['account_id'];
                                            $result1 = mysqli_query(
                                                $conn,
                                                $sql1
                                            );
                                            while (
                                                $row1 = mysqli_fetch_assoc(
                                                    $result1
                                                )
                                            ) {
                                                echo '<tr>
                                                        <td scope="row1">' .
                                                    $row1['type_nm'] .
                                                    '</td>
                                                        <td>' .
                                                    $row1['amount'] .
                                                    '</td>
                                                    </tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <br>
                                    <?php
                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                        </form>
                        <?php } ?>

                        <br><br>
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
            <!-- Modal -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <form action="insert_users.php" method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">New User</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body" style="display: inline-block">
                                <div class="row">
                                    <input type="hidden" id="user_id" name="user_id">
                                    <div class="col-md-3" style="display: inline-block">User ID: </div>
                                    <div class="col-md-7" style="display: inline-block"><input class="form-control"
                                            id="userid" name="userid">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3" style="display: inline-block">First Name: </div>
                                    <div class="col-md-7" style="display: inline-block"><input class="form-control"
                                            id="fname" name="fname">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3" style="display: inline-block">Last Name: </div>
                                    <div class="col-md-7" style="display: inline-block"><input class="form-control"
                                            id="lname" name="lname">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3" style="display: inline-block">Password: </div>
                                    <div class="col-md-7" style="display: inline-block"><input type="password"
                                            class="form-control" id="password" name="password">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3" style="display: inline-block"></div>
                                    <div class="col-md-7" style="display: inline-block"><input class="" type="checkbox"
                                            value="T" id="admin" name="admin"><label>Admin</label></div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default">OK</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Help</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->

            <!-- Main Footer -->
            <footer class="main-footer no-print">
                <strong>Copyright &copy; 2020 <a href="https://matz.group/">MATZ Solutions Pvt Ltd</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b> 3.0.0-rc.1
                </div>
            </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="dist/js/adminlte.js"></script>
    <!-- OPTIONAL SCRIPTS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="dist/js/pages/dashboard3.js"></script>
    <script type="text/javascript" src="dist/js/moment.min.js"></script>
    <script type="text/javascript" src="dist/js/daterangepicker.min.js"></script>
    <script type="text/javascript">
        $(function() {

            var start = moment();
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $('#daterange').val(start.format('YYYY/MM/DD') + ' - ' + end.format('YYYY/MM/DD'))
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    // 'Please select Date Range': [],
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, cb);

            cb(start, end);

        });
    </script>

    <script>
        // $(function() {
        //     $('input[name="daterange"]').daterangepicker({
        //         opens: 'left'
        //     }, function(start, end, label) {
        //         console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        //     });
        // });
    </script>
</body>

</html>