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
    </style>
    <script>
    counter = 1;

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

            <?php include 'header.php'; ?>
            <div class="content-wrapper" id="select_account_div">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark"><b><u>Please select Account first...</u></b></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="landingscreen.php">Home</a></li>

                                    <li class="breadcrumb-item active">Test No</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
            </div>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" id="main_div_main" style="display: none">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark"><b><u>Test No</u></b></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="landingscreen.php">Home</a></li>

                                    <li class="breadcrumb-item active">Test No</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
                <!-- Main content -->

                <?php
                $sqlPreferences = 'SELECT * FROM `preferences`';
                $resultPreferences = $conn->query($sqlPreferences);
                $fees = 0;
                if($resultPreferences->num_rows > 0) {
                    $rowPreferences = $resultPreferences->fetch_assoc();
                    // print_r($rowPreferences);
                    $sqlFees = 'SELECT * FROM `fees` WHERE account_id = ' . $_GET['account'] . ' AND type_id = ' . $rowPreferences['type_id'];
                    // echo $sqlFees;
                    $resultFees = $conn->query($sqlFees);
                    if($resultFees->num_rows > 0) {
                        $rowFees = $resultFees->fetch_assoc();
                        // print_r($rowPreferences);
                        $fees = $rowFees['amount'];
                    }
                }
                ?>
                <div class="content">
                    <div class="container-fluid">
                        <!-- <form action="" method="POST" class=""> -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Test No:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" value="New Test" disabled
                                        style="width: 240px; height: 31px; text-align:center">
                                </div>
                                <div class="form-group">
                                    <label>Requisition No:</label>
                                    <input type="number" placeholder="" id="requisitionNo" name="requisitionNo"
                                        style="width: 240px; height: 31px; text-align:center">
                                </div>
                                <div class="form-group">
                                    <label>Emp ID:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select style="width: 240px; height: 31px;" id="employee_select">
                                        <option selected disabled value="">Please select Location first....</option>
                                    </select>
                                    <a href="" class="nav-link" data-toggle="modal" data-target="#myModal_Employee"
                                        id="btn_add_employees" style="width: 0px; display: inline; padding: 0px;">
                                        &emsp;&emsp;<i class="fas fa-plus"></i>
                                    </a>

                                </div>
                                <div class="form-group">
                                    <label>Test Reason:</label>
                                    &nbsp;&nbsp;&nbsp;
                                    &nbsp;
                                    <select style="width: 240px; height: 31px;" id="testreason">
                                        <option selected disabled value="">Please select Test Reason</option>
                                        <?php
                                            $sql = 'SELECT * FROM reasons';
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while (
                                                    $row = $result->fetch_assoc()
                                                ) {
                                                    echo '<option value="' .
                                                        $row['reason_id'] .
                                                        '"';
                                                    if(isset($rowPreferences['reason_id']))
                                                        if($row['reason_id'] == $rowPreferences['reason_id'])
                                                            echo 'selected';
                                                    
                                                    echo '>' .
                                                        $row['reason_code'] .
                                                        ' - ' .
                                                        $row['reason_nm'] .
                                                        '</option>';
                                                }
                                            }
                                            ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Date Reported:</label>
                                    <input type="date" value="<?php echo date(
                                            'Y-m-d'
                                        ); ?>" max="<?php echo date(
                                            'Y-m-d'
                                        ); ?>" name="date_reported" id="date_reported" placeholder=""
                                        style="width: 240px; height: 31px; text-align:center">
                                </div>
                                <div class="form-group">
                                    <label>Sample Type:</label>
                                    &nbsp;&nbsp;&nbsp;
                                    <select style="width: 240px; height: 31px;" id="sampletype">
                                        <option selected disabled value="">Please select Sample Type</option>
                                        <?php
                                            $sql = 'SELECT * FROM sampletype';
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while (
                                                    $row = $result->fetch_assoc()
                                                ) {
                                                    echo '<option value="' .
                                                        $row['sample_id'] .
                                                        '"';
                                                    if(isset($rowPreferences['sample_id']))
                                                        if($row['sample_id'] == $rowPreferences['sample_id'])
                                                            echo 'selected';
                                                    
                                                    echo '>' .
                                                        $row['sample_nm'] .
                                                        '</option>';
                                                }
                                            }
                                            ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Test Type:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select style="width: 240px; height: 31px;" id="testtype">
                                        <option selected disabled value="">Please select Test Type</option>
                                        <?php
                                            $sql = 'SELECT * FROM testtype';
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while (
                                                    $row = $result->fetch_assoc()
                                                ) {
                                                    echo '<option value="' .
                                                        $row['type_id'] .
                                                        '"';
                                                    if(isset($rowPreferences['type_id']))
                                                        if($row['type_id'] == $rowPreferences['type_id'])
                                                            echo 'selected';
                                                    
                                                    echo '>' .
                                                        $row['type_nm'] .
                                                        '</option>';
                                                }
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="record_complete">
                                        <input type="checkbox" id="record_complete" name="" value="">
                                        &emsp;&emsp;This record is complete
                                    </label>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label>Invoice No:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" disabled style="width: 240px; height: 31px; text-align:center">
                                </div>
                                <div class="form-group">
                                    <label>Group No:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input disabled style="width: 240px; height: 31px;" type="text"
                                        style="text-align:center">
                                </div>
                                <div class="form-group">
                                    <label>Location:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select style="width: 240px; height: 31px;" id="location_select">


                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Collection Date:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="date" placeholder="" value="<?php echo date(
                                            'Y-m-d'
                                        ); ?>" style="width: 240px; height: 31px;
                                            text-align:center" id="collectiondate">
                                </div>
                                <div class="form-group">
                                    <label>Date MRO Copy Recvd:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="date" value="<?php echo date(
                                            'Y-m-d'
                                        ); ?>" max="<?php echo date(
                                            'Y-m-d'
                                        ); ?>" name="date_mro_recvd" id="date_mro_recvd" placeholder=""
                                        style="width: 240px; height: 31px; text-align:center">
                                </div>
                                <div class="form-group">
                                    <label>Test Date:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="date" placeholder="" value="<?php echo date(
                                            'Y-m-d'
                                        ); ?>" style=" width: 240px; height: 31px; text-align:center" id="testdate">
                                </div>
                                <div class="form-group">
                                    <label>Fee Amount:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="number" min="0" step="1" value="0.00" name="fee_amount" id="fee_amount"
                                        placeholder="" style="width: 240px; height: 31px; text-align:center">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-10" style="border: 1px solid black;">
                                <h5><b>Test Result</b></h5>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="negative_pos" style="display: inline-block">
                                            <div class="form-group">
                                                <input type="radio" checked id="negative_pos" name="negative_positive"
                                                    value="neg">
                                                Negative
                                            </div>
                                        </label>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label>Form:</label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <select style="width: 240px; height: 31px;" id="selectForm">
                                                <option selected disabled value="">Please select Form</option>
                                                <?php
                                                    $sql =
                                                        'SELECT * FROM drugform';
                                                    $result = $conn->query(
                                                        $sql
                                                    );
                                                    if ($result->num_rows > 0) {
                                                        while (
                                                            $row = $result->fetch_assoc()
                                                        ) {
                                                            echo '<option value="' .
                                                                $row[
                                                                    'form_id'
                                                                ] .
                                                                '">' .
                                                                $row[
                                                                    'form_nm'
                                                                ] .
                                                                '</option>';
                                                        }
                                                    }
