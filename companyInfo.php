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
                                <h1 class="m-0 text-dark"><b><u>Edit Company Information</u></b></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="landingscreen.php">Home</a></li>
                                    
                                    <li class="breadcrumb-item active">Edit Company Information</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
                <!-- Main content -->
                <form action="insert_companyinfo.php" method="POST" enctype="multipart/form-data">
                    <div class="content">
                        <div class="container-fluid">
                            <?php
$sql = 'SELECT * FROM `company` ORDER BY `company_id` DESC';
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>
                            <div class="row">
                                <div class="col-md-2">Company Name:</div>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="companyname"
                                        value="<?php echo $row['company_nm'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2" style="display: inline-block">Address: </div>
                                <div class="col-md-7" style="display: inline-block"><input class="form-control"
                                        name="address" value="<?php echo $row['address'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2" style="display: inline-block">City: </div>
                                <div class="col-md-3" style="display: inline-block"><input class="form-control"
                                        name="city" value="<?php echo $row['city'] ?>">
                                </div>
                                <div class="col-md-1" style="display: inline-block">State: </div>
                                <div class="col-md-1" style="display: inline-block"><input class="form-control"
                                        name="state" value="<?php echo $row['state'] ?>">
                                </div>
                                <div class="col-md-1" style="display: inline-block">Zip: </div>
                                <div class="col-md-1" style="display: inline-block"><input class="form-control"
                                        name="zip" value="<?php echo $row['zip'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2" style="display: inline-block">Phone: </div>
                                <div class="col-md-7" style="display: inline-block"><input class="form-control"
                                        name="phone" value="<?php echo $row['phone'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2" style="display: inline-block">Fax: </div>
                                <div class="col-md-7" style="display: inline-block"><input class="form-control"
                                        name="fax" value="<?php echo $row['fax'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9" style="display: inline-block">
                                    <fieldset style="border: 1px solid lightgray; padding: 10px">
                                        <legend>Company Logo</legend>
                                        <input type="hidden" name="cmplogo_old"
                                            value="<?php echo $row['logo_file_nm'] ?>">
                                        <a href="uploads/<?php echo $row['logo_file_nm'] ?>" target="_blank"><img
                                                src="uploads/<?php echo $row['logo_file_nm'] ?>" height=100></a><br>
                                        File Path: <input class="form-control" type="file" name="cmplogo"
                                            value="<?php echo $row['logo_file_nm'] ?>"><br>

                                    </fieldset>
                                </div>
                                <!-- <div class="col-md-2" style="display: inline-block">Location: </div><div class="col-md-7" style="display: inline-block"><select class="form-control"><option value="">Select Location</option></select></div> -->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12" style="text-align: right; padding-right: 50px;">
                            <button type="submit" name="" class="btn ml-5"
                                style="background-color:#E7D7B7; border-radius:5px; width: 100px;">OK</button>
                            <button type="submit" name="" class="btn ml-1"
                                style="background-color:#E7D7B7; border-radius:5px; width: 100px;">Cancel</button>
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
</body>

</html>