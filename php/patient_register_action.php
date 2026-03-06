<?php
require '../db.php';

// Collect form data
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];   // Later we will hash it
$phone = $_POST['phone'];

// Insert into database
$sql = "INSERT INTO patients (name, email, password, phone) 
        VALUES ('$name', '$email', '$password', '$phone')";

if ($conn->query($sql)) {
    header("Location: ../patient/register.php?success=1");
    exit();
} else {
    header("Location: ../patient/register.php?error=1");
    exit();
}
?>
