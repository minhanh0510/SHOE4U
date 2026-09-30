<style>
.cart-page{padding:44px 0 80px;}
.page-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:32px;flex-wrap:wrap;gap:14px;}
.page-head h2{font-family:'DM Serif Display',serif;font-size:30px;color:var(--ink);display:flex;align-items:center;gap:12px;}
.page-head h2 i{color:var(--blue);}
.cart-grid{display:grid;grid-template-columns:1fr 360px;gap:26px;align-items:start;}
.cart-card{background:#fff;border:1px solid var(--fog);border-radius:var(--r-xl);overflow:hidden;box-shadow:var(--shadow-xs);}
.cart-card-head{
  padding:18px 24px;border-bottom:1px solid var(--frost);
  display:flex;align-items:center;justify-content:space-between;
  background:linear-gradient(135deg,var(--blue-pale),#EDF8FD);
}
.cart-card-head h3{font-size:13.5px;font-weight:700;color:var(--ink);display:flex;align-items:center;gap:8px;}
.cart-card-head h3 i{color:var(--blue);}
.cart-card-head span{font-size:12px;color:var(--mist);font-weight:600;background:var(--blue-pale);padding:4px 12px;border-radius:20px;border:1px solid rgba(91,191,234,.2);}
.cart-item{display:flex;align-items:center;gap:18px;padding:20px 24px;border-bottom:1px solid var(--frost);transition:background .15s;}
.cart-item:last-child{border-bottom:none;}
.cart-item:hover{background:var(--blue-pale);}
.ci-img{width:80px;height:80px;border-radius:14px;overflow:hidden;background:var(--blue-pale);flex-shrink:0;border:1px solid var(--fog);}
.ci-img img{width:100%;height:100%;object-fit:cover;}
.ci-info{flex:1;}
.ci-name{font-size:14.5px;font-weight:700;color:var(--ink);margin-bottom:4px;}
.ci-meta{font-size:12px;color:var(--mist);font-weight:500;}
.qty-ctrl{display:flex;align-items:center;gap:8px;margin-top:10px;}
.qty-btn{
  width:30px;height:30px;border-radius:8px;border:1.5px solid var(--fog);
  background:#fff;color:var(--steel);font-size:12px;
  display:flex;align-items:center;justify-content:center;cursor:pointer;transition:var(--t);
}
.qty-btn:hover{border-color:var(--blue);color:var(--blue-mid);background:var(--blue-pale);}
.qty-num{font-size:14px;font-weight:700;color:var(--ink);min-width:24px;text-align:center;}
.ci-price-wrap{display:flex;flex-direction:column;align-items:flex-end;gap:10px;flex-shrink:0;}
.ci-price{font-size:17px;font-weight:800;color:var(--blue-mid);}
.ci-del{
  width:34px;height:34px;border-radius:9px;
  border:1.5px solid #FEE2E2;background:#FEF2F2;
  color:var(--danger);font-size:13px;
  display:flex;align-items:center;justify-content:center;cursor:pointer;transition:var(--t);
}
.ci-del:hover{background:var(--danger);color:#fff;border-color:var(--danger);}
.summary-card{background:#fff;border:1px solid var(--fog);border-radius:var(--r-xl);padding:26px;box-shadow:var(--shadow-xs);position:sticky;top:94px;}
.summary-card h3{font-size:15px;font-weight:700;color:var(--ink);margin-bottom:22px;padding-bottom:16px;border-bottom:1px solid var(--fog);display:flex;align-items:center;gap:8px;}
.summary-card h3 i{color:var(--blue);}
.sum-row{display:flex;justify-content:space-between;align-items:center;font-size:13.5px;padding:8px 0;}
.sum-row .sl{color:var(--steel);}
.sum-row .sv{font-weight:700;color:var(--ink);}
.sum-divider{height:1px;background:var(--fog);margin:10px 0;}
.sum-total{display:flex;justify-content:space-between;align-items:center;padding:14px 0 0;}
.sum-total .sl{font-size:14px;font-weight:700;color:var(--ink);}
.sum-total .sv{font-family:'DM Serif Display',serif;font-size:28px;color:var(--blue-mid);}
.promo-box{
  display:flex;align-items:center;gap:10px;
  background:rgba(91,191,234,.08);border:1.5px dashed rgba(91,191,234,.4);
  border-radius:var(--r-lg);padding:12px 16px;margin:16px 0;
  font-size:13px;color:var(--blue-mid);font-weight:600;
}
.empty-cart{text-align:center;padding:88px 24px;}
.empty-cart i{font-size:60px;color:var(--fog);margin-bottom:18px;display:block;}
.empty-cart h3{font-family:'DM Serif Display',serif;font-size:24px;color:var(--ink);margin-bottom:8px;}
.empty-cart p{color:var(--mist);font-size:14.5px;margin-bottom:28px;}
@media(max-width:768px){.cart-grid{grid-template-columns:1fr;}}
</style>

<div class="cart-page">
  <div class="container">
    <div class="page-head">
      <h2><i class="fas fa-shopping-bag"></i> Giỏ hàng của bạn</h2>
      <a href="index.php?controller=product&action=category" class="btn-ghost"><i class="fas fa-arrow-left"></i> Tiếp tục mua sắm</a>
    </div>

    <?php if (!isset($_SESSION['user_id'])): ?>
    <div class="cart-card">
      <div class="empty-cart">
        <i class="fas fa-lock"></i>
        <h3>Vui lòng đăng nhập để xem giỏ hàng</h3>
        <p>Đăng nhập để quản lý giỏ hàng và tiếp tục mua sắm</p>
        <div style="display:flex;gap:12px;justify-content:center;">
          <a href="index.php?controller=auth&action=login" class="btn-primary" style="display:inline-flex;">Đăng nhập</a>
          <a href="index.php?controller=auth&action=register" class="btn-outline" style="display:inline-flex;">Đăng ký</a>
        </div>
      </div>
    </div>

    <?php elseif (empty($cart_items)): ?>
    <div class="cart-card">
      <div class="empty-cart">
        <i class="fas fa-shopping-bag"></i>
        <h3>Giỏ hàng của bạn đang trống</h3>
        <p>Hãy khám phá và thêm những đôi giày yêu thích của bạn vào đây!</p>
        <a href="index.php?controller=product&action=category" class="btn-primary" style="display:inline-flex;">
          <i class="fas fa-shoe-prints"></i> Khám phá sản phẩm
        </a>
      </div>
    </div>

    <?php else: ?>
    <div class="cart-grid">
      <div>
        <div class="cart-card">
          <div class="cart-card-head">
            <h3><i class="fas fa-list-check"></i> Sản phẩm đã chọn</h3>
            <span><?= count($cart_items) ?> sản phẩm</span>
          </div>
          <?php foreach ($cart_items as $item): ?>
<div class="cart-item" data-variant-id="<?= $item['variant_id'] ?>">
    <div class="ci-img">
        <?php if (!empty($item['image_url'])): ?>
        <img src="assets/images/products/<?= htmlspecialchars($item['image_url']) ?>" alt="">
        <?php else: ?>
        <div style="display:flex;align-items:center;justify-content:center;height:100%;">
            <i class="fas fa-shoe-prints" style="color:var(--mist);font-size:22px;"></i>
        </div>
        <?php endif; ?>
    </div>
    <div class="ci-info">
        <div class="ci-name"><?= htmlspecialchars($item['product_name']) ?></div>
        <div class="ci-meta">Size <?= $item['size'] ?> &middot; <?= htmlspecialchars($item['color']) ?></div>
        <div class="qty-ctrl">
            <button class="qty-btn" onclick="updateQuantity(<?= $item['variant_id'] ?>, <?= $item['quantity'] - 1 ?>)">
                <i class="fas fa-minus"></i>
            </button>
            <span class="qty-num"><?= $item['quantity'] ?></span>
            <button class="qty-btn" onclick="updateQuantity(<?= $item['variant_id'] ?>, <?= $item['quantity'] + 1 ?>)">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="ci-price-wrap">
        <span class="ci-price"><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ</span>
        <button class="ci-del" onclick="removeItem(<?= $item['variant_id'] ?>)" title="Xóa sản phẩm">
            <i class="fas fa-trash-can"></i>
        </button>
    </div>
</div>
<?php endforeach; ?>
        </div>
      </div>

      <div>
        <div class="summary-card">
          <h3><i class="fas fa-receipt"></i> Tóm tắt đơn hàng</h3>
          <?php $subtotal = array_sum(array_map(function($item) { return $item['price'] * $item['quantity']; }, $cart_items)); ?>
          <div class="sum-row"><span class="sl">Tạm tính (<?= count($cart_items) ?> SP)</span><span class="sv"><?= number_format($subtotal, 0, ',', '.') ?>đ</span></div>
          <div class="sum-row"><span class="sl">Phí vận chuyển</span><span class="sv" style="color:var(--success);font-weight:800;"><i class="fas fa-truck-fast" style="margin-right:4px;"></i>Miễn phí</span></div>
          <div class="promo-box"><i class="fas fa-tag"></i> Miễn phí vận chuyển — Đơn từ 500.000đ!</div>
          <div class="sum-divider"></div>
          <div class="sum-total">
            <span class="sl">Tổng cộng</span>
            <span class="sv"><?= number_format($subtotal, 0, ',', '.') ?>đ</span>
          </div>
          <a href="index.php?controller=order&action=checkout" class="btn-primary" style="width:100%;justify-content:center;padding:15px;font-size:15px;margin-top:22px;display:flex;border-radius:var(--r-lg);">
            <i class="fas fa-credit-card"></i> Thanh toán ngay
          </a>
        </div>
      </div>
    </div>
    <?php endif; ?>
  </div>
</div>

<!-- Confirm remove modal -->
<div id="confirmRemoveModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); align-items:center; justify-content:center; z-index:10000;">
  <div style="background:#fff; padding:25px; border-radius:12px; width:90%; max-width:420px; box-shadow:0 10px 25px rgba(0,0,0,0.2);">
    <h3 style="margin-top:0; color:#333;">Xác nhận xóa sản phẩm</h3>
    <p style="color:#666;">Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?</p>
    <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">
      <button onclick="closeRemoveModal()" style="padding:10px 18px; border:none; background:#6c757d; color:#fff; border-radius:8px; cursor:pointer;">Hủy</button>
      <button onclick="confirmRemove()" style="padding:10px 18px; border:none; background:#dc3545; color:#fff; border-radius:8px; cursor:pointer;">Xác nhận</button>
    </div>
  </div>
</div>

<script>
let toRemoveVariantId = null;

function removeItem(variantId) {
    toRemoveVariantId = variantId;
    document.getElementById('confirmRemoveModal').style.display = 'flex';
}

function closeRemoveModal() {
    toRemoveVariantId = null;
    document.getElementById('confirmRemoveModal').style.display = 'none';
}

function confirmRemove() {
    if (!toRemoveVariantId) return;

    fetch('index.php?controller=cart&action=remove', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `variant_id=${toRemoveVariantId}`
    })
    .then(res => res.json())
    .then(data => {
        closeRemoveModal();
        if (data.success) {
            const cartCount = document.getElementById('cart-count');
            if (cartCount) cartCount.textContent = data.item_count || data.total_quantity || 0;
            location.reload();
        } else {
            alert(data.message || 'Xóa thất bại!');
        }
    })
    .catch(error => {
        closeRemoveModal();
        console.error('Error:', error);
        alert('Có lỗi xảy ra, vui lòng thử lại!');
    });
}

function updateQuantity(variantId, quantity) {
    quantity = parseInt(quantity);
    
    if (quantity < 1) {
        removeItem(variantId);
        return;
    }
    
    fetch('index.php?controller=cart&action=update', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `variant_id=${variantId}&quantity=${quantity}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Có lỗi xảy ra!');
    });
}
</script>