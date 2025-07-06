<?php
session_start();
require_once "../db.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$allowed = ['id', 'name', 'price_per_day', 'category'];
$sort_by = in_array($sort_by, $allowed) ? $sort_by : 'id';

$result = $conn->query("SELECT * FROM vehicles ORDER BY $sort_by ASC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Vehicles | FlexiRide Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #fdfaf6;
    }
    table img {
      width: 100px;
      height: auto;
      border-radius: 6px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">FlexiRide Admin</a>
    <div class="ms-auto">
      <a href="logout.php" class="btn btn-outline-light">Logout</a>
    </div>
  </div>
</nav>

<div class="container py-5">
  <h2 class="mb-4 text-center">All Vehicles</h2>

  <?php if ($result->num_rows > 0): ?>
    <div class="table-responsive row">
        <div class="col-6"><a href="dashboard.php" class="btn btn-outline-secondary">⬅ Back to Dashboard</a></div>
        <div class=" col-6 mb-3 d-flex justify-content-end">
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

      <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Subcategory</th>
            <th>Price/Day (₹)</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><img src="../uploads/<?= $row['image_path'] ?>" alt="<?= $row['name'] ?>"></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= ucfirst($row['category']) ?></td>
            <td><?= ucfirst($row['subcategory']) ?></td>
            <td><?= $row['price_per_day'] ?></td>
            <td>
              <a href="edit_vehicle.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
      <div class="text-center mt-4">
        <a href="dashboard.php" class="btn btn-outline-secondary">⬅ Back to Dashboard</a>
    </div>
    </div>
  <?php else: ?>
    <div class="alert alert-info">No vehicles found.</div>
  <?php endif; ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
