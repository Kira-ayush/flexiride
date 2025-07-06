<?php
session_start();
require '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$user_stmt = $conn->prepare("SELECT name, profile_picture FROM users WHERE id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user = $user_result->fetch_assoc();
$profile_img = !empty($user['profile_picture']) ? "../uploads/" . $user['profile_picture'] : "../uploads/default_user.png";

// Fetch all bookings
$sql = "SELECT b.*, v.name AS vehicle_name 
        FROM bookings b 
        JOIN vehicles v ON b.vehicle_id = v.id 
        WHERE b.user_id = ? 
        ORDER BY b.start_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$total_bookings = $result->num_rows;

// Fetch only 3 most recent bookings
$recent_stmt = $conn->prepare("SELECT b.*, v.name AS vehicle_name 
        FROM bookings b 
        JOIN vehicles v ON b.vehicle_id = v.id 
        WHERE b.user_id = ? 
        ORDER BY b.start_date DESC 
        LIMIT 3");
$recent_stmt->bind_param("i", $user_id);
$recent_stmt->execute();
$recent_result = $recent_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard | FlexiRide</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa, #e0eafc);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .dashboard-card {
            border-radius: 20px;
            overflow: hidden;
        }
        .btn-custom {
            min-width: 200px;
            margin: 8px 0;
        }
        .btn-custom i {
            margin-right: 8px;
        }
        .profile-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            margin-top: -60px;
            background-color: white;
        }
        .badge-status {
            font-size: 0.9rem;
            padding: 5px 10px;
        }
        .booking-card {
            border: 1px solid #dee2e6;
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 10px;
            background-color: #ffffff;
        }
        footer {
            text-align: center;
            padding: 20px;
            margin-top: 40px;
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="text-center mb-3">
        <h5 id="greeting" class="text-secondary"></h5>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card dashboard-card shadow-lg text-center">
                <div class="card-header bg-primary text-white py-4 position-relative">
                    <h3 class="mb-0">Welcome, <?= htmlspecialchars($user['name']) ?></h3>
                </div>
                <img src="<?= $profile_img ?>" class="profile-img mx-auto mt-0" alt="Profile Image">
                <div class="card-body">
                    <p class="lead mb-4">You're logged in to your FlexiRide dashboard</p>

                    <!-- Total Bookings -->
                    <div class="alert alert-info">
                        <strong><i class="fas fa-calendar-check"></i> Total Bookings:</strong> <?= $total_bookings ?>
                    </div>

                    <!-- Action Buttons -->
                    <a href="myprofile.php" class="btn btn-outline-primary btn-custom">
                        <i class="fas fa-user"></i> My Profile
                    </a><br>
                    <a href="edit_profile.php" class="btn btn-outline-secondary btn-custom">
                        <i class="fas fa-user-edit"></i> Edit Profile
                    </a><br>
                    <a href="mybookings.php" class="btn btn-outline-success btn-custom">
                        <i class="fas fa-car"></i> My Bookings
                    </a><br>
                    <a href="logout.php" class="btn btn-outline-danger btn-custom">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="mt-4">
                <h5 class="text-center mb-3"><i class="fas fa-clock"></i> Recent Bookings</h5>
                <?php if ($recent_result->num_rows > 0): ?>
                    <?php while ($row = $recent_result->fetch_assoc()): ?>
                        <div class="booking-card">
                            <div class="d-flex justify-content-between">
                                <strong><?= htmlspecialchars($row['vehicle_name']) ?></strong>
                                <?php
                                    $status = strtolower($row['status']);
                                    $badge = 'secondary';
                                    if ($status === 'confirmed') $badge = 'success';
                                    elseif ($status === 'pending') $badge = 'warning';
                                    elseif ($status === 'rejected') $badge = 'danger';
                                ?>
                                <span class="badge bg-<?= $badge ?> badge-status text-capitalize"><?= $status ?></span>
                            </div>
                            <small><i class="fas fa-calendar-day"></i> <?= htmlspecialchars($row['start_date']) ?> to <?= htmlspecialchars($row['end_date']) ?></small>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="text-center text-muted">No recent bookings found.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer>
    <p>&copy; <?= date('Y') ?> FlexiRide | Need help? <a href="contact.php">Contact Support</a></p>
</footer>

<!-- JavaScript for Greeting -->
<script>
    const greetingEl = document.getElementById('greeting');
    const hour = new Date().getHours();
    let greetingText = "Hello";

    if (hour < 12) {
        greetingText = "Good morning 👋";
    } else if (hour < 17) {
        greetingText = "Good afternoon ☀️";
    } else {
        greetingText = "Good evening 🌙";
    }

    greetingEl.textContent = greetingText;
</script>
</body>
</html>
