<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>About Us | FlexiRide</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/about.css">
</head>
<body>

<!-- Navbar -->
<header class="nav-wrapper">
  <div class="navbar-container">
    <a href="index.php" class="btn">Home</a>
    <a href="our_vehicles.php" class="btn">Vehicles</a>
    <a href="contact.php" class="btn">Contact</a>
    <a href="about.php" class="btn active">About</a>
  </div>
</header>

<!-- About Section -->
<div class="container about-section text-center">
    <div class="container">
      <!-- Section Heading -->
      <div class="text-center mb-5" data-aos="fade-in-right">
        <h1 class="fw-bold">About FlexiRide</h1>
        <p class="lead ">Your trusted partner for self-drive and chauffeur-based vehicle rentals across India.</p>
      </div>
      <!-- Row: Image + Intro -->
      <div class="row align-items-center mb-5 ">
        <div class="col-md-6 mb-4 mb-md-0" data-aos="fade-in-left">
          <img src="images/about.png" class="img-fluid rounded shadow" alt="About FlexiRide">
        </div>
        <div class="col-md-6" data-aos="fade-in-left">
          <h3>Who We Are</h3>
          <p>
            FlexiRide is a next-generation vehicle rental service offering complete flexibility. Whether you're a daily
            commuter, a weekend explorer, or a traveler needing a chauffeur, we've got the right vehicle for you.
          </p>
          <h4 class="mt-4">Why Choose Us?</h4>
          <ul class="list-unstyled">
            <li>✅ Diverse fleet of vehicles</li>
            <li>✅ Affordable and transparent pricing</li>
            <li>✅ 24/7 support and booking flexibility</li>
            <li>✅ Trusted by thousands of happy riders</li>
          </ul>
        </div>
      </div>
      <!-- Row: Mission, Vision, Values -->
      <div class="row text-center" data-aos="zoom-in">
        <div class="col-md-4 mb-4">
          <div class="about-box p-4 rounded shadow-sm h-100 text-center">
            <h5 class="fw-bold">🚀 Our Mission</h5>
            <p>To empower users with easy, affordable, and flexible transportation — anywhere, anytime.</p>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="about-box p-4 rounded shadow-sm h-100 text-center">
            <h5 class="fw-bold">🌍 Our Vision</h5>
            <p>To be India’s most trusted and loved mobility partner, redefining how people move.</p>
          </div>
        </div>
        <div class="col-md-4 mb-4">
          <div class="about-box p-4 rounded shadow-sm h-100 text-center">
            <h5 class="fw-bold">💡 Core Values</h5>
            <p>Customer-first service, safety, transparency, innovation, and a love for the road.</p>
          </div>
        </div>
      </div>
      <!-- Call to Action -->
      <div class="text-center mt-4">
        <a href="book.php" class="btn btn-primary btn-lg">Start Your Ride Now</a>
      </div>
    </div><hr>
</body>
</html>
