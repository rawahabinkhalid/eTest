<?php

include_once('conn.php');

if(isset($_GET['delete_user_id'])) {
    $userid =$_GET['delete_user_id'];

    $sql = 'DELETE FROM users WHERE `user_id` = ' . $userid;
    echo $sql;
    if($conn->query($sql))
    {
        echo "<script>alert('The data has been uploaded.');window.open('users.php', '_self');</script>";
        // echo "<script>alert('The data has been uploaded.');</script>";
        header("location:users.php");
    }
    else
    {
        echo "<script>alert('Error occurred while saving data.');window.open('users.php', '_self');</script>";
        // echo 'Error! Try Again';
        mysqli_close($conn);
    }
} else {
    $userid =$_POST['userid'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $password = $_POST['password'];
    $admin = (isset($_POST['admin'])) ? $_POST['admin'] : 'F';

    if(isset($_POST['user_id']) && $_POST['user_id'] == ''){
        $sql = 'INSERT INTO `users` (`user_id`,`first_nm`,`last_nm`,`password`,`admin`,`account_id`) VALUES ("'.$userid.'","'.$fname.'","'.$lname.'","'.$password.'","'.$admin.'",'.$_POST['accountSelect'].')';
        // echo $sql;

        if($conn->query($sql))
        {
            for($i=0; $i<count($_POST['locationSelect']); $i++){
                $sqlLocation = 'INSERT INTO userlocation (user_id,location) VALUES ("'.$userid.'","'.$_POST['locationSelect'][$i].'");';
                $conn->query($sqlLocation);
            }
            echo "<script>alert('The data has been uploaded.');window.open('users.php', '_self');</script>";
            // header("location:users.php");
        }
        else
        {
            echo "<script>alert('Error occurred while saving data.');window.open('users.php', '_self');</script>";
            // echo 'Error! Try Again';
            mysqli_close($conn);
        }
    } else if(isset($_POST['user_id']) && $_POST['user_id'] != ''){
        $sql1 = 'UPDATE users SET `user_id` = "'.$userid.'", `first_nm` = "'.$fname.'", `last_nm` = "'.$lname.'", `password` = "'.$password.'", `admin` = "'.$admin.'", `account_id` = '.$_POST['accountSelect'].' WHERE user_id ="'. $_POST['user_id'].'"';
        // echo $sql;
        if($conn->query($sql1))
        {
            echo "<script>alert('The data has been uploaded.');window.open('users.php', '_self');</script>";
            // header("location:users.php");
        }
        else
        {
            echo "<script>alert('Error occurred while saving data.');window.open('users.php', '_self');</script>";
            mysqli_close($conn);
        }
    }
}
?>