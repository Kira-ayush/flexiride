<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- To improve discoverability and track usage -->
  <meta name="description"
    content="Book self-drive or chauffeur-driven rides across India with FlexiRide. Affordable, flexible, and safe.">
  <meta name="keywords" content="vehicle rental India, self-drive, FlexiRide, book car, book bike">
  <!--style css-->
  <link rel="stylesheet" href="css/style.css">
  <!-- Font dm-serif-text-regular-->
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" rel="stylesheet">
  <!-- Font Awesome CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- Bootstrap css and js -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <!-- AOS CSS -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <!-- Title with icon -->
  <title>FLEXIRIDE</title>
  <link href="images/icon.png" rel="icon" type="image/png">
</head>
<body>
  <!-- Navbar Start -->
  <!-- Navbar Start -->
   <header>
<nav class="navbar navbar-expand-lg navbar-dark" id="navbar">
  <div class="container">
    <a class="navbar-brand" href="#"><img src="images/icon.png" alt="FlexiRide Logo" width="45" height="45" class="d-inline-block align-text-top me-2">FLEXIRIDE</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
        <li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
        <li class="nav-item"><a class="nav-link" href="#vehicles">Vehicles</a></li>
        <li class="nav-item"><a class="nav-link" href="#review">Testimonials</a></li>
        <li class="nav-item"><a class="nav-link" href="#team">Our Team</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Contact Us</a></li>
      </ul>

      <?php if (isset($_SESSION['user_id'])): 
          require 'db.php'; // make sure DB is connected
          $uid = $_SESSION['user_id'];
          $stmt = $conn->prepare("SELECT name, profile_picture FROM users WHERE id = ?");
          $stmt->bind_param("i", $uid);
          $stmt->execute();
          $result = $stmt->get_result();
          $user = $result->fetch_assoc();
          $profile_img = !empty($user['profile_picture']) ? $user['profile_picture'] : 'images/default_user.png';
      ?>
      <!-- Profile Dropdown -->
      <div class="dropdown ms-lg-3">
        <a class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
          <img src="uploads/<?= $user['profile_picture'] ?>" alt="Profile" class="rounded-circle me-2" width="40" height="40">
          <span><?= explode(' ', $user['name'])[0] ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="user/dashboard.php">Dashboard</a></li>
          <li><a class="dropdown-item" href="booking_summary.php">My Bookings</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="user/logout.php">Logout</a></li>
        </ul>
      </div>
      <?php else: ?>
        <button class="btn btn-outline-light ms-lg-3" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
      <?php endif; ?>

    </div>
  </div>
