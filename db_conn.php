<?php
$servername = "localhost";
$username = "root";
$password = "root_macalinao50";
$dbase = "mydb"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbase);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
//echo "connected.";
?>
