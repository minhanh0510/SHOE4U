<style>
.post-detail-page{padding:60px 0;background:var(--snow);}
.post-detail-page .container{max-width:820px;margin:0 auto;}
.post-detail-page h1{font-family:'DM Serif Display',serif;font-size:34px;color:var(--ink);margin-bottom:16px;}
.post-meta{font-size:13px;color:var(--mist);margin-bottom:24px;display:flex;gap:20px;}
.post-detail-page .featured-img{width:100%;max-height:400px;object-fit:cover;border-radius:16px;margin-bottom:30px;border:1px solid var(--fog);}
.post-content{font-size:16px;line-height:1.9;color:var(--steel);}
.post-content p{margin-bottom:20px;}
.back-link{display:inline-flex;align-items:center;gap:8px;color:var(--blue);font-weight:700;margin-bottom:24px;}
.back-link:hover{color:var(--blue-mid);}
</style>

<div class="post-detail-page">
    <div class="container">
        <a href="index.php?controller=post&action=index" class="back-link">
            <i class="fas fa-arrow-left"></i> Quay lại danh sách
        </a>
        
        <h1><?= htmlspecialchars($post['title']) ?></h1>
        <div class="post-meta">
            <span><i class="fas fa-calendar-alt"></i> <?= date('d/m/Y H:i', strtotime($post['created_at'])) ?></span>
        </div>
        
        <?php if ($post['thumbnail']): ?>
        <img src="assets/images/posts/<?= $post['thumbnail'] ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="featured-img" onerror="this.src='assets/images/no-image.png'">
        <?php endif; ?>
        
        <div class="post-content">
            <?= nl2br(htmlspecialchars($post['content'])) ?>
        </div>
    </div>
</div>