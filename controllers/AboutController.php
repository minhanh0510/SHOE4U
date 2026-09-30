<?php
class AboutController {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function index() {
        $show_sidebar = false; // TẮT sidebar cho trang giới thiệu
        include 'views/layouts/header.php';
        include 'views/about/index.php';
        include 'views/layouts/footer.php';
    }
}
?>