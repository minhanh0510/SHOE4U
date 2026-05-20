<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Đường dẫn đến database.php
require_once __DIR__ . '/../../../config/database.php';

// Định nghĩa đường dẫn tuyệt đối đến thư mục admin
// Điều chỉnh tên thư mục nếu cần (ví dụ 'Shoe4U_1')
define('ADMIN_URL', '/Shoe4U_1/views/admin/');

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../auth/login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
    exit();
}

// Kiểm tra quyền admin
if ($_SESSION['role'] !== 'admin') {
    header('Location: ../../../index.php?error=unauthorized');
    exit();
}

$admin_id = $_SESSION['user_id'];
$admin_name = $_SESSION['full_name'];
?>