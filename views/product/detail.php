<?php if (!isset($product) || empty($product)): ?>
<div class="container" style="padding:80px 0;text-align:center;">
    <i class="fas fa-box-open" style="font-size:48px;color:var(--fog);"></i>
    <p style="margin-top:16px;color:var(--mist);">Không tìm thấy sản phẩm</p>
</div>
<?php return; endif; ?>

<style>
/* BREADCRUMB */
.bc-bar{background:#fff;border-bottom:1px solid var(--fog);padding:14px 0;}
.bc-inner{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--mist);}
.bc-inner a{color:var(--mist);transition:color .2s;}
.bc-inner a:hover{color:var(--blue-mid);}
.bc-inner i{font-size:9px;}

/* DETAIL LAYOUT */
.detail-page{padding:44px 0 80px;}
.detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:start;}

/* IMAGE GALLERY */
.detail-img-container{position:sticky;top:96px;}
.detail-img-main{
    border-radius:24px;overflow:hidden;background:var(--blue-pale);
    aspect-ratio:1;border:1px solid var(--fog);position:relative;
}
.detail-img-main img{width:100%;height:100%;object-fit:cover;}
.detail-img-badge{position:absolute;top:18px;left:18px;z-index:2;}
.thumbnail-images{
    display:flex;gap:10px;margin-top:12px;overflow-x:auto;
}
.thumbnail-images img{
    width:70px;height:70px;border-radius:12px;object-fit:cover;
    cursor:pointer;border:2px solid var(--fog);transition:all .2s;
}
.thumbnail-images img:hover,
.thumbnail-images img.active{border-color:var(--blue);}

/* VARIANT SELECTION */
.variant-section{margin-bottom:24px;}
.variant-section h3{font-size:15px;font-weight:700;color:var(--ink);margin-bottom:12px;}
.variant-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;}
.variant-select{
    width:100%;padding:12px;border:1.5px solid var(--fog);border-radius:12px;
    font-size:14px;background:#fff;cursor:pointer;
}
.variant-select:focus{border-color:var(--blue);outline:none;}
#stockInfo{
    background:#f8f9fa;border-left:4px solid var(--blue);padding:12px 16px;
    border-radius:8px;font-size:13px;margin-top:12px;display:none;
}
#stockInfo .in-stock{color:#15803d;font-weight:700;}
#stockInfo .out-stock{color:#dc2626;font-weight:700;}

/* REVIEWS */
.reviews-section{margin-top:40px;padding-top:32px;border-top:1px solid var(--fog);}
.review-item{padding:16px 0;border-bottom:1px solid var(--fog);}
.review-item:last-child{border-bottom:none;}
.review-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;}
.review-name{font-weight:700;color:var(--ink);}
.review-stars{color:var(--gold);font-size:12px;}
.review-comment{color:var(--steel);font-size:14px;line-height:1.6;margin-bottom:6px;}
.review-date{font-size:11px;color:var(--mist);}

