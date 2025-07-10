<?php
require_once "db.php";
$vehicles = $conn->query("SELECT * FROM vehicles");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Our Vehicles | FlexiRide</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/our_vehiclesstyle.css">
</head>
<body>
<div class="nav-wrapper">
  <div class="navbar-container">
    <a href="index.php" class="btn">Home</a>
    <a href="our_vehicles.php" class="btn">Vehicles</a>
    <a href="contact.php" class="btn">Contact</a>
    <a href="about.php" class="btn">About</a>
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
        <label>
          <input type="radio" class="radio-input" name="categoryFilter" value="all" checked>
          <span class="radio-tile">
            <i class="fas fa-list"></i>
            <span>All</span>
          </span>
        </label>
        <label>
          <input type="radio" class="radio-input" name="categoryFilter" value="car">
          <span class="radio-tile">
            <i class="fas fa-car"></i>
            <span>Car</span>
          </span>
        </label>
        <label>
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
  <div class="item">
    <a href="#" class="link">
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
      <div class="col-md-4 mb-4 vehicle-card" data-category="<?= htmlspecialchars($row['category']) ?>">
        <div class="flip-card">
          <div class="flip-card-inner">
            <div class="flip-card-front">
              
              <img src="uploads/<?= $row['image_path'] ?>" alt="Image" class="img-fluid " style="height: 150px;">
              <h5><?= htmlspecialchars($row['name']) ?></h5>
              <p class="mt-2 text-muted text-uppercase small"><?= htmlspecialchars($row['subcategory']) ?></p>
              <p><strong>₹<?= $row['price_per_day'] ?>/day</strong></p>
            </div>
            <div class="flip-card-back d-flex flex-column justify-content-center">
              <h6>Features:</h6>
              <p class="small"><?= nl2br(htmlspecialchars($row['features'])) ?></p>
              <h6>Ready For Ride!</h6>
              
              <a href="book.php?vehicle_id=<?= $row['id'] ?>" class="btn btn-light mt-2">Book Now</a>
            </div>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div></div>

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



</body>
</html>
