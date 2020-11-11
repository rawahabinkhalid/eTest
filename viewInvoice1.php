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
    <script>
    counter = 1;

    function addRow() {
        var content =
            '<tr><td><input type="text" class="form-control" id="clientId_' + counter +
            '" name="client[]"></td><td><input type="text" class="form-control" id="itemid_' +
            counter +
            '" name="item[]" onchange="getRate(this);"></td><td><input type="text" class="form-control" id="description_' +
            counter + '" name="description[]"></td><td><input type="text" class="form-control" id="kg_' + counter +
            '" name="kg[]" onchange="calcTotal(this);"></td><td><input type="text" class="form-control" id="rate_' +
            counter +
            '" name="rate[]" onchange="calcTotal(this);"></td><td><input type="text" class="form-control" id="total_' +
            counter + '" name="total[]" readonly></td></tr>';
        $('#tbody').append(content);

        counter++;
    }

    function deleteRow() {
        var tableName = "item";
        var tbl = document.getElementById(tableName);
        var lastRow = tbl.rows.length;
        lastRow--;
        // alert(lastRow);
        if (lastRow > 1) {
            tbl.deleteRow(lastRow);
            // tbl.deleteRow(lastRow - 2);
        }

    }


    function calcTotal(reference) {
        index = reference.id.split('_')[1];
        rate = document.getElementById('rate_' + index).value;
        kg = document.getElementById('kg_' + index).value;
        if (rate != '' && kg != '') {
            document.getElementById('total_' + index).value = parseFloat(parseFloat(rate) * parseFloat(kg)).toFixed(2);
        }
    }

    </script>

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
    <div class="wrapper" id='printMe'>
    	<br>
        <div class="row" >
        	<div class="col-md-1"></div>
        	<div class="col-md-3"><h2>Invoice</h2></div>
        	<div class="col-md-5"></div>
        	<div class="col-md-3"><h2>RN Expertise, Inc.</h2></div>
        </div>
        <hr>
        <div class="row">
        	<div class="col-md-1"></div>
        	<div class="col-md-3"><span>Invoice:2141241</span></div>
        	<div class="col-md-5"></div>
        	<div class="col-md-3"><span>Date:05/08/20</span></div>
        </div>
        <br>
        <div class="row">
        	<div class="col-md-1"></div>
        	<div class="col-md-4"><span><b>RN Expertise, Inc:</b>2141241</span></div>
        	<div class="col-md-4"></div>
        	<div class="col-md-3"><span><b>SunCoast Concrete</b></span></div>
        </div>
        <div class="row">
        	<div class="col-md-9"></div>
        	<div class="col-md-3"><span><b>rrodney@gowtihthesun.com</b></span></div>
        </div>
        <div class="row">
        	<div class="col-md-1"></div>
        	<div class="col-md-4"><span>Tel: 12348645</span>&nbsp;&nbsp;<span>Fax: 12348645</span></div>
        	<div class="col-md-4"></div>
        	<div class="col-md-3"><span>Tel: 12348645</span>&nbsp;&nbsp;<span>Fax: 12348645</span></div>
        </div>
        <div class="row">
        	<div class="col-md-1"></div>
        	<div class="col-md-5"><span>Tel: 12348645</span>&nbsp;&nbsp;<span>Fax: 12348645</span></div>
        	<div class="col-md-3"></div>
        	<div class="col-md-3"><span>Tel: 12348645</span>&nbsp;&nbsp;<span>Fax: 12348645</span></div>
        </div>
        <br><br>
        <div class="row">
        	<div class="col-md-1"></div>
        	<div class="col-md-5"><span>Terms: Net 30 Days</div>
        	<div class="col-md-3"></div>
        	<div class="col-md-3"><span>Reference:</span></div>
        </div>
        <br><br><br>
        <div class="row">
        	<div class="col-md-1"></div>
        	<div class="col-md-10">
        		<b>Details</b>
				<table class="table">
				  <thead class="thead-dark">
				    <tr>
				      <th scope="col">Item</th>
				      <th scope="col">Test No</th>
				      <th scope="col">SSN</th>
				      <th scope="col">First/Req No.</th>
				      <th scope="col">Last Name</th>
				      <th scope="col">Test Type</th>
				      <th scope="col">Test Date</th>
				      <th scope="col">Amount</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr>
				      <td>1</td>
				      <td>644117</td>
				      <td>7864125862</td>
				      <td>2073</td>
				      <td>Matz</td>
				      <td>Drug</td>
				      <td>02/02/20</td>
				      <td>45</td>
				    </tr>
				  </tbody>
				</table>
        	</div>
        </div>
        <div class="row">
        	<div class="col-md-9"></div>
        	<div class="col-md-1"><b>Total</b></div>
        	<div class="col-md-2">45</div>
        </div>
        
    </div>
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