<?php
session_start();
require '../db.php'; // Make sure this file connects to your MySQL database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate required fields
    if (empty($email) || empty($phone) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: ../index.php");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: ../index.php");
        exit;
    }

    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        $_SESSION['error'] = "Invalid phone number. Enter 10 digits.";
        header("Location: ../index.php");
        exit;
    }

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: ../index.php");
        exit;
    }

    // Check if email or phone already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ? OR phone = ?");
    $check->bind_param("ss", $email, $phone);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $_SESSION['error'] = "Email or phone already registered.";
        header("Location: ../index.php");
        exit;
    }

    // Handle profile picture (optional)
    $profile_picture = '';
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $target_dir = "uploads/";
        $file_name = uniqid() . "_" . basename($_FILES["profile_picture"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $profile_picture = $target_file;
        }
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into DB
    $insert = $conn->prepare("INSERT INTO users (email, phone, password, profile_picture) VALUES (?, ?, ?, ?)");
    $insert->bind_param("ssss", $email, $phone, $hashed_password, $profile_picture);

    if ($insert->execute()) {
        $_SESSION['success'] = "Registration successful! You can now log in.";
    } else {
        $_SESSION['error'] = "Something went wrong. Please try again.";
    }

    header("Location: ../index.php");
    exit;
} else {
    header("Location: ../index.php");
    exit;
}
