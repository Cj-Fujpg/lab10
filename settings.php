<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "users"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}