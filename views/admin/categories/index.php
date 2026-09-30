<?php
require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';

$categories = mysqli_query($conn, "SELECT c.*, COUNT(p.product_id) as product_count 
                                    FROM categories c
                                    LEFT JOIN products p ON c.category_id = p.category_id
                                    GROUP BY c.category_id
                                    ORDER BY c.category_name");

include '../layouts/header.php';
include '../layouts/sidebar.php';
?>

<div class="content-header">
    <h1>Quản lý danh mục</h1>
    <a href="add.php" class="btn btn-primary">
        <i class="fas fa-plus"></i> Thêm danh mục
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th>Số sản phẩm</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($categories)): ?>
                <tr>
                    <td>#<?php echo $row['category_id']; ?></td>
                    <td><strong><?php echo $row['category_name']; ?></strong></td>
                    <td><?php echo $row['description']; ?></td>
                    <td>
                        <span class="badge badge-info"><?php echo $row['product_count']; ?> sản phẩm</span>
                    </td>
                    <td class="actions">
                        <a href="edit.php?id=<?php echo $row['category_id']; ?>" class="btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <?php if($row['product_count'] == 0): ?>
                        <a href="delete.php?id=<?php echo $row['category_id']; ?>" 
                           class="btn-sm btn-danger"
                           onclick="return confirm('Xóa danh mục này?')">
                            <i class="fas fa-trash"></i>
                        </a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>