<!DOCTYPE html>
<html>
<head>
<title></title>
</head>
<body>

<?php
  $servername = "database-1.cb3jbdsl26za.ap-southeast-1.rds.amazonaws.com";
  $username = "admin";
  $password = "ADB1st2023";
  $dbase = "hrm_project";

  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbase);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  //echo "connected.";
?>