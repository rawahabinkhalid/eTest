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
    <script src="plugins/jquery/jquery.min.js"></script>

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
            url: "getAllData.php?random_id='" + selected_user + "'",
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
        $.ajax({
            type: "GET",
            url: "insert_random_employee.php?delete_user_id='" + selected_user + "'",
            success: function(resultData) {
                // console.log(resultData);
                window.open("randomemployees.php", "_self");

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
        // $('#propertiesButton').prop('disabled', false);
        $("#" + id).css('background', 'rgba(0,0,0,.35)');
    }

    $('#accounts_select').on('change', function() {
        $('#account_id').val($('#accounts_select').val());
    })

    $(document).ready(function() {
        $('#account_id').val($('#accounts_select').val());
    })
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
            <!-- <div class="col-md-12 col-sm-12">
                <div class="row"> -->
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
            <!-- <form class="form-inline col-md-3 col-sm-1">
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
            <!-- <div class="col-md-1 col-sm-1">
                </div> -->
            <div class="col-md-6 col-sm-6">
                <div class="input-group input-group-sm">
                    <select class="form-control" id="accounts_select">
                        <?php
$sql = 'SELECT * FROM accounts';
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['account_id'] . '">' . $row['account_nm'] . '</option>';
    }
}
?>
                    </select>
                </div>
            </div>
            <?php include "header.php";?>
            <!-- </div>
            </div> -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark"><b><u>Random Employee List History</u></b></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Random Employee List History</li>
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
                                                <th scope="col">List No</th>
                                                <th scope="col">Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
$count = 1;
$sql = 'SELECT * FROM random';
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $id = "'" . $row['random_id'] . "'";
    echo '<tr id=' . implode('_', explode(' ', $id)) . ' onclick = "userSelected(' . $id . ', ' . implode('_', explode(' ', $id)) . ')">
                                                        <th scope="row">' . $count++ . '</th>
                                                        <td>' . $row['random_id'] . '</td>
                                                        <td>' . $row['comments'] . '</td>
                                                    </tr>';
}
?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" name="" class="btn mt-2" data-toggle="modal"
                                        data-target="#myModal" onclick="addClicked();"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100px;">Add</button>
                                    <button type="button" id="deleteButton" class="btn mt-2"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100px;"
                                        onclick="deleteClicked();" disabled>Remove</button>
                                    <button type="button" name="" class="btn mt-2"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100px;"
                                        data-toggle="modal" id="propertiesButton" data-target="#myModal"
                                        onclick="propertiesClicked();" disabled>Properties</button>
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
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <form action="insert_random_employee.php" method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">New Random Employee List</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body" style="display: inline-block">
                                <div class="row">
                                    <input type="hidden" id="random_id" name="random_id">
                                    <input type="hidden" id="account_id" name="account_id">
                                    <div class="col-md-4" style="display: inline-block">Test Form to Use: </div>
                                    <div class="col-md-7" style="display: inline-block">
                                        <select class="form-control" id="testfromuse" name="testfromuse" required>
                                            <option selected disabled value="">Select Test Form to Use</option>
                                            <?php
												$sql = "SELECT * FROM drugform";
												$result = mysqli_query($conn, $sql);
												while ($row = mysqli_fetch_assoc($result)) {
												    echo '
												    	<option value="' . $row['form_id'] . '">' . $row['form_nm'] . '</option>';
												}
											?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-md-4" style="display: inline-block">Location: </div>
                                    <div class="col-md-7" style="display: inline-block">
                                        <select class="form-control" id="location" name="location" required>
                                            <option selected disabled value="">Select Location</option>
                                            <?php
												$sql = "SELECT DISTINCT(division_nm), divisions.division_id, division_nm FROM divisions INNER JOIN employees ON employees.division_id = divisions.division_id";
												$result = mysqli_query($conn, $sql);
												while ($row = mysqli_fetch_assoc($result)) {
												    echo '<option value="' . $row['division_id'] . '">' . $row['division_nm'] . '</option>';
												}
											?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-md-4" style="display: inline-block">Test Reason: </div>
                                    <div class="col-md-7" style="display: inline-block">
                                        <select class="form-control" id="testreason" name="testreason" required>
                                            <option selected disabled value="">Select Test Reason</option>
                                            <?php
                                                $sql = "SELECT * FROM reasons";
                                                $result = mysqli_query($conn, $sql);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '
                                                                                                <option value="' . $row['reason_code'] . '">' . $row['reason_nm'] . '</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-12" style="display: inline-block"><input class="" type="checkbox"
                                            value="T" id="admin" name="admin">&nbsp;&nbsp;Automatically generate a new
                                        test for each random employee
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-12" style="display: inline-block">
                                        <fieldset style="border: 1px solid lightgray; padding: 10px">
                                            <legend>Total Employee</legend>
                                            <div class="col-md-5" style="display: inline-block">Total Employee Location:
                                            </div>
                                            <div class="col-md-6" style="display: inline-block">
                                                <input class="form-control" id="totalemployee" name="totalemployee"
                                                    value="" disabled>
                                            </div>
                                            <div class="col-md-5" style="display: inline-block">Number To Randomize:
                                            </div>
                                            <div class="col-md-6" style="display: inline-block">
                                                <input class="form-control" id="numberToRandomize"
                                                    name="numberToRandomize" type="number" min="0" max="100" required>
                                            </div>
                                            <div class="col-md-5 mt-2" style="display: inline-block"><input class=""
                                                    type="checkbox" value="T" id="percentagetick"
                                                    name="percentagetick">&nbsp;&nbsp;By Percentage:
                                            </div>
                                            <div class="col-md-4 mt-2" style="display: inline-block">
                                                <input class="form-control" id="pervalue" name="" type="number" min="0"
                                                    max="100" disabled>
                                            </div>
                                            <div class="col-md-2 mt-2" style="display: inline-block">
                                                <p>%</p>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <!-- <div class="col-md-2" style="display: inline-block">Location: </div><div class="col-md-7" style="display: inline-block"><select class="form-control"><option value="">Select Location</option></select></div> -->
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
    <script src="dist/js/jquery-3.5.1.js"></script>
    <script src="dist/js/jquery.dataTables.min.js"></script>
    <script src="dist/js/dataTables.bootstrap4.min.js"></script>
    <script src="dist/js/adminlte.js"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="dist/js/pages/dashboard3.js"></script>
</body>
<script>
$(document).ready(function() {
    $('#table_users').DataTable();
});
</script>
<script>
$('#percentagetick').on('click', function() {
    if ($('#percentagetick').is(':checked')) {
        $('#pervalue').prop('disabled', false);
    } else {
        $('#pervalue').prop('disabled', true);
    }
});
</script>

<script>
$('#location').on('change', function() {
    var loc_id = $('#location').val();
    $.ajax({
        url: 'rendomemplocation.php?val=' + loc_id,
        type: 'POST',

        success: function(data) {
            // alert(data);
            $('#totalemployee').val(data);
            $('#numberToRandomize').prop('max', data);
        },
        cache: false,
        contentType: false,
        processData: false
    });
});
</script>

</html>