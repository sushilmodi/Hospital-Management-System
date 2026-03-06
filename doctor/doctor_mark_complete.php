<?php
session_start();
require '../db.php';

if (!isset($_SESSION['doctor_id'])) {
    header("Location: ../doctor/login.php");
    exit();
}

$doctor_id = $_SESSION['doctor_id'];
$appointment_id = intval($_GET['id']);

// Fetch appointment
$sql = "SELECT doctor_id, status 
        FROM appointments 
        WHERE id = $appointment_id 
        LIMIT 1";

$res = $conn->query($sql);

if (!$res || $res->num_rows === 0) {
    header("Location: ../doctor/appointments.php?error=notfound");
    exit();
}

$appointment = $res->fetch_assoc();

// Security: Doctor can update only HIS OWN appointment
if ($appointment['doctor_id'] != $doctor_id) {
    header("Location: ../doctor/appointments.php?error=unauthorized");
    exit();
}

// Status must be APPROVED
if ($appointment['status'] !== 'approved') {
    header("Location: ../doctor/appointments.php?error=not_approved");
    exit();
}

// Now update to completed
$conn->query("UPDATE appointments SET status = 'completed' WHERE id = $appointment_id");

header("Location: ../doctor/appointments.php?success=1");
exit();
?>
