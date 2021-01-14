<?php
include_once('conn.php');

$employeeData = json_decode($_POST['employeeData']);
// print_r($employeeData);
// $sql3 = 'SELECT * FROM divisions WHERE account_id = ' . $employeeData->account_id . ' AND division_nm = "' . $employeeData->division_id . '"';
// echo $sql3;
// $result3 = $conn->query($sql3);
// if($result3->num_rows > 0) {
// $row3 = $result3->fetch_assoc();
$sql3 = 'SELECT * FROM employees WHERE account_id = ' . $employeeData->account_id . ' AND emp_id = "' . $employeeData->emp_id . '"';
// echo $sql3;
$result3 = $conn->query($sql3);
if ($result3->num_rows > 0) {
    $sqlDelete = 'DELETE FROM employees WHERE account_id = ' . $employeeData->account_id . ' AND emp_id = "' . $employeeData->emp_id . '"';
    $conn->query($sqlDelete);
}
$row3 = $result3->fetch_assoc();
$data = new \stdClass;
$sql2 = 'INSERT INTO `employees` (`emp_id`, `account_id`, `division_id`, `first_nm`, `last_nm`, `specimen_id`, `status`, `insert_user_id`, `insert_date`) VALUES ("' . $employeeData->emp_id . '", ' . $employeeData->account_id . ', "' . $employeeData->division_id . '", "' . $employeeData->first_nm . '", "' . $employeeData->last_nm . '", "' . $employeeData->specimen_id . '", "' . $employeeData->status . '", "' . $_SESSION['userid'] . '", "' . date('Y-m-d H:i:s') . '")';
// echo $sql2;
if ($conn->query($sql2)) {
    $data->message = "The data has been uploaded.";
    $data->id = $employeeData->emp_id;
} else {
    if (strstr($conn->error, 'Duplicate entry')) {
        $data->message = 'Employee Id already exists';
    } else {
        $data->message = $conn->error;
    }
    mysqli_close($conn);
}
echo json_encode($data);
