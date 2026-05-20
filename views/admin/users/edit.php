<?php
require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';

$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Lấy thông tin người dùng
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE user_id = $user_id"));

if (!$user) {
    $_SESSION['error'] = 'Không tìm thấy người dùng';
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $role = $_POST['role'];
    
    // Kiểm tra email đã tồn tại chưa (trừ email hiện tại)
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email' AND user_id != $user_id");
    if (mysqli_num_rows($check) > 0) {
        $error = 'Email đã được sử dụng bởi người dùng khác';
    } else {
        $sql = "UPDATE users SET 
                full_name = '$full_name',
                email = '$email',
                phone = '$phone',
                address = '$address',
                role = '$role'
                WHERE user_id = $user_id";
        
        if (mysqli_query($conn, $sql)) {
            $_SESSION['success'] = 'Cập nhật thông tin người dùng thành công';
            header('Location: index.php');
            exit();
        } else {
            $error = 'Lỗi: ' . mysqli_error($conn);
        }
    }
}

// Lấy lịch sử mua hàng
$orders = mysqli_query($conn, "
    SELECT o.*, 
           (SELECT COUNT(*) FROM order_details WHERE order_id = o.order_id) as total_items
    FROM orders o
    WHERE o.user_id = $user_id
    ORDER BY o.created_at DESC
    LIMIT 5
");

include '../layouts/header.php';
include '../layouts/sidebar.php';
?>

<div class="content-header">
    <h1>Sửa thông tin người dùng: <?php echo $user['full_name']; ?></h1>
    <a href="<?= ADMIN_URL ?>users/index.php" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Quay lại
</a>
</div>

<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3>Thông tin cá nhân</h3>
            </div>
            <div class="card-body">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <form method="POST" class="form">
                    <div class="form-group">
                        <label>Họ và tên <span class="required">*</span></label>
                        <input type="text" name="full_name" required class="form-control" 
                               value="<?php echo htmlspecialchars($user['full_name']); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" required class="form-control" 
                               value="<?php echo $user['email']; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="phone" class="form-control" 
                               value="<?php echo $user['phone']; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Địa chỉ</label>
                        <textarea name="address" rows="2" class="form-control"><?php echo $user['address']; ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Vai trò</label>
                        <select name="role" class="form-control">
                            <option value="customer" <?php echo $user['role'] == 'customer' ? 'selected' : ''; ?>>Khách hàng</option>
                            <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Ngày đăng ký</label>
                        <input type="text" class="form-control" value="<?php echo formatDate($user['created_at']); ?>" readonly disabled>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Cập nhật
                        </button>
                        <a href="index.php" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3>Lịch sử mua hàng gần đây</h3>
                <a href="../orders/?user_id=<?php echo $user_id; ?>" class="btn-sm btn-info">Xem tất cả</a>
            </div>
            <div class="card-body">
                <?php if(mysqli_num_rows($orders) > 0): ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mã ĐH</th>
                            <th>Ngày</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($order = mysqli_fetch_assoc($orders)): ?>
                        <tr>
                            <td>#<?php echo $order['order_id']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($order['created_at'])); ?></td>
                            <td><?php echo $order['total_items']; ?> SP</td>
                            <td><?php echo formatMoney($order['total_price']); ?></td>
                            <td><?php echo getOrderStatusBadge($order['status']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p class="text-center">Người dùng chưa có đơn hàng nào</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>