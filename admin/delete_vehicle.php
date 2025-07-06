<?php
session_start();
require_once "../db.php";

if (!isset($_SESSION['admin_id']) || !isset($_GET['id'])) {
    header("Location: vehicles.php");
    exit;
}

$id = $_GET['id'];

// Optional: delete image file from uploads folder
$stmt = $conn->prepare("SELECT image_path FROM vehicles WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($v = $result->fetch_assoc()) {
    $file = "../uploads/" . $v['image_path'];
    if (file_exists($file)) unlink($file);
}

// Delete vehicle
$del = $conn->prepare("DELETE FROM vehicles WHERE id = ?");
$del->bind_param("i", $id);
$del->execute();

header("Location: vehicles.php");
exit;
