<style>
.post-list-page{padding:60px 0;background:var(--snow);}
.post-list-page h1{font-family:'DM Serif Display',serif;font-size:36px;text-align:center;margin-bottom:12px;}
.post-list-page .sub{text-align:center;color:var(--mist);margin-bottom:40px;}
.post-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:30px;}
.post-card{background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,0.06);transition:all .3s;border:1px solid var(--fog);}
.post-card:hover{transform:translateY(-6px);box-shadow:0 12px 36px rgba(0,0,0,0.1);}
.post-card img{width:100%;height:220px;object-fit:cover;}
.post-card-body{padding:22px 24px 26px;}
.post-card-body h3{font-family:'DM Serif Display',serif;font-size:20px;margin-bottom:10px;}
.post-card-body h3 a{color:var(--ink);text-decoration:none;}
.post-card-body h3 a:hover{color:var(--blue-mid);}
.post-card-body .meta{font-size:12px;color:var(--mist);margin-bottom:12px;display:flex;gap:16px;}
.post-card-body .excerpt{color:var(--steel);line-height:1.7;margin-bottom:16px;}
.post-card-body .read-more{color:var(--blue);font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:6px;}
.post-card-body .read-more:hover{color:var(--blue-mid);}
.empty-posts{text-align:center;padding:80px 20px;background:#fff;border-radius:20px;border:1px solid var(--fog);}
.empty-posts i{font-size:48px;color:var(--fog);margin-bottom:16px;}
</style>

<div class="post-list-page">
    <div class="container">
        <h1><i class="fas fa-newspaper"></i> Bài viết về chúng tôi</h1>
        <p class="sub">Những câu chuyện, tin tức và chia sẻ từ Shoe4U</p>
        
        <?php if (empty($posts)): ?>
        <div class="empty-posts">
            <i class="fas fa-file-alt"></i>
            <p>Chưa có bài viết nào. Quay lại sau nhé!</p>
        </div>
        <?php else: ?>
        <div class="post-grid">
            <?php foreach ($posts as $p): ?>
            <div class="post-card">
                <?php if ($p['thumbnail']): ?>
                <img src="assets/images/posts/<?= $p['thumbnail'] ?>" alt="<?= htmlspecialchars($p['title']) ?>" onerror="this.src='assets/images/no-image.png'">
                <?php else: ?>
                <img src="assets/images/no-image.png" alt="No image">
                <?php endif; ?>
                <div class="post-card-body">
                    <h3><a href="index.php?controller=post&action=detail&id=<?= $p['post_id'] ?>"><?= htmlspecialchars($p['title']) ?></a></h3>
                    <div class="meta">
                        <span><i class="fas fa-calendar-alt"></i> <?= date('d/m/Y', strtotime($p['created_at'])) ?></span>
                    </div>
                    <div class="excerpt">
                        <?= htmlspecialchars(mb_substr($p['content'], 0, 120)) ?>...
                    </div>
                    <a href="index.php?controller=post&action=detail&id=<?= $p['post_id'] ?>" class="read-more">
                        Đọc tiếp <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>