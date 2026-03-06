<?php
session_start();
require '../db.php';

if (!isset($_SESSION['doctor_id'])) {
    header("Location: ../doctor/login.php");
    exit();
}

$doctor_id = $_SESSION['doctor_id'];

/* COMPLETE APPOINTMENT */
if (isset($_GET['complete'])) {

    $appointment_id = $_GET['complete'];

    // Check if appointment belongs to this doctor
    $check = $conn->query("SELECT * FROM appointments WHERE id='$appointment_id' AND doctor_id='$doctor_id'");

    if ($check->num_rows == 1) {

        $app = $check->fetch_assoc();

        // Only approved appointments can be completed
        if ($app['status'] == 'approved') {
            $conn->query("UPDATE appointments SET status='completed' WHERE id='$appointment_id'");
        }
    }

    header("Location: ../doctor/dashboard.php");
    exit();
}
?>
