<?php
session_start();
require '../db.php';

// If patient not logged in → redirect to login
if (!isset($_SESSION['patient_id'])) {
    header("Location: login.php?error=Please login to book appointment");
    exit();
}

// Fetch doctors list
$doctors = $conn->query("SELECT * FROM doctors ORDER BY name ASC");

// Fetch patient details
$patient_id = $_SESSION['patient_id'];
$patient_query = "SELECT name, email, phone FROM patients WHERE id = $patient_id";
$patient_result = $conn->query($patient_query);
$patient = $patient_result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Appointment - CarePlus Hospital</title>
    <link rel="stylesheet" href="../css/styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Additional responsive styles */
        .appointment-form {
            max-width: 600px;
            margin: 0 auto;
        }
        @media (max-width: 768px) {
            .patient-container {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                min-height: auto;
            }
            .main-content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="patient-container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2 class="sidebar-logo">Patient Panel</h2>

        <a href="dashboard.php">Dashboard</a>
        <a href="book_appointment.php" class="active">Book Appointment</a>
        <a href="my_appointments.php">My Appointments</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <h1>Book an Appointment</h1>
        <p class="subtitle">Select a doctor and preferred date/time for consultation.</p>

        <?php if (isset($_GET['success'])): ?>
            <p class="success-msg"><?php echo htmlspecialchars($_GET['success']); ?></p>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <p class="error-msg"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>

        <form class="appointment-form" action="../php/book_appointment_action.php" method="POST">

            <!-- Patient Name (hidden but shown for confirmation) -->
            <label>Patient Name</label>
            <input type="text" value="<?php echo htmlspecialchars($patient['name']); ?>" readonly>

            <!-- Doctor Select -->
            <label>Select Doctor</label>
            <select name="doctor_id" required>
                <option value="">-- Choose Doctor --</option>
                <?php while ($doc = $doctors->fetch_assoc()): ?>
                    <option value="<?= $doc['id'] ?>">Dr. <?= htmlspecialchars($doc['name']) ?> — <?= htmlspecialchars($doc['specialization']) ?></option>
                <?php endwhile; ?>
            </select>

            <!-- Date -->
            <label>Select Date</label>
            <input type="date" name="date" min="<?php echo date('Y-m-d'); ?>" required>

            <!-- Time -->
            <label>Select Time</label>
            <input type="time" name="time" required>

            <!-- Message -->
            <label>Message (Optional)</label>
            <textarea name="message" placeholder="Describe your issue"></textarea>

            <button type="submit" class="appointment-btn">Book Appointment</button>

        </form>

        <div class="login-link" style="text-align: center; margin-top: 20px;">
            <a href="dashboard.php">← Back to Dashboard</a>
        </div>
    </div>
</div>

</body>
</html>