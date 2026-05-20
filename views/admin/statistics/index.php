<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';

// Lấy tham số lọc
$view = isset($_GET['view']) ? $_GET['view'] : 'month'; // day hoặc month
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Thống kê theo ngày hoặc tháng
if($view == 'day') {
    // THỐNG KÊ THEO NGÀY CỤ THỂ
    $stats = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT 
            COUNT(*) as total_orders,
            SUM(CASE WHEN status = 'Completed' THEN total_price ELSE 0 END) as revenue,
            COUNT(CASE WHEN status = 'Pending' THEN 1 END) as pending_orders,
            COUNT(CASE WHEN status = 'Shipping' THEN 1 END) as shipping_orders,
            COUNT(CASE WHEN status = 'Completed' THEN 1 END) as completed_orders,
            COUNT(CASE WHEN status = 'Cancelled' THEN 1 END) as cancelled_orders
        FROM orders
        WHERE DATE(created_at) = '$date'
    "));
    
    // Doanh thu theo giờ trong ngày
    $daily_revenue = mysqli_query($conn, "
        SELECT HOUR(created_at) as hour, SUM(total_price) as revenue
        FROM orders
        WHERE DATE(created_at) = '$date' AND status = 'Completed'
        GROUP BY HOUR(created_at)
        ORDER BY hour
    ");
    
    // Top sản phẩm bán chạy trong ngày
    $top_products = mysqli_query($conn, "
        SELECT p.product_name, SUM(od.quantity) as sold, SUM(od.price * od.quantity) as revenue
        FROM order_details od
        JOIN product_variants pv ON od.variant_id = pv.variant_id
        JOIN products p ON pv.product_id = p.product_id
        JOIN orders o ON od.order_id = o.order_id
        WHERE o.status = 'Completed' AND DATE(o.created_at) = '$date'
        GROUP BY p.product_id
        ORDER BY sold DESC
        LIMIT 10
    ");
    
    $title = "Ngày " . date('d/m/Y', strtotime($date));
} else {
    // THỐNG KÊ THEO THÁNG (GIỮ NGUYÊN CODE CŨ)
    $stats = mysqli_fetch_assoc(mysqli_query($conn, "
        SELECT 
            COUNT(*) as total_orders,
            SUM(CASE WHEN status = 'Completed' THEN total_price ELSE 0 END) as revenue,
            COUNT(CASE WHEN status = 'Pending' THEN 1 END) as pending_orders,
            COUNT(CASE WHEN status = 'Shipping' THEN 1 END) as shipping_orders,
            COUNT(CASE WHEN status = 'Completed' THEN 1 END) as completed_orders,
            COUNT(CASE WHEN status = 'Cancelled' THEN 1 END) as cancelled_orders
        FROM orders
        WHERE YEAR(created_at) = $year AND MONTH(created_at) = $month
    "));
    
    // Doanh thu theo ngày trong tháng
    $daily_revenue = mysqli_query($conn, "
        SELECT DAY(created_at) as day, SUM(total_price) as revenue
        FROM orders
        WHERE YEAR(created_at) = $year AND MONTH(created_at) = $month AND status = 'Completed'
        GROUP BY DAY(created_at)
        ORDER BY day
    ");
    
    // Top sản phẩm bán chạy trong tháng
    $top_products = mysqli_query($conn, "
        SELECT p.product_name, SUM(od.quantity) as sold, SUM(od.price * od.quantity) as revenue
        FROM order_details od
        JOIN product_variants pv ON od.variant_id = pv.variant_id
        JOIN products p ON pv.product_id = p.product_id
        JOIN orders o ON od.order_id = o.order_id
        WHERE o.status = 'Completed' AND YEAR(o.created_at) = $year AND MONTH(o.created_at) = $month
        GROUP BY p.product_id
        ORDER BY sold DESC
        LIMIT 10
    ");
    
    $title = "Tháng $month/$year";
}

include '../layouts/header.php';
include '../layouts/sidebar.php';
?>

<div class="content-header">
    <h1>Thống kê</h1>
</div>

<!-- Filter -->
<div class="card">
    <div class="card-body">
        <form method="GET" class="filter-form">
            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <label>Xem theo:</label>
                        <select name="view" class="form-control" onchange="this.form.submit()">
                            <option value="day" <?php echo $view == 'day' ? 'selected' : ''; ?>>Theo ngày</option>
                            <option value="month" <?php echo $view == 'month' ? 'selected' : ''; ?>>Theo tháng</option>
                        </select>
                    </div>
                </div>
                
                <?php if($view == 'day'): ?>
                <div class="col-2">
                    <div class="form-group">
                        <label>Ngày:</label>
                        <input type="date" name="date" value="<?php echo $date; ?>" class="form-control">
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="col-2">
                    <div class="form-group">
                        <label>Tháng:</label>
                        <select name="month" class="form-control">
                            <?php for($i = 1; $i <= 12; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo $month == $i ? 'selected' : ''; ?>>
                                Tháng <?php echo $i; ?>
                            </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-2">
                    <div class="form-group">
                        <label>Năm:</label>
                        <select name="year" class="form-control">
                            <?php for($i = 2025; $i <= 2026; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php echo $year == $i ? 'selected' : ''; ?>>
                                <?php echo $i; ?>
                            </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-2">
                    <div class="form-group">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary">Xem</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-info">
            <h3><?php echo $stats['total_orders'] ?? 0; ?></h3>
            <p>Tổng đơn hàng</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-info">
            <h3><?php echo formatMoney($stats['revenue'] ?? 0); ?></h3>
            <p>Doanh thu</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-info">
            <h3><?php echo $stats['completed_orders'] ?? 0; ?></h3>
            <p>Đơn hoàn thành</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-info">
            <h3><?php echo $stats['pending_orders'] ?? 0; ?></h3>
            <p>Đơn chờ xử lý</p>
        </div>
    </div>
</div>

<!-- Revenue Chart -->
<div class="card mt-3">
    <div class="card-header">
        <h3>Doanh thu theo <?php echo $view == 'day' ? 'giờ' : 'ngày'; ?> - <?php echo $title; ?></h3>
    </div>
    <div class="card-body">
        <canvas id="revenueChart" style="height: 300px;"></canvas>
    </div>
</div>

<!-- Top Products -->
<div class="card mt-3">
    <div class="card-header">
        <h3>Top 10 sản phẩm bán chạy</h3>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng bán</th>
                    <th>Doanh thu</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($top_products)): ?>
                <tr>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['sold']; ?></td>
                    <td><?php echo formatMoney($row['revenue']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Vẽ biểu đồ doanh thu
const ctx = document.getElementById('revenueChart').getContext('2d');
const labels = [];
const revenues = [];

<?php 
mysqli_data_seek($daily_revenue, 0);
while($row = mysqli_fetch_assoc($daily_revenue)): 
    if($view == 'day') {
        $label = 'Giờ ' . $row['hour'] . ':00';
    } else {
        $label = 'Ngày ' . $row['day'];
    }
?>
    labels.push('<?php echo $label; ?>');
    revenues.push(<?php echo $row['revenue']; ?>);
<?php endwhile; ?>

new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: revenues,
            borderColor: '#28a745',
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString('vi-VN') + 'đ';
                    }
                }
            }
        }
    }
});
</script>

<?php include '../layouts/footer.php'; ?>