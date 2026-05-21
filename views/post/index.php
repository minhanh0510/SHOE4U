<style>
/* ========== BLOG PAGE ========== */
.blog-page{padding:44px 0 72px;}
.blog-header{text-align:center;margin-bottom:48px;}
.blog-header h1{font-family:'Playfair Display',serif;font-size:42px;color:var(--ink);margin-bottom:12px;}
.blog-header p{font-size:16px;color:var(--mist);max-width:600px;margin:0 auto;}
.blog-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:30px;}
.blog-card{background:#fff;border-radius:var(--r-xl);overflow:hidden;border:1px solid var(--fog);transition:var(--t);}
.blog-card:hover{transform:translateY(-6px);box-shadow:var(--shadow);border-color:rgba(75,184,240,.3);}
.blog-image{height:220px;overflow:hidden;position:relative;}
.blog-image img{width:100%;height:100%;object-fit:cover;transition:transform .5s ease;}
.blog-card:hover .blog-image img{transform:scale(1.05);}
.blog-date{position:absolute;bottom:12px;left:12px;background:rgba(0,0,0,.7);backdrop-filter:blur(4px);padding:4px 12px;border-radius:20px;font-size:11px;color:#fff;font-weight:500;}
.blog-content{padding:22px;}
.blog-title{font-family:'Playfair Display',serif;font-size:18px;font-weight:700;color:var(--ink);margin-bottom:10px;line-height:1.4;}
.blog-title a:hover{color:var(--blue-mid);}
.blog-excerpt{font-size:14px;color:var(--steel);line-height:1.65;margin-bottom:16px;}
.blog-readmore{display:inline-flex;align-items:center;gap:6px;color:var(--blue);font-size:13px;font-weight:600;text-decoration:none;}
.blog-readmore:hover{gap:10px;}
.empty-blog{text-align:center;padding:80px 20px;background:#fff;border-radius:var(--r-xl);border:1px solid var(--fog);}
.empty-blog i{font-size:56px;color:var(--fog);margin-bottom:16px;}
.empty-blog h3{font-size:22px;color:var(--ink);margin-bottom:8px;}
@media(max-width:992px){.blog-grid{grid-template-columns:repeat(2,1fr);}}
@media(max-width:576px){.blog-grid{grid-template-columns:1fr;}}
</style>

<div class="blog-page">
    <div class="container">
        <div class="blog-header">
            <h1><i class="fas fa-newspaper" style="color:var(--blue);margin-right:12px;"></i>Bài viết & Tin tức</h1>
            <p>Cập nhật những xu hướng thời trang mới nhất, cách phối đồ và bí quyết chọn giày phù hợp với phong cách của bạn.</p>
        </div>

        <?php if (empty($posts)): ?>
        <div class="empty-blog">
            <i class="fas fa-newspaper"></i>
            <h3>Chưa có bài viết nào</h3>
            <p>Hãy quay lại sau để đọc những bài viết thú vị nhé!</p>
            <a href="index.php" class="btn-primary" style="display:inline-flex;"><i class="fas fa-home"></i> Về trang chủ</a>
        </div>
        <?php else: ?>
        <div class="blog-grid">
            <?php foreach ($posts as $post): ?>
            <div class="blog-card">
                <div class="blog-image">
                    <?php if (!empty($post['thumbnail'])): ?>
                    <img src="uploads/posts/<?= htmlspecialchars($post['thumbnail']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
                    <?php else: ?>
                    <img src="assets/images/banner1.jpg" alt="<?= htmlspecialchars($post['title']) ?>">
                    <?php endif; ?>
                    <div class="blog-date"><i class="far fa-calendar-alt"></i> <?= date('d/m/Y', strtotime($post['created_at'])) ?></div>
                </div>
                <div class="blog-content">
                    <h3 class="blog-title"><a href="index.php?controller=post&action=detail&id=<?= $post['post_id'] ?>"><?= htmlspecialchars($post['title']) ?></a></h3>
                    <div class="blog-excerpt">
                        <?= htmlspecialchars(mb_substr(strip_tags($post['content']), 0, 120)) ?>...
                    </div>
                    <a href="index.php?controller=post&action=detail&id=<?= $post['post_id'] ?>" class="blog-readmore">
                        Đọc tiếp <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>