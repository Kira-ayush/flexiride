<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $vehicle_id = $_POST['vehicle_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $pickup_time = $_POST['pickup_time'];
    $pickup_location = $_POST['pickup_location'];
    $driver_option = $_POST['driver_option'];
    $extra_helmet = isset($_POST['extra_helmet']) ? (int)$_POST['extra_helmet'] : 0;
    $driver_fee = ($driver_option === 'With driver') ? 799 : 0;

    // Get vehicle category and price
    $stmt = $conn->prepare("SELECT category, price_per_day FROM vehicles WHERE id = ?");
    $stmt->bind_param("i", $vehicle_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $vehicle = $result->fetch_assoc();

    if (!$vehicle) {
        die("Invalid vehicle.");
    }

    $price_per_day = $vehicle['price_per_day'];
    $category = strtolower($vehicle['category']);

    // Calculate rental days
    $start = new DateTime($start_date);
    $end = new DateTime($end_date);
    $interval = $start->diff($end)->days + 1; // include start day

    if ($interval <= 0) {
        die("End date must be after or same as start date.");
    }

    $helmet_fee = ($category === 'bike' && $extra_helmet) ? 99 : 0;

    // Total price
    $total_price = ($price_per_day * $interval) + $driver_fee + $helmet_fee;

    // Insert into bookings
    $stmt = $conn->prepare("INSERT INTO bookings 
        (user_id, vehicle_id, start_date, end_date, pickup_time, pickup_location, driver_option, extra_helmet, driver_fee, total_price, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
    $stmt->bind_param("iisssssidd", $user_id, $vehicle_id, $start_date, $end_date, $pickup_time, $pickup_location, $driver_option, $extra_helmet, $driver_fee, $total_price);

    if ($stmt->execute()) {
        header("Location: booking_summary.php");
        exit;
    } else {
        echo "Failed to book. Try again.";
    }
}
?>
