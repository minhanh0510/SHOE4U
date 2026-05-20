<?php
// Khởi động session nếu chưa có
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Xóa toàn bộ session
session_unset();
session_destroy();

// Chuyển hướng về trang chủ (hoặc trang login)
header('Location: ../../index.php');
exit();
?>