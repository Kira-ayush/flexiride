<?php
session_start();
require '../db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch all vehicles
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$allowed = ['id', 'name', 'price_per_day', 'category'];
$sort_by = in_array($sort_by, $allowed) ? $sort_by : 'id';

$result = $conn->query("SELECT * FROM vehicles ORDER BY $sort_by ASC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Vehicles | Admin | FlexiRide</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .vehicle-img { height: 60px; width: auto; border-radius: 6px; }
    .table thead th { background-color: #343a40; color: white; }
  </style>
</head>
<body>
<div class="container mt-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Back to Dashboard</a>
    <h3 class="fw-bold">All Vehicles</h3>
      <form method="GET" class="d-flex gap-2">
    <label for="sort" class="form-label me-2 fw-bold mt-2">Sort by:</label>
    <select name="sort" id="sort" class="form-select w-auto" onchange="this.form.submit()">
      <option value="id" <?= $sort_by == 'id' ? 'selected' : '' ?>># (ID)</option>
      <option value="name" <?= $sort_by == 'name' ? 'selected' : '' ?>>Name</option>
      <option value="price_per_day" <?= $sort_by == 'price_per_day' ? 'selected' : '' ?>>Price</option>
      <option value="category" <?= $sort_by == 'category' ? 'selected' : '' ?>>Category</option>
    </select>
  </form>
  </div>

  <?php if ($result->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Subcategory</th>
            <th>Price/Day</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td>
                <img src="../uploads/<?= htmlspecialchars($row['image_path']) ?>" class="vehicle-img" alt="<?= $row['name'] ?>">
              </td>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= ucfirst($row['category']) ?></td>
              <td><?= htmlspecialchars($row['subcategory']) ?></td>
              <td>₹<?= number_format($row['price_per_day'], 2) ?></td>
              <td><span class="badge bg-success">Active</span></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-warning text-center">No vehicles found.</div>
  <?php endif; ?>
</div>
</body>
</html>
