<?php
session_start();
require '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$doctors = $conn->query("SELECT * FROM doctors ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>Manage Doctors</title>
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

  <!-- Main Area -->
  <main class="admin-main">
      <h1>Manage Doctors</h1>

      <a class="btn-primary add-btn" href="add_doctor.php">+ Add Doctor</a>

      <table class="doctor-table">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Photo</th>
                  <th>Name</th>
                  <th>Specialization</th>
                  <th>Phone</th>
                  <th>Email</th>
                  <th>Actions</th>
              </tr>
          </thead>

          <tbody>
          <?php if ($doctors && $doctors->num_rows > 0): ?>

              <?php while($d = $doctors->fetch_assoc()): ?>

              <?php
                $photo = "../uploads/doctors/" . ($d['photo'] ?: "default-doctor.jpg");
              ?>

              <tr>
                  <td><?= $d['id'] ?></td>

                  <td>
                      <img src="<?= $photo ?>" 
                           onerror="this.src='../uploads/doctors/default-doctor.jpg';"
                           width="50" height="50"
                           style="border-radius: 50%; object-fit: cover;">
                  </td>

                  <td><?= htmlspecialchars($d['name']) ?></td>
                  <td><?= htmlspecialchars($d['specialization']) ?></td>
                  <td><?= htmlspecialchars($d['phone']) ?></td>
                  <td><?= htmlspecialchars($d['email']) ?></td>

                  <td>
                      <a class="edit-btn" href="edit_doctor.php?id=<?= $d['id'] ?>">Edit</a>
                      <a class="delete-btn" 
                         href="../php/doctor_actions.php?delete=<?= $d['id'] ?>"
                         onclick="return confirm('Delete this doctor?');">
                         Delete
                      </a>
                  </td>
              </tr>

              <?php endwhile; ?>

          <?php else: ?>
              <tr>
                  <td colspan="7" style="text-align:center; padding:25px;">
                      No doctors found.
                  </td>
              </tr>
          <?php endif; ?>
          </tbody>

      </table>
  </main>
</div>

</body>
</html>
