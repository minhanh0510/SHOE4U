<?php
require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';

// Lấy tham số lọc
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$quarter = isset($_GET['quarter']) ? (int)$_GET['quarter'] : ceil(date('m')/3);
$view = isset($_GET['view']) ? $_GET['view'] : 'month'; // day, month, quarter, year

// Doanh thu theo ngày trong tháng
if($view == 'day') {
    $sql = "SELECT 
                DATE(o.created_at) as date,
                COUNT(DISTINCT o.order_id) as orders,
                COALESCE(SUM(od.quantity), 0) as total_products,
                COALESCE(SUM(od.price * od.quantity), SUM(o.total_price)) as revenue,
                COALESCE(AVG(o.total_price), 0) as avg_order_value
            FROM orders o
            LEFT JOIN order_details od ON o.order_id = od.order_id
            WHERE o.status = 'Completed' 
                AND MONTH(o.created_at) = $month 
                AND YEAR(o.created_at) = $year
            GROUP BY DATE(o.created_at)
            ORDER BY date DESC";
    $data = mysqli_query($conn, $sql);
}

// Doanh thu theo tháng trong năm
if($view == 'month') {
    $sql = "SELECT 
                MONTH(o.created_at) as month,
                COUNT(DISTINCT o.order_id) as orders,
                COALESCE(SUM(od.quantity), 0) as total_products,
                COALESCE(SUM(od.price * od.quantity), SUM(o.total_price)) as revenue,
                COALESCE(AVG(o.total_price), 0) as avg_order_value
            FROM orders o
            LEFT JOIN order_details od ON o.order_id = od.order_id
            WHERE o.status = 'Completed' 
                AND YEAR(o.created_at) = $year
            GROUP BY MONTH(o.created_at)
            ORDER BY month";
    $data = mysqli_query($conn, $sql);
}

// Doanh thu theo quý
if($view == 'quarter') {
    $sql = "SELECT 
                QUARTER(o.created_at) as quarter,
                COUNT(DISTINCT o.order_id) as orders,
                COALESCE(SUM(od.quantity), 0) as total_products,
                COALESCE(SUM(od.price * od.quantity), SUM(o.total_price)) as revenue,
                COALESCE(AVG(o.total_price), 0) as avg_order_value
            FROM orders o
            LEFT JOIN order_details od ON o.order_id = od.order_id
            WHERE o.status = 'Completed' 
                AND YEAR(o.created_at) = $year
            GROUP BY QUARTER(o.created_at)
            ORDER BY quarter";
    $data = mysqli_query($conn, $sql);
}

// Doanh thu theo năm
if($view == 'year') {
    $sql = "SELECT 
                YEAR(o.created_at) as year,
                COUNT(DISTINCT o.order_id) as orders,
                COALESCE(SUM(od.quantity), 0) as total_products,
                COALESCE(SUM(od.price * od.quantity), SUM(o.total_price)) as revenue,
                COALESCE(AVG(o.total_price), 0) as avg_order_value
            FROM orders o
            LEFT JOIN order_details od ON o.order_id = od.order_id
            WHERE o.status = 'Completed'
            GROUP BY YEAR(o.created_at)
            ORDER BY year DESC";
    $data = mysqli_query($conn, $sql);
}

