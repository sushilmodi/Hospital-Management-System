<?php
session_start();
require '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit();
}

/* APPROVE APPOINTMENT */
if (isset($_GET['approve'])) {
    $id = $_GET['approve'];
    $conn->query("UPDATE appointments SET status='approved' WHERE id='$id'");
    header("Location: ../admin/manage_appointments.php");
    exit();
}

/* REJECT APPOINTMENT */
if (isset($_GET['reject'])) {
    $id = $_GET['reject'];
    $conn->query("UPDATE appointments SET status='rejected' WHERE id='$id'");
    header("Location: ../admin/manage_appointments.php");
    exit();
}

/* COMPLETE APPOINTMENT */
if (isset($_GET['complete'])) {
    $id = $_GET['complete'];
    $conn->query("UPDATE appointments SET status='completed' WHERE id='$id'");
    header("Location: ../admin/manage_appointments.php");
    exit();
}
?>
