<?php

include_once('conn.php');
include 'php-random-name-generator/randomNameGenerator.php';

if(isset($_GET['delete_user_id'])) {
    $userid =$_GET['delete_user_id'];

    $sql = 'DELETE FROM random WHERE `random_id` = ' . $userid;
    // echo $sql;
    if($conn->query($sql))
    {
        echo "<script>alert('The data has been uploaded.');</script>";
        header("location:randomemployees.php");
    }
    else
    {
        echo 'Error! Try Again';
        mysqli_close($conn);
    }
} else {
    if(isset($_POST['random_id']) && $_POST['random_id'] == ''){
        $sql = 'INSERT INTO `random` (`account_id`,`insert_user_id`,`insert_date`,`comments`) VALUES ('.$_POST['account_id'].',"'.$_SESSION['userid'].'", "'.date('Y-m-d H:i:s').'","Random list generated on '.date('m/d/Y H:i:s').'")';
        // echo $sql;
        if($conn->query($sql)) {
            $random_id = $conn->insert_id;
            // echo "<script>alert('The data has been uploaded.');</script>";
            // header("location:random.php");
            for($i = 0; $i < intval($_POST['numberToRandomize']); $i++) {
                $emp_id = generateRandomString();
                $r = new randomNameGenerator('array');
                $names = $r->generateNames(1);
                $names = $names[0];

                $sql2 = 'INSERT INTO `employees` (`emp_id`, `account_id`, `division_id`, `first_nm`, `last_nm`, `random_marker`, `status`, `insert_user_id`, `insert_date`) VALUES ("'.$emp_id.'", '.$_POST['account_id'].', "'.$_POST['account_id'].'", "'.explode(' ', $names)[0].'", "'.explode(' ', $names)[1].'", "R", "A", "'.$_SESSION['userid'].'", "'.date('Y-m-d H:i:s').'")';
                // echo $sql2;
                if($conn->query($sql2)) {
                    // echo "<script>alert('The data has been uploaded.');</script>";
                    $sql = 'INSERT INTO `randomitems` (`random_id`, `account_id`,`emp_id`,`test_id`,`batch_id`) VALUES ('.$random_id.', '.$_POST['account_id'].', "'.$emp_id.'", '.$_POST['testfromuse'].', 0)';
                    // echo $sql;
                    if($conn->query($sql))
                    {
                        echo "<script>alert('The data has been uploaded.');</script>";
                        header("location:randomemployees.php");
                    }
                    else
                    {
                        echo 'Error! Try Again';
                        mysqli_close($conn);
                    }        

                } else {
                    $i--;
                    // echo $conn->error;
                    mysqli_close($conn);
                }
            }
        } else {
            echo 'Error! Try Again';
            mysqli_close($conn);
        }
    } else if(isset($_POST['random_id']) && $_POST['random_id'] != ''){
        $sql1 = 'UPDATE random SET `random_id` = "'.$userid.'", `first_nm` = "'.$fname.'", `last_nm` = "'.$lname.'", `password` = "'.$password.'", `admin` = "'.$admin.'" WHERE random_id ="'. $_POST['random_id'].'"';
        // echo $sql;
        if($conn->query($sql1))
        {
            echo "<script>alert('The data has been uploaded.');</script>";
            header("location:random.php");
        }
        else
        {
            echo 'Error! Try Again';
            mysqli_close($conn);
        }
    }
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
?>