<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login | FlexiRide</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      background-color: #0d1b2a;
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-card {
      background-color: #1e293b;
      color: #fff;
      border-radius: 15px;
      padding: 40px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 0 20px rgba(0,0,0,0.4);
    }
    .form-control {
      background-color: #334155;
      border: none;
      color: #fff;
    }
    .form-control:focus {
      background-color: #334155;
      color: #fff;
      border-color: #00c6ff;
      box-shadow: none;
    }
    .btn-primary {
      background-color: #00c6ff;
      border: none;
    }
    .btn-primary:hover {
      background-color: #00a6d6;
    }
    .input-group-text {
      background-color: #334155;
      border: none;
      color: #fff;
    }
  </style>
</head>
<body>

  <div class="login-card">
    <h3 class="text-center mb-4">Admin Login</h3>

    <?php if (isset($_SESSION['admin_login_error'])): ?>
      <div class="alert alert-danger py-2 small"><?= $_SESSION['admin_login_error']; unset($_SESSION['admin_login_error']); ?></div>
    <?php endif; ?>

    <form action="login_process.php" method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">Admin Username</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Enter admin username" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
          <span class="input-group-text"><i class="fa-solid fa-eye" id="togglePassword" style="cursor: pointer;"></i></span>
        </div>
      </div>
      <button type="submit" class="btn btn-primary w-100 mt-3">Login</button>
    </form>
  </div>

  <script>
    // Toggle password visibility
    const toggle = document.getElementById("togglePassword");
    const password = document.getElementById("password");
    toggle.addEventListener("click", () => {
      const type = password.type === "password" ? "text" : "password";
      password.type = type;
      toggle.classList.toggle("fa-eye-slash");
    });
  </script>

</body>
</html>
