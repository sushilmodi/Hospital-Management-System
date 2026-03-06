<?php
session_start();

/* If patient is logged in → go to Book Appointment page */
if (isset($_SESSION['patient_id'])) {
    header("Location: patient/book_appointment.php");
    exit;
}

/* If NOT logged in → go to Login page with message */
header("Location: patient/login.php?msg=Please login to book appointment");
exit;
?>