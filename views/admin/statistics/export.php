<?php
require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';

$type = isset($_GET['type']) ? $_GET['type'] : 'revenue';

// Xuất Excel
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="thong-ke-'.date('Y-m-d').'.xls"');

if($type == 'revenue') {
    $view = isset($_GET['view']) ? $_GET['view'] : 'month';
    $month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
    $year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');
    
    if($view == 'day') {
        $sql = "SELECT 
                    DATE(o.created_at) as date,
                    COUNT(DISTINCT o.order_id) as orders,
                    COALESCE(SUM(od.quantity), 0) as total_products,
                    COALESCE(SUM(od.price * od.quantity), SUM(o.total_price)) as revenue
                FROM orders o
                LEFT JOIN order_details od ON o.order_id = od.order_id
                WHERE o.status = 'Completed' 
                    AND MONTH(o.created_at) = $month 
                    AND YEAR(o.created_at) = $year
                GROUP BY DATE(o.created_at)
                ORDER BY date";
    } elseif($view == 'quarter') {
        $sql = "SELECT 
                    QUARTER(o.created_at) as quarter,
                    COUNT(DISTINCT o.order_id) as orders,
                    COALESCE(SUM(od.quantity), 0) as total_products,
                    COALESCE(SUM(od.price * od.quantity), SUM(o.total_price)) as revenue
                FROM orders o
                LEFT JOIN order_details od ON o.order_id = od.order_id
                WHERE o.status = 'Completed' 
                    AND YEAR(o.created_at) = $year
                GROUP BY QUARTER(o.created_at)
                ORDER BY quarter";
    } elseif($view == 'year') {
        $sql = "SELECT 
                    YEAR(o.created_at) as year,
                    COUNT(DISTINCT o.order_id) as orders,
                    COALESCE(SUM(od.quantity), 0) as total_products,
                    COALESCE(SUM(od.price * od.quantity), SUM(o.total_price)) as revenue
                FROM orders o
                LEFT JOIN order_details od ON o.order_id = od.order_id
                WHERE o.status = 'Completed'
                GROUP BY YEAR(o.created_at)
                ORDER BY year DESC";
    } else {
        $sql = "SELECT 
                    MONTH(o.created_at) as month,
                    COUNT(DISTINCT o.order_id) as orders,
                    COALESCE(SUM(od.quantity), 0) as total_products,
                    COALESCE(SUM(od.price * od.quantity), SUM(o.total_price)) as revenue
                FROM orders o
                LEFT JOIN order_details od ON o.order_id = od.order_id
                WHERE o.status = 'Completed' 
                    AND YEAR(o.created_at) = $year
                GROUP BY MONTH(o.created_at)
                ORDER BY month";
    }
    
    $result = mysqli_query($conn, $sql);
    
    echo "THỐNG KÊ DOANH THU & SỐ LƯỢNG SẢN PHẨM\n";
    if($view == 'day') echo "Tháng $month/$year\n";
    if($view == 'month') echo "Năm $year\n";
    if($view == 'quarter') echo "Năm $year (Theo Quý)\n";
    if($view == 'year') echo "Tất cả các năm\n";
    echo "====================\n\n";
    echo "Thời gian\tSố đơn\tSố lượng sản phẩm\tDoanh thu (VNĐ)\n";
    
    while($row = mysqli_fetch_assoc($result)) {
        if($view == 'day') $time = date('d/m/Y', strtotime($row['date']));
        elseif($view == 'quarter') $time = 'Quý '.$row['quarter'];
        elseif($view == 'year') $time = 'Năm '.$row['year'];
        else $time = 'Tháng '.$row['month'];
        
        echo $time."\t".$row['orders']."\t".$row['total_products']."\t".$row['revenue']."\n";
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