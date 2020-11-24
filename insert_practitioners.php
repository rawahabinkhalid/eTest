<?php

include_once('conn.php');
$error_occurred = false;

if(isset($_GET['delete_practitioner_id'])) {
    $practitioner_id =$_GET['delete_practitioner_id'];

    $sql = 'DELETE FROM practitioner WHERE `practitioner_id` = ' . $practitioner_id;
    // echo $sql;
    if($conn->query($sql))
    {
        echo "<script>alert('The data has been uploaded.');window.open('practitioners.php', '_self');</script>";
        // echo "<script>alert('The data has been uploaded.');</script>";
        // header("location:practitioners.php");
    }
    else
    {
        echo "<script>alert('Error occurred while saving data.');window.open('practitioners.php', '_self');</script>";
        // echo "<script>alert('Error! Try Again');</script>";
        // header("location:practitioners.php");
    }
} else {
    $practname = $_POST['practname'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $phone = $_POST['phone'];
    $fax = $_POST['fax'];
    $signaturefile = $_FILES['signaturefile']['name'];
    $imageSql = '';
    if($_FILES['signaturefile']['name'] != '') {
        $imageSql = ', `signaturefile` ="'.$signaturefile.'" ';

        
        if(isset($_POST['practitioner_id']) && $_POST['practitioner_id'] == '') {

            $sql = 'INSERT INTO `practitioner` (`practitioner_nm`,`address`,`city`,`state`,`zip`,`phone`,`fax`,`sig_file_nm`) VALUES ("'.$practname.'","'.$address.'","'.$city.'","'.$state.'","'.$zip.'","'.$phone.'","'.$fax.'","'.$signaturefile.'")';
            // echo $sql;
            if($conn->query($sql))
            {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["signaturefile"]["name"]);
                if (move_uploaded_file($_FILES["signaturefile"]["tmp_name"], $target_file)) {
                    echo "<script>alert('The file ". basename( $_FILES["signaturefile"]["name"]). " has been uploaded.');</script>";
                } else {
                    echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
                }
                echo "<script>window.open('practitioners.php', '_self');</script>";
                // header("location:practitioners.php");
            }
            else
            {
                echo "<script>alert('Error occurred while saving data.');window.open('practitioners.php', '_self');</script>";
            }
            
        } else if (isset($_POST['practitioner_id']) && $_POST['practitioner_id'] != '') {

            $sql1 = 'UPDATE practitioner SET `practitioner_nm` = "'.$practname.'" , `address` = "'.$address.'" , `city` = "'.$city.'" , `state` = "'.$state.'" , `zip` = "'.$zip.'" , `phone` = "'.$phone.'" , `fax` = "'.$fax.'" '.$imageSql.' WHERE  `practitioner_id` = '.$_POST['practitioner_id'] ;
            // echo $sql1;
            if($conn->query($sql1))
            {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["signaturefile"]["name"]);
                if($_FILES['signaturefile']['name'] != '') {
                    if (move_uploaded_file($_FILES["signaturefile"]["tmp_name"], $target_file)) {
                        echo "<script>alert('The file ". basename( $_FILES["signaturefile"]["name"]). " has been uploaded.');</script>";
                    } else {
                        echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
                    }

                }
                echo "<script>window.open('practitioners.php', '_self');</script>";
            }
            else
            {
                echo "<script>alert('Error occurred while saving data.');window.open('practitioners.php', '_self');</script>";
            }

        }
    }
}
?>