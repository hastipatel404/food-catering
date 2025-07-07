<?php
session_start();
require_once '../db.php';
include '../includes/user_header.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $item_id = (int)$_GET['id'];

    // Check if item already in cart
    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND item_id = ?");
    $stmt->execute([$user_id, $item_id]);

    if ($stmt->rowCount() > 0) {
        // Increase quantity if already in cart
        $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND item_id = ?");
        $stmt->execute([$user_id, $item_id]);
    } else {
        // Insert new item into cart
        $stmt = $conn->prepare("INSERT INTO cart (user_id, item_id, quantity) VALUES (?, ?, 1)");
        $stmt->execute([$user_id, $item_id]);
    }

    // ✅ Redirect back to menu with a message
    header("Location: menu.php?added=1");
    exit;
} else {
    // If no ID provided
    header("Location: menu.php?error=1");
    exit;
}
