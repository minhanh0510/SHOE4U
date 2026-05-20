<?php
$current_category = $_GET['category'] ?? '';
$current_price = $_GET['price'] ?? '';

$categories_sidebar = [];
if (isset($conn)) {
    $res = mysqli_query($conn, "SELECT category_id, category_name FROM categories ORDER BY category_name");
    if ($res) while ($row = mysqli_fetch_assoc($res)) $categories_sidebar[] = $row;
}
?>
<div class="sidebar-widget">
  <div class="widget-title"><i class="fas fa-grid-2"></i> Danh mục</div>
  <ul class="category-list">
    <li>
      <a href="index.php?controller=product&action=category" class="<?= empty($current_category) ? 'active' : '' ?>">
        <i class="fas fa-circle-dot"></i> Tất cả sản phẩm
      </a>
    </li>
    <?php foreach ($categories_sidebar as $cat): ?>
    <li>
      <a href="index.php?controller=product&action=category&category=<?= $cat['category_id'] ?>"
         class="<?= $current_category == $cat['category_id'] ? 'active' : '' ?>">
        <i class="fas fa-angle-right"></i> <?= htmlspecialchars($cat['category_name']) ?>
      </a>
    </li>
    <?php endforeach; ?>
  </ul>
</div>

<div class="sidebar-widget">
  <div class="widget-title"><i class="fas fa-tag"></i> Khoảng giá</div>
  <ul class="price-filter">
    <li><a href="?controller=product&action=category<?= $current_category ? '&category='.$current_category : '' ?>" class="<?= empty($current_price)?'active':'' ?>"><i class="fas fa-angle-right"></i> Tất cả mức giá</a></li>
    <li><a href="?controller=product&action=category&price=under500<?= $current_category ? '&category='.$current_category : '' ?>" class="<?= $current_price==='under500'?'active':'' ?>"><i class="fas fa-angle-right"></i> Dưới 500.000đ</a></li>
    <li><a href="?controller=product&action=category&price=500to1m<?= $current_category ? '&category='.$current_category : '' ?>" class="<?= $current_price==='500to1m'?'active':'' ?>"><i class="fas fa-angle-right"></i> 500k – 1.000.000đ</a></li>
    <li><a href="?controller=product&action=category&price=1mto2m<?= $current_category ? '&category='.$current_category : '' ?>" class="<?= $current_price==='1mto2m'?'active':'' ?>"><i class="fas fa-angle-right"></i> 1 – 2.000.000đ</a></li>
    <li><a href="?controller=product&action=category&price=above2m<?= $current_category ? '&category='.$current_category : '' ?>" class="<?= $current_price==='above2m'?'active':'' ?>"><i class="fas fa-angle-right"></i> Trên 2.000.000đ</a></li>
  </ul>
</div>

<div class="sidebar-widget" style="background:linear-gradient(135deg,var(--blue-pale),#EBF6FD);border-color:rgba(91,191,234,.25);">
  <div class="widget-title" style="border-bottom-color:rgba(91,191,234,.3);"><i class="fas fa-headset"></i> Hỗ trợ</div>
  <p style="font-size:13px;color:var(--steel);line-height:1.7;margin-bottom:14px;">Cần tư vấn về size hoặc sản phẩm?</p>
  <a href="tel:19001234" class="btn-primary" style="width:100%;justify-content:center;padding:11px;font-size:13px;border-radius:var(--r-lg);display:flex;">
    <i class="fas fa-phone-alt"></i> 1900 1234
  </a>
</div>
