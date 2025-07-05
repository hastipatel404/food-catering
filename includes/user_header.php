<?php
if (!isset($_SESSION)) session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Food Catering - User Panel</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Optional Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f7f7f7; }
        .navbar {
            background-color: #ff6347;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            font-weight: bold;
        }
        .navbar .links {
            display: flex;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div><a href="dashboard.php">🍽️ Food Catering</a></div>
        <div class="links">
            <a href="menu.php">Menu</a>
            <a href="cart.php">Cart</a>
            <a href="orders.php">Orders</a>
            <a href="contact.php">Contact</a>
            <a href="about.php">About</a>
            <a href="logout.php">Logout</a>
        </div>
    </div>
    <div style="padding: 30px;">
