<?php
class PageController {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function privacy() {
        $show_sidebar = false;
        include 'views/layouts/header.php';
        include 'views/page/privacy.php';
        include 'views/layouts/footer.php';
    }
    
    public function terms() {
        $show_sidebar = false;
        include 'views/layouts/header.php';
        include 'views/page/terms.php';
        include 'views/layouts/footer.php';
    }
}
?>