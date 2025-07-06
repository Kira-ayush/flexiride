<?php
session_start();

// If already logged in, redirect to dashboard or admin panel
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php"); // or wherever your admin goes after login
    exit;
}

// Else, redirect to login page
header("Location: login.php");
exit;
?>
