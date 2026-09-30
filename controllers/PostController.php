<?php
class PostController {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    // Danh sách bài viết
    public function index() {
        $sql = "SELECT * FROM posts ORDER BY created_at DESC";
        $result = mysqli_query($this->conn, $sql);
        $posts = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $posts[] = $row;
        }
        
        $show_sidebar = false;
        include 'views/layouts/header.php';
        include 'views/post/index.php';
        include 'views/layouts/footer.php';
    }
    
    // Chi tiết bài viết
    public function detail() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if (!$id) {
            header('Location: index.php?controller=post&action=index');
            exit();
        }
        
        $sql = "SELECT * FROM posts WHERE post_id = $id";
        $result = mysqli_query($this->conn, $sql);
        $post = mysqli_fetch_assoc($result);
        
        if (!$post) {
            header('Location: index.php?controller=post&action=index');
            exit();
        }
        
        $show_sidebar = false;
        include 'views/layouts/header.php';
        include 'views/post/detail.php';
        include 'views/layouts/footer.php';
    }
}
?>