?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3" style="display: inline-block">
                                        <label for="negative_positive" style="display: inline-block; text-align: left;">
                                            <input type="radio" id="negative_positive" name="negative_positive"
                                                value="pos">
                                            Positive for the Following:
                                        </label>
                                    </div>
                                    <div class="col-md-9" style="display: inline-block">
                                        <div class="row" id="drugsOfForm">
                                            <?php
                                                // $sql = 'SELECT * FROM drugs';
                                                // $result = $conn->query($sql);
                                                // if ($result->num_rows > 0) {
                                                //     while (
                                                //         $row = $result->fetch_assoc()
                                                //     ) {
                                                //         echo '<div class="form-group ml-3">';
                                                //         echo '    <label for="drug_' .
                                                //             $row['drug_id'] .
                                                //             '">
                                                //             <input type="hidden" disabled class="positiveForCheckBox" name="positiveForCheckBoxName" id="drugName_' .
                                                //             $row['drug_id'] .
                                                //             '" value="' .
                                                //             $row['drug_id'] .
                                                //             '">
                                                //             <input type="checkbox" disabled class="positiveForCheckBox" name="positiveForCheckBox" id="drug_' .
                                                //             $row['drug_id'] .
                                                //             '" value="' .
                                                //             $row['drug_id'] .
                                                //             '">';
                                                //         echo '&emsp;' .
                                                //             $row['drug_nm'];
                                                //         echo '</label></div>';
                                                //     }
                                                // }
