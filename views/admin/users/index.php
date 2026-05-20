<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';

// Phân trang
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Tìm kiếm
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$where = '';
if ($search) {
    $where = "WHERE full_name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%'";
}

// Tổng số người dùng
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users $where"))['total'];
$total_pages = ceil($total / $limit);

// Lấy danh sách người dùng
$users = mysqli_query($conn, "
    SELECT u.*, 
           (SELECT COUNT(*) FROM orders WHERE user_id = u.user_id) as total_orders,
           (SELECT SUM(total_price) FROM orders WHERE user_id = u.user_id AND status = 'Completed') as total_spent
    FROM users u
    $where
    ORDER BY u.created_at DESC
    LIMIT $offset, $limit
");

include '../layouts/header.php';
include '../layouts/sidebar.php';
?>

<div class="content-header">
    <h1>Quản lý người dùng</h1>
</div>

<!-- Hiển thị thông báo -->
<?php if(isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<?php if(isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>

<!-- Search Form -->
<div class="card">
    <div class="card-body">
        <form method="GET" class="search-form">
            <div class="form-group" style="display: flex; gap: 10px;">
                <input type="text" name="search" placeholder="Tìm kiếm theo tên, email, SĐT..." 
                       value="<?php echo htmlspecialchars($search); ?>" class="form-control" style="flex: 1;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Tìm
                </button>
                <?php if($search): ?>
                    <a href="index.php" class="btn btn-secondary">Xóa lọc</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Users Table -->
<div class="card mt-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Thông tin</th>
                        <th>Liên hệ</th>
                        <th>Vai trò</th>
                        <th>Đơn hàng</th>
                        <th>Đã chi</th>
                        <th>Ngày đăng ký</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($users) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($users)): ?>
                        <tr>
                            <td>#<?php echo $row['user_id']; ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($row['full_name']); ?></strong>
                            </td>
                            <td>
                                <i class="fas fa-envelope"></i> <?php echo htmlspecialchars($row['email']); ?><br>
                                <i class="fas fa-phone"></i> <?php echo $row['phone'] ? htmlspecialchars($row['phone']) : '<span class="text-muted">Chưa cập nhật</span>'; ?>
                            </td>
                            <td>
                                <?php if($row['role'] == 'admin'): ?>
                                    <span class="badge badge-danger">Admin</span>
                                <?php else: ?>
                                    <span class="badge badge-info">Khách hàng</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge badge-primary"><?php echo $row['total_orders']; ?> đơn</span>
                            </td>
                            <td>
                                <?php echo $row['total_spent'] ? formatMoney($row['total_spent']) : '0₫'; ?>
                            </td>
                            <td><?php echo formatDate($row['created_at']); ?></td>
                            <td class="actions" style="white-space: nowrap;">
                                <a href="edit.php?id=<?php echo $row['user_id']; ?>" class="btn-sm btn-warning" title="Sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if($row['role'] != 'admin'): ?>
                                    <a href="delete.php?id=<?php echo $row['user_id']; ?>" 
                                       class="btn-sm btn-danger" 
                                       title="Xóa"
                                       onclick="return confirm('Cảnh báo: Bạn có chắc muốn xóa người dùng này?\nTất cả đơn hàng, đánh giá và dữ liệu liên quan sẽ bị xóa vĩnh viễn!')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Không có người dùng nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if($total_pages > 1): ?>
        <div class="pagination">
            <?php for($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" 
               class="<?php echo $page == $i ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>