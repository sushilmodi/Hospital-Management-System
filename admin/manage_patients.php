<?php
session_start();
require '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all patients
$patients = $conn->query("SELECT * FROM patients ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Patients</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<div class="admin-container">

    <!-- SIDEBAR -->
    <aside class="admin-sidebar">
        <h2 class="sidebar-title">Admin Panel</h2>

        <a href="dashboard.php">Dashboard</a>
        <a href="manage_doctors.php">Manage Doctors</a>
        <a href="manage_patients.php" class="active">Manage Patients</a>
        <a href="manage_appointments.php">Manage Appointments</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="admin-main">
        <h1>Manage Patients</h1>

        <table class="patient-table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>

            <?php while ($p = $patients->fetch_assoc()): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= $p['name'] ?></td>
                <td><?= $p['email'] ?></td>
                <td><?= $p['phone'] ?></td>

                <td>
                    <a class="delete-btn"
                       href="../php/patient_actions.php?delete=<?= $p['id'] ?>"
                       onclick="return confirm('Delete this patient?');">
                       Delete
                    </a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

    </main>

</div>

</body>
</html>
