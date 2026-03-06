<!DOCTYPE html>
<html>
<head>
    <title>Patient Registration - Hospital</title>

    <!-- CSS path update -->
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<div class="login-container">
    <h2>Create an Account</h2>

    <?php 
    if (isset($_GET['success'])) {
        echo "<p class='success-msg'>Account created successfully! Please Login.</p>";
    }

    if (isset($_GET['error'])) {
        echo "<p class='error-msg'>Something went wrong! Try again.</p>";
    }
    ?>

    <!-- Updated action path -->
    <form action="../php/patient_register_action.php" method="POST">

        <input type="text" name="name" placeholder="Full Name" required>

        <input type="email" name="email" placeholder="Email Address" required>

        <input type="password" name="password" placeholder="Create Password" required>

        <input type="text" name="phone" placeholder="Phone Number">

        <button type="submit" class="btn-login">Register</button>

    </form>

    <p class="login-link">
        Already have an account? 
        <a href="login.php">Login</a>
    </p>

</div>

</body>
</html>
