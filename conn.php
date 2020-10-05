<?php
session_start();
// $servername = 'matzgroup17.ipagemysql.com';
// $username = 'etest_matz';
// $password = 'etest_matz';
// $dbname = 'etest_matz';

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'etest';

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}