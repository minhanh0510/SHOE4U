<?php
require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';

$category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Lấy thông tin danh mục
$category = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM categories WHERE category_id = $category_id"));

if (!$category) {
    $_SESSION['error'] = 'Không tìm thấy danh mục';
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    $sql = "UPDATE categories SET 
            category_name = '$category_name',
            description = '$description'
            WHERE category_id = $category_id";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = 'Cập nhật danh mục thành công';
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
    <h1>Sửa danh mục</h1>
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
                <input type="text" name="category_name" required class="form-control" 
                       value="<?php echo htmlspecialchars($category['category_name']); ?>">
            </div>
            
            <div class="form-group">
                <label>Mô tả</label>
                <textarea name="description" rows="3" class="form-control"><?php echo htmlspecialchars($category['description']); ?></textarea>
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

<?php include '../layouts/footer.php'; ?>