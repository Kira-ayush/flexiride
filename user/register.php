<?php
session_start();
require_once "../db.php"; // DB connection

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Profile picture variables
    $targetDir = "../uploads/";
    $profilePictureName = "";

    // Check if passwords match
    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        // Check if user already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR phone = ?");
        $stmt->bind_param("ss", $email, $phone);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Email or phone already registered.";
        } else {
            // Handle profile picture upload
            if (!empty($_FILES["profile_picture"]["name"])) {
                $filename = basename($_FILES["profile_picture"]["name"]);
                $profilePictureName = time() . "_" . $filename;
                $targetFile = $targetDir . $profilePictureName;
                move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile);
            }

            // Insert user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
            $insert->bind_param("ssss", $name, $email, $phone, $hashed_password);


            if ($insert->execute()) {
                $_SESSION['user_id'] = $insert->insert_id;
                $_SESSION['user_email'] = $email;
                header("Location: dashboard.php");
                exit;
            } else {
                $message = "Something went wrong. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration | FlexiRide</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white text-center">
                    <h4>Register</h4>
                </div>
                <div class="card-body">
                    <?php if ($message): ?>
                        <div class="alert alert-danger"><?= $message ?></div>
                    <?php endif; ?>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                         </div>
                         <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" required pattern="[0-9]{10}">
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Profile Picture</label>
                            <input type="file" name="profile_picture" class="form-control" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-success w-100">Register</button>
                        <div class="mt-3 text-center">
                            <small>Already have an account? <a href="login.php">Login here</a></small>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center text-muted mt-3">&copy; 2025 FlexiRide</p>
        </div>
    </div>
</div>
</body>
</html>
