<?php
class CartController {
    private $conn;
    private $cartModel;

    public function __construct($conn) {
        $this->conn = $conn;
        require_once 'models/Cart.php';
        $this->cartModel = new Cart($conn);
    }

    public function index() {
        $user_logged_in = isset($_SESSION['user_id']);
        
        if (!$user_logged_in) {
            header('Location: index.php?controller=auth&action=login&redirect=' . urlencode('index.php?controller=cart&action=index'));
            exit();
        }

        $user_id = $_SESSION['user_id'];
        $cart_items = $this->cartModel->getCart($user_id);

        // Lọc các sản phẩm quantity <=0 hoặc missing dữ liệu không hợp lệ
        $cart_items = array_filter($cart_items, function($item) {
            return isset($item['quantity']) && $item['quantity'] > 0;
        });

        $cart_total = $this->cartModel->getCartTotal($user_id);
        // Hiển thị số lượng thực tế tổng số sản phẩm (sum quantity)
        $item_count = $this->cartModel->getCartTotalQuantity($user_id);

        include 'views/layouts/header.php';
        include 'views/cart/index.php';
        include 'views/layouts/footer.php';
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $variant_id = isset($_POST['variant_id']) ? (int)$_POST['variant_id'] : 0;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

            if ($variant_id <= 0 || $quantity <= 0) {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
                exit();
            }

            // Kiểm tra tồn kho
            $stock = $this->checkStock($variant_id);
            if ($stock === false || $quantity > $stock) {
                echo json_encode(['success' => false, 'message' => 'Không đủ hàng trong kho']);
                exit();
            }

            if (!isset($_SESSION['user_id'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Vui lòng đăng nhập để tiếp tục mua hàng.',
                    'redirect' => 'index.php?controller=auth&action=login&redirect=' . urlencode('index.php?controller=cart&action=index')
                ]);
                exit();
            }

            $user_id = $_SESSION['user_id'];
            $result = $this->cartModel->addToCart($user_id, $variant_id, $quantity);

            if ($result) {
                $total_quantity = $this->cartModel->getCartTotalQuantity($user_id);
                echo json_encode([
                    'success' => true,
                    'message' => 'Đã thêm vào giỏ hàng',
                    'item_count' => $total_quantity,
                    'total_quantity' => $total_quantity
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi khi thêm vào giỏ hàng']);
            }
        }
        exit();
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $variant_id = isset($_POST['variant_id']) ? (int)$_POST['variant_id'] : 0;
            $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;

            if ($variant_id <= 0) {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
                exit();
            }

            // Kiểm tra tồn kho
            if ($quantity > 0) {
                $stock = $this->checkStock($variant_id);
                if ($stock === false || $quantity > $stock) {
                    echo json_encode(['success' => false, 'message' => 'Không đủ hàng trong kho']);
                    exit();
                }
            }

            if (!isset($_SESSION['user_id'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Vui lòng đăng nhập để tiếp tục mua hàng.',
                    'redirect' => 'index.php?controller=auth&action=login&redirect=' . urlencode('index.php?controller=cart&action=index')
                ]);
                exit();
            }

            $user_id = $_SESSION['user_id'];
            $result = $this->cartModel->updateQuantity($user_id, $variant_id, $quantity);

            if ($result) {
                $cart_total = $this->cartModel->getCartTotal($user_id);
                $total_quantity = $this->cartModel->getCartTotalQuantity($user_id);
                echo json_encode([
                    'success' => true,
                    'message' => 'Đã cập nhật giỏ hàng',
                    'cart_total' => $cart_total,
                    'item_count' => $total_quantity,
                    'total_quantity' => $total_quantity
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi khi cập nhật giỏ hàng']);
            }
        }
        exit();
    }

    public function remove() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $variant_id = isset($_POST['variant_id']) ? (int)$_POST['variant_id'] : 0;

            if ($variant_id <= 0) {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ']);
                exit();
            }

            if (!isset($_SESSION['user_id'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'Vui lòng đăng nhập để tiếp tục mua hàng.',
                    'redirect' => 'index.php?controller=auth&action=login&redirect=' . urlencode('index.php?controller=cart&action=index')
                ]);
                exit();
            }

            $user_id = $_SESSION['user_id'];
            $result = $this->cartModel->removeFromCart($user_id, $variant_id);

            header('Content-Type: application/json');
            if ($result) {
                $cart_total = $this->cartModel->getCartTotal($user_id);
                $total_quantity = $this->cartModel->getCartTotalQuantity($user_id);
                echo json_encode([
                    'success' => true,
                    'message' => 'Đã xóa sản phẩm khỏi giỏ hàng',
                    'cart_total' => $cart_total,
                    'item_count' => $total_quantity,
                    'total_quantity' => $total_quantity
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Lỗi khi xóa sản phẩm']);
            }
        }
        exit();
    }

    public function count() {
        header('Content-Type: application/json');
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Chưa đăng nhập']);
            exit();
        }

        $total_quantity = $this->cartModel->getCartTotalQuantity($_SESSION['user_id']);
        $cart_total = $this->cartModel->getCartTotal($_SESSION['user_id']);

        echo json_encode([
            'success' => true,
            'item_count' => $total_quantity,
            'total_quantity' => $total_quantity,
            'cart_total' => $cart_total
        ]);
        exit();
    }

    private function checkStock($variant_id) {
        $sql = "SELECT stock FROM product_variants WHERE variant_id = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $variant_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            return $row['stock'];
        }

        return false;
    }
}
?>
