<?php
$servername = "localhost";
$username = "root";
$password = "root_macalinao50";
$dbase = "mydb"; 

$conn = new mysqli($servername, $username, $password, $dbase);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    //echo "Connected successfully!";
}
?>
