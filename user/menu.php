<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['item_id'])) {
    $item_id = (int) $_POST['item_id'];

    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND item_id = ?");
    $stmt->execute([$user_id, $item_id]);
    $existing = $stmt->fetch();

    if ($existing) {
        $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND item_id = ?");
        $stmt->execute([$user_id, $item_id]);
    } else {
        $stmt = $conn->prepare("INSERT INTO cart (user_id, item_id, quantity) VALUES (?, ?, 1)");
        $stmt->execute([$user_id, $item_id]);
    }

    $message = "Item added to cart!";
}

$stmt = $conn->prepare("SELECT * FROM menu_items ORDER BY name");
$stmt->execute();
$menu = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../includes/user_header.php'; ?>

<div class="container mt-4">
    <h2 class="text-center mb-4">Menu</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($menu as $item): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                        <p class="card-text">₹<?= number_format($item['price'], 2) ?></p>
                        <form method="POST">
                            <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-cart-plus"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include '../includes/user_footer.php'; ?>
