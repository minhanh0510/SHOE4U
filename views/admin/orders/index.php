<?php
require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';

$status_filter = isset($_GET['status']) ? $_GET['status'] : '';
$where = $status_filter && $status_filter != 'all' ? "WHERE o.status = '$status_filter'" : '';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Tổng số đơn hàng
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders o $where"))['total'];
$total_pages = ceil($total / $limit);

// Lấy danh sách đơn hàng
$orders = mysqli_query($conn, "
    SELECT o.*, u.full_name, u.phone, u.address,
           p.method as payment_method, p.status as payment_status
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    LEFT JOIN payments p ON o.order_id = p.order_id
    $where
    ORDER BY o.created_at DESC
    LIMIT $offset, $limit
");

include '../layouts/header.php';
include '../layouts/sidebar.php';
?>

<div class="content-header">
    <h1>Quản lý đơn hàng</h1>
</div>

<!-- Filter -->
<div class="card">
    <div class="card-body">
        <form method="GET" class="filter-form">
            <div class="form-group">
                <label>Lọc theo trạng thái:</label>
                <select name="status" onchange="this.form.submit()" class="form-control" style="width: 200px;">
                    <option value="all" <?php echo $status_filter == 'all' ? 'selected' : ''; ?>>Tất cả</option>
                    <option value="Pending" <?php echo $status_filter == 'Pending' ? 'selected' : ''; ?>>Chờ xử lý</option>
                    <option value="Shipping" <?php echo $status_filter == 'Shipping' ? 'selected' : ''; ?>>Đang giao</option>
                    <option value="Completed" <?php echo $status_filter == 'Completed' ? 'selected' : ''; ?>>Hoàn thành</option>
                    <option value="Cancelled" <?php echo $status_filter == 'Cancelled' ? 'selected' : ''; ?>>Đã hủy</option>
                </select>
            </div>
        </form>
    </div>
</div>

<!-- Orders Table -->
<div class="card mt-3">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Mã ĐH</th>
                    <th>Khách hàng</th>
                    <th>SĐT</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Thanh toán</th>
                    <th>Ngày đặt</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($orders)): ?>
                <tr>
                    <td><strong>#<?php echo $row['order_id']; ?></strong></td>
                    <td><?php echo $row['full_name']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo formatMoney($row['total_price']); ?></td>
                    <td><?php echo getOrderStatusBadge($row['status']); ?></td>
                    <td>
                        <?php echo $row['payment_method'] ?? 'N/A'; ?>
                        <br>
                        <small><?php echo $row['payment_status'] ?? ''; ?></small>
                    </td>
                    <td><?php echo formatDate($row['created_at']); ?></td>
                    <td>
                        <a href="detail.php?id=<?php echo $row['order_id']; ?>" class="btn-sm btn-info">
                            <i class="fas fa-eye"></i> Chi tiết
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <!-- Pagination -->
        <?php if($total_pages > 1): ?>
        <div class="pagination">
            <?php for($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&status=<?php echo $status_filter; ?>" 
               class="<?php echo $page == $i ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>