<?php
session_start();
require '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$id = intval($_GET['id'] ?? 0);
$doctor = $conn->query("SELECT * FROM doctors WHERE id='$id'")->fetch_assoc();

if (!$doctor) {
    header("Location: manage_doctors.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Edit Doctor</title>
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<div class="admin-container">

  <!-- SIDEBAR -->
  <aside class="admin-sidebar">
    <h2 class="sidebar-title">Admin Panel</h2>

    <a href="dashboard.php">Dashboard</a>
    <a href="manage_doctors.php" class="active">Manage Doctors</a>
    <a href="manage_patients.php">Manage Patients</a>
    <a href="manage_appointments.php">Manage Appointments</a>
    <a href="logout.php" class="logout-btn">Logout</a>
  </aside>

  <!-- MAIN AREA -->
  <main class="admin-main">
    <h1>Edit Doctor</h1>

    <!-- IMPORTANT: enctype added -->
    <form class="doctor-form" action="../php/doctor_actions.php" method="POST" enctype="multipart/form-data">
      
      <input type="hidden" name="id" value="<?= $doctor['id'] ?>">

      <label>Doctor Name</label>
      <input type="text" name="name" value="<?= htmlspecialchars($doctor['name']) ?>" required>

      <label>Specialization</label>
      <input type="text" name="specialization" value="<?= htmlspecialchars($doctor['specialization']) ?>" required>

      <label>Phone</label>
      <input type="text" name="phone" value="<?= htmlspecialchars($doctor['phone']) ?>" required>

      <label>Email (Login Username)</label>
      <input type="email" name="email" value="<?= htmlspecialchars($doctor['email']) ?>" required>

      <label>Password (leave blank to keep unchanged)</label>
      <input type="text" name="password" placeholder="Enter new password if updating">

      <!-- NEW: PHOTO UPLOAD -->
      <label>Update Doctor Photo</label>
      <input type="file" name="photo" accept="image/*">

      <!-- OLD PHOTO PREVIEW -->
      <p>Current Photo:</p>
      <img src="../uploads/doctors/<?= htmlspecialchars($doctor['photo']) ?>" 
           width="90" height="90" 
           style="border-radius: 8px; border: 2px solid #ddd; object-fit: cover;">

      <button type="submit" name="update_doctor" class="btn-primary">Update Doctor</button>
    </form>

  </main>
</div>

</body>
</html>
