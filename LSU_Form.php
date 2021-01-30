<?php
include_once '../conn.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>LSU Form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
    #form-control {
        height: 10p !important;

    }
    </style>


</head>

<body style="background-color: #f5f5f5;">

    <div class="container">
        <form action="formSubmit.php" method="post">
            <h4 class="text-center" style="margin-top: 50px;">LSU Detail</h4>
            <div class="row mt-5">
                <div class="col-md-2"></div>

                <label class="mt-2" style="font-size: 13px; margin-right: 188px;"><b>Client</b></label>
                <div class="col-md-4">
                    <div class="form-group">
                        <select type="text" name="client" id="client" class="form-control">
                            <option selected disabled>Please Select Client</option>
                            <?php
                            $sql = 'SELECT * FROM `LSUDRUGTESTCONTACTS`';
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '
                            <option value="' .
                                    $row['LSUSiteName'] .
                                    '">' .
                                    $row['LSUSiteName'] .
                                    '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 150px;"><b>Department</b></label>
                <div class="col-md-4">
                    <div class="form-group">

                        <input type="text" name="dept" id="dept" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 159px;"><b>First Name</b></label>
                <div class="col-md-4">
                    <div class="form-group">

                        <input type="text" name="fname" id="fname" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 162px;"><b>Last Name</b></label>
                <div class="col-md-4">
                    <div class="form-group">

                        <input type="text" name="lname" id="lname" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 202px;"><b>SSN</b></label>
                <div class="col-md-4">
                    <div class="form-group">

                        <input type="text" name="ssn" id="ssn" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 150px;"><b>Specimen ID</b></label>
                <div class="col-md-4">
                    <div class="form-group">

                        <input type="text" name="specimen" id="specimen" class="form-control">
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 139px;"><b>Collection Site</b></label>
                <div class="col-md-7">
                    <div class="form-group">
                        <select type="text" name="collectionSite" id="collectionSite" class="form-control">
                            <option selected disabled>Please Select Collection Site</option>
                            <?php
                            $sql =
                                'SELECT * FROM `CollectionSites`';
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '
                            <option value="' .
                                    $row['CollectionSiteName'] . ' ' . $row['Address'] . ' ' . $row['City'] . ' ' . $row['State'] .
                                    '">' .
                                    $row['CollectionSiteName'] . ' ' . $row['Address'] . ' ' . $row['City'] . ' ' . $row['State'] .
                                    '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 155px;"><b>People Soft</b></label>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Account</label>
                        <input type="text" name="account" id="account" value="533020" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Fund</label>
                        <input type="text" name="fund" id="fund" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Department</label>
                        <input type="text" name="department" id="department" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4" style="margin-right: 38px;"></div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Program</label>
                        <input type="text" name="program" id="program" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Class</label>
                        <input type="text" name="class" id="class" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Project</label>
                        <input type="text" name="project" id="project" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 139px;"><b>Send Result To</b></label>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Contact</label>
                        <input type="text" name="contact" id="contact" class="form-control">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" id="email" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 146px;"><b>Requested By</b></label>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="text" name="requestedBy" id="requestedBy" class="form-control">
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 135px;"><b>Requested Date</b></label>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="date" name="requestedDate" id="requestedDate" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 115px;"><b>Collection Deadline</b></label>
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="date" name="deadline" id="deadline" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 175px;"><b>Test Type</b></label>
                <div class="col-md-4">
                    <div class="form-group">
                        <select type="text" name="type" id="type" class="form-control">
                            <option selected disabled>Please Select Test Type</option>
                            <?php
                            $sql = 'SELECT * FROM `testtype`';
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '
                            <option value="' .
                                    $row['type_id'] .
                                    '">' .
                                    $row['type_nm'] .
                                    '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 160px;"><b>Test Reason</b></label>
                <div class="col-md-4">
                    <div class="form-group">
                        <select type="text" name="reason" id="reason" class="form-control">
                            <option selected disabled>Please Select Test Reason</option>
                            <?php
                            $sql = 'SELECT * FROM `reasons`';
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '
                            <option value="' .
                                    $row['reason_code'] .
                                    '">' .
                                    $row['reason_nm'] .
                                    '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 165px;"><b>Test 2 Type</b></label>
                <div class="col-md-4">
                    <div class="form-group">
                        <select type="text" name="type2" id="type2" class="form-control">
                            <option selected disabled>Please Select Test Type</option>
                            <?php
                            $sql = 'SELECT * FROM `testtype`';
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '
                            <option value="' .
                                    $row['type_id'] .
                                    '">' .
                                    $row['type_nm'] .
                                    '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 165px;"><b>Test 3 Type</b></label>
                <div class="col-md-4">
                    <div class="form-group">
                        <select type="text" name="type3" id="type3" class="form-control">
                            <option selected disabled>Please Select Test Type</option>
                            <?php
                            $sql = 'SELECT * FROM `testtype`';
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '
                            <option value="' .
                                    $row['type_id'] .
                                    '">' .
                                    $row['type_nm'] .
                                    '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 90px;"><b>Safety Sensitive
                        Position</b></label>
                <div class="col-md-6">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="safety" id="safety">
                        <label class="form-check-label" for="defaultCheck1"></br>
                            Any individual whose principle responsibility is to operate public vehicles, maintain public
                            vehicles, or supervise any public employee who drives or maintains public vehicles will be
                            subject to a program of random alcohol and drug testing. Also, individuals who hold safety
                            or
                            security sensitive jobs may be subject to random alcohol and drug testing.
                        </label>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 172px;"><b>Comments</b></label>
                <div class="col-md-5">
                    <div class="form-group">
                        <textarea type="text" name="comments" id="comments" class="form-control"
                            style="height: 150px;"></textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"></div>
                <div class="col-md-4" style="margin-left: 50px;">
                    <button type="submit" class="btn btn-secondary">Submit</button>
                    <button type="button" onclick="window.open('LSU_Table.php', '_self');"
                        class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </form>

    </div>

    </div>

</body>

</html>1