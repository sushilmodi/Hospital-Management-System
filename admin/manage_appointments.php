<?php
session_start();
require '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$sql = "
SELECT a.*, 
       p.name AS patient_name, 
       d.name AS doctor_name 
FROM appointments a
JOIN patients p ON a.patient_id = p.id
JOIN doctors d ON a.doctor_id = d.id
ORDER BY a.date DESC, a.time DESC
";

$appointments = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Appointments</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<div class="admin-container">

    <!-- SIDEBAR -->
    <aside class="admin-sidebar">
        <h2 class="sidebar-title">Admin Panel</h2>

        <a href="dashboard.php">Dashboard</a>
        <a href="manage_doctors.php">Manage Doctors</a>
        <a href="manage_patients.php">Manage Patients</a>
        <a href="manage_appointments.php" class="active">Manage Appointments</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </aside>

    <!-- MAIN AREA -->
    <main class="admin-main">
        <h1>Manage Appointments</h1>

        <table class="appointment-table">
            <tr>
                <th>ID</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            <?php while ($row = $appointments->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['patient_name'] ?></td>
                <td><?= $row['doctor_name'] ?></td>
                <td><?= $row['date'] ?></td>
                <td><?= date("h:i A", strtotime($row['time'])) ?></td>

                <td>
                    <span class="admin-status <?= strtolower($row['status']) ?>">
                        <?= ucfirst($row['status']) ?>
                    </span>
                </td>

                <td>
                    <?php if ($row['status'] == 'pending'): ?>
                        <a class="approve-btn" href="../php/appointment_actions.php?approve=<?= $row['id'] ?>">Approve</a>
                        <a class="reject-btn" href="../php/appointment_actions.php?reject=<?= $row['id'] ?>">Reject</a>
                    <?php endif; ?>

                    <?php if ($row['status'] == 'approved'): ?>
                        <a class="complete-btn" href="../php/appointment_actions.php?complete=<?= $row['id'] ?>">Mark Completed</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>

        </table>

    </main>

</div>

</body>
</html>
