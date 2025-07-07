<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Handle item removal
if (isset($_GET['remove'])) {
    $item_id = (int)$_GET['remove'];
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND item_id = ?");
    $stmt->execute([$user_id, $item_id]);
    $removed = "Item removed from cart.";
}

// Fetch cart items
$stmt = $conn->prepare("
    SELECT c.item_id, c.quantity, m.name, m.price
    FROM cart c
    JOIN menu_items m ON c.item_id = m.id
    WHERE c.user_id = ?
");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total
$total = 0;
foreach ($cart_items as $item) {
    $total += $item['quantity'] * $item['price'];
}
?>
<?php include '../includes/user_header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart - Food Catering</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Your Cart</h4>
        </div>
        <div class="card-body">
            <?php if (isset($removed)): ?>
                <div class="alert alert-info"><?= htmlspecialchars($removed) ?></div>
            <?php endif; ?>

            <?php if ($cart_items): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th>Price (₹)</th>
                                <th>Quantity</th>
                                <th>Subtotal (₹)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['name']) ?></td>
                                    <td><?= number_format($item['price'], 2) ?></td>
                                    <td><?= $item['quantity'] ?></td>
                                    <td><?= number_format($item['quantity'] * $item['price'], 2) ?></td>
                                    <td>
                                        <a href="?remove=<?= $item['item_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Remove this item?')">
                                            Remove
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="table-info">
                                <th colspan="3" class="text-end">Total:</th>
                                <th colspan="2">₹<?= number_format($total, 2) ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="text-end mt-3">
                    <a href="place_order.php" class="btn btn-success">Place Order</a>
                </div>
            <?php else: ?>
                <div class="alert alert-warning text-center">
                    Your cart is empty. <a href="menu.php">View Menu</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

</body>
</html>
