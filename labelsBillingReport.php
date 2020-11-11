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



    <style>
    label {
        /* Other styling... */
        text-align: right;
        clear: both;
        float: left;
        margin-right: 15px;
    }

    @media print {    
        .no-print, .no-print *
        {
            display: none !important;
        }

        body, html, #wrapper {
            height: 100%;
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
<!-- <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed"> -->
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
                                <h1 class="m-0 text-dark"><b><u>Labels For Billing Report</u></b></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="landingscreen.php">Home</a></li>
                                    
                                    <li class="breadcrumb-item active">Users</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                        <br>
                        <form action="" method="POST" class="">
                        <?php if (
                            isset($_GET['account'])
                        ) { ?>
                        <!-- <form action="" method="POST" class=""> -->
                            <div class="row">
                                <div class="col-md-12" style="text-align: right">
                                    <button type="submit"  name="filterData" class="btn mt-2"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100px;">Retrieve</button>
                                    <button type="button" id="deleteButton" class="btn mt-2"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100px;"
                                        onclick="window.print();" disabled>Print</button>
                                </div>
                                <br>
                                <br>
                                <br>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php $account_filter =
                                        $_GET['account']; ?>
                                </div>
                            </div>
                            <div class="row" id="DivIdToPrint">
                            <!-- <div class="col-md-4">Trillium Driver Solution Houston<br>Ellen Alvia<br>1717 Turning Basin Site 447<br>Houston &emsp;&emsp;&emsp;TX 77029</div>
                            <div class="col-md-4">Trillium Driver Solution Houston<br>Ellen Alvia<br>1717 Turning Basin Site 447<br>Houston &emsp;&emsp;&emsp;TX 77029</div>
                            <div class="col-md-4">Trillium Driver Solution Houston<br>Ellen Alvia<br>1717 Turning Basin Site 447<br>Houston &emsp;&emsp;&emsp;TX 77029</div> -->
                            <?php
                            $count = 0;
                            $sql =
                                'SELECT * FROM accounts JOIN divisions ON divisions.account_id = accounts.account_id WHERE accounts.account_id = ' .
                                $account_filter;
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<div class="col-md-4 mt-4">' .
                                        $row['account_nm'] .
                                        ' - ' .
                                        $row['division_nm'] .
                                        '<br>' .
                                        $row['contact'] .
                                        '<br>' .
                                        $row['address'] .
                                        '<br>' .
                                        $row['city'] .
                                        ' &emsp;&emsp;&emsp;' .
                                        $row['state'] .
                                        ' ' .
                                        $row['zip'] .
                                        '</div>';
                                    // if ($count % 3 == 0) {
                                    //     echo '<div class="row">';
                                    // }
                                    $count++;
                                }
                            }
                            } ?>
                            </div>

                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
                <!-- Main content -->
                
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

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
    <!-- <script src="dist/js/adminlte.js"></script> -->

    <!-- OPTIONAL SCRIPTS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="dist/js/pages/dashboard3.js"></script>

    <script>
        $('#accountSelect').on('change',function(){
            var accId = $(this).val();
            $.ajax({
                url: 'get_location_testinfo.php?account_id_location=' + accId,
                type: 'POST',

                success: function(data) {
                    // alert(data);
                    $('#locationSelect').html(data);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        })
    </script>
</body>

</html>