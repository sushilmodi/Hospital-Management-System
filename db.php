<?php
// Database Credentials
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "hospital_db";

// Create Connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// To avoid any encoding issue
$conn->set_charset("utf8");
?>
