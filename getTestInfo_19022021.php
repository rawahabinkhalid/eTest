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
    <link href="plugins/select2/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dist/css/dataTables.bootstrap4.min.css">

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

            <?php include "header.php"; ?>
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
                <div class="content">
                    <div class="container-fluid">
                        <!-- <form action="" method="POST" class=""> -->

                        <?php
                        $sql = 'SELECT * FROM test LEFT JOIN reasons ON test.reason_id = reasons.reason_id LEFT JOIN sampletype ON test.sample_id = sampletype.sample_id LEFT JOIN testtype ON test.type_id = testtype.type_id LEFT JOIN divisions ON test.division_id = divisions.division_id LEFT JOIN drugform ON test.form_id = drugform.form_id JOIN employees ON employees.emp_id = test.emp_id LEFT JOIN invoice ON test.invoice_id = invoice.invoice_id WHERE test.account_id = ' . $_GET['account'] . ' AND test_id=' . $_GET['id'];
                        // echo $sql;
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Test No:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" id="getTestNo" disabled value="<?php if (isset($row['test_id'])) echo $row['test_id']; ?>" style="width: 240px; height: 31px; text-align:center">

                                </div>
                                <div class="form-group">
                                    <label>Requisition No:</label>
                                    <input type="text" placeholder="" value="<?php if (isset($row['req_no'])) echo $row['req_no']; ?>" style="width: 240px; height: 31px; text-align:center">
                                </div>
                                <div class="form-group">
                                    <label>Emp ID:</label>
                                    <input type="hidden" id="getEmployeeId" placeholder="" value="<?php if (isset($row['emp_id'])) echo $row['emp_id']; ?>" style="width: 240px; height: 31px; text-align:center">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select style="width: 240px; height: 31px;" id="employee_select">
                                        <option id="getEmployee" value="<?php if (isset($row['emp_id'])) echo $row['emp_id']; ?>">
                                            <?php if (isset($row['emp_id'])) echo $row['specimen_id'] . ' - ' . $row['first_nm'] . ' ' . $row['last_nm']; ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Test Reason:</label>
                                    &nbsp;&nbsp;&nbsp;
                                    <select style="width: 240px; height: 31px;" id="testreason">
                                        <option value="<?php if (isset($row['reason_id'])) echo $row['reason_id']; ?>">
                                            <?php if (isset($row['reason_id'])) echo $row['reason_nm']; ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Date Reported:</label>
                                    <input type="date" value="<?php if (isset($row['reported_date'])) echo $row['reported_date']; ?>" name="date_reported" id="date_reported" placeholder="" style="width: 240px; height: 31px; text-align:center">
                                </div>
                                <div class="form-group">
                                    <label>Sample Type:</label>
                                    &nbsp;&nbsp;&nbsp;
                                    <select style="width: 240px; height: 31px;" id="sampletype">
                                        <option value="<?php if (isset($row['sample_id'])) echo $row['sample_id']; ?>">
                                            <?php if (isset($row['sample_id'])) echo $row['sample_nm']; ?></option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Test Type:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select style="width: 240px; height: 31px;" id="testtype">
                                        <option id="getTestType" value="<?php if (isset($row['type_id'])) echo $row['type_id']; ?>">
                                            <?php if (isset($row['type_id'])) echo $row['type_nm']; ?></option>
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
                                    <input type="text" id="invoice_no" value="<?php if (isset($row['invoice_id'])) echo $row['invoice_id']; ?>" style="width: 240px; height: 31px; text-align:center">
                                    <input type="hidden" id="invoice_status" value="<?php if (isset($row['paid'])) echo $row['paid']; ?>" style="width: 240px; height: 31px; text-align:center">
                                </div>
                                <div class="form-group">
                                    <label>Group No:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input style="width: 240px; height: 31px;" type="text" style="text-align:center" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Location:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select style="width: 240px; height: 31px;" id="location_select">
                                        <option value="<?php if (isset($row['division_id'])) echo $row['division_id']; ?>">
                                            <?php if (isset($row['division_id'])) echo $row['division_nm']; ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Collection Date:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="date" placeholder="" style="width: 240px; height: 31px;
                                            text-align:center" id="collectiondate" value="<?php if (isset($row['collection_date']))
                                                                                                $date = explode(" ", $row['collection_date']);
                                                                                            echo $date[0]; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Date MRO Copy Recvd:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="date" value="<?php if (isset($row['mro_received_date'])) echo $row['mro_received_date']; ?>" name="date_mro_recvd" id="date_mro_recvd" placeholder="" style="width: 240px; height: 31px; text-align:center">
                                </div>
                                <div class="form-group">
                                    <label>Test Date:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input id="getTestDate" type="date" placeholder="" style=" width: 240px; height: 31px; text-align:center" id="testdate" value="<?php if (isset($row['test_date']))
                                                                                                                                                                                $date = explode(" ", $row['test_date']);
                                                                                                                                                                            echo $date[0]; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Fee Amount:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input id="getFeeAmount" type="number" min="0" step="1" value="<?php if (isset($row['amount'])) echo number_format(floatval($row['amount']), 2); ?>" id="fee_amount" placeholder="" style="width: 240px; height: 31px; text-align:center">
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
                                                <input type="radio" id="negative_pos" <?php if (isset($row['result']) && $row['result'] == "N") echo "checked"; ?> name="negative_positive">
                                                Negative
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label>Form:</label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <select style="width: 240px; height: 31px;" id="selectForm">
                                                <option value="<?php if (isset($row['form_id'])) echo $row['form_id']; ?>">
                                                    <?php if (isset($row['form_id'])) echo $row['form_nm']; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3" style="display: inline-block">
                                        <label for="negative_positive" style="display: inline-block; text-align: left;">
                                            <input type="radio" id="negative_positive" name="negative_positive" <?php if (isset($row['result']) && $row['result'] == "P") echo "checked"; ?>>
                                            Positive for the Following:
                                        </label>
                                    </div>
                                    <?php

                                    ?>
                                    <div class="col-md-9" style="display: inline-block">
                                        <div class="row">
                                            <?php
                                            $sql = 'SELECT * FROM drugs JOIN formdrugs ON drugs.drug_id = formdrugs.drug_id WHERE form_id = ' . $row['form_id'];
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {

                                                    $sqlResult = 'SELECT * FROM testresult WHERE test_id = ' . $_GET['id'] . ' AND drug_id=' . $row['drug_id'];
                                                    $result1 = $conn->query($sqlResult);
                                                    $rowResult = $result1->fetch_assoc();

                                                    echo '<div class="form-group ml-3">';
                                                    echo '    <label for="drug_' . $row['drug_id'] . '"><input type="checkbox" ';
                                                    if (isset($rowResult['result']) && $rowResult['result'] == "P") echo "checked";
                                                    echo ' class="positiveForCheckBox" name="" id="drug_' . $row['drug_id'] . '" value="' . $row['drug_id'] . '">';
                                                    echo '&emsp;' . $row['drug_nm'];
                                                    echo '</label></div>';
                                                }
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="other_substances" style="display: inline-block">
                                                <input type="checkbox" name="" id="other_substances" value="" <?php if (isset($row['other'])) echo "checked"; ?>>
                                                Other Substances:
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="" id="other_substances_input" value="<?php if (isset($row['other_nm'])) echo $row['other_nm']; ?>" style="width: 240px; height: 31px;">
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <br>

                        <?php if ($_SESSION['usertype'] != 'accounts') { ?>

                            <button type="button" name="submitPurchase" class="btn ml-1" style="background-color:#E7D7B7; border-radius:12px; width: 100px;" onclick="window.open('testinfo.php', '_self');">New</button>
                        <?php } ?>
                        <button type="button" name="" id="" class="btn ml-1" style="background-color:#E7D7B7; border-radius:12px; width: 100px;" onclick="window.open('viewMROReport.php?id=<?php echo $_GET['id']; ?>', '_blank'
                            );">Print</button>
                        <button type="button" name="" id="" class="btn ml-1" style="background-color:#E7D7B7; border-radius:12px; width: 100px;" data-toggle="modal" data-target="#myModal_Send">Email</button>
                        <button type="button" name="submitSave" id="submitSave" class="btn ml-1"
                            style="background-color:#E7D7B7; border-radius:12px; width: 100px;">Update</button>
                        <!-- <button type="button" name="submitDelete" id="submitDelete" class="btn ml-1"
                            style="background-color:#E7D7B7; border-radius:12px; width: 100px;">Delete</button> -->
                        <br>
                        <!-- </form> -->
                    </div>
                    <!-- /.container-fluid -->
                </div>
                <br><br><br>
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
    <script src="plugins/select2/js/select2.min.js"></script>

    <script src="dist/js/pages/dashboard3.js"></script>
    <script src="dist/js/jquery.dataTables.min.js"></script>
    <script>
        // $(document).ready(function() {
        //     setTimeout(() => {
        //         $("#accounts_select").children().eq(1).attr('selected', 'selected');
        //         $('#select_account_div').css('display', 'none');
        //         $('#main_div_main').css('display', 'block');
        //         $.ajax({
        //             type: "GET",
        //             url: "get_location_testinfo.php",
        //             data: 'account_id_location=' + $("#accounts_select").val(),
        //             success: function(resultData) {
        //                 // $('#location_select').html(resultData);
        //                 // window.open("accounts.php", "_self");
        //             }
        //         });
        //     }, 500);
        // })

        var invoices_data = [];

        function refreshFormBilling() {
            $('#invoiceNoBill').val("");
            $('#invoiceDateBill').val("");
            $('#division_id_bill').val("");
            $('#invoiceReferenceBill').val("");
            $('#invoiceTermsBill').val("");
            $('#invoiceDueDateBill').val("");
            $('#sentBillDate').val("");
            $('#sentBill').attr("checked", false);
            $('#invoiceAmountDueBill').val("");
            $('#invoiceAmountPaidBill').val("0.00");
            $('#invoiceCheckNoBill').val("");
            $('#invoiceCheckDateBill').val("");
            $('#invoicePayDateBill').val("");
            $('#paidInFull').attr("checked", false);
            let id = new URL(location.href).searchParams.get("id");
            console.log("id")
            console.log(id)
            $('#test_id_added').val(new URL(location.href).searchParams.get("id"))
        }

        function getDataForInvoice(invoices_data_temp, value) {
            invoices_data = invoices_data_temp;
            const invoice = invoices_data.find(invoice => invoice.invoice_id === $('#invoiceNoBilled').val())
            console.log(invoice)
            $('#invoiceNoBill').val(invoice.invoice_id);
            if (invoice.invoice_date != null)
                $('#invoiceDateBill').val(invoice.invoice_date.split(' ')[0]);
            $('#division_id_bill').val(invoice.division_id);
            $('#invoiceReferenceBill').val(invoice.reference_nm);
            $('#invoiceTermsBill').val(invoice.terms);
            if (invoice.due_date != null)
                $('#invoiceDueDateBill').val(invoice.due_date.split(' ')[0]);
            if (invoice.send_date != null)
                $('#sentBillDate').val(invoice.send_date.split(' ')[0]);
            $('#sentBillDate').attr('readonly', true);
            $('#sentBill').attr("checked", false);
            if (invoice.sent == 'T') {
                $('#sentBill').attr("checked", true);
                $('#sentBillDate').prop("readonly", false);
            }
            $('#invoiceAmountDueBill').val(parseFloat($('#getFeeAmount').val()) + parseFloat(invoice.amount));
            $('#invoiceAmountPaidBill').val(parseFloat(invoice.amount_paid));
            $('#invoiceCheckNoBill').val(invoice.check_no);
            if (invoice.check_date != null)
                $('#invoiceCheckDateBill').val(invoice.check_date.split(' ')[0]);
            if (invoice.pay_date != null)
                $('#invoicePayDateBill').val(invoice.pay_date.split(' ')[0]);
            $('#paidInFull').attr("checked", true);

            table_data = "";
            counter = 1;

            invoice.test.forEach((test, index) => {
                console.log(test);
                $.ajax({
                    type: "GET",
                    url: "getTestData.php?test_id=" + test.test_id + "&counter=" + counter,
                    success: function(resultData) {
                        $('#tests_billed').DataTable().destroy();
                        console.log(resultData)
                        table_data += resultData;
                        $('#tbody_table_bill').html(table_data);
                        $('#tests_billed').DataTable({
                            "paging": false,
                            "searching": false,
                            "info": false
                        });
                    }
                });
                counter++;
            })

            let id = new URL(location.href).searchParams.get("id");
            console.log("id")
            console.log(id)
            $('#test_id_added').val(new URL(location.href).searchParams.get("id"))
            $.ajax({
                type: "GET",
                url: "getTestData.php?test_id=" + id + "&counter=" + counter,
                success: function(resultData) {
                    $('#tests_billed').DataTable().destroy();
                    console.log(resultData)
                    table_data += resultData;
                    $('#tbody_table_bill').html(table_data);
                    $('#tests_billed').DataTable({
                        "paging": false,
                        "searching": false,
                        "info": false
                    });
                }
            });
        }

        </script>
        <script>
    $('#accounts_select').select2().on("change", function(e) {
        sessionStorage.setItem('account_selected', $(this).val());
        console.log($(this).val())
        console.log(location.pathname)
        window.open(location.pathname.split('/')[location.pathname.split('/').length - 1] + '?account=' +
        sessionStorage.getItem('account_selected'), '_self');
    });
    </script>
    <script>
    $('#testreason').select2();
    $('#location_select').select2();
    $('#sampletype').select2();
    $('#testtype').select2();
    $('#selectForm').select2();
    $('#employee_select').select2();
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
    <script>
    $('#employee_select').on('select2:select', function (e) {
        $('span[aria-labelledby ="select2-employee_select-container"]').removeClass('validation-error')
        var data = e.params.data;
        console.log(data);
    });
    $('#location_select').on('select2:select', function (e) {
        $('span[aria-labelledby ="select2-location_select-container"]').removeClass('validation-error')
        var data = e.params.data;
        console.log(data);
    });
    $('#testreason').on('select2:select', function (e) {
        $('span[aria-labelledby ="select2-testreason-container"]').removeClass('validation-error')
        var data = e.params.data;
        console.log(data);
    });
    $('#collectiondate').on('change', function () {
        $('#collectiondate').removeClass('validation-error')
    });
    $('#date_reported').on('change', function () {
        $('#date_reported').removeClass('validation-error')
    });
    $('#date_mro_recvd').on('change', function () {
        $('#date_mro_recvd').removeClass('validation-error')
    });
    $('#getTestDate').on('change', function () {
        $('#getTestDate').removeClass('validation-error')
    });
    $('#sampletype').on('select2:select', function (e) {
        $('span[aria-labelledby ="select2-testtype-container"]').removeClass('validation-error')
        var data = e.params.data;
        console.log(data);
    });
    $('#testtype').on('select2:select', function (e) {
        $('span[aria-labelledby ="select2-sampletype-container"]').removeClass('validation-error')
        var data = e.params.data;
        console.log(data);
    });
    $('#fee_amount').on('change', function () {
        $('#fee_amount').removeClass('validation-error')
    });
    $('#selectForm').on('select2:select', function (e) {
        $('span[aria-labelledby ="select2-selectForm-container"]').removeClass('validation-error')
        var data = e.params.data;
        console.log(data);
    });
    </script>
    <script>

    // function addEmployees() {
    //     $('#myModal_Employee').modal('hide');
    //     var temp = {};
    //     temp['emp_id'] = $('#emp_id').val();
    //     temp['specimen_id'] = $('#specimen_id').val();
    //     temp['first_nm'] = $('#first_nm').val();
    //     temp['last_nm'] = $('#last_nm').val();
    //     temp['division_id'] = $('#division_id').val();
    //     temp['account_id'] = $('#accounts_select').val();
    //     temp['status'] = '';
    //     if ($('#status_pre_employment').is(':checked'))
    //         temp['status'] = 'P';
    //     else if ($('#status_active').is(':checked'))
    //         temp['status'] = 'A';
    //     else if ($('#status_terminated').is(':checked'))
    //         temp['status'] = 'T';

    //     $('#emp_id').val('');
    //     $('#specimen_id').val('');
    //     $('#first_nm').val('');
    //     $('#last_nm').val('');
    //     $('#division_id').val('');
    //     $('#status_pre_employment').prop('checked', false);
    //     $('#status_active').prop('checked', false);
    //     $('#status_terminated').prop('checked', false);
    //     $('#employeesindex').val('');

    //     $.ajax({
    //         type: "POST",
    //         url: "insert_employee.php",
    //         data: 'employeeData=' + JSON.stringify(temp),
    //         success: function(resultData) {
    //             // console.log(resultData);
    //             // alert(resultData);
    //             // location.reload();
    //             resultData = JSON.parse(resultData);
    //             console.log(resultData);
    //             console.log("" + resultData.id);
    //             alert(resultData.message);
    //             if(resultData.id !== undefined)
    //                 window.open(location.pathname.split('/')[location.pathname.split('/').length - 1] + '?account=' + sessionStorage.getItem('account_selected') + '&employee=' + resultData.id, '_self');
    //             else
    //                 $('#myModal_Employee').modal('show');
    //             // else
    //             //     location.reload();
    //             // window.open("accounts.php", "_self");
    //         }
    //     });
    // }

    $(document).ready(function() {
        if($('#negative_pos').is(':checked')) {
            $('#negative_positive').click();
            $('#negative_pos').click();
        }
        if($('#negative_positive').is(':checked')) {
            $('#negative_pos').click();
            $('#negative_positive').click();
        }
        // $('#select_account_div').css('display', 'none');
        $('#status_pre_employment').prop('checked', true);
        $('#new_form').css('pointer-events', 'all');
        $('#cancel_form').css('pointer-events', 'all');
        // setTimeout(() => {
        // $("#accounts_select").children().eq(1).attr('selected', 'selected');
        let account = new URL(location.href).searchParams.get("account");
        if(account != null && account != '' && account != 'null') {
            let employee = new URL(location.href).searchParams.get("employee");
            if(employee != undefined && employee != null && employee != '' && employee != 'null') {
                console.log(employee)
                $('#employee_select').val(employee);
                $('#employee_select').trigger('change'); // Notify any JS components that the value changed

            }

            $('#select_account_div').css('display', 'none');
            $('#main_div_main').css('display', 'block');
            $.ajax({
                type: "GET",
                url: "get_location_testinfo.php",
                data: 'account_id_location=' + $("#accounts_select").val(),
                success: function(resultData) {
                    $('#location_select').html(resultData);
                    $('#division_id_send').html(resultData);
                    // window.open("accounts.php", "_self");
                }
            });
        } else if($('#accounts_select').val() != '') {
            // window.open('testinfo.php?account=' + $('#accounts_select').val(), '_self');
        }
        // }, 500);
    })

    // $('#accounts_select').on('change', function() {
    //     $('#select_account_div').css('display', 'none');
    //     $('#main_div_main').css('display', 'block');
    //     $.ajax({
    //         type: "GET",
    //         url: "get_location_testinfo.php",
    //         data: 'account_id_location=' + $(this).val(),
    //         success: function(resultData) {
    //             $('#location_select').html(resultData);
    //             // window.open("accounts.php", "_self");
    //         }
    //     });
    // })
    </script>
    <script>

    $.ajax({
        type: "GET",
        url: "get_location_testinfo.php?account_id_employee=" + $('#accounts_select')
            .val(),
        success: function(resultData) {
            console.log(resultData);
            $('#employee_select').html(resultData);
            let employee = $('#getEmployeeId').val();
            $('#employee_select').val(employee);
            $('#employee_select').trigger('change'); // Notify any JS components that the value changed
            // if(employee != undefined && employee != null && employee != '' && employee != 'null') {

            // $('#employee_select').val(employee);
            // $('#employee_select').trigger('change'); // Notify any JS components that the value changed
            // }
            // window.open("accounts.php", "_self");
        }
    });
    </script>
    <script>

    // $('#location_select').on('change', function() {
    //     console.log("get_location_testinfo.php?account_id_employee=" + $('#accounts_select').val() +
    //         "&location_select=" + $(this)
    //         .val())
    //     $.ajax({
    //         type: "GET",
    //         url: "get_location_testinfo.php?account_id_employee=" + $('#accounts_select').val() +
    //             "&location_select=" + $(this)
    //             .val(),
    //         success: function(resultData) {
    //             console.log(resultData);
    //             $('#employee_select').html(resultData);
    //             // window.open("accounts.php", "_self");
    //         }
    //     });
    // })
    </script>
    <script>

    $('#other_substances').on('click', function() {
        if ($(this).is(":checked"))
            $('#other_substances_input').prop('disabled', false);
        else
            $('#other_substances_input').prop('disabled', true);
    })
    </script>
    <script>


    $('#fee_amount').on('change', function() {
        if ($(this).val() < $(this).attr('min'))
            $(this).val($(this).attr('min'));
    })
    </script>
    <script>

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
    </script>
    <script>

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
    </script>
    <script>

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
    </script>
    <script>

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
                'test_no': $('#getTestNo').val(),
                'invoice_no': $('#invoice_no').val(),
                'requisition_no': $('#requisitionNo').val(),
                'accounts_select': $('#accounts_select').val(),
                'employee_select': $('#employee_select').val(),
                'location_select': $('#location_select').val(),
                'testreason': $('#testreason').val(),
                'collectiondate': $('#collectiondate').val(),
                'date_reported': $('#date_reported').val(),
                'date_mro_recvd': $('#date_mro_recvd').val(),
                'sampletype': $('#sampletype').val(),
                'testdate': $('#getTestDate').val(),
                'testtype': $('#testtype').val(),
                'fee_amount': $('#getFeeAmount').val(),
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
                    if (response.split("id=").length > 0) {
                        alert('Test saved successfully.')
                        // window.open("testinfo.php", "_self");
                        window.open("getTestInfo.php?account=" + $('#accounts_select').val() + "&id=" + response.split("id=")[1], "_self");
                        // getTestInfo.php?account=1338
                    } else {
                        alert('Error occurred while saving test.')
                        // window.open("testinfo.php", "_self");
                    }

                    // alert(response);
                }
            });
            console.log('form_validated', data);
        }
    })
    </script>
    <script>

    $('#testtype').on('change', function() {
        $.ajax({
            type: 'GET',
            url: 'getFeesFromTestType.php?account=' + $('#accounts_select').val() + '&type_id=' + $(
                this).val(),
            success: function(response) {
                console.log(response);
                $('#fee_amount').val(response);
                if(response == '')
                    $('#fee_amount').val('0.00');
            }
        });
    })
    </script>
    <script>

    function validateForm() {
        var error_validateForm = false;
        // if ($('#requisitionNo').val() == '' || $('#requisitionNo').val() == null) {
        //     $('#requisitionNo').focus();
        //     alert("Please enter Requisition No");
        //     return false;
        // }
        if ($('#employee_select').val() == '' || $('#employee_select').val() == null) {
            // $('#employee_select').focus();
            // alert("Please Select Employee");
            $('span[aria-labelledby ="select2-employee_select-container"]').addClass('validation-error')
            // console.log($('span[aria-labelledby ="select2-employee_select-container"]')[0])
            // $('span[aria-labelledby ="select2-employee_select-container"]')[0].style.border = '1px solid red !important';
            console.log("employee_select");
            error_validateForm = true;
            // return false;
        }
        if ($('#location_select').val() == '' || $('#location_select').val() == null) {
            // $('#location_select').focus();
            // alert("Please Select Location");
            $('span[aria-labelledby ="select2-location_select-container"]').addClass('validation-error')
            console.log("location_select");
            error_validateForm = true;
            // return false;
        }
        if ($('#testreason').val() == '' || $('#testreason').val() == null) {
            // $('#testreason').focus();
            $('span[aria-labelledby ="select2-testreason-container"]').addClass('validation-error')
            // alert("Please Select Test Reason");
            console.log("testreason");
            error_validateForm = true;
            // return false;
        }
        if ($('#collectiondate').val() == '' || $('#collectiondate').val() == null) {
            // $('#collectiondate').focus();
            $('#collectiondate').addClass('validation-error')
            // alert("Please Select Collection Date");
            console.log("collectiondate");
            error_validateForm = true;
            // return false;
        }
        if ($('#date_reported').val() == '' || $('#date_reported').val() == null) {
            // $('#date_reported').focus();
            $('#date_reported').addClass('validation-error')
            // alert("Please Select Collection Date");
            console.log("date_reported");
            error_validateForm = true;
            // return false;
        }
        if ($('#date_mro_recvd').val() == '' || $('#date_mro_recvd').val() == null) {
            // $('#date_mro_recvd').focus();
            $('#date_mro_recvd').addClass('validation-error')
            // alert("Please Select Collection Date");
            console.log("date_mro_recvd");
            error_validateForm = true;
            // return false;
        }
        if ($('#getTestDate').val() == '' || $('#getTestDate').val() == null) {
            // $('#testdate').focus();
            $('#getTestDate').addClass('validation-error')
            // alert("Please Select Collection Date");
            console.log("getTestDate");
            error_validateForm = true;
            // return false;
        }
        if ($('#sampletype').val() == '' || $('#sampletype').val() == null) {
            // $('#sampletype').focus();
            $('span[aria-labelledby ="select2-sampletype-container"]').addClass('validation-error')
            // alert("Please Select Sample Type");
            console.log("sampletype");
            error_validateForm = true;
            // return false;
        }
        if ($('#testtype').val() == '' || $('#testtype').val() == null) {
            // $('#testtype').focus();
            // alert("Please Select Test Type");
            $('span[aria-labelledby ="select2-testtype-container"]').addClass('validation-error')
            console.log("testtype");
            error_validateForm = true;
            // return false;
        }
        if ($('#fee_amount').val() == '0.00' || $('#fee_amount').val() == '' || $('#fee_amount').val() == '0') {
            // $('#fee_amount').focus();
            $('#fee_amount').addClass('validation-error')
            // alert("Please Select Fee Amount");
            console.log("fee_amount");
            error_validateForm = true;
            // return false;
        }
        if ($('#selectForm').val() == '' || $('#selectForm').val() == null) {
            // $('#testtype').focus();
            // alert("Please Select Test Type");
            $('span[aria-labelledby ="select2-selectForm-container"]').addClass('validation-error')
            console.log("selectForm");
            error_validateForm = true;
            // return false;
        }
        console.log(!error_validateForm);
        return !error_validateForm;
    }
    </script>
    <script>

    $('#negative_pos').on('click', function() {
        if ($('#negative_pos').is(":checked")) {
            console.log("asdadsa");
        }
    })
    </script>
    <script>

    $('#negative_positive').on('click', function() {
        if ($('#negative_positive').is(":checked")) {
            console.log("asdadsa");
        }
    })


    </script>
</body>

</html>