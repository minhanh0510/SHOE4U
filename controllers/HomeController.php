<?php
class HomeController {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function index() {
        // Lấy tất cả danh mục sản phẩm (phân loại sản phẩm)
        $categories = $this->getAllCategories();
        
        // Lấy sản phẩm bán chạy (is_best_seller = 1)
        $bestSellers = $this->getBestSellers();
        
        // Lấy sản phẩm mới nhất
        $newProducts = $this->getNewProducts();
        
        // Lấy sản phẩm nổi bật
        $featuredProducts = $this->getFeaturedProducts();
        
        // Banner quảng cáo
        $banners = [
            ['image' => 'banner1.jpg', 'title' => 'Summer Sale 2026', 'subtitle' => 'Giảm giá lên đến 50% cho giày thể thao', 'link' => 'index.php?controller=product&action=category&category=3'],
            ['image' => 'banner2.jpg', 'title' => 'New Collection', 'subtitle' => 'Bộ sưu tập giày mới nhất', 'link' => 'index.php?controller=product&action=category'],
            ['image' => 'banner3.jpg', 'title' => 'Free Shipping', 'subtitle' => 'Miễn phí vận chuyển cho đơn hàng từ 500k', 'link' => 'index.php?controller=product&action=category']
        ];
        
        $show_sidebar = false;
        
        include 'views/layouts/header.php';
        include 'views/home/index.php';
        include 'views/layouts/footer.php';
    }
    
    // Lấy tất cả danh mục (phân loại sản phẩm)
    private function getAllCategories() {
        $sql = "SELECT category_id, category_name, description 
                FROM categories 
                ORDER BY category_name";
        
        $result = mysqli_query($this->conn, $sql);
        
        $categories = [];
        if($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                // Ánh xạ ảnh cho danh mục
                $image_map = [
                    1 => 'giay-nam.jpg',
                    2 => 'giay-nu.jpg',
                    3 => 'sneaker.jpg',
                    4 => 'dep.jpg',
                    5 => 'sandal.jpg'
                ];
                
                // Đếm số sản phẩm trong danh mục
                $count_sql = "SELECT COUNT(*) as total FROM products WHERE category_id = " . $row['category_id'];
                $count_result = mysqli_query($this->conn, $count_sql);
                $count_row = mysqli_fetch_assoc($count_result);
                $row['product_count'] = $count_row['total'];
                
                $row['image'] = isset($image_map[$row['category_id']]) ? $image_map[$row['category_id']] : 'default-category.jpg';
                $categories[] = $row;
            }
        }
        return $categories;
    }
    
    // Lấy sản phẩm bán chạy
    private function getBestSellers() {
        $sql = "SELECT p.*, 
                       COALESCE(pi.image_url, 'default.jpg') as image_url,
                       c.category_name
                FROM products p 
                LEFT JOIN product_images pi ON p.product_id = pi.product_id 
                LEFT JOIN categories c ON p.category_id = c.category_id
                WHERE p.is_best_seller = 1 
                ORDER BY p.price DESC 
                LIMIT 8";
        
        $result = mysqli_query($this->conn, $sql);
        
        $products = [];
        if($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                // Tính giá sau giảm (giả sử giảm 10% cho sản phẩm bán chạy)
                $row['sale_price'] = $row['price'] * 0.9;
                $products[] = $row;
            }
        }
        return $products;
    }
    
    // Lấy sản phẩm mới nhất
    private function getNewProducts() {
        $sql = "SELECT p.*, 
                       COALESCE(pi.image_url, 'default.jpg') as image_url,
                       c.category_name
                FROM products p 
                LEFT JOIN product_images pi ON p.product_id = pi.product_id 
                LEFT JOIN categories c ON p.category_id = c.category_id
                ORDER BY p.created_at DESC 
                LIMIT 8";
        
        $result = mysqli_query($this->conn, $sql);
        
        if($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return [];
    }
    
    // Lấy sản phẩm nổi bật
    private function getFeaturedProducts() {
        $sql = "SELECT p.*, 
                       COALESCE(pi.image_url, 'default.jpg') as image_url,
                       c.category_name
                FROM products p 
                LEFT JOIN product_images pi ON p.product_id = pi.product_id 
                LEFT JOIN categories c ON p.category_id = c.category_id
                WHERE p.price > 1000000 
                ORDER BY RAND() 
                LIMIT 4";
        
        $result = mysqli_query($this->conn, $sql);
        
        if($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return [];
    }
}
?>