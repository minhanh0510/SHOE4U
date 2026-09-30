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

    public function checkout() {
        $this->requireLogin();
        require_once 'models/Cart.php';
        $cart = new Cart($this->conn);
        $cartItems = $cart->getCart($_SESSION['user_id']);

        if (empty($cartItems)) {
            $_SESSION['error'] = "Giỏ hàng của bạn đang trống!";
            header('Location: index.php');
            exit();
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        include 'views/layouts/header.php';
        include 'views/order/checkout.php';
        include 'views/layouts/footer.php';
    }

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
        $cart        = new Cart($this->conn);

        try {
            $this->pdo->beginTransaction();

            $shipping_address = trim($_POST['shipping_address'] ?? '');
            $payment_method   = $_POST['payment_method'] ?? 'COD';
            $user_id          = $_SESSION['user_id'];

            if (!in_array($payment_method, ['COD', 'Momo', 'Bank'])) {
                $payment_method = 'COD';
            }

            if (empty($shipping_address)) {
                throw new Exception("Vui lòng nhập địa chỉ giao hàng!");
            }

            $cartItems = $cart->getCart($user_id);
            if (empty($cartItems)) {
                throw new Exception("Giỏ hàng trống!");
            }

            $total_price = 0;
            foreach ($cartItems as $item) {
                $total_price += $item['price'] * $item['quantity'];
            }

            $order->user_id          = $user_id;
            $order->total_price      = $total_price;
            $order->shipping_address = $shipping_address;
            $order_id = $order->create();

            if (!$order_id) throw new Exception("Không thể tạo đơn hàng!");

            foreach ($cartItems as $item) {
                $orderDetail->create($order_id, $item['variant_id'], $item['quantity'], $item['price']);
            }

            $payment->order_id = $order_id;
            $payment->method   = $payment_method;
            $payment->status   = ($payment_method === 'COD') ? 'Unpaid' : 'Pending';
            $payment_id = $payment->create();
            if (!$payment_id) throw new Exception("Không thể lưu thông tin thanh toán!");

            $cart->clearCart($user_id);

            $this->pdo->commit();

            $_SESSION['success']          = "Đặt hàng thành công!";
            $_SESSION['last_order_id']    = $order_id;
            $_SESSION['payment_method']   = $payment_method;
            $_SESSION['payment_status']   = ($payment_method === 'COD') ? 'Unpaid' : 'Pending';
            $_SESSION['order_total']      = $total_price;

            // Nếu thanh toán trực tuyến qua Momo hoặc VietQR/Bank, chuyển tới trang quét mã QR
            if ($payment_method === 'Momo' || $payment_method === 'Bank') {
                header('Location: index.php?controller=order&action=qrcode&id=' . $order_id);
            } else {
                header('Location: index.php?controller=order&action=success&order_id=' . $order_id);
            }
            exit();

        } catch (Exception $e) {
            $this->pdo->rollBack();
            $_SESSION['error'] = $e->getMessage();
            header('Location: index.php?controller=order&action=checkout');
            exit();
        }
    }

    // Hiển thị mã QR thanh toán trực tuyến (MoMo / VietQR)
    public function qrcode() {
        $this->requireLogin();
        require_once 'models/Order.php';
        $order = new Order($this->pdo);

        $order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $orderInfo = $order->getOrderById($order_id);

        if (!$orderInfo || ($orderInfo['user_id'] != $_SESSION['user_id'] && ($_SESSION['role'] ?? '') != 'admin')) {
            $_SESSION['error'] = "Không tìm thấy thông tin đơn hàng!";
            header('Location: index.php?controller=order&action=history');
            exit();
        }

        $paymentMethod = $orderInfo['payment_method'] ?? 'Bank';
        $amount = (int)$orderInfo['total_price'];
        $orderCode = str_pad($order_id, 6, '0', STR_PAD_LEFT);

        // Cấu hình tài khoản ngân hàng nhận tiền thật (BIDV - NGUYEN MINH ANH)
        $bankId      = 'BIDV';
        $accountNo   = '1351450840';
        $accountName = 'NGUYEN MINH ANH';
        $memo        = 'SHOE4U DH' . $orderCode;

        if ($paymentMethod === 'Momo') {
            // QR MoMo hoặc VietQR tương thích MoMo
            $qrDataUri = "https://img.vietqr.io/image/{$bankId}-{$accountNo}-compact2.png?amount={$amount}&addInfo=" . urlencode($memo) . "&accountName=" . urlencode($accountName);
        } else {
            // VietQR chuẩn ngân hàng BIDV
            $qrDataUri = "https://img.vietqr.io/image/{$bankId}-{$accountNo}-compact2.png?amount={$amount}&addInfo=" . urlencode($memo) . "&accountName=" . urlencode($accountName);
        }

        include 'views/layouts/header.php';
        include 'views/order/qrcode.php';
        include 'views/layouts/footer.php';
    }

    // Xác nhận đã thanh toán trực tuyến
    public function confirm() {
        $this->requireLogin();
        require_once 'models/Order.php';
        require_once 'models/Payment.php';

        $order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $order = new Order($this->pdo);
        $orderInfo = $order->getOrderById($order_id);

        if ($orderInfo && ($orderInfo['user_id'] == $_SESSION['user_id'] || ($_SESSION['role'] ?? '') == 'admin')) {
            $payment = new Payment($this->pdo);
            $payment->updateStatusByOrder($order_id, 'Paid');
            $_SESSION['success'] = "Xác nhận thanh toán đơn hàng #" . str_pad($order_id, 6, '0', STR_PAD_LEFT) . " thành công!";
        }

        header('Location: index.php?controller=order&action=success&order_id=' . $order_id);
        exit();
    }

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

    public function history() {
        $this->requireLogin();
        require_once 'models/Order.php';
        $order  = new Order($this->pdo);
        $orders = $order->getOrdersByUser($_SESSION['user_id']);

        include 'views/layouts/header.php';
        include 'views/order/history.php';
        include 'views/layouts/footer.php';
    }

    public function detail() {
        $this->requireLogin();
        require_once 'models/Order.php';
        $order = new Order($this->pdo);

        $order_id  = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $orderInfo = $order->getOrderById($order_id);

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