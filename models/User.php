<?php
class User {
    private $conn;
    private $table = "users";

    public $user_id;
    public $full_name;
    public $email;
    public $password;
    public $phone;
    public $address;
    public $role;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Đăng ký
    public function register() {
        $query = "INSERT INTO " . $this->table . " 
                  SET full_name=:full_name, email=:email, password=:password, 
                      phone=:phone, address=:address, role='customer'";
        
        $stmt = $this->conn->prepare($query);
        
        $this->full_name = htmlspecialchars(strip_tags($this->full_name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        $this->phone = htmlspecialchars(strip_tags($this->phone));
        $this->address = htmlspecialchars(strip_tags($this->address));

        $stmt->bindParam(":full_name", $this->full_name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":phone", $this->phone);
        $stmt->bindParam(":address", $this->address);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Đăng nhập
    public function login() {
        $query = "SELECT user_id, full_name, email, password, phone, address, role 
                  FROM " . $this->table . " 
                  WHERE email = :email 
                  LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Kiểm tra password (hỗ trợ cả plain text cho dữ liệu cũ và bcrypt)
            if(password_verify($this->password, $row['password']) || $this->password == $row['password']) {
                $this->user_id = $row['user_id'];
                $this->full_name = $row['full_name'];
                $this->email = $row['email'];
                $this->phone = $row['phone'];
                $this->address = $row['address'];
                $this->role = $row['role'];
                return true;
            }
        }
        return false;
    }

    // Kiểm tra email tồn tại
    public function emailExists() {
        $query = "SELECT user_id FROM " . $this->table . " WHERE email = :email LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    // Lấy thông tin user theo ID
    public function getUserById($user_id) {
        $query = "SELECT * FROM " . $this->table . " WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>