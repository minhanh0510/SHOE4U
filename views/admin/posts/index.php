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
    <h1>Quản lý bài viết</h1>
    <a href="add.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm bài viết
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ảnh</th>
                    <th>Tiêu đề</th>
                    <th>Ngày đăng</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($posts) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($posts)): ?>
                    <tr>
                        <td>#<?php echo $row['post_id']; ?></td>
                        <td>
                            <?php if($row['thumbnail']): ?>
                                <!-- ĐƯỜNG DẪN TƯƠNG ĐỐI GIỐNG PRODUCTS -->
                                <img src="../../../assets/images/posts/<?php echo $row['thumbnail']; ?>" 
                                     width="60" height="60" style="object-fit: cover; border-radius: 4px;">
                            <?php else: ?>
                                <img src="../../../assets/images/no-image.png" width="60" height="60" style="object-fit: cover; border-radius: 4px;">
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?php echo htmlspecialchars($row['title']); ?></strong>
                        </td>
                        <td><?php echo formatDate($row['created_at']); ?></td>
                        <td class="actions" style="white-space: nowrap;">
                            <a href="edit.php?id=<?php echo $row['post_id']; ?>" class="btn-sm btn-warning" title="Sửa">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="delete.php?id=<?php echo $row['post_id']; ?>" 
                               class="btn-sm btn-danger" 
                               title="Xóa"
                               onclick="return confirm('Xóa bài viết này?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Không có bài viết nào</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>