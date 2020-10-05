<?php

include_once('conn.php');

if(isset($_GET['delete_sample_id'])) {
    $sample_id =$_GET['delete_sample_id'];

    $sql = 'DELETE FROM sampletype WHERE `sample_id` = ' . $sample_id;
    echo $sql;
    if($conn->query($sql))
    {
        echo "<script>alert('The data has been uploaded.');</script>";
        header("location:sampletype.php");
    }
    else
    {
        echo 'Error! Try Again';
        mysqli_close($conn);
    }
} else {
    $sampletypename = $_POST['sampletype'];

    if(isset($_POST['sampletype_id']) && $_POST['sampletype_id'] == ''){
        $sql = 'INSERT INTO `sampletype` (`sample_nm`) VALUES ("'.$sampletypename.'")';
        // echo $sql;
        if($conn->query($sql))
        {
            echo "<script>alert('The data has been uploaded.');</script>";
            header("location:sampletype.php");
        }
        else
        {
            echo 'Error! Try Again';
            mysqli_close($conn);
        }
    } else if(isset($_POST['sampletype_id']) && $_POST['sampletype_id'] != ''){
        $sql1 = 'UPDATE sampletype SET `sample_nm` = "'.$sampletypename.'" WHERE sample_id ='. $_POST['sampletype_id'];
        // echo $sql;
        if($conn->query($sql1))
        {
            echo "<script>alert('The data has been uploaded.');</script>";
            header("location:sampletype.php");
        }
        else
        {
            echo 'Error! Try Again';
            mysqli_close($conn);
        }
    }
}
?>