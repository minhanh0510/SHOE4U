<style>
.auth-page{min-height:90vh;display:flex;align-items:center;justify-content:center;padding:48px 20px;background:linear-gradient(145deg,var(--blue-pale) 0%,#EAF5FD 50%,var(--frost) 100%);position:relative;overflow:hidden;}
.auth-page::before{content:'';position:absolute;top:-200px;right:-150px;width:600px;height:600px;border-radius:50%;background:radial-gradient(circle,rgba(91,191,234,.1) 0%,transparent 70%);}
.auth-wrap{display:grid;grid-template-columns:1fr 1.4fr;max-width:940px;width:100%;background:#fff;border-radius:28px;box-shadow:0 32px 80px rgba(10,22,40,.14);overflow:hidden;border:1px solid var(--fog);position:relative;z-index:1;}
.auth-visual{background:linear-gradient(160deg,var(--ink) 0%,var(--ink2) 50%,var(--dark3) 100%);padding:52px 40px;display:flex;flex-direction:column;justify-content:center;position:relative;overflow:hidden;}
.auth-visual::before{content:'';position:absolute;top:-80px;right:-60px;width:280px;height:280px;border-radius:50%;background:radial-gradient(circle,rgba(91,191,234,.18) 0%,transparent 68%);}
.auth-v-logo{display:flex;align-items:center;gap:12px;margin-bottom:32px;position:relative;z-index:1;}
.auth-v-logo-mark{width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,var(--blue),var(--blue-mid));display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;box-shadow:0 5px 16px rgba(91,191,234,.4);}
.auth-v-logo-text{font-family:'Plus Jakarta Sans',sans-serif;font-size:19px;font-weight:800;color:#fff;}
.auth-v-logo-text em{color:var(--blue);font-style:normal;}
.auth-visual h2{font-family:'DM Serif Display',serif;font-size:28px;color:#fff;line-height:1.25;margin-bottom:10px;position:relative;z-index:1;}
.auth-visual h2 em{color:var(--blue-mid);font-style:italic;}
.auth-visual p{font-size:13px;color:rgba(255,255,255,.55);line-height:1.8;margin-bottom:28px;position:relative;z-index:1;}
.auth-perks{display:flex;flex-direction:column;gap:12px;position:relative;z-index:1;}
.auth-perk{display:flex;align-items:center;gap:12px;font-size:13px;color:rgba(255,255,255,.7);font-weight:500;}
.auth-perk-icon{width:34px;height:34px;border-radius:9px;background:rgba(91,191,234,.12);border:1px solid rgba(91,191,234,.25);color:var(--blue-mid);font-size:13px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.auth-form-side{padding:48px 44px;display:flex;flex-direction:column;justify-content:center;overflow-y:auto;}
.auth-form-side h3{font-family:'DM Serif Display',serif;font-size:26px;color:var(--ink);margin-bottom:5px;}
.auth-sub{font-size:13.5px;color:var(--mist);margin-bottom:28px;font-weight:500;}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
.alert-box{padding:13px 16px;border-radius:var(--r-lg);margin-bottom:18px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:10px;}
.alert-box-err{background:#FEF2F2;color:#991B1B;border:1.5px solid #FECACA;}
.auth-footer{text-align:center;margin-top:20px;font-size:13.5px;color:var(--mist);}
.auth-footer a{color:var(--blue-mid);font-weight:700;}
@media(max-width:660px){.auth-wrap{grid-template-columns:1fr;}.auth-visual{display:none;}.auth-form-side{padding:32px 24px;}.form-row{grid-template-columns:1fr;}}
</style>

<div class="auth-page">
  <div class="auth-wrap">
    <div class="auth-visual">
      <div class="auth-v-logo">
        <div class="auth-v-logo-mark"><i class="fas fa-shoe-prints"></i></div>
        <span class="auth-v-logo-text">Shoe<em>4U</em></span>
      </div>
      <h2>Tham gia<br><em>Shoe4U</em></h2>
      <p>Tạo tài khoản miễn phí và bắt đầu trải nghiệm mua sắm giày dép cao cấp với hàng ngàn ưu đãi.</p>
      <div class="auth-perks">
        <div class="auth-perk"><div class="auth-perk-icon"><i class="fas fa-gift"></i></div> Quà tặng chào mừng thành viên mới</div>
        <div class="auth-perk"><div class="auth-perk-icon"><i class="fas fa-percent"></i></div> Ưu đãi thành viên độc quyền</div>
        <div class="auth-perk"><div class="auth-perk-icon"><i class="fas fa-box-open"></i></div> Theo dõi đơn hàng mọi lúc</div>
        <div class="auth-perk"><div class="auth-perk-icon"><i class="fas fa-shield-halved"></i></div> Bảo mật thông tin tuyệt đối</div>
      </div>
    </div>
    <div class="auth-form-side">
      <h3>Tạo tài khoản</h3>
      <p class="auth-sub">Điền đầy đủ thông tin để đăng ký. Hoàn toàn miễn phí!</p>

      <?php if (isset($_SESSION['error'])): ?>
      <div class="alert-box alert-box-err"><i class="fas fa-circle-exclamation"></i> <?= $_SESSION['error'] ?></div>
      <?php unset($_SESSION['error']); endif; ?>

      <form method="POST" action="index.php?controller=auth&action=register">
        <div class="form-row">
          <div class="form-group">
            <label>Họ và tên *</label>
            <div class="iw"><i class="fas fa-user"></i><input type="text" name="full_name" placeholder="Nguyễn Văn A" required></div>
          </div>
          <div class="form-group">
            <label>Số điện thoại</label>
            <div class="iw"><i class="fas fa-phone"></i><input type="text" name="phone" placeholder="0901 234 567"></div>
          </div>
        </div>
        <div class="form-group">
          <label>Địa chỉ Email *</label>
          <div class="iw"><i class="fas fa-envelope"></i><input type="email" name="email" placeholder="email@example.com" required></div>
        </div>
        <div class="form-group">
          <label>Địa chỉ giao hàng</label>
          <div class="iw"><i class="fas fa-map-marker-alt"></i><input type="text" name="address" placeholder="Số nhà, đường, quận, thành phố"></div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Mật khẩu *</label>
            <div class="iw"><i class="fas fa-lock"></i><input type="password" name="password" placeholder="Tối thiểu 6 ký tự" required></div>
          </div>
          <div class="form-group">
            <label>Xác nhận mật khẩu *</label>
            <div class="iw"><i class="fas fa-lock"></i><input type="password" name="confirm_password" placeholder="Nhập lại" required></div>
          </div>
        </div>
        <button type="submit" class="btn-primary" style="width:100%;justify-content:center;padding:14px;font-size:15px;border-radius:var(--r-lg);">
          <i class="fas fa-user-plus"></i> Đăng ký ngay — Miễn phí!
        </button>
      </form>
      <div class="auth-footer">Đã có tài khoản? <a href="index.php?controller=auth&action=login">Đăng nhập</a></div>
    </div>
  </div>
</div>
