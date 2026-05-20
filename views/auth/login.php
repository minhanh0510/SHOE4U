<?php
// Lấy error từ session nếu có
$error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
unset($_SESSION['login_error']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Khởi tạo kết nối nếu chưa có
    if (!isset($pdo)) {
        require_once '../../config/database.php';
        $database = new Database();
        $pdo = $database->getConnection();
    }
    
    require_once '../../models/User.php';
    $user = new User($pdo);
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    
    if ($user->login()) {
        // Xóa session cũ và gán mới
        session_unset();
        
        $_SESSION['user_id']   = $user->user_id;
        $_SESSION['full_name'] = $user->full_name;
        $_SESSION['email']     = $user->email;
        $_SESSION['role']      = $user->role;
        
        // Chuyển hướng dựa trên role
        if ($user->role === 'admin') {
            header('Location: ../admin/index.php');
        } else {
            header('Location: ../../index.php');
        }
        exit();
    } else {
        $error = "Email hoặc mật khẩu không đúng!";
    }
}
?>

<style>
.auth-page{min-height:90vh;display:flex;align-items:center;justify-content:center;padding:48px 20px;background:linear-gradient(145deg,#e8f4fd 0%,#EAF5FD 50%,#d4e4f0 100%);position:relative;overflow:hidden;}
.auth-page::before{content:'';position:absolute;top:-200px;right:-150px;width:600px;height:600px;border-radius:50%;background:radial-gradient(circle,rgba(91,191,234,.1) 0%,transparent 70%);}
.auth-wrap{display:grid;grid-template-columns:1fr 1.4fr;max-width:940px;width:100%;background:#fff;border-radius:28px;box-shadow:0 32px 80px rgba(10,22,40,.14);overflow:hidden;border:1px solid #c5dce8;position:relative;z-index:1;}
.auth-visual{background:linear-gradient(160deg,#071828 0%,#0D2438 50%,#183550 100%);padding:52px 40px;display:flex;flex-direction:column;justify-content:center;position:relative;overflow:hidden;}
.auth-visual::before{content:'';position:absolute;top:-80px;right:-60px;width:280px;height:280px;border-radius:50%;background:radial-gradient(circle,rgba(91,191,234,.18) 0%,transparent 68%);}
.auth-v-logo{display:flex;align-items:center;gap:12px;margin-bottom:32px;position:relative;z-index:1;}
.auth-v-logo-mark{width:40px;height:40px;border-radius:12px;background:linear-gradient(135deg,#4BB8F0,#1A9FDB);display:flex;align-items:center;justify-content:center;color:#fff;font-size:17px;box-shadow:0 5px 16px rgba(91,191,234,.4);}
.auth-v-logo-text{font-family:'Plus Jakarta Sans',sans-serif;font-size:19px;font-weight:800;color:#fff;}
.auth-v-logo-text em{color:#4BB8F0;font-style:normal;}
.auth-visual h2{font-family:'DM Serif Display',serif;font-size:28px;color:#fff;line-height:1.25;margin-bottom:10px;position:relative;z-index:1;}
.auth-visual h2 em{color:#1A9FDB;font-style:italic;}
.auth-visual p{font-size:13px;color:rgba(255,255,255,.55);line-height:1.8;margin-bottom:28px;position:relative;z-index:1;}
.auth-perks{display:flex;flex-direction:column;gap:12px;position:relative;z-index:1;}
.auth-perk{display:flex;align-items:center;gap:12px;font-size:13px;color:rgba(255,255,255,.7);font-weight:500;}
.auth-perk-icon{width:34px;height:34px;border-radius:9px;background:rgba(91,191,234,.12);border:1px solid rgba(91,191,234,.25);color:#1A9FDB;font-size:13px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.auth-form-side{padding:48px 44px;display:flex;flex-direction:column;justify-content:center;overflow-y:auto;}
.auth-form-side h3{font-family:'DM Serif Display',serif;font-size:26px;color:#071828;margin-bottom:5px;}
.auth-sub{font-size:13.5px;color:#96B8C8;margin-bottom:28px;font-weight:500;}
.form-group{margin-bottom:20px;}
.form-group label{display:block;margin-bottom:8px;font-weight:600;color:#4A7A94;font-size:13px;}
.iw{position:relative;}
.iw i{position:absolute;left:15px;top:50%;transform:translateY(-50%);color:#96B8C8;font-size:14px;}
.iw input{width:100%;padding:12px 15px 12px 45px;border:1.5px solid #C5DCE8;border-radius:12px;font-size:14px;transition:all .2s;}
.iw input:focus{border-color:#4BB8F0;outline:none;box-shadow:0 0 0 3px rgba(75,184,240,.1);}
.alert-box{padding:13px 16px;border-radius:14px;margin-bottom:18px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:10px;}
.alert-box-err{background:#FEF2F2;color:#991B1B;border:1.5px solid #FECACA;}
.btn-primary{display:inline-flex;align-items:center;gap:8px;padding:13px 30px;background:linear-gradient(135deg,#4BB8F0,#1A9FDB);color:#fff;border:none;border-radius:50px;font-size:14px;font-weight:700;cursor:pointer;transition:all .2s;width:100%;justify-content:center;padding:14px;font-size:15px;border-radius:14px;}
.btn-primary:hover{transform:translateY(-2px);box-shadow:0 8px 28px rgba(75,184,240,.52);}
.auth-footer{text-align:center;margin-top:20px;font-size:13.5px;color:#96B8C8;}
.auth-footer a{color:#1A9FDB;font-weight:700;text-decoration:none;}
.auth-footer a:hover{text-decoration:underline;}
.demo-hint{margin-top:16px;text-align:center;font-size:12px;color:#96B8C8;padding:10px;background:#f0f9ff;border-radius:12px;}
@media(max-width:660px){.auth-wrap{grid-template-columns:1fr;}.auth-visual{display:none;}.auth-form-side{padding:32px 24px;}}
</style>

<div class="auth-page">
  <div class="auth-wrap">
    <div class="auth-visual">
      <div class="auth-v-logo">
        <div class="auth-v-logo-mark"><i class="fas fa-shoe-prints"></i></div>
        <span class="auth-v-logo-text">Shoe<em>4U</em></span>
      </div>
      <h2>Chào mừng<br><em>trở lại!</em></h2>
      <p>Đăng nhập để tiếp tục mua sắm, theo dõi đơn hàng và nhận những ưu đãi độc quyền dành riêng cho bạn.</p>
      <div class="auth-perks">
        <div class="auth-perk"><div class="auth-perk-icon"><i class="fas fa-box-open"></i></div> Theo dõi đơn hàng theo thời gian thực</div>
        <div class="auth-perk"><div class="auth-perk-icon"><i class="fas fa-gift"></i></div> Ưu đãi thành viên độc quyền</div>
        <div class="auth-perk"><div class="auth-perk-icon"><i class="fas fa-shield-halved"></i></div> Thanh toán bảo mật tuyệt đối</div>
        <div class="auth-perk"><div class="auth-perk-icon"><i class="fas fa-headset"></i></div> Hỗ trợ khách hàng 24/7</div>
      </div>
    </div>
    <div class="auth-form-side">
      <h3>Đăng nhập</h3>
      <p class="auth-sub">Nhập thông tin tài khoản của bạn để tiếp tục.</p>

      <?php if ($error): ?>
      <div class="alert-box alert-box-err"><i class="fas fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="form-group">
          <label>Địa chỉ Email</label>
          <div class="iw">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="email@example.com" required value="admin@gmail.com">
          </div>
        </div>
        <div class="form-group">
          <label>Mật khẩu</label>
          <div class="iw">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="••••••••" required value="123456">
          </div>
        </div>
        <button type="submit" class="btn-primary">
          <i class="fas fa-right-to-bracket"></i> Đăng nhập
        </button>
      </form>
      <div class="auth-footer">
        Chưa có tài khoản? <a href="../../index.php?controller=auth&action=register">Đăng ký miễn phí</a>
      </div>
      <div class="demo-hint">
        <strong>🔑 Demo:</strong> admin@gmail.com / 123456 &nbsp;|&nbsp; a@gmail.com / 123456
      </div>
    </div>
  </div>
</div>