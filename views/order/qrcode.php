<!-- views/order/qrcode.php -->
<style>
.qr-page{max-width:600px;margin:40px auto;text-align:center;background:#fff;border-radius:20px;padding:40px;box-shadow:0 8px 30px rgba(0,0,0,0.1);}
.qr-page h2{font-size:28px;color:#1a1a1a;margin-bottom:10px;}
.qr-page .sub{color:#666;margin-bottom:30px;}
.qr-box{background:#f8f9fa;border-radius:16px;padding:30px;display:inline-block;margin-bottom:20px;}
.qr-box img{width:220px;height:220px;}
.qr-info{background:#f0f7ff;border-radius:12px;padding:20px;margin:20px 0;text-align:left;}
.qr-info p{margin:8px 0;font-size:15px;}
.qr-info strong{color:#1a1a1a;}
.status-badge{display:inline-block;padding:6px 16px;border-radius:20px;font-size:13px;font-weight:600;}
.status-pending{background:#fff3cd;color:#856404;}
.btn-group{display:flex;gap:12px;justify-content:center;margin-top:20px;flex-wrap:wrap;}
</style>

<div class="qr-page">
    <h2>Quét mã QR để thanh toán</h2>
    <p class="sub">Đơn hàng #<?= str_pad($orderInfo['order_id'], 6, '0', STR_PAD_LEFT) ?> — Tổng: <strong><?= number_format($orderInfo['total_price'], 0, ',', '.') ?>đ</strong></p>

    <div class="qr-box">
        <img src="<?= $qrDataUri ?>" alt="QR Code thanh toán">
    </div>

    <div class="qr-info">
        <p><strong>Phương thức:</strong> <?= $paymentMethod == 'Momo' ? 'Ví MoMo (Quét VietQR)' : 'Chuyển khoản VietQR Ngân hàng' ?></p>
        <p><strong>Ngân hàng:</strong> BIDV (TMCP Đầu tư và Phát triển Việt Nam)</p>
        <p><strong>Số tài khoản:</strong> <strong style="color: #0066cc; font-size: 16px;">1351450840</strong></p>
        <p><strong>Chủ tài khoản:</strong> <strong>NGUYEN MINH ANH</strong></p>
        <p><strong>Số tiền:</strong> <strong style="color: #28a745; font-size: 17px;"><?= number_format($orderInfo['total_price'], 0, ',', '.') ?>đ</strong></p>
        <p><strong>Nội dung CK:</strong> <code style="background: #e9ecef; padding: 3px 8px; border-radius: 4px; font-weight: bold; color: #d63384;">SHOE4U DH<?= str_pad($orderInfo['order_id'], 6, '0', STR_PAD_LEFT) ?></code></p>
        <p><strong>Trạng thái:</strong> <span class="status-badge status-pending">Chờ thanh toán</span></p>
    </div>

    <p style="color:#888;font-size:14px;">Sau khi thanh toán, nhấn nút bên dưới để xác nhận.</p>

    <div class="btn-group">
        <a href="index.php?controller=order&action=confirm&id=<?= $orderInfo['order_id'] ?>" class="btn-primary" style="display:inline-flex;padding:14px 30px;">
            <i class="fas fa-check-circle"></i> Tôi đã thanh toán
        </a>
        <a href="index.php?controller=order&action=detail&id=<?= $orderInfo['order_id'] ?>" class="btn-outline" style="display:inline-flex;padding:14px 30px;">
            <i class="fas fa-eye"></i> Xem đơn hàng
        </a>
    </div>
</div>