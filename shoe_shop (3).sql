-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 20, 2026 lúc 05:56 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `shoe_shop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `carts`
--

CREATE TABLE `carts` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `carts`
--

INSERT INTO `carts` (`cart_id`, `user_id`, `created_at`) VALUES
(1, 2, '2026-02-04 23:56:15'),
(2, 3, '2026-02-04 23:56:15'),
(3, 4, '2026-02-04 23:56:15'),
(4, 5, '2026-02-04 23:56:15'),
(5, 2, '2026-02-04 23:56:15'),
(6, 1, '2026-03-26 00:37:54');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_item_id` int(11) NOT NULL,
  `cart_id` int(11) DEFAULT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart_items`
--

INSERT INTO `cart_items` (`cart_item_id`, `cart_id`, `variant_id`, `quantity`) VALUES
(3, 3, 4, 2),
(4, 4, 5, 1),
(5, 5, 2, 3),
(11, 2, 115, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `description`) VALUES
(1, 'Giày Da', 'Giày dành cho nam'),
(2, 'Cao Gót', 'Giày dành cho nữ'),
(3, 'Giày Thể Thao', 'Giày thể thao'),
(4, 'Dép', 'Dép đi trong nhà'),
(5, 'Dép Quai Hậu', 'Sandal thời trang');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` enum('Pending','Shipping','Completed','Cancelled') DEFAULT 'Pending',
  `shipping_address` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_price`, `status`, `shipping_address`, `created_at`) VALUES
(1, 2, 5000000.00, 'Completed', 'Hà Nội', '2026-02-04 23:56:25'),
(2, 3, 3200000.00, 'Completed', 'Đà Nẵng', '2026-02-04 23:56:25'),
(3, 4, 450000.00, 'Pending', 'Cần Thơ', '2026-02-04 23:56:25'),
(4, 5, 600000.00, 'Completed', 'Huế', '2026-02-04 23:56:25'),
(5, 2, 800000.00, 'Cancelled', 'TP HCM', '2026-02-04 23:56:25'),
(6, 3, 10200000.00, 'Completed', 'cccc', '2026-03-26 00:37:19');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `order_detail_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `variant_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`order_detail_id`, `order_id`, `variant_id`, `quantity`, `price`) VALUES
(1, 1, 1, 2, 2500000.00),
(2, 2, 3, 1, 3200000.00),
(3, 3, 4, 1, 450000.00),
(4, 4, 5, 1, 600000.00),
(5, 5, 2, 1, 800000.00),
(6, 6, 23, 1, 10200000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `method` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `method`, `status`, `paid_at`) VALUES
(1, 1, 'Momo', 'Paid', '2026-02-04 23:56:36'),
(2, 2, 'COD', 'Paid', '2026-03-26 00:39:08'),
(3, 3, 'Bank', 'Pending', NULL),
(4, 4, 'Momo', 'Paid', '2026-02-04 23:56:36'),
(5, 5, 'COD', 'Cancelled', NULL),
(6, 6, 'Momo', 'Paid', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `posts`
--

INSERT INTO `posts` (`post_id`, `title`, `content`, `thumbnail`, `created_at`) VALUES
(1, 'Giới thiệu shop', 'Shop chuyên giày chính hãng', 'post1.jpg', '2026-02-04 23:56:05'),
(2, 'Cách chọn size giày', 'Hướng dẫn chọn size', 'post2.jpg', '2026-02-04 23:56:05'),
(3, 'Xu hướng sneaker 2026', 'Các mẫu hot', 'post3.jpg', '2026-02-04 23:56:05'),
(4, 'Bảo quản giày', 'Mẹo giữ giày bền', 'post4.jpg', '2026-02-04 23:56:05'),
(5, 'Khuyến mãi tháng 3', 'Sale 30%', 'post5.jpg', '2026-02-04 23:56:05');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(200) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `gender` enum('Nam','Nữ','Unisex') DEFAULT NULL,
  `is_best_seller` tinyint(1) DEFAULT 0,
  `material` text DEFAULT NULL,
  `origin` varchar(100) DEFAULT NULL,
  `detailed_description` text DEFAULT NULL,
  `size_guide` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `price`, `description`, `category_id`, `brand`, `gender`, `is_best_seller`, `material`, `origin`, `detailed_description`, `size_guide`, `created_at`) VALUES
(1, 'Nike Air Force 1', 2500000.00, 'Giày thể thao Nike', 3, 'Nike', 'Unisex', 1, 'Da tổng hợp cao cấp và lưới thoáng khí', 'Việt Nam', 'Nike Air Force 1 là biểu tượng của văn hóa sneaker với thiết kế kinh điển từ năm 1982. Đế giày cao su bền bỉ với công nghệ Air cushioning mang lại sự thoải mái tối đa. Phù hợp cho cả nam và nữ, từ đi chơi hàng ngày đến phong cách streetwear.\n\nCAM KẾT CỦA SHOP\n\n- Sản phẩm chính hãng 100%, có tem mác và hóa đơn đầy đủ\n- Bảo hành 6 tháng cho các lỗi kỹ thuật từ nhà sản xuất\n- Hỗ trợ đổi trả trong 7 ngày nếu không hài lòng\n- Giao hàng tận nơi trên toàn quốc\n\nHƯỚNG DẪN BẢO QUẢN\n\n- Lau sạch bụi bẩn bằng khăn ẩm sau mỗi lần sử dụng\n- Để giày ở nơi khô ráo, tránh ánh nắng trực tiếp\n- Sử dụng dung dịch vệ sinh giày chuyên dụng để làm sạch', 'Bảng size Nike Air Force 1:\n- Size 39: Chiều dài bàn chân 24.5cm\n- Size 40: Chiều dài bàn chân 25cm\n- Size 41: Chiều dài bàn chân 25.5cm\n- Size 42: Chiều dài bàn chân 26cm\n- Size 43: Chiều dài bàn chân 26.5cm\n- Size 44: Chiều dài bàn chân 27cm', '2026-02-04 23:55:40'),
(2, 'Adidas UltraBoost', 3200000.00, 'Giày chạy bộ', 3, 'Adidas', 'Unisex', 1, 'Vải dệt kim Primeknit và đế Boost', 'Đức', 'Adidas UltraBoost mang đến trải nghiệm chạy bộ đỉnh cao với công nghệ Boost tiên tiến. Đế giày được làm từ hàng nghìn hạt Boost cung cấp năng lượng trả về vượt trội. Thiết kế ôm sát bàn chân với upper Primeknit co giãn hoàn hảo.\n\nĐẶC ĐIỂM NỔI BẬT\n\n- Công nghệ Boost: Trả về năng lượng 55% so với giày thông thường\n- Upper Primeknit: Thoáng khí và ôm sát bàn chân\n- Continental Rubber: Độ bám đường vượt trội\n- Phù hợp cho chạy bộ, tập gym và đi chơi hàng ngày\n\nCAM KẾT\n\n- Bảo hành 12 tháng cho công nghệ Boost\n- Hỗ trợ tư vấn size và fit chính xác\n- Miễn phí vận chuyển toàn quốc cho đơn hàng từ 2 triệu', 'Hướng dẫn chọn size Adidas:\n- Đo chiều dài bàn chân từ gót đến ngón cái dài nhất\n- Thêm 0.5-1cm cho độ rộng thoải mái\n- Size chart: 39 (24.5cm), 40 (25cm), 41 (25.5cm), 42 (26cm), 43 (26.5cm)', '2026-02-04 23:55:40'),
(3, 'Sandal Nữ Hàn Quốc', 450000.00, 'Sandal thời trang', 5, 'Local', 'Nữ', 0, 'Da PU cao cấp và quai dệt', 'Hàn Quốc', 'Sandal nữ Hàn Quốc với thiết kế thời trang, trẻ trung. Chất liệu da PU cao cấp bền đẹp, không gây kích ứng da. Thiết kế quai dệt tinh tế, dễ phối với nhiều trang phục từ công sở đến dạo phố.\n\nTHÔNG TIN SẢN PHẨM\n\n- Chất liệu: Da PU cao cấp, không mùi, không gây kích ứng\n- Đế: Cao su non chống trơn trượt\n- Màu sắc: Đen, trắng, nude\n- Kích cỡ: 35-40\n- Xuất xứ: Hàn Quốc\n\nCAM KẾT CỦA SHOP\n\n- Sản phẩm nhập khẩu chính hãng\n- Bảo hành keo dán 6 tháng\n- Hỗ trợ đổi trả size trong 7 ngày\n- Tư vấn phong cách mix & match', 'Bảng size sandal nữ:\n- Size 35: Chiều dài bàn chân 22cm\n- Size 36: Chiều dài bàn chân 22.5cm\n- Size 37: Chiều dài bàn chân 23cm\n- Size 38: Chiều dài bàn chân 23.5cm\n- Size 39: Chiều dài bàn chân 24cm\n- Size 40: Chiều dài bàn chân 24.5cm', '2026-02-04 23:55:40'),
(4, 'Dép Adidas Adilette', 600000.00, 'Dép nam', 4, 'Adidas', 'Nam', 0, 'Nhựa xốp EVA siêu nhẹ', 'Việt Nam', 'Dép đi trong nhà siêu nhẹ, êm chân. Với thiết kế kiểu dáng hiện đại, trẻ trung, phù hợp thông dụng cho nam và nữ. Chất liệu nhựa xốp siêu nhẹ EVA đi lại không gây tiếng động mạnh như dòng dép nhựa cứng, thích hợp đi trong nhà. Hoa văn kẻ sọc tạo điểm nhấn, đơn giản không cầu kì, dễ đi, có thể sử dụng cả ngoài trời đi dạo/trà chanh. Sản phẩm siêu nhẹ, tiện dụng dễ dàng mang đi du lịch, cắm trại.\n\nCAM KẾT\n\n- Shop cam kết bán sản phẩm chất lượng\n\n- Tất cả sản phẩm của shop đều được bọc kỹ trước khi gửi, nhưng trong quá trình vận chuyển rất có thể hộp sẽ bị móp méo, điều này shop không hề mong muốn và cũng không thể can thiệp được vào công việc vận chuyển của bên shopee, nên mong anh/chị thông cảm.\n\n- Tất cả sản phẩm shop đều hỗ trợ cho khách xem hàng, quý khách cứ bảo là shop cho kiểm tra hàng rồi shiper sẽ gọi cho shop.\n\n- Nến anh/chị nhận được sản phẩm lỗi hoặc do nhầm lẫn. Mong các bạn nhắn tin cho shop khắc phục trước khi đánh giá sản phẩm Dép bánh mì ạ\n\n❤ Shop cam kết sẽ luôn có trách nhiệm với sản phẩm đã bán ❤\n\nHƯỚNG DẪN BẢO QUẢN\n\nKhi mua dép về bạn nên ngâm vào trong nước muối nửa ngày rồi mới đi. Điều này sẽ giúp cho dép không bị nứt và bền hơn.', 'Bảng size Dép Adilette:\n- Size 38: Chiều dài bàn chân 24cm\n- Size 39: Chiều dài bàn chân 24.5cm\n- Size 40: Chiều dài bàn chân 25cm\n- Size 41: Chiều dài bàn chân 25.5cm\n- Size 42: Chiều dài bàn chân 26cm', '2026-02-04 23:55:40'),
(5, 'Giày Tây Nam', 800000.00, 'Giày công sở', 1, 'Local', 'Nam', 0, 'Da bò thật, đế cao su chống trượt', 'Việt Nam', 'Giày Tây Nam thanh lịch dành cho công sở, với thiết kế tối giản, sang trọng. Da bò thật mềm mịn, đế cao su chống trượt, đảm bảo đi êm và thoải mái cả ngày.\n\nCAM KẾT\n\n- Sản phẩm đạt tiêu chuẩn chất lượng, không bong keo, không thừa chỉ.\n- Hỗ trợ đổi trả trong 7 ngày nếu lỗi do nhà sản xuất.\n\nHƯỚNG DẪN BẢO QUẢN\n\n- Lau sạch bằng khăn mềm ẩm sau mỗi lần sử dụng.\n- Tránh tiếp xúc với nước trong thời gian dài.', 'Bảng size Giày Tây:\n- Size 39: 24.5cm\n- Size 40: 25cm\n- Size 41: 25.5cm\n- Size 42: 26cm\n- Size 43: 26.5cm', '2026-02-04 23:55:40'),
(6, 'Giày cao gót 5196-1  chất satin trên 7p của BIGTREE', 532000.00, '☑ Chất liệu : Chất tổng hợp, mềm mại bền đẹp lâu dài\r\n\r\n☑ Thiết kế hiện đại, tôn dáng và nâng cao sự tự tin\r\n\r\n☑ Lót đế êm ái, tạo cảm giác thoải mái cả ngày dài\r\n\r\n☑ Đế giày chống trượt, đảm bảo an toàn khi di chuyển\r\n\r\n☑ Chất liệu chống nước, dễ dàng làm sạch và bảo quản\r\n\r\n☑ Chân đế thiết kế chắc chắn, hỗ trợ giữ thăng bằng tốt\r\n\r\n☑ Đệm lót giày hỗ trợ tăng cường độ đàn hồi và giảm sốc', 2, 'BIGTREE', 'Unisex', 0, NULL, NULL, NULL, NULL, '2026-03-23 07:17:14'),
(7, 'Giày Manoloblahnik đính bướm ', 10200000.00, 'Khám phá bộ sưu tập mới nhất của Sororite Vintage là một hành trình tuyệt vời vào thế giới thời trang, nơi sự hoài cổ hòa quyện với vẻ thanh lịch hiện đại. Điều tôi nhận thấy là những đôi giày vintage của họ, đặc biệt là giày cao gót, mang vẻ đẹp vượt thời gian mà những người yêu thích đồ vintage luôn khao khát, khiến mỗi sản phẩm vừa thời trang vừa dễ mang trong thời đại ngày nay. Những đôi giày này thường gợi nhớ đến những nhà thiết kế huyền thoại như Manolo Blahnik, nổi tiếng với tay nghề thủ công và kiểu dáng cổ điển. Điểm nổi bật của Sororite Vintage là sự khéo léo trong việc sử dụng họa tiết bướm – thêm một chút tinh tế và đáng yêu, làm nổi bật bất kỳ bộ trang phục nào. Cho dù kết hợp chúng với một chiếc váy vintage giản dị hay nâng tầm một vẻ ngoài sang trọng hơn, những sản phẩm này đều mang đến sự linh hoạt và cá tính. Đối với bất cứ ai yêu thích thời trang lấy cảm hứng từ thập niên 70, quần áo và giày dép của Sororite Vintage mang đến trải nghiệm mua sắm độc đáo, giúp bạn sống lại một thời đại yêu dấu với phong cách hiện đại. Hơn nữa, sự chú trọng tỉ mỉ đến từng chi tiết trong thiết kế đảm bảo mỗi sản phẩm không chỉ là một tuyên ngôn thời trang mà còn là chủ đề để trò chuyện. Nếu bạn đang muốn làm mới tủ quần áo của mình với những món đồ vintage nổi bật hoặc những sản phẩm độc đáo, tôi rất khuyên bạn nên xem qua những sản phẩm mới nhất của Sororite Vintage. Từ những đôi giày lấy cảm hứng từ bướm đến những món đồ cổ điển quý giá khác, đây là một cách tuyệt vời để thể hiện cá tính và niềm đam mê với lịch sử thời trang.', 2, 'Manolo', 'Nữ', 1, NULL, NULL, NULL, NULL, '2026-03-23 07:51:23'),
(9, 'Dép xăng đan nữ màu trắng dáng rộng', 580000.00, 'Dép xăng đan nữ màu trắng dáng rộng, trang trí hoa lan bướm, giày mùa hè, dép đế bằng đi biển, rộng rãi và thoải mái, dép nữ, thích hợp cho ở nhà, đi nghỉ mát hoặc mang hàng ngày.', 4, 'SHEIN', 'Unisex', 0, NULL, NULL, NULL, NULL, '2026-03-23 08:13:40'),
(10, 'Xăng đan lười cho nữ', 450000.00, 'IELGY đơn giản và thời trang cao gót, một dòng sandal, Giày cao gót cho phụ nữ', 4, 'IELGY ', 'Nữ', 0, NULL, NULL, NULL, NULL, '2026-03-23 08:17:49'),
(11, 'Giày xăng đan ren Paloma', 874000.00, 'Giày sandal cao gót Alohas Paloma là món đồ hoàn hảo cho mùa Xuân/Hè, giúp tô điểm thêm vẻ sang trọng cho trang phục của bạn. Được chế tác bền vững tại Tây Ban Nha từ da thật, đôi sandal này có phần gót vuông thấp. Với thiết kế hở mũi, đế vuông và ba quai chéo, đôi sandal cao gót này chắc chắn sẽ giúp bạn tự tin từ ngày đến đêm.', 5, 'Paloma', 'Nữ', 0, NULL, NULL, NULL, NULL, '2026-03-23 08:26:38'),
(12, 'Dép gót mũi tròn, kiểu dáng slip-on ', 245000.00, 'Dép xăng đan là món đồ hoàn hảo cho mùa Xuân/Hè giúp tô điểm thêm vẻ sang trọng cho trang phục của bạn.', 4, 'Local', 'Nữ', 0, NULL, NULL, NULL, NULL, '2026-03-23 08:34:46'),
(13, 'Giày Tây Nam Phong Cách Italy', 1100000.00, 'Giày Mọi Nam Phong Cách Italy là một sản phẩm giày nam đẳng cấp, được thiết kế theo phong cách Italy. Chất liệu da bò màu đen titan mới được sử dụng để tạo nên sản phẩm này, giúp tăng độ bền và độ bóng của giày. Chất liệu da bò còn có độ mềm mại, thoáng khí và độ bền cao, giúp giày có thể sử dụng trong thời gian dài mà không bị hư hỏng.', 1, 'Tâm Anh', 'Nam', 1, NULL, NULL, NULL, NULL, '2026-03-26 00:44:00'),
(14, 'Giày da nam Oxford TÂM ANH sang trọng, thời thượng tinh tế GNTA9119-D', 680000.00, 'Sản phẩm từ da cao cấp, có độ bền vượt trội, bề mặt mịn mang lại tính thẩm mỹ cao và dễ vệ sinh, dễ xử lí khi da bị bẩn.', 1, 'Tâm Anh', 'Nam', 0, NULL, NULL, NULL, NULL, '2026-03-26 00:47:55'),
(15, 'Giày Thể Thao Speedcat OG', 2500000.00, 'Một biểu tượng kinh điển của PUMA, lấy cảm hứng từ tốc độ trên đường đua: Speedcat OG. Đôi giày nổi bật với dáng siêu mỏng, đường nét sắc sảo, mang tinh thần mạnh mẽ của những chiếc xe đua. Đưa phong cách motorsport xuống phố và làm chủ xu hướng low-profile với phiên bản huyền thoại này.\r\nIMEVA: Chất liệu đặc trưng của PUMA, mang lại cảm giác nhẹ và thoải mái', 3, 'PUMA', 'Unisex', 1, NULL, NULL, NULL, NULL, '2026-03-26 00:54:17'),
(16, 'Giày Puma Speedcat OG ‘Black Pink’', 2200000.00, 'Một đôi giày kiểu dáng đặt biệt với sự kết hợp hài hòa giữa đen và hồng', 3, 'PUMA', 'Unisex', 0, NULL, NULL, NULL, NULL, '2026-03-26 00:55:58'),
(17, 'Vans Giày MTE Old Skool Footwear ', 1834999.00, 'Vans MTE Old Skool là phiên bản cải tiến từ mẫu giày biểu tượng của Vans, được phát triển theo hướng bền vững và thân thiện với môi trường. Phần upper kết hợp giữa da lộn cao cấp và vải cotton Mỹ, đi kèm phần đế làm từ vật liệu có nguồn gốc sinh học, góp phần giảm thiểu tác động đến thiên nhiên. Đây không chỉ là một đôi giày thời trang mà còn là tuyên ngôn sống có trách nhiệm với môi trường.\r\nGiữ nguyên dáng Old Skool quen thuộc với dải logo Sidestripe™ đặc trưng chạy dọc hai bên, phiên bản này khoác lên mình tông màu đen cơ bản – dễ phối, phù hợp trong nhiều hoàn cảnh. Thiết kế phù hợp cho thời tiết giao mùa, đồng thời đáp ứng lối sống năng động của người trẻ hiện đại – những người vừa yêu thời trang, vừa quan tâm đến tính bền vững trong từng lựa chọn.', 3, 'VAN', 'Unisex', 1, NULL, NULL, NULL, NULL, '2026-03-26 00:57:03'),
(18, 'Giày Vans Old Skool Twill Stormy Weather', 1272000.00, '- Giày cổ thấp với họa tiết Sidestripe™ biểu tượng\r\n- Thân giày vải twill xanh xám “Stormy Weather”\r\n- Dây buộc cổ điển, mũi giày gia cố chắc chắn\r\n- Cổ giày đệm êm ái, tạo cảm giác thoải mái khi mang\r\n- Đế cao su waffle bám tốt, bền bỉ', 3, 'VAN', 'Unisex', 0, NULL, NULL, NULL, NULL, '2026-03-26 00:58:05'),
(19, 'Giày Vans Authentic', 1047500.00, 'Bộ sản phẩm: Hộp giày, túi vải, phiếu bảo hành chính hãng (không áp dụng cho sản phẩm giảm 30% trở lên), vớ tặng (không áp dụng cho sản phẩm giảm 30% trở lên)\r\nDòng giày được thiết kế đa dạng kiểu dáng bên thân giày. Kiểu dáng cổ điển, dễ vệ sinh, với đường may tỉ mỉ chắc chắn.\r\nSản phẩm giúp hỗ trợ cho bạn hoạt động, di chuyển linh hoạt hơn. Đa phần thiết kế của Vans ưu tiên bảo vệ đôi chân người dùng tạo nên độ chắc chắn và gắn kết hoàn hảo giữa đế và thân giày mang một vẻ liền khối. Thiết kế đế chống trơn trượt hiệu quả nên bạn có thể an tâm đi mưa\r\nPhối màu cực kỳ đa dạng cho bạn dễ dàng lựa chọn và thỏa sức mix, match với bất kỳ phong cách nào. Chẳng hạn, phối với quần jeans, áo sơ mi hoặc áo thun đều được.', 3, 'VAN', 'Unisex', 0, NULL, NULL, NULL, NULL, '2026-03-26 00:59:43'),
(20, 'Giày nữ cao gót Alex & Sara đính nơ', 1030000.00, 'Alex & Sara là một thương hiệu thời trang giày dép Việt bắt đầu thành lập vào năm 2018 từ một xưởng gia công giày thủ công gia đình nhỏ lẻ. Với tầm nhìn khai thác sức mạnh của thời trang để truyền cảm hứng cho phụ nữ trên khắp thế giới, giúp giải phóng khả năng sáng tạo và sự tự tin của họ, năm 2022, Alex & Sara bước vào mảng bán lẻ mong muốn được trực tiếp phục vụ tốt hơn cho phái đẹp ở cả 2 nền tảng offline và online.', 2, 'Alex & Sara', 'Nữ', 1, NULL, NULL, NULL, NULL, '2026-03-26 01:02:21'),
(21, 'Giày Búp Bê Phối Chất Liệu Vân', 449000.00, 'Giày Búp Bê Phối Chất Liệu Vân kết hợp quai ngang thanh lịch, nữ tính\r\nBề mặt phối chất liệu vân nhẹ tạo điểm nhấn hiện đại và sang trọng\r\nQuai có khóa điều chỉnh giúp ôm chân chắc chắn và dễ mang\r\nLót giày êm ái cùng đế chống trượt mang lại cảm giác thoải mái khi di chuyển', 5, 'JUNO', 'Nữ', 0, NULL, NULL, NULL, NULL, '2026-03-26 01:04:38'),
(22, 'Giày Thể Thao Biti\'s Hunter Street 2.0', 715000.00, 'Thời Trang Retro Độc Đáo: Đế Gum Sole không chỉ đẹp mà còn là chi tiết thời trang kinh điển, tạo vẻ ngoài khác biệt, rất phù hợp với phong cách streetwear.\r\nVững Chắc & Bền Bỉ: Đế Cao Su và quai SI PU đảm bảo giày có tuổi thọ cao và luôn giữ được form dáng tốt.\r\nAn Toàn: Đế cao su dày dặn, đảm bảo sự ổn định và an toàn khi đi lại trên nhiều địa hình.\r\nGiá Hợp Lý: Sở hữu đôi sneaker chất lượng với mức giá cực kỳ phải chăng', 3, 'Biti\'s', 'Nam', 0, NULL, NULL, NULL, NULL, '2026-03-26 01:06:27'),
(23, 'Sandal thể thao Nữ Biti\'s Hunter', 450000.00, 'Sandal thể thao Nữ Biti\'s Hunter HEW001600\r\n\r\nMàu sắc: Đen, Hồng, Kem\r\n\r\nCở số: 35 - 39\r\n\r\nChất liệu quai filament + lưới, đế IP êm nhẹ', 5, 'Biti\'s', 'Nữ', 1, NULL, NULL, NULL, NULL, '2026-03-26 01:09:10'),
(24, 'Cao gót nữ thời trang Biti\'s ', 560000.00, 'Chất liệu quai si, đế cao su', 2, 'Biti\'s', 'Nữ', 0, NULL, NULL, NULL, NULL, '2026-03-26 01:11:30'),
(25, 'Giày New Balance 530 Mens Classic', 2789000.00, 'Mẫu MR530 nguyên bản kết hợp tính thẩm mỹ của thời kỳ chuyển giao thiên niên kỷ với độ tin cậy của một đôi giày chạy bộ đường dài. Phiên bản 530 được tái giới thiệu mang đến phong cách hiện đại, phù hợp với sử dụng hàng ngày cho thiết kế chú trọng hiệu suất này. Đế giữa ABZORB phân đoạn được kết hợp với thiết kế phần trên bằng lưới và lớp phủ tổng hợp cổ điển, sử dụng các đường cong và góc cạnh uyển chuyển tạo nên vẻ ngoài đặc biệt, công nghệ cao.', 3, 'New Balance', 'Nam', 0, NULL, NULL, NULL, NULL, '2026-03-26 01:14:54'),
(26, 'Giày New Balance 530 Women Classic', 2789000.00, 'Mẫu MR530 nguyên bản kết hợp tính thẩm mỹ của thời kỳ chuyển giao thiên niên kỷ với độ tin cậy của một đôi giày chạy bộ đường dài. Phiên bản 530 được tái giới thiệu mang đến một phong cách hiện đại, phù hợp với sử dụng hàng ngày cho thiết kế hướng đến hiệu suất này. Đế giữa ABZORB phân đoạn được kết hợp với thiết kế phần trên bằng lưới và lớp phủ tổng hợp cổ điển, sử dụng các đường cong và góc cạnh uyển chuyển để tạo nên vẻ ngoài đặc biệt, công nghệ cao.', 3, 'New Balance', 'Nữ', 0, NULL, NULL, NULL, NULL, '2026-03-26 01:15:45'),
(27, 'Tây Xỏ Hu', 610000.00, 'Chất liệu quai: da bò, cùng đường chỉ may tinh tế.\r\nChất liệu đế: Cao su thiết kế chắc chắn, có các rãnh chống trơn trượt.\r\nĐộ cao: 2cm\r\nKiểu dáng: thiết kế tối giản không cầu kì phù hợp các trang phục: công sở, xuống phố hoặc các bữa tiệc quan trọng.', 1, 'Hong Thanh', 'Unisex', 0, NULL, NULL, NULL, NULL, '2026-03-26 01:16:59'),
(28, 'Giày Xỏ Giả Cột', 915000.00, 'Chất liệu da bò thật\r\nChất liệu đế cao su đúc nguyên khối cao 3cm, bề mặt nhiều vân chống trơn trượt\r\nMặt lót da mềm tạo sự thoải mái khi di chuyển', 1, 'Hồng Thạnh', 'Nam', 0, NULL, NULL, NULL, NULL, '2026-03-26 01:17:58'),
(29, 'Cột Dây Nd-9185', 590000.00, 'Với gam màu cổ điển, phái mạnh có thể tự tin khi kết hợp cùng những bộ đồ mình yêu thích nhưng vẫn trông rất trẻ trung và thời thượng. Giày tây sẽ giúp bạn ghi điểm trong mắt mọi người, dù cho bạn có đang đi làm, đi tiệc hay đi dự sự kiện.', 1, 'Hồng Thạnh', 'Nữ', 0, NULL, NULL, NULL, NULL, '2026-03-26 01:19:11'),
(30, 'Giày búp bê đế dẻo mềm êm', 380000.00, 'Giày búp bê bít mũi là một thiết kế công sở tiện lợi đề cao tính ứng dụng và thanh lịch giúp các nàng tự tin làm việc ngày dài.\r\n\r\n• Chất liệu quai microfiber mềm mại.\r\n\r\n• Chất liệu đế cao su chống trơn trợt, tạo độ bám tốt.', 5, 'Hồng Thạnh', 'Nữ', 0, NULL, NULL, NULL, NULL, '2026-03-26 01:20:53'),
(31, 'Giày Sandal Quai Chéo Phối Liệu Đan Lát ', 549000.00, 'Giày Sandal Quai Chéo Phối Liệu Đan Lát năng động, trẻ trung\r\n\r\nThiết kế quai bản to đan chéo họa tiết đan lát mang lại nét nổi bật khi diện\r\n\r\nChất liệu da tổng hợp cao cấp, dễ bảo quản, bền đẹp\r\n\r\nGiày có 2 màu dễ phối đồ. Phù hợp để đi làm, dạo phố, đi học,.', 5, 'JUNO', 'Unisex', 0, NULL, NULL, NULL, NULL, '2026-03-26 01:22:59'),
(32, 'Giày Búp Bê Slingback Mũi Tròn', 449000.00, 'Giày Búp Bê Slingback Mũi Tròn nữ tính, phù hợp mọi dịp\r\n\r\nThiết kế mũi vuông, quai ngang mang lại nét uyển chuyển trên từng bước đi\r\n\r\nChất liệu da tổng hợp bền đẹp, dễ vệ sinh\r\n\r\nLót giày êm ái, dưới đế có rãnh chống trượt cho bước chân thoải mái, tự tin\r\n\r\n', 5, 'JUNO', 'Nữ', 0, NULL, NULL, NULL, NULL, '2026-03-26 01:23:54'),
(33, 'Giày cao gót Phối Quai Tự Do', 589000.00, 'Thiết kế quai mảnh đan chéo tạo cảm giác nhẹ nhàng và thoáng chân\r\n\r\nForm mũi vuông hiện đại kết hợp gót cao 7cm, tôn dáng thanh thoát\r\n\r\nQuai hậu có khóa điều chỉnh giúp ôm chân chắc chắn khi di chuyển', 2, 'JUNO', 'Nữ', 0, NULL, NULL, NULL, NULL, '2026-03-26 01:25:06'),
(34, 'Giày Cao Gót Phối Liệu Sequin', 682000.00, 'Giày Cao Gót Phối Liệu Sequin sang trọng, nữ tính\r\n\r\nThiết kế đơn giản mũi nhọn, phối sequin lắp lánh đầy nổi bật\r\n\r\nQuai hậu gài tiện dụng, gót nhọn thanh cao 9cm, có phần lót chống trơn trượt giúp bạn dễ dàng  di chuyển\r\n\r\nChất liệu da tổng hợp cao cấp, dễ bảo quản, bền đẹp', 2, 'JUNO', 'Unisex', 1, NULL, NULL, NULL, NULL, '2026-03-26 01:26:06'),
(35, 'Dép Đế Trấu Two-strap Slides Vải Giả Da Mềm', 339000.00, 'ĐẾ CHỐNG TRƯỢT: Thiết kế vân đế đặc biệt giúp bám chắc và an toàn trong mọi điều kiện đi lại\r\nĐƠN GIẢN TIỆN LỢI: Dép không cầu kỳ chỉ cần xỏ vào là xong lý tưởng cho những ai yêu thích sự gọn gàng nhanh chóng', 4, 'YAME', 'Unisex', 0, NULL, NULL, NULL, NULL, '2026-03-26 01:27:57');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `image_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`image_id`, `product_id`, `image_url`) VALUES
(1, 1, 'nike1.jpg'),
(2, 2, 'adidas1.jpg'),
(4, 4, 'dep1.jpg'),
(5, 5, 'giaytay1.jpg'),
(6, 6, '1774226097_6_0.png'),
(9, 7, '1774227354_7_0.png'),
(11, 3, '1774227973_3_0.jpg'),
(12, 9, '1774228431_9_0.jpg'),
(13, 10, '1774228678_10_0.jpg'),
(14, 11, '1774229215_11_0.jpg'),
(15, 12, '1774229693_12_0.jpg'),
(16, 13, '1774460654_13_0.jpg'),
(20, 14, '1774461188_14_0.jpg'),
(21, 15, '1774461265_15_0.png'),
(22, 16, '1774461364_16_0.png'),
(23, 17, '1774461434_17_0.jpg'),
(24, 18, '1774461492_18_0.jpg'),
(25, 19, '1774461601_19_0.png'),
(26, 20, '1774461751_20_0.png'),
(27, 21, '1774461886_21_0.jpeg'),
(28, 22, '1774461998_22_0.jpg'),
(29, 23, '1774462161_23_0.png'),
(30, 24, '1774462295_24_0.png'),
(31, 25, '1774462501_25_0.png'),
(32, 26, '1774462552_26_0.png'),
(33, 27, '1774462627_27_0.png'),
(34, 28, '1774462700_28_0.jpg'),
(35, 29, '1774462761_29_0.jpg'),
(36, 30, '1774462858_30_0.jpg'),
(37, 31, '1774462986_31_0.jpeg'),
(38, 32, '1774463048_32_0.jpeg'),
(39, 33, '1774463115_33_0.jpeg'),
(40, 34, '1774463178_34_0.jpeg'),
(41, 35, '1774463290_35_0.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_variants`
--

CREATE TABLE `product_variants` (
  `variant_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_variants`
--

INSERT INTO `product_variants` (`variant_id`, `product_id`, `size`, `color`, `stock`) VALUES
(1, 1, 39, 'Trắng', 12),
(2, 1, 40, 'Đen', 8),
(3, 1, 41, 'Xanh Navy', 6),
(4, 1, 42, 'Trắng', 10),
(5, 1, 43, 'Đen', 5),
(6, 2, 39, 'Trắng', 7),
(7, 2, 40, 'Đen', 10),
(8, 2, 41, 'Xám', 9),
(9, 2, 42, 'Xanh', 6),
(10, 3, 35, 'Hồng', 14),
(11, 3, 36, 'Đen', 12),
(12, 3, 37, 'Trắng', 15),
(13, 3, 38, 'Hồng', 11),
(14, 4, 38, 'Xanh', 8),
(15, 4, 39, 'Đen', 10),
(16, 4, 40, 'Trắng', 9),
(17, 5, 39, 'Đen', 7),
(18, 5, 40, 'Nâu', 8),
(19, 5, 41, 'Đen', 6),
(20, 5, 42, 'Nâu', 5),
(21, 6, 35, 'Đỏ đô', 12),
(22, 6, 36, 'Đỏ đô', 6),
(23, 7, 35, 'Xanh', 34),
(24, 6, 37, 'đỏ đô', 5),
(25, 6, 38, 'đỏ đô', 13),
(26, 6, 39, 'đỏ đô', 7),
(27, 7, 36, 'xanh', 7),
(28, 7, 37, 'xanh', 3),
(29, 7, 38, 'xanh', 6),
(30, 7, 39, 'xanh', 17),
(31, 9, 36, 'Trắng', 13),
(32, 9, 37, 'Trắng', 6),
(33, 9, 38, 'Trắng', 10),
(34, 9, 39, 'Trắng', 13),
(35, 10, 36, 'Trắng', 3),
(36, 10, 37, 'Trắng', 3),
(37, 10, 38, 'Trắng', 3),
(38, 11, 36, 'rêu', 5),
(39, 11, 37, 'rêu', 5),
(40, 11, 38, 'rêu', 5),
(41, 11, 39, 'rêu', 15),
(42, 12, 36, 'Hồng', 2),
(43, 12, 36, 'Hồng', 2),
(44, 12, 36, 'Hồng', 2),
(45, 12, 37, 'Hồng', 12),
(46, 12, 3, 'Hồng', 22),
(47, 13, 38, 'Đen', 8),
(48, 13, 39, 'Đen', 8),
(49, 13, 40, 'Đen', 8),
(50, 13, 41, 'Đen', 8),
(51, 14, 38, 'Đen', 8),
(52, 14, 39, 'Đen', 8),
(53, 14, 40, 'Đen', 8),
(54, 14, 41, 'Đen', 8),
(55, 14, 42, 'Đen', 8),
(56, 28, 38, 'Đen', 8),
(57, 28, 39, 'Đen', 8),
(58, 28, 40, 'Đen', 8),
(59, 28, 41, 'Đen', 8),
(60, 28, 42, 'Đen', 8),
(61, 29, 38, 'Đen', 8),
(62, 29, 39, 'Đen', 8),
(63, 29, 40, 'Đen', 8),
(64, 29, 41, 'Đen', 8),
(65, 29, 42, 'Đen', 8),
(66, 27, 38, 'Nâu', 8),
(67, 27, 39, 'Nâu', 8),
(68, 27, 40, 'Nâu', 8),
(69, 27, 41, 'Nâu', 8),
(70, 27, 42, 'Nâu', 8),
(71, 15, 37, 'Đen', 5),
(72, 15, 38, 'Đen', 5),
(73, 15, 39, 'Đen', 5),
(74, 15, 40, 'Đen', 5),
(75, 15, 41, 'Đen', 5),
(76, 17, 38, 'Đen', 5),
(77, 17, 38, 'Đen', 5),
(78, 17, 39, 'Đen', 5),
(79, 17, 40, 'Đen', 5),
(80, 17, 41, 'Đen', 5),
(81, 16, 38, 'Đen-Hồng', 5),
(82, 16, 38, 'Đen-Hồng', 5),
(83, 16, 39, 'Đen-Hồng', 5),
(84, 16, 40, 'Đen-Hồng', 5),
(85, 16, 41, 'Đen-Hồng', 5),
(86, 18, 38, 'Xanh', 5),
(87, 18, 38, 'Xanh', 5),
(88, 18, 39, 'Xanh', 5),
(89, 18, 40, 'Xanh', 5),
(90, 18, 41, 'Xanh', 5),
(91, 19, 38, 'Trắng', 5),
(92, 19, 38, 'Trắng', 5),
(93, 19, 39, 'Trắng', 5),
(94, 19, 40, 'Trắng', 5),
(95, 19, 41, 'Trắng', 5),
(96, 25, 38, 'Trắng', 5),
(97, 25, 38, 'Trắng', 5),
(98, 25, 39, 'Trắng', 5),
(99, 25, 40, 'Trắng', 5),
(100, 25, 41, 'Trắng', 5),
(101, 26, 38, 'Trắng-Hồng', 5),
(102, 26, 38, 'Trắng-Hồng', 5),
(103, 26, 39, 'Trắng-Hồng', 5),
(104, 26, 40, 'Trắng-Hồng', 5),
(105, 26, 41, 'Trắng-Hồng', 5),
(106, 30, 37, 'Trắng', 5),
(107, 30, 38, 'Trắng', 5),
(108, 30, 36, 'Trắng', 5),
(109, 30, 39, 'Trắng', 5),
(110, 33, 37, 'Trắng', 5),
(111, 33, 38, 'Trắng', 5),
(112, 33, 36, 'Trắng', 5),
(113, 33, 39, 'Trắng', 5),
(114, 34, 37, 'Trắng', 5),
(115, 34, 38, 'Trắng', 5),
(116, 34, 36, 'Trắng', 5),
(117, 34, 39, 'Trắng', 5),
(118, 21, 37, 'Trắng', 5),
(119, 21, 38, 'Trắng', 5),
(120, 21, 36, 'Trắng', 5),
(121, 21, 39, 'Trắng', 5),
(122, 24, 37, 'Trắng', 5),
(123, 24, 38, 'Trắng', 5),
(124, 24, 36, 'Trắng', 5),
(125, 24, 39, 'Trắng', 5),
(126, 23, 37, 'Trắng', 5),
(127, 23, 38, 'Trắng', 5),
(128, 23, 36, 'Trắng', 5),
(129, 23, 39, 'Trắng', 5),
(130, 31, 37, 'Trắng', 5),
(131, 31, 38, 'Trắng', 5),
(132, 31, 36, 'Trắng', 5),
(133, 31, 39, 'Trắng', 5),
(134, 32, 37, 'Đen', 5),
(135, 32, 38, 'Đen', 5),
(136, 32, 36, 'Đen', 5),
(137, 32, 39, 'Đen', 5),
(138, 20, 37, 'Đen', 5),
(139, 20, 38, 'Đen', 5),
(140, 20, 36, 'Đen', 5),
(141, 20, 39, 'Đen', 5),
(142, 35, 37, 'Đen', 5),
(143, 35, 38, 'Đen', 5),
(144, 35, 39, 'Đen', 5),
(145, 35, 40, 'Đen', 5),
(146, 35, 41, 'Đen', 5),
(147, 22, 37, 'Trắng', 5),
(148, 22, 38, 'Trắng', 5),
(149, 22, 39, 'Trắng', 5),
(150, 22, 40, 'Trắng', 5),
(151, 22, 41, 'Trắng', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `reviews`
--

INSERT INTO `reviews` (`review_id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`) VALUES
(1, 2, 1, 5, 'Rất đẹp', '2026-02-04 23:56:41'),
(2, 3, 2, 4, 'Êm chân', '2026-02-04 23:56:41'),
(3, 4, 3, 3, 'Ổn', '2026-02-04 23:56:41'),
(4, 5, 4, 5, 'Tốt', '2026-02-04 23:56:41'),
(5, 2, 5, 4, 'Đáng mua', '2026-02-04 23:56:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` enum('admin','customer') DEFAULT 'customer',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `password`, `phone`, `address`, `role`, `created_at`) VALUES
(1, 'Nguyễn Minh Anh', 'admin@gmail.com', '123456', '0900000001', 'TP HCM', 'admin', '2026-02-04 23:55:24'),
(2, 'Trần Văn A', 'a@gmail.com', '123456', '0900000002', 'Hà Nội', 'customer', '2026-02-04 23:55:24'),
(3, 'Lê Thị B', 'b@gmail.com', '123456', '0900000003', 'Đà Nẵng', 'customer', '2026-02-04 23:55:24'),
(4, 'Phạm Văn C', 'c@gmail.com', '123456', '0900000004', 'Cần Thơ', 'customer', '2026-02-04 23:55:24'),
(5, 'Hoàng Thị D', 'd@gmail.com', '123456', '0900000005', 'Huế', 'customer', '2026-02-04 23:55:24');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`cart_item_id`),
  ADD KEY `cart_id` (`cart_id`),
  ADD KEY `variant_id` (`variant_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`order_detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `variant_id` (`variant_id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`post_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`variant_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `carts`
--
ALTER TABLE `carts`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `cart_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `order_detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `variant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`cart_id`),
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`variant_id`);

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`variant_id`);

--
-- Các ràng buộc cho bảng `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Các ràng buộc cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Các ràng buộc cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
