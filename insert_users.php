<?php

include_once('conn.php');

if (isset($_GET['delete_user_id'])) {
    $userid = $_GET['delete_user_id'];

    $sql = 'DELETE FROM users WHERE `user_id` = ' . $userid;
    // echo $sql;
    if ($conn->query($sql)) {
        echo "<script>alert('The data has been uploaded.');window.open('users.php', '_self');</script>";
        // echo "<script>alert('The data has been uploaded.');</script>";
        // header("location:users.php");
    } else {
        echo "<script>alert('Error occurred while saving data.');window.open('users.php', '_self');</script>";
        // echo 'Error! Try Again';
        mysqli_close($conn);
    }
} else {
    $userid = $_POST['userid'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $password = $_POST['password'];
    $User_Privileges = $_POST['User_Privileges'];
    $admin = (isset($_POST['admin'])) ? $_POST['admin'] : 'F';

    if (isset($_POST['user_id']) && $_POST['user_id'] == '') {
        $sql = 'INSERT INTO `users` (`user_id`,`first_nm`,`last_nm`,`password`,`admin`,`account_id`,`Privileges`) VALUES ("' . $userid . '","' . $fname . '","' . $lname . '","' . $password . '","' . $admin . '",' . $_POST['accountSelect'] . ',"' . $User_Privileges . '")';
        // echo $sql;

        if ($conn->query($sql)) {
            for ($i = 0; $i < count($_POST['locationSelect']); $i++) {
                $sqlLocation = 'INSERT INTO userlocation (user_id,location) VALUES ("' . $userid . '","' . $_POST['locationSelect'][$i] . '");';
                $conn->query($sqlLocation);
            }
            echo "<script>alert('The data has been uploaded.');window.open('users.php', '_self');</script>";
            // header("location:users.php");
        } else {
            echo "<script>alert('Error occurred while saving data.');window.open('users.php', '_self');</script>";
            // echo 'Error! Try Again';
            mysqli_close($conn);
        }
    } else if (isset($_POST['user_id']) && $_POST['user_id'] != '') {
        $sql1 = 'UPDATE users SET `user_id` = "' . $userid . '", `first_nm` = "' . $fname . '", `last_nm` = "' . $lname . '", `password` = "' . $password . '", `admin` = "' . $admin . '", `account_id` = ' . $_POST['accountSelect'] . ', `Privileges` = "' . $User_Privileges . '" WHERE user_id ="' . $_POST['user_id'] . '"';
        // echo $sql1;
        if ($conn->query($sql1)) {
            $sqlDeleteLocation = 'DELETE FROM userlocation WHERE user_id = "' . $userid . '"';
            $conn->query($sqlDeleteLocation);
            for ($i = 0; $i < count($_POST['locationSelect']); $i++) {
                $sqlLocation = 'INSERT INTO userlocation (user_id,location) VALUES ("' . $userid . '","' . $_POST['locationSelect'][$i] . '");';
                $conn->query($sqlLocation);
            }
            echo "<script>alert('The data has been uploaded.');window.open('users.php', '_self');</script>";
            // header("location:users.php");
        } else {
            echo "<script>alert('Error occurred while saving data.');window.open('users.php', '_self');</script>";
            mysqli_close($conn);
        }
    }
}
