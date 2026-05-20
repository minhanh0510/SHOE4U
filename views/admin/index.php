<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'layouts/auth_check.php';
require_once '../../config/functions.php';

// ======================
// Thống kê tổng quan
// ======================
$stats = [];

// Tổng sản phẩm
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM products");
$stats['total_products'] = mysqli_fetch_assoc($result)['total'] ?? 0;

// Tổng đơn hàng
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM orders");
$stats['total_orders'] = mysqli_fetch_assoc($result)['total'] ?? 0;

// Tổng người dùng
$result = mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE role='customer'");
$stats['total_users'] = mysqli_fetch_assoc($result)['total'] ?? 0;

// Doanh thu
$result = mysqli_query($conn, "SELECT SUM(total_price) as total FROM orders WHERE status='Completed'");
$stats['total_revenue'] = mysqli_fetch_assoc($result)['total'] ?? 0;


// ======================
// Đơn hàng theo trạng thái
// ======================
$result = mysqli_query($conn, "SELECT status, COUNT(*) as count FROM orders GROUP BY status");

$order_status = [];
while ($row = mysqli_fetch_assoc($result)) {
    $order_status[$row['status']] = $row['count'];
}


// ======================
// Sản phẩm bán chạy
// ======================
$best_sellers = mysqli_query($conn, "
    SELECT  p.product_name,
            SUM(od.quantity) as sold,
            SUM(od.price * od.quantity) as revenue
    FROM order_details od
    JOIN product_variants pv ON od.variant_id = pv.variant_id
    JOIN products p ON pv.product_id = p.product_id
    JOIN orders o ON od.order_id = o.order_id
    WHERE o.status = 'Completed'
    GROUP BY p.product_id
    ORDER BY sold DESC
    LIMIT 5
");


// ======================
// Đơn hàng gần đây
// ======================
$recent_orders = mysqli_query($conn, "
    SELECT o.*, u.full_name
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    ORDER BY o.created_at DESC
    LIMIT 5
");

include 'layouts/header.php';
include 'layouts/sidebar.php';
?>

<div class="content-header">
    <h1>Dashboard</h1>
    <p>Xin chào, <?= $admin_name ?>! Chào mừng trở lại.</p>
</div>


<!-- STATS CARDS -->
<div class="stats-grid">
    <a href="products/index.php" class="stat-link">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e3f2fd;color:#1976d2;">
                <i class="fas fa-shoe-prints"></i>
            </div>
            <div class="stat-info">
                <h3><?= $stats['total_products'] ?></h3>
                <p>Sản phẩm</p>
            </div>
        </div>
    </a>

    <a href="orders/index.php" class="stat-link">
        <div class="stat-card">
            <div class="stat-icon" style="background:#e8f5e9;color:#388e3c;">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <h3><?= $stats['total_orders'] ?></h3>
                <p>Đơn hàng</p>
            </div>
        </div>
    </a>

    <a href="users/index.php" class="stat-link">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff3e0;color:#f57c00;">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <h3><?= $stats['total_users'] ?></h3>
                <p>Người dùng</p>
            </div>
        </div>
    </a>

    <a href="statistics/index.php" class="stat-link">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fce4ec;color:#c2185b;">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-info">
                <h3><?= formatMoney($stats['total_revenue']) ?></h3>
                <p>Doanh thu</p>
            </div>
        </div>
    </a>
</div>


<!-- CHART + BEST SELLER -->
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3>Đơn hàng theo trạng thái</h3>
            </div>
            <div class="card-body chart-container">
                <canvas id="orderChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3>Sản phẩm bán chạy</h3>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr><th>Sản phẩm</th><th>Đã bán</th><th>Doanh thu</th></tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($best_sellers)): ?>
                        <tr><td><?= $row['product_name'] ?></td><td><?= $row['sold'] ?></td><td><?= formatMoney($row['revenue']) ?></td></tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- RECENT ORDERS -->
<div class="card mt-3">
    <div class="card-header">
        <h3>Đơn hàng gần đây</h3>
        <a href="<?= ADMIN_URL ?>orders/index.php" class="btn-view-all">Xem tất cả</a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr><th>Mã ĐH</th><th>Khách hàng</th><th>Tổng tiền</th><th>Trạng thái</th><th>Ngày đặt</th><th>Thao tác</th></tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($recent_orders)): ?>
                <tr>
                    <td>#<?= $row['order_id'] ?></td>
                    <td><?= $row['full_name'] ?></td>
                    <td><?= formatMoney($row['total_price']) ?></td>
                    <td><?= getOrderStatusBadge($row['status']) ?></td>
                    <td><?= formatDate($row['created_at']) ?></td>
                    <td><a href="orders/detail.php?id=<?= $row['order_id'] ?>" class="btn-sm btn-info"><i class="fas fa-eye"></i></a></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
const ctx = document.getElementById('orderChart');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Shipping', 'Completed', 'Cancelled'],
        datasets: [{
            data: [<?= $order_status['Pending'] ?? 0 ?>, <?= $order_status['Shipping'] ?? 0 ?>, <?= $order_status['Completed'] ?? 0 ?>, <?= $order_status['Cancelled'] ?? 0 ?>],
            backgroundColor: ['#ffc107', '#17a2b8', '#28a745', '#dc3545']
        }]
    },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
});
</script>

<?php include 'layouts/footer.php'; ?>