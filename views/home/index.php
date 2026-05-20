<style>
/* ── HERO ── */
.hero{position:relative;height:580px;overflow:hidden;}
.hero-slider{display:flex;height:100%;transition:transform .75s cubic-bezier(.4,0,.2,1);will-change:transform;}
.hero-slide{min-width:100%;position:relative;height:100%;}
.hero-slide img{width:100%;height:100%;object-fit:cover;}
.hero-slide::after{content:'';position:absolute;inset:0;background:linear-gradient(105deg,rgba(10,22,40,.85) 0%,rgba(10,22,40,.5) 50%,rgba(10,22,40,.1) 100%);}
.hero-content{position:absolute;top:50%;left:0;right:0;transform:translateY(-50%);z-index:2;}
.hero-inner{max-width:580px;}
.hero-eyebrow{
  display:inline-flex;align-items:center;gap:8px;
  padding:7px 16px;
  background:rgba(91,191,234,.15);border:1px solid rgba(91,191,234,.4);
  border-radius:30px;backdrop-filter:blur(10px);
  color:#fff;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;
  margin-bottom:22px;
}
.hero-eyebrow i{color:var(--blue);}
.hero-title{
  font-family:'DM Serif Display',serif;
  font-size:58px;font-weight:400;color:#fff;line-height:1.05;margin-bottom:18px;
}
.hero-title .hl{
  color:var(--blue-mid);
  font-style:italic;
}
.hero-sub{font-size:16px;color:rgba(255,255,255,.7);margin-bottom:36px;line-height:1.75;max-width:460px;}
.hero-btns{display:flex;gap:14px;flex-wrap:wrap;}
.hero-btn-ghost{
  display:inline-flex;align-items:center;gap:8px;
  padding:13px 26px;
  background:rgba(255,255,255,.1);border:1.5px solid rgba(255,255,255,.3);
  border-radius:50px;color:#fff;font-size:14px;font-weight:600;
  backdrop-filter:blur(8px);transition:all .22s;
}
.hero-btn-ghost:hover{background:rgba(255,255,255,.2);border-color:rgba(255,255,255,.5);}
/* Stats in hero */
.hero-stats{
  position:absolute;bottom:32px;left:0;right:0;z-index:3;
}
.hero-stats-inner{display:flex;gap:0;max-width:420px;}
.hero-stat{
  flex:1;padding:16px 20px;
  background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);
  backdrop-filter:blur(12px);text-align:center;
}
.hero-stat:first-child{border-radius:14px 0 0 14px;}
.hero-stat:last-child{border-radius:0 14px 14px 0;}
.hero-stat-num{font-family:'DM Serif Display',serif;font-size:22px;color:#fff;display:block;}
.hero-stat-lbl{font-size:10px;color:rgba(255,255,255,.5);font-weight:600;letter-spacing:1px;text-transform:uppercase;}
/* Controls */
.hero-controls{position:absolute;right:32px;top:50%;transform:translateY(-50%);display:flex;flex-direction:column;gap:8px;z-index:10;}
.hero-arrow{width:42px;height:42px;border-radius:12px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);color:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:13px;backdrop-filter:blur(10px);transition:all .2s;}
.hero-arrow:hover{background:var(--blue);border-color:var(--blue);}
.hero-dots{position:absolute;bottom:32px;right:32px;display:flex;gap:7px;z-index:10;}
.hero-dot{width:8px;height:8px;border-radius:50%;background:rgba(255,255,255,.3);cursor:pointer;transition:all .3s;}
.hero-dot.active{width:24px;border-radius:4px;background:var(--blue);}

