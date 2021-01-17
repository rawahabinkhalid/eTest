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
    <link rel="stylesheet" href="dist/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="dist/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="dist/css/buttons.dataTables.min.css" />

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
            $('#billing_info_background').hide();
            $('#rowBilledItemDiv').css('pointer-events', 'all');
            $('#rowBilledItemDiv').css('opacity', '1');
            $('#London > .row').show();
            $('#billExistingInvoice').prop('checked', true;)
            document.getElementsByClassName('modal-title')[0].innerHTML = 'Edit Invoice';
            let account = new URL(location.href).searchParams.get("account");
            $.ajax({
                type: "GET",
                url: "getInvoicesForBilling.php?account=" + account,
                success: function(resultData) {
                    var content = '';
                    let obj = JSON.parse(resultData);
                    console.log(obj);
                    for (i = 0; i < obj.length; i++) {
                        content += '<option value="' + obj[i].invoice_id + '">' + obj[i].invoice_id + '</option>';
                    }
                    $('#invoiceNoBilled').html(content);
                    $('#invoiceNoBilled').trigger('change');
                    invoices_data = obj;
                    getDataForInvoice(invoices_data)
                }
            });
            // $.ajax({
            //     type: "GET",
            //     url: "getAllData.php?invoice_id='" + selected_user + "'",
            //     success: function(resultData) {
            //         console.log(resultData);
            //         var data = JSON.parse(resultData);
            //         $('#user_id').val(selected_user);
            //         $('#userid').val(data.user_id);
            //         $('#fname').val(data.first_nm);
            //         $('#lname').val(data.last_nm);
            //         $('#password').val(data.password);
            //         if (data.admin == 'T')
            //             $('#admin').prop("checked", true);
            //         else
            //             $('#admin').prop("checked", false);
            //     }
            // });
        }

        function getDataForInvoice(invoices_data_temp, value) {
            invoices_data = invoices_data_temp;
            const invoice = invoices_data.find(invoice => invoice.invoice_id === selected_user)
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
            if ($('#getFeeAmount').val() != undefined)
                $('#invoiceAmountDueBill').val(parseFloat($('#getFeeAmount').val()) + parseFloat(invoice.amount));
            else
                $('#invoiceAmountDueBill').val(parseFloat(invoice.amount));
            $('#invoiceAmountPaidBill').val(parseFloat(invoice.amount_paid));
            $('#invoiceCheckNoBill').val(invoice.check_no);
            if (invoice.check_date != null)
                $('#invoiceCheckDateBill').val(invoice.check_date.split(' ')[0]);
            $('#invoicePayDateBill').val('');
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
            <?php include "header.php"; ?>

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
                            <div class="row no-print">
                                <div class="col-md-5">
                                    <!-- Date Range&emsp; -->
                                    <!-- <select class="form-control" style="width: calc(100% - 100px); display: inline-block;"><option>Please select Date Range</option> -->
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend" style="display: none">
                                            <div class="input-group-text">
                                                <input type="checkbox" checked style="height: calc(1.25rem); width: calc(1.25rem);" name="daterangeCheck" id="daterangeCheck" aria-label="Checkbox for following text input">
                                            </div>
                                        </div>
                                        <div id="reportrange" style="width: calc(100% - 100px) !important; display: inline-block; background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;">
                                            <i class="fa fa-calendar"></i>&nbsp;
                                            <span></span> <i class="fa fa-caret-down"></i>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" value="<?php echo isset($_POST['daterange'])
                                                                                            ? $_POST['daterange']
                                                                                            : ''; ?>" name="daterange" id="daterange" style="width: calc(100% - 100px); display: inline-block;" />

                                </div>
                                <div class="col-md-4">
                                </div>
                                <div class="col-md-3" style="text-align: right">
                                    <button type="submit" name="filterData" class="btn mt-2" style="background-color:#E7D7B7; border-radius:5px; width: 100px;">Filter</button>
                                    <button type="button" class="btn mt-2" onclick="window.open('bedsReport.php', '_self');" style="background-color:#E7D7B7; border-radius:5px; width: 100px;">Reset</button>
                                </div>
                            </div>

                            <!-- </form> -->
                            <!-- <br><br> -->
                            <?php if (isset($_GET['account'])) { ?>
                                <!-- <form action="" method="POST" class=""> -->
                                <div class="row no-print">
                                    <div class="col-md-12" style="text-align: right">
                                        <button type="submit" name="filterData" class="btn mt-2" style="background-color:#E7D7B7; border-radius:5px; width: 100px;">Retrieve</button>
                                        <!-- <button type="button" id="deleteButton" class="btn mt-2"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100px;"
                                        onclick="$('.buttons-print').click();" disabled>Print</button> -->
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                </div>
                                <div class="row">
                                    <div class="col-md-8" style="overflow-y:scroll; overflow-x:scroll;">
                                        <?php
                                        $account_filter = $_GET['account'];
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
                                        } else {
                                            $sqlDate =
                                                ' AND ((invoice_date  >= "' .
                                                date('Y') .
                                                '-01-01 00:00:00"))';
                                        }
                                        ?>
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
                                            $sql = 'SELECT * FROM invoice WHERE account_id = ' . $_GET['account'] . $sqlDate;
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
                                                $date = strtotime("+" . $row['terms'] . " day", $date);
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
                                        } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-1">
                                        <!-- <button type="button" name="" class="btn mt-2" data-toggle="modal" data-target="#myModal_Billing" style="background-color:#E7D7B7; border-radius:5px; width: 100px;">Add</button> -->
                                        <!-- <button type="button" id="deleteButton" class="btn mt-2"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100px;"
                                        onclick="deleteClicked();" disabled>Remove</button> -->
                                        <button type="button" name="" class="btn mt-2" style="background-color:#E7D7B7; border-radius:5px; width: 100px;" data-toggle="modal" id="propertiesButton" data-target="#myModal_Billing" onclick="propertiesClicked();" disabled>Properties</button>
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
                    <form action="insert_invoice.php" method="post">
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
                                                <div class="col-md-9" style="display: inline-block"><input readonly class="form-control" id="invoice_no" name="invoice_no" value="New Invoice">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3" style="display: inline-block">Invoice Date: </div>
                                                <div class="col-md-9" style="display: inline-block"><input type="date" class="form-control" id="invoice_date" name="invoice_date">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3" style="display: inline-block">Location: </div>
                                                <div class="col-md-9" style="display: inline-block"><select class="form-control" id="location" name="location"></select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3" style="display: inline-block">Reference: </div>
                                                <div class="col-md-9" style="display: inline-block"><input class="form-control" id="reference" name="reference">
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
                                                <div class="col-md-9" style="display: inline-block"><input type="date" class="form-control" id="fname" name="fname">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3" style="display: inline-block"><input type="checkbox">&emsp;Sent: </div>
                                                <div class="col-md-9" style="display: inline-block"><input type="date" class="form-control" id="lname" name="lname">
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
                                                <div class="col-md-7" style="display: inline-block"><input readonly class="form-control" id="amount_due" name="amount_due">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5" style="display: inline-block">Amount Paid: </div>
                                                <div class="col-md-7" style="display: inline-block"><input type="number" min="0" class="form-control" id="amount_paid" name="amount_paid" step="0.05" value="0.00">
                                                </div>
                                            </div>

                                            <br>
                                            <br>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-5" style="display: inline-block">Check No: </div>
                                                <div class="col-md-7" style="display: inline-block"><input class="form-control" id="check_no" name="check_no" type="text" pattern="\d*" maxlength="8">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5" style="display: inline-block">Check Date: </div>
                                                <div class="col-md-7" style="display: inline-block"><input type="date" class="form-control" id="check_date" name="check_date">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5" style="display: inline-block">Pay Date: </div>
                                                <div class="col-md-7" style="display: inline-block"><input type="date" class="form-control" id="pay_date" name="pay_date">
                                                </div>
                                            </div>

                                            <br>
                                            <br>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-3" style="display: inline-block"></div>
                                                <div class="col-md-9" style="display: inline-block"><input class="" type="checkbox" value="T" id="admin" name="admin"><label>Paid in full</label></div>
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
    <script src="dist/js/jquery.dataTables.min.js"></script>
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
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
                'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
            };
            var start = ($('#daterange').val() != '') ? moment($('#daterange').val().split(" - ")[0]) : moment().startOf('year');
            var end = ($('#daterange').val() != '') ? moment($('#daterange').val().split(" - ")[1]) : moment().endOf('year');

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
            if ($(this).is(':checked')) {
                $('#reportrange').css('pointer-events', '');
                $('#reportrange').css('background-color', '#fff');
            } else {
                $('#reportrange').css('pointer-events', 'none');
                $('#reportrange').css('background-color', '#e9ecef');
            }
        })
    </script>

    <script>
        $('.table').DataTable().destroy();
        $('.table').DataTable({
            dom: 'Blfrtip',
            "deferRender": true,
            buttons: [
                'print'
            ]
        });
        $('.buttons-print').addClass('btn mt-2');
        $('.buttons-print').css('border-radius', '5px');
        $('.buttons-print').css('width', '100px');
        $('.buttons-print').css('background', 'none');
        $('.buttons-print').css('background-color', '#E7D7B7');
        $('.buttons-print').css('border', 'none');
        $('.dt-buttons').addClass('float-right');
        $('.dataTables_length').css('width', '50%')
        $('.dataTables_length').css('display', 'inline-block')
        $('#DataTables_Table_0_filter').css('width', '50%')
        $('#DataTables_Table_0_filter').css('display', 'inline-block')
        $('#DataTables_Table_0_filter').css('text-align', 'right')
        $('#deleteButton').prop('disabled', false)
        $(document).ready(function() {
            $('.table').DataTable().destroy();
            $('.table').DataTable({
                dom: 'Blfrtip',
                buttons: [
                    'print'
                ]
            });
            // $('.buttons-print').css('display', 'none');
            $('.buttons-print').addClass('btn mt-2');
            $('.buttons-print').css('background', 'none');
            $('.buttons-print').css('background-color', '#E7D7B7');
            $('.buttons-print').css('border', 'none');
            $('.buttons-print').css('border-radius', '5px');
            $('.buttons-print').css('width', '100px');
            $('.dt-buttons').addClass('float-right');
            $('.dataTables_length').css('width', '50%')
            $('.dataTables_length').css('display', 'inline-block')
            $('#DataTables_Table_0_filter').css('width', '50%')
            $('#DataTables_Table_0_filter').css('display', 'inline-block')
            $('#DataTables_Table_0_filter').css('text-align', 'right')
            $('#deleteButton').prop('disabled', false)
        });
    </script>

</body>

</html>