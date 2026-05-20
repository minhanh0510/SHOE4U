<?php
class Payment {
    private $conn;
    private $table = "payments";

    public $payment_id;
    public $order_id;
    public $method;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Tạo payment record
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  SET order_id=:order_id, method=:method, status=:status";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":order_id", $this->order_id);
        $stmt->bindParam(":method", $this->method);
        $stmt->bindParam(":status", $this->status);

        if($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Cập nhật trạng thái payment
    public function updateStatus($payment_id, $status) {
        $paid_at = ($status == 'Paid') ? date('Y-m-d H:i:s') : null;
        
        $query = "UPDATE " . $this->table . " 
                  SET status = :status, paid_at = :paid_at 
                  WHERE payment_id = :payment_id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":paid_at", $paid_at);
        $stmt->bindParam(":payment_id", $payment_id);
        
        return $stmt->execute();
    }

    // Giả lập thanh toán Momo
    public function processMomoPayment($order_id, $amount) {
        // Fake Momo API - trong thực tế sẽ call API thật
        $transaction_id = 'MOMO' . time() . rand(1000, 9999);
        
        // Giả lập thanh toán thành công
        return [
            'success' => true,
            'transaction_id' => $transaction_id,
            'message' => 'Thanh toán Momo thành công'
        ];
    }
}
?>