<?php
session_start();
require_once "../db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$result = $conn->query("SELECT * FROM vehicles");
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Vehicles | FlexiRide Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3 class="text-center mb-4">All Vehicles</h3>
    <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Price/Day</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($v = $result->fetch_assoc()): ?>
            <tr>
                <td><img src="../uploads/<?= $v['image_path'] ?>" width="80" height="60" style="object-fit:cover;"></td>
                <td><?= htmlspecialchars($v['name']) ?></td>
                <td><?= $v['category'] ?></td>
                <td><?= $v['subcategory'] ?></td>
                <td>₹<?= $v['price_per_day'] ?></td>
                <td>
                    <a href="edit_vehicle.php?id=<?= $v['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="delete_vehicle.php?id=<?= $v['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this vehicle?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <div class="text-center mt-3">
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</div>
</body>
</html>
