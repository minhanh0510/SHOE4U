<?php

// Tránh khai báo lại function
if (!function_exists('base_url')) {
    function base_url($path = '') {
        // Bỏ dấu / ở đầu để dùng đường dẫn tương đối
        return $path;
    }
}

if (!function_exists('asset')) {
    function asset($path) {
        return '../../assets/' . $path;
    }
}

// Format tiền tệ
if (!function_exists('formatMoney')) {
    function formatMoney($amount) {
        return number_format($amount, 0, ',', '.') . '₫';
    }
}

// Format ngày tháng
if (!function_exists('formatDate')) {
    function formatDate($date) {
        return date('d/m/Y H:i', strtotime($date));
    }
}

// Trạng thái đơn hàng
if (!function_exists('getOrderStatusBadge')) {
    function getOrderStatusBadge($status) {
        $colors = [
            'Pending' => 'warning',
            'Shipping' => 'info',
            'Completed' => 'success',
            'Cancelled' => 'danger'
        ];
        $labels = [
            'Pending' => 'Chờ xử lý',
            'Shipping' => 'Đang giao',
            'Completed' => 'Hoàn thành',
            'Cancelled' => 'Đã hủy'
        ];
        $color = $colors[$status] ?? 'secondary';
        $label = $labels[$status] ?? $status;
        return "<span class='badge badge-$color'>$label</span>";
    }
}

?>