/* INFO */
.detail-brand{font-size:11px;font-weight:700;color:var(--blue);letter-spacing:1.5px;text-transform:uppercase;margin-bottom:8px;}
.detail-name{font-family:'DM Serif Display',serif;font-size:32px;color:var(--ink);line-height:1.2;margin-bottom:16px;}
.detail-tags{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:24px;}
.detail-tag{
    padding:5px 14px;border-radius:20px;font-size:12px;font-weight:600;
    background:var(--blue-pale);color:var(--blue-mid);border:1px solid rgba(91,191,234,.25);
}
.detail-price-wrap{
    background:linear-gradient(135deg,var(--blue-pale),#EBF6FD);
    border:1px solid rgba(91,191,234,.25);border-radius:var(--r-lg);
    padding:20px 22px;margin-bottom:24px;
}
.detail-price{font-family:'DM Serif Display',serif;font-size:42px;color:var(--blue-mid);}
.detail-desc{
    font-size:14px;color:var(--steel);line-height:1.85;
    padding:18px 20px;background:#fff;border-radius:var(--r-lg);
    border:1px solid var(--fog);border-left-width:3px;border-left-color:var(--blue);
    margin-bottom:24px;
}
.detail-actions{display:flex;gap:12px;flex-wrap:wrap;margin-bottom:28px;}
.detail-actions .btn-primary{flex:1;justify-content:center;padding:15px;font-size:15px;}
.detail-meta{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
.meta-card{
    background:#fff;border:1px solid var(--fog);border-radius:var(--r-lg);
    padding:14px 16px;display:flex;align-items:center;gap:12px;
}
.meta-icon{
    width:38px;height:38px;border-radius:11px;
    background:var(--blue-pale);color:var(--blue-mid);font-size:15px;
    display:flex;align-items:center;justify-content:center;
}
.meta-text h5{font-size:12.5px;font-weight:700;color:var(--ink);}
.meta-text p{font-size:11.5px;color:var(--mist);}

/* RELATED */
.related-section{padding:64px 0 0;border-top:1px solid var(--fog);}
.related-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-top:40px;}

@media(max-width:900px){
    .detail-grid{grid-template-columns:1fr;}
    .detail-img-container{position:static;}
    .related-grid{grid-template-columns:repeat(2,1fr);}
}
@media(max-width:480px){
    .related-grid{grid-template-columns:1fr;}
    .detail-meta{grid-template-columns:1fr;}
}
</style>

<!-- BREADCRUMB -->
<div class="bc-bar">
    <div class="container">
        <div class="bc-inner">
            <a href="index.php">Trang chủ</a>
            <i class="fas fa-chevron-right"></i>
            <a href="index.php?controller=product&action=category">Sản phẩm</a>
            <i class="fas fa-chevron-right"></i>
            <span><?= htmlspecialchars($product['product_name']) ?></span>
        </div>
    </div>
</div>

<div class="detail-page">
    <div class="container">
        <div class="detail-grid">
            
            <!-- LEFT: IMAGE GALLERY -->
            <div class="detail-img-container">
                <div class="detail-img-main">
                    <?php 
                    $mainImage = !empty($productImages) ? $productImages[0]['image_url'] : $product['image_url'];
                    ?>
                    <img id="mainImage" src="assets/images/products/<?= $mainImage ?>" 
                         alt="<?= htmlspecialchars($product['product_name']) ?>"
                         onerror="this.src='assets/images/banner1.jpg'">
                    <?php if($product['is_best_seller']): ?>
                    <div class="detail-img-badge">
                        <span class="product-badge badge-hot"><i class="fas fa-fire"></i> Bán chạy</span>
                    </div>
                    <?php endif; ?>
                </div>
                
                <?php if (!empty($productImages) && count($productImages) > 1): ?>
                <div class="thumbnail-images" id="thumbnailGallery">
                    <?php foreach ($productImages as $index => $img): ?>
                    <img src="assets/images/products/<?= $img['image_url'] ?>" 
                         alt="Thumbnail <?= $index+1 ?>"
                         onclick="changeMainImage('<?= $img['image_url'] ?>', this)"
                         class="<?= $index === 0 ? 'active' : '' ?>"
                         onerror="this.style.display='none'">
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- RIGHT: PRODUCT INFO -->
            <div class="detail-info">
                <div class="detail-brand"><?= htmlspecialchars($product['brand'] ?? 'Shoe4U') ?></div>
                <h1 class="detail-name"><?= htmlspecialchars($product['product_name']) ?></h1>
                
                <div class="detail-tags">
                    <span class="detail-tag"><i class="fas fa-folder"></i> <?= htmlspecialchars($product['category_name'] ?? '') ?></span>
                    <span class="detail-tag"><i class="fas fa-user"></i> <?= $product['gender'] ?? 'Unisex' ?></span>
                    <span class="detail-tag"><i class="fas fa-map-marker-alt"></i> <?= $product['origin'] ?? 'Việt Nam' ?></span>
                </div>

                <div class="detail-price-wrap">
                    <div class="detail-price"><?= number_format($product['price']) ?><span style="font-size:22px;">đ</span></div>
                </div>

                <!-- VARIANT SELECTION (từ Source 1) -->
                <?php if (!empty($productVariants)): ?>
                <div class="variant-section">
                    <h3>Chọn size và màu</h3>
                    <div class="variant-row">
                        <select id="sizeSelect" class="variant-select">
                            <option value="">Chọn size</option>
                            <?php 
                            $sizes = array_unique(array_column($productVariants, 'size'));
                            sort($sizes);
                            foreach ($sizes as $size): 
                            ?>
                            <option value="<?= $size ?>">Size <?= $size ?></option>
                            <?php endforeach; ?>
                        </select>
                        
                        <select id="colorSelect" class="variant-select">
                            <option value="">Chọn màu</option>
                            <?php 
                            $colors = array_unique(array_column($productVariants, 'color'));
                            foreach ($colors as $color): 
                            ?>
                            <option value="<?= $color ?>"><?= $color ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div id="stockInfo"></div>
                </div>
                <?php endif; ?>

                <div class="detail-desc">
                    <?= nl2br(htmlspecialchars($product['description'] ?? 'Sản phẩm chính hãng, chất lượng cao cấp.')) ?>
                </div>

                <div class="detail-actions">
                    <button class="btn-primary" id="addCartBtn" disabled>
                        <i class="fas fa-cart-plus"></i> Thêm vào giỏ hàng
                    </button>
                    <a href="javascript:void(0)" class="btn-outline" id="buyNowBtn" style="pointer-events:none;opacity:0.5;">
                        <i class="fas fa-bolt"></i> Mua ngay
                    </a>
                </div>

                <div class="detail-meta">
                    <div class="meta-card"><div class="meta-icon"><i class="fas fa-truck-fast"></i></div><div class="meta-text"><h5>Miễn phí vận chuyển</h5><p>Đơn từ 500.000đ</p></div></div>
                    <div class="meta-card"><div class="meta-icon"><i class="fas fa-shield-halved"></i></div><div class="meta-text"><h5>Bảo hành 12 tháng</h5><p>Chính hãng</p></div></div>
                    <div class="meta-card"><div class="meta-icon"><i class="fas fa-arrow-rotate-left"></i></div><div class="meta-text"><h5>Đổi trả 30 ngày</h5><p>Miễn phí đổi size</p></div></div>
                    <div class="meta-card"><div class="meta-icon"><i class="fas fa-award"></i></div><div class="meta-text"><h5>Hàng chính hãng</h5><p>100% authentic</p></div></div>
                </div>
            </div>
        </div>

        <!-- REVIEWS (từ Source 1) -->
        <?php if (!empty($productReviews)): ?>
        <div class="reviews-section">
            <h3 style="font-size:20px;margin-bottom:20px;"><i class="fas fa-star" style="color:var(--gold);"></i> Đánh giá sản phẩm (<?= count($productReviews) ?>)</h3>
            <?php foreach ($productReviews as $review): ?>
            <div class="review-item">
                <div class="review-header">
                    <span class="review-name"><?= htmlspecialchars($review['full_name']) ?></span>
                    <span class="review-stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fas fa-star" style="color:<?= $i <= $review['rating'] ? '#ffc107' : '#e0e0e0' ?>"></i>
                        <?php endfor; ?>
                    </span>
                </div>
                <div class="review-comment"><?= nl2br(htmlspecialchars($review['comment'])) ?></div>
                <div class="review-date"><?= date('d/m/Y H:i', strtotime($review['created_at'])) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <!-- RELATED PRODUCTS -->
        <?php if (!empty($relatedProducts)): ?>
        <div class="related-section">
            <div class="section-label"><i class="fas fa-sparkles"></i> Gợi ý cho bạn</div>
            <h2 class="section-title" style="font-size:28px;">Sản phẩm liên quan</h2>
            <div class="related-grid">
                <?php foreach ($relatedProducts as $rp): ?>
                <div class="product-card">
                    <a href="index.php?controller=product&action=detail&id=<?= $rp['product_id'] ?>">
                        <div class="product-image-wrap">
                            <img src="assets/images/products/<?= $rp['image_url'] ?>" alt="<?= htmlspecialchars($rp['product_name']) ?>" onerror="this.src='assets/images/banner1.jpg'">
                        </div>
                    </a>
                    <div class="product-info">
                        <div class="product-name"><?= htmlspecialchars($rp['product_name']) ?></div>
                        <div class="product-price-row"><span class="price-main"><?= number_format($rp['price']) ?>đ</span></div>
                        <button class="btn-add-cart" onclick="addToCartRelated(<?= $rp['product_id'] ?>, this)"><i class="fas fa-cart-plus"></i> Thêm vào giỏ</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
// Product variants data
const productVariants = <?= json_encode($productVariants) ?>;
let currentVariant = null;

// Change main image
function changeMainImage(imageUrl, element) {
    document.getElementById('mainImage').src = 'assets/images/products/' + imageUrl;
    document.querySelectorAll('.thumbnail-images img').forEach(img => {
        img.classList.remove('active');
    });
    element.classList.add('active');
}

// Update stock info
function updateStockInfo() {
    const sizeSelect = document.getElementById('sizeSelect');
    const colorSelect = document.getElementById('colorSelect');
    const stockInfo = document.getElementById('stockInfo');
    const addCartBtn = document.getElementById('addCartBtn');
    const buyNowBtn = document.getElementById('buyNowBtn');
    
    const selectedSize = sizeSelect.value;
    const selectedColor = colorSelect.value;
    
    if (selectedSize && selectedColor && productVariants.length > 0) {
        const variant = productVariants.find(v => 
            v.size == selectedSize && v.color === selectedColor
        );
        
        if (variant) {
            currentVariant = variant;
            if (variant.stock > 0) {
                stockInfo.innerHTML = `<i class="fas fa-check-circle" style="color:#15803d;"></i> <span class="in-stock">Còn ${variant.stock} sản phẩm trong kho</span>`;
                stockInfo.style.display = 'block';
                stockInfo.style.background = '#f0fdf4';
                stockInfo.style.borderLeftColor = '#15803d';
                addCartBtn.disabled = false;
                addCartBtn.style.opacity = '1';
                buyNowBtn.style.pointerEvents = 'auto';
                buyNowBtn.style.opacity = '1';
                buyNowBtn.onclick = () => buyNow(variant.variant_id);
                addCartBtn.onclick = () => addToCartDetail(variant.variant_id);
            } else {
                stockInfo.innerHTML = `<i class="fas fa-times-circle" style="color:#dc2626;"></i> <span class="out-stock">Hết hàng</span>`;
                stockInfo.style.display = 'block';
                stockInfo.style.background = '#fef2f2';
                stockInfo.style.borderLeftColor = '#dc2626';
                addCartBtn.disabled = true;
                addCartBtn.style.opacity = '0.5';
                buyNowBtn.style.pointerEvents = 'none';
                buyNowBtn.style.opacity = '0.5';
                currentVariant = null;
            }
        } else {
            stockInfo.innerHTML = `<i class="fas fa-exclamation-triangle"></i> Không có biến thể này`;
            stockInfo.style.display = 'block';
            stockInfo.style.background = '#fffbeb';
            stockInfo.style.borderLeftColor = '#f59e0b';
            addCartBtn.disabled = true;
            addCartBtn.style.opacity = '0.5';
            buyNowBtn.style.pointerEvents = 'none';
            buyNowBtn.style.opacity = '0.5';
            currentVariant = null;
        }
    } else {
        stockInfo.style.display = 'none';
        addCartBtn.disabled = true;
        addCartBtn.style.opacity = '0.5';
        buyNowBtn.style.pointerEvents = 'none';
        buyNowBtn.style.opacity = '0.5';
        currentVariant = null;
    }
}

// Add to cart
function addToCartDetail(variantId) {
    <?php if (isset($_SESSION['user_id'])): ?>
    const btn = document.getElementById('addCartBtn');
    const originalHTML = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang thêm...';
    btn.disabled = true;
    
    fetch('index.php?controller=cart&action=add', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `variant_id=${variantId}&quantity=1`
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            btn.innerHTML = '<i class="fas fa-check"></i> Đã thêm!';
            btn.style.background = '#15803d';
            const cartCount = document.getElementById('cart-count');
            if (cartCount) cartCount.textContent = data.total_quantity || data.item_count || 0;
            setTimeout(() => {
                btn.innerHTML = originalHTML;
                btn.style.background = '';
                btn.disabled = false;
            }, 2000);
        } else {
            btn.innerHTML = originalHTML;
            btn.disabled = false;
            alert(data.message || 'Thêm thất bại!');
        }
    })
    .catch(() => {
        btn.innerHTML = originalHTML;
        btn.disabled = false;
        alert('Có lỗi xảy ra!');
    });
    <?php else: ?>
    if (confirm('Bạn cần đăng nhập để thêm vào giỏ hàng. Đăng nhập ngay?')) {
        window.location = 'index.php?controller=auth&action=login';
    }
    <?php endif; ?>
}

