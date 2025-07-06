<?php
session_start();
require '../db.php'; // Make sure this path is correct

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (!empty($username) && !empty($password)) {
        // Fetch admin by username
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $admin['password'])) {
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['username'];

                header("Location: dashboard.php"); // or admin/index.php or wherever your dashboard is
                exit;
            } else {
                $_SESSION['admin_login_error'] = "Invalid password.";
            }
        } else {
            $_SESSION['admin_login_error'] = "Admin not found.";
        }
    } else {
        $_SESSION['admin_login_error'] = "Please fill in all fields.";
    }

    header("Location: login.php");
    exit;
} else {
    header("Location: login.php");
    exit;
}
