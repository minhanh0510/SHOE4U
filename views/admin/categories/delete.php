<?php
require_once '../layouts/auth_check.php';

$category_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Kiểm tra xem danh mục có sản phẩm không
$check = mysqli_query($conn, "SELECT COUNT(*) as total FROM products WHERE category_id = $category_id");
$result = mysqli_fetch_assoc($check);

if ($result['total'] > 0) {
    $_SESSION['error'] = 'Không thể xóa danh mục này vì đang có ' . $result['total'] . ' sản phẩm thuộc danh mục';
} else {
    // Xóa danh mục
    mysqli_query($conn, "DELETE FROM categories WHERE category_id = $category_id");
    $_SESSION['success'] = 'Xóa danh mục thành công';
}

header('Location: index.php');
exit();
?>