<?php
include_once "../conn.php";
if (isset($_POST['submit'])) {
    $pass = $_POST['pass'];
    $username = $_POST['username'];

    $sql = 'SELECT * FROM users WHERE BINARY user_id = "' . $username . '" AND BINARY password = "' . $pass . '"';
    // echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['userid'] = $row['user_id'];
        $_SESSION['usertype'] = ($row['admin'] == 'T') ? 'admin' : 'guest';
        $_SESSION['username'] = $row['first_nm'] . ' ' . $row['last_nm'];

            header("location: ../landingscreen.php");        
    } else {
        // echo '<script>alert("Not found");</script>';
        // header("location: index.php");
        $sql = 'SELECT * FROM accounts WHERE BINARY user_id = "' . $username . '" AND BINARY password = "' . $pass . '"';
        // echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $_SESSION['userid'] = $row['user_id'];
            $_SESSION['accountid'] = $row['account_id'];
            $_SESSION['usertype'] = 'accounts';
            $_SESSION['username'] = $row['account_nm'];

                header("location: ../landingscreen.php");        
        } else {
            echo '<script>alert("Username / Password is not correct");window.open("index.php", "_self");</script>';
            // header("location: index.php");
        }

    }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="shortcut icon" href="images/IE-LOGO.jpg" type="image/x-icon"> -->
    <!-- <link rel="icon" href="images/IE-LOGO.jpg" type="image/x-icon"> -->
    <!--===============================================================================================-->
    <!-- <link rel="icon" type="image/png" href="images/icons/favicon.ico"/> -->
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
</head>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt style="margin-top: -140px">
                    <!-- <img src="images/IE-LOGO.jpg" alt="IMG" style="border-radius: 5px;"> -->
                </div>

                <form class="login100-form" action="" method="POST">
                    <span class="login100-form-title">
                        Login
                    </span>
                    <div class="wrap-input100">
                        <input class="input100" type="text" name="username" placeholder="Username" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-user" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input class="input100" type="password" name="pass" placeholder="Password" required>
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button name='submit' id="submit" type="submit" class="login100-form-btn">Login</button>
                    </div>
                    <br>
                    &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;<a href="loginLSU.php"
                        style="color: blue; text-decoration: underline; text-align: center;"><b>Login with LSU</b></a>

                    <!-- <div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a>
					</div> -->
                    <!--
					<div class="text-center p-t-136">
						<a class="txt2" href="#">
							Create your Account
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div> -->
                </form>
            </div>
        </div>
    </div>




    <!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/tilt/tilt.jquery.min.js"></script>
    <script>
    $('.js-tilt').tilt({
        scale: 1.1
    })
    </script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>

</body>

</html>