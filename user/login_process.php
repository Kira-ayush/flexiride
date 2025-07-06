<?php
session_start();
require '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email_or_phone = trim($_POST["email_or_phone"]);
    $password = trim($_POST["password"]);

    if (!empty($email_or_phone) && !empty($password)) {
        // Fetch user by email or phone
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR phone = ?");
        $stmt->bind_param("ss", $email_or_phone, $email_or_phone);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Store user data in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_image'] = !empty($user['profile_picture']) ? $user['profile_picture'] : 'images/default.png';

                // Smart redirect if user was trying to access a protected page
                if (!empty($_SESSION['redirect_after_login'])) {
                    $redirect_url = $_SESSION['redirect_after_login'];
                    unset($_SESSION['redirect_after_login']);
                    header("Location: $redirect_url");
                } else {
                    header("Location: ../index.php");
                }
                exit;
            } else {
                $_SESSION['login_error'] = "Invalid password.";
            }
        } else {
            $_SESSION['login_error'] = "User not found.";
        }
    } else {
        $_SESSION['login_error'] = "Please fill in all fields.";
    }

    // Redirect back to login if failed
    header("Location: ../index.php");
    exit;
} else {
    header("Location: ../index.php");
    exit;
}
