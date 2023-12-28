<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the landing page or any other page after signing out
header('location:index.php');
exit();
?>