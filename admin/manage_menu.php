<?php
session_start();
require_once '../db.php';
include '../includes/admin_header.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Handle add menu item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'], $_POST['price'])) {
    $name = trim($_POST['name']);
    $price = (float) $_POST['price'];

    if (!empty($name) && $price > 0) {
        $stmt = $conn->prepare("INSERT INTO menu_items (name, price) VALUES (?, ?)");
        $stmt->execute([$name, $price]);
        $success = "Menu item added successfully.";
    } else {
        $error = "Please provide valid name and price.";
    }
}

// Handle delete menu item
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM menu_items WHERE id = ?");
    $stmt->execute([$id]);
    $success = "Menu item deleted.";
}

// Fetch menu items
$stmt = $conn->prepare("SELECT * FROM menu_items ORDER BY name");
$stmt->execute();
$menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../includes/admin_header.php'; ?>

<div class="container mt-4">
    <h2 class="mb-4 text-primary">Manage Menu</h2>

    <?php if (!empty($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php elseif (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Add New Item Form -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Add New Menu Item</div>
        <div class="card-body">
            <form method="POST">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Item Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Price (₹)</label>
                        <input type="number" step="0.01" name="price" class="form-control" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Menu Items Table -->
    <div class="card">
        <div class="card-header bg-secondary text-white">Current Menu</div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover m-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Item Name</th>
                        <th>Price (₹)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($menu_items): ?>
                        <?php foreach ($menu_items as $index => $item): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td><?= number_format($item['price'], 2) ?></td>
                                <td>
                                    <a href="?delete=<?= $item['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center text-muted">No menu items available.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>
