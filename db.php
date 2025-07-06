<?php
$host = "localhost";
$username = "root";
$password = ""; // Default for XAMPP
$database = "flexiride"; // Your database name

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
