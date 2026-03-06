<?php
session_start();

// If admin already logged in
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - CarePlus Hospital</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<div class="admin-login-container">
    <h2>Admin Login</h2>

    <?php if (isset($_GET['error'])): ?>
        <p class="error-msg"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <p class="success-msg"><?php echo htmlspecialchars($_GET['success']); ?></p>
    <?php endif; ?>

    <form action="../php/admin_login_action.php" method="POST">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" placeholder="Enter username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter password" required>

        <button type="submit" class="btn-login">Login</button>
    </form>

    <div class="login-link">
        <a href="../index.php">← Back to Home</a>
    </div>
</div>

</body>
</html>