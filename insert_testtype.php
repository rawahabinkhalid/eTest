<?php

include_once('conn.php');

if(isset($_GET['delete_testtype_id'])) {
    $testtype_id =$_GET['delete_testtype_id'];

    $sql = 'DELETE FROM testtype WHERE `type_id` = ' . $testtype_id;
    // echo $sql;
    if($conn->query($sql))
    {
        echo "<script>alert('The data has been uploaded.');window.open('testtype.php', '_self');</script>";
        // echo "<script>alert('The data has been uploaded.');</script>";
        // header("location:testtype.php");
    }
    else
    {
        echo "<script>alert('Error occurred while saving data.');window.open('testtype.php', '_self');</script>";
        // echo 'Error! Try Again';
        mysqli_close($conn);
    }
} else {
    $testtypename = $_POST['testtype'];

    if(isset($_POST['testtype_id']) && $_POST['testtype_id'] == ''){
        $sql = 'INSERT INTO `testtype` (`type_nm`) VALUES ("'.$testtypename.'")';
        // echo $sql;
        if($conn->query($sql))
        {
            echo "<script>alert('The data has been uploaded.');window.open('testtype.php', '_self');</script>";
            // echo "<script>alert('The data has been uploaded.');</script>";
            // header("location:testtype.php");
        }
        else
        {
            echo "<script>alert('Error occurred while saving data.');window.open('testtype.php', '_self');</script>";
            // echo 'Error! Try Again';
            mysqli_close($conn);
        }
    } else if(isset($_POST['testtype_id']) && $_POST['testtype_id'] != ''){
        $sql1 = 'UPDATE testtype SET `type_nm` = "'.$testtypename.'" WHERE type_id ='. $_POST['testtype_id'];
        // echo $sql;
        if($conn->query($sql1))
        {
            echo "<script>alert('The data has been uploaded.');window.open('testtype.php', '_self');</script>";
            // echo "<script>alert('The data has been uploaded.');</script>";
            // header("location:testtype.php");
        }
        else
        {
            echo "<script>alert('Error occurred while saving data.');window.open('testtype.php', '_self');</script>";
            // echo 'Error! Try Again';
            mysqli_close($conn);
        }
    }
}
?>