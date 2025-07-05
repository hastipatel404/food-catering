<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Food Catering - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #f8d7da, #fff3cd);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            width: 350px;
            border: none;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .btn-lg {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

    <div class="card text-center p-4">
        <h2 class="mb-4 text-danger"><i class="bi bi-basket-fill"></i> Food Catering</h2>
        <p class="mb-4">Welcome! Please select your role to continue:</p>
        <div class="d-grid gap-3">
            <a href="admin/login.php" class="btn btn-dark btn-lg">
                <i class="bi bi-person-lock"></i> Admin
            </a>
            <a href="user/login.php" class="btn btn-success btn-lg">
                <i class="bi bi-person-circle"></i> User
            </a>
        </div>
    </div>

</body>
</html>
