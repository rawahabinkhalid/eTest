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
        document.getElementsByClassName('modal-title')[0].innerHTML = 'Edit Invoice';
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
        document.getElementsByClassName('modal-title')[0].innerHTML = 'New Invoice';
        $.ajax({
            type: "GET",
            url: "get_location_testinfo.php",
            data: 'account_id_location=' + $('#accounts_select').val(),
            success: function(resultData) {
                $('#location').html(resultData);
                // window.open("accounts.php", "_self");
            }
        });
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

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark"><b><u>Invoices</u></b></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="landingscreen.php">Home</a></li>
                                    
                                    <li class="breadcrumb-item active">Invoices</li>
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
                                                <th scope="col">Invoice No.</th>
                                                <th scope="col">Invoice Date</th>
                                                <th scope="col">Sent</th>
                                                <th scope="col">Paid</th>
                                                <th scope="col">Pay Date</th>
                                                <th scope="col">Terms</th>
                                                <th scope="col">Due Date</th>
                                                <th scope="col">Overdue</th>
                                                <th scope="col">Check No.</th>
                                                <th scope="col">Check Date</th>
                                                <th scope="col">Amount Paid</th>
                                                <th scope="col">Entered By</th>
                                                <th scope="col">Entry Date</th>
                                                <th scope="col">Updated By</th>
                                                <th scope="col">Updated On</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                    $count = 1;
                                                    $sql = 'SELECT * FROM invoice WHERE account_id = ' . $_GET['account'];
                                                    $result = mysqli_query($conn, $sql);
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $id = "'" . $row['invoice_id'] . "'";
                                                        echo '<tr id=' . implode('_', explode(' ', $id)) . ' onclick = "userSelected(' . $id . ', ' . implode('_', explode(' ', $id)) . ')">
                                                        <th scope="row">' . $count++ . '</th>
                                                        <td>' . $row['invoice_id'] . '</td>
                                                        <td>' . $row['invoice_date'] . '</td>
                                                        <td>' . $row['sent'] . '</td>
                                                        <td>' . $row['paid'] . '</td>
                                                        <td>' . explode(' ', $row['pay_date'])[0] . '</td>
                                                        <td>' . $row['terms'] . '</td>
                                                        <td>' . explode(' ', $row['due_date'])[0] . '</td>';
                                                        $date = $row['due_date'];
                                                        $date = strtotime($date);
                                                        $date = strtotime("+".$row['terms']." day", $date);
                                                        echo '<td>' . date('Y-m-d', $date) . '</td>
                                                        <td>' . $row['check_no'] . '</td>
                                                        <td>' . explode(' ', $row['check_date'])[0] . '</td>
                                                        <td>' . $row['amount_paid'] . '</td>
                                                        <td>' . $row['insert_user_id'] . '</td>
                                                        <td>' . $row['insert_date'] . '</td>
                                                        <td>' . $row['update_user_id'] . '</td>
                                                        <td>' . $row['update_date'] . '</td>
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
                <div class="modal-dialog modal-lg" style="max-width:65%">

                    <!-- Modal content-->
                    <form action="insert_users.php" method="post">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">New Invoice</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body" style="display: inline-block">
                            <div class="row">
                                <div class="col-md-7">
                                    <fieldset style="border: 1px solid silver; padding-left: 15px; padding-right: 15px;">
                                    <legend>Details</legend>
                                    <div class="row">
                                            <input type="hidden" id="user_id" name="user_id">
                                            <div class="col-md-3" style="display: inline-block">Invoice No: </div>
                                            <div class="col-md-9" style="display: inline-block"><input readonly class="form-control"
                                                    id="invoice_no" name="invoice_no" value="New Invoice">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3" style="display: inline-block">Invoice Date: </div>
                                            <div class="col-md-9" style="display: inline-block"><input type="date" class="form-control"
                                                    id="invoice_date" name="invoice_date">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3" style="display: inline-block">Location: </div>
                                            <div class="col-md-9" style="display: inline-block"><select class="form-control"
                                                    id="location" name="location"></select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3" style="display: inline-block">Reference: </div>
                                            <div class="col-md-9" style="display: inline-block"><input
                                                    class="form-control" id="reference" name="reference">
                                            </div>
                                        </div>
                                        <br>
                                    </fieldset>
                                    <fieldset style="border: 1px solid silver; padding-left: 15px; padding-right: 15px;">
                                        <legend>Due</legend>
                                        <div class="row">
                                            <input type="hidden" id="user_id" name="user_id">
                                            <div class="col-md-3" style="display: inline-block">Terms: </div>
                                            <div class="col-md-9" style="display: inline-block">
                                                <select class="form-control">
                                                    <option selected disabled value="">Please select Terms</option>
                                                    <option value="30">30 Days</option>
                                                    <option value="60">60 Days</option>
                                                    <option value="90">90 Days</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3" style="display: inline-block">Due Date: </div>
                                            <div class="col-md-9" style="display: inline-block"><input type="date" class="form-control"
                                                    id="fname" name="fname">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3" style="display: inline-block"><input type="checkbox">&emsp;Sent: </div>
                                            <div class="col-md-9" style="display: inline-block"><input type="date" class="form-control"
                                                    id="lname" name="lname">
                                            </div>
                                        </div>
                                        <br>
                                    </fieldset>
                                </div>
                                <div class="col-md-5">
                                    <fieldset style="border: 1px solid silver; padding-left: 15px; padding-right: 15px;">
                                    <legend>Payment</legend>
                                    <div class="row">
                                            <input type="hidden" id="user_id" name="user_id">
                                            <div class="col-md-5" style="display: inline-block">Amount Due: </div>
                                            <div class="col-md-7" style="display: inline-block"><input readonly class="form-control"
                                                    id="amount_due" name="amount_due">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5" style="display: inline-block">Amount Paid: </div>
                                            <div class="col-md-7" style="display: inline-block"><input type="number" min="0" class="form-control"
                                                    id="amount_paid" name="amount_paid" step="0.05" value="0.00">
                                            </div>
                                        </div>
                                        
                                        <br>
                                        <br>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-5" style="display: inline-block">Check No: </div>
                                            <div class="col-md-7" style="display: inline-block"><input class="form-control"
                                                    id="check_no" name="check_no" type="text"  pattern="\d*"  maxlength="8">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5" style="display: inline-block">Check Date: </div>
                                            <div class="col-md-7" style="display: inline-block"><input type="date"
                                                    class="form-control" id="check_date" name="check_date">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5" style="display: inline-block">Pay Date: </div>
                                            <div class="col-md-7" style="display: inline-block"><input type="date"
                                                    class="form-control" id="pay_date" name="pay_date">
                                            </div>
                                        </div>

                                        <br>
                                        <br>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-3" style="display: inline-block"></div>
                                            <div class="col-md-9" style="display: inline-block"><input class="" type="checkbox"
                                                    value="T" id="admin" name="admin"><label>Paid in full</label></div>
                                        </div>
                                    </fieldset>
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
    <!-- <script src="dist/js/adminlte.js"></script> -->

    <!-- OPTIONAL SCRIPTS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="dist/js/pages/dashboard3.js"></script>
    <script>
    // $('#accounts_select').on('change', function() {
    //     $.ajax({
    //         type: "GET",
    //         url: "get_location_testinfo.php",
    //         data: 'account_id_location=' + $(this).val(),
    //         success: function(resultData) {
    //             $('#location').html(resultData);
    //             // window.open("accounts.php", "_self");
    //         }
    //     });
    // })

    
    </script>
</body>

</html>