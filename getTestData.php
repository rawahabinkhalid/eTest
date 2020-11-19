<?php
include_once "conn.php";

$sql = 'SELECT * FROM test JOIN testtype ON test.type_id = testtype.type_id WHERE test.test_id = ' . $_GET['test_id'];
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while (
        $row = $result->fetch_assoc()
    ) {
        $emp_id = '';
        $first_nm = '';
        $last_nm = '';
        $sqlEmployee = 'SELECT * FROM employees WHERE emp_id = "' . $row['emp_id'] . '"';
        $resultEmployee = $conn->query($sqlEmployee);
        if ($resultEmployee->num_rows > 0) {
            $rowEmployee = $resultEmployee->fetch_assoc();
            $emp_id = $rowEmployee['emp_id'];
            $first_nm = $rowEmployee['first_nm'];
            $last_nm = $rowEmployee['last_nm'];
        }
        echo '<tr>';
        echo '<td>1</td>';
        echo '<td>'.$row['test_id'].'</td>';
        echo '<td>'.$emp_id.'</td>';
        echo '<td>'.$first_nm.'</td>';
        echo '<td>'.$last_nm.'</td>';
        echo '<td>'.$row['type_nm'].'</td>';
        echo '<td>'.date('d-M-Y', strtotime($row['test_date'])).'</td>';
        echo '<td>'.number_format(floatval($row['amount']), 2).'</td>';
        echo '<tr>';
    }
}
?>