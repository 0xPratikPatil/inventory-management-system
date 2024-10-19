<?php
$host = "localhost"; // Database host
$username = "root"; // Database username
$password = ""; // Database password
$database = "ims"; // Database name

// Create connection
$conn = new mysqli($host, $username, $password, $database, 3306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
