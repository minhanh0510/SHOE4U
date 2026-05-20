<?php
require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';

$type = isset($_GET['type']) ? $_GET['type'] : 'revenue';

// Xuất Excel
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="thong-ke-'.date('Y-m-d').'.xls"');

if($type == 'revenue') {
    $view = isset($_GET['view']) ? $_GET['view'] : 'month';
    $month = isset($_GET['month']) ? $_GET['month'] : date('m');
    $year = isset($_GET['year']) ? $_GET['year'] : date('Y');
    
    if($view == 'day') {
        $sql = "SELECT 
                    DATE(created_at) as date,
                    COUNT(*) as orders,
                    SUM(total_price) as revenue
                FROM orders 
                WHERE status = 'Completed' 
                    AND MONTH(created_at) = $month 
                    AND YEAR(created_at) = $year
                GROUP BY DATE(created_at)
                ORDER BY date";
    }
    
    if($view == 'month') {
        $sql = "SELECT 
                    MONTH(created_at) as month,
                    COUNT(*) as orders,
                    SUM(total_price) as revenue
                FROM orders 
                WHERE status = 'Completed' 
                    AND YEAR(created_at) = $year
                GROUP BY MONTH(created_at)
                ORDER BY month";
    }
    
    $result = mysqli_query($conn, $sql);
    
    echo "THỐNG KÊ DOANH THU\n";
    if($view == 'day') echo "Tháng $month/$year\n";
    if($view == 'month') echo "Năm $year\n";
    echo "====================\n\n";
    echo "Thời gian\tSố đơn\tDoanh thu\n";
    
    while($row = mysqli_fetch_assoc($result)) {
        if($view == 'day') $time = date('d/m/Y', strtotime($row['date']));
        if($view == 'month') $time = 'Tháng '.$row['month'];
        
        echo $time."\t".$row['orders']."\t".$row['revenue']."\n";
    }
}

if($type == 'bestsellers') {
    $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : date('Y-m-01');
    $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : date('Y-m-d');
    
    $sql = "SELECT 
                p.product_name,
                p.brand,
                c.category_name,
                SUM(od.quantity) as total_quantity,
                SUM(od.price * od.quantity) as total_revenue
            FROM order_details od
            JOIN product_variants pv ON od.variant_id = pv.variant_id
            JOIN products p ON pv.product_id = p.product_id
            JOIN categories c ON p.category_id = c.category_id
            JOIN orders o ON od.order_id = o.order_id
            WHERE o.status = 'Completed'
                AND DATE(o.created_at) BETWEEN '$from_date' AND '$to_date'
            GROUP BY p.product_id
            ORDER BY total_quantity DESC";
    
    $result = mysqli_query($conn, $sql);
    
    echo "THỐNG KÊ SẢN PHẨM BÁN CHẠY\n";
    echo "Từ ngày: $from_date - Đến ngày: $to_date\n";
    echo "================================\n\n";
    echo "Sản phẩm\tThương hiệu\tDanh mục\tSố lượng\tDoanh thu\n";
    
    while($row = mysqli_fetch_assoc($result)) {
        echo $row['product_name']."\t";
        echo $row['brand']."\t";
        echo $row['category_name']."\t";
        echo $row['total_quantity']."\t";
        echo $row['total_revenue']."\n";
    }
}
?>