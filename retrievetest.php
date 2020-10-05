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
    <link rel="stylesheet" href="dist/css/jquery.dataTables.min.css">
    <style>
    label {
        /* Other styling... */
        text-align: right;
        clear: both;
        float: left;
        margin-right: 15px;
    }
    /* Style the buttons that are used to open and close the accordion panel */
    .accordion {
    background-color: #E7D7B7;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    text-align: left;
    border: none;
    outline: none;
    transition: 0.4s;
    }

    /* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
    .accordion-active, .accordion:hover {
    background-color: #d4b77e;
    }

    /* Style the accordion panel. Note: hidden by default */
    .panel {
    padding: 0 18px;
    /* background-color: white; */
    display: none;
    width: 100%;
    overflow: hidden;
    }

    .accordion:after {
        content: '\02795'; /* Unicode character for "plus" sign (+) */
        font-size: 13px;
        color: #777;
        float: right;
        margin-left: 5px;
    }

    .accordion-active:after {
        content: "\2796"; /* Unicode character for "minus" sign (-) */
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
                        <option selected disabled>Please select Account</option>
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
                                <h1 class="m-0 text-dark"><b><u>Retrieve Test</u></b></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Retrieve Test</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        <!-- <form action="" method="POST" class=""> -->
                            <div class="row">
                                <div class="col-md-6" style="border: 1px solid black;">
                                    <h5><b>Options</b></h5>
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group">
                                                <label>Retrieve:</label>
                                                &nbsp;
                                                <select style="width: 300px; height: 31px;" id="retrieve_tests">
                                                    <option value="All_test_results">All test results</option>
                                                    <option value="Unbilled_test_results">Unbilled test results</option>
                                                    <option value="By_test_number">By test number</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Test No:</label>
                                                &nbsp;&nbsp;&nbsp;
                                                <input disabled id="test_no_retrieve" type="number" min=0 value="0"
                                                    placeholder="" style="width: 200px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6" style="">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <button type="button" id="select_ok_button" class="btn mt-2 ml-1"
                                                style="background-color:#E7D7B7; border-radius:5px; width: 100px;">OK</button>
                                            <button type="button" onclick="window.open('retrievetest.php', '_self');" class="btn mt-2 ml-1"
                                                style="background-color:#E7D7B7; border-radius:5px; width: 100px;">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="search_criteria" style="display: none; margin-top: 10px; padding-top: 10px">
                                <button class="accordion">Search Criteria</button>
                                <div class="panel">
                                    <div class="col-md-12 mt-2" style="border: 1px solid black;">
                                        <!-- <h5><b>Search Criteria</b></h5> -->
                                        <!-- <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <input type="checkbox" name="" value="">
                                                    <b>Show unbilled tests only</b>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="row" style="margin-top: 10px;">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="search_by_employee_id_checkbox"><input type="checkbox" id="search_by_employee_id_checkbox" name=""
                                                        value="">
                                                    Employee ID:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <select style="width: 477px; height: 31px;" id="search_by_employee_id"
                                                    disabled>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="search_by_test_date_checkbox"><input type="checkbox" id="search_by_test_date_checkbox" name=""
                                                        value="">
                                                    Test Date:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>From:</label>
                                                <input type="date" id="search_by_from_test_date" name="" value="" disabled>
                                            </div>
                                            <div class="col-md-3">
                                                <label>To:</label>
                                                <input type="date" id="search_by_to_test_date" name="" value="" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="search_by_collection_date_checkbox"><input type="checkbox" id="search_by_collection_date_checkbox" name=""
                                                        value="">
                                                    Collection Date:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>From:</label>
                                                <input type="date" id="search_by_from_collection_date" name="" value=""
                                                    disabled>
                                            </div>
                                            <div class="col-md-3">
                                                <label>To:</label>
                                                <input type="date" id="search_by_to_collection_date" name="" value=""
                                                    disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="search_by_complete_checkbox"><input type="checkbox" name="" value=""
                                                        id="search_by_complete_checkbox">
                                                    Complete:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <select id="search_by_complete" style="width: 150px; height: 31px;"
                                                    disabled>
                                                    <option>No</option>
                                                    <option>Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="search_by_test_results_checkbox"><input type="checkbox" name="" value=""
                                                        id="search_by_test_results_checkbox">
                                                    Test Results:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <select style="width: 150px; height: 31px;" id="search_by_test_results"
                                                    disabled>
                                                    <option>Negative</option>
                                                    <option>Positive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="search_by_test_type_checkbox"><input type="checkbox" name="" value=""
                                                        id="search_by_test_type_checkbox">
                                                    Test Type:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <select style="width: 477px; height: 31px;" id="search_by_test_type"
                                                    disabled>
                                                    <option selected disabled value="">Please select Test Type</option>
                                                    <?php
    $sql = 'SELECT * FROM testtype';
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['type_id'] . '">' . $row['type_nm'] . '</option>';
        }
    }
    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                <label for="search_by_test_reason_checkbox"><input type="checkbox" name="" value=""
                                                        id="search_by_test_reason_checkbox">
                                                    Test Reason:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <select style="width: 477px; height: 31px;" id="search_by_test_reason"
                                                    disabled>
                                                    <option selected disabled value="">Please select Test Reason</option>
                                                    <?php
    $sql = 'SELECT * FROM reasons';
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['reason_id'] . '">' . $row['reason_code'] . ' - ' . $row['reason_nm'] . '</option>';
        }
    }
    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="search_by_group_no_checkbox"><input type="checkbox" name="" value=""
                                                        id="search_by_group_no_checkbox">
                                                    Group No:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <select style="width: 477px; height: 31px;" id="search_by_group_no"
                                                    disabled>
                                                    <option></option>
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                <label for="search_by_form_checkbox"><input type="checkbox" name="" value="" id="search_by_form_checkbox">
                                                    Form:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <select style="width: 477px; height: 31px;" id="search_by_form" disabled>
                                                    <option selected disabled value="">Please select Form</option>
                                                    <?php
    $sql = 'SELECT * FROM drugform';
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['form_id'] . '">' . $row['form_nm'] . '</option>';
        }
    }
    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="search_by_entry_user_checkbox"><input type="checkbox" name="" value=""
                                                        id="search_by_entry_user_checkbox">
                                                    Entry User:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <select style="width: 477px; height: 31px;" id="search_by_entry_user"
                                                    disabled>
                                                    <option selected disabled value="">Please select Entry User</option>
                                                    <?php
    $sql = 'SELECT * FROM users';
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['user_id'] . '">' . $row['first_nm'] . ' ' . $row['last_nm'] . '</option>';
        }
    }
    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="search_by_entry_date_checkbox"><input type="checkbox" name="" value=""
                                                        id="search_by_entry_date_checkbox">
                                                    Entry Date:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>From:</label>
                                                <input type="date" name="" value="" disabled id="search_by_entry_date_from">
                                            </div>
                                            <div class="col-md-3">
                                                <label>To:</label>
                                                <input type="date" name="" value="" disabled id="search_by_entry_date_to">
                                            </div>
                                        </div>
                                        <div class="row" style="margin-bottom: 10px">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="search_by_invoice_no_checkbox"><input type="checkbox" name="" value=""
                                                        id="search_by_invoice_no_checkbox">
                                                    Invoice No:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <select style="width: 477px; height: 31px;" disabled
                                                    id="search_by_invoice_no">
                                                    <option selected disabled value="">Please select Invoice No</option>
                                                    <?php
    $sql = 'SELECT * FROM invoice';
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['invoice_id'] . '">' . $row['invoice_id'] . '</option>';
        }
    }
    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="search_results" style="display: none;">
                                <div class="col-md-12 mt-2" style="border: 1px solid black;">
                                    <h5><b>Search Result</b></h5>
                                    <table id="tbl_search_results" class="hover" style="width:100%">
                                        <thead>
                                            <th>S. No.</th>
                                            <th>Test No</th>
                                            <th>Invoice No</th>
                                            <th>Emp ID</th>
                                            <th>Location</th>
                                            <th>Test Reason</th>
                                            <th>Sample Type</th>
                                            <th>Test Type</th>
                                            <th>Fee Amount</th>
                                        </thead>
                                        <tbody id="tbl_search_results_body">
                                        
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <!-- </form> -->
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
    <script src="dist/js/jquery.dataTables.min.js"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="dist/js/pages/dashboard3.js"></script>
    <script src="dist/js/pages/dashboard3.js"></script>
    <script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            /* Toggle between adding and removing the "active" class,
            to highlight the button that controls the panel */
            this.classList.toggle("accordion-active");

            /* Toggle between hiding and showing the active panel */
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
            panel.style.display = "none";
            } else {
            panel.style.display = "block";
            }
        });
    }
    </script>
    <script>

    $(document).ready(function() {
        // setTimeout(() => {
            $("#accounts_select").children().eq(1).attr('selected', 'selected');
            $.ajax({
                type: "GET",
                url: "getEmployeesFromAccount.php",
                data: 'account_id_location=' + $("#accounts_select").val(),
                success: function(resultData) {
                    $('#search_by_employee_id').html(resultData);
                    // window.open("accounts.php", "_self");
                }
            });
        // }, 500);
    })

    $('#accounts_select').on('change', function() {
        $.ajax({
            type: "GET",
            url: "getEmployeesFromAccount.php",
            data: 'account_id_location=' + $(this).val(),
            success: function(resultData) {
                $('#search_by_employee_id').html(resultData);
                // window.open("accounts.php", "_self");
            }
        });
    })
    
    </script>
    <script>
    $('#retrieve_tests').on('change', function() {
        $('#test_no_retrieve').val('0');
        $('#search_results').css('display', 'none');
        $('#search_criteria').css('display', 'none');
        $('#test_no_retrieve').prop('disabled', true);
        if ($(this).val() == 'By_test_number')
            $('#test_no_retrieve').prop('disabled', false);
        if ($(this).val() == 'Other')
            $('#search_criteria').css('display', '');
    })

    $('#test_no_retrieve').on('change', function() {
        if ($(this).val() < $(this).attr('min'))
            $(this).val($(this).attr('min'));
    })

    $('#search_by_employee_id_checkbox').on('click', function() {
        if ($(this).is(":checked"))
            $('#search_by_employee_id').prop('disabled', false);
        else
            $('#search_by_employee_id').prop('disabled', true);
    })

    $('#search_by_test_date_checkbox').on('click', function() {
        if ($(this).is(":checked")) {
            $('#search_by_from_test_date').prop('disabled', false);
            $('#search_by_to_test_date').prop('disabled', false);
        } else {
            $('#search_by_from_test_date').prop('disabled', true);
            $('#search_by_to_test_date').prop('disabled', true);
        }
    })

    $('#search_by_collection_date_checkbox').on('click', function() {
        if ($(this).is(":checked")) {
            $('#search_by_from_collection_date').prop('disabled', false);
            $('#search_by_to_collection_date').prop('disabled', false);
        } else {
            $('#search_by_from_collection_date').prop('disabled', true);
            $('#search_by_to_collection_date').prop('disabled', true);
        }
    })

    $('#search_by_complete_checkbox').on('click', function() {
        if ($(this).is(":checked")) {
            $('#search_by_complete').prop('disabled', false);
        } else {
            $('#search_by_complete').prop('disabled', true);
        }
    })

    $('#search_by_test_results_checkbox').on('click', function() {
        if ($(this).is(":checked")) {
            $('#search_by_test_results').prop('disabled', false);
        } else {
            $('#search_by_test_results').prop('disabled', true);
        }
    })

    $('#search_by_test_type_checkbox').on('click', function() {
        if ($(this).is(":checked")) {
            $('#search_by_test_type').prop('disabled', false);
        } else {
            $('#search_by_test_type').prop('disabled', true);
        }
    })

    $('#search_by_test_reason_checkbox').on('click', function() {
        if ($(this).is(":checked")) {
            $('#search_by_test_reason').prop('disabled', false);
        } else {
            $('#search_by_test_reason').prop('disabled', true);
        }
    })

    $('#search_by_group_no_checkbox').on('click', function() {
        if ($(this).is(":checked")) {
            $('#search_by_group_no').prop('disabled', false);
        } else {
            $('#search_by_group_no').prop('disabled', true);
        }
    })

    $('#search_by_form_checkbox').on('click', function() {
        if ($(this).is(":checked")) {
            $('#search_by_form').prop('disabled', false);
        } else {
            $('#search_by_form').prop('disabled', true);
        }
    })

    $('#search_by_entry_user_checkbox').on('click', function() {
        if ($(this).is(":checked")) {
            $('#search_by_entry_user').prop('disabled', false);
        } else {
            $('#search_by_entry_user').prop('disabled', true);
        }
    })

    $('#search_by_entry_date_checkbox').on('click', function() {
        if ($(this).is(":checked")) {
            $('#search_by_entry_date_from').prop('disabled', false);
            $('#search_by_entry_date_to').prop('disabled', false);
        } else {
            $('#search_by_entry_date_from').prop('disabled', true);
            $('#search_by_entry_date_to').prop('disabled', true);
        }
    })

    $('#search_by_invoice_no_checkbox').on('click', function() {
        if ($(this).is(":checked")) {
            $('#search_by_invoice_no').prop('disabled', false);
        } else {
            $('#search_by_invoice_no').prop('disabled', true);
        }
    })

    $('#select_ok_button').on('click', function() {
        // $('#search_criteria').css('display', 'none');
        for (i = 0; i < acc.length; i++) {

            $('.accordion').removeClass("accordion-active");
            $('.panel').css('display', "none");
        }
        console.log("retrieve_tests", $('#retrieve_tests').val());
        if($('#retrieve_tests').val() == 'All_test_results') {
            retrieveAllTests();
        } else if ($('#retrieve_tests').val() == 'Unbilled_test_results') {
            retrieveUnbilledTests();
        } else if ($('#retrieve_tests').val() == 'By_test_number') {
            retrieveByTestNo();
        } else if ($('#retrieve_tests').val() == 'Other') {
            retrieveOther();
        }
    })

    function retrieveAllTests() {
        $('#search_results').css('display', '');
        $('#test_no_retrieve').val('0');
        $('#test_no_retrieve').prop('disabled', true);

        $.ajax({
            type: "GET",
            url: "retrieveAllTests.php",
            success: function(resultData) {
                // console.log(resultData);
                $('#tbl_search_results_body').html(resultData);
                $('#tbl_search_results').DataTable();

            }
        });
    }

    function retrieveUnbilledTests() {
        $('#search_results').css('display', '');
        $('#test_no_retrieve').val('0');
        $('#test_no_retrieve').prop('disabled', true);
        
        $.ajax({
            type: "GET",
            url: "retrieveUnbilledTests.php",
            success: function(resultData) {
                // console.log(resultData);
                $('#tbl_search_results_body').html(resultData);
                $('#tbl_search_results').DataTable();

            }
        });
    }

    function retrieveByTestNo() {
        $('#search_results').css('display', '');
        
        $.ajax({
            type: "GET",
            url: "retrieveByTestNo.php?test_id=" + $('#test_no_retrieve').val(),
            success: function(resultData) {
                // console.log(resultData);
                $('#tbl_search_results_body').html(resultData);
                $('#tbl_search_results').DataTable();
            }
        });
    }

    function retrieveOther() {
        $('#search_results').css('display', '');
        $('#test_no_retrieve').val('0');
        $('#test_no_retrieve').prop('disabled', true);
        var data = {};
        data['emp_id'] = ($('#search_by_employee_id_checkbox').is(':checked')) ? $('#search_by_employee_id').val() : '';
        data['test_date_from'] = ($('#search_by_test_date_checkbox').is(':checked')) ? $('#search_by_from_test_date').val() : '';
        data['test_date_to'] = ($('#search_by_test_date_checkbox').is(':checked')) ? $('#search_by_to_test_date').val() : '';
        data['collection_date_from'] = ($('#search_by_collection_date_checkbox').is(':checked')) ? $('#search_by_from_collection_date').val() : '';
        data['collection_date_to'] = ($('#search_by_collection_date_checkbox').is(':checked')) ? $('#search_by_to_collection_date').val() : '';
        data['status'] = ($('#search_by_complete_checkbox').is(':checked')) ? $('#search_by_complete').val() : '';
        data['result'] = ($('#search_by_test_results_checkbox').is(':checked')) ? $('#search_by_test_results').val() : '';
        data['type_id'] = ($('#search_by_test_type_checkbox').is(':checked')) ? $('#search_by_test_type').val() : '';
        data['reason_id'] = ($('#search_by_test_reason_checkbox').is(':checked')) ? $('#search_by_test_reason').val() : '';
        data['batch_id'] = ($('#search_by_group_no_checkbox').is(':checked')) ? $('#search_by_group_no').val() : '';
        data['form_id'] = ($('#search_by_form_checkbox').is(':checked')) ? $('#search_by_form').val() : '';
        data['insert_user_id'] = ($('#search_by_entry_user_checkbox').is(':checked')) ? $('#search_by_entry_user').val() : '';
        data['insert_date_from'] = ($('#search_by_entry_date_checkbox').is(':checked')) ? $('#search_by_entry_date_from').val() : '';
        data['insert_date_to'] = ($('#search_by_entry_date_checkbox').is(':checked')) ? $('#search_by_entry_date_to').val() : '';
        data['invoice_id'] = ($('#search_by_invoice_no_checkbox').is(':checked')) ? $('#search_by_invoice_no').val() : '';
        // if()
        $.ajax({
            type: "POST",
            url: "retrieveOther.php",
            data: 'data='+JSON.stringify(data),
            contentType: 'application/x-www-form-urlencoded',
            success: function(resultData) {
                console.log(resultData);
                var obj = JSON.parse(resultData);
                console.log(obj);

                $('#tbl_search_results_body').html(obj.data);
                $('#tbl_search_results').DataTable();
            }
        });
    }
    </script>
</body>

</html>