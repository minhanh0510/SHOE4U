<?php
require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';


$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE product_id = $product_id"));

if (!$product) {
    header('Location: index.php');
    exit();
}

// Xử lý thêm biến thể
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_variant'])) {
    $size = $_POST['size'];
    $color = mysqli_real_escape_string($conn, $_POST['color']);
    $stock = $_POST['stock'];
    
    $sql = "INSERT INTO product_variants (product_id, size, color, stock) 
            VALUES ($product_id, $size, '$color', $stock)";
    mysqli_query($conn, $sql);
    $_SESSION['success'] = 'Thêm biến thể thành công';
    header("Location: variants.php?id=$product_id");
    exit();
}

// Xử lý xóa biến thể
if (isset($_GET['delete_variant'])) {
    $variant_id = $_GET['delete_variant'];
    mysqli_query($conn, "DELETE FROM product_variants WHERE variant_id = $variant_id");
    $_SESSION['success'] = 'Xóa biến thể thành công';
    header("Location: variants.php?id=$product_id");
    exit();
}

$variants = mysqli_query($conn, "SELECT * FROM product_variants WHERE product_id = $product_id ORDER BY size, color");

include '../layouts/header.php';
include '../layouts/sidebar.php';
?>

<div class="content-header">
    <h1>Quản lý biến thể: <?php echo $product['product_name']; ?></h1>
    <div>
        <a href="images.php?id=<?php echo $product_id; ?>" class="btn btn-info">
            <i class="fas fa-image"></i> Quản lý ảnh
        </a>
        <a href="index.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
</div>

<?php if(isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<!-- Form thêm biến thể -->
<div class="card">
    <div class="card-header">
        <h3>Thêm biến thể mới</h3>
    </div>
    <div class="card-body">
        <form method="POST" class="form-inline">
            <div class="form-group">
                <label>Size:</label>
                <input type="number" name="size" required min="35" max="45" placeholder="39, 40, 41...">
            </div>
            <div class="form-group">
                <label>Màu:</label>
                <input type="text" name="color" required placeholder="Trắng, Đen, Hồng...">
            </div>
            <div class="form-group">
                <label>Số lượng:</label>
                <input type="number" name="stock" required min="0" value="0">
            </div>
            <button type="submit" name="add_variant" class="btn btn-primary">Thêm</button>
        </form>
    </div>
</div>

<!-- Danh sách biến thể -->
<div class="card mt-3">
    <div class="card-header">
        <h3>Danh sách biến thể</h3>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Size</th>
                    <th>Màu sắc</th>
                    <th>Tồn kho</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($variants) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($variants)): ?>
                    <tr>
                        <td>#<?php echo $row['variant_id']; ?></td>
                        <td><?php echo $row['size']; ?></td>
                        <td><?php echo $row['color']; ?></td>
                        <td>
                            <?php if($row['stock'] > 0): ?>
                                <span class="badge badge-success"><?php echo $row['stock']; ?></span>
                            <?php else: ?>
                                <span class="badge badge-danger">Hết</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="?id=<?php echo $product_id; ?>&delete_variant=<?php echo $row['variant_id']; ?>" 
                               class="btn-sm btn-danger"
                               onclick="return confirm('Xóa biến thể này?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Chưa có biến thể nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>