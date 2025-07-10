<?php
session_start();
require_once "db.php";
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
}
$vehicles = $conn->query("SELECT * FROM vehicles");


$userLoggedIn = false;
$userProfilePic = '';

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $userLoggedIn = true;

    // Fetch user data (profile_picture)
    $stmt = $conn->prepare("SELECT profile_picture,name FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $userProfilePic = $user['profile_picture'] ?? 'default_user.png'; // fallback if null
    
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Our Vehicles | FlexiRide</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="css/our_vehiclesstyle.css">
</head>
<body>
<div class="nav-wrapper d-flex justify-content-between align-items-center px-3">
  <div class="navbar-box animate__animated animate__jackInTheBox mx-auto">
    <a href="index.php" class="btn animate__animated animate__zoomIn animate__delay-1s">Home</a>
    <a href="our_vehicles.php" class="btn animate__animated animate__zoomIn animate__delay-1s">Vehicles</a>
    <a href="contact.php" class="btn animate__animated animate__zoomIn animate__delay-1s">Contact</a>
    <a href="about.php" class="btn animate__animated animate__zoomIn animate__delay-1s">About</a>
  </div>
  <div class="login-button-wrapper">
    <?php if ($userLoggedIn): ?>
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-primary text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="uploads/<?= htmlspecialchars($userProfilePic) ?>" alt="Profile" width="40" height="40" class="rounded-circle animate__animated animate__zoomInDown me-2">
          <span class="animate__animated animate__zoomInRight animate__delay-1s"><?= explode(' ', $user['name'])[0] ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="user/dashboard.php">Dashboard</a></li>
          <li><a class="dropdown-item" href="booking_summary.php">My Bookings</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="user/logout.php">Logout</a></li>
        </ul>
      </div>
    <?php else: ?>
      <button data-bs-toggle="modal" data-bs-target="#loginModal">
          Login
          <span></span>
        </a>
      </button>
    <?php endif; ?>
  </div>
</div>


<div class="container py-4">
  <h2 class="text-center mb-4">Explore Our Vehicles</h2>
<div class="container">
  <div class="row gy-4 align-items-center justify-content-between mb-4">
    <!-- Search Input -->
    <div class="col-md-4">
      <div class="input-container">
        <input
          class="input"
          id="searchInput"
          type="text"
          placeholder="Search vehicles..."
        />
      </div>
    </div>

    <!-- Category Filter -->
    <div class="col-md-4 d-flex justify-content-center">
      <div class="radio-inputs">
        <label class="animate__animated animate__bounceIn ">
          <input type="radio" class="radio-input " name="categoryFilter" value="all" checked>
          <span class="radio-tile">
            <i class="fas fa-list"></i>
            <span>All</span>
          </span>
        </label>
        <label class="animate__animated animate__bounceIn animate__delay-1s">
          <input type="radio" class="radio-input" name="categoryFilter" value="car">
          <span class="radio-tile">
            <i class="fas fa-car"></i>
            <span>Car</span>
          </span>
        </label>
        <label class="animate__animated animate__bounceIn animate__delay-1s">
          <input type="radio" class="radio-input" name="categoryFilter" value="bike">
          <span class="radio-tile">
            <i class="fas fa-motorcycle"></i>
            <span>Bike</span>
          </span>
        </label>
      </div>
    </div>

    <!-- Sort Dropdown -->
    <div class="col-md-3 d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
<div class="menu">
  <div class="item animate__animated animate__fadeInDownBig">
    <a href="#" class="link ">
      <span> Sort By </span>
      <svg viewBox="0 0 360 360" xml:space="preserve">
        <path d="M325.607,79.393c-5.857-5.857-15.355-5.858-21.213,0.001l-139.39,139.393L25.607,79.393c-5.857-5.857-15.355-5.858-21.213,0.001c-5.858,5.858-5.858,15.355,0,21.213l150.004,150c2.813,2.813,6.628,4.393,10.606,4.393s7.794-1.581,10.606-4.394l149.996-150C331.465,94.749,331.465,85.251,325.607,79.393z"/>
      </svg>
    </a>
    <div class="submenu">
      <div class="submenu-item"><a href="#" class="submenu-link" data-sort="price-asc">Price: Low to High</a></div>
      <div class="submenu-item"><a href="#" class="submenu-link" data-sort="price-desc">Price: High to Low</a></div>
      <div class="submenu-item"><a href="#" class="submenu-link" data-sort="name-asc">Name: A-Z</a></div>
      <div class="submenu-item"><a href="#" class="submenu-link" data-sort="name-desc">Name: Z-A</a></div>
    </div>
  </div>
</div>

    </div>
  </div>
</div>

  <!-- Vehicle Grid -->
  <div class="row" id="vehicleGrid">
    <?php while ($row = $vehicles->fetch_assoc()): ?>
      <div class="col-12 col-sm-6 col-md-4 mb-4 vehicle-card animate__animated animate__fadeInLeftBig animate__delay-1s" data-category="<?= htmlspecialchars($row['category']) ?>">
        <div class="flip-card">
          <div class="flip-card-inner">
            <div class="flip-card-front">
              <img src="uploads/<?= $row['image_path'] ?>" alt="Image" class="img-fluid " style="height: 150px;">
              <h5><?= htmlspecialchars($row['name']) ?></h5>
              <p class="mt-2 text text-uppercase small"><?= htmlspecialchars($row['subcategory']) ?></p>
              <p><strong>₹<?= $row['price_per_day'] ?>/day</strong></p>
            </div>
            <div class="flip-card-back d-flex flex-column justify-content-center">
              <h6>Features:</h6>
              <p><?= nl2br(htmlspecialchars($row['features'])) ?></p>
              
              <a href="book.php?vehicle_id=<?= $row['id'] ?>" class="btn btn-info mt-2">Book Now</a>
              <a href="details.php?id=<?= $row['id'] ?>" class="btn btn-info mt-2">View Details</a><br>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div></div>
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
          <a href="user/register.php" class="btn btn-outline-secondary w-100 rounded-pill" style="background-color: teal;">Don't have an account? Register</a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const radios = document.querySelectorAll('input[name="categoryFilter"]');
  const vehicleCards = document.querySelectorAll('.vehicle-card');
  const searchInput = document.getElementById('searchInput');
  const sortLinks = document.querySelectorAll('.submenu-link');

  // Handle category filter and search
  radios.forEach(radio => radio.addEventListener('change', filterVehicles));
  searchInput.addEventListener('input', filterVehicles);

  function filterVehicles() {
    const selectedCategory = document.querySelector('input[name="categoryFilter"]:checked').value.toLowerCase();
    const searchTerm = searchInput.value.toLowerCase();

    vehicleCards.forEach(card => {
      const name = card.querySelector('h5')?.textContent.toLowerCase() || '';
      const subcat = card.querySelector('p.text-uppercase')?.textContent.toLowerCase() || '';
      const category = card.dataset.category.toLowerCase();

      const matchesSearch = name.includes(searchTerm) || subcat.includes(searchTerm);
      const matchesCategory = selectedCategory === 'all' || category === selectedCategory;

      card.style.display = (matchesSearch && matchesCategory) ? 'block' : 'none';
    });
  }

  // Handle sorting from submenu
  sortLinks.forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
      const sortType = link.dataset.sort;
      sortVehicles(sortType);
    });
  });

  function sortVehicles(sortBy) {
    const container = document.getElementById('vehicleGrid');
    const cards = Array.from(container.querySelectorAll('.vehicle-card'));

    cards.sort((a, b) => {
      const priceA = parseFloat(a.querySelector('strong')?.textContent.replace(/[^\d.]/g, '')) || 0;
      const priceB = parseFloat(b.querySelector('strong')?.textContent.replace(/[^\d.]/g, '')) || 0;
      const nameA = a.querySelector('h5')?.textContent.toLowerCase() || '';
      const nameB = b.querySelector('h5')?.textContent.toLowerCase() || '';

      switch (sortBy) {
        case 'price-asc': return priceA - priceB;
        case 'price-desc': return priceB - priceA;
        case 'name-asc': return nameA.localeCompare(nameB);
        case 'name-desc': return nameB.localeCompare(nameA);
        default: return 0;
      }
    });

    // Re-append sorted cards
    container.innerHTML = '';
    cards.forEach(card => container.appendChild(card));
  }
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
