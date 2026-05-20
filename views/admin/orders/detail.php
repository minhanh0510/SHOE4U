<?php
require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';

$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Lấy thông tin đơn hàng
$order = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT o.*, u.full_name, u.email, u.phone, u.address,
           p.method as payment_method, p.status as payment_status, p.paid_at
    FROM orders o
    JOIN users u ON o.user_id = u.user_id
    LEFT JOIN payments p ON o.order_id = p.order_id
    WHERE o.order_id = $order_id
"));

if (!$order) {
    header('Location: index.php');
    exit();
}

// Lấy chi tiết đơn hàng
$details = mysqli_query($conn, "
    SELECT od.*, pv.size, pv.color, p.product_name, p.brand
    FROM order_details od
    JOIN product_variants pv ON od.variant_id = pv.variant_id
    JOIN products p ON pv.product_id = p.product_id
    WHERE od.order_id = $order_id
");

include '../layouts/header.php';
include '../layouts/sidebar.php';
?>

<div class="content-header">
    <h1>Chi tiết đơn hàng #<?php echo $order_id; ?></h1>
    <a href="<?= ADMIN_URL ?>users/index.php" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Quay lại
</a>
</div>

<!-- Thông tin đơn hàng -->
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3>Thông tin khách hàng</h3>
            </div>
            <div class="card-body">
                <table class="info-table">
                    <tr>
                        <th>Họ tên:</th>
                        <td><?php echo $order['full_name']; ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?php echo $order['email']; ?></td>
                    </tr>
                    <tr>
                        <th>Số điện thoại:</th>
                        <td><?php echo $order['phone']; ?></td>
                    </tr>
                    <tr>
                        <th>Địa chỉ:</th>
                        <td><?php echo $order['shipping_address'] ?: $order['address']; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3>Thông tin đơn hàng</h3>
            </div>
            <div class="card-body">
                <table class="info-table">
                    <tr>
                        <th>Ngày đặt:</th>
                        <td><?php echo formatDate($order['created_at']); ?></td>
                    </tr>
                    <tr>
                        <th>Trạng thái:</th>
                        <td><?php echo getOrderStatusBadge($order['status']); ?></td>
                    </tr>
                    <tr>
                        <th>Tổng tiền:</th>
                        <td><strong style="color: #28a745;"><?php echo formatMoney($order['total_price']); ?></strong></td>
                    </tr>
                    <tr>
                        <th>Phương thức TT:</th>
                        <td><?php echo $order['payment_method'] ?? 'N/A'; ?></td>
                    </tr>
                    <tr>
                        <th>Trạng thái TT:</th>
                        <td>
                            <?php if($order['payment_status'] == 'Paid'): ?>
                                <span class="badge badge-success">Đã thanh toán</span>
                                <br><small><?php echo formatDate($order['paid_at']); ?></small>
                            <?php elseif($order['payment_status'] == 'Pending'): ?>
                                <span class="badge badge-warning">Chờ thanh toán</span>
                            <?php else: ?>
                                <span class="badge badge-secondary">Chưa thanh toán</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Chi tiết sản phẩm -->
<div class="card mt-3">
    <div class="card-header">
        <h3>Sản phẩm đã đặt</h3>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Size</th>
                    <th>Màu</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $subtotal = 0;
                while($row = mysqli_fetch_assoc($details)): 
                    $total = $row['price'] * $row['quantity'];
                    $subtotal += $total;
                ?>
                <tr>
                    <td>
                        <strong><?php echo $row['product_name']; ?></strong>
                        <br><small><?php echo $row['brand']; ?></small>
                    </td>
                    <td><?php echo $row['size']; ?></td>
                    <td><?php echo $row['color']; ?></td>
                    <td><?php echo formatMoney($row['price']); ?></td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo formatMoney($total); ?></td>
                </tr>
                <?php endwhile; ?>
                <tr class="total-row">
                    <td colspan="5" style="text-align: right;"><strong>Tổng cộng:</strong></td>
                    <td><strong><?php echo formatMoney($subtotal); ?></strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Cập nhật trạng thái -->
<div class="card mt-3">
    <div class="card-header">
        <h3>Cập nhật trạng thái đơn hàng</h3>
    </div>
    <div class="card-body">
        <form action="update_status.php" method="POST" class="form-inline">
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
            
            <div class="form-group">
                <select name="status" class="form-control" style="width: 200px;">
                    <option value="Pending" <?php echo $order['status'] == 'Pending' ? 'selected' : ''; ?>>Chờ xử lý</option>
                    <option value="Shipping" <?php echo $order['status'] == 'Shipping' ? 'selected' : ''; ?>>Đang giao</option>
                    <option value="Completed" <?php echo $order['status'] == 'Completed' ? 'selected' : ''; ?>>Hoàn thành</option>
                    <option value="Cancelled" <?php echo $order['status'] == 'Cancelled' ? 'selected' : ''; ?>>Hủy đơn</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-sync-alt"></i> Cập nhật trạng thái
            </button>
        </form>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>