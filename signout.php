<?php
$_SESSION = [];
session_start();
session_destroy();
session_unset();

// header("location: Login/index.php");

?>
<script>
    sessionStorage.clear();
    window.open('Login/index.php', '_self')
</script>