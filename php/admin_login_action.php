<?php
session_start();
require '../db.php';

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM admin WHERE username='$username' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows == 1) {

    $admin = $result->fetch_assoc();

    // plain-text password check
    if ($admin['password'] === $password) {

        $_SESSION['admin_id'] = $admin['id'];

        // Because table has no 'name' column, store username instead
        $_SESSION['admin_name'] = $admin['username'];

        header("Location: ../admin/dashboard.php");
        exit();
    }
}

// If login fails
header("Location: ../admin/login.php?error=1");
exit();
?>
