<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$vehicle_id = $_GET['vehicle_id'] ?? null;
if (!$vehicle_id) {
    header("Location: our_vehicles.php");};

// Fetch vehicle info
$stmt = $conn->prepare("SELECT * FROM vehicles WHERE id = ?");
$stmt->bind_param("i", $vehicle_id);
$stmt->execute();
$result = $stmt->get_result();
$vehicle = $result->fetch_assoc();
if (!$vehicle) die("Vehicle not found.");

$category = strtolower($vehicle['category']);
$is_bike = $category === 'bike';

// Fetch user info
$user_stmt = $conn->prepare("SELECT name, email, profile_picture FROM users WHERE id = ?");
if (!$user_stmt) {
    die("Query preparation failed: " . $conn->error);
}
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_res = $user_stmt->get_result();
$user = $user_res->fetch_assoc();
$name = htmlspecialchars($user['name']);
$email = htmlspecialchars($user['email']);
$pic = $user['profile_picture'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Book Vehicle | FlexiRide</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .vehicle-img {
      width: 100%;
      object-fit: cover;
    }
    .profile-pic {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #0d6efd;
    }
    .card-box {
      background: white;
      border-radius: 10px;
      padding: 25px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .hidden {
      display: none;
    }
    .section-heading {
      font-weight: 600;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

<div class="container my-5">
  <div class="row justify-content-between align-items-center mb-4" data-aos="fade-down">
    <div class="col-lg-8">   
       <!-- Back button -->
    <div class="mb-3">
      <a href="javascript:history.back()" class="btn btn-outline-secondary" data-aos="fade-down">
        ← Back
      </a>
    </div>
      <h2 class="section-heading text-primary fw-bold display-5 mb-4" data-aos="fade-right">Book <?= htmlspecialchars($vehicle['name']) ?>
      </h2>

    </div>
    <div class="col-lg-4 text-end">
      <?php if (!empty($pic)): ?>
        <img src="uploads/<?= $pic ?>" class="profile-pic me-2" alt="Profile">
      <?php endif; ?>
      <strong><?= $name ?></strong><br>
      <small><?= $email ?></small>
    </div>
  </div>

  <div class="row g-4">
 <div class="col-md-5" data-aos="zoom-in">
      <div class="card-box">
        <img src="uploads/<?= $vehicle['image_path'] ?>" alt="<?= $vehicle['name'] ?>" class="vehicle-img mb-3">
        <p><strong>Category:</strong> <?= htmlspecialchars($vehicle['category']) ?></p>
        <p><strong>Rate:</strong> ₹<?= $vehicle['price_per_day'] ?>/day</p>
      </div>
    </div>

    <div class="col-md-7" data-aos="fade-left">
      <div class="card-box">
        <form method="POST" action="process_booking.php" onsubmit="return validateForm()">
          <input type="hidden" name="vehicle_id" value="<?= $vehicle['id'] ?>">
          <input type="hidden" name="vehicle_category" value="<?= $vehicle['category'] ?>">

          <div class="mb-3">
            <label class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Pickup Time</label>
            <input type="time" name="pickup_time" id="pickup_time" class="form-control" required>
          </div>

          <?php if ($category === 'car'): ?>
          <div class="mb-3">
            <label class="form-label">Driver Option</label>
            <select class="form-select" name="driver_option" id="driver_option" onchange="toggleDriverFields()">
              <option value="Self-drive">Self-drive</option>
              <option value="With driver">With driver</option>
            </select>
          </div>
          <?php else: ?>
            <input type="hidden" name="driver_option" value="Self-drive">
          <?php endif; ?>

          <div class="mb-3">
            <label class="form-label">Pickup Location</label>
            <select class="form-select" name="pickup_location" id="pickup_select" required>
              <option value="Ratu Road">Ratu Road</option>
              <option value="Kanke">Kanke</option>
              <option value="Harmu">Harmu</option>
              <option value="Lalpur">Lalpur</option>
              <option value="Morabadi">Morabadi</option>
              <option value="custom" id="customOption">Custom Location</option>
            </select>
            <input type="text" name="pickup_location_custom" id="custom_input" class="form-control mt-2 hidden" placeholder="Enter custom pickup location">
          </div>

          <?php if ($is_bike): ?>
          <div class="mb-3">
            <label class="form-label">Need Extra Helmet? (₹99)</label><br>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="extra_helmet" value="1" id="helmetYes">
              <label class="form-check-label" for="helmetYes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="extra_helmet" value="0" id="helmetNo" checked>
              <label class="form-check-label" for="helmetNo">No</label>
            </div>
          </div>
          <?php else: ?>
            <input type="hidden" name="extra_helmet" value="0">
          <?php endif; ?>

          <div id="driverFeeBox" class="alert alert-info hidden">Driver Fee: ₹<span id="driver_fee_text">0</span> per day</div>
          <input type="hidden" name="driver_fee" id="driver_fee" value="0">

          <div class="alert alert-warning">
            Estimated Total: ₹<span id="total_price_preview"><?= $vehicle['price_per_day'] ?></span>
          </div>

          <button type="submit" class="btn btn-primary w-100">Confirm Booking</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- AOS JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
AOS.init();

function toggleDriverFields() {
  const driverOption = document.getElementById("driver_option").value;
  const customOption = document.getElementById("customOption");
  const customInput = document.getElementById("custom_input");
  const feeBox = document.getElementById("driverFeeBox");
  const feeText = document.getElementById("driver_fee_text");
  const feeInput = document.getElementById("driver_fee");
  const days = calculateDays();

  if (driverOption === "With driver") {
    customOption.classList.remove("hidden");
    feeBox.classList.remove("hidden");
    feeText.innerText = 799;
    feeInput.value = 799 * days;
  } else {
    customOption.classList.add("hidden");
    customInput.classList.add("hidden");
    feeBox.classList.add("hidden");
    feeText.innerText = 0;
    feeInput.value = 0;
  }
  updateTotalPrice();
}

document.getElementById("pickup_select").addEventListener("change", function () {
  const customInput = document.getElementById("custom_input");
  if (this.value === "custom") {
    customInput.classList.remove("hidden");
    customInput.setAttribute("name", "pickup_location");
  } else {
    customInput.classList.add("hidden");
    customInput.removeAttribute("name");
  }
});

function calculateDays() {
  const start = new Date(document.getElementById("start_date").value);
  const end = new Date(document.getElementById("end_date").value);
  if (!start || !end || start > end) return 1;
  const timeDiff = end - start;
  return Math.floor(timeDiff / (1000 * 3600 * 24)) + 1;
}

function updateTotalPrice() {
  const pricePerDay = <?= $vehicle['price_per_day'] ?>;
  const days = calculateDays();
  const driverFee = parseInt(document.getElementById("driver_fee").value) || 0;
  const helmet = document.querySelector('input[name="extra_helmet"]:checked')?.value == "1" ? 99 : 0;
  const total = (pricePerDay * days) + driverFee + helmet;
  document.getElementById("total_price_preview").innerText = total;
}

function validateForm() {
  const start = document.getElementById("start_date").value;
  const end = document.getElementById("end_date").value;
  if (!start || !end || new Date(start) > new Date(end)) {
    alert("End date must be after or same as start date.");
    return false;
  }
  return true;
}

document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("start_date").addEventListener("change", updateTotalPrice);
  document.getElementById("end_date").addEventListener("change", updateTotalPrice);
  if (document.getElementById("driver_option")) {
    document.getElementById("driver_option").addEventListener("change", toggleDriverFields);
  }
  if (document.getElementById("helmetYes")) {
    document.getElementById("helmetYes").addEventListener("change", updateTotalPrice);
    document.getElementById("helmetNo").addEventListener("change", updateTotalPrice);
  }
});
</script>
</body>
</html>
