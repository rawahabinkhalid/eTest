<?php
include_once "conn.php";

$sql_test = 'SELECT * FROM test 
            JOIN divisions ON divisions.division_id = test.division_id
            JOIN reasons ON reasons.reason_id = test.reason_id
            JOIN sampletype ON sampletype.sample_id = test.sample_id
            JOIN testtype ON testtype.type_id = test.type_id WHERE test.account_id = ' . $_GET['account_id'];
$result_test = $conn->query($sql_test);
if($result_test->num_rows > 0) {
    $counter = 1;
    while($row_test = $result_test->fetch_assoc()) {
        $url = "'getTestInfo.php?id=".$row_test['test_id']."'";
        $target = "'_self'";
        echo '<tr onclick="window.open('.$url.', '.$target.');">';
        echo '<td>'.$counter++.'</td>';
        echo '<td>'.$row_test['test_id'].'</td>';
        echo '<td>'.$row_test['invoice_id'].'</td>';
        echo '<td>'.$row_test['emp_id'].'</td>';
        echo '<td>'.$row_test['division_nm'].'</td>';
        echo '<td>'.$row_test['reason_nm'].'</td>';
        echo '<td>'.$row_test['sample_nm'].'</td>';
        echo '<td>'.$row_test['type_nm'].'</td>';
        echo '<td>'.number_format(floatval($row_test['amount']), 3).'</td>';
        
        echo '</tr>';
    }
}
?>