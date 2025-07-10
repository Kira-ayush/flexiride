<?php
session_start();
session_destroy();
if (!empty($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    // Fallback if HTTP_REFERER is not set
    header("Location: ../index.php");
}
exit;
?>