<style>
.detail-page{padding:40px 0 80px;background:var(--bg);}
.back-link{display:inline-flex;align-items:center;gap:6px;color:var(--blue);font-size:13px;font-weight:700;margin-bottom:24px;}
.back-link:hover{text-decoration:underline;}
.detail-page h2{font-family:'Sora',sans-serif;font-size:24px;font-weight:800;color:var(--navy);margin-bottom:24px;}
.dcard{background:#fff;border:1.5px solid var(--border);border-radius:var(--radius-xl);padding:28px;margin-bottom:20px;box-shadow:0 4px 16px rgba(62,182,232,.06);}
.dcard h3{font-family:'Sora',sans-serif;font-size:14px;font-weight:800;color:var(--navy);margin-bottom:18px;padding-bottom:12px;border-bottom:2px solid var(--border);display:flex;align-items:center;gap:8px;}
.dcard h3 i{color:var(--blue);}
.info-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
.info-item .lbl{font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px;}
.info-item .val{font-size:13px;font-weight:700;color:var(--navy);}
/* Timeline */
.timeline{display:flex;flex-direction:column;gap:0;}
.tl-row{display:flex;gap:16px;}
.tl-track{display:flex;flex-direction:column;align-items:center;}
.tl-dot{width:14px;height:14px;border-radius:50%;border:3px solid;flex-shrink:0;margin-top:3px;}
.tl-line{width:2px;flex:1;background:var(--border);margin:4px 0;min-height:32px;}
.tl-row:last-child .tl-line{display:none;}
.tl-content{padding-bottom:22px;}
.tl-content h5{font-size:13px;font-weight:700;color:var(--navy);}
.tl-content p{font-size:12px;color:var(--muted);margin-top:2px;}
.tl-done .tl-dot  {border-color:var(--success);background:var(--success);}
.tl-active .tl-dot{border-color:var(--blue);background:var(--blue);}
.tl-active .tl-dot{animation:tlPulse 1.8s infinite;}
.tl-wait .tl-dot  {border-color:var(--border);background:#fff;}
@keyframes tlPulse{0%,100%{box-shadow:0 0 0 0 rgba(62,182,232,.4)}50%{box-shadow:0 0 0 7px rgba(62,182,232,0)}}
/* Items */
.item-row{display:flex;align-items:center;gap:12px;padding:12px 0;border-bottom:1px solid var(--bg);}
.item-row:last-child{border-bottom:none;}
.item-img{width:60px;height:60px;border-radius:10px;overflow:hidden;background:var(--bg);flex-shrink:0;border:1.5px solid var(--border);}
.item-img img{width:100%;height:100%;object-fit:cover;}
.item-info h5{font-size:13px;font-weight:700;color:var(--navy);}
.item-info p{font-size:11px;color:var(--muted);margin-top:2px;}
.item-right{margin-left:auto;text-align:right;}
.item-unit{font-size:11px;color:var(--muted);}
.item-total{font-size:15px;font-weight:800;color:var(--blue-dark);}
.total-bar{background:linear-gradient(135deg,var(--blue-light),#EBF3FB);border:1.5px solid #B8DFF0;border-radius:var(--radius);padding:16px 20px;display:flex;justify-content:space-between;align-items:center;margin-top:16px;}
.total-bar .tl2{font-size:14px;font-weight:700;color:var(--sub);}
.total-bar .tv{font-family:'Sora',sans-serif;font-size:26px;font-weight:800;color:var(--blue-dark);}
@media(max-width:640px){.info-grid{grid-template-columns:1fr;}}
</style>

<div class="detail-page">
  <div class="container" style="max-width:820px;">
    <a href="index.php?controller=order&action=history" class="back-link"><i class="fas fa-arrow-left"></i> Quay lại lịch sử đơn hàng</a>
    <h2><i class="fas fa-file-invoice" style="color:var(--blue);margin-right:8px;"></i>Đơn hàng #<?= str_pad($orderInfo['order_id'],6,'0',STR_PAD_LEFT) ?></h2>

    <!-- Timeline -->
    <div class="dcard">
      <h3><i class="fas fa-route"></i> Trạng thái đơn hàng</h3>
      <?php
      $statusOrder=['Pending','Shipping','Completed'];
      $curIdx=array_search($orderInfo['status'],$statusOrder);
      $cancelled=$orderInfo['status']==='Cancelled';
      if($cancelled):?>
      <div style="background:#FEF0F0;border:1.5px solid #F0C0C0;border-radius:var(--radius);padding:14px 18px;color:#A33232;font-weight:700;display:flex;align-items:center;gap:8px;">
        <i class="fas fa-times-circle"></i> Đơn hàng đã bị huỷ
      </div>
      <?php else: ?>
      <div class="timeline">
        <?php $steps=[['Pending','Đặt hàng thành công','Đơn hàng đã được xác nhận'],['Shipping','Đang giao hàng','Đơn hàng đang trên đường đến bạn'],['Completed','Giao hàng thành công','Bạn đã nhận được hàng']];
        foreach($steps as $i=>[$k,$t,$d]):
          $c=$i<$curIdx?'tl-done':($i===$curIdx?'tl-active':'tl-wait');?>
        <div class="tl-row <?= $c ?>">
          <div class="tl-track"><div class="tl-dot"></div><div class="tl-line"></div></div>
          <div class="tl-content"><h5><?= $t ?></h5><p><?= $d ?></p></div>
        </div>
        <?php endforeach; endif; ?>
      </div>
    </div>

    <!-- Info -->
    <div class="dcard">
      <h3><i class="fas fa-info-circle"></i> Thông tin đơn hàng</h3>
      <div class="info-grid">
        <div class="info-item"><div class="lbl">Ngày đặt hàng</div><div class="val"><?= date('d/m/Y H:i',strtotime($orderInfo['created_at'])) ?></div></div>
        <div class="info-item">
          <div class="lbl">Trạng thái</div>
          <div class="val">
            <?php $sm=['Pending'=>['status-pending','⏳ Chờ xử lý'],'Shipping'=>['status-shipping','🚚 Đang giao'],'Completed'=>['status-completed','✅ Hoàn thành'],'Cancelled'=>['status-cancelled','❌ Đã huỷ']];$sb=$sm[$orderInfo['status']]??['status-pending','?'];?>
            <span class="status-badge <?= $sb[0] ?>"><?= $sb[1] ?></span>
          </div>
        </div>
        <div class="info-item" style="grid-column:1/-1;"><div class="lbl">Địa chỉ giao hàng</div><div class="val"><?= htmlspecialchars($orderInfo['shipping_address']) ?></div></div>
        <div class="info-item"><div class="lbl">Phương thức TT</div><div class="val"><?= ($orderInfo['payment_method']??'COD')==='Momo'?'📱 Ví MoMo':'💵 COD' ?></div></div>
        <div class="info-item"><div class="lbl">Trạng thái TT</div><div class="val"><span class="status-badge <?= ($orderInfo['payment_status']??'')==='Paid'?'status-paid':'status-unpaid' ?>"><?= ($orderInfo['payment_status']??'')==='Paid'?'✓ Đã thanh toán':'Chưa thanh toán' ?></span></div></div>
      </div>
    </div>

    <!-- Items -->
    <div class="dcard">
      <h3><i class="fas fa-box"></i> Sản phẩm</h3>
      <?php foreach($orderItems as $item): ?>
      <div class="item-row">
        <div class="item-img">
          <?php if(!empty($item['image_url'])): ?>
          <img src="assets/images/products/<?= htmlspecialchars($item['image_url']) ?>" alt="" onerror="this.style.display='none'">
          <?php else: ?><div style="display:flex;align-items:center;justify-content:center;height:100%;"><i class="fas fa-shoe-prints" style="color:var(--muted);"></i></div><?php endif; ?>
        </div>
        <div class="item-info">
          <h5><?= htmlspecialchars($item['product_name']) ?></h5>
          <p>Size <?= $item['size'] ?> · <?= htmlspecialchars($item['color']) ?></p>
        </div>
        <div class="item-right">
          <div class="item-unit"><?= number_format($item['price'],0,',','.') ?>đ × <?= $item['quantity'] ?></div>
          <div class="item-total"><?= number_format($item['price']*$item['quantity'],0,',','.') ?>đ</div>
        </div>
      </div>
      <?php endforeach; ?>
      <div class="total-bar">
        <span class="tl2">Tổng thanh toán</span>
        <span class="tv"><?= number_format($orderInfo['total_price'],0,',','.') ?>đ</span>
      </div>
    </div>
  </div>
</div>
