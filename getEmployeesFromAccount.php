<?php
include_once('conn.php');


if (isset($_GET['account_id_location'])) {
    $content = '<option selected disabled value="">Please select Employee</option>';
    // $sql = 'SELECT * FROM employees WHERE status = "A" ORDER BY first_nm, last_nm';
    $sql = 'SELECT * FROM employees WHERE status <> "T" AND account_id = ' . $_GET['account_id_location'] . '  ORDER BY first_nm, last_nm';
    // echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $content .= '<option value="' . $row['emp_id'] . '">' . $row['specimen_id'] . ' - ' . $row['first_nm'] . ' ' . $row['last_nm'] . '</option>';
        }
    }
    echo $content;
}
