<?php
class Cart {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Lấy giỏ hàng của user
    public function getCart($user_id) {
        $sql = "SELECT c.cart_id, ci.cart_item_id, ci.quantity,
                       pv.variant_id, pv.size, pv.color, pv.stock,
                       p.product_id, p.product_name, p.price,
                       COALESCE((SELECT image_url FROM product_images WHERE product_id = p.product_id LIMIT 1), 'default.jpg') as image_url
                FROM carts c
                LEFT JOIN cart_items ci ON c.cart_id = ci.cart_id
                LEFT JOIN product_variants pv ON ci.variant_id = pv.variant_id
                LEFT JOIN products p ON pv.product_id = p.product_id
                WHERE c.user_id = ?
                ORDER BY ci.cart_item_id";

        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $cart_items = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $cart_items[] = $row;
        }

        return $cart_items;
    }

    // Lấy giỏ hàng từ danh sách variant_id (dùng cho guest cart lưu trong session)
    public function getCartByVariantIds(array $variantIds) {
        if (empty($variantIds)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($variantIds), '?'));
        $types = str_repeat('i', count($variantIds));

        $sql = "SELECT pv.variant_id, pv.size, pv.color, pv.stock,
                       p.product_id, p.product_name, p.price,
                       COALESCE(pi.image_url, 'default.jpg') as image_url
                FROM product_variants pv
                LEFT JOIN products p ON pv.product_id = p.product_id
                LEFT JOIN product_images pi ON p.product_id = pi.product_id
                WHERE pv.variant_id IN ($placeholders)";

        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, $types, ...$variantIds);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $cart_items = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $cart_items[] = $row;
        }

        return $cart_items;
    }

    // Lấy hoặc tạo giỏ hàng cho user
    public function getOrCreateCart($user_id) {
        // Kiểm tra xem user đã có giỏ hàng chưa
        $sql = "SELECT cart_id FROM carts WHERE user_id = ? LIMIT 1";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['cart_id'];
        } else {
            // Tạo giỏ hàng mới
            $sql = "INSERT INTO carts (user_id) VALUES (?)";
            $stmt = mysqli_prepare($this->conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $user_id);
            mysqli_stmt_execute($stmt);
            return mysqli_insert_id($this->conn);
        }
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($user_id, $variant_id, $quantity = 1) {
        $cart_id = $this->getOrCreateCart($user_id);

        // Kiểm tra xem variant đã có trong giỏ chưa
        $sql = "SELECT cart_item_id, quantity FROM cart_items WHERE cart_id = ? AND variant_id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $cart_id, $variant_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            // Cập nhật số lượng
            $row = mysqli_fetch_assoc($result);
            $new_quantity = $row['quantity'] + $quantity;
            $sql = "UPDATE cart_items SET quantity = ? WHERE cart_item_id = ?";
            $stmt = mysqli_prepare($this->conn, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $new_quantity, $row['cart_item_id']);
        } else {
            // Thêm mới
            $sql = "INSERT INTO cart_items (cart_id, variant_id, quantity) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($this->conn, $sql);
            mysqli_stmt_bind_param($stmt, "iii", $cart_id, $variant_id, $quantity);
        }

        return mysqli_stmt_execute($stmt);
    }

    // Cập nhật số lượng
    public function updateQuantity($user_id, $variant_id, $quantity) {
        $cart_id = $this->getOrCreateCart($user_id);

        if ($quantity <= 0) {
            // Xóa item nếu quantity <= 0
            return $this->removeFromCart($user_id, $variant_id);
        }

        $sql = "UPDATE cart_items SET quantity = ? WHERE cart_id = ? AND variant_id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "iii", $quantity, $cart_id, $variant_id);
        return mysqli_stmt_execute($stmt);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($user_id, $variant_id) {
        $cart_id = $this->getOrCreateCart($user_id);

        $sql = "DELETE FROM cart_items WHERE cart_id = ? AND variant_id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $cart_id, $variant_id);
        return mysqli_stmt_execute($stmt);
    }

    // Lấy tổng số lượng items trong giỏ
    public function getCartItemCount($user_id) {
        $cart_id = $this->getOrCreateCart($user_id);

        // Số sản phẩm khác nhau (item rows) trong giỏ hàng, tương đương với số nút sản phẩm
        $sql = "SELECT COUNT(*) as total FROM cart_items WHERE cart_id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $cart_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0;
    }

    public function getCartTotalQuantity($user_id) {
        $cart_id = $this->getOrCreateCart($user_id);

        $sql = "SELECT COALESCE(SUM(quantity), 0) as total_quantity FROM cart_items WHERE cart_id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $cart_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $row = mysqli_fetch_assoc($result);
        return $row['total_quantity'] ?? 0;
    }

    // Lấy tổng tiền
    public function getCartTotal($user_id) {
        $cart_items = $this->getCart($user_id);
        $total = 0;

        foreach ($cart_items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

    // Xóa toàn bộ giỏ hàng
    public function clearCart($user_id) {
        $cart_id = $this->getOrCreateCart($user_id);

        $sql = "DELETE FROM cart_items WHERE cart_id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $cart_id);
        return mysqli_stmt_execute($stmt);
    }
}
?>