// Thống kê phương thức thanh toán
$payment_stats = mysqli_query($conn, "
    SELECT 
        p.method,
        COUNT(DISTINCT o.order_id) as total_orders,
        SUM(o.total_price) as total_revenue
    FROM payments p
    JOIN orders o ON p.order_id = o.order_id
    WHERE o.status = 'Completed'
    GROUP BY p.method
");

include '../layouts/header.php';
include '../layouts/sidebar.php';
?>

<div class="content-header">
    <h1>Thống kê đơn hàng & doanh thu</h1>
    <div style="display: flex; gap: 8px;">
        <a href="index.php" class="btn btn-secondary"><i class="fas fa-chart-pie"></i> Tổng quan</a>
        <a href="revenue.php" class="btn btn-primary"><i class="fas fa-calendar-alt"></i> Theo Tháng/Quý/Năm</a>
        <a href="bestsellers.php" class="btn btn-secondary"><i class="fas fa-fire"></i> Bán chạy</a>
    </div>
</div>

<!-- Bộ lọc -->
<div class="card">
    <div class="card-body">
        <form method="GET" class="filter-form">
            <div class="row">
                <div class="col-2">
                    <div class="form-group">
                        <label>Xem theo:</label>
                        <select name="view" class="form-control">
                            <option value="day" <?php echo $view == 'day' ? 'selected' : ''; ?>>Theo ngày</option>
                            <option value="month" <?php echo $view == 'month' ? 'selected' : ''; ?>>Theo tháng</option>
                            <option value="quarter" <?php echo $view == 'quarter' ? 'selected' : ''; ?>>Theo quý</option>
                            <option value="year" <?php echo $view == 'year' ? 'selected' : ''; ?>>Theo năm</option>
                        </select>
                    </div>
                </div>
                
                <?php if($view == 'day' || $view == 'month'): ?>
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
                <?php endif; ?>
                
                <?php if($view == 'quarter'): ?>
                <div class="col-2">
                    <div class="form-group">
                        <label>Quý:</label>
                        <select name="quarter" class="form-control">
                            <option value="1" <?php echo $quarter == 1 ? 'selected' : ''; ?>>Quý 1</option>
                            <option value="2" <?php echo $quarter == 2 ? 'selected' : ''; ?>>Quý 2</option>
                            <option value="3" <?php echo $quarter == 3 ? 'selected' : ''; ?>>Quý 3</option>
                            <option value="4" <?php echo $quarter == 4 ? 'selected' : ''; ?>>Quý 4</option>
                        </select>
                    </div>
                </div>
                <?php endif; ?>
                
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
                        <button type="submit" class="btn btn-primary" style="display: block;">Xem</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tổng quan -->
<?php
$total_revenue = 0;
$total_orders = 0;
$total_products_count = 0;
$total_avg = 0;
$count = 0;

if(mysqli_num_rows($data) > 0) {
    mysqli_data_seek($data, 0);
    while($row = mysqli_fetch_assoc($data)) {
        $total_revenue += $row['revenue'];
        $total_orders += $row['orders'];
        $total_products_count += $row['total_products'];
        $count++;
    }
    $total_avg = $total_orders > 0 ? $total_revenue / $total_orders : 0;
}
?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-info">
            <h3><?php echo formatMoney($total_revenue); ?></h3>
            <p>Tổng doanh thu</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-info">
            <h3><?php echo $total_orders; ?></h3>
            <p>Tổng đơn hàng</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-info">
            <h3><?php echo $total_products_count; ?></h3>
            <p>Số lượng sản phẩm bán ra</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-info">
            <h3><?php echo formatMoney($total_avg); ?></h3>
            <p>Giá trị trung bình/đơn</p>
        </div>
    </div>
</div>

<!-- Biểu đồ -->
<div class="card mt-3">
    <div class="card-header">
        <h3>Biểu đồ doanh thu</h3>
    </div>
    <div class="card-body">
        <canvas id="revenueChart" style="height: 400px;"></canvas>
    </div>
</div>

<!-- Bảng dữ liệu -->
<div class="card mt-3">
    <div class="card-header">
        <h3>Chi tiết doanh thu & số lượng sản phẩm</h3>
        <a href="export.php?type=revenue&view=<?php echo $view; ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>" 
           class="btn btn-success">
            <i class="fas fa-download"></i> Xuất Excel
        </a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Thời gian</th>
                    <th>Số đơn</th>
                    <th>Số lượng sản phẩm</th>
                    <th>Doanh thu (Thành tiền)</th>
                    <th>TB/đơn</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                mysqli_data_seek($data, 0);
                while($row = mysqli_fetch_assoc($data)): 
                ?>
                <tr>
                    <td>
                        <strong>
                        <?php 
                        if($view == 'day') echo date('d/m/Y', strtotime($row['date']));
                        if($view == 'month') echo 'Tháng ' . $row['month'];
                        if($view == 'quarter') echo 'Quý ' . $row['quarter'];
                        if($view == 'year') echo 'Năm ' . $row['year'];
                        ?>
                        </strong>
                    </td>
                    <td><?php echo $row['orders']; ?></td>
                    <td><span class="badge badge-success"><?php echo $row['total_products']; ?> SP</span></td>
                    <td><strong style="color: #28a745;"><?php echo formatMoney($row['revenue']); ?></strong></td>
                    <td><?php echo formatMoney($row['avg_order_value']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Thống kê phương thức thanh toán -->
<div class="card mt-3">
    <div class="card-header">
        <h3>Thống kê theo phương thức thanh toán</h3>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Phương thức</th>
                    <th>Số đơn</th>
                    <th>Doanh thu</th>
                    <th>Tỷ lệ</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($payment_stats)): 
                    $percent = $total_revenue > 0 ? round($row['total_revenue'] / $total_revenue * 100, 2) : 0;
                ?>
                <tr>
                    <td><?php echo $row['method'] ?: 'COD'; ?></td>
                    <td><?php echo $row['total_orders']; ?></td>
                    <td><?php echo formatMoney($row['total_revenue']); ?></td>
                    <td><?php echo $percent; ?>%</td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Vẽ biểu đồ
const ctx = document.getElementById('revenueChart').getContext('2d');
const labels = [];
const revenues = [];

<?php 
mysqli_data_seek($data, 0);
while($row = mysqli_fetch_assoc($data)): 
    if($view == 'day') $label = 'Ngày ' . date('d/m', strtotime($row['date']));
    if($view == 'month') $label = 'Tháng ' . $row['month'];
    if($view == 'quarter') $label = 'Quý ' . $row['quarter'];
    if($view == 'year') $label = 'Năm ' . $row['year'];
?>
    labels.push('<?php echo $label; ?>');
    revenues.push(<?php echo $row['revenue']; ?>);
<?php endwhile; ?>

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: revenues,
            backgroundColor: 'rgba(52, 152, 219, 0.5)',
            borderColor: '#3498db',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
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