<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

// Capture and clear error
$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | FlexiRide</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .form-container {
      width: 350px;
      height: auto;
      background-color: #fff;
      box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
      border-radius: 10px;
      box-sizing: border-box;
      padding: 20px 30px;
      margin: 60px auto;
    }

    .title {
      text-align: center;
      font-family: "Lucida Sans", Geneva, Verdana, sans-serif;
      margin: 10px 0 25px 0;
      font-size: 28px;
      font-weight: 800;
    }

    .form {
      width: 100%;
      display: flex;
      flex-direction: column;
      gap: 18px;
      margin-bottom: 15px;
    }

    .input {
      border-radius: 20px;
      border: 1px solid #c0c0c0;
      outline: 0 !important;
      padding: 12px 15px;
    }

    .page-link {
      text-align: end;
      color: #747474;
      font-size: 12px;
      text-decoration: underline;
      cursor: pointer;
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

    .sign-up-label {
      font-size: 12px;
      text-align: center;
      color: #747474;
    }

    .sign-up-link {
      color: teal;
      text-decoration: underline;
      margin-left: 4px;
      cursor: pointer;
      font-weight: bold;
    }

    .alert {
      margin-bottom: 15px;
    }
  </style>
</head>
<body>

<div class="form-container">
  <p class="title">Welcome back</p>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form class="form" method="POST" action="login_process.php">
    <input type="text" name="email_or_phone" class="input" placeholder="Email or Phone" required>
    <input type="password" name="password" class="input" placeholder="Password" required>

    <p class="page-link">
      <a href="#" class="text-decoration-none text-secondary">Forgot Password?</a>
    </p>

    <button type="submit" class="form-btn">Log in</button>
  </form>

  <p class="sign-up-label">
    Don't have an account?
    <a href="register.php" class="sign-up-link">Sign up</a>
  </p>
</div>

</body>
</html>
