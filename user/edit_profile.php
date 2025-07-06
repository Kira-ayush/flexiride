<?php
session_start();
require_once "../db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_SESSION['user_id'];
$message = "";

// Fetch current user info
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);

    // Handle profile picture
    $profile_picture = $user['profile_picture'];
    if (!empty($_FILES['profile_picture']['name'])) {
        $targetDir = "../uploads/";
        $fileName = time() . "_" . basename($_FILES["profile_picture"]["name"]);
        $uploadPath = $targetDir . $fileName;
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $uploadPath)) {
            $profile_picture = $fileName;
        }
    }

    // Optional password change
    if (!empty($_POST['password'])) {
        $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, phone=?, profile_picture=?, password=? WHERE id=?");
        $stmt->bind_param("sssssi", $name, $email, $phone, $profile_picture, $hashed_password, $id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET name=?, email=?, phone=?, profile_picture=? WHERE id=?");
        $stmt->bind_param("ssssi", $name, $email, $phone, $profile_picture, $id);
    }

    if ($stmt->execute()) {
        $message = "Profile updated successfully!";
        // Refresh updated data
        $user = array_merge($user, $_POST);
        $user['profile_picture'] = $profile_picture;
    } else {
        $message = "Something went wrong!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile | FlexiRide</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <h3 class="text-center mb-4">Edit My Profile</h3>

  <?php if ($message): ?>
    <div class="alert alert-info"><?= $message ?></div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data" class="bg-white p-4 shadow rounded">
    <div class="mb-3">
      <label>Name</label>
      <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Phone</label>
      <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" required>
    </div>
    <div class="mb-3">
      <label>Profile Picture</label><br>
      <?php if ($user['profile_picture']): ?>
        <img src="../uploads/<?= $user['profile_picture'] ?>" style="width:80px;height:80px;" class="rounded mb-2"><br>
      <?php endif; ?>
      <input type="file" name="profile_picture" class="form-control">
    </div>
    <div class="mb-3">
      <label>Change Password <small class="text-muted">(leave blank to keep current)</small></label>
      <input type="password" name="password" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary w-100">Update Profile</button>
  </form>

  <div class="text-center mt-3">
    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
  </div>
</div>
</body>
</html>
