<?php 
session_start();

// Agar already logged in hai to dashboard par bhejo
if (isset($_SESSION['patient_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Login - CarePlus Hospital</title>

    <!-- CSS path update (go one level up) -->
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<div class="login-container">
    <h2>Patient Login</h2>

    <?php 
    if (isset($_GET['error'])) {
        echo "<p class='error-msg'>" . htmlspecialchars($_GET['error']) . "</p>";
    }
    
    if (isset($_GET['success'])) {
        echo "<p class='success-msg'>" . htmlspecialchars($_GET['success']) . "</p>";
    }
    ?>

    <!-- Updated action path -->
    <form action="../php/patient_login_action.php" method="POST">

        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" placeholder="Enter your email" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>

        <button type="submit" class="btn-login">Login</button>

    </form>

    <div class="login-link">
        <a href="../index.php">← Back to Home</a>
    </div>
    
    <p class="login-link" style="margin-top: 0.5rem;">
        Don't have an account? 
        <a href="register.php">Register here</a>
    </p>

</div>

</body>
</html>