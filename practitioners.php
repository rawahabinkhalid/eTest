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
    var selected_practitioner = -1;

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
        document.getElementsByClassName('modal-title')[0].innerHTML = 'Edit Practitioner';
        $.ajax({
            type: "GET",
            url: "getAllData.php?practitioner_id=" + selected_practitioner,
            success: function(resultData) {
                var data = JSON.parse(resultData);
                $('#practitioner_id').val(selected_practitioner);
                $('#practname').val(data.practitioner_nm);
                $('#address').val(data.address);
                $('#city').val(data.city);
                $('#state').val(data.state);
                $('#zip').val(data.zip);
                $('#phone').val(data.phone);
                $('#fax').val(data.fax);
                $('#signature_anchor').prop('href', 'uploads/' + data.sig_file_nm);
                $('#signature_image').prop('src', 'uploads/' + data.sig_file_nm);

            }
        });
    }

    function deleteClicked() {
        $.ajax({
            type: "GET",
            url: "insert_practitioners.php?delete_practitioner_id=" + selected_practitioner,
            success: function(resultData) {
                // console.log(resultData);
                window.open("practitioners.php", "_self");

            }
        });
    }

    function addClicked() {
        document.getElementsByClassName('modal-title')[0].innerHTML = 'New Practitioner';
    }

    function practitionerSelected(id) {
        $('#table_practitioner > tbody  > tr').each(function(index, tr) {
            tr.style.background = 'rgba(0,0,0,.05)';
        });

        selected_practitioner = id;

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
                                <h1 class="m-0 text-dark"><b><u>Practitioner Maintenance</u></b></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="landingscreen.php">Home</a></li>
                                    
                                    <li class="breadcrumb-item active">Practitioner Maintenance</li>
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
                                    <table id="table_practitioner" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Lab Name</th>
                                                <th scope="col">Address</th>
                                                <th scope="col">City</th>
                                                <th scope="col">State</th>
                                                <th scope="col">Zip</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Fax</th>
                                                <th scope="col">Signature File</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
$count = 1;
$sql = 'SELECT * FROM practitioner';
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['practitioner_id'];
    echo '
                                                         <tr id="' . $id . '" onclick="practitionerSelected(' . $id . ');">
                                                            <th scope="row">' . $count++ . '</th>
                                                            <td>' . $row['practitioner_nm'] . '</td>
                                                            <td>' . $row['address'] . '</td>
                                                            <td>' . $row['city'] . '</td>
                                                            <td>' . $row['state'] . '</td>
                                                            <td>' . $row['zip'] . '</td>
                                                            <td>' . $row['phone'] . '</td>
                                                            <td>' . $row['fax'] . '</td>
                                                            <td><a href="uploads/' . $row['sig_file_nm'] . '"
                                                                target="_blank"><img src="uploads/' . $row['sig_file_nm'] . '"
                                                                height=100></a>
                                                            </td>
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
                                    <button type="button" id="deleteButton" name="" class="btn mt-2"
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
            <!-- Add Modal -->
            <div id="myModal" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">New User</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <form action="insert_practitioners.php" method="post" enctype="multipart/form-data">
                            <div class="modal-body" style="display: inline-block">
                                <div class="row">
                                    <input type="hidden" id="practitioner_id" name="practitioner_id">
                                    <div class="col-md-2" style="display: inline-block">Practitioner Name: </div>
                                    <div class="col-md-7" style="display: inline-block"><input class="form-control"
                                            id="practname" name="practname"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2" style="display: inline-block">Address: </div>
                                    <div class="col-md-7" style="display: inline-block"><input class="form-control"
                                            id="address" name="address"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2" style="display: inline-block">City: </div>
                                    <div class="col-md-3" style="display: inline-block"><input class="form-control"
                                            id="city" name="city"></div>
                                    <div class="col-md-1" style="display: inline-block">State: </div>
                                    <div class="col-md-1" style="display: inline-block"><input class="form-control"
                                            id="state" name="state"></div>
                                    <div class="col-md-1" style="display: inline-block">Zip: </div>
                                    <div class="col-md-1" style="display: inline-block"><input class="form-control"
                                            id="zip" name="zip"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2" style="display: inline-block">Phone: </div>
                                    <div class="col-md-7" style="display: inline-block"><input class="form-control"
                                            id="phone" name="phone"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2" style="display: inline-block">Fax: </div>
                                    <div class="col-md-7" style="display: inline-block"><input class="form-control"
                                            id="fax" name="fax"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2" style="display: inline-block"></div>
                                    <div class="col-md-7" style="display: inline-block">
                                        <fieldset style="border: 1px solid lightgray; padding: 10px">
                                            <legend>Signature File</legend>
                                            <a href="" id="signature_anchor" target="_blank"><img src=""
                                                    id="signature_image" height=100></a><br>
                                            File Path: <input class="form-control" type="file" name="signaturefile"><br>

                                        </fieldset>
                                    </div>
                                    <!-- <div class="col-md-2" style="display: inline-block">Location: </div><div class="col-md-7" style="display: inline-block"><select class="form-control"><option value="">Select Location</option></select></div> -->
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default">OK</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Help</button>
                            </div>
                        </form>
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
        $('#table_practitioner').DataTable();
    });
    </script>
</body>

</html>