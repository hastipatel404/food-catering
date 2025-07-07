<?php
session_start();
require_once '../db.php';

// Restrict access to admin only
//if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
//    header("Location: login.php");
//    exit;
//}

// Handle status update
if (isset($_GET['mark_completed'])) {
    $order_id = (int)$_GET['mark_completed'];
    $stmt = $conn->prepare("UPDATE orders SET status = 'Completed' WHERE id = ?");
    $stmt->execute([$order_id]);
    header("Location: manage_orders.php");
    exit;
}

// Fetch all orders
$stmt = $conn->query("
    SELECT o.*, u.username
    FROM orders o
    JOIN users u ON o.user_id = u.id
    ORDER BY o.order_date DESC
");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include '../includes/admin_header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Orders - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="text-end mb-3">
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4>Manage Orders</h4>
        </div>
        <div class="card-body">
            <?php if ($orders): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>User</th>
                                <th>Items</th>
                                <th>Total (₹)</th>
                                <th>Status</th>
                                <th>Order Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td>#<?= $order['id'] ?></td>
                                    <td><?= htmlspecialchars($order['username']) ?></td>
                                    <td><?= nl2br(htmlspecialchars($order['order_items'])) ?></td>
                                    <td><?= number_format($order['total_price'], 2) ?></td>
                                    <td>
                                        <?php if ($order['status'] === 'Pending'): ?>
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Completed</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date("d M Y, h:i A", strtotime($order['order_date'])) ?></td>
                                    <td>
                                        <?php if ($order['status'] === 'Pending'): ?>
                                            <a href="?mark_completed=<?= $order['id'] ?>" class="btn btn-sm btn-success" onclick="return confirm('Mark this order as completed?')">
                                                Mark Completed
                                            </a>
                                        <?php else: ?>
                                            <span class="text-muted">No Action</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center">No orders found.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>
