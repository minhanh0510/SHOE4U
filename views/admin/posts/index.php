<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';

$posts = mysqli_query($conn, "SELECT * FROM posts ORDER BY created_at DESC");

include '../layouts/header.php';
include '../layouts/sidebar.php';
?>

<div class="content-header">
    <h1><i class="fas fa-newspaper"></i> Quản lý bài viết</h1>
    <a href="add.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm bài viết
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="width: 60px; text-align: center;">ID</th>
                        <th style="width: 80px;">Ảnh</th>
                        <th style="width: auto;">Tiêu đề</th>
                        <th style="width: 170px;">Ngày đăng</th>
                        <th style="width: 140px; text-align: center;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($posts) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($posts)): ?>
                        <tr>
                            <td style="text-align: center; vertical-align: middle;">#<?php echo $row['post_id']; ?></td>
                            <td style="vertical-align: middle;">
                                <?php 
                                $thumbnail_path = '../../../uploads/posts/' . $row['thumbnail'];
                                if($row['thumbnail'] && file_exists($thumbnail_path)): 
                                ?>
                                <img src="<?php echo $thumbnail_path; ?>" 
                                     width="50" height="50" style="object-fit: cover; border-radius: 8px; display: block;">
                                <?php else: ?>
                                <img src="../../../assets/images/no-image.png" 
                                     width="50" height="50" style="object-fit: cover; border-radius: 8px; display: block;">
                                <?php endif; ?>
                            </td>
                            <td style="vertical-align: middle;">
                                <strong><?php echo htmlspecialchars($row['title']); ?></strong>
                            </td>
                            <td style="vertical-align: middle; white-space: nowrap;"><?php echo formatDate($row['created_at']); ?></td>
                            <td style="vertical-align: middle; text-align: center; white-space: nowrap;">
                                <a href="edit.php?id=<?php echo $row['post_id']; ?>" class="btn-sm btn-warning" title="Sửa" style="display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; text-decoration: none; border-radius: 6px;">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <a href="delete.php?id=<?php echo $row['post_id']; ?>" 
                                   class="btn-sm btn-danger" 
                                   title="Xóa"
                                   style="display: inline-flex; align-items: center; gap: 4px; padding: 5px 10px; text-decoration: none; border-radius: 6px;"
                                   onclick="return confirm('Xóa bài viết này?')">
                                    <i class="fas fa-trash"></i> Xóa
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px;">Không có bài viết nào</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>