<?php
include 'conn.php';
$test_no = (isset($_POST['test_no'])) ? $_POST['test_no'] : '';
$invoice_no = (isset($_POST['invoice_no'])) ? $_POST['invoice_no'] : '';
$requisition_no = $_POST['requisition_no'];
$account = $_POST['accounts_select'];
$location = $_POST['location_select'];
$emp = $_POST['employee_select'];
$collection = $_POST['collectiondate'];
$date_reported = $_POST['date_reported'];
$date_mro_recvd = $_POST['date_mro_recvd'];
$testdate = $_POST['testdate'];
$reason = $_POST['testreason'];
$stype = $_POST['sampletype'];
$type = $_POST['testtype'];
$amount = $_POST['fee_amount'];
$resultStatus = $_POST['negative_positive'];
$drug_ids = $_POST['drug_ids'];
$drug_result = $_POST['drug_result'];

$formId = 'null';
if ($resultStatus == 'neg') {
    $formId = $_POST['selectForm'];
    $result = 'N';
} elseif ($resultStatus == 'pos') {
    $result = 'P';
}

//checking other substances
if ($_POST['other'] == 'T') {
    $otherName = $_POST['otherName'];
    $other = $_POST['other'];
} else {
    $otherName = null;
    $other = null;
}

$sqlCompany = 'SELECT MAX(company_id) as compID FROM company';
$resultComp = $conn->query($sqlCompany);
$rowComp = $resultComp->fetch_assoc();
$compId = $rowComp['compID'];

$sqlLab = 'SELECT * FROM preferences';
$resultLab = $conn->query($sqlLab);
$rowLab = $resultLab->fetch_assoc();
$labId = $rowLab['lab_id'];
$prac = $rowLab['practitioner_id'];
if($test_no != '') {
    $sqlDelete = 'DELETE FROM test WHERE test_id = ' . $test_no;
    $conn->query($sqlDelete);
    if(isset($formId) && $formId != '') {
        $sql =
            'INSERT INTO `test`(`test_id`, `invoice_id`, `account_id`, `division_id`, `emp_id`, `collection_date`, `reported_date`, `mro_received_date`, `company_id`, `lab_id`, `reason_id`, `result`, `practitioner_id`, `test_date`, `type_id`, `sample_id`, `amount`,  `batch_id`, `insert_user_id`, `form_id`, `other`, `other_nm`, `req_no`) VALUES (' .
            $test_no .
            ',' .
            $invoice_no .
            ',' .
            $account .
            ',' .
            $location .
            ',"' .
            $emp .
            '","' .
            $collection .
            '","' .
            $date_reported .
            '","' .
            $date_mro_recvd .
            '",' .
            $compId .
            ',' .
            $labId .
            ',' .
            $reason .
            ',"' .
            $result .
            '",' .
            $prac .
            ',"' .
            $testdate .
            '",' .
            $type .
            ',' .
            $stype .
            ',"' .
            $amount .
            '",2,"' .
            $_SESSION['userid'] .
            '",' .
            $formId .
            ',"' .
            $other .
            '","' .
            $otherName .
            '","' .
            $requisition_no .
            '")';
        } else {
        $sql =
            'INSERT INTO `test`(`test_id`, `invoice_id`, `account_id`, `division_id`, `emp_id`, `collection_date`, `reported_date`, `mro_received_date`, `company_id`, `lab_id`, `reason_id`, `result`, `practitioner_id`, `test_date`, `type_id`, `sample_id`, `amount`,  `batch_id`, `insert_user_id`, `other`, `other_nm`, `req_no`) VALUES (' .
            $test_no .
            ',' .
            $invoice_no .
            ',' .
            $account .
            ',' .
            $location .
            ',"' .
            $emp .
            '","' .
            $collection .
            '","' .
            $date_reported .
            '","' .
            $date_mro_recvd .
            '",' .
            $compId .
            ',' .
            $labId .
            ',' .
            $reason .
            ',"' .
            $result .
            '",' .
            $prac .
            ',"' .
            $testdate .
            '",' .
            $type .
            ',' .
            $stype .
            ',"' .
            $amount .
            '",2,"' .
            $_SESSION['userid'] .
            ',"' .
            $other .
            '","' .
            $otherName .
            '","' .
            $requisition_no .
            '")';
        }
} else {
    if(isset($formId) && $formId != '') {
        $sql =
            'INSERT INTO `test`( `account_id`, `division_id`, `emp_id`, `collection_date`, `reported_date`, `mro_received_date`, `company_id`, `lab_id`, `reason_id`, `result`, `practitioner_id`, `test_date`, `type_id`, `sample_id`, `amount`,  `batch_id`, `insert_user_id`, `form_id`, `other`, `other_nm`, `req_no`) VALUES (' .
            $account .
            ',' .
            $location .
            ',"' .
            $emp .
            '","' .
            $collection .
            '","' .
            $date_reported .
            '","' .
            $date_mro_recvd .
            '",' .
            $compId .
            ',' .
            $labId .
            ',' .
            $reason .
            ',"' .
            $result .
            '",' .
            $prac .
            ',"' .
            $testdate .
            '",' .
            $type .
            ',' .
            $stype .
            ',"' .
            $amount .
            '",2,"' .
            $_SESSION['userid'] .
            '",' .
            $formId .
            ',"' .
            $other .
            '","' .
            $otherName .
            '","' .
            $requisition_no .
            '")';
        } else {
        $sql =
            'INSERT INTO `test`( `account_id`, `division_id`, `emp_id`, `collection_date`, `reported_date`, `mro_received_date`, `company_id`, `lab_id`, `reason_id`, `result`, `practitioner_id`, `test_date`, `type_id`, `sample_id`, `amount`,  `batch_id`, `insert_user_id`, `other`, `other_nm`, `req_no`) VALUES (' .
            $account .
            ',' .
            $location .
            ',"' .
            $emp .
            '","' .
            $collection .
            '","' .
            $date_reported .
            '","' .
            $date_mro_recvd .
            '",' .
            $compId .
            ',' .
            $labId .
            ',' .
            $reason .
            ',"' .
            $result .
            '",' .
            $prac .
            ',"' .
            $testdate .
            '",' .
            $type .
            ',' .
            $stype .
            ',"' .
            $amount .
            '",2,"' .
            $_SESSION['userid'] .
            ',"' .
            $other .
            '","' .
            $otherName .
            '","' .
            $requisition_no .
            '")';
        }
}

if ($conn->query($sql)) {
    $id = mysqli_insert_id($conn);

    if ($result == 'P') {
        for ($i = 0; $i < count($drug_ids); $i++) {
            $sql1 =
                'INSERT INTO `testresult`( `test_id`, `account_id`, `drug_id`, `result`) VALUES (' .
                $id .
                ', ' .
                $account .
                ',' .
                $drug_ids[$i] .
                ',"' .
                $drug_result[$i] .
                '")';
            if ($conn->query($sql1)) {
            }
        }
    }
    // if($resultStatus == "pos"){
    // 	for($i = 0;$i<sizeof($_POST['positiveForCheckBox']);$i++){
    // 		$sqlResult = 'INSERT INTO testresult (test_id,account_id,drug_id,result) VALUES ('.$id.','.$account.','.$_POST['positiveForCheckBox'].')'
    // 	}
    // }
    echo "id=" . $id;
} else {
    // echo $sql;
}

?>