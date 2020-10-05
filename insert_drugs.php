<?php

include_once('conn.php');

if(isset($_GET['delete_drug_id'])) {
    $drug_id =$_GET['delete_drug_id'];

    $sql = 'DELETE FROM drugs WHERE `drug_id` = ' . $drug_id;
    echo $sql;
    if($conn->query($sql))
    {
        echo "<script>alert('The data has been uploaded.');</script>";
        header("location:testtype.php");
    }
    else
    {
        echo 'Error! Try Again';
        mysqli_close($conn);
    }
    } else {
    $drugname = $_POST['drugname'];

    if(isset($_POST['drugs_id']) && $_POST['drugs_id'] == ''){
        $sql = 'INSERT INTO `drugs` (`drug_nm`) VALUES ("'.$drugname.'")';
        // echo $sql;
        if($conn->query($sql))
        {
            echo "<script>alert('The data has been uploaded.');</script>";
            header("location:drugs.php");
        }
        else
        {
            echo 'Error! Try Again';
            mysqli_close($conn);
        }
    } else if(isset($_POST['drugs_id']) && $_POST['drugs_id'] != ''){
        $sql = 'UPDATE `drugs` SET `drug_nm` = "'.$drugname.'" WHERE drug_id ='.$_POST['drugs_id'];
        // echo $sql;
        if($conn->query($sql))
        {
            echo "<script>alert('The data has been uploaded.');</script>";
            header("location:drugs.php");
        }
        else
        {
            echo 'Error! Try Again';
            mysqli_close($conn);
        }
    }
}
?>