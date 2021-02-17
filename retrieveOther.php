<?php
include_once "conn.php";

// header("Content-Type: application/json; charset=UTF-8");
$obj = json_decode($_POST["data"], false);
// print_r($obj);
$response = new \StdClass;
// $response->message = 'got it';
// echo json_encode($response);
// echo "got it";
$filter = '';
if(isset($obj->emp_id) && $obj->emp_id != '') {
    $filter .= ' AND test.emp_id = "' . $obj->emp_id . '"';
}
if(isset($obj->test_date_from) && $obj->test_date_from != '') {
    $filter .= ' AND test.test_date >= "' . $obj->test_date_from . '"';
}
if(isset($obj->test_date_to) && $obj->test_date_to != '') {
    $filter .= ' AND test.test_date <= "' . $obj->test_date_to . '"';
}
if(isset($obj->collection_date_from) && $obj->collection_date_from != '') {
    $filter .= ' AND test.collection_date >= "' . $obj->collection_date_from . '"';
}
if(isset($obj->collection_date_to) && $obj->collection_date_to != '') {
    $filter .= ' AND test.collection_date <= "' . $obj->collection_date_to . '"';
}
if(isset($obj->status) && $obj->status != '') {
    $filter .= ' AND status = "' . $obj->status . '"';
}
if(isset($obj->result) && $obj->result != '') {
    $filter .= ' AND test.result = "' . $obj->result . '"';
}
if(isset($obj->type_id) && $obj->type_id != '') {
    $filter .= ' AND test.type_id = ' . $obj->type_id;
}
if(isset($obj->reason_id) && $obj->reason_id != '') {
    $filter .= ' AND reasons.reason_id = ' . $obj->reason_id;
}
if(isset($obj->batch_id) && $obj->batch_id != '') {
    $filter .= ' AND test.batch_id = ' . $obj->batch_id;
}
if(isset($obj->form_id) && $obj->form_id != '') {
    $filter .= ' AND test.form_id = ' . $obj->form_id;
}
if(isset($obj->insert_user_id) && $obj->insert_user_id != '') {
    $filter .= ' AND test.insert_user_id = ' . $obj->insert_user_id;
}
if(isset($obj->insert_date_from) && $obj->insert_date_from != '') {
    $filter .= ' AND test.insert_date >= "' . $obj->insert_date_from . '"';
}
if(isset($obj->insert_date_to) && $obj->insert_date_to != '') {
    $filter .= ' AND test.insert_date <= "' . $obj->insert_date_to . '"';
}
if(isset($obj->invoice_id) && $obj->invoice_id != '') {
    $filter .= ' AND test.invoice_id = ' . $obj->invoice_id;
}
$content = '';
$sql_test = 'SELECT * FROM test 
            JOIN divisions ON divisions.division_id = test.division_id
            JOIN reasons ON reasons.reason_id = test.reason_id
            JOIN sampletype ON sampletype.sample_id = test.sample_id
            JOIN testtype ON testtype.type_id = test.type_id WHERE test.account_id = ' . $_GET['account_id'] . ' AND test_id IS NOT NULL ' . $filter;
$result_test = $conn->query($sql_test);
// echo $sql_test;
if($result_test->num_rows > 0) {
    $counter = 1;
    while($row_test = $result_test->fetch_assoc()) {
        $url = "'getTestInfo.php?account=".$_GET['account_id']."&id=".$row_test['test_id']."'";
        $target = "'_self'";
        $content .= '<tr onclick="window.open('.$url.', '.$target.');">';
        $content .= '<td>'.$counter++.'</td>';
        $content .= '<td>'.$row_test['test_id'].'</td>';
        $content .= '<td>'.$row_test['invoice_id'].'</td>';
        $content .= '<td>'.$row_test['emp_id'].'</td>';
        $content .= '<td>'.$row_test['division_nm'].'</td>';
        $content .= '<td>'.$row_test['reason_nm'].'</td>';
        $content .= '<td>'.$row_test['sample_nm'].'</td>';
        $content .= '<td>'.$row_test['type_nm'].'</td>';
        $content .= '<td>'.number_format(floatval($row_test['amount']), 3).'</td>';
        $content .= '</tr>';
    }
}

$response->data = $content;
echo json_encode($response);
?>