?>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="other_substances"
                                                style="display: inline-block; text-align: left;">
                                                <input type="checkbox" name="" id="other_substances" value="T">
                                                Other Substances:
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="other_substances_input" id="other_substances_input"
                                                value="" style="width: 240px; height: 31px;" disabled>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <br>
                        <button type="button" name="submitPurchase" class="btn ml-1"
                            style="background-color:#E7D7B7; border-radius:12px; width: 100px;"
                            onclick="window.open('testinfo.php', '_self');">New</button>
                        <button type="button" name="submitSave" id="submitSave" class="btn ml-1"
                            style="background-color:#E7D7B7; border-radius:12px; width: 100px;">Save</button>
                        <button type="button" name="submitDelete" id="submitDelete" class="btn ml-1"
                            style="background-color:#E7D7B7; border-radius:12px; width: 100px;">Delete</button>
                        <br>
                        <!-- </form> -->
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <div id="myModal_Employee" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">New Employee</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body" style="display: inline-block">
                            <div id="main_div">
                                <div class="row">
                                    <div class="col-md-2" style="display: inline-block">Specimen ID: </div>
                                    <div class="col-md-7" style="display: inline-block">
                                        <input class="form-control" id="specimen_id" name="specimen_id">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2" style="display: inline-block">Employee ID (SSN): </div>
                                    <div class="col-md-7" style="display: inline-block">
                                        <input type="hidden" id="employeesindex" name="employeesindex" value="">
                                        <input class="form-control" id="emp_id" name="emp_id">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2" style="display: inline-block">First Name / Req No: </div>
                                    <div class="col-md-7" style="display: inline-block">
                                        <input class="form-control" id="first_nm" name="first_nm">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2" style="display: inline-block">Last Name: </div>
                                    <div class="col-md-7" style="display: inline-block">
                                        <input class="form-control" id="last_nm" name="last_nm">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2" style="display: inline-block">Location: </div>
                                    <div class="col-md-7" style="display: inline-block">
                                        <select class="form-control" id="division_id" name="division_id">
                                            <!-- <option value="">Select Location</option> -->
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2" style="display: inline-block"></div>
                                    <div class="col-md-7" style="display: inline-block">
                                        <fieldset style="border: 1px solid lightgray; padding: 10px">
                                            <legend>Status</legend>
                                            <label for="status_pre_employment"><input type="radio"
                                                    id="status_pre_employment"
                                                    name="status">&emsp;Pre-Employment</label><br>
                                            <label for="status_active"><input type="radio" id="status_active"
                                                    name="status">&emsp;Active</label><br>
                                            <label for="status_terminated"><input type="radio" id="status_terminated"
                                                    name="status">&emsp;Terminated</label><br>
                                        </fieldset>
                                    </div>
                                    <!-- <div class="col-md-2" style="display: inline-block">Location: </div><div class="col-md-7" style="display: inline-block"><select class="form-control"><option value="">Select Location</option></select></div> -->
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" onclick="addEmployees();">OK</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal"
                                onclick="selected_fees = -1;">Close</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Help</button>
                        </div>
                    </div>

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
    <script src="dist/js/adminlte.js"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="dist/js/pages/dashboard3.js"></script>

    <script>
    function addEmployees() {
        $('#myModal_Employee').modal('hide');
        var temp = {};
        temp['emp_id'] = $('#emp_id').val();
        temp['specimen_id'] = $('#specimen_id').val();
        temp['first_nm'] = $('#first_nm').val();
        temp['last_nm'] = $('#last_nm').val();
        temp['division_id'] = $('#division_id').val();
        temp['account_id'] = $('#accounts_select').val();
        temp['status'] = '';
        if ($('#status_pre_employment').is(':checked'))
            temp['status'] = 'P';
        else if ($('#status_active').is(':checked'))
            temp['status'] = 'A';
        else if ($('#status_terminated').is(':checked'))
            temp['status'] = 'T';

        $('#emp_id').val('');
        $('#specimen_id').val('');
        $('#first_nm').val('');
        $('#last_nm').val('');
        $('#division_id').val('');
        $('#status_pre_employment').prop('checked', false);
        $('#status_active').prop('checked', false);
        $('#status_terminated').prop('checked', false);
        $('#employeesindex').val('');

        $.ajax({
            type: "POST",
            url: "insert_employee.php",
            data: 'employeeData=' + JSON.stringify(temp),
            success: function(resultData) {
                console.log(resultData);
                alert(resultData);
                location.reload();
                // window.open("accounts.php", "_self");
            }
        });
    }

    $(document).ready(function() {
        $('#status_pre_employment').prop('checked', true);
        $('#new_form').css('pointer-events', 'all');
        $('#cancel_form').css('pointer-events', 'all');
        // setTimeout(() => {
        // $("#accounts_select").children().eq(1).attr('selected', 'selected');
        $('#select_account_div').css('display', 'none');
        $('#main_div_main').css('display', 'block');
        $.ajax({
            type: "GET",
            url: "get_location_testinfo.php",
            data: 'account_id_location=' + $("#accounts_select").val(),
            success: function(resultData) {
                $('#location_select').html(resultData);
                // window.open("accounts.php", "_self");
            }
        });
        // }, 500);
    })

    $('#accounts_select').on('change', function() {
        $('#select_account_div').css('display', 'none');
        $('#main_div_main').css('display', 'block');
        $.ajax({
            type: "GET",
            url: "get_location_testinfo.php",
            data: 'account_id_location=' + $(this).val(),
            success: function(resultData) {
                $('#location_select').html(resultData);
                // window.open("accounts.php", "_self");
            }
        });
    })

    $('#location_select').on('change', function() {
        console.log("get_location_testinfo.php?account_id_employee=" + $('#accounts_select').val() +
            "&location_select=" + $(this)
            .val())
        $.ajax({
            type: "GET",
            url: "get_location_testinfo.php?account_id_employee=" + $('#accounts_select').val() +
                "&location_select=" + $(this)
                .val(),
            success: function(resultData) {
                console.log(resultData);
                $('#employee_select').html(resultData);
                // window.open("accounts.php", "_self");
            }
        });
    })

    $('#other_substances').on('click', function() {
        if ($(this).is(":checked"))
            $('#other_substances_input').prop('disabled', false);
        else
            $('#other_substances_input').prop('disabled', true);
    })


    $('#fee_amount').on('change', function() {
        if ($(this).val() < $(this).attr('min'))
            $(this).val($(this).attr('min'));
    })

    $('#selectForm').on('change', function() {
        $.ajax({
            type: "GET",
            url: "get_drugs_from_form.php?form_id=" + $('#selectForm')
                .val(),
            success: function(resultData) {
                console.log(resultData);
                $('#drugsOfForm').html(resultData);
                // window.open("accounts.php", "_self");
            }
        });
    })

    $('#negative_pos').on('click', function() {
        if ($('#negative_pos').is(':checked')) {
            // $('#selectForm').val('');
            // $('#drugsOfForm').html('');
            $('.positiveForCheckBox').prop('checked', false);
            $('.positiveForCheckBox').prop('disabled', true);
            // $('#selectForm').prop('disabled', true);
        } else {
            // $('#selectForm').prop('disabled', false);
            // $('#selectForm').val('');
            $('.positiveForCheckBox').prop('disabled', false);
        }
    })

    $('#negative_positive').on('click', function() {
        if ($('#negative_positive').is(':checked')) {
            // $('#selectForm').val('');
            // $('#selectForm').prop('disabled', false);
            $('.positiveForCheckBox').prop('disabled', false);
        } else {
            // $('#selectForm').prop('disabled', true);
            $('.positiveForCheckBox').prop('checked', false);
            $('.positiveForCheckBox').prop('disabled', true);

        }
    })

    $('#submitSave').on('click', function() {
        if (validateForm()) {
            console.log("form validated");
            var negative_positive = '';
            var other_substances = null;
            var other_substances_input = '';
            if ($('#negative_positive').is(':checked')) {
                negative_positive = 'pos';
            } else if ($('#negative_pos').is(':checked')) {
                negative_positive = 'neg';
            } else {
                alert('Kindly select Test Result');
                return;
            }

            if ($('#other_substances').is(':checked')) {
                other_substances = 'T'
                other_substances_input = $('#other_substances_input').val()
            }

            var drug_ids = [];
            var drug_result = [];
            for (i = 0; i < document.getElementsByName('positiveForCheckBoxName').length; i++) {
                console.log("iter: " + i)
                console.log(document.getElementsByName('positiveForCheckBoxName')[i].value)

                drug_ids.push(document.getElementsByName('positiveForCheckBoxName')[i].value);
                if (document.getElementsByName('positiveForCheckBox')[i].checked)
                    drug_result.push('P');
                else
                    drug_result.push('N');

            }

            var data = {
                'requisition_no': $('#requisitionNo').val(),
                'accounts_select': $('#accounts_select').val(),
                'employee_select': $('#employee_select').val(),
                'location_select': $('#location_select').val(),
                'testreason': $('#testreason').val(),
                'collectiondate': $('#collectiondate').val(),
                'date_reported': $('#date_reported').val(),
                'date_mro_recvd': $('#date_mro_recvd').val(),
                'sampletype': $('#sampletype').val(),
                'testdate': $('#testdate').val(),
                'testtype': $('#testtype').val(),
                'fee_amount': $('#fee_amount').val(),
                'negative_positive': negative_positive,
                'selectForm': $('#selectForm').val(),
                'other': other_substances,
                'otherName': other_substances_input,
                'drug_ids': drug_ids,
                'drug_result': drug_result
            };
            $.ajax({
                type: 'POST',
                url: 'insert_test.php',
                data: data,
                success: function(response) {
                    console.log(response);
                    if (response == '') {
                        alert('Test saved successfully.')
                        window.open("testinfo.php", "_self");
                    } else {
                        alert('Error occurred while saving test.')
                        window.open("testinfo.php", "_self");
                    }

                    // alert(response);
                }
            });
            console.log('form_validated', data);
        }
    })

    $('#testtype').on('change', function() {
        $.ajax({
            type: 'GET',
            url: 'getFeesFromTestType.php?account=' + $('#accounts_select').val() + '&type_id=' + $(
                this).val(),
            success: function(response) {
                console.log(response);
                $('#fee_amount').val(response);
            }
        });
    })

    function validateForm() {
        if ($('#requisitionNo').val() == '' || $('#requisitionNo').val() == null) {
            $('#requisitionNo').focus();
            alert("Please enter Requisition No");
            return false;
        }
        if ($('#employee_select').val() == '' || $('#employee_select').val() == null) {
            $('#employee_select').focus();
            alert("Please Select Employee");
            return false;
        }
        if ($('#location_select').val() == '' || $('#location_select').val() == null) {
            $('#location_select').focus();
            alert("Please Select Location");
            return false;
        }
        if ($('#testreason').val() == '' || $('#testreason').val() == null) {
            $('#testreason').focus();
            alert("Please Select Test Reason");
            return false;
        }
        if ($('#collectiondate').val() == '' || $('#collectiondate').val() == null) {
            $('#collectiondate').focus();
            alert("Please Select Collection Date");
            return false;
        }
        if ($('#sampletype').val() == '' || $('#sampletype').val() == null) {
            $('#sampletype').focus();
            alert("Please Select Sample Type");
            return false;
        }
        if ($('#testdate').val() == '' || $('#testdate').val() == null) {
            $('#testdate').focus();
            alert("Please Select Test Date");
            return false;
        }
        if ($('#testtype').val() == '' || $('#testtype').val() == null) {
            $('#testtype').focus();
            alert("Please Select Test Type");
            return false;
        }
        if ($('#fee_amount').val() == '0.00') {
            $('#fee_amount').focus();
            alert("Please Select Fee Amount");
            return false;
        }
        return true;
    }

    $('#negative_pos').on('click', function() {
        if ($('#negative_pos').is(":checked")) {
            console.log("asdadsa");
        }
    })

    $('#negative_positive').on('click', function() {
        if ($('#negative_positive').is(":checked")) {
            console.log("asdadsa");
        }
    })
    </script>
</body>

</html>