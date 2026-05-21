<?php
if (!isset($conn)) { global $conn; if (!$conn) require_once 'config/database.php'; }
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shoe4U — Giày Dép Cao Cấp Chính Hãng</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,700;0,800;1,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php if (isset($_SESSION['success'])): ?>
<div class="alert-flash alert-success" id="flash-msg"><i class="fas fa-check-circle"></i> <?= htmlspecialchars($_SESSION['success']) ?></div>
<?php unset($_SESSION['success']); ?>
<?php elseif (isset($_SESSION['error'])): ?>
<div class="alert-flash alert-error" id="flash-msg"><i class="fas fa-exclamation-circle"></i> <?= $_SESSION['error'] ?></div>
<?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- TOPBAR -->
<div class="topbar">
  <div class="container">
    <div class="topbar-inner">
      <div class="topbar-left">
        <span><i class="fas fa-truck-fast"></i> Miễn phí ship từ 500k</span>
        <span><i class="fas fa-shield-halved"></i> Bảo hành 12 tháng</span>
        <span><i class="fas fa-phone-alt"></i> 1900 1234</span>
      </div>
      <div class="topbar-right">
        <a href="index.php?controller=order&action=history"><i class="fas fa-box-open"></i> Theo dõi đơn hàng</a>
        <a href="index.php?controller=post&action=index"><i class="fas fa-newspaper"></i> Bài viết</a>
        <a href="index.php?controller=about"><i class="fas fa-store"></i> Về chúng tôi</a>
    </div>
    </div>
  </div>
</div>

<header>
  <div class="container">
    <div class="header-wrapper">
      <!-- LOGO -->
      <div class="logo">
        <a href="index.php">
          <div class="logo-mark"><i class="fas fa-shoe-prints"></i></div>
          <div class="logo-text">
            <span class="logo-name">Shoe<em>4U</em></span>
            <span class="logo-tagline">Premium Footwear</span>
          </div>
        </a>
      </div>

      <!-- SEARCH -->
      <div class="header-search">
        <form method="GET" action="index.php" style="display:contents;">
          <input type="hidden" name="controller" value="product">
          <input type="hidden" name="action" value="category">
          <input type="text" name="search" placeholder="Tìm kiếm giày, thương hiệu..." autocomplete="off">
          <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
        </form>
      </div>

      <!-- NAV -->
      <nav class="main-menu">
        <ul>
          <li><a href="index.php"><i class="fas fa-house"></i> Trang chủ</a></li>
          <li><a href="index.php?controller=product&action=category"><i class="fas fa-grid-2"></i> Sản phẩm</a></li>
          <li>
            <a href="index.php?controller=cart" class="cart-nav-link">
              <i class="fas fa-shopping-bag"></i>
              Giỏ hàng
              <span id="cart-count" class="cart-count">0</span>
            </a>
          </li>
          <?php if (isset($_SESSION['user_id'])): ?>
          <li class="user-menu">
            <a class="user-badge">
              <div class="user-avatar"><i class="fas fa-user"></i></div>
              <?= htmlspecialchars(explode(' ', $_SESSION['full_name'] ?? 'Tài khoản')[0]) ?>
              <i class="fas fa-chevron-down chevron"></i>
            </a>
            <div class="dropdown">
              <div class="dropdown-header">Tài khoản của bạn</div>
              <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
              <a href="index.php?controller=admin"><i class="fas fa-crown"></i> Quản trị viên</a>
              <div class="divider"></div>
              <?php endif; ?>
              <a href="index.php?controller=order&action=history"><i class="fas fa-box-open"></i> Đơn hàng của tôi</a>
              <div class="divider"></div>
              <a href="index.php?controller=auth&action=logout" class="logout-link"><i class="fas fa-right-from-bracket"></i> Đăng xuất</a>
            </div>
          </li>
          <?php else: ?>
          <li><a href="index.php?controller=auth&action=login" class="nav-btn-login">Đăng nhập</a></li>
          <li><a href="index.php?controller=auth&action=register" class="nav-btn-register"><i class="fas fa-user-plus"></i> Đăng ký</a></li>
          <?php endif; ?>
        </ul>
      </nav>
      <button class="menu-toggle" onclick="openMobileMenu()"><i class="fas fa-bars"></i></button>
    </div>
  </div>
</header>

