<?php
class HomeController {
    private $conn;
    
    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function index() {
        $categories = $this->getAllCategories();
        $bestSellers = $this->getBestSellers();
        $newProducts = $this->getNewProducts();
        $featuredProducts = $this->getFeaturedProducts();
        
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
    
    private function getAllCategories() {
        $sql = "SELECT c.category_id, c.category_name, c.description, COUNT(p.product_id) as product_count 
                FROM categories c 
                LEFT JOIN products p ON c.category_id = p.category_id 
                GROUP BY c.category_id, c.category_name, c.description 
                ORDER BY c.category_name";
        $result = mysqli_query($this->conn, $sql);
        $categories = [];
        $image_map = [
            1 => 'giay-nam.jpg',
            2 => 'giay-nu.jpg',
            3 => 'sneaker.jpg',
            4 => 'dep.jpg',
            5 => 'sandal.jpg'
        ];
        if($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $row['image'] = isset($image_map[$row['category_id']]) ? $image_map[$row['category_id']] : 'default-category.jpg';
                $categories[] = $row;
            }
        }
        return $categories;
    }
    
    private function getBestSellers() {
        $sql = "SELECT p.*, 
                       COALESCE(p.sale_price, p.price) as display_price,
                       p.price as original_price,
                       COALESCE(pi.image_url, 'default.jpg') as image_url,
                       c.category_name
                FROM products p 
                LEFT JOIN (
                    SELECT product_id, MIN(image_url) as image_url 
                    FROM product_images 
                    GROUP BY product_id
                ) pi ON p.product_id = pi.product_id 
                LEFT JOIN categories c ON p.category_id = c.category_id
                WHERE p.is_best_seller = 1 
                ORDER BY p.price DESC 
                LIMIT 8";
        $result = mysqli_query($this->conn, $sql);
        $products = [];
        if($result && mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $products[] = $row;
            }
        }
        return $products;
    }
    
    private function getNewProducts() {
        $sql = "SELECT p.*, 
                       COALESCE(p.sale_price, p.price) as display_price,
                       p.price as original_price,
                       COALESCE(pi.image_url, 'default.jpg') as image_url,
                       c.category_name
                FROM products p 
                LEFT JOIN (
                    SELECT product_id, MIN(image_url) as image_url 
                    FROM product_images 
                    GROUP BY product_id
                ) pi ON p.product_id = pi.product_id 
                LEFT JOIN categories c ON p.category_id = c.category_id
                ORDER BY p.created_at DESC 
                LIMIT 8";
        $result = mysqli_query($this->conn, $sql);
        if($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return [];
    }
    
    private function getFeaturedProducts() {
        $sql = "SELECT p.*, 
                       COALESCE(p.sale_price, p.price) as display_price,
                       p.price as original_price,
                       COALESCE(pi.image_url, 'default.jpg') as image_url,
                       c.category_name
                FROM products p 
                LEFT JOIN (
                    SELECT product_id, MIN(image_url) as image_url 
                    FROM product_images 
                    GROUP BY product_id
                ) pi ON p.product_id = pi.product_id 
                LEFT JOIN categories c ON p.category_id = c.category_id
                WHERE p.price > 1000000 
                ORDER BY p.product_id DESC 
                LIMIT 4";
        $result = mysqli_query($this->conn, $sql);
        if($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        return [];
    }
}
?>