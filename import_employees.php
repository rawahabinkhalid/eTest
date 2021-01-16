<?php

include_once('conn.php');

$importData = json_decode($_POST['importData']);
print_r($importData);
