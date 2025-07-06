<?php
require_once "db.php"; // Ensure db.php is in the same folder

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name && $email && $subject && $message) {
        $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);
        $stmt->execute();
        $stmt->close();
        
        // Redirect back to homepage with a success message
        header("Location: index.php?msg=sent#contact");
        exit;
    } else {
        // If any field is missing
        header("Location: index.php?msg=error#contact");
        exit;
    }
} else {
    // Prevent direct access
    header("Location: index.php");
    exit;
}
?>
