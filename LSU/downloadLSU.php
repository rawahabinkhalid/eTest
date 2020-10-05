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

    <div class="container" style="max-width: 100%;">
        <form action="formSubmit.php" method="post" class="lsudetails">
            <br><br>
            <h4 class="text-center">LSU Detail</h4>
            <div class="row mt-4 ml-2">

                <?php
            // $conn = mysqli_connect("localhost","root","","etest");
            include_once "../conn.php";
            $sql = 'SELECT * FROM lsuform WHERE Id = '.$_GET['id'];
            $result = $conn -> query($sql);
            $row = $result -> fetch_assoc();
            ?>
            </div>
            <div class="container">
                <div class="row ml-5">
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>Client:
                            </b><span><?php echo $row['Client']; ?></span></label>
                    </div>
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>Department:
                            </b><span><?php echo $row['Dept']; ?></span></label>
                    </div>
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>First Name:
                            </b><span><?php echo $row['FirstName']; ?></span></label>
                    </div>
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>Last Name:
                            </b><span><?php echo $row['LastName']; ?></span></label>
                    </div>
                </div>

                <div class="row ml-5">
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>SSN:
                            </b><span><?php echo $row['SSN']; ?></span></label>
                    </div>
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>Specimen ID:
                            </b><span><?php echo $row['Specimen']; ?></span></label>
                    </div>
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>Collection Site:
                            </b><span><?php echo $row['Collection']; ?></span></label>
                    </div>
                </div>

                <div class="row ml-5">
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b><u>People Soft:</u></b> </label>
                    </div>
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>Account:
                            </b><span><?php echo $row['Account']; ?></span></label>
                    </div>
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>Fund:
                            </b><span><?php echo $row['Fund']; ?></span></label>
                    </div>
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>Department:
                            </b><span><?php echo $row['Department']; ?></span></label>
                    </div>
                </div>

                <div class="row ml-5">
                    <div class="col-md-3"></div>
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>Program:
                            </b><span><?php echo $row['Program']; ?></span></label>
                    </div>
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>Class:
                            </b><span><?php echo $row['Class']; ?></span></label>
                    </div>
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>Project:
                            </b><span><?php echo $row['Project']; ?></span></label>
                    </div>
                </div>


                <div class="row ml-5">
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b><u>Send Result To:</u></b> </label>
                    </div>
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>Contact:
                            </b><span><?php echo $row['Contact']; ?></span></label>
                    </div>
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>Email:
                            </b><span><?php echo $row['Email']; ?></span></label>
                    </div>
                </div>

                <div class="row ml-5">
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>Requested
                                By: </b><span><?php echo $row['RequestedBy']; ?></span> </label>
                    </div>
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>Requested Date:
                            </b><span><?php echo $row['RequestedDate']; ?></span></label>
                    </div>
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>Collection Deadline:
                            </b><span><?php echo $row['Deadline']; ?></span></label>
                    </div>
                </div>

                <div class="row ml-5">
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>Test Type
                                By: </b><span><?php echo $row['TestType']; ?></span> </label>
                    </div>
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>Test Reason
                                By: </b><span><?php echo $row['Reason']; ?></span> </label>
                    </div>
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>Test 2 Type:
                            </b><span><?php echo $row['Type2']; ?></span></label>
                    </div>
                    <div class="col-md-3">
                        <label class="mt-2" style="font-size: 13px;"><b>Test 3 Type:
                            </b><span><?php echo $row['Type3']; ?></span></label>
                    </div>
                </div>

                <div class="row ml-5">
                    <div class="col-md-12">
                        <label class="mt-2" style="font-size: 13px;"><b>Safety Sensitive
                                Position</b>
                        </label>
                        <input class="form-check-input ml-3" disabled type="checkbox" value="1" name="safety"
                            id="safety" <?php if($row['Safety']==1) echo "checked"; ?>>
                        </label><label class="ml-6">Any individual whose principle responsibility is to operate public
                            vehicles, maintain
                            public vehicles, or supervise any public employee who drives or maintains public vehicles
                            will
                            be subject to a program of random alcohol and drug testing. Also, individuals who hold
                            safety or security sensitive jobs may be subject to random alcohol and drug testing.
                    </div>
                </div>

                <div class="row ml-5">
                    <div class="col-md-12">
                        <label class="mt-2" style="font-size: 13px;"><b>Comments:
                            </b><span><?php echo $row['Comments']; ?></span></label>
                    </div>
                </div>
            </div>

            <div class="row mb-3 mt-5">
                <div class="col-md-4"></div>
                <div class="col-md-4" style="margin-left: 50px;">
                    <button type="submit" class="btn btn-secondary">Submit</button>
                    <button type="button" class="btn btn-secondary" onclick="downloadPDF();"><i
                            class="fa fa-download"></i> Reprint
                        Forms</button>
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

        $('.btn').css('display', 'none')

        var opt = {
            margin: 0.5,
            filename: 'MyFile.pdf',
            html2canvas: {
                scale: 2
            },
            pagebreak: {
                mode: 'avoid-all',
                before: '#page2el'
            },
            jsPDF: {
                unit: 'in',
                format: 'letter',
                orientation: 'landscape'
            }
        };
        html2pdf().set(opt)
            .from(document.getElementsByClassName('lsudetails')[0])
            .save().then(() => {
                $('.btn').css('display', '')
            });
    }
    </script>

</body>

</html>