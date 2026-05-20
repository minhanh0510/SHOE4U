<?php
$current_page = basename($_SERVER['PHP_SELF']);
$current_folder = basename(dirname($_SERVER['PHP_SELF']));
?>

<div class="sidebar">
    <ul class="sidebar-menu">
        <li class="<?= ($current_page == 'index.php' && $current_folder == 'admin') ? 'active' : '' ?>">
            <a href="<?= ADMIN_URL ?>index.php">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        
        <li class="<?= $current_folder == 'products' ? 'active' : '' ?>">
            <a href="<?= ADMIN_URL ?>products/index.php">
                <i class="fas fa-shoe-prints"></i> Sản phẩm
            </a>
        </li>
        
        <li class="<?= $current_folder == 'categories' ? 'active' : '' ?>">
            <a href="<?= ADMIN_URL ?>categories/index.php">
                <i class="fas fa-list"></i> Danh mục
            </a>
        </li>
        
        <li class="<?= $current_folder == 'orders' ? 'active' : '' ?>">
            <a href="<?= ADMIN_URL ?>orders/index.php">
                <i class="fas fa-shopping-cart"></i> Đơn hàng
            </a>
        </li>
        
        <li class="<?= $current_folder == 'users' ? 'active' : '' ?>">
            <a href="<?= ADMIN_URL ?>users/index.php">
                <i class="fas fa-users"></i> Người dùng
            </a>
        </li>
        
        <li class="<?= $current_folder == 'posts' ? 'active' : '' ?>">
            <a href="<?= ADMIN_URL ?>posts/index.php">
                <i class="fas fa-newspaper"></i> Bài viết
            </a>
        </li>
        
        <li class="<?= $current_folder == 'statistics' ? 'active' : '' ?>">
            <a href="<?= ADMIN_URL ?>statistics/index.php">
                <i class="fas fa-chart-bar"></i> Thống kê
            </a>
        </li>
    </ul>
</div>

<div class="main-content">