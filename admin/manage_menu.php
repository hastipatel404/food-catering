<?php
session_start();
require_once '../db.php';

// Handle new item addition
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image'];

    $image_name = basename($image['name']);
    $target_dir = "../uploads/";
    $target_path = $target_dir . $image_name;

    if (move_uploaded_file($image['tmp_name'], $target_path)) {
        $stmt = $conn->prepare("INSERT INTO menu_items (name, price, image) VALUES (?, ?, ?)");
        $stmt->execute([$name, $price, $image_name]);
        $message = "Item added successfully!";
    } else {
        $error = "Image upload failed.";
    }
}

// Fetch existing items
$items = $conn->query("SELECT * FROM menu_items ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3>Manage Menu</h3>

    <?php if (isset($message)): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm mb-4">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" name="name" class="form-control" placeholder="Item Name" required>
            </div>
            <div class="col-md-3">
                <input type="number" name="price" class="form-control" step="0.01" placeholder="Price ₹" required>
            </div>
            <div class="col-md-3">
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>
            <div class="col-md-2 d-grid">
                <button type="submit" name="add" class="btn btn-success">Add Item</button>
            </div>
        </div>
    </form>

    <div class="row g-4">
        <?php foreach ($items as $item): ?>
            <div class="col-md-4">
                <div class="card h-100 shadow">
                    <img src="../uploads/<?= $item['image'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5><?= htmlspecialchars($item['name']) ?></h5>
                        <p>₹<?= number_format($item['price'], 2) ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
