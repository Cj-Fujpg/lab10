<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "user"; 

$dbconn = mysqli_connect($host, $username, $password, $database);

if (!$dbconn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>