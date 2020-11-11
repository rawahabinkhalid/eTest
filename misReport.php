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
    <div class="wrapper" id='printMe'>
        <br>
        <div class="row" >
            <div class="col-md-1"></div>
            <div class="col-md-5"><h2>Drug Testing Report</h2></div>
            <div class="col-md-3"></div>
            <div class="col-md-3"><h2>RN Expertise, Inc.</h2></div>
        </div>
        <br>
        <div class="row" >
            <div class="col-md-1"></div>
            <div class="col-md-3"><h5>Company Wide Results</h5></div>
        </div>
        <div class="row" >
            <div class="col-md-1"></div>
            <div class="col-md-3"><h5><span style="font-size: 0.65em;">For samples collected from</span></h5></div>
        </div>
        <hr>
        <br>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-4"><span><b>RN Expertise, Inc:</b>2141241</span></div>
            <div class="col-md-4"></div>
            <div class="col-md-3"><span><b>SunCoast Concrete</b></span></div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-3"><span><b>691 Douglas Ave</b></span></div>
            <div class="col-md-5"></div>
            <div class="col-md-3"><span><b>691 Douglas Ave</b></span></div>
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
        <br>
        <br>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-2"><h4><b>Results</b></h4></div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-1"><span style="font-size: 0.80em;"><b>Summary</b></span></div>
            <div class="col-md-1"></div>
            <div class="col-md-1"><b>PA</b></div>
            <div class="col-md-1"><b>PRE</b></div>
            <div class="col-md-1"><b>R/AC</b></div>
            <div class="col-md-1"><b>RAN</b></div>
            <div class="col-md-1"><b>Total</b></div>
        </div>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-1"><b>Negative</b></div>
            <div class="col-md-1"></div>
            <div class="col-md-1">4</div>
            <div class="col-md-1">39</div>
            <div class="col-md-1">2</div>
            <div class="col-md-1">11</div>
            <div class="col-md-1"><b>56</b></div>
        </div>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-1"><b>Positive</b></div>
            <div class="col-md-1"></div>
            <div class="col-md-1">4</div>
            <div class="col-md-1">39</div>
            <div class="col-md-1">2</div>
            <div class="col-md-1">11</div>
            <div class="col-md-1"><b>56</b></div>
        </div>

        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-1"><b>Grand Total</b></div>
            <div class="col-md-1"><b>4</b></div>
            <div class="col-md-1"><b>39</b></div>
            <div class="col-md-1"><b>2</b></div>
            <div class="col-md-1"><b>11</b></div>
            <div class="col-md-1"><b>56</b></div>
        </div>

        <br><br>


        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-1"><span style="font-size: 0.80em;"><b>Refusal Details</b></span></div>
            <div class="col-md-1"></div>
            <div class="col-md-1"><b>PA</b></div>
            <div class="col-md-1"><b>PRE</b></div>
            <div class="col-md-1"><b>R/AC</b></div>
            <div class="col-md-1"><b>RAN</b></div>
            <div class="col-md-1"><b>Total</b></div>
        </div>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-1"><b>Adulterated</b></div>
            <div class="col-md-1"></div>
            <div class="col-md-1">4</div>
            <div class="col-md-1">39</div>
            <div class="col-md-1">2</div>
            <div class="col-md-1">11</div>
            <div class="col-md-1"><b>56</b></div>
        </div>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-1"><b>Substituted</b></div>
            <div class="col-md-1"></div>
            <div class="col-md-1">4</div>
            <div class="col-md-1">39</div>
            <div class="col-md-1">2</div>
            <div class="col-md-1">11</div>
            <div class="col-md-1"><b>56</b></div>
        </div>
        
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-1"><b>Grand Total</b></div>
            <div class="col-md-1"><b>4</b></div>
            <div class="col-md-1"><b>39</b></div>
            <div class="col-md-1"><b>2</b></div>
            <div class="col-md-1"><b>11</b></div>
            <div class="col-md-1"><b>56</b></div>
        </div>
        
        <br><br>



        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-1"><span style="font-size: 0.80em;"><b>Positive Details</b></span></div>
            <div class="col-md-1"></div>
            <div class="col-md-1"><b>PA</b></div>
            <div class="col-md-1"><b>PRE</b></div>
            <div class="col-md-1"><b>R/AC</b></div>
            <div class="col-md-1"><b>RAN</b></div>
            <div class="col-md-1"><b>Total</b></div>
        </div>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-1"><b>Alcohol</b></div>
            <div class="col-md-1"></div>
            <div class="col-md-1">4</div>
            <div class="col-md-1">39</div>
            <div class="col-md-1">2</div>
            <div class="col-md-1">11</div>
            <div class="col-md-1"><b>56</b></div>
        </div>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-1"><b>Amphetamines</b></div>
            <div class="col-md-1"></div>
            <div class="col-md-1">4</div>
            <div class="col-md-1">39</div>
            <div class="col-md-1">2</div>
            <div class="col-md-1">11</div>
            <div class="col-md-1"><b>56</b></div>
        </div>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-1"><b>Cocaine Metabolite</b></div>
            <div class="col-md-1"></div>
            <div class="col-md-1">4</div>
            <div class="col-md-1">39</div>
            <div class="col-md-1">2</div>
            <div class="col-md-1">11</div>
            <div class="col-md-1"><b>56</b></div>
        </div>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-1"><b>Marijuana</b></div>
            <div class="col-md-1"></div>
            <div class="col-md-1">4</div>
            <div class="col-md-1">39</div>
            <div class="col-md-1">2</div>
            <div class="col-md-1">11</div>
            <div class="col-md-1"><b>56</b></div>
        </div>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-1"><b>Opiates</b></div>
            <div class="col-md-1"></div>
            <div class="col-md-1">4</div>
            <div class="col-md-1">39</div>
            <div class="col-md-1">2</div>
            <div class="col-md-1">11</div>
            <div class="col-md-1"><b>56</b></div>
        </div>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-1"><b>Phencyclidine</b></div>
            <div class="col-md-1"></div>
            <div class="col-md-1">4</div>
            <div class="col-md-1">39</div>
            <div class="col-md-1">2</div>
            <div class="col-md-1">11</div>
            <div class="col-md-1"><b>56</b></div>
        </div>
        
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-1"><b>Grand Total</b></div>
            <div class="col-md-1"><b>4</b></div>
            <div class="col-md-1"><b>39</b></div>
            <div class="col-md-1"><b>2</b></div>
            <div class="col-md-1"><b>11</b></div>
            <div class="col-md-1"><b>56</b></div>
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