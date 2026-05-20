<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../layouts/auth_check.php';
require_once '../../../config/functions.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE product_id = $product_id"));

if (!$product) {
    header('Location: index.php');
    exit();
}

// Xử lý upload ảnh - DÙNG ĐƯỜNG DẪN TƯƠNG ĐỐI
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['images'])) {
    // Đường dẫn từ file hiện tại đến thư mục uploads
    $upload_dir = __DIR__ . '/../../../assets/images/products/';
    
    // Tạo thư mục nếu chưa có
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    $files = $_FILES['images'];
    $success_count = 0;
    
    for($i = 0; $i < count($files['name']); $i++) {
        if($files['error'][$i] == 0) {
            // Lấy đuôi file
            $file_ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
            // Tạo tên file an toàn
            $file_name = time() . '_' . $product_id . '_' . $i . '.' . $file_ext;
            $file_path = $upload_dir . $file_name;
            
            if(move_uploaded_file($files['tmp_name'][$i], $file_path)) {
                mysqli_query($conn, "INSERT INTO product_images (product_id, image_url) VALUES ($product_id, '$file_name')");
                $success_count++;
            }
        }
    }
    
    $_SESSION['success'] = "Đã upload $success_count ảnh thành công";
    header("Location: images.php?id=$product_id");
    exit();
}

// Xử lý xóa ảnh - DÙNG ĐƯỜNG DẪN TƯƠNG ĐỐI
if (isset($_GET['delete_image'])) {
    $image_id = $_GET['delete_image'];
    $image = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM product_images WHERE image_id = $image_id"));
    
    if($image) {
        $file_path = __DIR__ . '/../../../assets/images/products/' . $image['image_url'];
        if(file_exists($file_path)) {
            unlink($file_path);
        }
        mysqli_query($conn, "DELETE FROM product_images WHERE image_id = $image_id");
    }
    
    header("Location: images.php?id=$product_id");
    exit();
}

$images = mysqli_query($conn, "SELECT * FROM product_images WHERE product_id = $product_id");

include '../layouts/header.php';
include '../layouts/sidebar.php';
?>

<div class="content-header">
    <h1>Quản lý ảnh: <?php echo $product['product_name']; ?></h1>
    <a href="variants.php?id=<?php echo $product_id; ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Quay lại
    </a>
</div>

<?php if(isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<!-- Form upload ảnh -->
<div class="card">
    <div class="card-header">
        <h3>Upload ảnh sản phẩm</h3>
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Chọn ảnh (có thể chọn nhiều):</label>
                <input type="file" name="images[]" multiple accept="image/*" required class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-upload"></i> Upload
            </button>
        </form>
    </div>
</div>

<!-- Danh sách ảnh -->
<div class="card mt-3">
    <div class="card-header">
        <h3>Ảnh sản phẩm (<?php echo mysqli_num_rows($images); ?>)</h3>
    </div>
    <div class="card-body">
        <div class="image-gallery">
            <?php if(mysqli_num_rows($images) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($images)): ?>
                <div class="image-item">
                    <img src="../../assets/images/products/<?php echo $row['image_url']; ?>" 
                         alt="Product Image"
                         style="width: 100%; height: 150px; object-fit: cover;">
                    <div class="image-actions">
                        <a href="?id=<?php echo $product_id; ?>&delete_image=<?php echo $row['image_id']; ?>" 
                           class="btn-delete-image"
                           onclick="return confirm('Xóa ảnh này?')">
                            <i class="fas fa-trash"></i>
                        </a>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center">Chưa có ảnh nào</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../layouts/footer.php'; ?>