/* ── FEATURES STRIP ── */
.features-strip{background:#fff;border-bottom:1px solid var(--fog);padding:0;}
.features-grid{display:grid;grid-template-columns:repeat(4,1fr);}
.feature-item{
  display:flex;align-items:center;gap:16px;
  padding:22px 28px;border-right:1px solid var(--fog);
  transition:background .2s;
}
.feature-item:last-child{border-right:none;}
.feature-item:hover{background:var(--blue-pale);}
.feature-icon-wrap{
  width:48px;height:48px;border-radius:14px;flex-shrink:0;
  background:linear-gradient(135deg,var(--blue-light),#DCF0FA);
  color:var(--blue-mid);font-size:20px;
  display:flex;align-items:center;justify-content:center;
}
.feature-text h4{font-size:13.5px;font-weight:700;color:var(--ink);}
.feature-text p{font-size:12px;color:var(--mist);margin-top:2px;}

/* ── CATEGORIES ── */
.categories-section{padding:80px 0 0;}
.cat-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:16px;margin-top:48px;}
.cat-card{
  position:relative;border-radius:20px;overflow:hidden;height:300px;
  cursor:pointer;border:1px solid var(--fog);display:block;
  transition:all .3s;
}
.cat-card img{width:100%;height:100%;object-fit:cover;transition:transform .55s cubic-bezier(.4,0,.2,1);}
.cat-card:hover img{transform:scale(1.08);}
.cat-card::after{content:'';position:absolute;inset:0;background:linear-gradient(to top,rgba(10,22,40,.9) 0%,rgba(10,22,40,.2) 55%,transparent 100%);}
.cat-card:hover{border-color:var(--blue);box-shadow:0 16px 48px rgba(91,191,234,.25);transform:translateY(-4px);}
.cat-body{position:absolute;bottom:0;left:0;right:0;padding:22px 18px;z-index:2;}
.cat-name{font-family:'DM Serif Display',serif;font-size:16px;color:#fff;margin-bottom:3px;}
.cat-count{font-size:11px;color:rgba(255,255,255,.55);margin-bottom:14px;font-weight:500;}
.cat-cta{
  display:inline-flex;align-items:center;gap:6px;
  padding:6px 14px;background:var(--blue);color:#fff;
  border-radius:20px;font-size:11px;font-weight:700;
  opacity:0;transform:translateY(8px);transition:all .25s;
}
.cat-card:hover .cat-cta{opacity:1;transform:translateY(0);}

/* ── PRODUCT SECTIONS ── */
.products-section{padding:80px 0;}
.product-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:22px;}
.view-more{text-align:center;margin-top:48px;}

/* TABS for products */
.tab-bar{display:flex;align-items:center;justify-content:center;gap:8px;margin-bottom:44px;}
.tab-btn{
  padding:10px 22px;border-radius:50px;border:1.5px solid var(--fog);
  font-size:13.5px;font-weight:600;color:var(--steel);
  background:#fff;cursor:pointer;transition:all .22s;
}
.tab-btn.active,.tab-btn:hover{
  background:linear-gradient(135deg,var(--blue),var(--blue-mid));
  color:#fff;border-color:transparent;
  box-shadow:0 4px 16px rgba(91,191,234,.35);
}

/* ── PROMO BANNER ── */
.promo-section{padding:0 0 80px;}
.promo-card{
  position:relative;overflow:hidden;border-radius:28px;
  background:linear-gradient(130deg,var(--ink) 0%,var(--ink2) 55%,#0D2840 100%);
  padding:68px 64px;
  display:grid;grid-template-columns:1fr auto;align-items:center;gap:48px;
}
.promo-card::before{content:'';position:absolute;top:-100px;right:80px;width:520px;height:520px;border-radius:50%;background:radial-gradient(circle,rgba(91,191,234,.14) 0%,transparent 68%);}
.promo-card::after{content:'';position:absolute;bottom:-80px;left:40px;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle,rgba(91,191,234,.07) 0%,transparent 68%);}
.promo-inner{position:relative;z-index:1;}
.promo-eyebrow{font-size:11px;font-weight:700;letter-spacing:2.5px;text-transform:uppercase;color:var(--blue);margin-bottom:12px;display:flex;align-items:center;gap:8px;}
.promo-eyebrow::before{content:'';width:24px;height:2px;background:var(--blue);border-radius:1px;}
.promo-title{font-family:'DM Serif Display',serif;font-size:46px;color:#fff;line-height:1.1;margin-bottom:14px;}
.promo-title span{color:var(--blue-mid);font-style:italic;}
.promo-sub{font-size:15px;color:rgba(255,255,255,.58);margin-bottom:28px;max-width:440px;line-height:1.75;}
.promo-tags{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:32px;}
.promo-tag{
  padding:6px 16px;border-radius:20px;font-size:12px;font-weight:700;
  background:rgba(91,191,234,.12);border:1px solid rgba(91,191,234,.3);color:var(--blue-mid);
  display:flex;align-items:center;gap:6px;
}
.promo-side{position:relative;z-index:1;text-align:center;}
.promo-percent{
  font-family:'DM Serif Display',serif;font-size:110px;
  color:rgba(91,191,234,.12);line-height:1;letter-spacing:-6px;
  position:absolute;right:-16px;top:-40px;pointer-events:none;
  white-space:nowrap;
}
.promo-stat-card{
  background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);
  border-radius:20px;padding:28px 36px;text-align:center;position:relative;z-index:1;
  min-width:190px;
}
.promo-stat-num{font-family:'DM Serif Display',serif;font-size:42px;color:var(--blue-mid);display:block;line-height:1;}
.promo-stat-lbl{font-size:12px;color:rgba(255,255,255,.45);font-weight:600;letter-spacing:.5px;margin-top:6px;display:block;}
.promo-timer{display:flex;gap:10px;justify-content:center;margin-top:16px;}
.timer-block{text-align:center;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:10px;padding:8px 14px;}
.timer-block .t-num{font-family:'DM Serif Display',serif;font-size:22px;color:#fff;line-height:1;display:block;}
.timer-block .t-lbl{font-size:9px;color:rgba(255,255,255,.4);font-weight:700;letter-spacing:1px;text-transform:uppercase;}

/* ── BRANDS ── */
.brands-section{background:#fff;border-top:1px solid var(--fog);border-bottom:1px solid var(--fog);padding:56px 0;}
.brands-grid{display:flex;align-items:center;justify-content:center;gap:0;flex-wrap:wrap;margin-top:40px;}
.brand-item{
  flex:1;min-width:140px;text-align:center;
  padding:20px 24px;border-right:1px solid var(--fog);
  transition:background .22s;
}
.brand-item:last-child{border-right:none;}
.brand-item:hover{background:var(--blue-pale);}
.brand-name{
  font-family:'Plus Jakarta Sans',sans-serif;font-size:17px;font-weight:800;
  color:var(--fog);letter-spacing:1.5px;transition:color .22s;
}
.brand-item:hover .brand-name{color:var(--blue-mid);}

/* ── NEWSLETTER ── */
.newsletter-section{
  background:linear-gradient(135deg,var(--blue-pale) 0%,#EBF6FD 100%);
  border-top:1px solid var(--fog);border-bottom:1px solid var(--fog);
  padding:56px 0;
}
.newsletter-inner{display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:center;}
.newsletter-left h3{font-family:'DM Serif Display',serif;font-size:30px;color:var(--ink);margin-bottom:8px;}
.newsletter-left p{font-size:14.5px;color:var(--steel);}
.newsletter-form{display:flex;gap:10px;}
.newsletter-form input{
  flex:1;padding:13px 20px;
  background:#fff;border:1.5px solid var(--fog);
  border-radius:50px;font-size:14px;color:var(--ink);
  outline:none;transition:all .22s;
}
.newsletter-form input:focus{border-color:var(--blue);box-shadow:0 0 0 4px rgba(91,191,234,.12);}
.newsletter-form input::placeholder{color:var(--mist);}

/* RESPONSIVE */
@media(max-width:1024px){.cat-grid{grid-template-columns:repeat(3,1fr);}.product-grid{grid-template-columns:repeat(3,1fr);}}
@media(max-width:768px){
  .hero{height:480px;}.hero-title{font-size:38px;}
  .features-grid{grid-template-columns:repeat(2,1fr);}.feature-item{border-right:none;border-bottom:1px solid var(--fog);}
  .cat-grid{grid-template-columns:repeat(2,1fr);}.product-grid{grid-template-columns:repeat(2,1fr);}
  .promo-card{grid-template-columns:1fr;padding:40px 28px;gap:24px;}.promo-title{font-size:32px;}
  .brands-grid{flex-wrap:wrap;}.brand-item{min-width:calc(33.333% - 1px);}
  .newsletter-inner{grid-template-columns:1fr;}
  .hero-controls{display:none;}
  .hero-stats-inner{display:none;}
}
@media(max-width:480px){.product-grid{grid-template-columns:1fr;}.cat-grid{grid-template-columns:1fr 1fr;}.brand-item{min-width:50%;}}
</style>

<!-- ═══ HERO ═══ -->
<section class="hero">
  <div class="hero-slider" id="heroSlider">
    <?php foreach ($banners as $i => $banner): ?>
    <div class="hero-slide">
      <img src="assets/images/<?= $banner['image'] ?>" alt="<?= $banner['title'] ?>" onerror="this.src='assets/images/banner1.jpg'">
      <div class="hero-content">
        <div class="container">
          <div class="hero-inner">
            <div class="hero-eyebrow"><i class="fas fa-star"></i> Bộ sưu tập mới 2026</div>
            <h1 class="hero-title"><?= $banner['title'] ?><br><span class="hl">Premium.</span></h1>
            <p class="hero-sub"><?= $banner['subtitle'] ?></p>
            <div class="hero-btns">
              <a href="<?= $banner['link'] ?>" class="btn-primary"><i class="fas fa-bag-shopping"></i> Mua ngay</a>
              <a href="index.php?controller=product&action=category" class="hero-btn-ghost"><i class="fas fa-arrow-right"></i> Xem bộ sưu tập</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <div class="container">
    <div class="hero-stats">
      <div class="hero-stats-inner">
        <div class="hero-stat"><span class="hero-stat-num">5K+</span><span class="hero-stat-lbl">Sản phẩm</span></div>
        <div class="hero-stat"><span class="hero-stat-num">50K+</span><span class="hero-stat-lbl">Khách hàng</span></div>
        <div class="hero-stat"><span class="hero-stat-num">4.9★</span><span class="hero-stat-lbl">Đánh giá</span></div>
      </div>
    </div>
  </div>
  <div class="hero-controls">
    <button class="hero-arrow" id="heroPrev"><i class="fas fa-chevron-up"></i></button>
    <button class="hero-arrow" id="heroNext"><i class="fas fa-chevron-down"></i></button>
  </div>
  <div class="hero-dots" id="heroDots"></div>
</section>

<!-- ═══ FEATURES ═══ -->
<div class="features-strip">
  <div class="features-grid">
    <div class="feature-item">
      <div class="feature-icon-wrap"><i class="fas fa-truck-fast"></i></div>
      <div class="feature-text"><h4>Miễn phí vận chuyển</h4><p>Đơn hàng từ 500.000đ</p></div>
    </div>
    <div class="feature-item">
      <div class="feature-icon-wrap"><i class="fas fa-shield-halved"></i></div>
      <div class="feature-text"><h4>Bảo hành chính hãng</h4><p>12 tháng toàn quốc</p></div>
    </div>
    <div class="feature-item">
      <div class="feature-icon-wrap"><i class="fas fa-arrow-rotate-left"></i></div>
      <div class="feature-text"><h4>Đổi trả dễ dàng</h4><p>30 ngày miễn phí</p></div>
    </div>
    <div class="feature-item">
      <div class="feature-icon-wrap"><i class="fas fa-headset"></i></div>
      <div class="feature-text"><h4>Hỗ trợ 24/7</h4><p>Tư vấn tận tâm</p></div>
    </div>
  </div>
</div>

<!-- ═══ CATEGORIES ═══ -->
<section class="categories-section">
  <div class="container">
    <div class="section-head">
      <div class="section-label"><i class="fas fa-grid-2"></i> Danh mục</div>
      <h2 class="section-title">Khám phá theo phong cách</h2>
      <p class="section-sub">Tìm đôi giày hoàn hảo cho mọi dịp</p>
    </div>
    <div class="cat-grid">
      <?php foreach ($categories as $cat): ?>
      <a href="index.php?controller=product&action=category&category=<?= $cat['category_id'] ?>" class="cat-card">
        <img src="assets/images/category/<?= $cat['image'] ?>" alt="<?= $cat['category_name'] ?>" onerror="this.src='assets/images/banner1.jpg'">
        <div class="cat-body">
          <div class="cat-name"><?= $cat['category_name'] ?></div>
          <div class="cat-count"><?= $cat['product_count'] ?> sản phẩm</div>
          <span class="cat-cta"><i class="fas fa-arrow-right"></i> Xem ngay</span>
        </div>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══ BEST SELLERS ═══ -->
<section class="products-section">
  <div class="container">
    <div class="section-head">
      <div class="section-label"><i class="fas fa-fire"></i> Bán chạy nhất</div>
      <h2 class="section-title">Sản phẩm được yêu thích</h2>
      <p class="section-sub">Những đôi giày được khách hàng lựa chọn nhiều nhất tháng này</p>
    </div>
    <div class="product-grid">
      <?php foreach ($bestSellers as $p): ?>
      <div class="product-card">
        <span class="product-badge badge-hot"><i class="fas fa-fire"></i> Hot</span>
        <span class="product-badge badge-sale" style="left:auto;right:14px;top:14px;">-10%</span>
        <div class="product-actions">
          <a href="index.php?controller=product&action=detail&id=<?= $p['product_id'] ?>" class="action-btn" title="Xem chi tiết"><i class="fas fa-eye"></i></a>
          <button class="action-btn" onclick="addToCart(<?= $p['product_id'] ?>,event)" title="Thêm yêu thích"><i class="fas fa-heart"></i></button>
        </div>
        <a href="index.php?controller=product&action=detail&id=<?= $p['product_id'] ?>">
          <div class="product-image-wrap">
            <img src="assets/images/products/<?= $p['image_url'] ?>" alt="<?= htmlspecialchars($p['product_name']) ?>" onerror="this.src='assets/images/banner1.jpg'">
          </div>
        </a>
        <div class="product-info">
          <div class="product-brand"><?= htmlspecialchars($p['brand'] ?? $p['category_name'] ?? 'Shoe4U') ?></div>
          <div class="product-name"><?= htmlspecialchars($p['product_name']) ?></div>
          <div class="product-rating"><span class="stars">★★★★★</span><span class="rating-num">(4.9)</span></div>
          <div class="product-price-row">
            <span class="price-main"><?= number_format($p['sale_price'] ?? $p['price']) ?>đ</span>
            <?php if (isset($p['sale_price'])): ?><span class="price-old"><?= number_format($p['price']) ?>đ</span><?php endif; ?>
          </div>
          <button class="btn-add-cart" onclick="addToCart(<?= $p['product_id'] ?>,event)"><i class="fas fa-cart-plus"></i> Thêm vào giỏ</button>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="view-more">
      <a href="index.php?controller=product&action=category" class="btn-outline"><i class="fas fa-grid-2"></i> Xem tất cả sản phẩm</a>
    </div>
  </div>
</section>

<!-- ═══ PROMO BANNER ═══ -->
<section class="promo-section">
  <div class="container">
    <div class="promo-card">
      <div class="promo-inner">
        <div class="promo-eyebrow">Ưu đãi đặc biệt</div>
        <h2 class="promo-title">Sale lớn<br><span>Hè 2026</span></h2>
        <p class="promo-sub">Giảm giá lên đến 30% cho tất cả sản phẩm giày thể thao, sneaker cao cấp. Chương trình có thời hạn!</p>
        <div class="promo-tags">
          <span class="promo-tag"><i class="fas fa-tag"></i> Giảm đến 30%</span>
          <span class="promo-tag"><i class="fas fa-truck"></i> Free ship</span>
          <span class="promo-tag"><i class="fas fa-rotate-left"></i> Đổi trả 30 ngày</span>
        </div>
        <a href="index.php?controller=product&action=category&category=3" class="btn-primary" style="font-size:15px;padding:14px 32px;">
          <i class="fas fa-bolt"></i> Mua ngay — Ưu đãi tốt nhất
        </a>
      </div>
      <div class="promo-side">
        <div class="promo-percent">30%</div>
        <div class="promo-stat-card">
          <span class="promo-stat-num">500+</span>
          <span class="promo-stat-lbl">Sản phẩm sale</span>
          <div class="promo-timer" id="countdown">
            <div class="timer-block"><span class="t-num" id="t-h">02</span><span class="t-lbl">Giờ</span></div>
            <div class="timer-block"><span class="t-num" id="t-m">45</span><span class="t-lbl">Phút</span></div>
            <div class="timer-block"><span class="t-num" id="t-s">30</span><span class="t-lbl">Giây</span></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ═══ NEW ARRIVALS ═══ -->
<section class="products-section" style="padding-top:0;">
  <div class="container">
    <div class="section-head">
      <div class="section-label"><i class="fas fa-sparkles"></i> Mới về</div>
      <h2 class="section-title">Sản phẩm mới nhất</h2>
      <p class="section-sub">Cập nhật liên tục những mẫu giày trendy nhất mùa này</p>
    </div>
    <div class="product-grid">
      <?php foreach ($newProducts as $p): ?>
      <div class="product-card">
        <span class="product-badge badge-new">✦ Mới</span>
        <div class="product-actions">
          <a href="index.php?controller=product&action=detail&id=<?= $p['product_id'] ?>" class="action-btn"><i class="fas fa-eye"></i></a>
          <button class="action-btn" onclick="addToCart(<?= $p['product_id'] ?>,event)"><i class="fas fa-heart"></i></button>
        </div>
        <a href="index.php?controller=product&action=detail&id=<?= $p['product_id'] ?>">
          <div class="product-image-wrap">
            <img src="assets/images/products/<?= $p['image_url'] ?>" alt="<?= htmlspecialchars($p['product_name']) ?>" onerror="this.src='assets/images/banner1.jpg'">
          </div>
        </a>
        <div class="product-info">
          <div class="product-brand"><?= htmlspecialchars($p['brand'] ?? $p['category_name'] ?? 'Shoe4U') ?></div>
          <div class="product-name"><?= htmlspecialchars($p['product_name']) ?></div>
          <div class="product-rating"><span class="stars">★★★★☆</span><span class="rating-num">(4.7)</span></div>
          <div class="product-price-row">
            <span class="price-main"><?= number_format($p['price']) ?>đ</span>
          </div>
          <button class="btn-add-cart" onclick="addToCart(<?= $p['product_id'] ?>,event)"><i class="fas fa-cart-plus"></i> Thêm vào giỏ</button>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ═══ BRANDS ═══ -->
<section class="brands-section">
  <div class="container">
    <div class="section-head" style="margin-bottom:0;">
      <div class="section-label"><i class="fas fa-certificate"></i> Thương hiệu</div>
      <h2 class="section-title" style="font-size:28px;">Hàng chính hãng 100%</h2>
    </div>
    <div class="brands-grid">
      <div class="brand-item"><div class="brand-name">NIKE</div></div>
      <div class="brand-item"><div class="brand-name">ADIDAS</div></div>
      <div class="brand-item"><div class="brand-name">PUMA</div></div>
      <div class="brand-item"><div class="brand-name">VANS</div></div>
      <div class="brand-item"><div class="brand-name">CONVERSE</div></div>
      <div class="brand-item" style="border-right:none;"><div class="brand-name">NEW BALANCE</div></div>
    </div>
  </div>
</section>

<!-- ═══ NEWSLETTER ═══ -->
<section class="newsletter-section">
  <div class="container">
    <div class="newsletter-inner">
      <div class="newsletter-left">
        <h3>Đăng ký nhận<br>ưu đãi độc quyền</h3>
        <p>Nhận thông báo về sản phẩm mới, khuyến mãi và xu hướng thời trang mới nhất.</p>
      </div>
      <div>
        <div class="newsletter-form">
          <input type="email" placeholder="Nhập địa chỉ email của bạn...">
          <button class="btn-primary" type="button"><i class="fas fa-paper-plane"></i> Đăng ký</button>
        </div>
        <p style="font-size:12px;color:var(--mist);margin-top:10px;"><i class="fas fa-lock" style="color:var(--blue);"></i> Chúng tôi tôn trọng quyền riêng tư của bạn. Không spam!</p>
      </div>
    </div>
  </div>
</section>

<script>
// Hero Slider
(function(){
  const slider=document.getElementById('heroSlider');
  const dotsEl=document.getElementById('heroDots');
  if(!slider)return;
  const slides=slider.children;
  const n=slides.length;
  let cur=0,timer;
  for(let i=0;i<n;i++){
    const d=document.createElement('div');d.className='hero-dot'+(i===0?' active':'');
    d.onclick=()=>go(i);dotsEl.appendChild(d);
  }
  function go(i){
    cur=(i+n)%n;
    slider.style.transform=`translateX(-${cur*100}%)`;
    document.querySelectorAll('.hero-dot').forEach((d,j)=>d.classList.toggle('active',j===cur));
  }
  function autoPlay(){clearInterval(timer);timer=setInterval(()=>go(cur+1),5200);}
  document.getElementById('heroNext')?.addEventListener('click',()=>{go(cur+1);autoPlay();});
  document.getElementById('heroPrev')?.addEventListener('click',()=>{go(cur-1);autoPlay();});
  go(0);autoPlay();
})();

// Countdown timer
(function(){
  let h=2,m=45,s=30;
  setInterval(()=>{
    if(s>0)s--;else if(m>0){m--;s=59;}else if(h>0){h--;m=59;s=59;}
    document.getElementById('t-h').textContent=String(h).padStart(2,'0');
    document.getElementById('t-m').textContent=String(m).padStart(2,'0');
    document.getElementById('t-s').textContent=String(s).padStart(2,'0');
  },1000);
})();

// Add to cart
function addToCart(productId,event){
  <?php if (isset($_SESSION['user_id'])): ?>
  const btn=event.currentTarget;
  const orig=btn.innerHTML;
  btn.innerHTML='<i class="fas fa-spinner fa-spin"></i> Đang thêm...';
  btn.disabled=true;
  fetch('index.php?controller=cart&action=add',{method:'POST',headers:{'Content-Type':'application/x-www-form-urlencoded'},body:`variant_id=1&quantity=1`})
  .then(r=>r.json()).then(d=>{
    btn.innerHTML='<i class="fas fa-check"></i> Đã thêm!';
    btn.style.background='var(--success)';btn.style.color='#fff';btn.style.borderColor='transparent';
    const c=document.getElementById('cart-count');if(c)c.textContent=d.cart_count||0;
    setTimeout(()=>{btn.innerHTML=orig;btn.style.background='';btn.style.color='';btn.style.borderColor='';btn.disabled=false;},2000);
  }).catch(()=>{btn.innerHTML=orig;btn.disabled=false;});
  <?php else: ?>
  if(confirm('Bạn cần đăng nhập để thêm vào giỏ hàng. Đăng nhập ngay?'))window.location='index.php?controller=auth&action=login';
  <?php endif; ?>
}
</script>
