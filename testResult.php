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
    <div class="wrapper" id='printMe' style="margin: 20px;">
        <div class="row" >
            <div class="col-md-4">
                <img src="uploads/alere_logo.png" style="margin-bottom: 0px;">
            </div>
            <div class="col-md-4"></div>
            <div class="col-md-4" style="text-align: right;">
                <span>450 Southlake Blvd</span><br>
                <span>Richmond, VA, 23226</span><br>
                <span>23456543</span><br>
                <span>FAX: 54324543</span><br>
            </div>
        </div>


        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4"><h2 style="text-align: center;"><b>Drug Test Report</b></h2></div>
        </div>
        <br>

        <div class="row" >
            <div class="col-md-5" style="border: 1px solid #000;">
                <span> WV DHHR CALHOUN - SOCIAL SERVICES</span><br>
                <span> CRYSTAL KENDALL</span><br>
                <span>85 INDUSTRIAL PARK ROAD</span><br>
                <span> GRANTSVILLE, WV 26147</span><br><br>
                <span>Facility Phone : 12445484884</span>&emsp;&emsp;
                <span>FAX: 2345676543</span>
            </div>
            <div class="col-md-2"></div>
            <div class="col-md-5" style="text-align: right;">
                <span> Account Number: 787845</span><br>
                <span> Facility Number: 45454</span><br>
                <span> Lab Number: 877542524</span><br>
                <span> Specimen ID Number: 3456789</span><br><br>
                <span>Specimen Type: URINE</span>&emsp;&emsp;
            </div>
        </div>
        <br>


        <div class="row">
        	<div class="col-md-1"></div>
        	<div class="col-md-5">
        		<span>Collection Site Number: 868</span><br>
        		<span>Collection Site Name: MINNIE HAMILTON HEALTH CARE CTR LAB</span><br>
        		<span>Collection Site Address:  186 HOSPITAL DR</span><br>
        		<span>Collection Site City, State, Zip: GRANTSVILLE WV 26474</span><br>
        		<span>Collection Site Phone: 123456789</span><br>
        		<span>Collection Site Fax: 123456789</span><br>
        	</div>
        	<div class="col-md-3"></div>
        	<div class="col-md-2">
        		<br><br><br>
        		<span style="text-align: : right; text-decoration: underline;">Collector Name</span><br>
        		<span style="text-align: : right;">BRITTENEY STEVENS</span>
        	</div>
        </div>
        <hr>


        <div class="row">
        	<div class="col-md-5">
        		<span><b>Donor Name/ID: HEINEY, MATTHEW W</b></span>
        	</div>
        	<div class="col-md-4"></div>
        	<div class="col-md-3">Date Collected: 07/07/20</div>
        </div>

        <div class="row">
        	<div class="col-md-5">
        		<span>Donor SSN/ID: 89505</span>
        	</div>
        	<div class="col-md-4"></div>
        	<div class="col-md-3">Date Received: 07/06/20</div>
        </div>

        <div class="row">
        	<div class="col-md-5">
        		<span>Reason for drug test: Pre Employment</span>
        	</div>
        	<div class="col-md-4"></div>
        	<div class="col-md-3">Date Collected: 07/07/20</div>
        </div>
        <br>
        <div class="row">
        	<div class="col-md-5">
        		<span>Panel Number: 3607</span>
        	</div>
        	<!-- <div class="col-md-2"></div> -->
        	<div class="col-md-3">Panel Description: 9DR OPDIX + BUP</div>
        </div>

        <div class="row">
        	<div class="col-md-5">
        		<span>Drug Test Result: <b>NEGATIVE</b></span>
        	</div>
        </div>

        <div class="row">
        	<div class="col-md-5"></div>
        	<div class="col-md-3">Confirmation Method: GC/MS and /or LC-MS/MS</div>
        </div>
        <br><br>
        <div class="row">
        	<div class="col-md-2"></div>
        	<span>The following drugs and/or drugs drug classes were tested at the indicated threshold (cut-off) levels:</span>
        </div>

        <table class="table table-borderless">
		  <thead>
		    <tr>
		      <th scope="col">Description</th>
		      <th scope="col">Screening Level</th>
		      <th scope="col">Confirmation Level</th>
		      <th scope="col">Result</th>
		    </tr>
		  </thead>
		  <tbody>
		    <tr>
		      <th scope="row">AMPHETAMINE/METHAMOHETAMINE</th>
		      <td>1000ng/ml</td>
		      <td>500ng/ml</td>
		      <td>NEGATIVE</td>
		    </tr>
		    <tr>
		      <th scope="row">BARBITURATES</th>
		      <td>1000ng/ml</td>
		      <td>500ng/ml</td>
		      <td>NEGATIVE</td>
		    </tr>
		    <tr>
		      <th scope="row">BENZODIAZEPINES</th>
		      <td>1000ng/ml</td>
		      <td>500ng/ml</td>
		      <td>NEGATIVE</td>
		    </tr>
		    <tr>
		      <th scope="row">METHADONE</th>
		      <td>1000ng/ml</td>
		      <td>500ng/ml</td>
		      <td>NEGATIVE</td>
		    </tr>
		  </tbody>
		</table>
		<br><br>

		<span><b>Comments: </b>DILUTE CREATININE 18,5MG/DL SPECIFIC GRAVITY 1.0021</span>

		<br><br><br><br><br><br><br>

		<div class="row">
			<div class="col-md-4">
				<hr style="height:1px;border:none;color:#000;background-color:#333;"><br>
				CERTIFYING TECHNICIAN
			</div>
			<div class="col-md-2"></div>
			<div class="col-md-4">
				<hr style="height:1px;border:none;color:#000;background-color:#333;"><br>
				COLLECTOR NAME
			</div>
		</div>

    </div>
    <!-- ./wrapper -->
 <!--    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-2"><button class="btn btn-info" onclick="printDiv('printMe')">Print </button></div>
    </div> -->
    

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
        function printDiv(divName){
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;

        }
    </script>
</body>

</html>