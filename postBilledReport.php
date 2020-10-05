<?php
include_once 'conn.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Post Billed Report</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link rel="stylesheet" href="dist/css/bootstrap.css">
    <link rel="stylesheet" href="dist/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/buttons.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="dist/css/datepicker.css" />

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
    counter = 1;
    var selected_user = -1;

    function addRow() {
        var content =
            '<tr><td><input type="text" class="form-control" id="clientId_' + counter +
            '" name="client[]"></td><td><input type="text" class="form-control" id="itemid_' +
            counter +
            '" name="item[]" onchange="getRate(this);"></td><td><input type="text" class="form-control" id="description_' +
            counter + '" name="description[]"></td><td><input type="text" class="form-control" id="kg_' + counter +
            '" name="kg[]" onchange="calcTotal(this);"></td><td><input type="text" class="form-control" id="rate_' +
            counter +
            '" name="rate[]" onchange="calcTotal(this);"></td><td><input type="text" class="form-control" id="total_' +
            counter + '" name="total[]" readonly></td></tr>';
        $('#tbody').append(content);

        counter++;
    }

    function deleteRow() {
        var tableName = "item";
        var tbl = document.getElementById(tableName);
        var lastRow = tbl.rows.length;
        lastRow--;
        // alert(lastRow);
        if (lastRow > 1) {
            tbl.deleteRow(lastRow);
            // tbl.deleteRow(lastRow - 2);
        }

    }


    function calcTotal(reference) {
        index = reference.id.split('_')[1];
        rate = document.getElementById('rate_' + index).value;
        kg = document.getElementById('kg_' + index).value;
        if (rate != '' && kg != '') {
            document.getElementById('total_' + index).value = parseFloat(parseFloat(rate) * parseFloat(kg)).toFixed(2);
        }
    }

    function propertiesClicked() {
        document.getElementsByClassName('modal-title')[0].innerHTML = 'Edit User';
        $.ajax({
            type: "GET",
            url: "getAllData.php?user_id='" + selected_user + "'",
            success: function(resultData) {
                console.log(resultData);
                var data = JSON.parse(resultData);
                $('#user_id').val(selected_user);
                $('#userid').val(data.user_id);
                $('#fname').val(data.first_nm);
                $('#lname').val(data.last_nm);
                $('#password').val(data.password);
                if (data.admin == 'T')
                    $('#admin').prop("checked", true);
                else
                    $('#admin').prop("checked", false);
            }
        });
    }

    function deleteClicked() {
        console.log("insert_users.php?delete_user_id='" + selected_user + "'");
        $.ajax({
            type: "GET",
            url: "insert_users.php?delete_user_id='" + selected_user + "'",
            success: function(resultData) {
                // console.log(resultData);
                window.open("users.php", "_self");

            }
        });
    }

    function addClicked() {
        document.getElementsByClassName('modal-title')[0].innerHTML = 'New User';
    }

    function userSelected(user, id) {
        $('#table_users > tbody  > tr').each(function(index, tr) {
            tr.style.background = 'rgba(0,0,0,.05)';
        });

        selected_user = user;
        // alert("#" + id);
        $('#deleteButton').prop('disabled', false);
        $('#propertiesButton').prop('disabled', false);
        $("#" + id).css('background', 'rgba(0,0,0,.35)');
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

            <?php include 'header.php'; ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark"><b><u>Post Billed Report</u></b></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Users</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
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
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                            <input type="checkbox" style="height: calc(1.25rem); width: calc(1.25rem);" <?php echo isset(
                                                $_POST['daterangeCheck']
                                            )
                                                ? 'checked'
                                                : ''; ?> name="daterangeCheck" id="daterangeCheck" aria-label="Checkbox for following text input">
                                            </div>
                                        </div>
                                        <div id="reportrange" style="width: calc(100% - 100px) !important; display: inline-block; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%; <?php echo isset(
                                            $_POST['daterangeCheck']
                                        )
                                            ? ''
                                            : 'pointer-events: none; background-color: #e9ecef;'; ?>">
                                        <i class="fa fa-calendar"></i>&nbsp;
                                        <span></span> <i class="fa fa-caret-down"></i>
                                    </div>                                    </div>
                                    <input type="hidden" class="form-control" value="<?php echo isset(
                                        $_POST['daterange']
                                    )
                                        ? $_POST['daterange']
                                        : ''; ?>" name="daterange" id="daterange" style="width: calc(100% - 100px); display: inline-block;" />
                                    
                                </div>
                                <div class="col-md-3" style="text-align: right">
                                    <button type="submit" name="filterData" class="btn mt-2"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100px;">Filter</button>
                                    <button type="button" class="btn mt-2"
                                    onclick="window.open('postBilledReport.php', '_self');" style="background-color:#E7D7B7; border-radius:5px; width: 100px;">Reset</button>
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
                                        onclick="$('.buttons-print').click();" disabled>Print</button>
                                </div>
                                <br>
                                <br>
                                <br>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php
                                    $account_filter = $_POST['account_filter'];
                                    $sqlDate = '';
                                    if (
                                        isset($_POST['daterangeCheck']) &&
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
                                        $sqlDate =
                                            ' AND ((invoice_date BETWEEN "' .
                                            $date_start_filter .
                                            '" AND "' .
                                            $date_end_filter .
                                            '"))';
                                    }
                                    ?>
                                    </div></div>
                        <table class="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">arfunding_code</th>
                                    <th scope="col">account_nm</th>
                                    <th scope="col">invoice_id</th>
                                    <th scope="col">invoice_date</th>
                                    <th scope="col">Sum of Amount</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                $i = 1;
                                $sql =
                                    'SELECT SUM(amount_paid) as total,accounts.account_id,invoice.account_id,account_nm,invoice_date,invoice_id, ar_funding_code FROM accounts JOIN invoice ON accounts.account_id = invoice.account_id WHERE accounts.account_id = ' .
                                    $account_filter .
                                    $sqlDate .
                                    ' GROUP BY accounts.account_id, invoice_id ORDER BY invoice_date, account_nm, invoice_id';
                                // echo $sql;
                                $result = $conn->query($sql);
                                while ($row = $result->fetch_assoc()) {
                                    echo '
                                    <tr>
                                      <td>' .
                                        $row['ar_funding_code'] .
                                        '</td>
                                      <td>' .
                                        $row['account_nm'] .
                                        '</td>
                                      <td>' .
                                        $row['invoice_id'] .
                                        '</td>
                                      <td>' .
                                        $row['invoice_date'] .
                                        '</td>
                                      <td>' .
                                        $row['total'] .
                                        '</td>';
                                    echo '</tr>';
                                    $i++;
                                }
                                } ?>
                            </tbody>
                        </table>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">

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
    <script src="dist/js/jquery-3.5.1.js"></script>
    <script src="dist/js/jquery.dataTables.min.js"></script>
    <script src="dist/js/dataTables.bootstrap4.min.js"></script>
    <script src="dist/js/dataTables.buttons.min.js"></script>
    <script src="dist/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="dist/js/moment.min.js"></script>
    <script type="text/javascript" src="dist/js/daterangepicker.min.js"></script>
    <script type="text/javascript">
        $(function() {
            var temp_range = {
                            // 'Please select Date Range': [],
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                        };
            var start = ($('#daterange').val() != '') ? moment($('#daterange').val().split(" - ")[0]) : moment();
            var end = ($('#daterange').val() != '') ? moment($('#daterange').val().split(" - ")[1]) : moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                $('#daterange').val(start.format('YYYY/MM/DD') + ' - ' + end.format('YYYY/MM/DD'))
            }


            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: temp_range
            }, cb);

            cb(start, end);

        });

        $('.ranges ul li').on('click', function() {
            console.log($(this).attr('data-range-key'));
        })
    </script>
    <script>
    $('#daterangeCheck').on('click', function() {
        if($(this).is(':checked')) {
            $('#reportrange').css('pointer-events', '');
            $('#reportrange').css('background-color', '#fff');
        } else {
            $('#reportrange').css('pointer-events', 'none');
            $('#reportrange').css('background-color', '#e9ecef');
        }
    })
    </script>
    <script>
    $(document).ready(function() {
        $('.table').DataTable({
            dom: 'Blfrtip',
            buttons: [
                'print'
            ]
        });
        $('.buttons-print').css('display', 'none');
        $('.dataTables_length').css('width', '50%')
        $('.dataTables_length').css('display', 'inline-block')
        $('#DataTables_Table_0_filter').css('width', '50%')
        $('#DataTables_Table_0_filter').css('display', 'inline-block')
        $('#DataTables_Table_0_filter').css('text-align', 'right')
        $('#deleteButton').prop('disabled', false)
    });
    </script>
    <script>
    $('#accountSelect').on('change', function() {
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