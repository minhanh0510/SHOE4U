<style>
.checkout-page{padding:40px 0 80px;background:var(--bg);}
.page-head{margin-bottom:32px;}
.page-head h2{font-family:'Sora',sans-serif;font-size:28px;font-weight:800;color:var(--navy);display:flex;align-items:center;gap:10px;}
.page-head h2 i{color:var(--blue);}
.co-grid{display:grid;grid-template-columns:1.15fr 1fr;gap:24px;align-items:start;}
.co-card{background:#fff;border:1.5px solid var(--border);border-radius:var(--radius-xl);padding:28px;margin-bottom:20px;box-shadow:0 4px 16px rgba(62,182,232,.06);}
.co-card:last-child{margin-bottom:0;}
.co-card h3{font-family:'Sora',sans-serif;font-size:15px;font-weight:800;color:var(--navy);margin-bottom:20px;padding-bottom:14px;border-bottom:2px solid var(--border);display:flex;align-items:center;gap:8px;}
.co-card h3 i{color:var(--blue);}
/* Payment options */
.pay-opts{display:flex;flex-direction:column;gap:10px;}
.pay-opt{display:flex;align-items:center;gap:14px;padding:14px 16px;border:2px solid var(--border);border-radius:var(--radius);cursor:pointer;transition:var(--trans);position:relative;}
.pay-opt:hover{border-color:var(--blue);background:var(--blue-light);}
.pay-opt.selected{border-color:var(--blue);background:#EEF7FE;}
.pay-opt.selected::after{content:'✓';position:absolute;top:-8px;right:-8px;width:22px;height:22px;border-radius:50%;background:var(--blue);color:#fff;font-size:11px;font-weight:700;display:flex;align-items:center;justify-content:center;}
.pay-icon{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;}
.pay-momo{background:linear-gradient(135deg,#AE2070,#D43090);color:#fff;}
.pay-cod {background:linear-gradient(135deg,#F0A840,#E08020);color:#fff;}
.pay-info h4{font-size:14px;font-weight:700;color:var(--navy);}
.pay-info p {font-size:12px;color:var(--muted);margin-top:2px;}
/* Momo box */
.momo-box{display:none;margin-top:12px;padding:20px;background:#FDF3F8;border:2px solid #E8A0CC;border-radius:var(--radius);text-align:center;animation:fadeIn .3s;}
.momo-box.show{display:block;}
.momo-qr{width:130px;height:130px;margin:0 auto 14px;background:linear-gradient(135deg,#AE2070,#D43090);border-radius:14px;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#fff;}
.momo-qr .ml{font-size:40px;font-weight:900;line-height:1;}
.momo-qr .ms{font-size:10px;opacity:.85;margin-top:4px;}
.momo-steps{text-align:left;font-size:12px;color:#7A3050;margin-top:10px;}
.momo-steps li{padding:3px 0;}
.momo-badge{display:inline-block;background:#AE2070;color:#fff;padding:4px 14px;border-radius:20px;font-size:11px;font-weight:700;margin-top:10px;}
/* Summary */
.order-item{display:flex;align-items:center;gap:12px;padding:12px 0;border-bottom:1px solid var(--bg);}
.order-item:last-child{border-bottom:none;}
.oi-img{width:56px;height:56px;border-radius:10px;overflow:hidden;background:var(--bg);flex-shrink:0;display:flex;align-items:center;justify-content:center;border:1.5px solid var(--border);}
.oi-img img{width:100%;height:100%;object-fit:cover;}
.oi-info h5{font-size:13px;font-weight:700;color:var(--navy);}
.oi-info p{font-size:11px;color:var(--muted);margin-top:2px;}
.oi-price{margin-left:auto;font-size:14px;font-weight:700;color:var(--blue-dark);white-space:nowrap;}
.total-row{display:flex;justify-content:space-between;align-items:center;padding:8px 0;font-size:14px;}
.total-row .tl{color:var(--sub);}
.total-row .tv{font-weight:600;color:var(--text);}
.total-row.big{border-top:2px solid var(--border);padding-top:14px;margin-top:6px;}
.total-row.big .tl{font-size:16px;font-weight:700;color:var(--navy);}
.total-row.big .tv{font-size:22px;font-weight:800;color:var(--blue-dark);}
@keyframes fadeIn{from{opacity:0;transform:translateY(-6px)}to{opacity:1;transform:translateY(0)}}
@media(max-width:768px){.co-grid{grid-template-columns:1fr;}}
</style>

<div class="checkout-page">
  <div class="container">
    <div class="page-head">
      <h2><i class="fas fa-credit-card"></i> Thanh toán đơn hàng</h2>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
    <div style="padding:14px 18px;background:#FEF0F0;border:1.5px solid #F0C0C0;border-radius:var(--radius);color:#A33232;font-size:13px;font-weight:600;margin-bottom:24px;display:flex;align-items:center;gap:8px;">
      <i class="fas fa-exclamation-circle"></i> <?= $_SESSION['error'] ?></div>
    <?php unset($_SESSION['error']); endif; ?>

    <form method="POST" action="index.php?controller=order&action=placeOrder">
    <div class="co-grid">
      <div>
        <!-- Delivery Info -->
        <div class="co-card">
          <h3><i class="fas fa-map-marker-alt"></i> Thông tin giao hàng</h3>
          <div class="form-group" style="margin-bottom:14px;">
            <label>Người nhận</label>
            <div class="iw"><i class="fas fa-user"></i>
              <input type="text" value="<?= htmlspecialchars($_SESSION['full_name'] ?? '') ?>" readonly style="background:#F8FBFE;color:var(--sub);">
            </div>
          </div>
          <div class="form-group" style="margin-bottom:0;">
            <label>Địa chỉ giao hàng *</label>
            <div class="iw">
              <textarea name="shipping_address" rows="3" placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố" required style="padding:12px 14px;"></textarea>
            </div>
          </div>
        </div>

        <!-- Payment Method -->
        <div class="co-card">
          <h3><i class="fas fa-wallet"></i> Phương thức thanh toán</h3>
          <div class="pay-opts">
            <div class="pay-opt" id="opt-momo" onclick="selectPay('Momo',this)">
              <div class="pay-icon pay-momo"><i class="fas fa-mobile-alt"></i></div>
              <div class="pay-info">
                <h4>Ví MoMo</h4>
                <p>Quét QR thanh toán nhanh qua ví điện tử</p>
              </div>
            </div>
            <div class="momo-box" id="momo-box">
              <div class="momo-qr"><div class="ml">M</div><div class="ms">SCAN TO PAY</div></div>
              <p style="font-size:13px;font-weight:700;color:#7A3050;margin-bottom:8px;">Quét mã QR bằng app MoMo</p>
              <ol class="momo-steps">
                <li>Mở app MoMo → chọn <strong>Quét mã QR</strong></li>
                <li>Quét mã và xác nhận thanh toán</li>
                <li>Nhấn "Xác nhận đặt hàng" sau khi quét</li>
              </ol>
              <span class="momo-badge">✓ Giả lập — Tự động xác nhận</span>
            </div>

            <div class="pay-opt selected" id="opt-cod" onclick="selectPay('COD',this)">
              <div class="pay-icon pay-cod"><i class="fas fa-money-bill-wave"></i></div>
              <div class="pay-info">
                <h4>Thanh toán khi nhận hàng (COD)</h4>
                <p>Trả tiền mặt khi nhận được hàng tại nhà</p>
              </div>
            </div>
          </div>
          <input type="hidden" name="payment_method" id="pmInput" value="COD">
        </div>
      </div>

      <!-- Order Summary -->
      <div>
        <div class="co-card" style="position:sticky;top:90px;">
          <h3><i class="fas fa-shopping-bag"></i> Đơn hàng của bạn</h3>
          <?php foreach ($cartItems as $item): ?>
          <div class="order-item">
            <div class="oi-img">
              <?php if (!empty($item['image_url'])): ?>
              <img src="assets/images/products/<?= htmlspecialchars($item['image_url']) ?>" alt="" onerror="this.style.display='none'">
              <?php else: ?><i class="fas fa-shoe-prints" style="color:var(--muted);"></i><?php endif; ?>
            </div>
            <div class="oi-info">
              <h5><?= htmlspecialchars($item['product_name']) ?></h5>
              <p>Size <?= $item['size'] ?> · <?= htmlspecialchars($item['color']) ?> · ×<?= $item['quantity'] ?></p>
            </div>
            <div class="oi-price"><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>đ</div>
          </div>
          <?php endforeach; ?>
          <div style="margin-top:16px;">
            <div class="total-row"><span class="tl">Tạm tính</span><span class="tv"><?= number_format($total,0,',','.') ?>đ</span></div>
            <div class="total-row"><span class="tl">Phí vận chuyển</span><span class="tv" style="color:var(--success);font-weight:700;">Miễn phí</span></div>
            <div class="total-row big"><span class="tl">Tổng cộng</span><span class="tv"><?= number_format($total,0,',','.') ?>đ</span></div>
          </div>
          <button type="submit" class="btn-primary" style="width:100%;justify-content:center;padding:15px;font-size:15px;margin-top:20px;">
            <i class="fas fa-check-circle"></i> Xác nhận đặt hàng
          </button>
          <a href="index.php" style="display:block;text-align:center;margin-top:12px;font-size:13px;color:var(--muted);"><i class="fas fa-arrow-left"></i> Tiếp tục mua sắm</a>
        </div>
      </div>
    </div>
    </form>
  </div>
</div>
<script>
function selectPay(m,el){
  document.querySelectorAll('.pay-opt').forEach(o=>o.classList.remove('selected'));
  el.classList.add('selected');
  document.getElementById('pmInput').value=m;
  document.getElementById('momo-box').classList.toggle('show',m==='Momo');
}
</script>