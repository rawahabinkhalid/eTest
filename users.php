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
        // alert(selected_user);
        document.getElementsByClassName('modal-title')[0].innerHTML = 'Edit User';
        $.ajax({
            type: "GET",
            url: "getAllData.php?user_id=" + encodeURIComponent(selected_user),
            success: function(resultData) {
                console.log(resultData);
                var data = JSON.parse(resultData);
                $('#user_id').val(selected_user);
                $('#userid').val(data.user_id);
                $('#fname').val(data.first_nm);
                $('#lname').val(data.last_nm);
                $('#password').val(data.password);
                $('#accountSelect').val(data.account_id);

                var accId = $('#accountSelect').val();
                $.ajax({
                    url: 'get_location_testinfo.php?account_id_location=' + accId,
                    type: 'POST',

                    success: function(data) {
                        // alert(data);
                        $('#locationSelect').html(data);
                        $('#locationSelect').val(data.location)
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

                // $('#locationSelect').val(data.location);
                if (data.admin === 'T') {
                    $('.checkbox').prop('checked', true)
                } else {
                    $('.checkbox').prop('checked', false)
                }
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

            <?php include "header.php";?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark"><b><u>Users</u></b></h1>
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
                                                <th scope="col">User ID</th>
                                                <th scope="col">First Name</th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Admin</th>
                                                <th scope="col">Account</th>
                                                <th scope="col">Locations</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            $sql = 'SELECT users.*, account_nm FROM users LEFT JOIN accounts ON users.account_id = accounts.account_id';
                                            $result = mysqli_query($conn, $sql);
                                            if(mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {

                                                    $sqlLocations = 'SELECT * FROM userlocation JOIN divisions ON userlocation.location = divisions.division_id WHERE userlocation.user_id = "'.$row['user_id'].'"';
                                                    // echo $sqlLocations;
                                                    $resultLocation = $conn->query($sqlLocations);
                                                    $arr_locations = array();
                                                    if (mysqli_num_rows($resultLocation)>0) {
                                                        while ($rowLocation = $resultLocation->fetch_assoc()) {
                                                            array_push($arr_locations,$rowLocation['division_nm']);
                                                        }
                                                    }

                                                    

                                                    $id = "'" . $row['user_id'] . "'";
                                                    echo '
                                                    <tr id=' . implode('_', explode(' ', $id)) . ' onclick = "userSelected(' . $id . ', ' . implode('_', explode(' ', $id)) . ')">
                                                        <th scope="row">' . $count++ . '</th>
                                                        <td>' . $row['user_id'] . '</td>
                                                        <td>' . $row['first_nm'] . '</td>
                                                        <td>' . $row['last_nm'] . '</td>
                                                        <td>' . $row['admin'] . '</td>
                                                        <td>' . $row['account_nm'] . '</td>';
                                                        echo '<td>';
                                                            foreach($arr_locations as $locations) {
                                                                echo $locations, '<br>';
                                                            }
                                                        echo '</td>';
                                                    echo '</tr>';
                                                }
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
                                    <div class="col-md-7" style="display: inline-block">
                                        <input type="password" class="form-control" id="password" name="password"
                                            onchange="test_str()">
                                        <!-- <input type="text" id="t2" readonly/>  -->
                                        <span id="t2"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3" style="display: inline-block"></div>
                                    <div class="col-md-7" style="display: inline-block"><input class="checkbox"
                                            type="checkbox" value="T" id="admin" name="admin"><label>Admin</label></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">Account:</div>
                                    <div class="col-md-7">
                                        <select class="form-control" id="accountSelect" name="accountSelect">
                                            <option disabled selected>Select Account</option>
                                            <?php
                                            $sql = 'SELECT * FROM accounts';
                                            $result = $conn->query($sql);
                                            while ($row = $result ->fetch_assoc()) {
                                                echo '<option value='.$row['account_id'].'>'.$row['account_nm'].'</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">Location:</div>
                                    <div class="col-md-7">
                                        <select class="form-control" id="locationSelect" name="locationSelect[]"
                                            multiple>
                                        </select>


                                    </div>
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
            <!-- <footer class="main-footer">
                <strong>Copyright &copy; 2020 <a href="https://matz.group/">MATZ Solutions Pvt Ltd</a>.</strong>
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
    <!-- <script src="dist/js/adminlte.js"></script> -->

    <!-- OPTIONAL SCRIPTS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="dist/js/pages/dashboard3.js"></script>

    <script>
    $(document).ready(function() {
        $('#accountSelect').val($('#accounts_select').val());
        var accId = $('#accounts_select').val();
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
        $('#table_users').DataTable();
    });
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

    <script>
    function test_str() {
        var res;
        var str =
            document.getElementById("password").value;
        if (str.match(/[a-z]/g) && str.match(
                /[A-Z]/g) && str.match(
                /[0-9]/g) && str.match(
                /[^a-zA-Z\d]/g) && str.length >= 8) {
            res = "Password is strong";
            document.getElementById("t2").innerHTML = res;
            document.getElementById("t2").style.color = "#08c922";
        }

        // document.getElementById("t2").innerHTML = res; 
        // document.getElementById("t2").style.color = "#08c922";
        else {
            res = "Password should contain atleast 1 special characters, 1 uppercase letter, 1 number.";
            document.getElementById("t2").innerHTML = res;
            document.getElementById("t2").style.color = "#f50008";
        }


    }
    </script>
</body>

</html>