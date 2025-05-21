<?php
$host = "localhost";
$username = "Cj";
$password = "105927887";
$database = "users"; 

$dbconn = mysqli_connect($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}