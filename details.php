<?php
require_once "db.php";

if (!isset($_GET['id'])) {
    die("Vehicle not specified.");
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM vehicles WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$vehicle = $result->fetch_assoc();

if (!$vehicle) {
    die("Vehicle not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($vehicle['name']) ?> | FlexiRide</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <style>
        body {
            background-color: #fdfaf6;
            font-family: 'Segoe UI', sans-serif;
        }
        .vehicle-img {
            width: 100%;
            max-height: 400px;
            object-fit: contain;
        }
        .info-box, .spec-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }
        .feature-item, .spec-item {
            background: #f8fafc;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 8px;
            transition: background 0.3s ease, transform 0.3s ease;
            cursor: default;
        }
        .feature-item:hover, .spec-item:hover {
            background: #e0f7fa;
            transform: translateX(5px);
        }
    </style>
</head>
<body>

<div class="container py-5">
    <!-- Back button and Heading -->
    <div class="row mb-4 align-items-center">
        <div class="col-md-6 text-start">
            <a href="our_vehicles.php" class="btn btn-outline-secondary">&larr; Back</a>
        </div>
        <div class="col-md-6 text-center">
            <h2><?= htmlspecialchars($vehicle['name']) ?></h2>
        </div>
    </div>

    <!-- Image and Info -->
    <div class="row g-4 align-items-start mb-4">
        <div class="col-md-6" data-aos="fade-right">
            <img src="uploads/<?= htmlspecialchars($vehicle['image_path']) ?>" alt="<?= htmlspecialchars($vehicle['name']) ?>" class="vehicle-img">
        </div>
        <div class="col-md-6" data-aos="fade-left">
            <div class="info-box">
                <p><strong>Category:</strong> <?= ucfirst($vehicle['category']) ?> / <?= ucfirst($vehicle['subcategory']) ?></p>
                <p><strong>Price per day:</strong> ₹<?= $vehicle['price_per_day'] ?></p>
                <p class="mt-3"><?= nl2br(htmlspecialchars($vehicle['description'])) ?></p>
                <a href="book.php?vehicle_id=<?= $vehicle['id'] ?>" class="btn btn-success mt-3">Book Now</a>
            </div>
        </div>
    </div>

    <!-- Features and Specs -->
    <div class="row g-4">
        <div class="col-md-6" data-aos="fade-up">
            <div class="spec-box">
                <h5 class="mb-3">🚗 Key Features</h5>
                <?php foreach (explode(',', $vehicle['features']) as $feature): ?>
                    <div class="feature-item"><?= htmlspecialchars(trim($feature)) ?></div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="spec-box">
                <h5 class="mb-3">⚙️ Key Specifications</h5>
                <?php foreach (explode(',', $vehicle['key_specifications']) as $spec): ?>
                    <div class="spec-item"><?= htmlspecialchars(trim($spec)) ?></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
