<?php
session_start();
require_once "../db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Profile | FlexiRide</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #fdfaf6;
    }
    .profile-pic {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
    }
  </style>
</head>
<body>

<div class="container py-5">
  <h3 class="text-center mb-4">My Profile</h3>

  <div class="card p-4 shadow">
    <div class="row">
      <div class="col-md-3 text-center">
        <?php if (!empty($user['profile_picture'])): ?>
          <img src="../uploads/<?= $user['profile_picture'] ?>" alt="Profile Picture" class="profile-pic mb-3">
        <?php else: ?>
          <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded-circle" style="width: 120px; height: 120px;">N/A</div>
        <?php endif; ?>
      </div>
      <div class="col-md-9">
        <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Phone:</strong> <?= htmlspecialchars($user['phone']) ?></p>
      </div>
    </div>
  </div>

  <div class="text-center mt-4">
    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
  </div>
</div>

</body>
</html>
