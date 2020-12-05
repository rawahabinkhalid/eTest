<?php

include_once('conn.php');
// include 'php-random-name-generator/randomNameGenerator.php';

if(isset($_GET['delete_user_id'])) {
    $userid =$_GET['delete_user_id'];

    $sql = 'DELETE FROM random WHERE `random_id` = ' . $userid;
    // echo $sql;
    if($conn->query($sql))
    {
        echo "<script>alert('The data has been uploaded.');</script>";
        echo "<script>window.open('randomemployeeslisting.php', '_self');</script>";
        // header("location:randomemployees.php");
    }
    else
    {
        echo 'Error! Try Again';
        mysqli_close($conn);
    }
} else {
    if(isset($_POST['random_id']) && $_POST['random_id'] == '') {
        $sql = 'INSERT INTO `random` (`account_id`,`insert_user_id`,`insert_date`,`comments`) VALUES ('.$_POST['account_id'].',"'.$_SESSION['userid'].'", "'.date('Y-m-d H:i:s').'","Random list generated on '.date('m/d/Y H:i:s').'")';
        // echo $sql;
        if($conn->query($sql)) {
            $random_id = $conn->insert_id;
            // echo "<script>alert('The data has been uploaded.');</script>";
            // header("location:random.php");
            // for($i = 0; $i < intval($_POST['numberToRandomize']); $i++) {
            //     $emp_id = generateRandomString();
            //     $r = new randomNameGenerator('array');
            //     $names = $r->generateNames(1);
            //     $names = $names[0];
            $sqlSelect = 'SELECT * FROM employees WHERE account_id = ' . $_POST['account_id'] . ' ORDER BY RAND() LIMIT ' . intval($_POST['numberToRandomize']);
            // echo $sqlSelect;
            $resultSelect = $conn->query($sqlSelect);
            if($resultSelect->num_rows > 0) {
                while($rowSelect = $resultSelect->fetch_assoc()) {
                    // $sql2 = 'INSERT INTO `employees` (`emp_id`, `account_id`, `division_id`, `first_nm`, `last_nm`, `random_marker`, `status`, `insert_user_id`, `insert_date`) VALUES ("'.$emp_id.'", '.$_POST['account_id'].', "'.$_POST['account_id'].'", "'.$rowSelect['first_nm'].'", "'.$rowSelect['last_nm'].'", "R", "A", "'.$_SESSION['userid'].'", "'.date('Y-m-d H:i:s').'")';
                    // echo $sql2;
                    // if($conn->query($sql2)) {
                        // echo "<script>alert('The data has been uploaded.');</script>";
                    if(!isset($_POST['admin']))
                        $sql = 'INSERT INTO `randomitems` (`random_id`, `account_id`,`emp_id`,`batch_id`) VALUES ('.$random_id.', '.$_POST['account_id'].', "'.$rowSelect['emp_id'].'", 0)';
                    else {
                        $sqlLab = 'SELECT * FROM preferences';
                        $resultLab = $conn->query($sqlLab);
                        $rowLab = $resultLab->fetch_assoc();
                        
                        $sql =
                            'INSERT INTO `test`( `account_id`, `division_id`, `emp_id`, `collection_date`, `reported_date`, `mro_received_date`, `company_id`, `lab_id`, `reason_id`, `result`, `practitioner_id`, `test_date`, `type_id`, `sample_id`, `amount`,  `batch_id`, `insert_user_id`, `form_id`, `other`, `other_nm`, `req_no`) VALUES (' .
                            $_POST['account_id'] .
                            ',' .
                            $_POST['location'] .
                            ',"' .
                            $rowSelect['emp_id'] .
                            '","' .
                            date('Y-m-d') .
                            '","' .
                            date('Y-m-d') .
                            '","' .
                            date('Y-m-d') .
                            '",' .
                            1 .
                            ',' .
                            $rowLab['lab_id'] .
                            ',' .
                            $rowLab['reason_id'] .
                            ',"N",' .
                            $rowLab['practitioner_id'] .
                            ',"' .
                            date('Y-m-d') .
                            '",' .
                            $rowLab['type_id'] .
                            ',' .
                            $rowLab['sample_id'] .
                            ',"' .
                            $amount .
                            '",2,"' .
                            $_SESSION['userid'] .
                            '",' .
                            $_POST['testfromuse'] .
                            ',"' .
                            '","' .
                            '","' .
                            '")';
                            if($conn->query($sql))
                            {
                                $test_id = $conn->insert_id;
                                $sql = 'INSERT INTO `randomitems` (`random_id`, `account_id`,`emp_id`,`test_id`,`batch_id`) VALUES ('.$random_id.', '.$_POST['account_id'].', "'.$rowSelect['emp_id'].'", '.$test_id.', 0)';
                            }        

                    }
                    // echo $sql;
                    if($conn->query($sql))
                    {
                        // echo "<script>alert('The data has been uploaded.');</script>";
                        // header("location:randomemployees.php");
                    }
                    else
                    {
                        echo 'Error! Try Again';
                        mysqli_close($conn);
                    }        
    
                    // } else {
                    //     $i--;
                    //     // echo $conn->error;
                    //     mysqli_close($conn);
                    // }
                }
            }
            // }
        } else {
            echo 'Error! Try Again';
            mysqli_close($conn);
        }
    } else if(isset($_POST['random_id']) && $_POST['random_id'] != ''){
        $sql1 = 'UPDATE random SET `random_id` = "'.$userid.'", `first_nm` = "'.$fname.'", `last_nm` = "'.$lname.'", `password` = "'.$password.'", `admin` = "'.$admin.'" WHERE random_id ="'. $_POST['random_id'].'"';
        // echo $sql;
        if($conn->query($sql1))
        {
            // echo "<script>alert('The data has been uploaded.');</script>";
            // header("location:random.php");
        }
        else
        {
            echo 'Error! Try Again';
            mysqli_close($conn);
        }
    }
}
echo "<script>window.open('randomemployeeslisting.php', '_self');</script>";

// function generateRandomString($length = 10) {
//     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//     $charactersLength = strlen($characters);
//     $randomString = '';
//     for ($i = 0; $i < $length; $i++) {
//         $randomString .= $characters[rand(0, $charactersLength - 1)];
//     }
//     return $randomString;
// }
?>