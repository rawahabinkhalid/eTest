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
        <form action="formSubmit.php" method="post" class="lsudetails">
            <h4 class="text-center" style="margin-top: 50px;">LSU Detail</h4>
            <div class="row mt-5">
                <div class="col-md-2"></div>

                <?php
                // $conn = mysqli_connect("localhost","root","","etest");
                include_once '../conn.php';
                $sql = 'SELECT * FROM lsuform WHERE Id = ' . $_GET['id'];
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                ?>

                <label class="mt-2" style="font-size: 13px; margin-right: 188px;"><b>Client</b></label>
                <div class="col-md-4">
                    <div class="form-group">
                        <select disabled type="text" name="client" id="client" class="form-control">
                            <option selected><?php echo $row[
                                'Client'
                            ]; ?></option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 150px;"><b>Department</b></label>
                <div class="col-md-4">
                    <div class="form-group">

                        <input disabled type="text" name="dept" id="dept" class="form-control"
                            value="<?php echo $row['Dept']; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 159px;"><b>First Name</b></label>
                <div class="col-md-4">
                    <div class="form-group">

                        <input disabled type="text" name="fname" id="fname" class="form-control"
                            value="<?php echo $row['FirstName']; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 162px;"><b>Last Name</b></label>
                <div class="col-md-4">
                    <div class="form-group">

                        <input disabled type="text" name="lname" id="lname" class="form-control"
                            value="<?php echo $row['LastName']; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 202px;"><b>SSN</b></label>
                <div class="col-md-4">
                    <div class="form-group">

                        <input disabled type="text" name="ssn" id="ssn" class="form-control"
                            value="<?php echo $row['SSN']; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 150px;"><b>Specimen ID</b></label>
                <div class="col-md-4">
                    <div class="form-group">

                        <input disabled type="text" name="specimen" id="specimen" class="form-control"
                            value="<?php echo $row['Specimen']; ?>">
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 139px;"><b>Collection Site</b></label>
                <div class="col-md-7">
                    <div class="form-group">
                        <select disabled type="text" name="collectionSite" id="collectionSite" class="form-control">
                            <option selected><?php echo $row[
                                'Collection'
                            ]; ?></option>
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
                        <input disabled type="text" name="account" id="account" placeholder="533020"
                            class="form-control" readonly value="<?php echo $row[
                                'Account'
                            ]; ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Fund</label>
                        <input disabled type="text" name="fund" id="fund" class="form-control"
                            value="<?php echo $row['Fund']; ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Department</label>
                        <input disabled type="text" name="department" id="department" class="form-control"
                            value="<?php echo $row['Department']; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4" style="margin-right: 38px;"></div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Program</label>
                        <input disabled type="text" name="program" id="program" class="form-control"
                            value="<?php echo $row['Program']; ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Class</label>
                        <input disabled type="text" name="class" id="class" class="form-control"
                            value="<?php echo $row['Class']; ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Project</label>
                        <input disabled type="text" name="project" id="project" class="form-control"
                            value="<?php echo $row['Project']; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 139px;"><b>Send Result To</b></label>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Contact</label>
                        <input disabled type="text" name="contact" id="contact" class="form-control"
                            value="<?php echo $row['Contact']; ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Email</label>
                        <input disabled type="text" name="email" id="email" class="form-control"
                            value="<?php echo $row['Email']; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 146px;"><b>Requested By</b></label>
                <div class="col-md-3">
                    <div class="form-group">
                        <input disabled type="text" name="requestedBy" id="requestedBy" class="form-control"
                            value="<?php echo $row['RequestedBy']; ?>">
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 135px;"><b>Requested Date</b></label>
                <div class="col-md-4">
                    <div class="form-group">
                        <input disabled type="date" name="requestedDate" id="requestedDate" class="form-control"
                            value="<?php echo $row['RequestedDate']; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 115px;"><b>Collection Deadline</b></label>
                <div class="col-md-4">
                    <div class="form-group">
                        <input disabled type="date" name="deadline" id="deadline" class="form-control"
                            value="<?php echo $row['Deadline']; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 175px;"><b>Test Type</b></label>
                <div class="col-md-4">
                    <div class="form-group">
                        <select disabled type="text" name="type" id="type" class="form-control">
                            <option selected><?php echo $row[
                                'TestType'
                            ]; ?></option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 160px;"><b>Test Reason</b></label>
                <div class="col-md-4">
                    <div class="form-group">
                        <select disabled type="text" name="reason" id="reason" class="form-control">
                            <option selected><?php echo $row[
                                'Reason'
                            ]; ?></option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 165px;"><b>Test 2 Type</b></label>
                <div class="col-md-4">
                    <div class="form-group">
                        <select disabled type="text" name="type2" id="type2" class="form-control">
                            <option selected><?php echo $row[
                                'Type2'
                            ]; ?></option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2"></div>
                <label class="mt-2" style="font-size: 13px; margin-right: 165px;"><b>Test 3 Type</b></label>
                <div class="col-md-4">
                    <div class="form-group">
                        <select disabled type="text" name="type3" id="type3" class="form-control">
                            <option selected><?php echo $row[
                                'Type3'
                            ]; ?></option>
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
                        <input class="form-check-input" disabled type="checkbox" value="1" name="safety" id="safety"
                            <?php if ($row['Safety'] == 1) {
                                echo 'checked';
                            } ?>>
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
                        <textarea disabled type="text" name="comments" id="comments" class="form-control"
                            style="height: 150px;"><?php echo $row[
                                'Comments'
                            ]; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4"></div>
                <div class="col-md-4" style="margin-left: 50px;">
                    <button type="submit" class="btn btn-secondary">Submit</button>
                    <button type="button" class="btn btn-secondary" onclick="downloadPDF();"><i
                            class="fa fa-download"></i> Reprint
                        Form</button>
                    <button type="submit" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </form>

    </div>

    </div>

    <!-- DOWNLOAD PDF WORK-->
    <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
    <script>
    function downloadPDF() {
        window.open("printForm.php", "_self");

        // $('.btn').css('display', 'none')

        // var opt = {
        //     margin: 0.5,
        //     filename: 'MyFile.pdf',
        //     html2canvas: {
        //         scale: 2
        //     },
        //     pagebreak: {
        //         mode: 'avoid-all',
        //         before: '#page2el'
        //     },
        //     jsPDF: {
        //         unit: 'in',
        //         format: 'letter',
        //         orientation: 'landscape'
        //     }
        // };
        // html2pdf().set(opt)
        //     .from(document.getElementsByClassName('lsudetails')[0])
        //     .save().then(() => {
        //         $('.btn').css('display', '')
        //     });
        
    }
    </script>

</body>

</html>