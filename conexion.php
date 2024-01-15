<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Hospital";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die(mysqli_error($conn));
}
?>