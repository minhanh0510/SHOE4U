<?php
require_once '../layouts/auth_check.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    $sql = "INSERT INTO categories (category_name, description) VALUES ('$category_name', '$description')";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = 'Thêm danh mục thành công';
        header('Location: index.php');
        exit();
    } else {
        $error = 'Lỗi: ' . mysqli_error($conn);
    }
}

include '../layouts/header.php';
include '../layouts/sidebar.php';
?>

<div class="content-header">
    <h1>Thêm danh mục mới</h1>
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
            <div class="form-group">
                <label>Tên danh mục <span class="required">*</span></label>
                <input type="text" name="category_name" required class="form-control">
            </div>
            
            <div class="form-group">
                <label>Mô tả</label>
                <textarea name="description" rows="3" class="form-control"></textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Thêm danh mục</button>
                <button type="reset" class="btn btn-secondary">Nhập lại</button>
            </div>
        </form>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>