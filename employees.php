<?php
include_once "conn.php";
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
    <link rel="stylesheet" href="dist/css/bootstrap.css">
    <link rel="stylesheet" href="dist/css/dataTables.bootstrap4.min.css">
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
    <script>
        counter = 1;
        var selected_employee = -1;

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
            $('.modal-title').html('Edit Employee');
            $.ajax({
                type: "GET",
                url: "getAllData.php?employee_id=" + selected_employee,
                success: function(resultData) {
                    var data = JSON.parse(resultData);
                    $('#specimen_id').val(data.specimen_id);
                    $('#emp_id').val(data.emp_id);
                    $('#first_nm').val(data.first_nm);
                    $('#last_nm').val(data.last_nm);
                    $('#division_id').val(data.division_id);
                    if (data.status == 'P') {
                        $('#status_pre_employment').prop('checked', true);
                        $('#status_active').prop('checked', false);
                        $('#status_terminated').prop('checked', false);
                    } else if (data.status == 'A') {
                        $('#status_pre_employment').prop('checked', false);
                        $('#status_active').prop('checked', true);
                        $('#status_terminated').prop('checked', false);
                    } else if (data.status == 'T') {
                        $('#status_pre_employment').prop('checked', false);
                        $('#status_active').prop('checked', false);
                        $('#status_terminated').prop('checked', true);
                    }
                }
            });
        }

        function deleteClicked() {
            $.ajax({
                type: "GET",
                url: "insert_laboratories.php?delete_laboratories_id=" + selected_employee,
                success: function(resultData) {
                    // console.log(resultData);
                    window.open("laboratories.php", "_self");

                }
            });
        }

        function addClicked() {
            $('.modal-title').html('New Employee');

            $('#specimen_id').val("");
            $('#emp_id').val("");
            $('#emp_id').prop("readonly", false);
            $('#first_nm').val("");
            $('#last_nm').val("");
            $('#division_id').val("");
            $('#status_pre_employment').prop('checked', true);
            $('#status_active').prop('checked', false);
            $('#status_terminated').prop('checked', false);

            selected_employee = -1;

            $('#table_laboratories > tbody  > tr').each(function(index, tr) {
                console.log(tr.style.background = 'rgba(0,0,0,.05)');
            });

            $('#deleteButton').prop('disabled', true);
            $('#propertiesButton').prop('disabled', true);
            $('#editEmployee').hide();
            $('#addEmployee').show();
        }

        function laboratoriesSelected(id) {
            $('#table_laboratories > tbody  > tr').each(function(index, tr) {
                console.log(tr.style.background = 'rgba(0,0,0,.05)');
            });
            selected_employee = id;
            $('#emp_id').prop("readonly", true);
            $('#deleteButton').prop('disabled', false);
            $('#propertiesButton').prop('disabled', false);
            $("#" + id).css('background', 'rgba(0,0,0,.35)');
            $('#editEmployee').show();
            $('#addEmployee').hide();

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
                                <h1 class="m-0 text-dark"><b><u>Employees Management</u></b></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="landingscreen.php">Home</a></li>

                                    <li class="breadcrumb-item active">Employees Management</li>
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
                                    <table id="table_laboratories" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Specimen ID</th>
                                                <th scope="col">Employee ID</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">First / Req No.</th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            $sql = 'SELECT * FROM employees JOIN divisions ON divisions.division_id = employees.division_id WHERE employees.account_id = ' . $_GET['account'];
                                            // echo $sql;
                                            $result = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $id = "'" . $row['emp_id'] . "'";
                                                echo '
                                                         <tr id="' . $row['emp_id'] . '" onclick = "laboratoriesSelected(' . $id . ');">
                                                            <th scope="row">' . $count++ . '</th>
                                                            <td>' . $row['specimen_id'] . '</td>
                                                            <td>' . $row['emp_id'] . '</td>
                                                            <td>' . $row['division_nm'] . '</td>
                                                            <td>' . $row['first_nm'] . '</td>
                                                            <td>' . $row['last_nm'] . '</td>
                                                            <td>';
                                                // echo $row['status'];
                                                if ($row['status'] == 'A')
                                                    echo 'Active';
                                                else if ($row['status'] == 'P')
                                                    echo 'Pre-Employment';
                                                else if ($row['status'] == 'T')
                                                    echo 'Terminated';
                                                echo '</td>
                                                        </tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" name="" class="btn mt-2" data-toggle="modal" data-target="#myModal_Employee" onclick="addClicked();" style="background-color:#E7D7B7; border-radius:5px; width: 100px;">Add</button>
                                    <button type="button" name="" class="btn mt-2" id="deleteButton" style="background-color:#E7D7B7; border-radius:5px; width: 100px;" onclick="deleteClicked();" disabled>Remove</button>
                                    <button type="button" name="" class="btn mt-2" style="background-color:#E7D7B7; border-radius:5px; width: 100px;" data-toggle="modal" id="propertiesButton" data-target="#myModal_Employee" onclick="propertiesClicked();" disabled>Properties</button>
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
            <!-- Modal -->
            <!--  -->
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
    <script src="dist/js/jquery-3.5.1.js"></script>
    <script src="dist/js/jquery.dataTables.min.js"></script>
    <script src="dist/js/dataTables.bootstrap4.min.js"></script>
    <!-- <script src="dist/js/adminlte.js"></script> -->

    <!-- OPTIONAL SCRIPTS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="dist/js/pages/dashboard3.js"></script>
    <script>
        $(document).ready(function() {
            $('#table_laboratories').DataTable();
        });
    </script>
    <script>
        // var account = new URL(location.href).searchParams.get("account");
        if (account == undefined || account == '')
            if (sessionStorage.getItem('account_selected') != undefined && sessionStorage.getItem('account_selected') != null &&
                sessionStorage.getItem('account_selected') != '') {
                account = sessionStorage.getItem('account_selected');
            }
        $.ajax({
            type: "GET",
            url: "get_location_testinfo.php",
            data: 'account_id_location=' + account,
            success: function(resultData) {
                $('#division_id').html(resultData);
            }
        });
    </script>
</body>

</html>