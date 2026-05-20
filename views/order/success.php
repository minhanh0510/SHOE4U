<style>
.success-page{padding:64px 0 80px;background:var(--bg);}
.success-inner{max-width:700px;margin:0 auto;text-align:center;}
.success-anim{width:90px;height:90px;background:linear-gradient(135deg,var(--blue),var(--blue-dark));border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;box-shadow:0 12px 32px rgba(62,182,232,.35);animation:popIn .5s cubic-bezier(.34,1.56,.64,1);}
.success-anim i{font-size:40px;color:#fff;}
.success-inner h2{font-family:'Sora',sans-serif;font-size:30px;font-weight:800;color:var(--navy);margin-bottom:8px;}
.success-inner .sub{font-size:15px;color:var(--muted);margin-bottom:40px;}
.order-card{background:#fff;border:1.5px solid var(--border);border-radius:var(--radius-xl);padding:28px;text-align:left;margin-bottom:20px;box-shadow:0 4px 20px rgba(62,182,232,.08);}
.order-card h3{font-family:'Sora',sans-serif;font-size:14px;font-weight:800;color:var(--navy);margin-bottom:18px;padding-bottom:12px;border-bottom:2px solid var(--border);display:flex;align-items:center;gap:8px;}
.order-card h3 i{color:var(--blue);}
.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.info-item .lbl{font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;}
.info-item .val{font-size:13px;font-weight:700;color:var(--navy);}
.item-row{display:flex;align-items:center;gap:12px;padding:10px 0;border-bottom:1px solid var(--bg);}
.item-row:last-child{border-bottom:none;}
.item-img{width:52px;height:52px;border-radius:10px;overflow:hidden;background:var(--bg);flex-shrink:0;border:1.5px solid var(--border);}
.item-img img{width:100%;height:100%;object-fit:cover;}
.item-info h5{font-size:13px;font-weight:700;color:var(--navy);}
.item-info p{font-size:11px;color:var(--muted);margin-top:2px;}
.item-price{margin-left:auto;font-size:14px;font-weight:700;color:var(--blue-dark);}
.total-bar{background:linear-gradient(135deg,var(--blue-light),#EBF3FB);border:1.5px solid #B8DFF0;border-radius:var(--radius);padding:16px 20px;display:flex;justify-content:space-between;align-items:center;margin-top:16px;}
.total-bar .tl{font-size:14px;font-weight:700;color:var(--sub);}
.total-bar .tv{font-family:'Sora',sans-serif;font-size:24px;font-weight:800;color:var(--blue-dark);}
.action-btns{display:flex;gap:14px;justify-content:center;flex-wrap:wrap;margin-top:8px;}
@keyframes popIn{0%{transform:scale(0)}70%{transform:scale(1.12)}100%{transform:scale(1)}}
</style>

<div class="success-page">
  <div class="container">
    <div class="success-inner">
      <div class="success-anim"><i class="fas fa-check"></i></div>
      <h2>Đặt hàng thành công! 🎉</h2>
      <p class="sub">Cảm ơn bạn đã mua sắm tại <strong>Shoe4U</strong>. Đơn hàng của bạn đang được xử lý và sẽ sớm được giao đến bạn.</p>

      <?php if ($orderInfo): ?>
      <div class="order-card">
        <h3><i class="fas fa-receipt"></i> Thông tin đơn hàng #<?= str_pad($orderInfo['order_id'],6,'0',STR_PAD_LEFT) ?></h3>
        <div class="info-grid">
          <div class="info-item"><div class="lbl">Mã đơn</div><div class="val">#<?= str_pad($orderInfo['order_id'],6,'0',STR_PAD_LEFT) ?></div></div>
          <div class="info-item"><div class="lbl">Ngày đặt</div><div class="val"><?= date('d/m/Y H:i',strtotime($orderInfo['created_at'])) ?></div></div>
          <div class="info-item" style="grid-column:1/-1;"><div class="lbl">Địa chỉ giao hàng</div><div class="val"><?= htmlspecialchars($orderInfo['shipping_address']) ?></div></div>
          <div class="info-item">
            <div class="lbl">Thanh toán</div>
            <div class="val">
              <?php $pm=$orderInfo['payment_method']??'COD'; ?>
              <?= $pm==='Momo'?'📱 Ví MoMo':'💵 COD' ?>
              — <span style="color:<?= ($orderInfo['payment_status']??'')==='Paid'?'var(--success)':'var(--warning)' ?>;font-size:12px;">
                <?= ($orderInfo['payment_status']??'')==='Paid'?'✓ Đã thanh toán':'Thanh toán khi nhận hàng' ?>
              </span>
            </div>
          </div>
          <div class="info-item">
            <div class="lbl">Trạng thái</div>
            <div class="val"><span class="status-badge status-pending">⏳ Đang xử lý</span></div>
          </div>
        </div>
      </div>

      <?php if (!empty($orderItems)): ?>
      <div class="order-card">
        <h3><i class="fas fa-box"></i> Sản phẩm đã đặt</h3>
        <?php foreach($orderItems as $item): ?>
        <div class="item-row">
          <div class="item-img">
            <?php if(!empty($item['image_url'])): ?>
            <img src="assets/images/products/<?= htmlspecialchars($item['image_url']) ?>" alt="" onerror="this.style.display='none'">
            <?php else: ?><div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;"><i class="fas fa-shoe-prints" style="color:var(--muted);"></i></div><?php endif; ?>
          </div>
          <div class="item-info">
            <h5><?= htmlspecialchars($item['product_name']) ?></h5>
            <p>Size <?= $item['size'] ?> · <?= htmlspecialchars($item['color']) ?> · ×<?= $item['quantity'] ?></p>
          </div>
          <div class="item-price"><?= number_format($item['price']*$item['quantity'],0,',','.') ?>đ</div>
        </div>
        <?php endforeach; ?>
        <div class="total-bar">
          <span class="tl">Tổng thanh toán</span>
          <span class="tv"><?= number_format($orderInfo['total_price'],0,',','.') ?>đ</span>
        </div>
      </div>
      <?php endif; ?>
      <?php endif; ?>

      <div class="action-btns">
        <a href="index.php?controller=order&action=history" class="btn-primary"><i class="fas fa-list"></i> Xem đơn hàng</a>
        <a href="index.php" class="btn-outline"><i class="fas fa-shopping-bag"></i> Tiếp tục mua sắm</a>
      </div>
    </div>
  </div>
</div>
