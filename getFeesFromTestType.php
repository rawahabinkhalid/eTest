<?php
include_once "conn.php";

$fees = 0;
$sqlFees = 'SELECT * FROM `fees` WHERE account_id = ' . $_GET['account'] . ' AND type_id = ' . $_GET['type_id'];
// echo $sqlFees;
$resultFees = $conn->query($sqlFees);
if($resultFees->num_rows > 0) {
    $rowFees = $resultFees->fetch_assoc();
    // print_r($rowPreferences);
    $fees = $rowFees['amount'];
}
if($fees != '')
echo $fees;
else
echo 0;

?>