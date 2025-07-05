<?php
session_start();
require_once '../db.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user's cart items
$stmt = $conn->prepare("
    SELECT c.quantity, m.name, m.price
    FROM cart c
    JOIN menu_items m ON c.item_id = m.id
    WHERE c.user_id = ?
");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$cart_items) {
    $error = "Your cart is empty.";
} else {
    $item_list = [];
    $total = 0;

    foreach ($cart_items as $item) {
        $name = $item['name'];
        $qty = $item['quantity'];
        $price = $item['price'];
        $total += $qty * $price;
        $item_list[] = "$name x$qty";
    }

    $order_items_str = implode(", ", $item_list);

    // Insert into orders table
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, order_items) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $total, $order_items_str]);

    // Clear cart
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);

    $success = "Your order has been placed successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Place Order - Food Catering</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow p-4">
        <h3 class="text-center text-success mb-4">Place Order</h3>

        <?php if (isset($error)): ?>
            <div class="alert alert-warning"><?= htmlspecialchars($error) ?></div>
            <div class="text-center"><a href="cart.php" class="btn btn-primary">Go to Cart</a></div>
        <?php else: ?>
            <div class="alert alert-success text-center"><?= htmlspecialchars($success) ?></div>
            <div class="text-center"><a href="orders.php" class="btn btn-success">View My Orders</a></div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
