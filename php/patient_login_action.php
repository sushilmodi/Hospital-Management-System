<?php
session_start();
require '../db.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Search user
$sql = "SELECT * FROM patients WHERE email = '$email' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows === 1) {

    $user = $result->fetch_assoc();

    // Compare password (plain text version for simplicity now)
    if ($user['password'] === $password) {

        // Login success
        $_SESSION['patient_id'] = $user['id'];
        $_SESSION['patient_name'] = $user['name'];

        header("Location: ../patient/dashboard.php");
        exit();
    }
}

header("Location: ../patient/login.php?error=1");
exit();
?>