</nav>
</header>

  <!-- Navbar End -->
  <!-- Home Section-->
  <section id="hero">
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000">
      <div class="carousel-inner">
        <!-- Slide 1 -->
        <div class="carousel-item active">
          <img src="images/C1.png" class= "img-fluid d-block w-100" alt="...">
          <div
            class="carousel-caption d-flex flex-column justify-content-center align-items-center text-center dm-serif-text-regular">
            <h1 class="display-1 fw-bold hero-title">FlexiRide</h1>
            <p class="sub">Your Ride, Your Way</p>
            <p class=" lead sub2">Self-Drive or Chauffeur, You Choose.</p>
            <a href="book.php" class="btn btn-outline-light btn-lg mt-3">Book Now</a>
          </div>
        </div>
        <!-- Slide 2 -->
        <div class="carousel-item">
          <img src="images/C2.png" class="img-fluid d-block w-100" alt="...">
          <div
            class="carousel-caption d-flex flex-column justify-content-center align-items-center text-center dm-serif-text-regular">
            <h1 class="display-1 fw-bold hero-title ">FlexiRide</h1>
            <p class="lead sub">Go Where You Feel Alive</p>
            <p class=" lead sub2">Self-drive freedom that lets you explore at your own pace.</p>
            <a href="book.php" class="btn btn-outline-light btn-lg mt-3">Book Now</a>
          </div>
        </div>
        <!-- Slide 3 -->
        <div class="carousel-item">
          <img src="images/C3.png" class="img-fluid  d-block w-100" alt="...">
          <div
            class="carousel-caption d-flex flex-column justify-content-center align-items-center text-center dm-serif-text-regular">
            <h1 class="display-1 fw-bold hero-title">FlexiRide</h1>
            <p class="lead sub">Comfortable Rides, Anytime</p>
            <p class=" lead sub2">Professional drivers for your comfort and convenience.</p>
            <a href="book.php" class="btn btn-outline-light btn-lg mt-3">Book Now</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Home End -->
  <!-- About Start -->
  <section id="about" class="py-5 ">
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
    </div>
  </section>
  <!-- About End -->
  <!-- Service Start -->
  <section id="services" class="py-5 ">
    <div class="container">
      <div class="text-center mb-5" data-aos="zoom-in-down">
        <h2 class="fw-bold">Our Services</h2>
        <p class="lead text-muted">FlexiRide offers flexible rental solutions to suit every journey.</p>
      </div>
      <div class="row text-center g-4">
        <!-- Service 1 -->
        <div class="col-md-4" data-aos="zoom-in-down">
          <div class="service-box p-4 rounded shadow-sm h-100">
            <div class="icon mb-3 fs-1">🚗</div>
            <h5 class="fw-bold">Self-Drive Rentals</h5>
            <p>Enjoy complete freedom with our well-maintained fleet of cars and bikes. Rent by the hour, day, or week.
            </p>
          </div>
        </div>
        <!-- Service 2 -->
        <div class="col-md-4" data-aos="zoom-in-down">
          <div class="service-box p-4 rounded shadow-sm h-100">
            <div class="icon mb-3 fs-1">🧑‍✈️</div>
            <h5 class="fw-bold">Chauffeur Service</h5>
            <p>Travel in comfort and style with our trained and professional drivers for business or leisure trips.</p>
          </div>
        </div>
        <!-- Service 3 -->
        <div class="col-md-4" data-aos="zoom-in-down">
          <div class="service-box p-4 rounded shadow-sm h-100">
            <div class="icon mb-3 fs-1 ">📍</div>
            <h5 class="fw-bold">Doorstep Delivery</h5>
            <p>We deliver the vehicle to your preferred location, making your rental experience seamless and
              hassle-free.</p>
          </div>
        </div>
        <!-- Service 4 -->
        <div class="col-md-4" data-aos="zoom-in-up">
          <div class="service-box p-4 rounded shadow-sm h-100">
            <div class="icon mb-3 fs-1 ">🛠️</div>
            <h5 class="fw-bold">24/7 Roadside Assistance</h5>
            <p>Drive worry-free with our around-the-clock roadside support across supported cities.</p>
          </div>
        </div>
        <!-- Service 5 -->
        <div class="col-md-4" data-aos="zoom-in-up">
          <div class="service-box p-4 rounded shadow-sm h-100">
            <div class="icon mb-3 fs-1">💳</div>
            <h5 class="fw-bold">Flexible Payment Options</h5>
            <p>Pay online or offline with multiple secure methods including UPI, cards, and wallets.</p>
          </div>
        </div>
        <!-- Service 6 -->
        <div class="col-md-4" data-aos="zoom-in-up">
          <div class="service-box p-4 rounded shadow-sm h-100">
            <div class="icon mb-3 fs-1">🧼</div>
            <h5 class="fw-bold">Sanitized Vehicles</h5>
            <p>Every vehicle is cleaned and sanitized after every trip to ensure your safety and hygiene.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Service End -->
  <!-- Pricing section -->
  <section id="pricing" class="py-5 " style="background-color:  #FDFAF6;">
    <div class="container text-center">
      <h2 class="fw-bold mb-4" data-aos="fade-down">Our Pricing Plans</h2>
      <p class="lead text-muted mb-5" data-aos="fade-down">Flexible rental options for two-wheelers and four-wheelers to
        suit every journey.</p>
      <!-- Two-Wheelers -->
      <h4 class="mb-4" data-aos="fade-down">Two-Wheeler Plans</h4>
      <div class="row g-4 mb-5">
        <div class="col-md-4" data-aos="fade-left">
          <div class="card h-100 shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Basic Ride</h5>
              <p class="text-muted">Perfect for short trips.</p>
              <h6 class="fw-bold mb-3">₹399 / Day</h6>
              <ul class="list-unstyled mb-4">
                <li>✅ 100 km limit</li>
                <li>✅ Helmet included</li>
                <li>❌ Roadside Assistance</li>
              </ul>
              <a href="our_vehicles.php?search=&category=bike&subcategory=basic" class="btn btn-outline-primary">Book Now</a>
            </div>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-left" data-aos-delay="100">
          <div class="card h-100 shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Standard Ride</h5>
              <p class="text-muted">Ideal for day-long city exploration.</p>
              <h6 class="fw-bold mb-3">₹499 / Day</h6>
              <ul class="list-unstyled mb-4">
                <li>✅ 200 km limit</li>
                <li>✅ Helmet & Phone mount</li>
                <li>✅ Roadside Assistance</li>
              </ul>
              <a href="our_vehicles.php?search=&category=bike&subcategory=standard" class="btn btn-outline-primary">Book Now</a>
            </div>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-left" data-aos-delay="200">
          <div class="card h-100 shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Adventure Ride</h5>
              <p class="text-muted">Long trips and tours.</p>
              <h6 class="fw-bold mb-3">₹699 / Day</h6>
              <ul class="list-unstyled mb-4">
                <li>✅ Unlimited km</li>
                <li>✅ Dual helmets</li>
                <li>✅ Roadside + Trip Support</li>
              </ul>
              <a href="our_vehicles.php?search=&category=bike&subcategory=adventurous" class="btn btn-outline-primary">Book Now</a>
            </div>
          </div>
        </div>
      </div>
      <!-- Four-Wheelers -->
      <h4 class="mb-4" data-aos="fade-down">Four-Wheeler Plans</h4>
      <div class="row g-4">
        <div class="col-md-4" data-aos="fade-right">
          <div class="card h-100 shadow-sm">
            <div class="card-body">
              <h5 class="card-title">City Compact</h5>
              <p class="text-muted">Best for local commutes.</p>
              <h6 class="fw-bold mb-3">₹999 / Day</h6>
              <ul class="list-unstyled mb-4">
                <li>✅ 150 km limit</li>
                <li>✅ AC Hatchback options</li>
              </ul>
              <a href="our_vehicles.php?search=&category=car&subcategory=hatchback" class="btn btn-outline-primary">Book Now</a>
            </div>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-right" data-aos-delay="100">
          <div class="card h-100 shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Comfort Drive</h5>
              <p class="text-muted">Family trips made easy.</p>
              <h6 class="fw-bold mb-3">₹1499 / Day</h6>
              <ul class="list-unstyled mb-4">
                <li>✅ 250 km limit</li>
                <li>✅ Sedan options</li>
                <li>✅ Roadside Support</li>
              </ul>
              <a href="our_vehicles.php?search=&category=car&subcategory=sedan" class="btn btn-outline-primary">Book Now</a>
            </div>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-right" data-aos-delay="200">
          <div class="card h-100 shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Luxury Chauffeur</h5>
              <p class="text-muted">Corporate or special events.</p>
              <h6 class="fw-bold mb-3">₹2299 / Day</h6>
              <ul class="list-unstyled mb-4">
                <li>✅ Unlimited km</li>
                <li>✅ SUV options</li>
                <li>✅ Premium AC</li>
                <li>✅ Full Insurance</li>
              </ul>
              <a href="our_vehicles.php?search=&category=car&subcategory=suv" class="btn btn-outline-primary">Book Now</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Pricing section End -->
  <!-- Vehicle section -->
  <section id="vehicles" class="py-5 " style="background-color: #FAF1E6;">
    <div class="container text-center">
      <h2 class="fw-bold mb-4" data-aos="zoom-in-left">Our Vehicles</h2>
      <p class="lead text-muted mb-5" data-aos="zoom-in-left">Choose from our wide range of well-maintained cars and
        bikes for your perfect journey.</p>
      <div class="row g-4" data-aos="zoom-in-right">
        <!-- Vehicle 1 -->
        <div class="col-md-4">
          <div class="card shadow-sm h-100">
            <img src="images/MarutiSwift_hatchback.png" class="card-img-top" alt="Hatchback">
            <div class="card-body">
              <a href="details.php?id=2" class="me-3 text-dark">
                <h5 class="card-title">Maruti Swift</h5>
              </a>
              <p class="card-text">Ideal for city rides with great mileage and easy handling.</p>
              <p class="text-muted">Starting at ₹499/day</p>
              <a href="book.php?vehicle_id=2" class="btn btn-outline-primary">Book Now</a>
            </div>
          </div>
        </div>
        <!-- Vehicle 2 -->
        <div class="col-md-4">
          <div class="card shadow-sm h-100">
            <img src="images/MarutiSuzuki_Sedan.png" class="card-img-top" alt="Sedan">
            <div class="card-body">
              <a href="details.php?id=7" class="me-3 text-dark">
                <h5 class="card-title">Maruti Dzire</h5>
              </a>
              <p class="card-text">Spacious and elegant, perfect for long-distance journeys.</p>
              <p class="text-muted">Starting at ₹899/day</p>
              <a href="book.php?vehicle_id=7" class="btn btn-outline-primary">Book Now</a>
            </div>
          </div>
        </div>
        <!-- Vehicle 3 -->
        <div class="col-md-4">
          <div class="card shadow-sm h-100">
            <img src="images/bullet.png" class="card-img-top" alt="Bike">
            <div class="card-body">
              <a href="details.php?id=31" class="me-3 text-dark">
                <h5 class="card-title">Royal Enfield</h5>
              </a>
              <p class="card-text">Powerful and rugged — great for highway trips and adventure rides.</p>
              <p class="text-muted">Starting at ₹699/day</p>
              <a href="book.php?vehicle_id=31" class="btn btn-outline-primary">Book Now</a>
            </div>
          </div>
        </div>
      </div>
      <div class="mt-4">
        <a href="our_vehicles.php" class="btn btn-primary">View All Vehicles</a>
      </div>
    </div>
  </section>
  <!-- Vehicle section End -->
  <!-- Review Section -->
  <section id="review" class="py-5" style="background-color: #FDFAF6;" data-aos="fade-left">
    <div class="text-center mb-5">
      <h2 class="fw-bold">Testimonials</h2>
      <p class="lead"> Hear from some of our satisfied clients who have shared their experiences.
        We value their feedback and strive to provide the best service possible every time.</p>
    </div>
    <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"
          aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3" aria-label="Slide 4"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="4" aria-label="Slide 5"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="5" aria-label="Slide 6"></button>
        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="6" aria-label="Slide 7"></button>
      </div>
      <div class="carousel-inner inner">
        <div class="carousel-item active rev" data-bs-interval="4000">
          <div class="container">
            <div class="row align-items-center ">
              <!-- Left Column: Image -->
              <div class="col-md-6 text-center">
                <img src="images/anita.jpg" class="d-block w-50" alt="...">
              </div>
              <div class="col-md-6 review-box">
                <h4>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i><br>
                  Anita Kumari
                </h4>
                <p>"Very satisfied! Would definitely use the service again."</p>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item rev" data-bs-interval="3000">
          <div class="container">
            <div class="row align-items-center">
              <!-- Left Column: Image -->
              <div class="col-md-6 text-center">
                <img src="images/anu.jpg" class="d-block w-50" alt="...">
              </div>
              <div class="col-md-6 review-box">
                <h4>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i><br>
                  Anjali Khandait
                </h4>
                <p>"Absolutely amazing experience! The service exceeded all expectations."</p>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item rev" data-bs-interval="3000">
          <div class="container">
            <div class="row align-items-center">
              <!-- Left Column: Image -->
              <div class="col-md-6 text-center">
                <img src="images/rahul.jpg" class="d-block w-50" alt="...">
              </div>
              <div class="col-md-6 review-box">
                <h4>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i><br>
                  Rahul Kumar
                </h4>
                <p>"Professional, punctual, and friendly. Would highly recommend them!"</p>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item rev" data-bs-interval="3000">
          <div class="container">
            <div class="row align-items-center">
              <!-- Left Column: Image -->
              <div class="col-md-6 text-center">
                <img src="images/aadi.jpg" class="d-block w-50" alt="...">
              </div>
              <div class="col-md-6 review-box">
                <h4>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star-half-stroke "></i><br>
                  Aditya Kumar
                </h4>
                <p>"Flawless from start to finish. Truly impressed by the team’s dedication."</p>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item rev" data-bs-interval="3000">
          <div class="container">
            <div class="row align-items-center">
              <!-- Left Column: Image -->
              <div class="col-md-6 text-center">
                <img src="images/prerna.jpg" class="d-block w-50" alt="...">
              </div>
              <div class="col-md-6 review-box">
                <h4>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i><br>
                  Prerna Singh
                </h4>
                <p>"Couldn’t have asked for better service. Truly top-class experience."</p>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item rev" data-bs-interval="3000">
          <div class="container">
            <div class="row align-items-center">
              <!-- Left Column: Image -->
              <div class="col-md-6 text-center">
                <img src="images/bittu.jpg" class="d-block w-50" alt="...">
              </div>
              <div class="col-md-6 review-box">
                <h4>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i><br>
                  Bittu Kumar Saw
                </h4>
                <p>"Excellent quality and outstanding support. Keep up the great work!"</p>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item rev">
          <div class="container">
            <div class="row align-items-center">
              <!-- Left Column: Image -->
              <div class="col-md-6 text-center">
                <img src="images/dhiraj.jpg" class="d-block" alt="...">
              </div>
              <div class="col-md-6 review-box">
                <h4>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star " aria-hidden="true"></i>
                  <i class="fa-solid fa-star-half-stroke "></i><br>
                  Dhiraj Kumar
                </h4>
                <p>Some representative placeholder content for the first slide.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Review Section -->
  <!-- Team Section -->
  <section id="team" class="py-5 " data-aos="zoom-out-right">
    <div class="container text-center">
      <h2 class="fw-bold mb-3">Our Team</h2>
      <p class="lead mb-5">Meet the passionate minds behind FlexiRide — dedicated to redefining how India rides.</p>
      <!-- Clickable Avatars -->
      <div class="mb-4 d-flex justify-content-center gap-3">
        <img src="images/m1-icon.png" class="rounded-circle shadow team-avatar" width="100" height="100" alt="Ayush"
          onclick="showProfile('ayush')">
        <img src="images/m2-icon.png" class="rounded-circle shadow team-avatar" width="100" height="100" alt="Anjali"
          onclick="showProfile('jyoti')">
        <img src="images/m3-icon.png" class="rounded-circle shadow team-avatar" width="100" height="100" alt="Rohan"
          onclick="showProfile('rajan')">
      </div>
      <!-- Profiles -->
      <div id="ayush" class="team-profile row align-items-center mt-4">
        <div class="col-md-5 text-center mb-4 mb-md-0">
          <img src="images/ayush.jpg" class="img-fluid rounded shadow border border-5 border-light" alt="Ayush Kumar">
        </div>
        <div class="col-md-7 text-start">
          <h3 class="fw-bold">Ayush Kumar</h3>
          <p class="text-muted mb-2">Founder & CEO</p>
          <p class="text-secondary">
            "Ayush Kumar is the visionary force behind FlexiRide. As both Founder and CEO, he leads with passion,
            guiding the company's mission to offer flexible, affordable, and modern transportation solutions across
            India."
          </p>
        </div>
      </div>
      <div id="jyoti" class="team-profile row align-items-center mt-4 d-none">
        <div class="col-md-5 text-center mb-4 mb-md-0">
          <img src="images/jyoti.jpg" class="img-fluid rounded shadow border border-5 border-light" alt="Jyoti Kumari">
        </div>
        <div class="col-md-7 text-start">
          <h3 class="fw-bold">Jyoti Kumari</h3>
          <p class="text-muted mb-2">Operations Head</p>
          <p class="text-secondary">
            “Jyoti Kumari is the backbone of FlexiRide's operations. As Operations Head, she ensures the smooth
            functioning of daily processes, manages logistics, coordinates staff, and maintains service quality across
            all our locations. Her organizational excellence keeps FlexiRide running like a well-oiled engine.”
          </p>
        </div>
      </div>
      <div id="rajan" class="team-profile row align-items-center mt-4 d-none">
        <div class="col-md-5 text-center mb-4 mb-md-0">
          <img src="images/rajan.jpg" class="img-fluid rounded shadow border border-5 border-light"
            alt="Rajan Kumar Saha">
        </div>
        <div class="col-md-7 text-start">
          <h3 class="fw-bold">Rajan Kumar Saha</h3>
          <p class="text-muted mb-2">Tech Lead</p>
          <p class="text-secondary">
            “Rajan Kumar Saha leads the technological backbone of FlexiRide. As Tech Lead, he oversees web and mobile
            platform development, user experience improvements, security, and tech innovation. His technical vision
            powers the seamless booking experience our users love.”
          </p>
        </div>
      </div>
    </div>
  </section>
  <!-- Team Section End-->
  <!-- Contact Us Section -->
  <section id="contact" class="py-5" style="background-color: #FDFAF6;" data-aos="flip-up">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold">Contact Us</h2>
        <p class="lead">We're here to help. Reach out to us for inquiries, support, or partnership opportunities.</p>
      </div>
      <div class="row">
        <!-- Contact Form -->
        <div class="col-md-7 mb-4">
          <form action="contact_process.php" method="POST">
        <div class="mb-3">
          <label for="name" class="form-label fw-semibold">Full Name</label>
          <input type="text" name="name" class="form-control" id="name" placeholder="Enter your full name" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label fw-semibold">Email Address</label>
          <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email address" required>
        </div>
        <div class="mb-3">
          <label for="message" class="form-label fw-semibold">Message</label>
          <textarea name="message" class="form-control" id="message" rows="5" placeholder="Type your message here..." required></textarea>
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
          <div class="mt-4">
            <a href="#" class="me-3 text-dark"><i class="fab fa-facebook fa-lg"></i></a>
            <a href="#" class="me-3 text-dark"><i class="fab fa-twitter fa-lg"></i></a>
            <a href="#" class="me-3 text-dark"><i class="fab fa-instagram fa-lg"></i></a>
            <a href="#" class="me-3 text-dark"><i class="fab fa-linkedin fa-lg"></i></a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Contact Section End-->
  <!-- Footer Start -->
  <footer class="bg-dark text-white pt-4 pb-3 py-5">
    <div class="container">
      <div class="row">
        <!-- Brand Info -->
        <div class="col-md-4 mb-4">
          <h5 class="fw-bold">FlexiRide</h5>
          <p>Your ride, your way — across India. We offer reliable, affordable, and flexible self-drive and
            chauffeur-based vehicle rentals.</p>
        </div>
        <!-- Quick Links -->
        <div class="col-md-4 mb-4">
          <h6 class="fw-bold">Quick Links</h6>
          <ul class="list-unstyled">
            <li><a href="#home" class="text-white text-decoration-none">Home</a></li>
            <li><a href="#about" class="text-white text-decoration-none">About</a></li>
            <li><a href="#services" class="text-white text-decoration-none">Services</a></li>
            <li><a href="#team" class="text-white text-decoration-none">Team</a></li>
            <li><a href="#contact" class="text-white text-decoration-none">Contact</a></li>
          </ul>
        </div>
        <!-- Contact Info -->
        <div class="col-md-4 mb-4">
          <h6 class="fw-bold">Contact Us</h6>
          <p><i class="fas fa-envelope me-2 text-warning"></i> support@flexiride.com</p>
          <p><i class="fas fa-phone me-2 text-success"></i> +91 98765 43210</p>
          <div class="mt-3">
            <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-lg"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-lg"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-lg"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-linkedin fa-lg"></i></a>
          </div>
        </div>
      </div>
      <hr class="bg-secondary">
      <div class="text-center small">
        &copy; 2025 FlexiRide. All Rights Reserved.
      </div>
    </div>
  </footer>
  </section>
  <!-- Footer End -->
  <!-- Login Modal -->
