<?php
session_start();
require_once "../db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    // Profile picture setup
    $targetDir = "../uploads/";
    $profilePictureName = "";

    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR phone = ?");
        $stmt->bind_param("ss", $email, $phone);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Email or phone already registered.";
        } else {
            if (!empty($_FILES["profile_picture"]["name"])) {
                $filename = basename($_FILES["profile_picture"]["name"]);
                $profilePictureName = time() . "_" . $filename;
                $targetFile = $targetDir . $profilePictureName;
                move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile);
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO users (name, email, phone, password, profile_picture) VALUES (?, ?, ?, ?, ?)");
            $insert->bind_param("sssss", $name, $email, $phone, $hashed_password, $profilePictureName);

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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register | FlexiRide</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .form-container {
      width: 380px;
      background-color: #fff;
      box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
      border-radius: 10px;
      box-sizing: border-box;
      padding: 25px 30px;
      margin: 50px auto;
    }

    .title {
      text-align: center;
      font-family: "Lucida Sans", Geneva, Verdana, sans-serif;
      margin-bottom: 20px;
      font-size: 28px;
      font-weight: 800;
    }

    .form {
      display: flex;
      flex-direction: column;
      gap: 14px;
      margin-bottom: 15px;
    }

    .input {
      border-radius: 20px;
      border: 1px solid #c0c0c0;
      padding: 12px 15px;
    }

    .form-btn {
      padding: 10px 15px;
      border-radius: 20px;
      border: none;
      background: teal;
      color: white;
      font-weight: bold;
      cursor: pointer;
      box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
    }

    .form-btn:active {
      box-shadow: none;
    }

    .link-label {
      font-size: 12px;
      text-align: center;
      color: #747474;
    }

    .link-label a {
      color: teal;
      text-decoration: underline;
      font-weight: bold;
      margin-left: 3px;
    }

    .alert {
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

<div class="form-container">
  <p class="title">Create Account</p>

  <?php if ($message): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <form class="form" method="POST" enctype="multipart/form-data">
    <input type="text" name="name" class="input" placeholder="Full Name" required>
    <input type="email" name="email" class="input" placeholder="Email" required>
    <input type="text" name="phone" class="input" placeholder="Phone (10 digits)" pattern="[0-9]{10}" required>
    <input type="password" name="password" class="input" placeholder="Password" required>
    <input type="password" name="confirm_password" class="input" placeholder="Confirm Password" required>
    <input type="file" name="profile_picture" class="form-control" accept="image/*">

    <button type="submit" class="form-btn">Register</button>
  </form>

  <p class="link-label">
    Already have an account?
    <a href="login.php">Login here</a>
  </p>
</div>

</body>
</html>
