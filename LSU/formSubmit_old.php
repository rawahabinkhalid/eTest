<?php
include_once "../conn.php";
// $conn = mysqli_connect("localhost","root","","etest");

$client = $_POST['client'];
$dept = $_POST['dept'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$ssn = $_POST['ssn'];
$specimen = $_POST['specimen'];
$collectionSite = $_POST['collectionSite'];
$account = $_POST['account'];
$fund = $_POST['fund'];
$department = $_POST['department'];
$program = $_POST['program'];
$class = $_POST['class'];
$project = $_POST['project'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$requestedBy = $_POST['requestedBy'];
$requestedDate = $_POST['requestedDate'];
$deadline = $_POST['deadline'];
$type = $_POST['type'];
$reason = $_POST['reason'];
$type2 = $_POST['type2'];
$type3 = $_POST['type3'];
$safety = $_POST['safety'];
$comments = $_POST['comments'];


$sql = 'INSERT INTO `lsuform`(`Client`, `Dept`, `FirstName`, `LastName`, `SSN`, `Specimen`, `Collection`, `Account`, `Fund`, `Department`, `Program`, `Class`, `Project`, `Contact`, `Email`, `RequestedBy`, `RequestedDate`, `Deadline`, `TestType`, `Reason`, `Type2`, `Type3`, `Safety`, `Comments`) VALUES ("'.$client.'","'.$dept.'","'.$fname.'","'.$lname.'","'.$ssn.'","'.$specimen.'","'.$collectionSite.'","'.$account.'","'.$fund.'","'.$department.'","'.$program.'","'.$class.'","'.$project.'","'.$contact.'","'.$email.'","'.$requestedBy.'","'.$requestedDate.'","'.$deadline.'","'.$type.'","'.$reason.'","'.$type2.'","'.$type3.'","'.$safety.'","'.$comments.'")';
$result = $conn->query($sql);
if ($result) {
	// echo "Success";
	header('location: LSU_Table.php');
}
else{
	echo $sql;
}

?>