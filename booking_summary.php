<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch latest booking
$sql = "SELECT b.*, v.name AS vehicle_name, v.category, v.image_path, u.name, u.email, u.profile_picture
        FROM bookings b
        JOIN vehicles v ON b.vehicle_id = v.id
        JOIN users u ON b.user_id = u.id
        WHERE b.user_id = ?
        ORDER BY b.id DESC
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Booking | FlexiRide</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
  <style>
    body {
      background-color: #f9f9f9;
    }
    .vehicle-img {
      width: 100%;
      object-fit: contain;
      height: 220px;
      padding: 10px;
      background-color: #fff;
      border-radius: 8px;
      max-height: 300px;
    }
        .vehicle-img:hover {
                    transform: translateY(-6px);
                    box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
                    transition: 0.3s ease;
                   }    
    .profile-pic {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      object-fit: cover;
    }
  </style>
</head>
<body>
<div class="container mt-5" data-aos="fade-up">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Booking</h2>
    <?php if ($booking): ?>
      <div class="text-end">
        <?php if (!empty($booking['profile_picture'])): ?>
          <a href="user/dashboard.php"><img src="uploads/<?= $booking['profile_picture'] ?>" class="profile-pic me-2" alt="User"></a>
        <?php endif; ?>
        <strong><?= htmlspecialchars($booking['name']) ?></strong><br>
        <small><?= htmlspecialchars($booking['email']) ?></small>
      </div>
    <?php endif; ?>
  </div>

  <?php if ($booking): ?>
    <div class="card shadow-sm p-3 bg-white" data-aos="fade-up">
      <img src="uploads/<?= $booking['image_path'] ?>" class="vehicle-img mb-3" alt="<?= $booking['vehicle_name'] ?>">

      <h4 class="fw-semibold"><?= htmlspecialchars($booking['vehicle_name']) ?> (<?= ucfirst($booking['category']) ?>)</h4>

      <p><strong>Start:</strong> <?= htmlspecialchars($booking['start_date']) ?> | 
         <strong>End:</strong> <?= htmlspecialchars($booking['end_date']) ?></p>

      <p><strong>Pickup:</strong> <?= htmlspecialchars($booking['pickup_location']) ?> 
        <?= $booking['pickup_time'] ? '@ ' . htmlspecialchars($booking['pickup_time']) : '' ?></p>

      <p><strong>Driver Option:</strong> <?= htmlspecialchars($booking['driver_option']) ?></p>

      <?php if (strtolower($booking['category']) === 'bike'): ?>
        <p><strong>Helmet:</strong> <?= $booking['extra_helmet'] ? 'Yes (+₹99)' : 'No' ?></p>
      <?php endif; ?>

      <?php if ($booking['driver_fee'] > 0): ?>
        <p><strong>Driver Fee:</strong> ₹<?= number_format($booking['driver_fee'], 2) ?></p>
      <?php endif; ?>

      <p><strong>Total:</strong> ₹<?= number_format($booking['total_price'], 2) ?></p>

      <p><strong>Status:</strong> 
        <span class="badge bg-<?= $booking['status'] == 'confirmed' ? 'success' : ($booking['status'] == 'rejected' ? 'danger' : 'warning') ?>">
          <?= ucfirst($booking['status']) ?>
        </span>
      </p>
    </div>
  <?php else: ?>
    <div class="alert alert-info">You have not made any bookings yet.</div>
  <?php endif; ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
