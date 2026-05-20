<?php
require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';

$from_date = isset($_GET['from_date']) ? $_GET['from_date'] : date('Y-m-01');
$to_date = isset($_GET['to_date']) ? $_GET['to_date'] : date('Y-m-d');
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;

// Top sản phẩm bán chạy
$top_products = mysqli_query($conn, "
    SELECT 
        p.product_id,
        p.product_name,
        p.brand,
        p.price,
        c.category_name,
        COUNT(DISTINCT o.order_id) as total_orders,
        SUM(od.quantity) as total_quantity,
        SUM(od.price * od.quantity) as total_revenue
    FROM order_details od
    JOIN product_variants pv ON od.variant_id = pv.variant_id
    JOIN products p ON pv.product_id = p.product_id
    JOIN categories c ON p.category_id = c.category_id
    JOIN orders o ON od.order_id = o.order_id
    WHERE o.status = 'Completed'
        AND DATE(o.created_at) BETWEEN '$from_date' AND '$to_date'
    GROUP BY p.product_id
    ORDER BY total_quantity DESC
    LIMIT $limit
");

// Top danh mục bán chạy
$top_categories = mysqli_query($conn, "
    SELECT 
        c.category_name,
        SUM(od.quantity) as total_quantity,
        SUM(od.price * od.quantity) as total_revenue
    FROM order_details od
    JOIN product_variants pv ON od.variant_id = pv.variant_id
    JOIN products p ON pv.product_id = p.product_id
    JOIN categories c ON p.category_id = c.category_id
    JOIN orders o ON od.order_id = o.order_id
    WHERE o.status = 'Completed'
        AND DATE(o.created_at) BETWEEN '$from_date' AND '$to_date'
    GROUP BY c.category_id
    ORDER BY total_quantity DESC
");

// Top thương hiệu bán chạy
$top_brands = mysqli_query($conn, "
    SELECT 
        p.brand,
        SUM(od.quantity) as total_quantity,
        SUM(od.price * od.quantity) as total_revenue
    FROM order_details od
    JOIN product_variants pv ON od.variant_id = pv.variant_id
    JOIN products p ON pv.product_id = p.product_id
    JOIN orders o ON od.order_id = o.order_id
    WHERE o.status = 'Completed'
        AND DATE(o.created_at) BETWEEN '$from_date' AND '$to_date'
        AND p.brand IS NOT NULL AND p.brand != ''
    GROUP BY p.brand
    ORDER BY total_quantity DESC
");

include '../layouts/header.php';
include '../layouts/sidebar.php';
?>

<div class="content-header">
    <h1>Thống kê sản phẩm bán chạy</h1>
</div>

<!-- Bộ lọc -->
<div class="card">
    <div class="card-body">
        <form method="GET" class="filter-form">
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label>Từ ngày:</label>
                        <input type="date" name="from_date" value="<?php echo $from_date; ?>" class="form-control">
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>Đến ngày:</label>
                        <input type="date" name="to_date" value="<?php echo $to_date; ?>" class="form-control">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label>Số lượng:</label>
                        <select name="limit" class="form-control">
                            <option value="10" <?php echo $limit == 10 ? 'selected' : ''; ?>>10</option>
                            <option value="20" <?php echo $limit == 20 ? 'selected' : ''; ?>>20</option>
                            <option value="50" <?php echo $limit == 50 ? 'selected' : ''; ?>>50</option>
                            <option value="100" <?php echo $limit == 100 ? 'selected' : ''; ?>>100</option>
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

<!-- Top sản phẩm -->
<div class="card mt-3">
    <div class="card-header">
        <h3>Top <?php echo $limit; ?> sản phẩm bán chạy</h3>
        <a href="export.php?type=bestsellers&from_date=<?php echo $from_date; ?>&to_date=<?php echo $to_date; ?>" 
           class="btn btn-success">
            <i class="fas fa-download"></i> Xuất Excel
        </a>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Sản phẩm</th>
                    <th>Thương hiệu</th>
                    <th>Danh mục</th>
                    <th>Đơn giá</th>
                    <th>Số lượng bán</th>
                    <th>Doanh thu</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $stt = 1;
                while($row = mysqli_fetch_assoc($top_products)): 
                ?>
                <tr>
                    <td><?php echo $stt++; ?></td>
                    <td>
                        <strong><?php echo $row['product_name']; ?></strong>
                    </td>
                    <td><?php echo $row['brand']; ?></td>
                    <td><?php echo $row['category_name']; ?></td>
                    <td><?php echo formatMoney($row['price']); ?></td>
                    <td>
                        <span class="badge badge-success"><?php echo $row['total_quantity']; ?></span>
                    </td>
                    <td><?php echo formatMoney($row['total_revenue']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Thống kê theo danh mục và thương hiệu -->
<div class="row mt-3">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3>Top danh mục bán chạy</h3>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Danh mục</th>
                            <th>Số lượng</th>
                            <th>Doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($top_categories)): ?>
                        <tr>
                            <td><?php echo $row['category_name']; ?></td>
                            <td><?php echo $row['total_quantity']; ?></td>
                            <td><?php echo formatMoney($row['total_revenue']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3>Top thương hiệu bán chạy</h3>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Thương hiệu</th>
                            <th>Số lượng</th>
                            <th>Doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($top_brands)): ?>
                        <tr>
                            <td><?php echo $row['brand'] ?: 'Khác'; ?></td>
                            <td><?php echo $row['total_quantity']; ?></td>
                            <td><?php echo formatMoney($row['total_revenue']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Biểu đồ tròn danh mục -->
<div class="card mt-3">
    <div class="card-header">
        <h3>Phân bố doanh thu theo danh mục</h3>
    </div>
    <div class="card-body">
        <canvas id="categoryChart" style="height: 300px; width: 300px; margin: 0 auto;"></canvas>
    </div>
</div>

<script>
// Vẽ biểu đồ tròn danh mục
const ctx2 = document.getElementById('categoryChart').getContext('2d');
const catLabels = [];
const catRevenues = [];

<?php 
mysqli_data_seek($top_categories, 0);
while($row = mysqli_fetch_assoc($top_categories)): 
?>
    catLabels.push('<?php echo $row['category_name']; ?>');
    catRevenues.push(<?php echo $row['total_revenue']; ?>);
<?php endwhile; ?>

new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: catLabels,
        datasets: [{
            data: catRevenues,
            backgroundColor: [
                '#3498db', '#e74c3c', '#2ecc71', '#f39c12', 
                '#9b59b6', '#1abc9c', '#e67e22', '#34495e'
            ]
        }]
    }
});
</script>

<?php include '../layouts/footer.php'; ?>