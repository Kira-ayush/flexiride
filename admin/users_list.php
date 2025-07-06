<?php
session_start();
require_once "../db.php";
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
include 'admin_sidebar.php';

// Delete user
if (isset($_POST['delete']) && isset($_POST['delete_id'])) {
    $delete_id = (int) $_POST['delete_id'];
    $conn->query("DELETE FROM users WHERE id = $delete_id");
    header("Location: users_list.php");
    exit;
}

// Search logic
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email LIKE ? OR phone LIKE ? ORDER BY id DESC");
    $like = "%$search%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM users ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Users List | FlexiRide Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #fdfaf6;
    }
    .profile-pic {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 50%;
    }
    .main-content {
      margin-left: 220px;
      padding: 20px;
    }
    @media (max-width: 768px) {
      .main-content {
        margin-left: 0;
        padding-top: 60px;
      }
    }
  </style>
</head>
<body>

<div class="main-content">
  <div class="container">
    <h2 class="text-center mb-4">All Registered Users</h2>

    <div class="row mb-3">
      <div class="col-md-6">
        
      </div>
      <div class="col-md-6">
        <form method="GET" class="d-flex justify-content-end">
          <input type="text" name="search" class="form-control" placeholder="Search by email or phone" value="<?= htmlspecialchars($search) ?>">
          <button type="submit" class="btn btn-dark ms-2">Search</button>
        </form>
      </div>
    </div>

    <?php if ($result->num_rows > 0): ?>
      <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Profile</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php while ($user = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $user['id'] ?></td>
              <td>
                <?php if (!empty($user['profile_picture'])): ?>
                  <img src="../uploads/<?= htmlspecialchars($user['profile_picture']) ?>" class="profile-pic" alt="Profile">
                <?php else: ?>
                  <span class="text-muted">N/A</span>
                <?php endif; ?>
              </td>
              <td><?= htmlspecialchars($user['name']) ?></td>
              <td><?= htmlspecialchars($user['email']) ?></td>
              <td><?= htmlspecialchars($user['phone']) ?></td>
              <td>
                <a href="user_profile.php?id=<?= $user['id'] ?>" class="btn btn-sm btn-primary mb-1">View</a>
                <form method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                  <input type="hidden" name="delete_id" value="<?= $user['id'] ?>">
                  <button type="submit" name="delete" class="btn btn-sm btn-danger mb-1">Delete</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="alert alert-info text-center">No users found.</div>
    <?php endif; ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
