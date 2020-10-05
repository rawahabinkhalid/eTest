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
                                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
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
                                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
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
                            $sql = 'SELECT * FROM test LEFT JOIN reasons ON test.reason_id = reasons.reason_id LEFT JOIN sampletype ON test.sample_id = sampletype.sample_id LEFT JOIN testtype ON test.type_id = testtype.type_id LEFT JOIN divisions ON test.division_id = divisions.division_id LEFT JOIN drugform ON test.form_id = drugform.form_id WHERE test_id='.$_GET['id'];
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Test No:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" value="<?php if(isset($row['test_id'])) echo $row['test_id']; ?>"
                                        disabled style="width: 240px; height: 31px; text-align:center">
                                </div>
                                <div class="form-group">
                                    <label>Invoice No:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input disabled type="text" placeholder=""
                                        value="<?php if(isset($row['invoice_id'])) echo $row['invoice_id']; ?>"
                                        style="width: 240px; height: 31px; text-align:center">
                                </div>
                                <div class="form-group">
                                    <label>Emp ID:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select style="width: 240px; height: 31px;" id="employee_select" disabled>
                                        <option value="<?php if(isset($row['emp_id'])) echo $row['emp_id']; ?>">
                                            <?php if(isset($row['emp_id'])) echo $row['emp_id']; ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Test Reason:</label>
                                    &nbsp;
                                    <select style="width: 240px; height: 31px;" id="testreason" disabled>
                                        <option value="<?php if(isset($row['reason_id'])) echo $row['reason_id']; ?>">
                                            <?php if(isset($row['reason_id'])) echo $row['reason_nm']; ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Sample Type:</label>
                                    <select style="width: 240px; height: 31px;" id="sampletype" disabled>
                                        <option value="<?php if(isset($row['sample_id'])) echo $row['sample_id']; ?>">
                                            <?php if(isset($row['sample_id'])) echo $row['sample_nm']; ?></option>

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Test Type:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select style="width: 240px; height: 31px;" id="testtype" disabled>
                                        <option value="<?php if(isset($row['type_id'])) echo $row['type_id']; ?>">
                                            <?php if(isset($row['type_id'])) echo $row['type_nm']; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="record_complete">
                                        <input type="checkbox" id="record_complete" name="" value="">
                                        &emsp;&emsp;This record is complete
                                    </label>
                                </div>
                                <br>
                                <div class="form-group">
                                    <label>Group No:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input disabled style="width: 240px; height: 31px;" type="text"
                                        style="text-align:center">
                                </div>
                                <div class="form-group">
                                    <label>Location:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <select style="width: 240px; height: 31px;" id="location_select" disabled>
                                        <option
                                            value="<?php if(isset($row['division_id'])) echo $row['division_id']; ?>">
                                            <?php if(isset($row['division_id'])) echo $row['division_nm']; ?></option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Collection Date:</label>
                                    <input type="date" disabled placeholder="" style="width: 240px; height: 31px;
                                            text-align:center" id="collectiondate" value="<?php if(isset($row['collection_date'])) 
                                            $date = explode(" ",$row['collection_date']);
                                            echo $date[0]; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Test Date:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="date" disabled placeholder=""
                                        style=" width: 240px; height: 31px; text-align:center" id="testdate" value="<?php if(isset($row['test_date'])) 
                                            $date = explode(" ",$row['test_date']);
                                            echo $date[0]; ?>">
                                </div>
                                <div class="form-group">
                                    <label>Fee Amount:</label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input disabled type="number" min="0" step="1"
                                        value="<?php if(isset($row['amount'])) echo $row['amount']; ?>" id="fee_amount"
                                        placeholder="" style="width: 240px; height: 31px; text-align:center">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-10" style="border: 1px solid black;">
                                <h5><b>Test Result</b></h5>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label for="negative_pos" style="display: inline-block">
                                            <div class="form-group">
                                                <input type="radio" id="negative_pos"
                                                    <?php if(isset($row['result']) && $row['result']=="N") echo "checked"; ?>
                                                    name="negative_positive">
                                                Negative
                                            </div>
                                        </label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Form:</label>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <select style="width: 240px; height: 31px;" disabled id="selectForm">
                                                <option
                                                    value="<?php if(isset($row['form_id'])) echo $row['form_id']; ?>">
                                                    <?php if(isset($row['form_id'])) echo $row['form_nm']; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3" style="display: inline-block">
                                        <label for="negative_positive" style="display: inline-block">
                                            <input type="radio" id="negative_positive" name="negative_positive"
                                                <?php if(isset($row['result']) && $row['result']=="P") echo "checked"; ?>>
                                            Positive for the Following:
                                        </label>
                                    </div>
                                    <?php
                                            
                                        ?>
                                    <div class="col-md-9" style="display: inline-block">
                                        <div class="row">
                                            <?php
                                                    $sql = 'SELECT * FROM drugs';
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {

                                                            $sqlResult = 'SELECT * FROM testresult WHERE test_id = '.$_GET['id'].' AND drug_id='.$row['drug_id'];
                                                            $result1 = $conn->query($sqlResult);
                                                            $rowResult = $result1 -> fetch_assoc();

                                                            echo '<div class="form-group ml-3">';
                                                            echo '    <label for="drug_' . $row['drug_id'] . '"><input type="checkbox" ';
                                                            if(isset($rowResult['result']) && $rowResult['result'] == "P") echo "checked";
                                                            echo' disabled class="positiveForCheckBox" name="" id="drug_' . $row['drug_id'] . '" value="' . $row['drug_id'] . '">';
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
                                                <input type="checkbox" name="" id="other_substances" value=""
                                                    <?php if(isset($row['other']) ) echo "checked"; ?>>
                                                Other Substances:
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="" id="other_substances_input"
                                                value="<?php if(isset($row['other_nm']) ) echo $row['other_nm']; ?>"
                                                style="width: 240px; height: 31px;" disabled>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <br>
                        <button type="button" name="submitPurchase" class="btn ml-1"
                            style="background-color:#E7D7B7; border-radius:12px; width: 100px;"
                            onclick="window.open('testinfo.php', '_self');">New</button>
                        <button type="button" name="" id="" class="btn ml-1"
                            style="background-color:#E7D7B7; border-radius:12px; width: 100px;" onclick="window.open('downloadPDF.php?id=<?php echo $_GET['id']; ?>', '_self'
                            );">Print</button>
                        <button type="button" name="submitSave" id="submitSave" class="btn ml-1"
                            style="background-color:#E7D7B7; border-radius:12px; width: 100px;">Save</button>
                        <button type="button" name="submitDelete" id="submitDelete" class="btn ml-1"
                            style="background-color:#E7D7B7; border-radius:12px; width: 100px;">Delete</button>
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
    <script src="dist/js/adminlte.js"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="dist/js/pages/dashboard3.js"></script>
    <script>
    $(document).ready(function() {
        setTimeout(() => {
            $("#accounts_select").children().eq(1).attr('selected', 'selected');
            $('#select_account_div').css('display', 'none');
            $('#main_div_main').css('display', 'block');
            $.ajax({
                type: "GET",
                url: "get_location_testinfo.php",
                data: 'account_id_location=' + $("#accounts_select").val(),
                success: function(resultData) {
                    // $('#location_select').html(resultData);
                    // window.open("accounts.php", "_self");
                }
            });
        }, 500);
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