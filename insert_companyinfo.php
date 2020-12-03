<?php

include_once('conn.php');

$companyname = $_POST['companyname'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip = $_POST['zip'];
$phone = $_POST['phone'];
$fax = $_POST['fax'];
$cmplogo = $_FILES['cmplogo']['name'];
$imageSql = '';
if($_FILES['cmplogo']['name'] != '') {
    $imageSql = $cmplogo;
} else if ($_POST['cmplogo_old'] != '') {
    $imageSql = $_POST['cmplogo_old'];
}

$sql = 'INSERT INTO company (`company_nm`, `address`, `city`, `state`, `zip`, `phone`, `fax`, `logo_file_nm`) VALUES ("'.$companyname.'", "'.$address.'", "'.$city.'", "'.$state.'", "'.$zip.'", "'.$phone.'", "'.$fax.'", "'.$imageSql.'")';
// $sql = 'UPDATE company SET `company_nm` = "'.$companyname.'" , `address` = "'.$address.'" , `city` = "'.$city.'" , `state` = "'.$state.'" , `zip` = "'.$zip.'" , `phone` = "'.$phone.'" , `fax` = "'.$fax.'" '.$imageSql.' WHERE  `company_id` = 1 ';
// echo $sql;
if($conn->query($sql))
{
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["cmplogo"]["name"]);
    if($_FILES['cmplogo']['name'] != '') {
        if (move_uploaded_file($_FILES["cmplogo"]["tmp_name"], $target_file)) {
            echo "<script>alert('The file ". basename( $_FILES["cmplogo"]["name"]). " has been uploaded.');</script>";
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
        }

    }
    header("location:companyinfo.php");
}
else
{
    echo 'Error! Try Again';
    mysqli_close($conn);
}

?>