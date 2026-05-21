<?php
class PostController {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    // Danh sách bài viết
    public function index() {
        $show_sidebar = true;
        
        // Lấy danh sách bài viết
        $sql = "SELECT * FROM posts ORDER BY created_at DESC";
        $result = mysqli_query($this->conn, $sql);
        $posts = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $posts[] = $row;
            }
        }
        
        include 'views/layouts/header.php';
        include 'views/post/index.php';
        include 'views/layouts/footer.php';
    }
    
    // Chi tiết bài viết
    public function detail() {
        $show_sidebar = false;
        
        $post_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        $sql = "SELECT * FROM posts WHERE post_id = $post_id";
        $result = mysqli_query($this->conn, $sql);
        $post = mysqli_fetch_assoc($result);
        
        if (!$post) {
            header('Location: index.php?controller=post&action=index');
            exit();
        }
        
        // Lấy bài viết liên quan (cùng tháng)
        $related_sql = "SELECT * FROM posts WHERE post_id != $post_id ORDER BY created_at DESC LIMIT 3";
        $related_result = mysqli_query($this->conn, $related_sql);
        $related_posts = [];
        if ($related_result && mysqli_num_rows($related_result) > 0) {
            while ($row = mysqli_fetch_assoc($related_result)) {
                $related_posts[] = $row;
            }
        }
        
        include 'views/layouts/header.php';
        include 'views/post/detail.php';
        include 'views/layouts/footer.php';
    }
}
?>