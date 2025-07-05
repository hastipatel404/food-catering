<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
?>

<?php include '../includes/admin_header.php'; ?>

<style>
    .dashboard-banner {
        background: linear-gradient(to right, #c2e9fb, #a1c4fd);
        padding: 50px 20px;
        border-radius: 12px;
        margin-bottom: 40px;
        text-align: center;
    }

    .dashboard-banner h2 {
        font-weight: bold;
        color: #333;
    }

    .dashboard-banner p {
        color: #555;
        font-size: 18px;
    }

    .action-card {
        transition: all 0.3s ease-in-out;
        border-radius: 12px;
    }

    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: 500;
    }

    .bi {
        font-size: 2.5rem;
    }
</style>

<div class="container">
    <div class="dashboard-banner shadow">
        <h2>Welcome, <?= htmlspecialchars($username) ?> 👨‍🍳</h2>
        <p>Use the dashboard below to manage menu, orders, and more.</p>
    </div>

    <div class="row g-4 justify-content-center">
        <div class="col-md-4 col-sm-6">
            <a href="manage_menu.php" class="text-decoration-none">
                <div class="card action-card text-center p-4 shadow-sm border-0">
                    <i class="bi bi-card-list text-primary mb-3"></i>
                    <div class="card-title">Manage Menu</div>
                </div>
            </a>
        </div>

        <div class="col-md-4 col-sm-6">
            <a href="manage_orders.php" class="text-decoration-none">
                <div class="card action-card text-center p-4 shadow-sm border-0">
                    <i class="bi bi-journal-check text-success mb-3"></i>
                    <div class="card-title">Manage Orders</div>
                </div>
            </a>
        </div>

        <div class="col-md-4 col-sm-6">
            <a href="logout.php" class="text-decoration-none">
                <div class="card action-card text-center p-4 shadow-sm border-0">
                    <i class="bi bi-box-arrow-right text-danger mb-3"></i>
                    <div class="card-title">Logout</div>
                </div>
            </a>
        </div>
    </div>
</div>

<?php include '../includes/admin_footer.php'; ?>
