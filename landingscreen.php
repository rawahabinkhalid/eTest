<?php
include_once 'conn.php';
// if ($_SESSION['usertype'] == 'guest') {
//     header('location: personal.php');
// }
?>
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
    <link href="plugins/select2/css/select2.min.css" rel="stylesheet">

    <style>
        label {
            /* Other styling... */
            text-align: right;
            clear: both;
            float: left;
            margin-right: 15px;
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
            </ul>
            <?php include 'header.php'; ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark"><b><u>eTest</u></b></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="landingscreen.php">Home</a></li>

                                    <li class="breadcrumb-item active">eTest</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-3">
                                <button type="button" name="" class="btn ml-1" style="background-color:#E7D7B7; border-radius:5px; width: 100%;" onclick="window.open('retrievetest.php?account=<?php echo isset($_GET['account'])
                                                                                                                                                                                                    ? $_GET['account']
                                                                                                                                                                                                    : ''; ?>', '_self');">Retrieve
                                    Tests</button>
                            </div>
                        </div>
                        <br>
                        <?php if ($_SESSION['userid'] === 'admin') { ?>
                            <div class="row">
                                <div class="col-md-3">
                                    <button type="button" name="" class="btn ml-1" style="background-color:#E7D7B7; border-radius:5px; width: 100%;" onclick="window.open('testinfo.php?account=<?php echo isset($_GET['account'])
                                                                                                                                                                                                    ? $_GET['account']
                                                                                                                                                                                                    : ''; ?>', '_self');">Enter a new
                                        test</button>
                                    <br><br>
                                </div>
                            </div>
                        <?php } ?>
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
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="dist/js/pages/dashboard3.js"></script>
    <script src="plugins/select2/js/select2.min.js"></script>
    <script>
        if (sessionStorage.getItem('account_selected') != undefined && sessionStorage.getItem('account_selected') != null && sessionStorage.getItem('account_selected') != 'null' &&
            sessionStorage.getItem('account_selected') != '')
            $('#accounts_select').val(sessionStorage.getItem('account_selected'));
        else {
            $('.btn').css('pointer-events', 'none');
            // $('.sidebar').css('pointer-events', 'none');
            // $('.nav-link').css('pointer-events', 'none');

        }
    </script>
    <script>
        $('#accounts_select').select2({
            width: '100%'
        }).on("change", function(e) {
            sessionStorage.setItem('account_selected', $(this).val());
            console.log($(this).val())
            console.log(location.pathname)
            window.open(location.pathname.split('/')[location.pathname.split('/').length - 1] + '?account=' +
                sessionStorage.getItem('account_selected'), '_self');
        });

        $('#practitioner_default').select2({
            width: '100%'
        });
        $('#lab_default').select2({
            width: '100%'
        });
        $('#sampleType_default').select2({
            width: '100%'
        });
        $('#testType_default').select2({
            width: '100%'
        });
        $('#testReason_default').select2({
            width: '100%'
        });
    </script>
</body>

</html>