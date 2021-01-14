<?php
include_once "conn.php";
$sqlInvoice = 'SELECT invoice.*, SUM(IFNULL(amount, 0)) AS amount FROM invoice JOIN test ON test.invoice_id = invoice.invoice_id WHERE invoice.account_id = ' . $_GET['account'] . ' GROUP BY invoice.invoice_id ORDER BY invoice_id';
$resultInvoice = $conn->query($sqlInvoice);
$data = [];
if ($resultInvoice->num_rows > 0) {
    while ($rowInvoice = $resultInvoice->fetch_assoc()) {
        $sqlTest = 'SELECT * FROM test WHERE invoice_id = ' . $rowInvoice['invoice_id'] . ' ORDER BY test_id';
        $resultTest = $conn->query($sqlTest);
        $dataTest = [];
        if ($resultTest->num_rows > 0) {
            while ($rowTest = $resultTest->fetch_assoc()) {
                $dataTest[] = $rowTest;
            }
        }
        $rowInvoice['test'] = $dataTest;
        // $rowInvoice['sql'] = $sqlTest;
        $data[] = $rowInvoice;
        // echo '<option value="'.$rowInvoice['invoice_id'].'">'.$rowInvoice['invoice_id'].'</option>';
    }
}
echo json_encode($data);
