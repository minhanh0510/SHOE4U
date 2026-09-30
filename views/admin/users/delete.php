<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';

$user_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Kiểm tra user có tồn tại không
$check = mysqli_query($conn, "SELECT * FROM users WHERE user_id = $user_id");
if (mysqli_num_rows($check) == 0) {
    $_SESSION['error'] = 'Không tìm thấy người dùng';
    header('Location: index.php');
    exit();
}

// Kiểm tra có phải admin không (không cho xóa admin)
$user = mysqli_fetch_assoc($check);
if ($user['role'] == 'admin') {
    $_SESSION['error'] = 'Không thể xóa tài khoản admin';
    header('Location: index.php');
    exit();
}

// TẮT KHÓA NGOẠI TẠM THỜI
mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

// Lấy tất cả đơn hàng của user
$orders = mysqli_query($conn, "SELECT order_id FROM orders WHERE user_id = $user_id");
$order_ids = [];
while($order = mysqli_fetch_assoc($orders)) {
    $order_ids[] = $order['order_id'];
}

if (!empty($order_ids)) {
    $order_list = implode(',', $order_ids);
    
    // Xóa order_details trước
    mysqli_query($conn, "DELETE FROM order_details WHERE order_id IN ($order_list)");
    
    // Xóa payments
    mysqli_query($conn, "DELETE FROM payments WHERE order_id IN ($order_list)");
}

// Xóa reviews
mysqli_query($conn, "DELETE FROM reviews WHERE user_id = $user_id");

// Xóa cart_items (giỏ hàng)
$carts = mysqli_query($conn, "SELECT cart_id FROM carts WHERE user_id = $user_id");
while($cart = mysqli_fetch_assoc($carts)) {
    mysqli_query($conn, "DELETE FROM cart_items WHERE cart_id = {$cart['cart_id']}");
}

// Xóa carts
mysqli_query($conn, "DELETE FROM carts WHERE user_id = $user_id");

// Xóa orders
mysqli_query($conn, "DELETE FROM orders WHERE user_id = $user_id");

// Cuối cùng xóa user
mysqli_query($conn, "DELETE FROM users WHERE user_id = $user_id");

// BẬT LẠI KHÓA NGOẠI
mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

// Kiểm tra xem user đã được xóa chưa
$check_again = mysqli_query($conn, "SELECT * FROM users WHERE user_id = $user_id");
if (mysqli_num_rows($check_again) == 0) {
    $_SESSION['success'] = 'Xóa người dùng thành công';
} else {
    $_SESSION['error'] = 'Không thể xóa người dùng';
}

header('Location: index.php');
exit();
?>