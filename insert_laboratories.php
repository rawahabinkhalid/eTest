<?php

include_once('conn.php');

if(isset($_GET['delete_laboratories_id'])) {
    $laboratories_id =$_GET['delete_laboratories_id'];

    $sql = 'DELETE FROM lab WHERE `lab_id` = ' . $laboratories_id;
    echo $sql;
    if($conn->query($sql))
    {
        echo "<script>alert('The data has been uploaded.');</script>";
        header("location:laboratories.php");
    }
    else
    {
        echo 'Error! Try Again';
        mysqli_close($conn);
    }
} else {
    $labname = $_POST['labname'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $phone = $_POST['phone'];
    $fax = $_POST['fax'];

    if(isset($_POST['laboratories_id']) && $_POST['laboratories_id'] == '') {
        
        $sql = 'INSERT INTO `lab` (`lab_nm`,`address`,`city`,`state`,`zip`,`phone`,`fax`) VALUES ("'.$labname.'","'.$address.'","'.$city.'","'.$state.'","'.$zip.'","'.$phone.'","'.$fax.'")';
        echo $sql;
        if($conn->query($sql))
        {
            echo "<script>alert('The data has been uploaded.');</script>";
            header("location:laboratories.php");
        }
        else
        {
            echo 'Error! Try Again';
            echo $conn->error;
            mysqli_close($conn);
        }
    } else if (isset($_POST['laboratories_id']) && $_POST['laboratories_id'] != '') {

        $sql1 = 'UPDATE lab SET `lab_nm` = "'.$labname.'" , `address` = "'.$address.'" , `city` = "'.$city.'" , `state` = "'.$state.'" , `zip` = "'.$zip.'" , `phone` = "'.$phone.'" , `fax` = "'.$fax.'" WHERE  `lab_id` = '.$_POST['laboratories_id'] ;
        // echo $sql1;
        if($conn->query($sql1))
        {
            echo "<script>alert('The data has been uploaded.');</script>";
            header("location:laboratories.php");
        }
        else
        {
            echo 'Error! Try Again';
            mysqli_close($conn);
        }

    }
}
?>