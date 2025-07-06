<?php
require_once "db.php";

// Pagination config
$limit = 6;
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$offset = ($page - 1) * $limit;

// Search/filter/sort
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$subcategory = $_GET['subcategory'] ?? '';
$sort = $_GET['sort'] ?? '';

$conditions = [];
$params = [];
$types = '';

if ($search) {
    $conditions[] = "name LIKE ?";
    $params[] = "%$search%";
    $types .= 's';
}
if ($category) {
    $conditions[] = "category = ?";
    $params[] = $category;
    $types .= 's';
}
if ($subcategory) {
    $conditions[] = "subcategory = ?";
    $params[] = $subcategory;
    $types .= 's';
}
$whereSQL = $conditions ? ('WHERE ' . implode(' AND ', $conditions)) : '';

$orderSQL = "ORDER BY id DESC";
if ($sort == 'price_asc') $orderSQL = "ORDER BY price_per_day ASC";
if ($sort == 'price_desc') $orderSQL = "ORDER BY price_per_day DESC";
if ($sort == 'name_asc') $orderSQL = "ORDER BY name ASC";
if ($sort == 'name_desc') $orderSQL = "ORDER BY name DESC";

// Count total
$countSQL = "SELECT COUNT(*) FROM vehicles $whereSQL";
$stmt = $conn->prepare($countSQL);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute(); $stmt->bind_result($total); $stmt->fetch(); $stmt->close();
$totalPages = ceil($total / $limit);

// Fetch data
$dataSQL = "SELECT * FROM vehicles $whereSQL $orderSQL LIMIT ? OFFSET ?";
$stmt = $conn->prepare($dataSQL);
if ($params) {
    $types .= 'ii'; $params[] = $limit; $params[] = $offset;
    $stmt->bind_param($types, ...$params);
} else {
    $stmt->bind_param("ii", $limit, $offset);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Our Vehicles | FlexiRide</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <style>
        body { 
            background-color: #f4f6f8; 
            }
        
        .card-img-top {
            object-fit: contain;
            height: 220px;
            padding: 10px;
            background-color: #fff;
            }

        .category-badge {
             font-size: 0.8rem; 
            }
        .card:hover {
                    transform: translateY(-6px);
                    box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
                    transition: 0.3s ease;
                   }
        .card-title {
            font-weight: 600;
        }
        .badge {
            font-size: 0.75rem;
        }

    </style>
</head>
<body>
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">FlexiRide</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="our_vehicles.php">Vehicles</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
        <li class="nav-item"><a class="nav-link btn btn-outline-success px-3 ms-2" href="user/login.php">Login</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">
    <h2 class="text-center mb-4" data-aos="fade-down">🚘 Explore Our Vehicles</h2>

    <form method="GET" class="row g-2 mb-4" data-aos="fade-up">
        <div class="col-md-3">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Search by name">
        </div>
        <div class="col-md-2">
            <select name="category" class="form-control">
                <option value="">All Categories</option>
                <option value="car" <?= $category == 'car' ? 'selected' : '' ?>>Car</option>
                <option value="bike" <?= $category == 'bike' ? 'selected' : '' ?>>Bike</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="subcategory" class="form-control">
                <option value="">All Subcategories</option>
                <?php
                $subRes = $conn->query("SELECT DISTINCT subcategory FROM vehicles WHERE subcategory IS NOT NULL AND subcategory != ''");
                while ($row = $subRes->fetch_assoc()):
                ?>
                    <option value="<?= $row['subcategory'] ?>" <?= $subcategory == $row['subcategory'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['subcategory']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-2">
            <select name="sort" class="form-control">
                <option value="">Sort</option>
                <option value="price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Price: Low → High</option>
                <option value="price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Price: High → Low</option>
                <option value="name_asc" <?= $sort == 'name_asc' ? 'selected' : '' ?>>Name: A-Z</option>
                <option value="name_desc" <?= $sort == 'name_desc' ? 'selected' : '' ?>>Name: Z-A</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
        </div>
    </form>

    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php $delay = 0; while ($row = $result->fetch_assoc()): $delay += 50; ?>
                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="<?= $delay ?>">
                    <div class="card h-100 shadow-sm">
                        <img src="uploads/<?= $row['image_path'] ?>" class="card-img-top" alt="<?= $row['name'] ?>">
                        <div class="card-body d-flex flex-column justify-content-between">
    <div>
        <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
        <span class="badge bg-secondary category-badge">
            <?= $row['category'] == 'car' ? '🚗 Car' : '🏍️ Bike' ?> - <?= ucfirst($row['subcategory']) ?>
        </span>
        <p class="text-muted mt-2" style="font-size: 0.9rem;">
            ₹<?= $row['price_per_day'] ?>/day
        </p>
    </div>

<?php
$features = array_filter(array_map('trim', explode(',', $row['features'])));
if (count($features) > 0): ?>
    <ul class="small ps-3 mb-2 text-muted">
        <?php foreach (array_slice($features, 0, 2) as $feature): ?>
            <li><?= htmlspecialchars($feature) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<a href="details.php?id=<?= $row['id'] ?>" class="btn btn-outline-primary w-100">View Details</a>

</div>

                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <div class="alert alert-warning">No vehicles found.</div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <nav class="mt-4">
            <ul class="pagination justify-content-center">
                <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                    <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $p])) ?>">
                            <?= $p ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>AOS.init();</script>

</body>
</html>
