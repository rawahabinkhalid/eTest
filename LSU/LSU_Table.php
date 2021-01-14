<?php
include_once '../conn.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>LSU Table</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">


        <h4 class="text-center" style="margin-top: 50px;">LSU Summary</h4>
        <div class="row mb-3">
            <div class="col-md-10" style="margin-right: 83px;">
                <a href="../signout.php" class="btn btn-info">LogOut</a>
            </div>
            <div class="col-md-0">
                <a href="LSU_Form.php" class="btn btn-success">New Test</a>
            </div>
        </div>
        <table class="table table-bordered table-sm table-striped">
            <thead class="" style="background-color: black; color: white;">
                <tr>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>SpecimenID</th>
                    <th>SSN</th>
                    <th>TestID</th>
                    <th></th>
                </tr>
            </thead>


            <tbody>
                <?php
                // $conn = mysqli_connect("localhost","root","","etest");
                $sql = 'SELECT * FROM lsuform WHERE userid = "' . $_SESSION['userid'] . '"';
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td>' .
                        $row['FirstName'] .
                        '</td>
                            <td>' .
                        $row['LastName'] .
                        '</td>
                            <td>' .
                        $row['Specimen'] .
                        '</td>
                            <td>' .
                        $row['SSN'] .
                        '</td>
                            <td>' .
                        $row['TestType'] .
                        '</td>
                            <td><a href="viewLSU_Form.php?id=' .
                        $row['Id'] .
                        '">Select</a></td>
                        </tr>';
                }
                ?>

            </tbody>
        </table>
    </div>

</body>

</html>
_