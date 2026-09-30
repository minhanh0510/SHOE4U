<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$where = $search ? "WHERE p.product_name LIKE '%$search%' OR p.brand LIKE '%$search%'" : '';

// Tổng số sản phẩm
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM products p $where"))['total'];
$total_pages = ceil($total / $limit);

// Lấy danh sách sản phẩm
$sql = "SELECT p.*, c.category_name,
        (SELECT SUM(stock) FROM product_variants WHERE product_id = p.product_id) as total_stock
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.category_id
        $where
        ORDER BY p.created_at DESC
        LIMIT $offset, $limit";
$products = mysqli_query($conn, $sql);

include '../layouts/header.php';
include '../layouts/sidebar.php';
?>

<div class="content-header">
    <h1>Quản lý sản phẩm</h1>
    <a href="add.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm sản phẩm
    </a>
</div>

<!-- Search Form -->
<div class="card">
    <div class="card-body">
        <form method="GET" class="search-form">
            <div class="form-group" style="display: flex; gap: 10px;">
                <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." 
                       value="<?php echo $search; ?>" style="flex: 1; padding: 8px;">
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

<!-- Products Table -->
<div class="card mt-3">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Tồn kho</th>
                    <th>Bán chạy</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($products) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($products)): ?>
                    <tr>
                        <td>#<?php echo $row['product_id']; ?></td>
                        <td>
                            <?php 
                            $img = mysqli_query($conn, "SELECT image_url FROM product_images WHERE product_id = " . $row['product_id'] . " LIMIT 1");
                            if(mysqli_num_rows($img) > 0):
                                $img_row = mysqli_fetch_assoc($img);
                            ?>
                                <!-- ĐƯỜNG DẪN ĐÚNG: ../../../ -->
                                <img src="../../../assets/images/products/<?php echo $img_row['image_url']; ?>" 
                                     width="50" height="50" style="object-fit: cover; border-radius: 4px;">
                            <?php else: ?>
                                <!-- ĐƯỜNG DẪN ĐÚNG: ../../../ -->
                                <img src="../../../assets/images/no-image.png" width="50" height="50" style="object-fit: cover; border-radius: 4px;">
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($row['product_name']); ?></strong>
                            <br>
                            <small style="color: #64748b;"><?php echo htmlspecialchars($row['brand']); ?></small>
                        </td>
                        <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                        <td><?php echo formatMoney($row['price']); ?></td>
                        <td>
                            <?php if($row['total_stock'] > 0): ?>
                                <span class="badge badge-success"><?php echo $row['total_stock']; ?> cái</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Hết hàng</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($row['is_best_seller']): ?>
                                <span class="badge badge-warning">Bán chạy</span>
                            <?php endif; ?>
                        </td>
                        <td class="actions" style="white-space: nowrap;">
                            <a href="variants.php?id=<?php echo $row['product_id']; ?>" class="btn-sm btn-info" title="Biến thể">
                                <i class="fas fa-palette"></i>
                            </a>
                            <a href="edit.php?id=<?php echo $row['product_id']; ?>" class="btn-sm btn-warning" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="delete.php?id=<?php echo $row['product_id']; ?>" 
                               class="btn-sm btn-danger" 
                               title="Xóa"
                               onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Không có sản phẩm nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <!-- Pagination -->
        <?php if($total_pages > 1): ?>
        <div class="pagination">
            <?php for($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>" 
               class="<?php echo $page == $i ? 'active' : ''; ?>">
                <?php echo $i; ?>
            </a>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>