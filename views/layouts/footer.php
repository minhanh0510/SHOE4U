<?php if (isset($show_sidebar) && $show_sidebar): ?>
    </div><!-- .main-content -->
  </div><!-- .container -->
<?php endif; ?>
</main>

<footer>
  <div class="container">
    <div class="footer-content">
      <!-- Brand -->
      <div>
        <div class="footer-brand-wrap">
          <div class="footer-logo-mark"><i class="fas fa-shoe-prints"></i></div>
          <span class="footer-brand-name">Shoe<em>4U</em></span>
        </div>
        <p class="footer-desc">Cửa hàng giày dép cao cấp hàng đầu Việt Nam. Chúng tôi mang đến phong cách, chất lượng và đẳng cấp cho từng bước chân của bạn.</p>
        <div class="footer-socials">
          <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
          <a href="#" class="social-btn"><i class="fab fa-tiktok"></i></a>
          <a href="#" class="social-btn"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
      <!-- Khám phá -->
      <div>
        <div class="footer-heading">Khám phá</div>
        <ul class="footer-links">
          <li><a href="index.php"><i class="fas fa-angle-right"></i> Trang chủ</a></li>
          <li><a href="index.php?controller=product&action=category"><i class="fas fa-angle-right"></i> Tất cả sản phẩm</a></li>
          <li><a href="index.php?controller=about"><i class="fas fa-angle-right"></i> Về chúng tôi</a></li>
          <li><a href="index.php?controller=order&action=history"><i class="fas fa-angle-right"></i> Đơn hàng của tôi</a></li>
        </ul>
      </div>
      <!-- Danh mục -->
      <div>
        <div class="footer-heading">Danh mục</div>
        <ul class="footer-links">
          <li><a href="index.php?controller=product&action=category&category=1"><i class="fas fa-angle-right"></i> Giày Nam</a></li>
          <li><a href="index.php?controller=product&action=category&category=2"><i class="fas fa-angle-right"></i> Giày Nữ</a></li>
          <li><a href="index.php?controller=product&action=category&category=3"><i class="fas fa-angle-right"></i> Sneaker</a></li>
          <li><a href="index.php?controller=product&action=category&category=4"><i class="fas fa-angle-right"></i> Dép & Sandal</a></li>
          <li><a href="index.php?controller=product&action=category&category=5"><i class="fas fa-angle-right"></i> Giày Thể Thao</a></li>
        </ul>
      </div>
      <!-- Liên hệ -->
      <div>
        <div class="footer-heading">Liên hệ</div>
        <ul class="contact-info">
          <li><i class="fas fa-map-marker-alt"></i> 123 Lê Lợi, Q.1, TP.HCM</li>
          <li><i class="fas fa-phone-alt"></i> 1900 1234</li>
          <li><i class="fas fa-envelope"></i> hello@shoe4u.vn</li>
          <li><i class="fas fa-clock"></i> 8:00 – 22:00 mỗi ngày</li>
        </ul>
        <!-- Payment icons -->
        <div style="margin-top:20px;">
          <div class="footer-heading" style="margin-bottom:12px;">Thanh toán</div>
          <div style="display:flex;gap:8px;flex-wrap:wrap;">
            <span style="padding:5px 12px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);border-radius:6px;font-size:11px;font-weight:700;color:rgba(255,255,255,.5);">VISA</span>
            <span style="padding:5px 12px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);border-radius:6px;font-size:11px;font-weight:700;color:rgba(255,255,255,.5);">MasterCard</span>
            <span style="padding:5px 12px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);border-radius:6px;font-size:11px;font-weight:700;color:rgba(255,255,255,.5);">Momo</span>
            <span style="padding:5px 12px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);border-radius:6px;font-size:11px;font-weight:700;color:rgba(255,255,255,.5);">COD</span>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-divider"></div>
    <div class="footer-bottom">
      <span>&copy; 2026 Shoe4U. All rights reserved.</span>
      <div class="footer-bottom-links">
        <a href="index.php?controller=page&action=privacy"><i class="fas fa-shield-halved"></i> Chính sách bảo mật</a>
        <a href="index.php?controller=page&action=terms"><i class="fas fa-file-contract"></i> Điều khoản sử dụng</a>
        <span style="color:rgba(255,255,255,.2);">Thiết kế với <i class="fas fa-heart" style="color:var(--blue);"></i> tại Việt Nam</span>
      </div>
    </div>
  </div>
</footer>

<button id="back-to-top" title="Lên đầu trang"><i class="fas fa-arrow-up"></i></button>
<script src="assets/js/script.js"></script>
<script>
window.addEventListener('scroll',()=>{document.getElementById('back-to-top')?.classList.toggle('show',window.scrollY>400);});
document.getElementById('back-to-top')?.addEventListener('click',()=>window.scrollTo({top:0,behavior:'smooth'}));
</script>
</body>
</html>