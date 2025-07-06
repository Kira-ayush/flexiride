<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

require_once '../db.php';

if (!isset($_SESSION['admin_name'])) {
    $stmt = $conn->prepare("SELECT name FROM admins WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['admin_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();
    $_SESSION['admin_name'] = $admin['name'] ?? 'Admin';
}
?>

<!-- Internal CSS for Sidebar -->
<style>
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

  @media (max-width: 768px) {
    .sidebar {
      transform: translateX(-220px);
      transition: transform 0.3s ease;
    }

    .sidebar.show {
      transform: translateX(0);
    }
  }
</style>

<!-- Toggle Button for Mobile -->
<button class="toggle-btn d-md-none" onclick="document.querySelector('.sidebar').classList.toggle('show')">
  <i class="fas fa-bars"></i>
</button>

<!-- Sidebar -->
<div class="sidebar d-flex flex-column">
  <div class="profile border-bottom">
    <img src="../images/default_admin.png" alt="Admin">
    <h6><?= htmlspecialchars($_SESSION['admin_name']) ?></h6>
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

<!-- Internal JS for Sidebar -->
<script>
  function toggleSubmenu(el) {
    el.parentElement.classList.toggle('open');
  }

  document.querySelector('.toggle-btn')?.addEventListener('click', function () {
    document.querySelector('.sidebar')?.classList.toggle('show');
  });
</script>