// Buy now
function buyNow(variantId) {
    <?php if (isset($_SESSION['user_id'])): ?>
    addToCartDetail(variantId);
    setTimeout(() => {
        window.location.href = 'index.php?controller=order&action=checkout';
    }, 500);
    <?php else: ?>
    if (confirm('Bạn cần đăng nhập để mua hàng. Đăng nhập ngay?')) {
        window.location = 'index.php?controller=auth&action=login';
    }
    <?php endif; ?>
}

// Add to cart for related products
function addToCartRelated(productId, btn) {
    <?php if (isset($_SESSION['user_id'])): ?>
    const originalHTML = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    btn.disabled = true;
    
    fetch('index.php?controller=cart&action=add', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `variant_id=1&quantity=1`
    })
    .then(res => res.json())
    .then(data => {
        btn.innerHTML = '<i class="fas fa-check"></i> Đã thêm';
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.disabled = false;
        }, 1500);
        const cartCount = document.getElementById('cart-count');
        if (cartCount) cartCount.textContent = data.total_quantity || data.item_count || 0;
    })
    .catch(() => {
        btn.innerHTML = originalHTML;
        btn.disabled = false;
    });
    <?php else: ?>
    if (confirm('Bạn cần đăng nhập!')) window.location = 'index.php?controller=auth&action=login';
    <?php endif; ?>
}

// Event listeners
document.getElementById('sizeSelect')?.addEventListener('change', updateStockInfo);
document.getElementById('colorSelect')?.addEventListener('change', updateStockInfo);

// Initialize
updateStockInfo();
</script>