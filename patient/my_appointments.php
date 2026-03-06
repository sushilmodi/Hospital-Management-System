<?php
session_start();
require '../db.php';

// If patient not logged in
if (!isset($_SESSION['patient_id'])) {
    header("Location: ../login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];

// Fetch appointments with doctor info
$sql = "
SELECT a.*, d.name AS doctor_name, d.specialization 
FROM appointments a
JOIN doctors d ON a.doctor_id = d.id
WHERE a.patient_id = '$patient_id'
ORDER BY a.date DESC, a.time DESC
";

$appointments = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Appointments</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<div class="patient-container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2 class="sidebar-logo">Patient Panel</h2>

        <a href="dashboard.php">Dashboard</a>
        <a href="book_appointment.php">Book Appointment</a>
        <a href="my_appointments.php" class="active">My Appointments</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <h1>My Appointments</h1>
        <p class="subtitle">View all your past and upcoming appointments.</p>

        <div class="appointment-list">

            <?php if ($appointments->num_rows > 0): ?>
                
                <?php while ($row = $appointments->fetch_assoc()): ?>
                
                    <div class="appointment-card">
                        <h3>Dr. <?= $row['doctor_name'] ?></h3>
                        <p><strong>Specialization:</strong> <?= $row['specialization'] ?></p>

                        <p><strong>Date:</strong> <?= $row['date'] ?></p>
                        <p><strong>Time:</strong> <?= date("h:i A", strtotime($row['time'])) ?></p>

                        <?php if (!empty($row['message'])): ?>
                            <p><strong>Message:</strong> <?= $row['message'] ?></p>
                        <?php endif; ?>

                        <p><strong>Status:</strong> 
                            <span class="status <?= strtolower($row['status']) ?>">
                                <?= ucfirst($row['status']) ?>
                            </span>
                        </p>
                    </div>

                <?php endwhile; ?>

            <?php else: ?>
                <p class="no-appointments">No appointments found.</p>
            <?php endif; ?>

        </div>

    </div>
</div>

</body>
</html>
