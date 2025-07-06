<?php
session_start();
require_once "../db.php";

if (!isset($_SESSION['admin_id']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$message = "";

// Fetch vehicle
$stmt = $conn->prepare("SELECT * FROM vehicles WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$vehicle = $result->fetch_assoc();

if (!$vehicle) {
    die("Vehicle not found.");
}

// Update form handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $category = $_POST['category'];
    $subcategory = $_POST['subcategory'];
    $price = $_POST['price'];
    $description = trim($_POST['description']);
    $features = trim($_POST['features']);
    $key_specifications = trim($_POST['key_specifications']);
    $newImagePath = $vehicle['image_path'];

    // If new image uploaded
    if (!empty($_FILES["image"]["name"])) {
        $uploadDir = "../uploads/";
        $fileName = time() . "_" . basename($_FILES["image"]["name"]);
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadPath)) {
            if (file_exists($uploadDir . $vehicle['image_path'])) {
                unlink($uploadDir . $vehicle['image_path']);
            }
            $newImagePath = $fileName;
        } else {
            $message = "Image upload failed.";
        }
    }

    // Update vehicle
    $update = $conn->prepare("UPDATE vehicles SET name = ?, category = ?, subcategory = ?, price_per_day = ?, description = ?, features = ?, key_specifications = ?, image_path = ? WHERE id = ?");
    $update->bind_param("sssissssi", $name, $category, $subcategory, $price, $description, $features, $key_specifications, $newImagePath, $id);

    if ($update->execute()) {
        $message = "Vehicle updated successfully.";
        $vehicle = array_merge($vehicle, [
            'name' => $name,
            'category' => $category,
            'subcategory' => $subcategory,
            'price_per_day' => $price,
            'description' => $description,
            'features' => $features,
            'key_specifications' => $key_specifications,
            'image_path' => $newImagePath
        ]);
    } else {
        $message = "Update failed: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Vehicle | FlexiRide Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3 class="text-center mb-4">Edit Vehicle</h3>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="shadow p-4 bg-white rounded">
        <div class="mb-3">
            <label>Vehicle Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($vehicle['name']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <select name="category" id="category" class="form-control" required>
                <option value="">Select</option>
                <option value="car" <?= $vehicle['category'] == 'car' ? 'selected' : '' ?>>Car</option>
                <option value="bike" <?= $vehicle['category'] == 'bike' ? 'selected' : '' ?>>Bike</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Subcategory</label>
            <select name="subcategory" id="subcategory" class="form-control" required>
                <!-- JS will populate this -->
            </select>
        </div>

        <div class="mb-3">
            <label>Price Per Day (₹)</label>
            <input type="number" step="0.01" name="price" id="price" value="<?= $vehicle['price_per_day'] ?>" class="form-control" required readonly>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($vehicle['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label>Key Features</label>
            <input type="text" name="features" value="<?= htmlspecialchars($vehicle['features']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Key Specifications</label>
            <input type="text" name="key_specifications" value="<?= htmlspecialchars($vehicle['key_specifications']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Current Image</label><br>
            <img src="../uploads/<?= $vehicle['image_path'] ?>" width="150" class="mb-2"><br>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-warning w-100">Update Vehicle</button>
    </form>

    <div class="text-center mt-3">
        <a href="vehicles.php" class="btn btn-secondary">Back to Vehicle List</a>
    </div>
</div>

<!-- JavaScript for Subcategory & Auto Price -->
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

    // Preload selected values
    const currentSub = "<?= strtolower($vehicle['subcategory']) ?>";
    const currentCat = "<?= $vehicle['category'] ?>";

    categorySelect.addEventListener("change", function () {
        const selected = this.value;
        subcategorySelect.innerHTML = '<option value="">Select subcategory</option>';
        priceInput.value = '';

        if (subcategories[selected]) {
            subcategories[selected].forEach(function (item) {
                const val = item.toLowerCase();
                const opt = document.createElement("option");
                opt.value = val;
                opt.textContent = item;
                if (val === currentSub) opt.selected = true;
                subcategorySelect.appendChild(opt);
            });
        }
    });

    subcategorySelect.addEventListener("change", function () {
        const selectedSub = this.value.toLowerCase();
        priceInput.value = prices[selectedSub] || '';
    });

    // Trigger pre-load
    window.addEventListener('DOMContentLoaded', () => {
        categorySelect.value = currentCat;
        categorySelect.dispatchEvent(new Event('change'));
        subcategorySelect.dispatchEvent(new Event('change'));
    });
</script>

</body>
</html>
