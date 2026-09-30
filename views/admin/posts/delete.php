<?php
require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';

$post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$post = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM posts WHERE post_id = $post_id"));

if ($post) {
    // Xóa file ảnh trong assets/images/posts/
    if ($post['thumbnail']) {
        $file_path = __DIR__ . '/../../../assets/images/posts/' . $post['thumbnail'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }
    
    mysqli_query($conn, "DELETE FROM posts WHERE post_id = $post_id");
    $_SESSION['success'] = 'Xóa bài viết thành công';
} else {
    $_SESSION['error'] = 'Không tìm thấy bài viết';
}

header('Location: index.php');
exit();
?>