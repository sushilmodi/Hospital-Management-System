<?php
session_start();
require '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch dashboard counts
$doctor_count = $conn->query("SELECT COUNT(*) AS total FROM doctors")->fetch_assoc()['total'];
$patient_count = $conn->query("SELECT COUNT(*) AS total FROM patients")->fetch_assoc()['total'];
$appointment_count = $conn->query("SELECT COUNT(*) AS total FROM appointments")->fetch_assoc()['total'];
$pending_count = $conn->query("SELECT COUNT(*) AS total FROM appointments WHERE status='pending'")->fetch_assoc()['total'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<div class="admin-container">

    <!-- SIDEBAR -->
    <aside class="admin-sidebar">
        <h2 class="sidebar-title">Admin Panel</h2>

        <a href="dashboard.php" class="active">Dashboard</a>
        <a href="manage_doctors.php">Manage Doctors</a>
        <a href="manage_patients.php">Manage Patients</a>
        <a href="manage_appointments.php">Manage Appointments</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="admin-main">
        <h1>Welcome, <?= $_SESSION['admin_name']; ?> 👋</h1>
        <p class="subtitle">Here is today's overview of the hospital system.</p>

        <div class="admin-cards">

            <div class="admin-card blue">
                <h3><?= $doctor_count ?></h3>
                <p>Doctors</p>
            </div>

            <div class="admin-card green">
                <h3><?= $patient_count ?></h3>
                <p>Patients</p>
            </div>

            <div class="admin-card purple">
                <h3><?= $appointment_count ?></h3>
                <p>Total Appointments</p>
            </div>

            <div class="admin-card orange">
                <h3><?= $pending_count ?></h3>
                <p>Pending Approvals</p>
            </div>
        </div>

    </main>

</div>

</body>
</html>
