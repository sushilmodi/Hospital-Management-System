<?php
session_start();
require '../db.php';

if (!isset($_SESSION['doctor_id'])) {
    header("Location: login.php");
    exit();
}

$doctor_id = $_SESSION['doctor_id'];

// Fetch doctor details
$sql = "SELECT * FROM doctors WHERE id = $doctor_id LIMIT 1";
$doctor = $conn->query($sql)->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Profile</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<div class="doctor-dashboard">

    <!-- Sidebar -->
    <aside class="doctor-sidebar">
        <h2>Doctor Panel</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="appointments.php">My Appointments</a>
        <a href="profile.php" class="active">My Profile</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </aside>

    <!-- Main Content -->
    <main class="profile-main">
        <h1>My Profile</h1>

        <?php if (isset($_GET['success'])): ?>
            <p class="success-msg">Profile updated successfully!</p>
        <?php endif; ?>

        <form action="update_profile.php" method="POST" enctype="multipart/form-data" class="profile-form">

            <!-- Profile Image -->
            <div class="profile-photo-box">
                <img src="../uploads/doctors/<?php echo $doctor['photo'] ?: 'default-doctor.jpg'; ?>" 
                     onerror="this.src='../uploads/doctors/default-doctor.jpg';">
                <input type="file" name="photo">
            </div>

            <label>Name</label>
            <input type="text" name="name" value="<?= $doctor['name'] ?>" required>

            <label>Phone</label>
            <input type="text" name="phone" value="<?= $doctor['phone'] ?>">

            <label>Email (cannot change)</label>
            <input type="email" value="<?= $doctor['email'] ?>" readonly>

            <label>New Password (optional)</label>
            <input type="password" name="password" placeholder="Enter new password">

            <button type="submit" class="btn-primary">Update Profile</button>
        </form>
    </main>

</div>

</body>
</html>
