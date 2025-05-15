<?php
include 'header.inc';
session_start();

if (isset($_SESSION['Cj'])) {
    echo "Welcome, ".$_SESSION['Cj'];
} else {
    header('Location: login.php');
}
include 'footer.inc';
?>