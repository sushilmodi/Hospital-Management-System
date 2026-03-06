<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Add Doctor</title>
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<div class="admin-container">

  <!-- Sidebar -->
  <aside class="admin-sidebar">
    <h2 class="sidebar-title">Admin Panel</h2>
    
    <a href="dashboard.php">Dashboard</a>
    <a href="manage_doctors.php" class="active">Manage Doctors</a>
    <a href="manage_patients.php">Manage Patients</a>
    <a href="manage_appointments.php">Manage Appointments</a>
    <a href="logout.php" class="logout-btn">Logout</a>
  </aside>

  <!-- Main Content -->
  <main class="admin-main">
    <h1>Add Doctor</h1>

    <!-- UPDATED: Added enctype + photo upload field -->
    <form class="doctor-form" action="../php/doctor_actions.php" method="POST" enctype="multipart/form-data">
      
      <label>Doctor Name</label>
      <input type="text" name="name" required>

      <label>Specialization</label>
      <input type="text" name="specialization" required>

      <label>Phone</label>
      <input type="text" name="phone" required>

      <label>Email</label>
      <input type="email" name="email" required>

      <label>Password (plain-text)</label>
      <input type="text" name="password" required>

      <!-- NEW: Doctor Photo Upload -->
      <label>Doctor Photo</label>
      <input type="file" name="photo" accept="image/*">

      <button type="submit" name="add_doctor" class="btn-primary">Add Doctor</button>
    </form>
  </main>

</div>

</body>
</html>
