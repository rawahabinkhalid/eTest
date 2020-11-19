<?php
include_once "conn.php";
$sqlInvoice = 'SELECT * FROM invoice WHERE account_id = ' . $_GET['account'] . ' ORDER BY invoice_id';
$resultInvoice = $conn->query($sqlInvoice);
$data = [];
if($resultInvoice->num_rows > 0) {
    while($rowInvoice = $resultInvoice->fetch_assoc()) {
        $data[] = $rowInvoice;
        // echo '<option value="'.$rowInvoice['invoice_id'].'">'.$rowInvoice['invoice_id'].'</option>';
    }
}
echo json_encode($data);
?>