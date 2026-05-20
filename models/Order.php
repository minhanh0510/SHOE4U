<?php
class Order {
    private $conn;
    private $table = "orders";

    public $order_id;
    public $user_id;
    public $total_price;
    public $status;
    public $shipping_address;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Tạo đơn hàng mới
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  SET user_id=:user_id, total_price=:total_price, 
                      status='Pending', shipping_address=:shipping_address";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":total_price", $this->total_price);
        $stmt->bindParam(":shipping_address", $this->shipping_address);

        if($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Lấy lịch sử đơn hàng của user
    public function getOrdersByUser($user_id) {
        $query = "SELECT o.*, p.method as payment_method, p.status as payment_status 
                  FROM " . $this->table . " o
                  LEFT JOIN payments p ON o.order_id = p.order_id
                  WHERE o.user_id = :user_id 
                  ORDER BY o.created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy chi tiết đơn hàng
    public function getOrderDetails($order_id) {
        $query = "SELECT od.*, p.product_name, p.price, pv.size, pv.color, pi.image_url
                  FROM order_details od
                  JOIN product_variants pv ON od.variant_id = pv.variant_id
                  JOIN products p ON pv.product_id = p.product_id
                  LEFT JOIN product_images pi ON p.product_id = pi.product_id
                  WHERE od.order_id = :order_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":order_id", $order_id);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy thông tin đơn hàng
    public function getOrderById($order_id) {
        $query = "SELECT o.*, p.method as payment_method, p.status as payment_status
                  FROM " . $this->table . " o
                  LEFT JOIN payments p ON o.order_id = p.order_id
                  WHERE o.order_id = :order_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":order_id", $order_id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus($order_id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":order_id", $order_id);
        
        return $stmt->execute();
    }
    
}
?>