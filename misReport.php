<?php
include_once "conn.php";
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>eTest</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <style>
        label {
            /* Other styling... */
            text-align: right;
            clear: both;
            float: left;
            margin-right: 15px;
        }

        
    </style>

<style>@media print{@page {size: landscape !important}}
            @media print {
body {transform: scale(.9);}
table {page-break-inside: avoid;}
			table {width: 100%;font: 12px Calibri;}
			table, th, td {border: solid 1px #DDD; border-collapse: collapse;@page {
                size: landscape;
}}
			padding: 2px 3px;text-align: left;}
			a {color: black;} tfoot {position: static; bottom: 20px; left: 0px; width: 100%; background: gray;}
			</style>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to to the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

<body class="sidebar-mini layout-fixed sidebar-expand">
    <div class="wrapper landscape" id='printMe'>
        <br>
        <div class="row">
            <div class="col-md-1 col-lg-1 col-xl-1"></div>
            <div class="col-md-5 col-lg-5 col-xl-5">
                <h2>Drug Testing Report</h2>
            </div>
            <div class="col-md-3 col-lg-3 col-xl-3"></div>
            <div class="col-md-3 col-lg-3 col-xl-3">
                <h2>RN Expertise, Inc.</h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-3">
                <h5>Company Wide Results</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-3">
                <h5><span style="font-size: 0.65em;">For samples collected from</span></h5>
            </div>
        </div>
        <hr>
        <br>
        <?php
        $companyCityState = '';
        $companyPhone = '';
        $sqlCompany = 'SELECT * FROM company ORDER BY company_id DESC LIMIT 1';
        $resultCompany = $conn->query($sqlCompany);
        if ($resultCompany->num_rows > 0) {
            $rowCompany = $resultCompany->fetch_assoc();
            $companyCityState = $rowCompany['city'] . ', ';
            $companyCityState .= $rowCompany['state'] . ' ';
            $companyCityState .= $rowCompany['zip'];

            $companyPhone = $rowCompany['phone'];
            $companyPhone .= '&emsp;&emsp;Fax: ' . $rowCompany['fax'];
        }
        $accountCityState = '';
        $accountPhone = '';
        $sqlAccount = 'SELECT * FROM accounts JOIN divisions ON divisions.account_id = accounts.account_id WHERE accounts.account_id = ' . $_GET['account'] . '';
        $resultAccount = $conn->query($sqlAccount);
        if ($resultAccount->num_rows > 0) {
            $rowAccount = $resultAccount->fetch_assoc();

            $accountCityState = $rowAccount['city'] . ', ';
            $accountCityState .= $rowAccount['state'] . ' ';
            $accountCityState .= $rowAccount['zip'];

            $accountPhone = $rowAccount['phone'];
            $accountPhone .= '&emsp;&emsp;Fax: ' . $rowAccount['fax'];
        }
        // $sqlAccount = 'SELECT * FROM accounts WHERE account_id = ' . $_GET['account'] . '';
        // $resultAccount = $conn->query($sqlAccount);
        // if ($resultAccount->num_rows > 0) {
        //     $rowAccount = $resultAccount->fetch_assoc();
        // }

        ?>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-4"><span><b><?php echo (isset($rowCompany['company_nm'])) ? $rowCompany['company_nm'] : ''; ?></b></span></div>
            <div class="col-md-4"></div>
            <div class="col-md-3"><span><b><?php echo (isset($rowAccount['account_nm'])) ? $rowAccount['account_nm'] : ''; ?></b></span></div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-3"><span><?php echo (isset($rowCompany['address'])) ? $rowCompany['address'] : ''; ?></span></div>
            <div class="col-md-5"></div>
            <div class="col-md-3"><span><?php echo (isset($rowAccount['contact'])) ? "ATTN: " . $rowAccount['contact'] : ''; ?></span></div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-3"><span><?php echo (isset($companyCityState)) ? $companyCityState : ''; ?></span></div>
            <div class="col-md-5"></div>
            <div class="col-md-3"><span><?php echo (isset($rowAccount['address'])) ? $rowAccount['address'] : ''; ?></span></div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-3"><span><?php echo (isset($companyPhone)) ? $companyPhone : ''; ?></span></div>
            <div class="col-md-5"></div>
            <div class="col-md-3"><span><?php echo (isset($accountCityState)) ? $accountCityState : ''; ?></span></div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-3"></div>
            <div class="col-md-5"></div>
            <div class="col-md-3"><span><?php echo (isset($accountPhone)) ? $accountPhone : ''; ?></span></div>
        </div>
        <br>
        <br>
        <!-- <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <h4><b>Results</b></h4>
            </div>
        </div>
        <hr> -->

        <div class="row">
            <div class="container">
                <table id="" style="width:100%">
                    <thead>
                        <tr>
                            <th>Summary</th>
                            <?php
                            $sqlReason = 'SELECT DISTINCT(reasons.reason_code) AS reason_code FROM `test` JOIN `reasons` ON reasons.reason_id = test.reason_id WHERE account_id = ' . $_GET['account'] . ' ORDER BY reason_code';
                            $resultReason = $conn->query($sqlReason);
                            if ($resultReason->num_rows > 0) {
                                while ($rowReason = $resultReason->fetch_assoc()) {
                                    echo '<th>' . $rowReason['reason_code'] . '</th>';
                                }
                            }
                            ?>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b>Negative</b></td>
                            <?php
                            $sqlReason = 'SELECT DISTINCT(reasons.reason_code), reasons.reason_id FROM `test` JOIN `reasons` ON reasons.reason_id = test.reason_id WHERE account_id = ' . $_GET['account'] . ' ORDER BY reason_code';
                            $resultReason = $conn->query($sqlReason);
                            if ($resultReason->num_rows > 0) {
                                while ($rowReason = $resultReason->fetch_assoc()) {
                                    $sqlReason1 = 'SELECT COUNT(test_id) FROM `test` WHERE account_id = ' . $_GET['account'] . ' AND reason_id = ' . $rowReason['reason_id'] . ' AND result = "N" GROUP BY account_id,reason_id';
                                    // echo $sqlReason1;
                                    $resultReason1 = $conn->query($sqlReason1);
                                    if ($resultReason1->num_rows > 0) {
                                        while ($rowReason1 = $resultReason1->fetch_assoc()) {
                                            echo '<th>' . $rowReason1['COUNT(test_id)'] . '</th>';
                                        }
                                    } else {
                                        echo '<th></th>';
                                    }
                                }
                            }


                            $sqlReason1 = 'SELECT COUNT(test_id) FROM `test` WHERE account_id = ' . $_GET['account'] . ' AND result = "N" GROUP BY account_id';
                            // echo $sqlReason1;
                            $resultReason1 = $conn->query($sqlReason1);
                            if ($resultReason1->num_rows > 0) {
                                while ($rowReason1 = $resultReason1->fetch_assoc()) {
                                    echo '<th style="background: rgba(0, 0, 0, .2);">' . $rowReason1['COUNT(test_id)'] . '</th>';
                                }
                            }
                            ?>

                        </tr>
                        <tr>
                            <td><b>Positive</b></td>
                            <?php
                            $sqlReason = 'SELECT DISTINCT(reasons.reason_code), reasons.reason_id FROM `test` JOIN `reasons` ON reasons.reason_id = test.reason_id WHERE account_id = ' . $_GET['account'] . ' ORDER BY reason_code';
                            $resultReason = $conn->query($sqlReason);
                            if ($resultReason->num_rows > 0) {
                                while ($rowReason = $resultReason->fetch_assoc()) {
                                    $sqlReason1 = 'SELECT COUNT(test_id) FROM `test` WHERE account_id = ' . $_GET['account'] . ' AND reason_id = ' . $rowReason['reason_id'] . ' AND result = "P" GROUP BY account_id,reason_id';
                                    // echo $sqlReason1;
                                    $resultReason1 = $conn->query($sqlReason1);
                                    if ($resultReason1->num_rows > 0) {
                                        while ($rowReason1 = $resultReason1->fetch_assoc()) {
                                            echo '<th>' . $rowReason1['COUNT(test_id)'] . '</th>';
                                        }
                                    } else {
                                        echo '<th></th>';
                                    }
                                }
                            }


                            $sqlReason1 = 'SELECT COUNT(test_id) FROM `test` WHERE account_id = ' . $_GET['account'] . ' AND result = "P" GROUP BY account_id';
                            // echo $sqlReason1;
                            $resultReason1 = $conn->query($sqlReason1);
                            if ($resultReason1->num_rows > 0) {
                                while ($rowReason1 = $resultReason1->fetch_assoc()) {
                                    echo '<th style="background: rgba(0, 0, 0, .2);">' . $rowReason1['COUNT(test_id)'] . '</th>';
                                }
                            } else {
                                echo '<th style="background: rgba(0, 0, 0, .2);">0</th>';
                            }
                            ?>
                        </tr>
                        <tr style="background: rgba(0, 0, 0, .2);">
                            <td style="text-align: right"><b>Grand Total</b></td>
                            <?php
                            $sqlReason = 'SELECT DISTINCT(reasons.reason_code), reasons.reason_id FROM `test` JOIN `reasons` ON reasons.reason_id = test.reason_id WHERE account_id = ' . $_GET['account'] . ' ORDER BY reason_code';
                            $resultReason = $conn->query($sqlReason);
                            if ($resultReason->num_rows > 0) {
                                while ($rowReason = $resultReason->fetch_assoc()) {
                                    $sqlReason1 = 'SELECT COUNT(test_id) FROM `test` WHERE account_id = ' . $_GET['account'] . ' AND reason_id = ' . $rowReason['reason_id'] . ' GROUP BY account_id,reason_id';
                                    // echo $sqlReason1;
                                    $resultReason1 = $conn->query($sqlReason1);
                                    if ($resultReason1->num_rows > 0) {
                                        while ($rowReason1 = $resultReason1->fetch_assoc()) {
                                            echo '<th>' . $rowReason1['COUNT(test_id)'] . '</th>';
                                        }
                                    } else {
                                        echo '<th></th>';
                                    }
                                }
                            }

                            $sqlReason1 = 'SELECT COUNT(test_id) FROM `test` WHERE account_id = ' . $_GET['account'] . ' GROUP BY account_id';
                            // echo $sqlReason1;
                            $resultReason1 = $conn->query($sqlReason1);
                            if ($resultReason1->num_rows > 0) {
                                while ($rowReason1 = $resultReason1->fetch_assoc()) {
                                    echo '<th style="background: rgba(0, 0, 0, .2);">' . $rowReason1['COUNT(test_id)'] . '</th>';
                                }
                            } else {
                                echo '<th style="background: rgba(0, 0, 0, .2);">0</th>';
                            }
                            ?>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <br>
        <br>

        <div class="row">
            <div class="container">
                <table id="" style="width:100%">
                    <thead>
                        <tr>
                            <th>Refusal Details</th>
                            <?php
                            $sqlReason = 'SELECT DISTINCT(reasons.reason_code) AS reason_code FROM `test` JOIN `reasons` ON reasons.reason_id = test.reason_id WHERE account_id = ' . $_GET['account'] . ' ORDER BY reason_code';
                            $resultReason = $conn->query($sqlReason);
                            if ($resultReason->num_rows > 0) {
                                while ($rowReason = $resultReason->fetch_assoc()) {
                                    echo '<th>' . $rowReason['reason_code'] . '</th>';
                                }
                            }
                            ?>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><b>Adulterated</b></td>
                            <?php
                            $sqlReason = 'SELECT DISTINCT(reasons.reason_code), reasons.reason_id FROM `test` JOIN `reasons` ON reasons.reason_id = test.reason_id WHERE account_id = ' . $_GET['account'] . ' ORDER BY reason_code';
                            $resultReason = $conn->query($sqlReason);
                            if ($resultReason->num_rows > 0) {
                                while ($rowReason = $resultReason->fetch_assoc()) {
                                    $sqlReason1 = 'SELECT COUNT(DISTINCT(test_id)) FROM `test` JOIN formdrugs ON formdrugs.form_id = test.form_id JOIN drugs ON drugs.drug_id = formdrugs.drug_id WHERE account_id = ' . $_GET['account'] . ' AND reason_id = ' . $rowReason['reason_id'] . ' AND drug_nm = "Adulterated" AND result = "P" GROUP BY account_id,reason_id,drug_nm';
                                    // echo $sqlReason1;
                                    $resultReason1 = $conn->query($sqlReason1);
                                    if ($resultReason1->num_rows > 0) {
                                        while ($rowReason1 = $resultReason1->fetch_assoc()) {
                                            echo '<th>' . $rowReason1['COUNT(DISTINCT(test_id))'] . '</th>';
                                        }
                                    } else {
                                        echo '<th>0</th>';
                                    }
                                }
                            }

                            $sqlReason1 = 'SELECT COUNT(DISTINCT(test_id)) FROM `test` JOIN formdrugs ON formdrugs.form_id = test.form_id JOIN drugs ON drugs.drug_id = formdrugs.drug_id WHERE account_id = ' . $_GET['account'] . ' AND drug_nm = "Adulterated" AND result = "P" GROUP BY account_id,drug_nm';
                            // echo $sqlReason1;
                            $resultReason1 = $conn->query($sqlReason1);
                            if ($resultReason1->num_rows > 0) {
                                while ($rowReason1 = $resultReason1->fetch_assoc()) {
                                    echo '<th style="background: rgba(0, 0, 0, .2);">' . $rowReason1['COUNT(DISTINCT(test_id))'] . '</th>';
                                }
                            } else {
                                echo '<th style="background: rgba(0, 0, 0, .2);">0</th>';
                            }
                            ?>

                        </tr>
                        <tr>
                            <td><b>DidNotProvideSample</b></td>
                            <?php
                            $sqlReason = 'SELECT DISTINCT(reasons.reason_code), reasons.reason_id FROM `test` JOIN `reasons` ON reasons.reason_id = test.reason_id WHERE account_id = ' . $_GET['account'] . ' ORDER BY reason_code';
                            $resultReason = $conn->query($sqlReason);
                            if ($resultReason->num_rows > 0) {
                                while ($rowReason = $resultReason->fetch_assoc()) {
                                    $sqlReason1 = 'SELECT COUNT(DISTINCT(test_id)) FROM `test` JOIN formdrugs ON formdrugs.form_id = test.form_id JOIN drugs ON drugs.drug_id = formdrugs.drug_id WHERE account_id = ' . $_GET['account'] . ' AND reason_id = ' . $rowReason['reason_id'] . ' AND drug_nm = "DidNotProvideSample" AND result = "P" GROUP BY account_id,reason_id,drug_nm';
                                    // echo $sqlReason1;
                                    $resultReason1 = $conn->query($sqlReason1);
                                    if ($resultReason1->num_rows > 0) {
                                        while ($rowReason1 = $resultReason1->fetch_assoc()) {
                                            echo '<th>' . $rowReason1['COUNT(DISTINCT(test_id))'] . '</th>';
                                        }
                                    } else {
                                        echo '<th>0</th>';
                                    }
                                }
                            }

                            $sqlReason1 = 'SELECT COUNT(DISTINCT(test_id)) FROM `test` JOIN formdrugs ON formdrugs.form_id = test.form_id JOIN drugs ON drugs.drug_id = formdrugs.drug_id WHERE account_id = ' . $_GET['account'] . ' AND drug_nm = "DidNotProvideSample" AND result = "P" GROUP BY account_id,drug_nm';
                            // echo $sqlReason1;
                            $resultReason1 = $conn->query($sqlReason1);
                            if ($resultReason1->num_rows > 0) {
                                while ($rowReason1 = $resultReason1->fetch_assoc()) {
                                    echo '<th style="background: rgba(0, 0, 0, .2);">' . $rowReason1['COUNT(DISTINCT(test_id))'] . '</th>';
                                }
                            } else {
                                echo '<th style="background: rgba(0, 0, 0, .2);">0</th>';
                            }
                            ?>

                        </tr>
                        <tr>
                            <td><b>Substituted</b></td>
                            <?php
                            $sqlReason = 'SELECT DISTINCT(reasons.reason_code), reasons.reason_id FROM `test` JOIN `reasons` ON reasons.reason_id = test.reason_id WHERE account_id = ' . $_GET['account'] . ' ORDER BY reason_code';
                            $resultReason = $conn->query($sqlReason);
                            if ($resultReason->num_rows > 0) {
                                while ($rowReason = $resultReason->fetch_assoc()) {
                                    $sqlReason1 = 'SELECT COUNT(DISTINCT(test_id)) FROM `test` JOIN formdrugs ON formdrugs.form_id = test.form_id JOIN drugs ON drugs.drug_id = formdrugs.drug_id WHERE account_id = ' . $_GET['account'] . ' AND reason_id = ' . $rowReason['reason_id'] . ' AND drug_nm = "Substituted" AND result = "P" GROUP BY account_id,reason_id,drug_nm';
                                    // echo $sqlReason1;
                                    $resultReason1 = $conn->query($sqlReason1);
                                    if ($resultReason1->num_rows > 0) {
                                        while ($rowReason1 = $resultReason1->fetch_assoc()) {
                                            echo '<th>' . $rowReason1['COUNT(DISTINCT(test_id))'] . '</th>';
                                        }
                                    } else {
                                        echo '<th>0</th>';
                                    }
                                }
                            }

                            $sqlReason1 = 'SELECT COUNT(DISTINCT(test_id)) FROM `test` JOIN formdrugs ON formdrugs.form_id = test.form_id JOIN drugs ON drugs.drug_id = formdrugs.drug_id WHERE account_id = ' . $_GET['account'] . ' AND drug_nm = "Substituted" AND result = "P" GROUP BY account_id,drug_nm';
                            // echo $sqlReason1;
                            $resultReason1 = $conn->query($sqlReason1);
                            if ($resultReason1->num_rows > 0) {
                                while ($rowReason1 = $resultReason1->fetch_assoc()) {
                                    echo '<th style="background: rgba(0, 0, 0, .2);">' . $rowReason1['COUNT(DISTINCT(test_id))'] . '</th>';
                                }
                            } else {
                                echo '<th style="background: rgba(0, 0, 0, .2);">0</th>';
                            }
                            ?>

                        </tr>
                        <tr style="background: rgba(0, 0, 0, .2);">
                            <td style="text-align: right"><b>Grand Total</b></td>
                            <?php
                            $sqlReason = 'SELECT DISTINCT(reasons.reason_code), reasons.reason_id FROM `test` JOIN `reasons` ON reasons.reason_id = test.reason_id WHERE account_id = ' . $_GET['account'] . ' ORDER BY reason_code';
                            $resultReason = $conn->query($sqlReason);
                            if ($resultReason->num_rows > 0) {
                                while ($rowReason = $resultReason->fetch_assoc()) {
                                    $sqlReason1 = 'SELECT COUNT(DISTINCT(test_id)) FROM `test` JOIN formdrugs ON formdrugs.form_id = test.form_id JOIN drugs ON drugs.drug_id = formdrugs.drug_id WHERE account_id = ' . $_GET['account'] . ' AND reason_id = ' . $rowReason['reason_id'] . ' AND (drug_nm = "Adulterated" OR drug_nm = "DidNotProvideSample" OR drug_nm = "Substituted") AND result = "P" GROUP BY account_id,reason_id,drug_nm';
                                    // echo $sqlReason1;
                                    $resultReason1 = $conn->query($sqlReason1);
                                    if ($resultReason1->num_rows > 0) {
                                        while ($rowReason1 = $resultReason1->fetch_assoc()) {
                                            echo '<th>' . $rowReason1['COUNT(test_id)'] . '</th>';
                                        }
                                    } else {
                                        echo '<th>0</th>';
                                    }
                                }
                            }

                            $sqlReason1 = 'SELECT COUNT(DISTINCT(test_id)) FROM `test` JOIN formdrugs ON formdrugs.form_id = test.form_id JOIN drugs ON drugs.drug_id = formdrugs.drug_id WHERE account_id = ' . $_GET['account'] . ' AND (drug_nm = "Adulterated" OR drug_nm = "DidNotProvideSample" OR drug_nm = "Substituted") AND result = "P" GROUP BY account_id';
                            // echo $sqlReason1;
                            $resultReason1 = $conn->query($sqlReason1);
                            if ($resultReason1->num_rows > 0) {
                                while ($rowReason1 = $resultReason1->fetch_assoc()) {
                                    echo '<th>' . $rowReason1['COUNT(DISTINCT(test_id))'] . '</th>';
                                }
                            } else {
                                echo '<th>0</th>';
                            }
                            ?>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <br>
        <br>
        <div class="row">
            <div class="container">
                <table id="" style="width:100%">
                    <thead>
                        <tr>
                            <th>Positive Details</th>
                            <?php
                            $sqlReason = 'SELECT DISTINCT(reasons.reason_code) AS reason_code FROM `test` JOIN `reasons` ON reasons.reason_id = test.reason_id WHERE account_id = ' . $_GET['account'] . ' ORDER BY reason_code';
                            $resultReason = $conn->query($sqlReason);
                            if ($resultReason->num_rows > 0) {
                                while ($rowReason = $resultReason->fetch_assoc()) {
                                    echo '<th>' . $rowReason['reason_code'] . '</th>';
                                }
                            }
                            ?>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sqlDrugs = 'SELECT DISTINCT(drugs.drug_nm) AS drug_nm FROM `test` JOIN formdrugs ON formdrugs.form_id = test.form_id JOIN drugs ON drugs.drug_id = formdrugs.drug_id JOIN `reasons` ON reasons.reason_id = test.reason_id WHERE account_id = ' . $_GET['account'] . ' ORDER BY drug_nm';
                        $resultDrugs = $conn->query($sqlDrugs);
                        if ($resultDrugs->num_rows > 0) {
                            while ($rowDrugs = $resultDrugs->fetch_assoc()) {

                        ?>
                                <tr>
                                    <td><b>
                                            <? echo $rowDrugs['drug_nm']; ?>
                                        </b></td>
                                    <?php
                                    $sqlReason = 'SELECT DISTINCT(reasons.reason_code), reasons.reason_id FROM `test` JOIN `reasons` ON reasons.reason_id = test.reason_id WHERE account_id = ' . $_GET['account'] . ' ORDER BY reason_code';
                                    $resultReason = $conn->query($sqlReason);
                                    if ($resultReason->num_rows > 0) {
                                        while ($rowReason = $resultReason->fetch_assoc()) {
                                            $sqlReason1 = 'SELECT COUNT(DISTINCT(test_id)) FROM `test` JOIN formdrugs ON formdrugs.form_id = test.form_id JOIN drugs ON drugs.drug_id = formdrugs.drug_id WHERE account_id = ' . $_GET['account'] . ' AND reason_id = ' . $rowReason['reason_id'] . ' AND drug_nm = "' . $rowDrugs['drug_nm'] . '" AND result = "P" GROUP BY account_id,reason_id,drug_nm';
                                            // echo $sqlReason1;
                                            $resultReason1 = $conn->query($sqlReason1);
                                            if ($resultReason1->num_rows > 0) {
                                                while ($rowReason1 = $resultReason1->fetch_assoc()) {
                                                    echo '<th>' . $rowReason1['COUNT(DISTINCT(test_id))'] . '</th>';
                                                }
                                            } else {
                                                echo '<th>0</th>';
                                            }
                                        }
                                    }



                                    $sqlReason1 = 'SELECT COUNT(DISTINCT(test_id)) FROM `test` JOIN formdrugs ON formdrugs.form_id = test.form_id JOIN drugs ON drugs.drug_id = formdrugs.drug_id WHERE account_id = ' . $_GET['account'] . ' AND drug_nm = "' . $rowDrugs['drug_nm'] . '" AND result = "P" GROUP BY account_id,drug_nm';
                                    // echo $sqlReason1;
                                    $resultReason1 = $conn->query($sqlReason1);
                                    if ($resultReason1->num_rows > 0) {
                                        while ($rowReason1 = $resultReason1->fetch_assoc()) {
                                            echo '<th style="background: rgba(0, 0, 0, .2);">' . $rowReason1['COUNT(DISTINCT(test_id))'] . '</th>';
                                        }
                                    } else {
                                        echo '<th style="background: rgba(0, 0, 0, .2);">0</th>';
                                    }
                                    ?>

                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="container">
                <h3>LEGEND</h3>
                <hr>
                <div class="row">
                    <?php
                    $sqlReason = 'SELECT DISTINCT(reasons.reason_code) AS reason_code, reasons.reason_nm FROM `test` JOIN `reasons` ON reasons.reason_id = test.reason_id WHERE account_id = ' . $_GET['account'] . ' ORDER BY reason_code';
                    $resultReason = $conn->query($sqlReason);
                    if ($resultReason->num_rows > 0) {
                        while ($rowReason = $resultReason->fetch_assoc()) {
                            echo '<div class="col-md-1"><b>' . $rowReason['reason_code'] . '</b></div><div class="col-md-3">' . $rowReason['reason_nm'] . '</div>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <!-- ./wrapper -->
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-2"><button class="btn btn-info" onclick="printDiv('printMe')">Print </button></div>
    </div>


    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <!-- <script src="dist/js/adminlte.js"></script> -->

    <!-- OPTIONAL SCRIPTS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="dist/js/pages/dashboard3.js"></script>
    <script>
        function printDiv(divName) {
            // var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            // document.body.innerHTML = printContents;

            // window.print();

            document.body.innerHTML = originalContents;






    
			var sTable = '<link rel="stylesheet" href="dist/css/adminlte.min.css">';
			// if (document.getElementsByName('partyNameMain')[0].value != '') {
			// 	sTable += '<span style="font-weight: bold;">Client: ' + document.getElementsByName('partyNameMain')[0].value + '</span><br><br>';
			// 	$('table tr').find('td:eq(2),th:eq(2)').css('display', 'none');
            //     // console.log($('table tr').find('td:eq(2),th:eq(2)'));
			// }
			// $('table tr').find('td:eq(5),th:eq(5)').css('display', 'none');

			sTable += document.getElementById(divName).innerHTML;

            var style = "<style>@media print{@page {size: landscape !important}}\
            @media print {\
body {zoom: 80%;}\
            ";
			style = style + "table {width: 100%;font: 12px Calibri;}";
			style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;@page {   \
                size: landscape;                                                                \
}}\
";
			style = style + "padding: 2px 3px;text-align: left;}";
			style = style + "a {color: black;} tfoot {position: static; bottom: 20px; left: 0px; width: 100%; background: gray;}";
			style = style + "</style>";

			// CREATE A WINDOW OBJECT.
			var win = window.open('', '', '');
			win.document.write('<span style="text-align: center;"><h1></h1></span>');
			win.document.write('<html><head>');
			win.document.write('<title>MIS Report</title>'); // <title> FOR PDF HEADER.
			win.document.write(style); // ADD STYLE INSIDE THE HEAD TAG.
			win.document.write('</head>');
			win.document.write('<body>');
			win.document.write(sTable); // THE TABLE CONTENTS INSIDE THE BODY TAG.
			win.document.write('</body></html>');

			win.document.close(); // CLOSE THE CURRENT WINDOW.

			setTimeout(() => {
				win.print(); // PRINT THE CONTENTS.
			}, 500);
        }
    </script>
</body>

</html>