<?php
session_start();
require '../db.php';

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

$doctor_id = intval($_SESSION['doctor_id']);

// Total appointments for this doctor
$totalRes = $conn->query("SELECT COUNT(*) AS total FROM appointments WHERE doctor_id = $doctor_id");
$total = ($totalRes && $totalRes->num_rows) ? $totalRes->fetch_assoc()['total'] : 0;

// Today's appointments
$today = date('Y-m-d');
$todayRes = $conn->query("SELECT COUNT(*) AS cnt FROM appointments WHERE doctor_id = $doctor_id AND  date = '$today'");
$todayCount = ($todayRes && $todayRes->num_rows) ? $todayRes->fetch_assoc()['cnt'] : 0;

// Pending appointments
$pendingRes = $conn->query("SELECT COUNT(*) AS cnt FROM appointments WHERE doctor_id = $doctor_id AND status = 'pending'");
$pending = ($pendingRes && $pendingRes->num_rows) ? $pendingRes->fetch_assoc()['cnt'] : 0;

// Completed appointments
$completedRes = $conn->query("SELECT COUNT(*) AS cnt FROM appointments WHERE doctor_id = $doctor_id AND status = 'completed'");
$completed = ($completedRes && $completedRes->num_rows) ? $completedRes->fetch_assoc()['cnt'] : 0;

// Unique patients treated (count distinct patient_id with status = completed)
$patientsRes = $conn->query("SELECT COUNT(DISTINCT patient_id) AS cnt FROM appointments WHERE doctor_id = $doctor_id AND status = 'completed'");
$patientsTreated = ($patientsRes && $patientsRes->num_rows) ? $patientsRes->fetch_assoc()['cnt'] : 0;

// doctor name safe display
$doctor_name = isset($_SESSION['doctor_name']) ? htmlspecialchars($_SESSION['doctor_name']) : "Doctor";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<div class="doctor-dashboard">

    <!-- Sidebar -->
    <aside class="doctor-sidebar">
    <h2>Doctor Panel</h2>

    <div class="sidebar-menu">
        <a href="dashboard.php" class="active">Dashboard</a>
        <a href="appointments.php">My Appointments</a>
        <a href="profile.php">My Profile</a>

        <!-- Logout same block me admin ki tarah -->
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
    </aside>

    <!-- Main -->
    <main class="doctor-main">
        <h1>Welcome, <?= $doctor_name ?></h1>

        <div class="doctor-cards">
            <div class="doctor-card">
                <h3>Total Appointments</h3>
                <p><?= intval($total) ?></p>
            </div>

            <div class="doctor-card">
                <h3>Today's Appointments</h3>
                <p><?= intval($todayCount) ?></p>
            </div>

            <div class="doctor-card">
                <h3>Pending</h3>
                <p><?= intval($pending) ?></p>
            </div>

            <div class="doctor-card">
                <h3>Completed</h3>
                <p><?= intval($completed) ?></p>
            </div>

            <div class="doctor-card">
                <h3>Patients Treated</h3>
                <p><?= intval($patientsTreated) ?></p>
            </div>
        </div>

        <div class="dashboard-actions">
            <a class="btn-primary" href="appointments.php">View Appointments</a>
            <a class="btn-primary" href="profile.php">Edit Profile</a>
        </div>
    </main>

</div>

</body>
</html>
