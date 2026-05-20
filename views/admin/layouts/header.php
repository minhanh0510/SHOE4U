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
        <img src="/Shoe4U_1/assets/images/logo.png" class="logo" alt="Logo" onerror="this.style.display='none'">
        <span>Shoe4U Admin</span>
    </div>
    <div class="header-right">
        <span style="margin-right: 15px;">Xin chào, <?= $_SESSION['full_name'] ?? 'Admin' ?></span>
        <a href="<?= ADMIN_URL ?>logout.php" class="logout-btn">
    <i class="fas fa-sign-out-alt"></i> Đăng xuất
</a>
    </div>
</header>

<div class="admin-container">