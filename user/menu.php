<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$items = $conn->query("SELECT * FROM menu_items")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .menu-card {
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }
        .menu-card img {
            transition: transform 0.3s ease;
        }
        .menu-card:hover img {
            transform: scale(1.05);
        }
        .menu-overlay {
            position: absolute;
            bottom: -100%;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            color: white;
            transition: bottom 0.4s ease;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 10px;
            text-align: center;
        }
        .menu-card:hover .menu-overlay {
            bottom: 0;
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">
    <h3 class="mb-4">Our Menu</h3>
    <div class="row g-4">
        <?php foreach ($items as $item): ?>
            <div class="col-md-4">
                <div class="card menu-card shadow-sm h-100">
                    <img src="../uploads/<?= htmlspecialchars($item['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($item['name']) ?>" style="height: 250px; object-fit: cover;">
                    <div class="menu-overlay">
                        <h5><?= htmlspecialchars($item['name']) ?></h5>
                        <p>₹<?= number_format($item['price'], 2) ?></p>
                        <a href="add_to_cart.php?id=<?= $item['id'] ?>" class="btn btn-sm btn-light">Add to Cart</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
