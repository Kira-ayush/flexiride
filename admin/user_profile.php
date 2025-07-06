<?php
session_start();
require_once "../db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("User not specified.");
}

$user_id = (int)$_GET['id'];

// Fetch user info
$user_stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user = $user_stmt->get_result()->fetch_assoc();

if (!$user) {
    die("User not found.");
}

// Fetch bookings (optional)
$booking_stmt = $conn->prepare("SELECT b.*, v.name AS vehicle_name FROM bookings b JOIN vehicles v ON b.vehicle_id = v.id WHERE b.user_id = ? ORDER BY b.id DESC");
$booking_stmt->bind_param("i", $user_id);
$booking_stmt->execute();
$bookings = $booking_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile | FlexiRide Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #fdfaf6;
    }
    img.profile-pic {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">FlexiRide Admin</a>
    <div class="ms-auto">
      <a href="logout.php" class="btn btn-outline-light">Logout</a>
    </div>
  </div>
</nav>

<div class="container py-5">
  <a href="users_list.php" class="btn btn-outline-secondary mb-4">&larr; Back to Users</a>

  <div class="card p-4 mb-5">
    <div class="row">
      <div class="col-md-3 text-center">
        <?php if (!empty($user['profile_picture'])): ?>
          <img src="../uploads/<?= $user['profile_picture'] ?>" class="profile-pic mb-3">
        <?php else: ?>
          <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:120px;height:120px;">N/A</div>
        <?php endif; ?>
      </div>
      <div class="col-md-9">
        <h4>User Info</h4>
        <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
        <p><strong>User ID:</strong> <?= $user['id'] ?></p>
      </div>
    </div>
  </div>

  <div>
    <h4>Booking History</h4>
    <?php if ($bookings->num_rows > 0): ?>
      <table class="table table-bordered table-striped">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Vehicle</th>
            <th>Start</th>
            <th>End</th>
            <th>Total Price</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($b = $bookings->fetch_assoc()): ?>
            <tr>
              <td><?= $b['id'] ?></td>
              <td><?= htmlspecialchars($b['vehicle_name']) ?></td>
              <td><?= $b['start_date'] ?></td>
              <td><?= $b['end_date'] ?></td>
              <td>₹<?= $b['total_price'] ?></td>
              <td><?= $b['status'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="text-muted">No bookings found.</p>
    <?php endif; ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
