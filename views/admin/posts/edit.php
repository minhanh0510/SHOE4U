<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';

$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Lấy thông tin bài viết
$post = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM posts WHERE post_id = $post_id"));

if (!$post) {
    $_SESSION['error'] = 'Không tìm thấy bài viết';
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    
    // Xử lý upload thumbnail mới
    $thumbnail = $post['thumbnail']; // Giữ ảnh cũ
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
        $upload_dir = __DIR__ . '/../../../uploads/posts/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        // Xóa ảnh cũ
        if ($post['thumbnail'] && file_exists($upload_dir . $post['thumbnail'])) {
            unlink($upload_dir . $post['thumbnail']);
        }
        
        // Upload ảnh mới
        $file_ext = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
        $file_name = time() . '_' . $post_id . '.' . $file_ext;
        $file_path = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $file_path)) {
            $thumbnail = $file_name;
        }
    }
    
    $sql = "UPDATE posts SET 
            title = '$title',
            content = '$content',
            thumbnail = '$thumbnail'
            WHERE post_id = $post_id";
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = 'Cập nhật bài viết thành công';
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
    <h1>Sửa bài viết</h1>
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
                <input type="text" name="title" required class="form-control" 
                       value="<?php echo htmlspecialchars($post['title']); ?>">
            </div>
            
            <div class="form-group">
                <label>Ảnh đại diện hiện tại:</label>
                <?php if($post['thumbnail']): ?>
                    <div style="margin-bottom: 10px;">
                        <!-- SỬA ĐƯỜNG DẪN ẢNH HIỆN TẠI -->
                        <img src="../../../uploads/posts/<?php echo $post['thumbnail']; ?>" 
                             style="max-width: 200px; border: 1px solid #ddd; padding: 5px;">
                    </div>
                <?php endif; ?>
                <label>Thay đổi ảnh mới (nếu muốn):</label>
                <input type="file" name="thumbnail" accept="image/*" class="form-control">
                <small>Để trống nếu không muốn thay đổi ảnh</small>
            </div>
            
            <div class="form-group">
                <label>Nội dung <span class="required">*</span></label>
                <textarea name="content" rows="10" required class="form-control"><?php echo htmlspecialchars($post['content']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Ngày đăng:</label>
                <input type="text" class="form-control" value="<?php echo formatDate($post['created_at']); ?>" readonly disabled>
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