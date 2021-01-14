<?php
session_start();
$servername = 'matzgroup17.ipagemysql.com';
$username = 'etest_matz';
$password = 'etest_matz';
$dbname = 'etest_matz';
date_default_timezone_set('America/Los_Angeles');

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
