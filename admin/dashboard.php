<?php
session_start();
require '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['admin_name'])) {
    $stmt = $conn->prepare("SELECT name FROM admins WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['admin_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $_SESSION['admin_name'] = $admin['name'] ?? 'Admin';
}

function getCount($conn, $query) {
    $result = $conn->query($query);
    return ($result && $row = $result->fetch_assoc()) ? $row['total'] : 0;
}

$vehicle_count = getCount($conn, "SELECT COUNT(*) AS total FROM vehicles");
$user_count = getCount($conn, "SELECT COUNT(*) AS total FROM users");
$booking_count = getCount($conn, "SELECT COUNT(*) AS total FROM bookings");
$pending_bookings = getCount($conn, "SELECT COUNT(*) AS total FROM bookings WHERE status = 'pending'");
$confirmed_bookings = getCount($conn, "SELECT COUNT(*) AS total FROM bookings WHERE status = 'confirmed'");
$message_count = getCount($conn, "SELECT COUNT(*) AS total FROM contact_messages");
$today = date('Y-m-d');
$todays_bookings = getCount($conn, "SELECT COUNT(*) AS total FROM bookings WHERE DATE(created_at) = '$today'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | FlexiRide</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Segoe UI', sans-serif;
      transition: background 0.3s, color 0.3s;
    }

    .sidebar {
      width: 220px;
      height: 100vh;
      position: fixed;
      background-color: #0d1b2a;
      overflow-y: auto;
      z-index: 1000;
    }

    .sidebar a {
      color: white;
      text-decoration: none;
      padding: 12px 20px;
      display: block;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: #1b263b;
    }

    .profile {
      text-align: center;
      padding: 20px 10px 10px;
    }

    .profile img {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      margin-bottom: 10px;
    }

    .toggle-btn {
      position: fixed;
      top: 15px;
      left: 15px;
      z-index: 1101;
      background: #0d1b2a;
      border: none;
      color: white;
      padding: 8px 12px;
      border-radius: 4px;
    }

    .submenu {
      padding-left: 20px;
      display: none;
    }

    .has-submenu.open .submenu {
      display: block;
    }

    .main-content {
      margin-left: 220px;
      padding: 20px;
    }

    .stats-card {
      border-radius: 10px;
      color: white;
    }

    .stat-icon {
      font-size: 1.4rem;
    }

    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-220px);
        transition: transform 0.3s ease;
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0;
        padding-top: 60px;
      }
    }
  </style>
</head>
<body>

<!-- Toggle button for mobile -->
<button class="toggle-btn d-md-none" onclick="document.querySelector('.sidebar').classList.toggle('show')">
  <i class="fas fa-bars"></i>
</button>

<!-- Sidebar -->
<div class="sidebar d-flex flex-column">
  <div class="profile border-bottom">
    <img src="../images/default_admin.png" alt="Admin">
    <h6 class="text-primary"><?= htmlspecialchars($_SESSION['admin_name']) ?></h6>
    <a href="admin_profile_edit.php" class="text-light small d-block mt-1">Edit Profile</a>
  </div>

  <a href="dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>

  <div class="has-submenu">
    <a href="javascript:void(0)" onclick="toggleSubmenu(this)">
      <i class="fas fa-car me-2"></i> Vehicles <i class="fas fa-chevron-down float-end"></i>
    </a>
    <div class="submenu">
      <a href="vehicle_list.php">All Vehicles</a>
      <a href="add_vehicle.php">Add Vehicle</a>
      <a href="edit_vehicle_list.php">Edit Vehicles</a>
    </div>
  </div>

  <a href="users_list.php"><i class="fas fa-users me-2"></i> Users</a>
  <a href="admin_bookings.php"><i class="fas fa-calendar-check me-2"></i> Bookings</a>
  <a href="view_contacts.php"><i class="fas fa-envelope me-2"></i> Contacts</a>
  <a href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
  <div class="container">
    <h2 class="mb-4 ">Welcome, <?= htmlspecialchars($_SESSION['admin_name']) ?>!</h2>
    <div class="row g-4">
      <div class="col-md-3" data-aos="fade-up">
        <div class="p-3 bg-primary stats-card shadow-sm text-center">
          <div class="stat-icon"><i class="fas fa-car"></i></div>
          <h6 class="mt-2"><?= $vehicle_count ?> Vehicles</h6>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
        <div class="p-3 bg-dark stats-card shadow-sm text-center">
          <div class="stat-icon"><i class="fas fa-users"></i></div>
          <h6 class="mt-2"><?= $user_count ?> Users</h6>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="200">
        <div class="p-3 bg-success stats-card shadow-sm text-center">
          <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
          <h6 class="mt-2"><?= $confirmed_bookings ?> Confirmed</h6>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="300">
        <div class="p-3 bg-warning stats-card shadow-sm text-center">
          <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
          <h6 class="mt-2"><?= $pending_bookings ?> Pending</h6>
        </div>
      </div>
      <div class="col-md-3" data-aos="fade-up" data-aos-delay="500">
      <div class="p-3 bg-secondary stats-card shadow-sm text-center">
        <div class="stat-icon"><i class="fas fa-list-alt"></i></div>
        <h6 class="mt-2"><?= $booking_count ?> Total Bookings</h6>
      </div>
    </div>
    <div class="col-md-3" data-aos="fade-up" data-aos-delay="600">
      <div class="p-3 bg-danger stats-card shadow-sm text-center">
        <div class="stat-icon"><i class="fas fa-calendar-day"></i></div>
        <h6 class="mt-2"><?= $todays_bookings ?> Booked Today</h6>
      </div>
    </div>

      <div class="col-md-3" data-aos="fade-up" data-aos-delay="400">
        <div class="p-3 bg-info stats-card shadow-sm text-center">
          <div class="stat-icon"><i class="fas fa-envelope"></i></div>
          <h6 class="mt-2"><?= $message_count ?> Messages</h6>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
  AOS.init();

  function toggleSubmenu(el) {
    el.parentElement.classList.toggle('open');
  }
</script>
</body>
</html>
