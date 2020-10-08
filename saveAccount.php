<?php

include_once "conn.php";
$accounts = (isset($_POST['active'])) ? $_POST['active'] : '0';
$sql = 'UPDATE accounts SET user_id = "' . $_POST['userid'] . '", password = "' . $_POST['password'] . '", account_nm = "' . $_POST['account_nm'] . '", account_code = "' . $_POST['account_code'] . '", active = "' . $active . '" WHERE account_id = "'.$_POST['account_id'].'"';
if($conn->query($sql)) {
    echo '<script>alert("Saved successfully.");window.open("accountsManagement.php", "_self");</script>';
} else {
    echo '<script>alert("Error occurred while updating data.");window.open("accountsManagement.php", "_self");</script>';
}


?>