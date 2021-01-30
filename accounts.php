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

    <link rel="stylesheet" href="dist/css/dataTables.bootstrap4.min.css">
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
        var locations = [];
        var fees = [];
        var employees = [];
        var selected_location = -1;
        var selected_fees = -1;
        var selected_employees = -1;
        var selected_accounts = -1;

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
            // document.getElementsByClassName('modal-title')[0].innerHTML = 'Edit User';
        }

        function addClicked() {
            $('#table_accounts > tbody  > tr').each(function(index, tr) {
                tr.style.background = 'rgba(0,0,0,.05)';
            });

            $('#account_id').val('');
            $('#account_nm').val('');
            $('#is_active').attr('checked', false);
            $('#is_random').attr('checked', false);
            $('#ar_funding_code').val('');
            $('#account_code').val('');

            $('#table_locations').html('');
            $('#table_fees').html('');
            $('#table_employees').html('');

            locations = [];
            selected_location = -1;

            fees = [];
            selected_fees = -1;

            employees = [];
            selected_employees = -1;
            $('#import_employee_btn').prop('hidden', true);

        }

        function addClicked_General() {
            document.getElementsByClassName('modal-title')[1].innerHTML = 'New Location';
            // $('#locationindex').val(locations.length);
        }

        function propertiesClicked_General() {
            $('#division_nm').removeClass('validation-error')
            $('#address').removeClass('validation-error')
            $('#city').removeClass('validation-error')
            $('#state').removeClass('validation-error')
            $('#zip').removeClass('validation-error')
            $('#email').removeClass('validation-error')

            document.getElementsByClassName('modal-title')[1].innerHTML = 'Edit Location';
        }

        function addClicked_Fees() {
            document.getElementsByClassName('modal-title')[2].innerHTML = 'New Account Fee';
        }

        function propertiesClicked_Fees() {
            document.getElementsByClassName('modal-title')[2].innerHTML = 'Edit Account Fee';
        }

        function addClicked_Employees() {
            document.getElementsByClassName('modal-title')[3].innerHTML = 'New Employee';
        }

        function propertiesClicked_Employees() {
            document.getElementsByClassName('modal-title')[3].innerHTML = 'Edit Employee';
        }
    </script>

    <script>
        function openTab(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
            if (cityName == 'Employees') {
                content = '';
                content += '<option value="">Select Location</option>';
                for (i = 0; i < locations.length; i++) {
                    content += '<option value="' + locations[i].division_nm + '">' + locations[i].division_nm + '</option>';
                }
                $('#division_id').html(content);
                // alert("employees");
                if (locations.length <= 0) {
                    $('#btn_add_employees').prop('disabled', true);
                } else {
                    $('#btn_add_employees').prop('disabled', false);
                }
            }
        }

        function validateLocation() {
            var error_validateForm = false;
            // $('#myModal_Employee').modal('hide');
            if ($('#division_nm').val() == '') {
                // $('#specimen_id').focus();
                // alert('Kindly enter Specimen Id.');
                // return;
                $('#division_nm').addClass('validation-error')
                error_validateForm = true;
            }
            if ($('#address').val() == '') {
                $('#address').addClass('validation-error')
                // $('#emp_id').focus();
                // alert('Kindly enter Employee Id.');
                // return;
                error_validateForm = true;
            }
            if ($('#city').val() == '') {
                $('#city').addClass('validation-error')
                // $('#first_nm').focus();
                // alert('Kindly enter First Name.');
                // return;
                error_validateForm = true;
            }
            if ($('#state').val() == '') {
                $('#state').addClass('validation-error')
                // $('#last_nm').focus();
                // alert('Kindly enter Last Name.');
                // return;
                error_validateForm = true;
            }
            console.log($('#zip').val().length)
            if ($('#zip').val() == '') {
                $('#zip').addClass('validation-error')
                // $('#division_id').focus();
                // alert('Kindly select Location.');
                // return;
                error_validateForm = true;
            } else if ($('#zip').val().length == 5 || $('#zip').val().length == 10) {
                $('#zip').removeClass('validation-error')
                error_validateForm = false;
            } else {
                $('#zip').addClass('validation-error')
                // $('#division_id').focus();
                // alert('Kindly select Location.');
                // return;
                error_validateForm = true;
            }
            if ($('#email').val() == '' || !/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test($('#email').val())) {
                $('#email').addClass('validation-error')
                // $('#accounts_select').focus();
                // alert('Kindly select Account.');
                // return;
                error_validateForm = true;
            }
            return error_validateForm;
        }

        function addLocation() {
            var temp = {};
            if (validateLocation()) {
                $('#addLocation').attr('data-dismiss', '');
                return;
            } else {
                $('#addLocation').attr('data-dismiss', 'modal');
            }
            temp['division_nm'] = $('#division_nm').val();
            temp['address'] = $('#address').val();
            temp['city'] = $('#city').val();
            temp['state'] = $('#state').val();
            temp['zip'] = $('#zip').val();
            temp['phone'] = $('#phone').val();
            temp['fax'] = $('#fax').val();
            temp['contact'] = $('#contact').val();
            temp['email'] = $('#email').val();
            temp['comments'] = $('#comments').html();

            if ($('#locationindex').val() == '')
                locations.push(temp);
            else {
                locations[selected_location] = temp;
            }

            $('#division_nm').val('');
            $('#address').val('');
            $('#city').val('');
            $('#state').val('');
            $('#zip').val('');
            $('#phone').val('');
            $('#fax').val('');
            $('#contact').val('');
            $('#email').val('');
            $('#comments').html('');

            refreshLocationTable();
            console.log(locations);

            selected_location = -1;
        }

        function refreshLocationTable() {
            content = '';
            for (i = 0; i < locations.length; i++) {
                content += '<tr id="locations_' + i + '" onclick="selectedLocation(' + i + ');">';
                content += '<td>';
                content += (i + 1);
                content += '</td>';
                content += '<td>';
                content += locations[i].division_nm;
                content += '</td>';
                content += '</tr>';
            }

            $('#table_locations').html(content);


            $('#btn_delete_location').prop('disabled', true);
            $('#btn_properties_location').prop('disabled', true);
        }

        function selectedLocation(i) {

            $('#table_locations > tr').each(function(index, tr) {
                tr.style.background = 'rgba(0,0,0,.05)';
            });

            selected_location = i;
            $('#btn_delete_location').prop('disabled', false);
            $('#btn_properties_location').prop('disabled', false);
            $("#locations_" + i).css('background', 'rgba(0,0,0,.35)');
        }

        function removeClicked_General() {
            var value = locations[selected_location].division_nm;

            locations = locations.filter(function(item) {
                console.log(item);
                return item.division_nm !== value
            })

            $('#btn_delete_location').prop('disabled', true);
            $('#btn_properties_location').prop('disabled', true);

            refreshLocationTable();
            selected_location = -1;
        }

        function propertiesClicked_General() {
            $('#division_nm').removeClass('validation-error')
            $('#address').removeClass('validation-error')
            $('#city').removeClass('validation-error')
            $('#state').removeClass('validation-error')
            $('#zip').removeClass('validation-error')
            $('#email').removeClass('validation-error')


            $('#locationindex').val(selected_location);
            $('#division_nm').val(locations[selected_location].division_nm);
            $('#address').val(locations[selected_location].address);
            $('#city').val(locations[selected_location].city);
            $('#state').val(locations[selected_location].state);
            $('#zip').val(locations[selected_location].zip);
            $('#phone').val(locations[selected_location].phone);
            $('#fax').val(locations[selected_location].fax);
            $('#contact').val(locations[selected_location].contact);
            $('#email').val(locations[selected_location].email);
            $('#comments').val(locations[selected_location].comments);
        }


        function addFees() {
            var temp = {};
            temp['type_id'] = $('#type_id').val();
            temp['amount'] = $('#amount').val();

            if ($('#feesindex').val() == '')
                fees.push(temp);
            else {
                fees[selected_fees] = temp;
            }

            $('#type_id').val('');
            $('#amount').val('');
            $('#feesindex').val('');

            refreshFeesTable();

            selected_fees = -1;
        }

        function refreshFeesTable() {
            content = '';
            for (i = 0; i < fees.length; i++) {
                content += '<tr id="fees_' + i + '" onclick="selectedFees(' + i + ');">';
                content += '<td>';
                content += (i + 1);
                content += '</td>';
                content += '<td>';
                content += document.querySelector('#type_id option[value="' + fees[i].type_id + '"]').innerHTML;
                content += '</td>';
                content += '<td>';
                content += fees[i].amount;
                content += '</td>';
                content += '</tr>';
            }

            $('#feesindex').val('');

            $('#table_fees').html(content);

            $('#btn_delete_fee').prop('disabled', true);
            $('#btn_properties_fee').prop('disabled', true);
        }

        function selectedFees(i) {

            $('#table_fees > tr').each(function(index, tr) {
                tr.style.background = 'rgba(0,0,0,.05)';
            });

            selected_fees = i;
            $('#btn_delete_fee').prop('disabled', false);
            $('#btn_properties_fee').prop('disabled', false);
            $("#fees_" + i).css('background', 'rgba(0,0,0,.35)');
        }

        function removeClicked_Fees() {
            var value = fees[selected_fees].type_id;
            var amount = fees[selected_fees].amount;

            fees = fees.filter(function(item) {
                console.log(item);
                console.log(item.type_id !== value);
                console.log(item.amount !== amount);
                console.log(item.type_id !== value || item.amount !== amount);
                return item.type_id !== value || item.amount !== amount
            })

            $('#btn_delete_fee').prop('disabled', true);
            $('#btn_properties_fee').prop('disabled', true);
            console.log(fees);

            refreshFeesTable();
            selected_fees = -1;
            $('#feesindex').val('');

        }

        function propertiesClicked_Fees() {
            $('#feesindex').val(selected_fees);
            $('#type_id').val(fees[selected_fees].type_id);
            $('#amount').val(fees[selected_fees].amount);
        }


        function addEmployees_Account() {
            error_validateForm = validateEmployee();
            if (!error_validateForm) {
                var temp = {};
                temp['specimen_id'] = $('#specimen_id').val();
                temp['emp_id'] = $('#emp_id').val();
                temp['first_nm'] = $('#first_nm').val();
                temp['last_nm'] = $('#last_nm').val();
                temp['division_id'] = $('#division_id').val();
                temp['status'] = '';
                if ($('#status_pre_employment').is(':checked'))
                    temp['status'] = 'P';
                else if ($('#status_active').is(':checked'))
                    temp['status'] = 'A';
                else if ($('#status_terminated').is(':checked'))
                    temp['status'] = 'T';

                if ($('#employeesindex').val() == '')
                    employees.push(temp);
                else {
                    employees[selected_employees] = temp;
                }

                $('#emp_id').val('');
                $('#first_nm').val('');
                $('#last_nm').val('');
                $('#division_id').val('');
                $('#status_pre_employment').prop('checked', false);
                $('#status_active').prop('checked', false);
                $('#status_terminated').prop('checked', false);
                $('#employeesindex').val('');

                refreshEmployeesTable();

                selected_employees = -1;
            }

        }

        function refreshEmployeesTable() {
            content = '';
            for (i = 0; i < employees.length; i++) {
                content += '<tr id="employee_' + i + '" onclick="selectedEmployees(' + i + ');">';
                content += '<td>';
                content += (i + 1);
                content += '</td>';
                content += '<td>' + employees[i].emp_id + '</td>';
                content += '<td>' + employees[i].division_id + '</td>';
                // content += '<td>';
                // locations.find(item => {
                //     return item.restaurant.food == 'chicken'
                // })
                // content += '</td>';
                content += '<td>' + employees[i].first_nm + '</td>';
                content += '<td>' + employees[i].last_nm + '</td>';
                content += '<td>';
                if (employees[i].status == 'P')
                    content += 'Pre-Employment';
                if (employees[i].status == 'A')
                    content += 'Active';
                if (employees[i].status == 'T')
                    content += 'Terminated';
                content += '</td>';
                content += '</tr>';
            }

            $('#employeesindex').val('');

            $('#table_employees').html(content);

            $('#btn_delete_employees').prop('disabled', true);
            $('#btn_properties_employees').prop('disabled', true);
        }

        function selectedEmployees(i) {
            $('#table_employees > tr').each(function(index, tr) {
                tr.style.background = 'rgba(0,0,0,.05)';
            });

            selected_employees = i;
            $('#btn_delete_employees').prop('disabled', false);
            $('#btn_properties_employees').prop('disabled', false);
            $("#employee_" + i).css('background', 'rgba(0,0,0,.35)');
        }

        function removeClicked_Employees() {
            var value = employees[selected_employees].emp_id;
            var division_id = employees[selected_employees].division_id;

            employees = employees.filter(function(item) {
                return item.emp_id !== value || item.division_id !== division_id
            })

            $('#btn_delete_employees').prop('disabled', true);
            $('#btn_properties_employees').prop('disabled', true);
            console.log(fees);

            refreshEmployeesTable();
            selected_employees = -1;
            $('#employeesindex').val('');

        }

        function propertiesClicked_Employees() {
            $('#employeesindex').val(selected_employees);

            $('#emp_id').val(employees[selected_employees].emp_id);
            $('#first_nm').val(employees[selected_employees].first_nm);
            $('#last_nm').val(employees[selected_employees].last_nm);
            $('#division_id').val(employees[selected_employees].division_id);
            if (employees[selected_employees].status == 'P')
                $('#status_pre_employment').prop('checked', true);
            if (employees[selected_employees].status == 'A')
                $('#status_active').prop('checked', true);
            if (employees[selected_employees].status == 'T')
                $('#status_terminated').prop('checked', true);
        }

        function saveAccount() {
            accountsData = {
                'account_id': $('#account_id').val(),
                'account_nm': $('#account_nm').val(),
                'active_flg': ($('#is_active').is(':checked')) ? 'T' : 'F',
                'random_flg': ($('#is_random').is(':checked')) ? 'T' : 'F',
                'account_code': $('#account_code').val(),
                'ar_funding_code': $('#ar_funding_code').val(),
                'locations': locations,
                'fees': fees,
                'employees': employees
            };
            console.log('accountsData', accountsData);
            console.log('accountsData=' + JSON.stringify(accountsData))
            $.ajax({
                type: "POST",
                url: "insert_account.php",
                data: 'accountsData=' + JSON.stringify(accountsData),
                success: function(resultData) {
                    console.log(resultData);
                    alert(resultData);
                    // windo
                    window.open("accounts.php", "_self");
                }
            });
        }


        function deleteClicked() {
            $.ajax({
                type: "GET",
                url: "insert_account.php?delete_account_id=" + selected_accounts,
                success: function(resultData) {
                    // console.log(resultData);
                    window.open("accounts.php", "_self");

                }
            });
        }

        function propertiesClicked() {
            document.getElementsByClassName('modal-title')[0].innerHTML = 'Edit Practitioner';
            $('#import_employee_btn').prop('hidden', false);

            $.ajax({
                type: "GET",
                url: "getAllData.php?account_id=" + selected_accounts,
                success: function(resultData) {
                    console.log(resultData);
                    var data = JSON.parse(resultData);
                    console.log(data);

                    $('#locationindex').val('');
                    $('#feesindex').val('');
                    $('#employeesindex').val('');
                    $('#account_id').val(data.accounts_data.account_id);
                    $('#account_nm').val(data.accounts_data.account_nm);
                    if(data.accounts_data.active_flg == 'T')
                        $('#is_active').prop('checked', true);
                    else
                        $('#is_active').prop('checked', false);
                    if(data.accounts_data.random_flg == 'T')
                        $('#is_random').prop('checked', true);
                    else
                        $('#is_random').prop('checked', false);
                    $('#account_code').val(data.accounts_data.account_code);
                    $('#ar_funding_code').val(data.accounts_data.ar_funding_code);

                    locations = [];
                    fees = [];
                    employees = [];
                    selected_location = -1;
                    selected_fees = -1;
                    selected_employees = -1;
                    // selected_accounts = -1;

                    for (i = 0; i < data.accounts_divisions.length; i++) {
                        var temp = {};
                        temp['division_nm'] = data.accounts_divisions[i].division_nm;
                        temp['address'] = data.accounts_divisions[i].address;
                        temp['city'] = data.accounts_divisions[i].city;
                        temp['state'] = data.accounts_divisions[i].state;
                        temp['zip'] = data.accounts_divisions[i].zip;
                        temp['phone'] = data.accounts_divisions[i].phone;
                        temp['fax'] = data.accounts_divisions[i].fax;
                        temp['contact'] = data.accounts_divisions[i].contact;
                        temp['email'] = data.accounts_divisions[i].email;
                        temp['comments'] = data.accounts_divisions[i].comments;

                        locations.push(temp);
                        console.log(locations);
                    }
                    refreshLocationTable();

                    for (i = 0; i < data.accounts_fees.length; i++) {
                        var temp = {};
                        temp['type_id'] = data.accounts_fees[i].type_id;
                        temp['amount'] = data.accounts_fees[i].amount;

                        fees.push(temp);
                        console.log(fees);
                    }
                    refreshFeesTable();
                    if (data.accounts_employees.length > 0) {
                        $('#export_employee_btn').prop('hidden', false);
                        $('#clear_employee_btn').prop('hidden', false);
                    }

                    for (i = 0; i < data.accounts_employees.length; i++) {
                        var temp = {};
                        temp['emp_id'] = data.accounts_employees[i].emp_id;
                        temp['first_nm'] = data.accounts_employees[i].first_nm;
                        temp['last_nm'] = data.accounts_employees[i].last_nm;
                        temp['division_id'] = data.accounts_employees[i].division_id;
                        temp['status'] = data.accounts_employees[i].status;

                        employees.push(temp);
                        console.log(employees);
                    }
                    refreshEmployeesTable();
                }
            });
        }

        function accountSelected(id) {
            $('#table_accounts > tbody  > tr').each(function(index, tr) {
                tr.style.background = 'rgba(0,0,0,.05)';
            });

            selected_accounts = id;

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

    <!-- <body class="hold-transition sidebar-mini"> -->
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
                                <h1 class="m-0 text-dark"><b><u>Account Maintenance</u></b></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="landingscreen.php">Home</a></li>

                                    <li class="breadcrumb-item active">Account Maintenance</li>
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
                                    <table class="table table-striped" id="table_accounts">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Account Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 1;
                                            $sql = 'SELECT * FROM accounts';
                                            $result = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $id = $row['account_id'];
                                                echo '
                                                    <tr id="' . $id . '" onclick = "accountSelected(' . $id . ');">
                                                        <th scope="row">' . $count++ . '</th>
                                                        <td>' . $row['account_nm'] . '</td>
                                                    </tr>';
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" name="" class="btn mt-2" data-toggle="modal" data-target="#myModal" onclick="addClicked();" style="background-color:#E7D7B7; border-radius:5px; width: 100px;">Add</button>
                                    <button type="button" name="" class="btn mt-2" id="deleteButton" style="background-color:#E7D7B7; border-radius:5px; width: 100px;" onclick="deleteClicked();" disabled>Remove</button>
                                    <button type="button" name="" id="propertiesButton" class="btn mt-2" style="background-color:#E7D7B7; border-radius:5px; width: 100px;" data-toggle="modal" data-target="#myModal" onclick="propertiesClicked();" disabled>Properties</button>
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
            <div id="myModal" class="modal fade" data-backdrop="static" role="dialog" style="z-index:1400;">
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Account Properties</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body" style="display: inline-block">

                            <div class="tab">
                                <button class="tablinks active" onclick="openTab(event, 'General')">General</button>
                                <button class="tablinks" onclick="openTab(event, 'Fees')">Fees</button>
                                <button class="tablinks" onclick="openTab(event, 'Employees')">Employees</button>
                            </div>
                            <br><br>

                            <div id="General" class="tabcontent" style="display: block;">
                                <br>
                                <div class="row">
                                    <div class="col-3">Account Name: </div>
                                    <div class="col-9">
                                        <input type="hidden" id="account_id" name="account_id">
                                        <input class="form-control" id="account_nm" name="account_nm">
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-3">AR Funding Code: </div>
                                    <div class="col-4"><input class="form-control" id="ar_funding_code" name="account_code">
                                    </div>
                                    <div class="col-1">Code: </div>
                                    <div class="col-4"><input class="form-control" id="account_code" name="account_code">
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-2"><label for="is_active"><input type="checkbox" id="is_active" name="is_active" value="T">&emsp;Active</label>
                                    </div>
                                    <div class="col-2"><label for="is_random"><input type="checkbox" id="is_random" name="is_random" value="T">&emsp;Random</label>
                                    </div>
                                </div>
                                <br>
                                <div class="row" style=" height: 200px; overflow: auto;">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Location</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_locations">
                                            <!-- <tr>
                                                <th scope="row">1</th>
                                                <td>Location 1</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Location 2</td>
                                            </tr> -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal_General" onclick="addClicked_General();">Add</button>
                                    <button type="button" class="btn btn-default" id="btn_delete_location" onclick="removeClicked_General();" disabled>Remove</button>
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal_General" onclick="propertiesClicked_General();" id="btn_properties_location" disabled>Properties</button>
                                </div>


                            </div>

                            <div id="Fees" class="tabcontent">
                                <br>
                                <div class="row" style=" height: 300px; overflow: auto;">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Test Type</th>
                                                <th scope="col">Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_fees">
                                            <!-- <tr>
                                                <th scope="row">1</th>
                                                <td>Test Type 1</td>
                                                <td>100.00</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Test Type 2</td>
                                                <td>100.00</td>
                                            </tr> -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal_Fees" onclick="addClicked_Fees();">Add</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal" id="btn_delete_fee" onclick="removeClicked_Fees();" disabled>Remove</button>
                                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal_Fees" id="btn_properties_fee" onclick="propertiesClicked_Fees();" disabled>Properties</button>
                                </div>

                            </div>

                            <div id="Employees" class="tabcontent">
                                <br>
                                <div class="row" style=" height: 300px; overflow: auto;">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Employee ID</th>
                                                <th scope="col">Location</th>
                                                <th scope="col">First / Req No.</th>
                                                <th scope="col">Last Name</th>
                                                <th scope="col">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table_employees">
                                            <!-- <tr>
                                                <th scope="row">1</th>
                                                <td>4545646</td>
                                                <td>Location 1</td>
                                                <td>ABC</td>
                                                <td>User 1</td>
                                                <td>Active</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>8798456</td>
                                                <td>Location 2</td>
                                                <td>XYZ</td>
                                                <td>User 2</td>
                                                <td>Terminated</td>
                                            </tr> -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer" style="justify-content: flex-start;">
                                    <div class="row" style="width: 100%">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-default" id="clear_employee_btn" data-toggle="modal" data-target="#myModal_Employee_Clear" hidden>Clear All</button>
                                            <button type="button" class="btn btn-default" id="import_employee_btn" data-toggle="modal" data-target="#myModal_Employee_Import" hidden>Import</button>
                                            <button type="button" class="btn btn-default" id="export_employee_btn" onclick="exportEmployees();" hidden>Export</button>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal_Employee1" onclick="addClicked_Employees();" id="btn_add_employees">Add</button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal" id="btn_delete_employees" onclick="removeClicked_Employees();" disabled>Remove</button>
                                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal_Employee1" id="btn_properties_employees" onclick="propertiesClicked_Employees();" disabled>Properties</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="saveAccount();">OK</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Help</button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Modal -->
            <div id="myModal_General" class="modal fade" role="dialog" style="z-index:9996;">
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body" style="display: inline-block">
                            <div class="row">
                                <div class="col-md-2" style="display: inline-block">Location Name: </div>
                                <div class="col-md-8" style="display: inline-block">
                                    <input type="hidden" id="locationindex" name="locationindex" value="">
                                    <input class="form-control" id="division_nm" name="division_nm">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2" style="display: inline-block">Address: </div>
                                <div class="col-md-8" style="display: inline-block"><input class="form-control" id="address" name="address"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2" style="display: inline-block">City: </div>
                                <div class="col-md-3" style="display: inline-block"><input class="form-control" id="city" name="city"></div>
                                <div class="col-md-1" style="display: inline-block">State: </div>
                                <div class="col-md-1" style="display: inline-block"><input class="form-control" id="state" name="state"></div>
                                <div class="col-md-1" style="display: inline-block">Zip: </div>
                                <div class="col-md-2" style="display: inline-block"><input class="form-control" id="zip" name="zip" minlength="5"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2" style="display: inline-block">Phone: </div>
                                <div class="col-md-3" style="display: inline-block"><input class="form-control" id="phone" name="phone"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2" style="display: inline-block">Fax: </div>
                                <div class="col-md-3" style="display: inline-block"><input class="form-control" id="fax" name="fax"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2" style="display: inline-block">Contact: </div>
                                <div class="col-md-8" style="display: inline-block"><input class="form-control" id="contact" name="contact"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2" style="display: inline-block">Email Address: </div>
                                <div class="col-md-8" style="display: inline-block"><input class="form-control" id="email" name="email"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2" style="display: inline-block">Comments: </div>
                                <div class="col-md-8" style="display: inline-block"><textarea class="form-control" id="comments" name="comments"></textarea></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" id="addLocation" onclick="addLocation();">OK</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="selected_location = -1;refreshLocationTable()">Close</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Help</button>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Modal -->
            <div id="myModal_Fees" class="modal fade" role="dialog" style="z-index:9997;">
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body" style="display: inline-block">
                            <div class="row">
                                <div class="col-md-2" style="display: inline-block">Test Type: </div>
                                <div class="col-md-7" style="display: inline-block">
                                    <input type="hidden" id="feesindex" name="feesindex" value="">
                                    <select class="form-control" id="type_id" name="type_id">
                                        <option value="">Select Test Type</option>
                                        <?php
                                        $sql = 'SELECT * FROM testtype';
                                        $result = mysqli_query($conn, $sql);
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . $row['type_id'] . '">' . $row['type_nm'] . '</option>';
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2" style="display: inline-block">Amount: </div>
                                <div class="col-md-7" style="display: inline-block"><input id="amount" name="amount" type="number" min="0" step="0.01" class="form-control"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="addFees();">OK</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="selected_fees = -1;">Close</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Help</button>
                        </div>
                        <!-- <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Help</button>
                        </div> -->
                    </div>

                </div>
            </div>


            <!-- Modal -->
            <div id="myModal_Employee1" class="modal fade" role="dialog" style="z-index:9997;">
                <!-- <div id="myModal_Employee" class="modal fade" role="dialog" style="z-index:9998;"> -->
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title"></h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body" style="display: inline-block">
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
                                        <option value="">Select Location</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2" style="display: inline-block"></div>
                                <div class="col-md-7" style="display: inline-block">
                                    <fieldset style="border: 1px solid lightgray; padding: 10px">
                                        <legend>Status</legend>
                                        <label for="status_pre_employment"><input type="radio" id="status_pre_employment" name="status">&emsp;Pre-Employment</label><br>
                                        <label for="status_active"><input type="radio" id="status_active" name="status">&emsp;Active</label><br>
                                        <label for="status_terminated"><input type="radio" id="status_terminated" name="status">&emsp;Terminated</label><br>
                                    </fieldset>
                                </div>
                                <!-- <div class="col-md-2" style="display: inline-block">Location: </div><div class="col-md-7" style="display: inline-block"><select class="form-control"><option value="">Select Location</option></select></div> -->
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="addEmployees_Account();">OK</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="selected_fees = -1;">Close</button>
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
            <!-- <footer class="main-footer">
                <strong>Copyright &copy; 2020-21 <a href="https://matz.group/">MATZ Solutions Pvt Ltd</a>.</strong>
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
    <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <!-- AdminLTE -->
    <!-- <script src="dist/js/jquery-3.5.1.js"></script> -->
    <!-- <script src="dist/js/jquery.dataTables.min.js"></script> -->
    <!-- <script src="dist/js/dataTables.bootstrap4.min.js"></script> -->
    <!-- <script src="dist/js/adminlte.js"></script> -->

    <!-- OPTIONAL SCRIPTS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="dist/js/pages/dashboard3.js"></script>
    <script src="dist/js/jquery.dataTables.min.js"></script>
    <script src="dist/js/dataTables.bootstrap4.min.js"></script>
    <script src="dist/js/dataTables.buttons.min.js"></script>
    <script src="dist/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#table_accounts').DataTable();
        });
        $('#emp_id').on('change', function() {
            var str = $(this).val();
            regexp = /^(?!000|666)[0-8][0-9]{2}-(?!00)[0-9]{2}-(?!  0000)[0-9]{4}$/;

            // var strFilter = /^[0-3][0-9]{7}$/;

            if (regexp.test(str)) {
                console.log('right');
            } else {
                alert('Please enter correct SSN Number');
                $('#emp_id').val('');
            }
        })
    </script>
    <script>
        $('#division_nm').on('change', function() {
            $('#division_nm').removeClass('validation-error')
        });
        $('#address').on('change', function() {
            $('#address').removeClass('validation-error')
        });
        $('#city').on('change', function() {
            $('#city').removeClass('validation-error')
        });
        $('#state').on('change', function() {
            $('#state').removeClass('validation-error')
        });
        $('#zip').on('change', function() {
            $('#zip').removeClass('validation-error')
        });
        $('#email').on('change', function() {
            $('#email').removeClass('validation-error')
        });
    </script>
    <script>
        $().ready(() => {
            var maskOptions = {
                placeholder: "_____-____",
                onKeyPress: function(cep, e, field, options) {
                    // Use an optional digit (9) at the end to trigger the change
                    var masks = ["00000-0009", "00009"],
                        digits = cep.replace(/[^0-9]/g, "").length,
                        // When you receive a value for the optional parameter, then you need to swap
                        // to the new format
                        mask = digits >= 5 ? masks[0] : masks[1];
                    console.log('triggered')
                    $("#zip").mask(mask, options);
                }
            };

            $("#zip").mask("00009", maskOptions);
        });
    </script>
</body>

</html>