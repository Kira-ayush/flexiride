<?php
session_start();
require_once "../db.php";
include 'admin_sidebar.php';
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $price = $_POST['price'];
    $description = trim($_POST['description']);
    $features = trim($_POST['features']);
    $key_specifications = trim($_POST['key_specifications']);
    $image_path = "";

    if (!empty($_FILES["image"]["name"])) {
        $uploadDir = "../uploads/";
        $fileName = time() . "_" . basename($_FILES["image"]["name"]);
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadPath)) {
            $image_path = $fileName;
        } else {
            $message = "Failed to upload image.";
        }
    }

    if ($image_path) {
        $stmt = $conn->prepare("INSERT INTO vehicles (name, category, subcategory, price_per_day, description, features, key_specifications, image_path)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssissss", $name, $category, $subcategory, $price, $description, $features, $key_specifications, $image_path);

        if ($stmt->execute()) {
            $message = "✅ Vehicle added successfully!";
        } else {
            $message = "❌ Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Vehicle | FlexiRide Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <style>
        body {
            background: #f5f7fa;
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

        .form-section {
            max-width: 720px;
            margin: auto;
            padding: 40px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>
<div class="main-content">
<div class="container mt-5">
    <h3 class="text-center mb-4" data-aos="fade-down">🚗 Add New Vehicle</h3>

    <?php if ($message): ?>
        <div class="alert alert-info text-center"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="form-section" data-aos="zoom-in-up">
        <div class="mb-3" data-aos="fade-right">
            <label class="form-label">Vehicle Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="row mb-3" data-aos="fade-left">
            <div class="col-md-6">
                <label class="form-label">Category</label>
                <select name="category" id="category" class="form-control" required>
                    <option value="">Select category</option>
                    <option value="car">Car</option>
                    <option value="bike">Bike</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Subcategory</label>
                <select name="subcategory" id="subcategory" class="form-control" required>
                    <option value="">Select subcategory</option>
                </select>
            </div>
        </div>

        <div class="mb-3" data-aos="fade-right">
            <label class="form-label">Price Per Day (₹)</label>
            <input type="number" step="0.01" name="price" id="price" class="form-control" required readonly>
        </div>

        <div class="mb-3" data-aos="fade-left">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3" data-aos="fade-up">
            <label class="form-label">Key Features <small class="text-muted">(comma-separated)</small></label>
            <input type="text" name="features" class="form-control" placeholder="e.g., Airbags, ABS, Sunroof" required>
        </div>

        <div class="mb-3" data-aos="fade-up">
            <label class="form-label">Key Specifications <small class="text-muted">(comma-separated)</small></label>
            <input type="text" name="key_specifications" class="form-control" placeholder="e.g., Mileage 18km/l, Engine 1498cc" required>
        </div>

        <div class="mb-3" data-aos="fade-up">
            <label class="form-label">Vehicle Image</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-success w-100" >🚀 Add Vehicle</button>
    </form>

</div>
    </div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<!-- AOS JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>AOS.init();</script>

<!-- JS for dynamic subcategory and price -->
<script>
    const categorySelect = document.getElementById("category");
    const subcategorySelect = document.getElementById("subcategory");
    const priceInput = document.getElementById("price");

    const subcategories = {
        car: ["Hatchback", "Sedan", "SUV"],
        bike: ["Basic", "Standard", "Adventurous"]
    };

    const prices = {
        hatchback: 999,
        sedan: 1499,
        suv: 2299,
        basic: 399,
        standard: 499,
        adventurous: 699
    };

    categorySelect.addEventListener("change", function () {
        const selected = this.value;
        subcategorySelect.innerHTML = '<option value="">Select subcategory</option>';
        priceInput.value = '';

        if (subcategories[selected]) {
            subcategories[selected].forEach(function (item) {
                const opt = document.createElement("option");
                opt.value = item.toLowerCase();
                opt.textContent = item;
                subcategorySelect.appendChild(opt);
            });
        }
    });

    subcategorySelect.addEventListener("change", function () {
        const selectedSub = this.value.toLowerCase();
        priceInput.value = prices[selectedSub] || '';
    });
</script>

</body>
</html>
