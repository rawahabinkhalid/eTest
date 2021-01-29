<?php
/*
billedType=existing_invoice
invoiceNoBilled=35796
invoiceNoBill=35796
invoiceDateBill=2008-08-01
division_id_bill=1855
invoiceReferenceBill=Drug%20Screens%20%2F%20See%20Excel%20Spreadsheet
invoiceTermsBill=30
invoiceDueDateBill=2008-08-31
sentBillDate=2008-07-31
invoiceAmountDueBill=175
invoiceAmountPaidBill=144
invoiceCheckNoBill=398612
invoiceCheckDateBill=2008-08-25
invoicePayDateBill=2008-08-25
test_id_added=653519
*/
include_once('conn.php');

$sqlcheck = 'SELECT * FROM invoice WHERE invoice_id = '. $_POST['invoiceNoBilled'];
$resultcheck = mysqli_query($conn,$sqlcheck);

$insertdate = date('Y-m-d H:i:s');
$updatedate = date('Y-m-d H:i:s');

$paidInFull = (isset($_POST['paidInFull'])) ? $_POST['paidInFull'] : 'F';
$sentBill = (isset($_POST['sentBill'])) ? $_POST['sentBill'] : 'F';

if(mysqli_num_rows($resultcheck) > 0){

    $sqlDelete = 'DELETE FROM invoice WHERE invoice_id = '. $_POST['invoiceNoBilled'];
    $resultDelete = mysqli_query($conn,$sqlDelete);

    if($resultDelete){

        $sql = 'INSERT INTO invoice(
            `invoice_id`,
            `company_id`,
            `account_id`,
            `division_id`,
            `terms`,
            `reference_nm`,
            `invoice_date`,
            `check_no`,
            `check_date`,
            `amount_paid`,
            `pay_date`,
            `due_date`,
            `paid`,
            `comments`,
            `insert_user_id`,
            `insert_date`,
            `update_user_id`,
            `update_date`,
            `sent`,
            `send_type`,
            `send_date`
        )
        VALUES( "'.$_POST['invoiceNoBilled'].'", 1 , "'.$_POST['account_id_bill'].'", "'.$_POST['division_id_bill'].'", 
                "'.$_POST['invoiceTermsBill'].'", "'.$_POST['invoiceReferenceBill'].'", "'.$_POST['invoiceDateBill'].'", 
                "'.$_POST['invoiceCheckNoBill'].'", "'.$_POST['invoiceCheckDateBill'].'", "'.$_POST['invoiceAmountPaidBill'].'", 
                "'.$_POST['invoicePayDateBill'].'", "'.$_POST['invoiceDueDateBill'].'", "'.$paidInFull.'", "", "'.$_SESSION['userid'].'", 
                "'.$insertdate.'", "'.$_SESSION['userid'].'", "'.$updatedate.'", "'.$sentBill.'", " ", "'.$_POST['sentBillDate'].'") ';
        $result = mysqli_query($conn,$sql);

        if($result){
    
            echo "The data has been uploaded.";

        } else {
            echo $sql;
        }
        
    } else {

        echo $sqlDelete;
    }

} else {

    $sql = 'INSERT INTO invoice(
        `company_id`,
        `account_id`,
        `division_id`,
        `terms`,
        `reference_nm`,
        `invoice_date`,
        `check_no`,
        `check_date`,
        `amount_paid`,
        `pay_date`,
        `due_date`,
        `paid`,
        `comments`,
        `insert_user_id`,
        `insert_date`,
        `update_user_id`,
        `update_date`,
        `sent`,
        `send_type`,
        `send_date`
    )
    VALUES( 1 , "'.$_POST['account_id_bill'].'", "'.$_POST['division_id_bill'].'", 
                "'.$_POST['invoiceTermsBill'].'", "'.$_POST['invoiceReferenceBill'].'", "'.$_POST['invoiceDateBill'].'", 
                "'.$_POST['invoiceCheckNoBill'].'", "'.$_POST['invoiceCheckDateBill'].'", "'.$_POST['invoiceAmountPaidBill'].'", 
                "'.$_POST['invoicePayDateBill'].'", "'.$_POST['invoiceDueDateBill'].'", "'.$paidInFull.'", "", "'.$_SESSION['userid'].'", 
                "'.$insertdate.'", "'.$_SESSION['userid'].'", "'.$updatedate.'", "'.$sentBill.'", " ", "'.$_POST['sentBillDate'].'") ';

    $result = mysqli_query($conn,$sql);
    $id = $conn->insert_id;
    $sql = 'INSERT INTO invoiceitems(
        `invoice_id`,
        `account_id`,
        `test_id`,
        `insert_user_id`,
        `insert_date`
    )
    VALUES( "'.$id.'" , "'.$_POST['account_id_bill'].'", '.$_POST['test_id_added'].', 
                "'.$_SESSION['userid'].'", "'.$insertdate.'") ';
    $result = mysqli_query($conn,$sql);
    $sqlUpdateTest = 'UPDATE test SET invoice_id = ' . $id . ' WHERE test_id = ' . $_POST['test_id_added'];
    $result = mysqli_query($conn,$sqlUpdateTest);

    if($result){

        echo "The data has been uploaded.";

    } else {
        echo $sql;
    }
}


?>