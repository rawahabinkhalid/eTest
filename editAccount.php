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
                                <h1 class="m-0 text-dark"><b><u>Account Info.</u></b></h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <!-- <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="landingscreen.php">Home</a></li>
                                    
                                    <li class="breadcrumb-item active">eTest</li>
                                </ol> -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->
                <!-- Main content -->
                <?php
                $sql = 'SELECT * FROM accounts WHERE account_id = "'.$_GET['id'].'"';
                $result = $conn->query($sql);
                if($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                ?>
                <form action="saveAccount.php" method="POST">
                    <div class="content">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-2">Account ID</div>
                                <div class="col-md-2"><input readonly name="account_id"
                                        value="<?php echo $row['account_id']; ?>" class="form-control"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">User ID</div>
                                <div class="col-md-2"><input class="form-control" value="<?php echo $row['user_id']; ?>"
                                        name="userid"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">Password</div>
                                <div class="col-md-2"><input class="form-control"
                                        value="<?php echo $row['password']; ?>" name="password"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">Account Name</div>
                                <div class="col-md-2"><input class="form-control" name="account_nm"
                                        value="<?php echo $row['account_nm']; ?>"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">Account Code</div>
                                <div class="col-md-2"><input class="form-control" name="account_code"
                                        value="<?php echo $row['account_code']; ?>"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-2"><label for="active"><input type="checkbox" id="active"
                                            name="active" value="1"
                                            <?php echo ($row['account_code'] != '0') ? 'checked' : ''; ?>>&emsp;&emsp;Active
                                        Account</label></div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-2">
                                    <button type="button" id="submitSave" name="submitSave" class="btn ml-1"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100%;">Save</button>
                                    <button type="submit" id="submitSaveH" name="submitSaveH" class="btn ml-1"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100%; display: none;">Save</button>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" name="" class="btn ml-1"
                                        style="background-color:#E7D7B7; border-radius:5px; width: 100%;"
                                        onclick="window.open('editAccount.php', '_self');">Reset</button>
                                </div>
                                <!-- <div class="col-md-1">
                                <button type="button" name="" class="btn ml-1"
                                    style="background-color:#E7D7B7; border-radius:5px; width: 100%;"
                                    onclick="window.open('retrievetest.php', '_self');">Back</button>
                            </div> -->
                            </div>
                        </div>
                        <!-- /.container-fluid -->
                    </div>
                </form>
                <!-- /.content -->
                <?php
                }

?>
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
    $('#password').on('keyup', function() {
        if ($('#password').val() != '') {
            $('#confirm_pass_div').css('display', '');
        } else {
            $('#confirm_pass_div').css('display', 'none');
        }
    })

    $('#submitSave').on('click', function() {
        if ($('#password').val() == $('#confirm_password').val()) {
            $('#submitSaveH').click();
        } else {
            alert('Passwords do not match');
        }
    })
    </script>
</body>

</html>