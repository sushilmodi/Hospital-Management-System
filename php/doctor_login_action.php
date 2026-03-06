<?php
session_start();
require '../db.php';

$email = $conn->real_escape_string($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($email) || empty($password)) {
    header("Location: ../doctor/login.php?error=1");
    exit();
}

// Login using EMAIL
$sql = "SELECT * FROM doctors WHERE email = '$email' LIMIT 1";
$res = $conn->query($sql);

if ($res && $res->num_rows == 1) {
    $doc = $res->fetch_assoc();

    // Plain text password compare
    if ($doc['password'] === $password) {

        // Login success
        $_SESSION['doctor_id'] = $doc['id'];
        $_SESSION['doctor_name'] = $doc['name'];
        $_SESSION['doctor_email'] = $doc['email'];

        header("Location: ../doctor/dashboard.php");
        exit();
    }
}

// Failed login
header("Location: ../doctor/login.php?error=1");
exit();
?>
