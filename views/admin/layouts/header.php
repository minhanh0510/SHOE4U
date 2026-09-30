<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin - Shoe4U</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="/Shoe4U_1/assets/css/admin.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<header class="admin-header">
    <div class="header-left">
        <div class="admin-logo">
            <div class="logo-mark"><i class="fas fa-shoe-prints"></i></div>
            <div class="logo-text">
                <span class="logo-name">Shoe<em>4U</em></span>
                <span class="logo-badge">Admin</span>
            </div>
        </div>
    </div>
    <div class="header-right">
        <!-- LINK VỀ TRANG CHỦ -->
        <a href="/Shoe4U_1/index.php" class="btn-home" title="Về trang chủ" style="margin-right: 15px; color: rgba(255,255,255,0.7); text-decoration: none; font-size: 13px; transition: 0.2s;">
            <i class="fas fa-home"></i> Về trang chủ
        </a>
        <span style="margin-right: 15px; color: rgba(255,255,255,0.7); font-size: 13px;">
            <i class="fas fa-user-circle"></i> <?= $_SESSION['full_name'] ?? 'Admin' ?>
        </span>
        <a href="<?= ADMIN_URL ?>logout.php" class="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Đăng xuất
        </a>
    </div>
</header>

<div class="admin-container">