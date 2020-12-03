<?php

include_once('conn.php');

if(isset($_GET['delete_form_id'])) {
    $form_id =$_GET['delete_form_id'];

    $sql = 'DELETE FROM drugform WHERE `form_id` = ' . $form_id;
    // echo $sql;
    if($conn->query($sql))
    {
        $sql1 = 'DELETE FROM formdrugs WHERE `form_id` = ' . $form_id;
        // echo $sql1;
        if($conn->query($sql1))
        {
            echo "<script>alert('The data has been uploaded.');window.open('form.php', '_self');</script>";
            // echo "<script>alert('The data has been uploaded.');</script>";
            // header("location:testtype.php");
        }
        else
        {
            echo "<script>alert('Error occurred while saving data.');window.open('form.php', '_self');</script>";
            // echo 'Error! Try Again';
            mysqli_close($conn);
        }
    }
    else
    {
        echo "<script>alert('Error occurred while saving data.');window.open('form.php', '_self');</script>";
        // echo 'Error! Try Again';
        mysqli_close($conn);
    }
} else {
    if(isset($_POST['form_id']) && $_POST['form_id'] == ''){
        $error = false;
        $formname = $_POST['formname'];
        $formtype =$_POST['formtype'];
        $drugs =$_POST['drugs'];

        $sql = 'INSERT INTO `drugform` (`form_nm`,`form_type`) VALUES ("'.$formname.'","'.$formtype.'")';
        // echo $sql;
        if($conn->query($sql))
        {
            $id = $conn->insert_id;
            for($i = 0; $i < count($drugs); $i++) {
                $sql1 = 'INSERT INTO `formdrugs` VALUES ('.$id.', '.$drugs[$i].')';
                    if(!$conn->query($sql1)) {
                        $error = true;
                        // echo "<script>alert('Error occurred while saving drugs.');</script>";
                    }
                }
            if(!$error)
                echo "<script>alert('The data has been uploaded.');window.open('form.php', '_self');</script>";
            else
                echo "<script>alert('Error occurred while saving data.');window.open('form.php', '_self');</script>";
            // echo "<script>alert('The data has been uploaded.');</script>";
            // header("location:form.php");
        }
        else
        {
            echo "<script>alert('Error occurred while saving data.');window.open('form.php', '_self');</script>";
            // echo 'Error! Try Again';
            mysqli_close($conn);
        }
    } else if(isset($_POST['form_id']) && $_POST['form_id'] != ''){
        $error = false;

        $form_id = $_POST['form_id'];
        $formname = $_POST['formname'];
        $formtype =$_POST['formtype'];
        $drugs =$_POST['drugs'];
        $sql1 = 'DELETE FROM formdrugs WHERE `form_id` = ' . $form_id;
        // echo $sql1;
        if($conn->query($sql1))
        {
            $sql = 'UPDATE `drugform` SET `form_nm` = "'.$formname.'", `form_type` = "'.$formtype.'" WHERE form_id = ' . $form_id;
            // echo $sql;
            if($conn->query($sql))
            {
                for($i = 0; $i < count($drugs); $i++) {
                    $sql1 = 'INSERT INTO `formdrugs` VALUES ('.$form_id.', '.$drugs[$i].')';
                        if(!$conn->query($sql1)) {
                            $error = true;
                            // echo "<script>alert('Error occurred while saving drugs.');</script>";
                        }
                    }
                    if(!$error)
                        echo "<script>alert('The data has been uploaded.');window.open('form.php', '_self');</script>";
                    else
                        echo "<script>alert('Error occurred while saving data.');window.open('form.php', '_self');</script>";
                    // echo "<script>alert('The data has been uploaded.');</script>";
                    // header("location:form.php");
                }
            else
            {
                echo "<script>alert('Error occurred while saving data.');window.open('form.php', '_self');</script>";
                // echo 'Error! Try Again';
                mysqli_close($conn);
            }
        }
        else
        {
            echo "<script>alert('Error occurred while saving data.');window.open('form.php', '_self');</script>";
            // echo 'Error! Try Again';
            mysqli_close($conn);
        }

    }

}
?>