<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow rounded-4">
      <div class="modal-header bg-dark text-white rounded-top-4">
        <h5 class="modal-title" id="loginModalLabel">Welcome Back</h5><br>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="user/login_process.php" method="POST" class="px-3 py-2">
        <div class="modal-body">
          <!-- Error Alert -->
          <?php if (!empty($_SESSION['login_error'])): ?>
            <div class="alert alert-danger py-2">
              <?= htmlspecialchars($_SESSION['login_error']) ?>
            </div>
            <?php unset($_SESSION['login_error']); ?>
          <?php endif; ?>

          <div class="mb-3">
            <input type="text" name="email_or_phone" class="form-control rounded-pill px-4 py-2" placeholder="Email or Phone" required>
          </div>
          <div class="mb-3">
            <input type="password" name="password" class="form-control rounded-pill px-4 py-2" placeholder="Password" required>
          </div>
        </div>
        <div class="modal-footer d-flex flex-column gap-2 px-4 pb-4">
          <button type="submit" class="btn w-100 rounded-pill text-white" style="background-color: teal;">Log in</button>
          <a href="user/register.php" class="btn btn-outline-secondary w-100 rounded-pill">Don't have an account? Register</a>
        </div>
      </form>
    </div>
  </div>
</div>


 
</body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="js/main.js"></script>

</html>