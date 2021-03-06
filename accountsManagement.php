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
        // document.getElementsByClassName('modal-title')[0].innerHTML = 'New User';
    }

    function addClicked_General() {
        document.getElementsByClassName('modal-title')[1].innerHTML = 'New Location';
        // $('#locationindex').val(locations.length);
    }

    function propertiesClicked_General() {
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

    function addLocation() {
        var temp = {};
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


    function addEmployees() {
        var temp = {};
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
                // window.open("accounts.php", "_self");
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
                $('#account_code').val(data.accounts_data.account_code);
                $('#ar_funding_code').val(data.accounts_data.ar_funding_code);

                locations = [];
                fees = [];
                employees = [];
                selected_location = -1;
                selected_fees = -1;
                selected_employees = -1;
                selected_accounts = -1;

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
        // $('#table_accounts > tbody  > tr').each(function(index, tr) {
        //     tr.style.background = 'rgba(0,0,0,.05)';
        // });

        // selected_accounts = id;

        // // alert("#" + id);
        // $('#deleteButton').prop('disabled', false);
        // $('#propertiesButton').prop('disabled', false);
        // $("#" + id).css('background', 'rgba(0,0,0,.35)');
        window.open('editAccount.php?id=' + id, '_self');
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

            <?php include "header.php";?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0 text-dark"><b><u>Account Management</u></b></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="landingscreen.php">Home</a></li>
                                    
                                    <li class="breadcrumb-item active">Account Management</li>
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
                                <div class="col-md-12" style="overflow-y:scroll; overflow-x:scroll;">
                                    <table class="table table-striped" id="table_accounts">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">User ID</th>
                                                <th scope="col">Account Name</th>
                                                <th scope="col">Account Code</th>
                                                <th scope="col">Password</th>
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
                                                        <td>' . $row['user_id'] . '</td>
                                                        <td>' . $row['account_nm'] . '</td>
                                                        <td>' . $row['account_code'] . '</td>
                                                        <td>' . $row['password'] . '</td>
                                                    </tr>';
}
?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- <div class="col-md-1">
                                    <button type="button" name="" class="btn mt-2" data-toggle="modal"
                                        data-target="#myModal" onclick="addClicked();"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100px;">Add</button>
                                    <button type="button" name="" class="btn mt-2" id="deleteButton"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100px;"
                                        onclick="deleteClicked();" disabled>Remove</button>
                                    <button type="button" name="" id="propertiesButton" class="btn mt-2"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100px;"
                                        data-toggle="modal" data-target="#myModal" onclick="propertiesClicked();"
                                        disabled>Properties</button>
                                </div> -->
                            </div>
                        </form>
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
</body>

</html>