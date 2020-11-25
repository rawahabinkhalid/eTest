<?php
$i = 1;
$sql1 =
    'SELECT * FROM test JOIN accounts ON accounts.account_id = test.account_id JOIN employees ON employees.emp_id = test.emp_id JOIN testtype ON testtype.type_id = test.type_id JOIN invoice ON invoice.invoice_id = test.invoice_id WHERE accounts.account_id = ' .
    $account_filter .
    ' AND test.invoice_id IS NOT NULL ' .
    $sqlDate .
    ' ORDER BY collection_date, test.account_id';
$result1 = $conn->query($sql1);
$result2 = $conn->query($sql1);
while ($row1 = $result1->fetch_assoc()) {
    $name = $row1['account_nm'];
    echo '<tr>';
    $typeId = $row1['type_id'];
    $collection = $row1['collection_date'];
    $emp = $row1['emp_id'];
    $invId = $row1['invoice_id'];
    $amount = $row1['amount'];
    $fname = $row1['first_nm'];
    $lname = $row1['last_nm'];
    $typenm = $row1['type_nm'];
    $date = $row1['invoice_date'];

    echo '
            <td>' .
        $i .
        '</td>
            <td>' .
        $name .
        '</td>
            <td>' .
        $collection .
        '</td>
            <td>' .
        $emp .
        '</td>
            <td>' .
        $fname .
        '</td>
            <td>' .
        $lname .
        '</td>
            <td>' .
        $typenm .
        '</td>
            <td>' .
        $invId .
        '</td>
            <td>' .
        $amount .
        '</td>
            <td>' .
        $date .
        '</td>';
    echo '</tr>';
    $i++;
}
?>
