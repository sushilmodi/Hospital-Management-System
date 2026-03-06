<?php
session_start();
require '../db.php';

// Check if patient is logged in
if (!isset($_SESSION['patient_id'])) {
    header("Location: ../patient/login.php?error=Please login first");
    exit();
}

// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../patient/book_appointment.php");
    exit();
}

// Get patient ID from session
$patient_id = $_SESSION['patient_id'];

// Get and validate POST data
$doctor_id = isset($_POST['doctor_id']) ? intval($_POST['doctor_id']) : 0;
$date = isset($_POST['date']) ? trim($_POST['date']) : '';
$time = isset($_POST['time']) ? trim($_POST['time']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validate required fields
if ($doctor_id <= 0 || empty($date) || empty($time)) {
    header("Location: ../patient/book_appointment.php?error=All fields are required");
    exit();
}

// Validate date (cannot be in the past)
if (strtotime($date) < strtotime(date('Y-m-d'))) {
    header("Location: ../patient/book_appointment.php?error=Appointment date cannot be in the past");
    exit();
}

// Escape message for SQL safety
$message = mysqli_real_escape_string($conn, $message);

// Check if table name is correct (appointments table should have these columns)
// Note: Using 'appointment_date' and 'appointment_time' instead of 'date' and 'time'
// because 'date' and 'time' are reserved keywords in MySQL
$sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, message, status) 
        VALUES ('$patient_id', '$doctor_id', '$date', '$time', '$message', 'pending')";

// Execute query
if ($conn->query($sql)) {
    // Success - redirect with success message
    header("Location: ../patient/book_appointment.php?success=Appointment booked successfully!");
} else {
    // Error - check what went wrong
    $error = $conn->error;
    error_log("Appointment booking error: " . $error);
    header("Location: ../patient/book_appointment.php?error=Failed to book appointment. Please try again.");
}
exit();
?>