<?php
session_start();

// If user not logged in → redirect
if (!isset($_SESSION['patient_id'])) {
    header("Location: ../login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

<div class="patient-container">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h2 class="sidebar-logo">Patient Panel</h2>

        <a href="dashboard.php" class="active">Dashboard</a>
        <a href="book_appointment.php">Book Appointment</a>
        <a href="my_appointments.php">My Appointments</a>
        <a href="profile.php">Profile</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content dashboard-content">

        <h1>Welcome, <?php echo $_SESSION['patient_name']; ?> 👋</h1>
        <p class="subtitle">Your health records and appointments are available here.</p>

        <div class="dash-cards">

            <div class="dash-card">
                <h3>Book Appointment</h3>
                <p>Schedule your visit with the doctor.</p>
                <a href="book_appointment.php" class="dash-btn">Book Now</a>
            </div>

            <div class="dash-card">
                <h3>My Appointments</h3>
                <p>Check your previous and upcoming visits.</p>
                <a href="my_appointments.php" class="dash-btn">View Appointments</a>
            </div>

            <div class="dash-card">
                <h3>Your Profile</h3>
                <p>Manage your personal details.</p>
                <a href="profile.php" class="dash-btn">View Profile</a>
            </div>

        </div>

    </div>

</div>

</body>
</html>
