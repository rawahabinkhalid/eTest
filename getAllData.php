<?php
include_once('conn.php');

if (isset($_GET['practitioner_id'])) {
    $sql = 'SELECT * FROM practitioner WHERE practitioner_id = ' . $_GET['practitioner_id'];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    }
} else if (isset($_GET['employee_id'])) {
    $sql = 'SELECT * FROM employees WHERE emp_id = "' . $_GET['employee_id'] . '"';
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    }
} else if (isset($_GET['laboratories_id'])) {
    $sql = 'SELECT * FROM lab WHERE lab_id = ' . $_GET['laboratories_id'];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    }
} else if (isset($_GET['testtype_id'])) {
    $sql = 'SELECT * FROM testtype WHERE `type_id` = ' . $_GET['testtype_id'];
    // echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    }
} else if (isset($_GET['sampletype_id'])) {
    $sql = 'SELECT * FROM sampletype WHERE `sample_id` = ' . $_GET['sampletype_id'];
    // echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    }
} else if (isset($_GET['testreason_id'])) {
    $sql = 'SELECT * FROM reasons WHERE `reason_id` = ' . $_GET['testreason_id'];
    // echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    }
} else if (isset($_GET['drugs_id'])) {
    $sql = 'SELECT * FROM drugs WHERE `drug_id` = ' . $_GET['drugs_id'];
    // echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    }
} else if (isset($_GET['user_id'])) {
    // $sql = 'SELECT users.*, userlocation.location FROM users LEFT JOIN userlocation ON users.user_id = userlocation.user_id  WHERE users.user_id = "' . $_GET['user_id'] . '"';
    $sql = 'SELECT * FROM users WHERE users.user_id = "' . $_GET['user_id'] . '"';
    // echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $sql1 = 'SELECT userlocation.location FROM userlocation WHERE userlocation.user_id = "' . $_GET['user_id'] . '"';
        $result1 = $conn->query($sql1);
        $locations = [];
        if ($result1->num_rows > 0) {
            while ($row1 = $result1->fetch_assoc()) {
                $locations[] = $row1['location'];
            }
        }
        $row['location'] = $locations;
        echo json_encode($row);
    }
} else if (isset($_GET['form_id'])) {
    $sql = 'SELECT * FROM drugform WHERE `form_id` = ' . $_GET['form_id'];
    // echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $data = [];
        $row = $result->fetch_assoc();
        $sql1 = 'SELECT drug_id FROM formdrugs WHERE `form_id` = ' . $_GET['form_id'];
        // echo $sql;
        $result1 = $conn->query($sql1);
        if ($result1->num_rows > 0) {
            while ($row1 = $result1->fetch_assoc()) {
                $data[] = $row1;
            }
        }
        $form = [];
        $form['formdata'] = $row;
        $form['formdrugs'] = $data;
        echo json_encode($form);
    }
} else if (isset($_GET['account_id'])) {
    $sql = 'SELECT * FROM accounts WHERE `account_id` = ' . $_GET['account_id'];
    // echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $data_divisions = [];
        $data_fees = [];
        $data_employees = [];
        $row = $result->fetch_assoc();
        $sql1 = 'SELECT * FROM divisions WHERE `account_id` = ' . $_GET['account_id'];
        // echo $sql;
        $result1 = $conn->query($sql1);
        if ($result1->num_rows > 0) {
            while ($row1 = $result1->fetch_assoc()) {
                $data_divisions[] = $row1;
            }
        }
        $sql2 = 'SELECT * FROM fees WHERE `account_id` = ' . $_GET['account_id'];
        // echo $sql;
        $result2 = $conn->query($sql2);
        if ($result2->num_rows > 0) {
            while ($row2 = $result2->fetch_assoc()) {
                $data_fees[] = $row2;
            }
        }
        $sql3 = 'SELECT * FROM employees WHERE `account_id` = ' . $_GET['account_id'];
        // echo $sql;
        $result3 = $conn->query($sql3);
        if ($result3->num_rows > 0) {
            while ($row3 = $result3->fetch_assoc()) {
                $data_employees[] = $row3;
            }
        }
        $form = [];
        $form['accounts_data'] = $row;
        $form['accounts_divisions'] = $data_divisions;
        $form['accounts_fees'] = $data_fees;
        $form['accounts_employees'] = $data_employees;
        echo json_encode($form);
    }
}
