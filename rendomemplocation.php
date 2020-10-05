<?php
include_once('conn.php');
$employee_count = 0;
$sql = 'SELECT COUNT(*) AS employee_count FROM `employees` WHERE division_id = ' . $_GET['val'];
$result = mysqli_query($conn, $sql);
if($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $employee_count = intval($row['employee_count']);
}
echo $employee_count;
?>