<style>
/* ========== BLOG DETAIL ========== */
.blog-detail{padding:44px 0 72px;}
.back-link{display:inline-flex;align-items:center;gap:8px;color:var(--blue);font-size:13px;font-weight:600;margin-bottom:24px;}
.back-link:hover{text-decoration:underline;}
.detail-card{background:#fff;border-radius:var(--r-xl);border:1px solid var(--fog);overflow:hidden;box-shadow:var(--shadow-xs);}
.detail-image{height:400px;overflow:hidden;}
.detail-image img{width:100%;height:100%;object-fit:cover;}
.detail-content{padding:36px;}
.detail-meta{display:flex;align-items:center;gap:20px;margin-bottom:24px;padding-bottom:16px;border-bottom:1px solid var(--fog);}
.detail-date{font-size:13px;color:var(--mist);display:flex;align-items:center;gap:6px;}
.detail-title{font-family:'Playfair Display',serif;font-size:36px;color:var(--ink);margin-bottom:24px;line-height:1.2;}
.detail-body{font-size:15px;color:var(--steel);line-height:1.85;}
.detail-body p{margin-bottom:18px;}
.related-section{margin-top:48px;}
.related-title{font-family:'Playfair Display',serif;font-size:24px;color:var(--ink);margin-bottom:24px;padding-bottom:12px;border-bottom:2px solid var(--blue-light);}
.related-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;}
.related-card{background:#fff;border-radius:var(--r-lg);border:1px solid var(--fog);overflow:hidden;transition:var(--t);}
.related-card:hover{transform:translateY(-4px);box-shadow:var(--shadow);}
.related-img{height:140px;overflow:hidden;}
.related-img img{width:100%;height:100%;object-fit:cover;}
.related-content{padding:16px;}
.related-content h4{font-size:14px;font-weight:700;color:var(--ink);margin-bottom:8px;line-height:1.4;}
.related-content h4 a:hover{color:var(--blue-mid);}
.related-date{font-size:11px;color:var(--mist);}
@media(max-width:768px){
    .detail-image{height:250px;}
    .detail-content{padding:24px;}
    .detail-title{font-size:28px;}
    .related-grid{grid-template-columns:repeat(2,1fr);}
}
@media(max-width:480px){
    .related-grid{grid-template-columns:1fr;}
}
</style>

<div class="blog-detail">
    <div class="container" style="max-width:900px;">
        <a href="index.php?controller=post&action=index" class="back-link">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách bài viết
        </a>

        <div class="detail-card">
            <?php if (!empty($post['thumbnail']) && file_exists('uploads/posts/' . $post['thumbnail'])): ?>
            <div class="detail-image">
                <img src="uploads/posts/<?= htmlspecialchars($post['thumbnail']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
            </div>
            <?php endif; ?>
            
            <div class="detail-content">
                <div class="detail-meta">
                    <span class="detail-date"><i class="far fa-calendar-alt"></i> <?= date('d/m/Y H:i', strtotime($post['created_at'])) ?></span>
                </div>
                <h1 class="detail-title"><?= htmlspecialchars($post['title']) ?></h1>
                <div class="detail-body">
                    <?= nl2br(htmlspecialchars($post['content'])) ?>
                </div>
            </div>
        </div>

        <?php if (!empty($related_posts)): ?>
        <div class="related-section">
            <h3 class="related-title"><i class="fas fa-eye" style="color:var(--blue);margin-right:8px;"></i> Bài viết liên quan</h3>
            <div class="related-grid">
                <?php foreach ($related_posts as $rp): ?>
                <div class="related-card">
                    <div class="related-img">
                        <?php if (!empty($rp['thumbnail']) && file_exists('uploads/posts/' . $rp['thumbnail'])): ?>
                        <img src="uploads/posts/<?= htmlspecialchars($rp['thumbnail']) ?>" alt="<?= htmlspecialchars($rp['title']) ?>">
                        <?php else: ?>
                        <img src="assets/images/banner1.jpg" alt="<?= htmlspecialchars($rp['title']) ?>">
                        <?php endif; ?>
                    </div>
                    <div class="related-content">
                        <h4><a href="index.php?controller=post&action=detail&id=<?= $rp['post_id'] ?>"><?= htmlspecialchars($rp['title']) ?></a></h4>
                        <div class="related-date"><i class="far fa-calendar-alt"></i> <?= date('d/m/Y', strtotime($rp['created_at'])) ?></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>