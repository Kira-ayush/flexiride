<?php
session_start();
require '../db.php'; // adjust path if needed

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location:login.php");
    exit();
}

// Handle confirmation or rejection
if (isset($_GET['action']) && isset($_GET['id'])) {
    $bookingId = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action == 'confirm') {
        $stmt = $conn->prepare("UPDATE bookings SET status = 'Confirmed' WHERE id = ?");
    } elseif ($action == 'reject') {
        $stmt = $conn->prepare("UPDATE bookings SET status = 'Rejected' WHERE id = ?");
    }

    if (isset($stmt)) {
        $stmt->bind_param("i", $bookingId);
        $stmt->execute();
        header("Location: admin_bookings.php");
        exit();
    }
}

// Fetch all bookings with vehicle and user info
$sql = "
    SELECT b.*, v.name AS vehicle_name, u.name AS user_name
    FROM bookings b
    JOIN vehicles v ON b.vehicle_id = v.id
    JOIN users u ON b.user_id = u.id
    ORDER BY b.id DESC
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Booking Management | FlexiRide</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            overflow-x: auto;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="text-center mb-4">Booking Management</h2>

    <div class="table-container">
        <table class="table table-bordered table-striped table-hover shadow-sm">
            <thead class="table-dark text-center">
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Vehicle</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Pickup Time</th>
                <th>Pickup Location</th>
                <th>Driver Option</th>
                <th>Driver Fee</th>
                <th>Helmet</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="text-center align-middle">
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['user_name']) ?> (#<?= $row['user_id'] ?>)</td>
                        <td><?= htmlspecialchars($row['vehicle_name']) ?> (#<?= $row['vehicle_id'] ?>)</td>
                        <td><?= $row['start_date'] ?></td>
                        <td><?= $row['end_date'] ?></td>
                        <td><?= $row['pickup_time'] ?></td>
                        <td><?= htmlspecialchars($row['pickup_location']) ?></td>
                        <td><?= $row['driver_option'] ?></td>
                        <td>₹<?= $row['driver_fee'] ?? '0' ?></td>
                        <td><?= $row['extra_helmet'] === 'yes' ? 'Yes' : 'No' ?></td>
                        <td>₹<?= $row['total_price'] ?></td>
                        <td>
                            <?php
                            $status = $row['status'];
                            $badge = match($status) {
                                'Pending' => 'warning',
                                'Confirmed' => 'success',
                                'Rejected' => 'danger',
                                default => 'secondary',
                            };
                            ?>
                            <span class="badge bg-<?= $badge ?>"><?= $status ?></span>
                        </td>
                        <td><?= $row['created_at'] ?></td>
                        <td>
                            <?php if ($status === 'Pending'): ?>
                                <a href="?action=confirm&id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Confirm</a>
                                <a href="?action=reject&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Reject</a>
                            <?php else: ?>
                                <em class="text-muted">No actions</em>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr class="text-center"><td colspan="14">No bookings found.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <a href="dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
    </div>
</div>
</body>
</html>
