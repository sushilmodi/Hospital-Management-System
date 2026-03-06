<?php
session_start();
require '../db.php';

// If not logged in → redirect
if (!isset($_SESSION['patient_id'])) {
    header("Location: ../login.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];

// Fetch patient details
$sql = "SELECT * FROM patients WHERE id = '$patient_id'";
$data = $conn->query($sql)->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<div class="patient-container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2 class="sidebar-logo">Patient Panel</h2>

        <a href="dashboard.php">Dashboard</a>
        <a href="book_appointment.php">Book Appointment</a>
        <a href="my_appointments.php">My Appointments</a>
        <a href="profile.php" class="active">Profile</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <h1>My Profile</h1>

        <?php if (isset($_GET['success'])): ?>
            <p class="success-msg">Profile updated successfully!</p>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <p class="error-msg">Something went wrong.</p>
        <?php endif; ?>

        <form class="profile-form" action="../php/update_profile.php" method="POST">
            
            <label>Name</label>
            <input type="text" name="name" value="<?= $data['name'] ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?= $data['email'] ?>" required>

            <label>Phone</label>
            <input type="text" name="phone" value="<?= $data['phone'] ?>" required>

            <label>Change Password (optional)</label>
            <input type="password" name="password" placeholder="Enter new password">

            <button type="submit" class="btn-primary">Update Profile</button>
        </form>
    </div>

</div>

</body>
</html>
