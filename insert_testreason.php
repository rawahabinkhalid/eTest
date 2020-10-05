<?php

include_once('conn.php');

if(isset($_GET['delete_reason_id'])) {
    $reason_id =$_GET['delete_reason_id'];

    $sql = 'DELETE FROM reasons WHERE `reason_id` = ' . $reason_id;
    echo $sql;
    if($conn->query($sql))
    {
        echo "<script>alert('The data has been uploaded.');</script>";
        header("location:testreason.php");
    }
    else
    {
        echo 'Error! Try Again';
        mysqli_close($conn);
    }
    } else {
    $resoncode = $_POST['resoncode'];
    $reasonname = $_POST['reason'];

    if(isset($_POST['testreason_id']) && $_POST['testreason_id'] == ''){
        $sql = 'INSERT INTO `reasons` (`reason_code`,`reason_nm`) VALUES ("'.$resoncode.'","'.$reasonname.'")';
        // echo $sql;
        if($conn->query($sql))
        {
            echo "<script>alert('The data has been uploaded.');</script>";
            header("location:testreason.php");
        }
        else
        {
            echo 'Error! Try Again';
            mysqli_close($conn);
        }
    } else if(isset($_POST['testreason_id']) && $_POST['testreason_id'] != ''){
        $sql1 = 'UPDATE reasons SET `reason_code` = "'.$resoncode.'", `reason_nm` = "'.$reasonname.'" WHERE reason_id ='. $_POST['testreason_id'];
        // echo $sql;
        if($conn->query($sql1))
        {
            echo "<script>alert('The data has been uploaded.');</script>";
            header("location:testreason.php");
        }
        else
        {
            echo 'Error! Try Again';
            mysqli_close($conn);
        }
    }
}
?>