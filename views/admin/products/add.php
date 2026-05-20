<?php
require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';


$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY category_name");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price = $_POST['price'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category_id = $_POST['category_id'];
    $brand = mysqli_real_escape_string($conn, $_POST['brand']);
    $gender = $_POST['gender'];
    $is_best_seller = isset($_POST['is_best_seller']) ? 1 : 0;
    
    $sql = "INSERT INTO products (product_name, price, description, category_id, brand, gender, is_best_seller) 
            VALUES ('$product_name', $price, '$description', $category_id, '$brand', '$gender', $is_best_seller)";
    
    if (mysqli_query($conn, $sql)) {
        $product_id = mysqli_insert_id($conn);
        $_SESSION['success'] = 'Thêm sản phẩm thành công';
        header("Location: variants.php?id=$product_id");
        exit();
    } else {
        $error = 'Lỗi: ' . mysqli_error($conn);
    }
}

include '../layouts/header.php';
include '../layouts/sidebar.php';
?>

<div class="content-header">
    <h1>Thêm sản phẩm mới</h1>
    <a href="<?= ADMIN_URL ?>users/index.php" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Quay lại
</a>
</div>

<div class="card">
    <div class="card-body">
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" class="form">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Tên sản phẩm <span class="required">*</span></label>
                        <input type="text" name="product_name" required class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>Giá <span class="required">*</span></label>
                        <input type="number" name="price" required class="form-control" min="0">
                    </div>
                    
                    <div class="form-group">
                        <label>Danh mục <span class="required">*</span></label>
                        <select name="category_id" required class="form-control">
                            <option value="">-- Chọn danh mục --</option>
                            <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                                <option value="<?php echo $cat['category_id']; ?>">
                                    <?php echo $cat['category_name']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Thương hiệu</label>
                        <input type="text" name="brand" class="form-control">
                    </div>
                </div>
                
                <div class="col-6">
                    <div class="form-group">
                        <label>Giới tính</label>
                        <select name="gender" class="form-control">
                            <option value="Unisex">Unisex</option>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="is_best_seller" value="1">
                            Sản phẩm bán chạy
                        </label>
                    </div>
                    
                    <div class="form-group">
                        <label>Mô tả sản phẩm</label>
                        <textarea name="description" rows="5" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Lưu và tiếp tục
                </button>
                <button type="reset" class="btn btn-secondary">Nhập lại</button>
            </div>
        </form>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>