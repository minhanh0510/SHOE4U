<?php
require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    
    // Xử lý upload thumbnail
    $thumbnail = '';
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
        $upload_dir = '../../../uploads/posts/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_name = time() . '_' . $_FILES['thumbnail']['name'];
        $file_path = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $file_path)) {
            $thumbnail = $file_name;
        }
    }
    
    $sql = "INSERT INTO posts (title, content, thumbnail) VALUES ('$title', '$content', '$thumbnail')";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = 'Thêm bài viết thành công';
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
    <h1>Thêm bài viết mới</h1>
    <a href="<?= ADMIN_URL ?>users/index.php" class="btn btn-secondary">
    <i class="fas fa-arrow-left"></i> Quay lại
</a>
</div>

<div class="card">
    <div class="card-body">
        <?php if(isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Tiêu đề <span class="required">*</span></label>
                <input type="text" name="title" required class="form-control">
            </div>
            
            <div class="form-group">
                <label>Ảnh đại diện</label>
                <input type="file" name="thumbnail" accept="image/*" class="form-control">
                <small>Nên chọn ảnh có kích thước 800x400px</small>
            </div>
            
            <div class="form-group">
                <label>Nội dung <span class="required">*</span></label>
                <textarea name="content" rows="10" required class="form-control"></textarea>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Đăng bài</button>
                <button type="reset" class="btn btn-secondary">Nhập lại</button>
            </div>
        </form>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>