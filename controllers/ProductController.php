<?php
class ProductController {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function index() {
        $this->category();
    }
    
    public function category() {
        $show_sidebar = true;
        
        // Lấy danh sách danh mục
        $categories = $this->getAllCategories();
        
        // Lấy sản phẩm theo filter
        $products = $this->getFilteredProducts();
        
        include 'views/layouts/header.php';
        include 'views/product/category.php';
        include 'views/layouts/footer.php';
    }
    
    public function detail() {
        $show_sidebar = false;
        
        // KIỂM TRA ID CÓ TỒN TẠI KHÔNG
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header('Location: index.php?controller=product&action=category');
            exit();
        }
        
        $product_id = (int)$_GET['id']; // Ép kiểu sang số nguyên
        
        // Debug - tạm thời hiển thị ID để kiểm tra
        // echo "Product ID: " . $product_id; 
        // die();
        
        $product = $this->getProductById($product_id);
        
        if (!$product) {
            // Nếu không tìm thấy sản phẩm, chuyển về trang danh sách
            header('Location: index.php?controller=product&action=category');
            exit();
        }
        
        $relatedProducts = $this->getRelatedProducts($product['category_id'], $product_id);
        $productVariants = $this->getProductVariants($product_id);
        $productReviews = $this->getProductReviews($product_id);
        $productImages = $this->getProductImages($product_id);
        $categories = $this->getAllCategories();
        
        $cartItemCount = 0;
        if (isset($_SESSION['user_id'])) {
            $cartItemCount = $this->getCartItemCount($_SESSION['user_id']);
        }
        
        include 'views/layouts/header.php';
        include 'views/product/detail.php';
        include 'views/layouts/footer.php';
    }

    private function getCartItemCount($userId) {
        $sql = "SELECT SUM(ci.quantity) as total_items
                FROM carts c
                JOIN cart_items ci ON c.cart_id = ci.cart_id
                WHERE c.user_id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        return isset($row['total_items']) ? (int)$row['total_items'] : 0;
    }
    
    private function getAllCategories() {
        $sql = "SELECT * FROM categories ORDER BY category_name";
        $result = mysqli_query($this->conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return [];
    }
    
    private function getFilteredProducts() {
        $category_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $price_range = isset($_GET['price']) ? $_GET['price'] : '';
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'default';
        
        $sql = "SELECT p.*, 
                       COALESCE(pi.image_url, 'default.jpg') as image_url
                FROM products p 
                LEFT JOIN product_images pi ON p.product_id = pi.product_id 
                WHERE 1=1";
        
        if ($category_id > 0) {
            $sql .= " AND p.category_id = $category_id";
        }
        
        if (!empty($search)) {
            $search = mysqli_real_escape_string($this->conn, $search);
            $sql .= " AND p.product_name LIKE '%$search%'";
        }
        
        if (!empty($price_range)) {
            switch($price_range) {
                case 'under500':
                    $sql .= " AND p.price < 500000";
                    break;
                case '500to1m':
                    $sql .= " AND p.price BETWEEN 500000 AND 1000000";
                    break;
                case '1mto2m':
                    $sql .= " AND p.price BETWEEN 1000000 AND 2000000";
                    break;
                case 'above2m':
                    $sql .= " AND p.price > 2000000";
                    break;
            }
        }
        
        // Xử lý sắp xếp
        switch($sort) {
            case 'price_asc':
                $sql .= " ORDER BY p.price ASC";
                break;
            case 'price_desc':
                $sql .= " ORDER BY p.price DESC";
                break;
            case 'name_asc':
                $sql .= " ORDER BY p.product_name ASC";
                break;
            case 'name_desc':
                $sql .= " ORDER BY p.product_name DESC";
                break;
            default:
                $sql .= " ORDER BY p.created_at DESC";
        }
        
        $result = mysqli_query($this->conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return [];
    }
    
    private function getProductById($id) {
        // Lấy thông tin sản phẩm chính
        $sql = "SELECT p.*, c.category_name FROM products p 
                LEFT JOIN categories c ON p.category_id = c.category_id
                WHERE p.product_id = $id LIMIT 1";
        $result = mysqli_query($this->conn, $sql);
        
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
        
        return null;
    }
    
    private function getRelatedProducts($category_id, $current_product_id) {
        $sql = "SELECT p.*,
                       COALESCE(pi.image_url, 'default.jpg') as image_url
                FROM products p 
                LEFT JOIN product_images pi ON p.product_id = pi.product_id 
                WHERE p.category_id = $category_id 
                AND p.product_id != $current_product_id 
                LIMIT 4";
        $result = mysqli_query($this->conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return [];
    }
    
    private function getProductVariants($product_id) {
        $sql = "SELECT * FROM product_variants WHERE product_id = ? ORDER BY size, color";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $product_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $variants = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $variants[] = $row;
        }
        return $variants;
    }
    
    private function getProductReviews($product_id) {
        $sql = "SELECT r.*, u.full_name 
                FROM reviews r 
                LEFT JOIN users u ON r.user_id = u.user_id 
                WHERE r.product_id = ? 
                ORDER BY r.created_at DESC";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $product_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $reviews = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $reviews[] = $row;
        }
        return $reviews;
    }
    
    private function getProductImages($product_id) {
        $sql = "SELECT * FROM product_images WHERE product_id = ? ORDER BY image_id";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $product_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        $images = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $images[] = $row;
        }
        return $images;
    }
}
?>