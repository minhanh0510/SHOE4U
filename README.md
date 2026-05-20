Shoe4U là một ứng dụng web bán giày dép trực tuyến được xây dựng bằng PHP thuần (không framework) theo mô hình MVC. Hệ thống hỗ trợ đầy đủ các chức năng của một cửa hàng thương mại điện tử: quản lý sản phẩm (kèm biến thể size – màu), giỏ hàng, đặt hàng (COD + Momo giả lập), quản trị viên, thống kê doanh thu, bài viết tin tức, đánh giá sản phẩm, và phân quyền người dùng.

Tính năng nổi bật
Khách hàng (Customer)
- Đăng ký / Đăng nhập / Đăng xuất (hỗ trợ cả plaintext và bcrypt)
- Xem danh sách sản phẩm, lọc theo danh mục, giá, sắp xếp, tìm kiếm
- Xem chi tiết sản phẩm, chọn size/màu, kiểm tra tồn kho
- Thêm sản phẩm vào giỏ hàng (AJAX real-time)
- Cập nhật số lượng, xóa sản phẩm khỏi giỏ hàng
- Đặt hàng với hai phương thức thanh toán: COD và Momo (giả lập quét QR)
- Xem lịch sử đơn hàng, lọc theo trạng thái
- Xem chi tiết đơn hàng, timeline trạng thái
- Đánh giá sản phẩm (sao và bình luận)
Quản trị viên (Admin)
- Dashboard thống kê tổng quan (số sản phẩm, đơn hàng, người dùng, doanh thu)
- Quản lý sản phẩm: thêm, sửa, xóa, upload ảnh, quản lý biến thể (size, màu, tồn kho)
- Quản lý danh mục
- Quản lý đơn hàng: xem chi tiết, cập nhật trạng thái (Pending → Shipping → Completed / Cancelled)
- Quản lý người dùng: sửa thông tin, xóa (tự động xóa dữ liệu liên quan)
- Quản lý bài viết (tin tức, hướng dẫn)
- Thống kê nâng cao: doanh thu theo ngày/tháng/quý/năm, sản phẩm bán chạy, xuất Excel
- Bảo vệ route bằng session và kiểm tra quyền `role = admin`

Công nghệ sử dụng
Thành phần	Công nghệ
Backend	PHP 7.4+ (hỗ trợ cả mysqli và PDO)
Database 	MySQL (MariaDB)
Frontend 	HTML5, CSS3, JavaScript (thuần + Fetch API)
CSS Framework 	Tự viết (Outfit + Playfair Display)
Chart 	Chart.js
Icons 	Font Awesome 6
AJAX	Fetch API (cập nhật giỏ hàng, thêm sản phẩm)
Session	PHP native session

Cấu trúc thư mục chính
Shoe4U/
├── assets/                CSS, JS, images (products, category, banners)
├── config/                database.php (mysqli + PDO), functions.php
├── controllers/           Các controller xử lý logic
├── models/                Các model tương tác database
├── views/                 Template frontend & admin
│   ├── admin/             Khu vực quản trị
│   ├── auth/              Đăng nhập, đăng ký
│   ├── cart/              Giỏ hàng
│   ├── home/              Trang chủ
│   ├── order/             Thanh toán, lịch sử, chi tiết
│   ├── product/           Danh sách sản phẩm, chi tiết
│   └── layouts/           header, footer, sidebar chung
├── uploads/               Ảnh bài viết (posts)
├── .htaccess              (tuỳ chọn) rewrite URL
├── index.php              Front controller duy nhất
├── shoe_shop_setup.sql    File khởi tạo database + dữ liệu mẫu
└── README.md

 Yêu cầu hệ thống
- Web Server: Apache / Nginx (hoặc XAMPP/WAMP)
- PHP: Phiên bản 7.4 trở lên (bật extension `mysqli`, `pdo_mysql`, `gd`)
- MySQL: 5.7+ hoặc MariaDB 10.4+
- Trình duyệt: Chrome, Firefox, Edge (hỗ trợ ES6)

 📥 Hướng dẫn cài đặt
 1. Clone hoặc tải source code
Đặt toàn bộ source code vào thư mục gốc của web server (ví dụ: `htdocs/Shoe4U`).
 2. Tạo database
Import file `shoe_shop_setup.sql` vào phpMyAdmin hoặc dùng dòng lệnh:
bash
mysql -u root -p < shoe_shop_setup.sql
File này sẽ tạo database `shoe_shop` cùng tất cả bảng và dữ liệu mẫu.
 3. Cấu hình kết nối database
Mở file `config/database.php` và sửa thông số kết nối phù hợp:
php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');       // mật khẩu của bạn
define('DB_NAME', 'shoe_shop');
4. Cấu hình đường dẫn (nếu cần)
Trong file `views/admin/layouts/auth_check.php` có hằng số `ADMIN_URL`. Nếu bạn đặt project ở thư mục không phải `Shoe4U_1`, hãy sửa lại cho đúng.
 5. Chạy ứng dụng
Truy cập vào đường dẫn:  
`http://localhost/Shoe4U/
Tài khoản mẫu
Vai trò	Email             	Mật khẩu   
Admin  	admin@gmail.com	123456
Customer	b@gmail.com	123456

Mật khẩu trong database đang lưu dạng plaintext (demo). Khi triển khai thực tế, nên băm mật khẩu bằng `password_hash()`.
Cách kiểm thử thanh toán Momo (giả lập)
- Khi đặt hàng, chọn phương thức Momo.
- Hệ thống hiển thị mã QR giả và thông báo `success = true` ngay lập tức.
- Đơn hàng được tạo với trạng thái thanh toán `Paid`.
- (Đây là demo, không kết nối thực tế với Momo API.)
Tính năng thống kê (Admin)
- Dashboard: biểu đồ tròn trạng thái đơn hàng, top 5 sản phẩm bán chạy, 5 đơn gần nhất.
- Thống kê doanh thu: theo ngày / tháng / quý / năm, kèm biểu đồ cột.
- Sản phẩm bán chạy: lọc theo khoảng thời gian, xuất Excel.
- Xuất Excel doanh thu hoặc top sản phẩm.
Lưu ý bảo mật & cải tiến (khi đưa lên production)
Hiện tại dự án đang ở giai đoạn demo / phát triển. Để sẵn sàng chạy thực tế, cần thực hiện các bước sau:
-  Chuyển toàn bộ truy vấn sang Prepared Statement (PDO) để tránh SQL injection.
-  Băm mật khẩu bằng `password_hash()` và xóa mật khẩu plaintext trong file SQL.
-  Thêm CSRF token cho các form (đăng nhập, đặt hàng, xóa sản phẩm).
-  Kiểm tra và giới hạn kích thước, loại file khi upload ảnh.
-  Tái cấu trúc thư mục (tách `public/` làm document root).
-  Thêm logging và xử lý lỗi tập trung.
Giấy phép
Dự án được phát triển với mục đích học tập và tham khảo. Bạn có thể tự do sửa đổi và phân phối lại với điều kiện giữ nguyên thông tin tác giả.
  Tác giả & hỗ trợ
Được phát triển bởi Shoe4U Team.  
Mọi đóng góp, báo lỗi vui lòng tạo issue hoặc liên hệ qua email: `support@shoe4u.vn` (demo).
Chúc bạn trải nghiệm thành công với Shoe4U – Đôi giày của phong cách! 

