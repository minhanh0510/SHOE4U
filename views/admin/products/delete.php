<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Kiểm tra sản phẩm
$check = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $product_id");
if (mysqli_num_rows($check) == 0) {
    $_SESSION['error'] = 'Không tìm thấy sản phẩm';
    header('Location: index.php');
    exit();
}

// Lấy tất cả variant_id
$variants = mysqli_query($conn, "SELECT variant_id FROM product_variants WHERE product_id = $product_id");
$variant_ids = [];
while($v = mysqli_fetch_assoc($variants)) {
    $variant_ids[] = $v['variant_id'];
}

// Xóa theo thứ tự
if (!empty($variant_ids)) {
    $variant_list = implode(',', $variant_ids);
    
    // Xóa cart_items
    mysqli_query($conn, "DELETE FROM cart_items WHERE variant_id IN ($variant_list)");
    
    // Xóa order_details
    mysqli_query($conn, "DELETE FROM order_details WHERE variant_id IN ($variant_list)");
}

// Xóa reviews
mysqli_query($conn, "DELETE FROM reviews WHERE product_id = $product_id");

// Xóa ảnh trong thư mục
$images = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id = $product_id");
while($img = mysqli_fetch_assoc($images)) {
    $file_path = __DIR__ . '/../../../assets/images/products/' . $img['image_url'];
    if(file_exists($file_path)) {
        unlink($file_path);
    }
}

// Xóa product_images
mysqli_query($conn, "DELETE FROM product_images WHERE product_id = $product_id");

// Xóa product_variants
mysqli_query($conn, "DELETE FROM product_variants WHERE product_id = $product_id");

// Xóa products
mysqli_query($conn, "DELETE FROM products WHERE product_id = $product_id");

$_SESSION['success'] = 'Xóa sản phẩm thành công';
header('Location: index.php');
exit();
?>