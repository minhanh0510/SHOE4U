<?php
require_once '../layouts/auth_check.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    
    mysqli_query($conn, "UPDATE orders SET status = '$status' WHERE order_id = $order_id");
    
    // Nếu đơn hàng hoàn thành, cập nhật thanh toán nếu là COD
    if ($status == 'Completed') {
        mysqli_query($conn, "UPDATE payments SET status = 'Paid', paid_at = NOW() 
                             WHERE order_id = $order_id AND method = 'COD'");
    }
    
    $_SESSION['success'] = 'Cập nhật trạng thái thành công';
}

header("Location: detail.php?id=$order_id");
exit();
?>