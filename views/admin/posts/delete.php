<?php
require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';


$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Lấy thông tin bài viết để xóa ảnh
$post = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM posts WHERE post_id = $post_id"));

if ($post) {
    // Xóa file ảnh trong thư mục uploads
    if ($post['thumbnail']) {
        $file_path = '../../../uploads/posts/' . $post['thumbnail'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    
    // Xóa bài viết trong database
    mysqli_query($conn, "DELETE FROM posts WHERE post_id = $post_id");
    
    $_SESSION['success'] = 'Xóa bài viết thành công';
} else {
    $_SESSION['error'] = 'Không tìm thấy bài viết';
}

header('Location: index.php');
exit();
?>