<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CarePlus Hospital | Trusted Medical Care</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<body>

<?php require 'db.php'; ?>

<!-- ================= HEADER / NAVBAR ================= -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#home">CarePlus Hospital</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list"></i>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="#home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#doctors">Doctors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-login-nav" href="patient/login.php">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ================= HERO SECTION ================= -->
<section id="home" class="hero">
    <div class="hero-content">
        <h1>Your Health, Our Commitment</h1>
        <p>Providing trusted medical care with advanced technology and experienced professionals.</p>
        <a href="patient.php" class="btn-hero">Book Appointment</a>
    </div>
</section>

<!-- ================= SERVICES SECTION ================= -->
<section id="services" class="services">
    <div class="container">
        <h2 class="text-center">Our Medical Services</h2>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="service-card">
                    <i class="bi bi-heart-pulse service-icon"></i>
                    <h3>Cardiology</h3>
                    <p>Advanced heart treatments & checkups with expert cardiologists.</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="service-card">
                    <i class="bi bi-clipboard2-pulse service-icon"></i>
                    <h3>General Checkup</h3>
                    <p>Complete health diagnosis and routine medical consultation.</p>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="service-card">
                    <i class="bi bi-truck service-icon"></i>
                    <h3>24x7 Emergency</h3>
                    <p>Emergency care and ambulance support anytime, anywhere.</p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ================= DOCTORS SECTION ================= -->
<section id="doctors" class="doctors">
    <div class="container">
        <h2 class="text-center">Our Doctors</h2>
        
        <div class="doctor-grid">
            <?php
            $query = "SELECT id, name, specialization, photo FROM doctors ORDER BY id DESC";
            $result = $conn->query($query);

            if ($result && $result->num_rows > 0) {
                while ($doc = $result->fetch_assoc()) {
                    $name = htmlspecialchars($doc['name']);
                    $spec = htmlspecialchars($doc['specialization']);
                    $photo = !empty($doc['photo']) 
                            ? "uploads/doctors/" . $doc['photo'] 
                            : "uploads/doctors/default-doctor.jpg";

            ?>
            
            <div class="doctor-card">
                <img src="<?= $photo ?>" 
                     alt="<?= $name ?>"
                     onerror="this.src='uploads/doctors/default-doctor.jpg';">
                <h3><?= $name ?></h3>
                <p class="spec"><?= $spec ?></p>
            </div>
            
            <?php
                }
            }
            ?>
        </div>
    </div>
</section>


<!-- ================= CONTACT SECTION ================= -->
<section id="contact" class="contact">
    <div class="container">
        <h2 class="text-center">Contact Us</h2>
        
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <form action="php/contact.php" method="POST" class="contact-form" id="contactForm">
                    <input type="text" name="name" placeholder="Your Name" required />
                    <input type="email" name="email" placeholder="Your Email" required />
                    <textarea name="message" placeholder="Your Message" required></textarea>
                    <button type="submit" class="contact-btn">Send Message</button>
                </form>
                
                <div id="popupMessage" class="popup-message" style="display:none"></div>
            </div>
        </div>
    </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="footer">
    <div class="footer-center">
        © 2025 CarePlus Hospital
    </div>
    
    <div class="footer-login-links">
        <a href="doctor/login.php">Doctor Login</a>
        <a href="admin/login.php">Admin Login</a>
    </div>
</footer>

<!-- Bootstrap JS for mobile toggle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS -->
<script src="js/scripts.js"></script>
</body>
</html>