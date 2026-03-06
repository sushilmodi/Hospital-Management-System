<?php
session_start();
require '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/login.php");
    exit();
}

/* DELETE PATIENT */
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    // Delete patient record
    $conn->query("DELETE FROM patients WHERE id='$id'");

    header("Location: ../admin/manage_patients.php");
    exit();
}
?>
