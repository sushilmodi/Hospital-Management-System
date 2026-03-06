<?php
session_start();
require '../db.php';

if (!isset($_SESSION['patient_id'])) {
    header("Location: ../login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];

// If password nhi diya → update without password
if (empty($password)) {
    $sql = "UPDATE patients SET name='$name', email='$email', phone='$phone'
            WHERE id='$patient_id'";
} else {
    // password change
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $sql = "UPDATE patients SET name='$name', email='$email', phone='$phone', password='$hashed'
            WHERE id='$patient_id'";
}

if ($conn->query($sql)) {
    $_SESSION['patient_name'] = $name; // dashboard greeting update
    header("Location: ../patient/profile.php?success=1");
} else {
    header("Location: ../patient/profile.php?error=1");
}
exit();
?>
