<?php
class OrderController {
    private $conn;
    private $pdo;

    public function __construct($conn) {
        $this->conn = $conn;
        $database = new Database();
        $this->pdo = $database->getConnection();
    }

    private function requireLogin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = "Vui lòng đăng nhập để tiếp tục!";
            header('Location: index.php?controller=auth&action=login');
            exit();
        }
    }

    // Trang thanh toán (GET)
    public function checkout() {
        $this->requireLogin();
        require_once 'models/Cart.php';
        // SỬA: dùng $this->conn (MySQLi) thay vì $this->pdo (PDO)
        $cart = new Cart($this->conn);
        // SỬA: gọi getCart thay vì getCartItems
        $cartItems = $cart->getCart($_SESSION['user_id']);

        if (empty($cartItems)) {
            $_SESSION['error'] = "Giỏ hàng của bạn đang trống!";
            header('Location: index.php');
            exit();
        }

        $total = 0;
        foreach ($cartItems as $item) {
            // SỬA: tính subtotal từ price * quantity (getCart không có subtotal)
            $total += $item['price'] * $item['quantity'];
        }

        include 'views/layouts/header.php';
        include 'views/order/checkout.php';
        include 'views/layouts/footer.php';
    }

    // Xử lý đặt hàng (POST)
    public function placeOrder() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?controller=order&action=checkout');
            exit();
        }

        require_once 'models/Order.php';
        require_once 'models/OrderDetail.php';
        require_once 'models/Payment.php';
        require_once 'models/Cart.php';

        $order       = new Order($this->pdo);
        $orderDetail = new OrderDetail($this->pdo);
        $payment     = new Payment($this->pdo);
        // SỬA: dùng $this->conn cho Cart
        $cart        = new Cart($this->conn);

        try {
            $this->pdo->beginTransaction();

            $shipping_address = trim($_POST['shipping_address'] ?? '');
            $payment_method   = $_POST['payment_method'] ?? 'COD';
            $user_id          = $_SESSION['user_id'];

            if (empty($shipping_address)) {
                throw new Exception("Vui lòng nhập địa chỉ giao hàng!");
            }

            // SỬA: gọi getCart thay vì getCartItems
            $cartItems = $cart->getCart($user_id);
            if (empty($cartItems)) {
                throw new Exception("Giỏ hàng trống!");
            }

            $total_price = 0;
            foreach ($cartItems as $item) {
                // SỬA: tính total_price từ price * quantity
                $total_price += $item['price'] * $item['quantity'];
            }

            // Tạo đơn hàng
            $order->user_id          = $user_id;
            $order->total_price      = $total_price;
            $order->shipping_address = $shipping_address;
            $order_id = $order->create();

            if (!$order_id) throw new Exception("Không thể tạo đơn hàng!");

            // Thêm chi tiết đơn hàng
            foreach ($cartItems as $item) {
                $orderDetail->create($order_id, $item['variant_id'], $item['quantity'], $item['price']);
            }

            // Xử lý thanh toán
            $payment->order_id = $order_id;
            $payment->method   = $payment_method;

            if ($payment_method == 'Momo') {
                $result = $payment->processMomoPayment($order_id, $total_price);
                $payment->status = $result['success'] ? 'Paid' : 'Failed';
            } elseif ($payment_method == 'COD') {
                $payment->status = 'Unpaid';
            } else {
                $payment->status = 'Pending';
            }

            $payment_id = $payment->create();
            if (!$payment_id) throw new Exception("Không thể lưu thông tin thanh toán!");

            // Xóa giỏ hàng
            $cart->clearCart($user_id);

            $this->pdo->commit();

            $_SESSION['success']          = "Đặt hàng thành công!";
            $_SESSION['last_order_id']    = $order_id;
            $_SESSION['payment_method']   = $payment_method;
            $_SESSION['payment_status']   = $payment->status;
            $_SESSION['order_total']      = $total_price;

            header('Location: index.php?controller=order&action=success&order_id=' . $order_id);
            exit();

        } catch (Exception $e) {
            $this->pdo->rollBack();
            $_SESSION['error'] = "Đặt hàng thất bại: " . $e->getMessage();
            header('Location: index.php?controller=order&action=checkout');
            exit();
        }
    }

    // Trang đặt hàng thành công
    public function success() {
        $this->requireLogin();
        require_once 'models/Order.php';
        $order = new Order($this->pdo);

        $order_id   = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
        $orderInfo  = $order_id ? $order->getOrderById($order_id) : null;
        $orderItems = $order_id ? $order->getOrderDetails($order_id) : [];

        include 'views/layouts/header.php';
        include 'views/order/success.php';
        include 'views/layouts/footer.php';
    }

    // Lịch sử đơn hàng
    public function history() {
        $this->requireLogin();
        require_once 'models/Order.php';
        $order  = new Order($this->pdo);
        $orders = $order->getOrdersByUser($_SESSION['user_id']);

        include 'views/layouts/header.php';
        include 'views/order/history.php';
        include 'views/layouts/footer.php';
    }

    // Chi tiết đơn hàng
    public function detail() {
        $this->requireLogin();
        require_once 'models/Order.php';
        $order = new Order($this->pdo);

        $order_id  = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $orderInfo = $order->getOrderById($order_id);

        // Kiểm tra quyền truy cập
        if (!$orderInfo || ($orderInfo['user_id'] != $_SESSION['user_id'] && ($_SESSION['role'] ?? '') != 'admin')) {
            $_SESSION['error'] = "Bạn không có quyền xem đơn hàng này!";
            header('Location: index.php?controller=order&action=history');
            exit();
        }

        $orderItems = $order->getOrderDetails($order_id);

        include 'views/layouts/header.php';
        include 'views/order/detail.php';
        include 'views/layouts/footer.php';
    }
}
?>