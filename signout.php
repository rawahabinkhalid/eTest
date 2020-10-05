<?php
$_SESSION = [];
session_start();
session_destroy();
session_unset();

header("location: Login/index.php");
