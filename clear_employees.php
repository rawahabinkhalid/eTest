<?php

include_once('conn.php');

$sql = 'DELETE FROM employees WHERE account_id = ' . $_POST['data'];
$conn->query($sql);