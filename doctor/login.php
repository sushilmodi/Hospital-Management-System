<?php
session_start();

// If doctor already logged in
if (isset($_SESSION['doctor_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Login - CarePlus Hospital</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<div class="doctor-login-container">
    <h2>Doctor Login</h2>

    <?php if (isset($_GET['error'])): ?>
        <p class="error-msg"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <p class="success-msg"><?php echo htmlspecialchars($_GET['success']); ?></p>
    <?php endif; ?>

    <form action="../php/doctor_login_action.php" method="POST">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>

        <button type="submit" class="btn-login">Login</button>
    </form>

    <div class="login-link">
        <a href="../index.php">← Back to Home</a>
    </div>
</div>

</body>
</html>