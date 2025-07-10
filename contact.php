<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us | FlexiRide</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
  background-color: #fff4ee;
  font-family: 'Segoe UI', sans-serif;
  padding-top: 100px;
}
    .nav-wrapper {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  background: transparent;
  display: flex;
  justify-content: center;
  padding: 10px 0;
  z-index: 1000;
  
}

.navbar-container {
  background: #0d1b2a;
  display: flex;
  gap: 30px;
  padding: 8px 24px;
  border-radius: 12px;
}

.btn {
  color: #fff;
  text-decoration: none;
  padding: 6px 14px;
  font-size: 15px;
  font-weight: 500;
  border-radius: 6px;
  transition: background 0.2s;
}
  </style>
</head>
<body >

<!-- Navbar -->
<header class="nav-wrapper">
  <div class="navbar-container">
    <a href="index.php" class="btn">Home</a>
    <a href="our_vehicles.php" class="btn">Vehicles</a>
    <a href="contact.php" class="btn ">Contact</a>
    <a href="about.php" class="btn ">About</a>
  </div>
</header>

<!-- Contact Section -->
<section class="py-5">
  <div class="container">
    <div class="text-center mb-4">
      <h2 class="fw-bold">Contact Us</h2>
      <p class="text-muted">We're here to help. Reach out for inquiries or support.</p>
    </div>
    <div class="row">
      <!-- Contact Form -->
      <div class="col-md-7 mb-4">
      <form action="submit_contact.php" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label fw-semibold">Message</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary px-4">Send Message</button>
    </form>

      </div>
      <!-- Contact Info -->
      <div class="col-md-5">
        <h5 class="fw-bold mb-3">Get in Touch</h5>
        <p><i class="fas fa-map-marker-alt me-2 text-primary"></i> Ranchi, Jharkhand, India</p>
        <p><i class="fas fa-envelope me-2 text-danger"></i> support@flexiride.com</p>
        <p><i class="fas fa-phone me-2 text-success"></i> +91 98765 43210</p>
        <p><i class="fas fa-clock me-2 text-warning"></i> Mon - Sat: 9:00 AM - 6:00 PM</p>
        <div class="mt-3">
          <a href="#" class="me-3 text-dark"><i class="fab fa-facebook fa-lg"></i></a>
          <a href="#" class="me-3 text-dark"><i class="fab fa-twitter fa-lg"></i></a>
          <a href="#" class="me-3 text-dark"><i class="fab fa-instagram fa-lg"></i></a>
          <a href="#" class="me-3 text-dark"><i class="fab fa-linkedin fa-lg"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
  &copy; 2025 FlexiRide. All Rights Reserved.
</footer>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
