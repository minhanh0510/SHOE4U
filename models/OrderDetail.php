<?php
class OrderDetail {
    private $conn;
    private $table = "order_details";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Thêm chi tiết đơn hàng
    public function create($order_id, $variant_id, $quantity, $price) {
        $query = "INSERT INTO " . $this->table . " 
                  SET order_id=:order_id, variant_id=:variant_id, 
                      quantity=:quantity, price=:price";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":order_id", $order_id);
        $stmt->bindParam(":variant_id", $variant_id);
        $stmt->bindParam(":quantity", $quantity);
        $stmt->bindParam(":price", $price);

        return $stmt->execute();
    }
}
?>