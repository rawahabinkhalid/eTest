<?php
include_once "conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Random Employees Listing</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/bootstrap.css">
    <link rel="stylesheet" href="dist/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="dist/css/buttons.dataTables.min.css" />
    <!-- <script src="plugins/jquery/jquery.min.js"></script> -->

    <style>
        label {
            /* Other styling... */
            text-align: right;
            clear: both;
            float: left;
            margin-right: 15px;
        }
    </style>
    <script>
        var selected_employees = 0;
        var selected_test = 0;
        var selected_account_id = 0;

        function selectedEmployees(i, test_id, account_id) {
            $('#table_employees > tr').each(function(index, tr) {
                tr.style.background = 'rgba(0,0,0,.05)';
            });

            console.log(test_id);
            selected_employees = i;
            $("#employee_" + i).css('background', 'rgba(0,0,0,.35)');
            selected_test = test_id;
            selected_account_id = account_id;
            if (test_id == 0 || test_id == '')
                $('#goToTest').prop('disabled', true);
            else
                $('#goToTest').prop('disabled', false);
        }

        function goToTest_Func() {
            if (selected_test != 0 || selected_test == '')
                window.open('getTestInfo.php?account=' + selected_account_id + '&id=' + selected_test, '_self');
        }
    </script>
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

            <?php include "header.php"; ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark"><b><u>Random Employee Listing</u></b></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="landingscreen.php">Home</a></li>

                                    <li class="breadcrumb-item active">Users</li>
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
                            <div class="row">
                                <div class="col-md-8" style="overflow-y:scroll; overflow-x:scroll;">
                                    <table id="table_users" class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Random Emp Id</th>
                                                <th scope="col">Emp Id</th>
                                                <th scope="col">First / Req No</th>
                                                <th scope="col">Last</th>
                                                <th scope="col">Test No</th>
                                                <th scope="col">Group No</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_employees">
                                            <?php
                                            $count = 1;
                                            $i = 0;
                                            $sqlRandom = '';

                                            if(isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] != null) {
                                                $sqlRandom = ' AND randomitems.random_id = ' . $_GET['id'];
                                            }
                                            if (isset($_GET['account']) && $_GET['account'] != '' && $_GET['account'] != null) {
                                                $sql = 'SELECT * FROM randomitems JOIN employees ON randomitems.emp_id = employees.emp_id AND randomitems.account_id = employees.account_id WHERE randomitems.account_id = ' . $_GET['account'] . ' ' . $sqlRandom;
                                                $result = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $test_id = (is_null($row['test_id'])) ? 0 : $row['test_id'];
                                                    echo '<tr id="employee_' . $i . '" onclick="selectedEmployees(' . $i++ . ', ' . $test_id . ', ' . $_GET['account'] . ');">
                                                            <th scope="row">' . $count++ . '</th>
                                                            <td>' . $row['random_id'] . '</td>
                                                            <td>' . $row['emp_id'] . '</td>
                                                            <td>' . $row['first_nm'] . '</td>
                                                            <td>' . $row['last_nm'] . '</td>
                                                            <td>';
                                                    if ($row['test_id'] != '0')
                                                        echo $row['test_id'];
                                                    echo '</td>
                                                            <td>' . $row['batch_id'] . '</td>
                                                        </tr>';
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-2 mt-5">
                                    <button type="button" name="" id="goToTest" class="btn mt-2" style="background-color:#E7D7B7; border-radius:5px; width: 110px;" onclick="goToTest_Func();" disabled>Go to
                                        test</button><br>
                                    <button type="button" name="" id="goToGroup" class="btn mt-2" style="background-color:#E7D7B7; border-radius:5px; width: 110px;" onclick="window.open('landingscreen.php', '_self');">Go to
                                        group
                                    </button><br><br><br>
                                    <!-- <button type="button" name="" class="btn mt-2"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 110px;">Print
                                    </button> -->
                                </div>
                            </div>
                        </form>
                        <br><br>
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->

            <!-- Main Footer -->
            <footer class="main-footer">
                <strong>Copyright &copy; 2020-21 <a href="https://matz.group/">MATZ Solutions Pvt Ltd</a>.</strong>
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
    <!-- <script src="dist/js/adminlte.js"></script> -->

    <!-- OPTIONAL SCRIPTS -->
    <script src="plugins/select2/js/select2.min.js"></script>
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="dist/js/pages/dashboard3.js"></script>

    <script src="dist/js/jquery.dataTables.min.js"></script>
    <script src="dist/js/dataTables.bootstrap4.min.js"></script>
    <script src="dist/js/dataTables.buttons.min.js"></script>
    <script src="dist/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="dist/js/moment.min.js"></script>
    <script type="text/javascript" src="dist/js/daterangepicker.min.js"></script>
    <script>
        $(document).ready(function() {
            // $('#table_users').DataTable();
        });
    </script>
    <script>
        $('#table_users').DataTable().destroy();
        $('#table_users').DataTable({
            dom: 'Blfrtip',
            "deferRender": true,
            buttons: [
                'print'
            ]
        });
        $('.buttons-print').addClass('btn mt-2');
        $('.buttons-print').css('border-radius', '5px');
        $('.buttons-print').css('width', '100px');
        $('.buttons-print').css('background', 'none');
        $('.buttons-print').css('background-color', '#E7D7B7');
        $('.buttons-print').css('border', 'none');
        $('.dt-buttons').addClass('float-right');
        $('.dataTables_length').css('width', '50%')
        $('.dataTables_length').css('display', 'inline-block')
        $('#DataTables_Table_0_filter').css('width', '50%')
        $('#DataTables_Table_0_filter').css('display', 'inline-block')
        $('#DataTables_Table_0_filter').css('text-align', 'right')
        // $('#deleteButton').prop('disabled', false)
        $(document).ready(function() {
            $('#table_users').DataTable().destroy();
            $('#table_users').DataTable({
                dom: 'Blfrtip',
                buttons: [
                    'print'
                ]
            });
            // $('.buttons-print').css('display', 'none');
            $('.buttons-print').addClass('btn mt-2');
            $('.buttons-print').css('background', 'none');
            $('.buttons-print').css('background-color', '#E7D7B7');
            $('.buttons-print').css('border', 'none');
            $('.buttons-print').css('border-radius', '5px');
            $('.buttons-print').css('width', '100px');
            $('.dt-buttons').addClass('float-right');
            $('.dataTables_length').css('width', '50%')
            $('.dataTables_length').css('display', 'inline-block')
            $('#DataTables_Table_0_filter').css('width', '50%')
            $('#DataTables_Table_0_filter').css('display', 'inline-block')
            $('#DataTables_Table_0_filter').css('text-align', 'right')
            // $('#deleteButton').prop('disabled', false)
        });
    </script>
</body>

</html>