<?php

include_once('conn.php');

$importData = json_decode($_POST['importData']);
$employee_id_index = intval(explode(' ', $importData->employee_id)[1]) - 1;
$employee_first_nm_index = intval(explode(' ', $importData->employee_first_nm)[1]) - 1;
$employee_last_nm_index = intval(explode(' ', $importData->employee_last_nm)[1]) - 1;
$account = $importData->account;
$location = $importData->location;
$start_at_row = intval($importData->start_at_row) - 1;
$employees_data = $importData->employees_data;

for ($i = $start_at_row; $i < count($employees_data); $i++) {
    $employee_id = '';
    $employee_first_nm = '';
    $employee_last_nm = '';

    if (isset($employees_data[$i][$employee_id_index]))
        $employee_id = $employees_data[$i][$employee_id_index];
    if (isset($employees_data[$i][$employee_first_nm_index]))
        $employee_first_nm = $employees_data[$i][$employee_first_nm_index];
    if (isset($employees_data[$i][$employee_last_nm_index]))
        $employee_last_nm = $employees_data[$i][$employee_last_nm_index];

    if ($employee_id != '') {
        $sql = 'SELECT * FROM employees WHERE 
            emp_id = "' . $employee_id . '"
            ORDER BY insert_date DESC
            ';
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($employee_first_nm == '')
                $employee_first_nm = $row['first_nm'];
            if ($employee_last_nm == '')
                $employee_last_nm = $row['last_nm'];

            $sqlImport = 'UPDATE employees SET 
                emp_id = "' . $employee_id . '",
                first_nm = "' . $employee_first_nm . '",
                last_nm = "' . $employee_last_nm . '",
                account_id = "' . $account . '",
                division_id = "' . $location . '",
                status = "A" WHERE 
                emp_id = "' . $employee_id . '"
    ';
        } else {
            $sqlImport = 'INSERT INTO employees 
                (`emp_id`, `account_id`, `division_id`, `first_nm`, `last_nm`, `specimen_id`, `status`, `insert_user_id`, `insert_date`) VALUES (
                    "' . $employee_id . '",
                    ' . $account . ',
                    ' . $location . ',
                    "' . $employee_first_nm . '",
                    "' . $employee_last_nm . '",
                    "",
                    "A",
                    "' . $_SESSION['userid'] . '",
                    "' . date('Y-m-d H:i:s') . '"
                    )
                ';
        }
        echo $sqlImport;
        if ($conn->query($sqlImport)) {
        } else {
            echo $conn->error;
        }
    }
}
