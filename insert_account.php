<?php

include_once('conn.php');

if(isset($_GET['delete_account_id'])) {
    $account_id =$_GET['delete_account_id'];

    $sql = 'DELETE FROM accounts WHERE `account_id` = ' . $account_id;
    echo $sql;
    if($conn->query($sql))
    {
        echo "<script>alert('The data has been uploaded.');</script>";
        header("location:accounts.php");
    }
    else
    {
        echo 'Error! Try Again';
        mysqli_close($conn);
    }
} else {
    $accountsData = json_decode($_POST['accountsData']);
    // print_r($accountsData);
    if(isset($accountsData->account_id) && $accountsData->account_id == ''){
        $sql = 'INSERT INTO `accounts` (`account_code`, `account_nm`,`ar_funding_code`) VALUES ("'.$accountsData->account_code.'", "'.$accountsData->account_nm.'","'.$accountsData->ar_funding_code.'")';
        // echo $sql;
        if($conn->query($sql)) {
            $account_id = $conn->insert_id;
            for($i = 0; $i < count($accountsData->locations); $i++) {
                $sql1 = 'INSERT INTO `divisions` (`account_id`, `division_nm`, `address`, `city`, `state`, `zip`, `phone`, `fax`, `contact`, `comments`, `email`) VALUES ('.$account_id.', "'.$accountsData->locations[$i]->division_nm.'", "'.$accountsData->locations[$i]->address.'", "'.$accountsData->locations[$i]->city.'", "'.$accountsData->locations[$i]->state.'", "'.$accountsData->locations[$i]->zip.'", "'.$accountsData->locations[$i]->phone.'", "'.$accountsData->locations[$i]->fax.'", "'.$accountsData->locations[$i]->contact.'", "'.$accountsData->locations[$i]->comments.'", "'.$accountsData->locations[$i]->email.'")';
                echo $sql1;
                if($conn->query($sql1)) {
                    echo "<script>alert('The data has been uploaded.');</script>";
                } else {
                    echo $conn->error;
                    mysqli_close($conn);
                }
            }
            for($i = 0; $i < count($accountsData->fees); $i++) {
                $sql2 = 'INSERT INTO `fees` (`account_id`, `type_id`, `amount`) VALUES ('.$account_id.', "'.$accountsData->fees[$i]->type_id.'", "'.$accountsData->fees[$i]->amount.'")';
                echo $sql2;
                if($conn->query($sql2)) {
                    echo "<script>alert('The data has been uploaded.');</script>";
                } else {
                    echo $conn->error;
                    mysqli_close($conn);
                }
            }
            for($i = 0; $i < count($accountsData->employees); $i++) {
                $sql3 = 'SELECT * FROM divisions WHERE account_id = ' . $account_id . ' AND division_nm = "' . $accountsData->employees[$i]->division_id . '"';
                $result3 = $conn->query($sql3);
                if($result3->num_rows > 0) {
                    $row3 = $result3->fetch_assoc();
                    $sql2 = 'INSERT INTO `employees` (`emp_id`, `account_id`, `division_id`, `first_nm`, `last_nm`, `random_marker`, `status`, `insert_user_id`, `insert_date`) VALUES ("'.$accountsData->employees[$i]->emp_id.'", '.$account_id.', "'.$row3['division_id'].'", "'.$accountsData->employees[$i]->first_nm.'", "'.$accountsData->employees[$i]->last_nm.'", "'.$accountsData->employees[$i]->random_marker.'", "'.$accountsData->employees[$i]->status.'", "'.$_SESSION['userid'].'", "'.date('Y-m-d H:i:s').'")';
                    echo $sql2;
                    if($conn->query($sql2)) {
                        echo "<script>alert('The data has been uploaded.');</script>";
                    } else {
                        echo $conn->error;
                        mysqli_close($conn);
                    }
                }
            }
        } else {
            echo $conn->error;
            mysqli_close($conn);
        }
    } else if(isset($accountsData->account_id) && $accountsData->account_id != ''){
        $sql = 'UPDATE `accounts` SET `account_code` = "'.$accountsData->account_code.'", `account_nm` = "'.$accountsData->account_nm.'", `ar_funding_code` = "'.$accountsData->ar_funding_code.'"  WHERE account_id ='.$accountsData->account_id;
        // echo $sql;
        if($conn->query($sql))
        {
            $account_id = $accountsData->account_id;
            $sqlDel1 = 'DELETE FROM `divisions` WHERE `account_id` = ' . $account_id;
            if($conn->query($sqlDel1))
            {
                $sqlDel2 = 'DELETE FROM `fees` WHERE `account_id` = ' . $account_id;
                if($conn->query($sqlDel2))
                {
                    $sqlDel3 = 'DELETE FROM `employees` WHERE `account_id` = ' . $account_id;
                    if($conn->query($sqlDel3))
                    {
                        for($i = 0; $i < count($accountsData->locations); $i++) {
                            $sql1 = 'INSERT INTO `divisions` (`account_id`, `division_nm`, `address`, `city`, `state`, `zip`, `phone`, `fax`, `contact`, `comments`, `email`) VALUES ('.$account_id.', "'.$accountsData->locations[$i]->division_nm.'", "'.$accountsData->locations[$i]->address.'", "'.$accountsData->locations[$i]->city.'", "'.$accountsData->locations[$i]->state.'", "'.$accountsData->locations[$i]->zip.'", "'.$accountsData->locations[$i]->phone.'", "'.$accountsData->locations[$i]->fax.'", "'.$accountsData->locations[$i]->contact.'", "'.$accountsData->locations[$i]->comments.'", "'.$accountsData->locations[$i]->email.'")';
                            echo $sql1;
                            if($conn->query($sql1)) {
                                echo "<script>alert('The data has been uploaded.');</script>";
                            } else {
                                echo $conn->error;
                                mysqli_close($conn);
                            }
                        }
                        for($J = 0; $J < count($accountsData->fees); $J++) {
                            $sql2 = 'INSERT INTO `fees` (`account_id`, `type_id`, `amount`) VALUES ('.$account_id.', "'.$accountsData->fees[$J]->type_id.'", "'.$accountsData->fees[$J]->amount.'")';
                            echo $sql2;
                            if($conn->query($sql2)) {
                                echo "<script>alert('The data has been uploaded.');</script>";
                            } else {
                                echo $conn->error;
                                mysqli_close($conn);
                            }
                        }
                        for($K = 0; $K < count($accountsData->employees); $K++) {
                            $sql3 = 'SELECT * FROM divisions WHERE account_id = ' . $account_id . ' AND division_nm = "' . $accountsData->employees[$K]->division_id . '"';
                            $result3 = $conn->query($sql3);
                            if($result3->num_rows > 0) {
                                $row3 = $result3->fetch_assoc();
                                $sql2 = 'INSERT INTO `employees` (`emp_id`, `account_id`, `division_id`, `first_nm`, `last_nm`, `random_marker`, `status`, `insert_user_id`, `insert_date`) VALUES ("'.$accountsData->employees[$K]->emp_id.'", '.$account_id.', "'.$row3['division_id'].'", "'.$accountsData->employees[$K]->first_nm.'", "'.$accountsData->employees[$K]->last_nm.'", "", "'.$accountsData->employees[$K]->status.'", "'.$_SESSION['userid'].'", "'.date('Y-m-d H:i:s').'")';
                                echo $sql2;
                                if($conn->query($sql2)) {
                                    echo "<script>alert('The data has been uploaded.');</script>";
                                } else {
                                    echo $conn->error;
                                    mysqli_close($conn);
                                }
                            }
                        }
                    } else {
                        echo $conn->error;
                        mysqli_close($conn);
                    }
                } else {
                    echo $conn->error;
                    mysqli_close($conn);
                }
            } else {
                echo $conn->error;
                mysqli_close($conn);
            }
        } else {
            echo $conn->error;
            mysqli_close($conn);
        }
    }
}
?>