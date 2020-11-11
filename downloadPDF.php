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

            <?php include "header.php";?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mt-4">
                            <div class="col-md-3"></div>
                            <div class="col-md-5">
                                <h4><b><u>MRO DETERMINATION / VERIFICATION REPORT</u></b></h4>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <?php
                            $sql= 'SELECT * FROM employees';
                            $result = mysqli_query($conn, $sql);
                            $row = mysqli_fetch_assoc($result);
                            echo'
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-2">
                                <p><b>Employee Name/Req#:</b></p>
                            </div>
                            <div class="col-md-2">
                                <p>' .$row['first_nm'].  ' '  .$row['last_nm'].  '</p>
                            </div>
                            
                            <div class="col-md-2">
                                <p><b>Soc. Sec/Employee ID#:</b></p>
                            </div>
                            <div class="col-md-3">
                                <p>' .$row['emp_id']. '</p>
                            </div>';

                            $sql1= 'SELECT * FROM accounts';
                            $result1 = mysqli_query($conn, $sql1);
                            $row1 = mysqli_fetch_assoc($result1);
                            echo'
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-2">
                                <p><b>Employer Name:</b></p>
                            </div>
                            <div class="col-md-8">
                                <p>' .$row1['account_nm']. '</p>
                            </div>';
                            
                            $sql2= 'SELECT * FROM divisions';
                            $result2 = mysqli_query($conn, $sql2);
                            $row2 = mysqli_fetch_assoc($result2);
                            echo'
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-2">
                                <p><b>Employers Address:</b></p>
                            </div>
                            <div class="col-md-8">
                                <p>' .$row2['address']. '</p>
                            </div>';

                            $sql3= 'SELECT * FROM test';
                            $result3 = mysqli_query($conn, $sql3);
                            $row3 = mysqli_fetch_assoc($result3);
                            echo'
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-2">
                                <p><b>Date Of Collection:</b></p>
                            </div>
                            <div class="col-md-8">
                                <p>' .$row3['collection_date']. '</p>
                            </div>';

                            $sql4= 'SELECT * FROM company';
                            $result4 = mysqli_query($conn, $sql4);
                            $row4 = mysqli_fetch_assoc($result4);
                            echo'
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-2">
                                <p><b>Collection Facility:</b></p>
                            </div>
                            <div class="col-md-8">
                                <p>' .$row4['address']. '</p>
                            </div>';
                            
                            $sql5= 'SELECT * FROM lab';
                            $result5 = mysqli_query($conn, $sql5);
                            $row5 = mysqli_fetch_assoc($result5);
                            echo'
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-2">
                                <p><b>Collection Facility:</b></p>
                            </div>
                            <div class="col-md-8">
                                <p>' .$row5['address']. '</p>
                            </div>';

                            $sql6= 'SELECT * FROM testtype';
                            $result6 = mysqli_query($conn, $sql6);
                            $row6 = mysqli_fetch_assoc($result6);
                            echo'
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-2">
                                <p><b>Collection Facility:</b></p>
                            </div>
                            <div class="col-md-8">
                                <p>' .$row6['type_nm']. '</p>
                            </div>';
                            
                            echo'
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-10">
                            <p>The results for the identified specimen are in accordance with the applicable screening confirmation cut-off levels established by the  DHHS/NIDA/SAMHSA mandatory guidelines for the Federal and the State DRUG FREE workplace testing programs.</p>
                            </div>';
                            
                            echo'
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-10">
                            <p><b>My Final Determination/Verification is:</b></p>
                            </div>';

                            echo'
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-2">
                            <p><b><input type="radio" id="" name="" checked> Negative</b></p>
                            </div>
                            <div class="col-md-2">
                            <p><b><input type="radio" id="" name=""> Positive For:</b></p>
                            </div>
                            <div class="col-md-2">
                            <p><b><input type="radio" id="" name=""> Test Cencelled</b></p>
                            </div>
                            <div class="col-md-2">
                            <p><b><input type="radio" id="" name=""> Refusal to test:</b></p>
                            </div>
                            <div class="col-md-2">
                            </div>';

                            echo'
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-2">
                            <p><b><input type="checkbox" id="" name=""> Marijuana</b></p>
                            </div>
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-2">
                            <p><b><input type="checkbox" id="" name=""> Phencyclidine</b></p>
                            </div>
                            <div class="col-md-2">
                            </div>';

                            echo'
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-2">
                            <p><b><input type="checkbox" id="" name=""> Amphetamines</b></p>
                            </div>
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-2">
                            <p><b><input type="checkbox" id="" name=""> Opiates</b></p>
                            </div>
                            <div class="col-md-2">
                            </div>';

                            echo'
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-2">
                            <p><b><input type="checkbox" id="" name=""> Cocaine Metabolite</b></p>
                            </div>
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-2">
                            <p><b><input type="checkbox" id="" name=""> Benzodiazepines</b></p>
                            </div>
                            <div class="col-md-2">
                            </div>';

                             echo'
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-2">
                            <p><b><input type="checkbox" id="" name=""> Methadone</b></p>
                            </div>
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-2">
                            <p><b><input type="checkbox" id="" name=""> Methaqualone</b></p>
                            </div>
                            <div class="col-md-2">
                            </div>';

                             echo'
                            <div class="col-md-4">
                            </div>
                            <div class="col-md-2">
                            <p><b><input type="checkbox" id="" name=""> Barbiturates</b></p>
                            </div>
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-2">
                            <p><b><input type="checkbox" id="" name=""> Propxyphene</b></p>
                            </div>
                            <div class="col-md-2">
                            </div>';
                        ?>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <br><br><br><br>
            </div>
            <!-- Content Wrapper. Contains page content -->

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
    <script src="dist/js/pages/dashboard3.js"></script>
    <!-- DOWNLOAD PDF WORK-->
    <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
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


        var opt = {
            margin: 0.5,
            filename: 'MyFile.pdf',
            html2canvas: {
                scale: 2
            },
        };
        html2pdf().set(opt)
            .from(document.getElementsByClassName('content-header')[0])
            .save().then(() => {
                open('landingscreen.php', '_self').close();
            });

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