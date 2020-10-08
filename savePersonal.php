<?php

include_once "conn.php";

$sql = 'UPDATE users SET password = "'.$_POST['password'].'" WHERE user_id = "'.$_POST['userid'].'"';
if($conn->query($sql)) {
    echo '<script>alert("Saved successfully.");window.open("personal.php", "_self");</script>';
} else {
    echo '<script>alert("Error occurred while updating data.");window.open("personal.php", "_self");</script>';
}


?>