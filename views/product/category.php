<style>
.products-wrap{padding:44px 0 72px;}
.product-grid-cat{display:grid;grid-template-columns:repeat(4,1fr);gap:22px;}
.empty-state{text-align:center;padding:100px 20px;background:#fff;border-radius:var(--r-xl);border:1px solid var(--fog);}
.empty-state i{font-size:56px;color:var(--fog);margin-bottom:16px;}
.empty-state h3{font-family:'DM Serif Display',serif;font-size:22px;color:var(--ink);margin-bottom:8px;}
.empty-state p{color:var(--mist);font-size:14px;margin-bottom:24px;}
.filter-chip{display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:20px;background:var(--blue-light);border:1px solid rgba(91,191,234,.25);font-size:12px;font-weight:700;color:var(--blue-mid);margin-bottom:16px;}
@media(max-width:1024px){.product-grid-cat{grid-template-columns:repeat(3,1fr);}}
@media(max-width:768px){.product-grid-cat{grid-template-columns:repeat(2,1fr);}.filter-inner{gap:8px;}}
@media(max-width:480px){.product-grid-cat{grid-template-columns:1fr;}}
</style>

<!-- PAGE BANNER -->
<div class="page-banner">
  <div class="container">
    <h1><i class="fas fa-shoe-prints"></i>Tất cả sản phẩm</h1>
    <div class="breadcrumb">
      <a href="index.php">Trang chủ</a>
      <i class="fas fa-chevron-right"></i>
      <span style="color:rgba(255,255,255,.8);">Sản phẩm</span>
    </div>
  </div>
</div>

<!-- FILTER BAR -->
<div class="filter-bar">
  <div class="container">
    <div class="filter-inner">
      <form method="GET" action="index.php" style="display:contents;">
        <input type="hidden" name="controller" value="product">
        <input type="hidden" name="action" value="category">
        <select name="category" class="filter-select" onchange="this.form.submit()">
          <option value="">Tất cả danh mục</option>
          <?php foreach ($categories as $cat): ?>
          <option value="<?= $cat['category_id'] ?>" <?= (isset($_GET['category']) && $_GET['category']==$cat['category_id'])?'selected':'' ?>>
            <?= htmlspecialchars($cat['category_name']) ?>
          </option>
          <?php endforeach; ?>
        </select>
        <select name="price" class="filter-select" onchange="this.form.submit()">
          <option value="">Tất cả giá</option>
          <option value="under500" <?= (($_GET['price']??'')==='under500')?'selected':'' ?>>Dưới 500k</option>
          <option value="500to1m"  <?= (($_GET['price']??'')==='500to1m') ?'selected':'' ?>>500k – 1 triệu</option>
          <option value="1mto2m"   <?= (($_GET['price']??'')==='1mto2m')  ?'selected':'' ?>>1 – 2 triệu</option>
          <option value="above2m"  <?= (($_GET['price']??'')==='above2m') ?'selected':'' ?>>Trên 2 triệu</option>
        </select>
        <select name="sort" class="filter-select" onchange="this.form.submit()">
          <option value="default"    <?= (($_GET['sort']??'')==='default')   ?'selected':'' ?>>Mới nhất</option>
          <option value="price_asc"  <?= (($_GET['sort']??'')==='price_asc') ?'selected':'' ?>>Giá thấp → cao</option>
          <option value="price_desc" <?= (($_GET['sort']??'')==='price_desc')?'selected':'' ?>>Giá cao → thấp</option>
          <option value="name_asc"   <?= (($_GET['sort']??'')==='name_asc')  ?'selected':'' ?>>Tên A → Z</option>
        </select>
        <div class="filter-search">
          <i class="fas fa-search"></i>
          <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
        </div>
        <button type="submit" class="btn-primary" style="padding:9px 22px;font-size:13px;border-radius:50px;"><i class="fas fa-search"></i> Tìm</button>
      </form>
      <span class="results-count"><i class="fas fa-box" style="color:var(--blue);margin-right:4px;"></i><?= count($products) ?> sản phẩm</span>
    </div>
  </div>
</div>

<!-- PRODUCTS GRID -->
<div class="products-wrap">
  <div class="container">
    <?php if (empty($products)): ?>
    <div class="empty-state">
      <i class="fas fa-box-open"></i>
      <h3>Không tìm thấy sản phẩm</h3>
      <p>Thử tìm kiếm với từ khóa khác hoặc xóa bộ lọc để xem tất cả sản phẩm.</p>
      <a href="index.php?controller=product&action=category" class="btn-primary" style="display:inline-flex;"><i class="fas fa-rotate-left"></i> Xem tất cả</a>
    </div>
    <?php else: ?>
    <div class="product-grid-cat" id="productGrid">
      <?php foreach ($products as $p): ?>
      <div class="product-card">
        <?php if ($p['is_best_seller']): ?>
        <span class="product-badge badge-hot"><i class="fas fa-fire"></i> Hot</span>
        <?php else: ?>
        <span class="product-badge badge-new">✦ Mới</span>
        <?php endif; ?>
        <div class="product-actions">
          <a href="index.php?controller=product&action=detail&id=<?= $p['product_id'] ?>" class="action-btn" title="Xem chi tiết"><i class="fas fa-eye"></i></a>
          <button class="action-btn" onclick="addToCart(<?= $p['product_id'] ?>,event)" title="Thêm yêu thích"><i class="fas fa-heart"></i></button>
        </div>
        <a href="index.php?controller=product&action=detail&id=<?= $p['product_id'] ?>">
          <div class="product-image-wrap">
            <img src="assets/images/products/<?= $p['image_url'] ?>" alt="<?= htmlspecialchars($p['product_name']) ?>" onerror="this.src='assets/images/banner1.jpg'" loading="lazy">
          </div>
        </a>
        <div class="product-info">
          <div class="product-brand"><?= htmlspecialchars($p['brand'] ?? $p['category_name'] ?? 'Shoe4U') ?></div>
          <div class="product-name"><?= htmlspecialchars($p['product_name']) ?></div>
          <div class="product-rating"><span class="stars">★★★★★</span><span class="rating-num">(<?= rand(42,198) ?>)</span></div>
          <div class="product-price-row">
            <span class="price-main"><?= number_format($p['price']) ?>đ</span>
          </div>
          <button class="btn-add-cart" onclick="addToCart(<?= $p['product_id'] ?>,event)"><i class="fas fa-cart-plus"></i> Thêm vào giỏ</button>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</div>

<script>
function addToCart(productId,event){
  <?php if (isset($_SESSION['user_id'])): ?>
  const btn=event.currentTarget;const orig=btn.innerHTML;
  btn.innerHTML='<i class="fas fa-spinner fa-spin"></i>';btn.disabled=true;
  fetch('index.php?controller=cart&action=add',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:`variant_id=1&quantity=1`})
  .then(r=>r.json()).then(d=>{
    btn.innerHTML='<i class="fas fa-check"></i> Đã thêm!';
    btn.style.background='var(--success)';btn.style.color='#fff';btn.style.borderColor='transparent';
    const c=document.getElementById('cart-count');if(c)c.textContent=d.cart_count||0;
    setTimeout(()=>{btn.innerHTML=orig;btn.style.cssText='';btn.disabled=false;},2000);
  }).catch(()=>{btn.innerHTML=orig;btn.disabled=false;});
  <?php else: ?>
  if(confirm('Bạn cần đăng nhập để thêm vào giỏ hàng. Đăng nhập ngay?'))window.location='index.php?controller=auth&action=login';
  <?php endif; ?>
}
</script>
