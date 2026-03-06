<?php
session_start();
require '../db.php';

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

$doctor_id = $_SESSION['doctor_id'];

$sql = "SELECT a.*, p.name AS patient_name 
        FROM appointments a
        JOIN patients p ON a.patient_id = p.id
        WHERE a.doctor_id = $doctor_id
        ORDER BY a.date DESC, a.time DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My Appointments - Doctor Panel</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<div class="doctor-container">

    <aside class="doctor-sidebar">
        <h2 class="sidebar-title">Doctor Panel</h2>

        <a href="dashboard.php">Dashboard</a>
        <a href="appointments.php" class="active">My Appointments</a>
        <a href="profile.php">My Profile</a>

        <a href="logout.php" class="logout-btn">Logout</a>
    </aside>

    <main class="doctor-main">
        <h1>My Appointments</h1>

        <table class="doctor-table">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>

                        <tr>
                            <td><?= htmlspecialchars($row['patient_name']) ?></td>
                            <td><?= htmlspecialchars($row['date']) ?></td>
                            <td><?= htmlspecialchars($row['time']) ?></td>

                            <td>
                                <?php if ($row['status'] == 'pending'): ?>
                                    <span class="doc-status pending">Pending</span>
                                <?php elseif ($row['status'] == 'approved'): ?>
                                    <span class="doc-status approved">Approved</span>
                                <?php else: ?>
                                    <span class="doc-status completed">Completed</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($row['status'] == 'approved'): ?>
                                    <a class="mark-complete-btn"
                                       href="../doctor/doctor_mark_complete.php?id=<?= $row['id'] ?>">
                                       Mark Complete
                                    </a>
                                <?php else: ?>
                                    <span style="color:#888;">Not Allowed</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                    <?php endwhile; ?>

                <?php else: ?>
                    <tr><td colspan="5" style="text-align:center; padding:20px;">No Appointments Found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

    </main>
</div>

</body>
</html>
