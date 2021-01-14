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
                        $sql = 'SELECT * FROM test LEFT JOIN reasons ON test.reason_id = reasons.reason_id LEFT JOIN sampletype ON test.sample_id = sampletype.sample_id LEFT JOIN testtype ON test.type_id = testtype.type_id LEFT JOIN divisions ON test.division_id = divisions.division_id LEFT JOIN drugform ON test.form_id = drugform.form_id JOIN employees ON employees.emp_id = test.emp_id LEFT JOIN invoice ON test.invoice_id = invoice.invoice_id WHERE account_id = ' . $_GET['account'] . ' AND test_id=' . $_GET['id'];
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Test No:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" id="getTestNo" value="<?php if (isset($row['test_id'])) echo $row['test_id']; ?>" disabled style="width: 240px; height: 31px; text-align:center">

                                </div>
                                <div class="form-group">
                                    <label>Requisition No:</label>
                                    <input disabled type="text" placeholder="" value="<?php if (isset($row['req_no'])) echo $row['req_no']; ?>" style="width: 240px; height: 31px; text-align:center">
                                </div>
                                <div class="form-group">
                                    <label>Emp ID:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select style="width: 240px; height: 31px;" id="employee_select" disabled>
                                        <option id="getEmployee" value="<?php if (isset($row['emp_id'])) echo $row['emp_id']; ?>">
                                            <?php if (isset($row['emp_id'])) echo $row['specimen_id'] . ' - ' . $row['first_nm'] . ' ' . $row['last_nm']; ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Test Reason:</label>
                                    &nbsp;&nbsp;&nbsp;
                                    <select style="width: 240px; height: 31px;" id="testreason" disabled>
                                        <option value="<?php if (isset($row['reason_id'])) echo $row['reason_id']; ?>">
                                            <?php if (isset($row['reason_id'])) echo $row['reason_nm']; ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Date Reported:</label>
                                    <input type="date" disabled value="<?php if (isset($row['reported_date'])) echo $row['reported_date']; ?>" name="date_reported" id="date_reported" placeholder="" style="width: 240px; height: 31px; text-align:center">
                                </div>
                                <div class="form-group">
                                    <label>Sample Type:</label>
                                    &nbsp;&nbsp;&nbsp;
                                    <select style="width: 240px; height: 31px;" id="sampletype" disabled>
                                        <option value="<?php if (isset($row['sample_id'])) echo $row['sample_id']; ?>">
                                            <?php if (isset($row['sample_id'])) echo $row['sample_nm']; ?></option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Test Type:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select style="width: 240px; height: 31px;" id="testtype" disabled>
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
                                    <input type="text" id="invoice_no" value="<?php if (isset($row['invoice_id'])) echo $row['invoice_id']; ?>" disabled style="width: 240px; height: 31px; text-align:center">
                                    <input type="hidden" id="invoice_status" value="<?php if (isset($row['paid'])) echo $row['paid']; ?>" disabled style="width: 240px; height: 31px; text-align:center">
                                </div>
                                <div class="form-group">
                                    <label>Group No:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input disabled style="width: 240px; height: 31px;" type="text" style="text-align:center">
                                </div>
                                <div class="form-group">
                                    <label>Location:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select style="width: 240px; height: 31px;" id="location_select" disabled>
                                        <option value="<?php if (isset($row['division_id'])) echo $row['division_id']; ?>">
                                            <?php if (isset($row['division_id'])) echo $row['division_nm']; ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Collection Date:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="date" disabled placeholder="" style="width: 240px; height: 31px;
                                            text-align:center" id="collectiondate" value="<?php if (isset($row['collection_date']))
                                                                                                $date = explode(" ", $row['collection_date']);
                                                                                            echo $date[0]; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Date MRO Copy Recvd:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="date" disabled value="<?php if (isset($row['mro_received_date'])) echo $row['mro_received_date']; ?>" name="date_mro_recvd" id="date_mro_recvd" placeholder="" style="width: 240px; height: 31px; text-align:center">
                                </div>
                                <div class="form-group">
                                    <label>Test Date:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input id="getTestDate" type="date" disabled placeholder="" style=" width: 240px; height: 31px; text-align:center" id="testdate" value="<?php if (isset($row['test_date']))
                                                                                                                                                                                $date = explode(" ", $row['test_date']);
                                                                                                                                                                            echo $date[0]; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Fee Amount:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input id="getFeeAmount" disabled type="number" min="0" step="1" value="<?php if (isset($row['amount'])) echo number_format(floatval($row['amount']), 2); ?>" id="fee_amount" placeholder="" style="width: 240px; height: 31px; text-align:center">
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
                                                <input type="radio" id="negative_pos" <?php if (isset($row['result']) && $row['result'] == "N") echo "checked"; ?> name="negative_positive" disabled>
                                                Negative
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label>Form:</label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <select style="width: 240px; height: 31px;" disabled id="selectForm">
                                                <option value="<?php if (isset($row['form_id'])) echo $row['form_id']; ?>">
                                                    <?php if (isset($row['form_id'])) echo $row['form_nm']; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3" style="display: inline-block">
                                        <label for="negative_positive" style="display: inline-block; text-align: left;">
                                            <input type="radio" id="negative_positive" name="negative_positive" <?php if (isset($row['result']) && $row['result'] == "P") echo "checked"; ?> disabled>
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
                                                    echo ' disabled class="positiveForCheckBox" name="" id="drug_' . $row['drug_id'] . '" value="' . $row['drug_id'] . '">';
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
                                                <input type="checkbox" name="" id="other_substances" value="" <?php if (isset($row['other'])) echo "checked"; ?> disabled>
                                                Other Substances:
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="" id="other_substances_input" value="<?php if (isset($row['other_nm'])) echo $row['other_nm']; ?>" style="width: 240px; height: 31px;" disabled>
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
                        <!-- <button type="button" name="submitSave" id="submitSave" class="btn ml-1"
                            style="background-color:#E7D7B7; border-radius:12px; width: 100px;">Save</button>
                        <button type="button" name="submitDelete" id="submitDelete" class="btn ml-1"
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
        }

        function getDataForInvoice(invoices_data_temp, value) {
            invoices_data = invoices_data_temp;
            const invoice = invoices_data.find(invoice => invoice.invoice_id === $('#invoiceNoBilled').val())
            console.log(invoice)
            $('#invoiceNoBill').val(invoice.invoice_id);
            $('#invoiceDateBill').val(invoice.invoice_date.split(' ')[0]);
            $('#division_id_bill').val(invoice.division_id);
            $('#invoiceReferenceBill').val(invoice.reference_nm);
            $('#invoiceTermsBill').val(invoice.terms);
            $('#invoiceDueDateBill').val(invoice.due_date.split(' ')[0]);
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
            $('#invoiceCheckDateBill').val(invoice.check_date.split(' ')[0]);
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

        $(document).ready(function() {
            // $('#select_account_div').css('display', 'none');
            $('#status_pre_employment').prop('checked', true);
            $('#new_form').css('pointer-events', 'all');
            $('#cancel_form').css('pointer-events', 'all');
            $('#btn_add_send').css('pointer-events', 'all');
            if ($('#invoice_no').val() == '' || $('#invoice_status').val() != 'T')
                $('#btn_add_billing').css('pointer-events', 'all');
            $('#accounts_select').attr('disabled', 'disabled');
            $('#invoiceNoBilled').select2({
                width: '100%'
            });
            // setTimeout(() => {
            // $("#accounts_select").children().eq(1).attr('selected', 'selected');
            let account = new URL(location.href).searchParams.get("account");
            console.log(account)
            if (account != null && account != '' && account != 'null') {
                $('#account_select').val(account);
                $('#account_select').trigger('change');
                // let employee = new URL(location.href).searchParams.get("employee");
                // if(employee != undefined && employee != null && employee != '' && employee != 'null') {
                //     $('#employee_select').val(employee);
                //     $('#employee_select').trigger('change'); 
                // }

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
            } else if ($('#accounts_select').val() != '') {
                // window.open('testinfo.php?account=' + $('#accounts_select').val(), '_self');
            }
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
                    // $('#location_select').html(resultData);
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

        $('#negative_pos').on('click', function() {
            if ($('#negative_pos').is(':checked')) {
                $('.positiveForCheckBox').prop('checked', false);
                $('.positiveForCheckBox').prop('disabled', true);
                $('#selectForm').prop('disabled', false);
            } else {
                $('#selectForm').prop('disabled', true);
                $('#selectForm').val('');
                $('.positiveForCheckBox').prop('disabled', false);
            }
        })

        $('#negative_positive').on('click', function() {
            if ($('#negative_positive').is(':checked')) {
                $('#selectForm').val('');
                $('#selectForm').prop('disabled', true);
                $('.positiveForCheckBox').prop('disabled', false);
            } else {
                $('#selectForm').prop('disabled', false);
                $('.positiveForCheckBox').prop('checked', false);
                $('.positiveForCheckBox').prop('disabled', true);

            }
        })

        $('#submitSave').on('click', function() {
            if (validateForm()) {
                console.log("form validated");
                var data = {
                    'accounts_select': $('#accounts_select').val(),
                    'employee_select': $('#employee_select').val(),
                    'location_select': $('#location_select').val(),
                    'testreason': $('#testreason').val(),
                    'collectiondate': $('#collectiondate').val(),
                    'sampletype': $('#sampletype').val(),
                    'testdate': $('#testdate').val(),
                    'testtype': $('#testtype').val(),
                    'fee_amount': $('#fee_amount').val()
                };
                console.log('form_validated', data);
            }
        })

        function validateForm() {
            if ($('#employee_select').val() == '' || $('#employee_select').val() == null) {
                $('.select2-selection').css('border', '1px solid red !important;')
                // $('#employee_select').focus();
                // alert("Please Select Employee");
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