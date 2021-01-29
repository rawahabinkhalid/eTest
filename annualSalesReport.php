<?php
include_once "conn.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Annual Sales Report</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/bootstrap.css">
    <link rel="stylesheet" href="dist/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/buttons.dataTables.min.css" />
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
                            <h1 class="m-0 text-dark"><b><u>Annual Sales Report</u></b></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="landingscreen.php">Home</a></li>

                                    <li class="breadcrumb-item active">Annual Sales Report</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                        <form action="" method="POST" class="">
                            <div class="row no-print">
                                <div class="col-md-5">
                                    <!-- Date Range&emsp; -->
                                    <select class="form-control" name="daterange" style="width: calc(100% - 100px); display: inline-block;">
                                    <?php
                                    $starting_year  =2000;
                                    $sqlMinYear = 'SELECT MIN(test_date) FROM test';
                                    $resultMinYear = $conn->query($sqlMinYear);
                                    if($resultMinYear->num_rows > 0) {
                                        $starting_year = date('Y', strtotime($resultMinYear->fetch_assoc()['MIN(test_date)']));
                                    }
                                    $ending_year = date('Y');
                                    $current_year = date('Y');
                                    for($ending_year; $ending_year>=$starting_year; $ending_year--) {
                                        echo '<option value="'.$ending_year.'"';
                                        if(!isset($_POST['daterange'])) {
                                            if( $ending_year ==  $current_year ) {
                                                echo ' selected="selected"';
                                         }
                                        } else {
                                            if( $ending_year ==  $_POST['daterange'] ) {
                                                echo ' selected="selected"';
                                         }
                                        }
                                        echo ' >'.$ending_year.'</option>';
                                    }         
                                    ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-3" style="text-align: right">
                                    <button type="submit" name="filterData" class="btn mt-2"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100px;">Filter</button>
                                    <button type="button" class="btn mt-2"
                                        onclick="window.open('annualSalesReport.php', '_self');"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100px;">Reset</button>
                                </div>
                            </div>

                            <!-- <br><br> -->
                            <?php if (isset($_GET['account'])) {} ?>
                            <!-- <form action="" method="POST" class=""> -->
                            <div class="row no-print">
                                <div class="col-md-12" style="text-align: right">
                                    <button type="submit" name="filterData" class="btn mt-2"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100px;">Retrieve</button>
                                    <!-- <button type="button" id="deleteButton" class="btn mt-2"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100px;"
                                        onclick="$('.buttons-print').click();" disabled>Print</button> -->
                                </div>
                                <br>
                                <br>
                                <br>
                            </div>
                        </form>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        <form action="" method="POST" class="">
                            <div class="row">
                                <div class="col-md-12">
                                <?php
                                    $account_filter = $_GET['account'];
                                    $sqlDate = '';
                                    if (
                                        isset($_POST['daterange']) &&
                                            $_POST['daterange'] != ''
                                    ) {
                                        $sqlDate =
                                            ' AND (collection_date LIKE "%' .
                                            $_POST['daterange'] .
                                            '%" OR test_date LIKE "%' .
                                            $_POST['daterange'] .
                                            '%")';
                                    } else {
                                        $sqlDate =
                                        ' AND (collection_date LIKE "%' .
                                            date('Y') .
                                            '%" OR test_date LIKE "%' .
                                            date('Y') .
                                            '%")';
                                    }
                                    ?>
                                    <table id="table_users" class="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Account Name</th>
                                                <th scope="col">Total Sales</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $totalAmount = 0;
                                            $sql1 =
                                                'SELECT account_nm, SUM(test.amount) FROM test JOIN accounts ON accounts.account_id = test.account_id WHERE accounts.account_id IS NOT NULL ' .
                                                $sqlDate .
                                                ' GROUP BY accounts.account_id ORDER BY account_nm';
                                            // echo $sql1;
                                            $result1 = $conn->query($sql1);
                                            $result2 = $conn->query($sql1);
                                            while (
                                                $row1 = $result1->fetch_assoc()
                                            ) {
                                                $name = $row1['account_nm'];
                                            echo '<tr>';
                                                echo '
                                          <td>' .
                                          $row1['account_nm'] .
                                                    '</td>
                                          <td>$ ' .
                                          number_format(floatval($row1['SUM(test.amount)']), 2) .
                                                    '</td>
                                            </tr>';
                                                $i++;
                                                $totalAmount = floatval($totalAmount) + floatval($row1['SUM(test.amount)']);
                                            }
                                             ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th style="text-align:right">Total:</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
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
            <!-- <footer class="main-footer">
                <strong>Copyright &copy; 2020-21 <a href="https://matz.group/">MATZ Solutions Pvt Ltd</a>.</strong>
                All rights reserved.
                <div class="float-right d-none d-sm-inline-block">
                    <b>Version</b> 3.0.0-rc.1
                </div>
            </footer> -->
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="dist/js/jquery-3.5.1.js"></script>
    <script src="dist/js/jquery.dataTables.min.js"></script>
    <script src="dist/js/dataTables.bootstrap4.min.js"></script>
    <script src="dist/js/dataTables.buttons.min.js"></script>
    <script src="dist/js/buttons.print.min.js"></script>
    <script src="dist/js/jszip.min.js"></script>
    <script src="dist/js/pdfmake.min.js"></script>
    <script src="dist/js/vfs_fonts.js"></script>
    <script src="dist/js/buttons.html5.min.js"></script>
    <!-- <script src="dist/js/adminlte.js"></script> -->

    <!-- OPTIONAL SCRIPTS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="dist/js/pages/dashboard3.js"></script>

    <script>
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    $(document).ready(function() {
        $('#table_users').DataTable({
            dom: 'Blfrtip',
            "deferRender": true,
            buttons: [
                {   extend: 'print', footer: true   },
                { extend: 'excelHtml5', footer: true },
                { extend: 'csvHtml5', footer: true },
                { extend: 'pdfHtml5', footer: true }
            ],
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
    
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
    
                // Total over all pages
                total = api
                    .column( 1 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                // Total over this page
                pageTotal = api
                    .column( 1, { page: 'all', filter:'applied'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                // Update footer
                $( api.column( 1 ).footer() ).html(
                    '$ '+numberWithCommas(pageTotal)
                );
            }
        });
        $('.dataTables_length').css('display', 'inline-block')
        $('.dataTables_filter').css('display', 'inline-block')
        $('.dataTables_filter').css('text-align', 'right')
        $('.dt-buttons').addClass('float-right');
        $('.buttons-print').css('border-radius', '5px');

        formatDataTableButtons('.buttons-print')
        formatDataTableButtons('.buttons-excel')
        formatDataTableButtons('.buttons-csv')
        formatDataTableButtons('.buttons-pdf')

        // $('.dataTables_length').css('width', '50%')
        // $('#DataTables_Table_0_filter').css('width', '50%')
    });

    function formatDataTableButtons(className) {
        $(className).addClass('btn mt-2');
        $(className).css('border-radius', '5px');
        $(className).css('width', '100px');
        $(className).css('background', 'none');
        $(className).css('background-color', '#E7D7B7');
        $(className).css('border', 'none');
    }
    </script>

</body>

</html>