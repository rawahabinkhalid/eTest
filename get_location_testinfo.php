<?php
include_once('conn.php');

if(isset($_GET['account_id_location'])) {
    $content = '<option selected disabled value="">Please select Location</option>';
    $sql = 'SELECT DISTINCT(division_nm), division_id FROM divisions WHERE account_id = ' . $_GET['account_id_location'];
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $content .=  '<option value="'.$row['division_id'].'">'.$row['division_nm'].'</option>';
        }
    }
    echo $content;
}


if(isset($_GET['account_id_employee']) && isset($_GET['location_select'])) {
    $content = '<option selected disabled value="">Please select Employee</option>';
    $sql = 'SELECT * FROM employees WHERE status <> "T" AND account_id = ' . $_GET['account_id_employee'] . ' AND division_id = ' . $_GET['location_select'];
    // echo $sql;
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $content .= '<option value="'.$row['emp_id'].'">'.$row['first_nm'].' '.$row['last_nm'].'</option>';
        }
    }
    echo $content;

}
?>