<!-- MOBILE MENU -->
<div class="mobile-menu-overlay" id="mobileOverlay" onclick="closeMobileMenu()"></div>
<style>
.mobile-menu-overlay{display:none;position:fixed;inset:0;z-index:1100;background:rgba(10,22,40,.6);backdrop-filter:blur(4px);}
.mobile-menu-overlay.open{display:block;}
.mobile-menu-panel{position:fixed;top:0;left:0;bottom:0;width:300px;background:#fff;z-index:1101;transform:translateX(-100%);transition:transform .3s cubic-bezier(.4,0,.2,1);display:flex;flex-direction:column;overflow-y:auto;}
.mobile-menu-panel.open{transform:translateX(0);}
.mobile-menu-header{padding:20px;border-bottom:1px solid var(--fog);display:flex;align-items:center;justify-content:space-between;}
.mobile-menu-logo{display:flex;align-items:center;gap:10px;font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;}
.mobile-menu-logo em{color:var(--blue-mid);font-style:normal;}
.mobile-logo-mark{width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,var(--blue),var(--blue-mid));display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;}
.mobile-close{background:none;border:none;font-size:18px;color:var(--steel);cursor:pointer;width:34px;height:34px;display:flex;align-items:center;justify-content:center;border-radius:8px;transition:all .2s;}
.mobile-close:hover{background:var(--blue-pale);color:var(--blue-mid);}
.mobile-menu-nav{padding:16px 12px;flex:1;}
.mobile-menu-nav a{display:flex;align-items:center;gap:12px;padding:13px 16px;border-radius:var(--r-lg);font-size:14px;font-weight:600;color:var(--steel);transition:var(--t);margin-bottom:4px;}
.mobile-menu-nav a:hover{color:var(--blue-mid);background:var(--blue-pale);}
.mobile-menu-nav a i{width:18px;text-align:center;color:var(--blue);}
.mobile-menu-divider{height:1px;background:var(--fog);margin:12px 0;}
/* ===== DROPDOWN NGƯỜI DÙNG - CẢI TIẾN ===== */
.user-menu {
    position: relative;
    /* Xóa mọi margin/padding gây cách */
    margin: 0;
    padding: 0;
}
.user-badge {
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border-radius: 30px;
    transition: background 0.2s;
    /* Đảm bảo không có margin-bottom */
    margin-bottom: 0;
}
.user-badge:hover {
    background: #f0f2f5;
}
/* Dropdown gắn sát vào nút */
.dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 0;            /* KHÔNG CÓ KHOẢNG CÁCH */
    background: white;
    min-width: 220px;
    border-radius: 12px;
    box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.02);
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.2s ease, visibility 0.2s;
    z-index: 1000;
    border: 1px solid #eef2f6;
}
/* Hiển thị khi hover vào .user-menu */
.user-menu:hover .dropdown {
    opacity: 1;
    visibility: visible;
}
/* TẠO CẦU NỐI VÔ HÌNH ĐỂ KHÔNG BỊ MẤT HOVER */
.user-menu::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    height: 12px;
    background: transparent;
    z-index: 999;
}
/* Khi dropdown hiện, cầu nối giữ hover */
.user-menu:hover::after {
    display: block;
}
/* Style các item trong dropdown */
.dropdown-header {
    padding: 12px 16px;
    font-weight: 600;
    border-bottom: 1px solid #eef2f6;
    color: #1e293b;
}
.dropdown a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 16px;
    color: #334155;
    transition: background 0.2s;
    text-decoration: none;
}
.dropdown a:hover {
    background: #f8fafc;
}
.divider {
    height: 1px;
    background: #eef2f6;
    margin: 6px 0;
}
.logout-link {
    color: #dc2626 !important;
}
.logout-link i {
    color: #dc2626;
}
</style>
<div class="mobile-menu-panel" id="mobilePanel">
  <div class="mobile-menu-header">
    <div class="mobile-menu-logo">
      <div class="mobile-logo-mark"><i class="fas fa-shoe-prints"></i></div>
      Shoe<em>4U</em>
    </div>
    <button class="mobile-close" onclick="closeMobileMenu()"><i class="fas fa-xmark"></i></button>
  </div>
  <div class="mobile-menu-nav">
    <a href="index.php"><i class="fas fa-house"></i> Trang chủ</a>
    <a href="index.php?controller=product&action=category"><i class="fas fa-grid-2"></i> Tất cả sản phẩm</a>
    <a href="index.php?controller=cart"><i class="fas fa-shopping-bag"></i> Giỏ hàng</a>
    <a href="index.php?controller=about"><i class="fas fa-store"></i> Về chúng tôi</a>
    <div class="mobile-menu-divider"></div>
    <?php if (isset($_SESSION['user_id'])): ?>
    <a href="index.php?controller=order&action=history"><i class="fas fa-box-open"></i> Đơn hàng của tôi</a>
    <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
    <a href="index.php?controller=admin"><i class="fas fa-crown"></i> Quản trị viên</a>
    <?php endif; ?>
    <a href="index.php?controller=auth&action=logout" style="color:var(--danger)"><i class="fas fa-right-from-bracket" style="color:var(--danger)"></i> Đăng xuất</a>
    <?php else: ?>
    <a href="index.php?controller=auth&action=login"><i class="fas fa-right-to-bracket"></i> Đăng nhập</a>
    <a href="index.php?controller=auth&action=register" style="color:var(--blue-mid)"><i class="fas fa-user-plus"></i> Đăng ký ngay</a>
    <?php endif; ?>
  </div>
</div>

<?php $show_sidebar = isset($show_sidebar) ? $show_sidebar : false; ?>
<main class="<?= $show_sidebar ? 'main-with-sidebar' : 'main-full' ?>">
<?php if ($show_sidebar): ?>
<div class="container main-container">
  <aside class="sidebar"><?php include 'views/layouts/sidebar.php'; ?></aside>
  <div class="main-content">
<?php endif; ?>

<script>
// Flash
setTimeout(()=>{const m=document.getElementById('flash-msg');if(m){m.style.transition='opacity .4s';m.style.opacity='0';setTimeout(()=>m.remove(),400);}},3800);
// Cart count
// Cart count - FIX: đọc đúng key từ server
fetch('index.php?controller=cart&action=count')
    .then(r => r.json())
    .then(d => {
        const el = document.getElementById('cart-count');
        if (el) {
            // Server trả về total_quantity hoặc item_count
            const count = d.total_quantity || d.item_count || d.count || 0;
            el.textContent = count;
        }
    })
    .catch(() => {});// Mobile menu
function openMobileMenu(){document.getElementById('mobileOverlay').classList.add('open');document.getElementById('mobilePanel').classList.add('open');document.body.style.overflow='hidden';}
function closeMobileMenu(){document.getElementById('mobileOverlay').classList.remove('open');document.getElementById('mobilePanel').classList.remove('open');document.body.style.overflow='';}
</script>
