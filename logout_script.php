<?php
session_start();

// Perform the logout actions; destroying the session
session_destroy();

// Redirect back to the login page or any other desired page
header("Location: login.php");
exit();
?>
