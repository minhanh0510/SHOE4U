<?php
class AdminController {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function index() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=auth&action=login&redirect=' . urlencode('index.php?controller=admin'));
            exit();
        }
        
        // Kiểm tra quyền admin
        if ($_SESSION['role'] !== 'admin') {
            // Nếu không phải admin, chuyển về trang chủ
            header('Location: index.php');
            exit();
        }
        
        // Nếu là admin, chuyển đến dashboard
        header('Location: views/admin/index.php');
        exit();
    }
}
?>