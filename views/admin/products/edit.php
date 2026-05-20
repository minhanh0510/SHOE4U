<?php
require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Lấy thông tin sản phẩm
$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE product_id = $product_id"));

if (!$product) {
    $_SESSION['error'] = 'Không tìm thấy sản phẩm';
    header('Location: index.php');
    exit();
}

// Lấy danh sách danh mục
$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY category_name");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price = $_POST['price'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category_id = $_POST['category_id'];
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $gender = $_POST['gender'];
    $is_best_seller = isset($_POST['is_best_seller']) ? 1 : 0;
    
    $sql = "UPDATE products SET 
            product_name = '$product_name',
            price = $price,
            description = '$description',
            category_id = $category_id,
            brand = '$brand',
            gender = '$gender',
            is_best_seller = $is_best_seller
            WHERE product_id = $product_id";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = 'Cập nhật sản phẩm thành công';
        header("Location: index.php");
        exit();
    } else {
        $error = 'Lỗi: ' . mysqli_error($conn);
    }
}

include '../layouts/header.php';
include '../layouts/sidebar.php';
?>

<div class="content-header">
    <h1>Sửa sản phẩm: <?php echo $product['product_name']; ?></h1>
    <div>
        <a href="variants.php?id=<?php echo $product_id; ?>" class="btn btn-info">
            <i class="fas fa-palette"></i> Quản lý biến thể
        </a>
        <a href="images.php?id=<?php echo $product_id; ?>" class="btn btn-info">
            <i class="fas fa-image"></i> Quản lý ảnh
        </a>
        <a href="<?= ADMIN_URL ?>users/index.php" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Quay lại
</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>
        
        <form method="POST" class="form">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Tên sản phẩm <span class="required">*</span></label>
                        <input type="text" name="product_name" required class="form-control" 
                               value="<?php echo $product['product_name']; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Giá <span class="required">*</span></label>
                        <input type="number" name="price" required class="form-control" min="0"
                               value="<?php echo $product['price']; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Danh mục <span class="required">*</span></label>
                        <select name="category_id" required class="form-control">
                            <option value="">-- Chọn danh mục --</option>
                            <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                                <option value="<?php echo $cat['category_id']; ?>"
                                    <?php echo $cat['category_id'] == $product['category_id'] ? 'selected' : ''; ?>>
                                    <?php echo $cat['category_name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Thương hiệu</label>
                        <input type="text" name="brand" class="form-control" 
                               value="<?php echo $product['brand']; ?>">
                    </div>
                </div>
                
                <div class="col-6">
                    <div class="form-group">
                        <label>Giới tính</label>
                        <select name="gender" class="form-control">
                            <option value="Unisex" <?php echo $product['gender'] == 'Unisex' ? 'selected' : ''; ?>>Unisex</option>
                            <option value="Nam" <?php echo $product['gender'] == 'Nam' ? 'selected' : ''; ?>>Nam</option>
                            <option value="Nữ" <?php echo $product['gender'] == 'Nữ' ? 'selected' : ''; ?>>Nữ</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="is_best_seller" value="1"
                                <?php echo $product['is_best_seller'] ? 'checked' : ''; ?>>
                            Sản phẩm bán chạy
                        </label>
                    </div>
                    
                    <div class="form-group">
                        <label>Mô tả sản phẩm</label>
                        <textarea name="description" rows="5" class="form-control"><?php echo $product['description']; ?></textarea>
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Cập nhật sản phẩm
                </button>
                <a href="index.php" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>

<!-- Thông tin thêm -->
<div class="row mt-3">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3>Thông tin biến thể</h3>
                <a href="variants.php?id=<?php echo $product_id; ?>" class="btn-sm btn-primary">Thêm biến thể</a>
            </div>
            <div class="card-body">
                <?php
                $variants = mysqli_query($conn, "SELECT * FROM product_variants WHERE product_id = $product_id LIMIT 5");
                if(mysqli_num_rows($variants) > 0):
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Size</th>
                            <th>Màu</th>
                            <th>Tồn kho</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($var = mysqli_fetch_assoc($variants)): ?>
                        <tr>
                            <td><?php echo $var['size']; ?></td>
                            <td><?php echo $var['color']; ?></td>
                            <td><?php echo $var['stock']; ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p class="text-center">Chưa có biến thể nào</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3>Ảnh sản phẩm</h3>
                <a href="images.php?id=<?php echo $product_id; ?>" class="btn-sm btn-primary">Thêm ảnh</a>
            </div>
            <div class="card-body">
                <div class="image-gallery" style="grid-template-columns: repeat(4, 1fr);">
                    <?php
                    $images = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id = $product_id LIMIT 4");
                    if(mysqli_num_rows($images) > 0):
                        while($img = mysqli_fetch_assoc($images)):
                    ?>
                    <div class="image-item">
                        <img src="<?php echo BASE_URL; ?>/uploads/products/<?php echo $img['image_url']; ?>" 
                             style="height: 80px;">
                    </div>
                    <?php 
                        endwhile;
                    else:
                    ?>
                    <p class="text-center">Chưa có ảnh</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>