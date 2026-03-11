-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for storelyminhkhang
CREATE DATABASE IF NOT EXISTS `storelyminhkhang` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `storelyminhkhang`;

-- Dumping structure for table storelyminhkhang.banners
CREATE TABLE IF NOT EXISTS `banners` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image_url` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table storelyminhkhang.banners: ~4 rows (approximately)
INSERT INTO `banners` (`id`, `image_url`, `created_at`) VALUES
	(1, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:1036:450/q:100/plain/https://dashboard.cellphones.com.vn/storage/Home_Ver4(4).png', '2026-03-11 06:47:29'),
	(2, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:1036:450/q:100/plain/https://dashboard.cellphones.com.vn/storage/690x300_ROI_MacBookNeo.png', '2026-03-11 06:47:58'),
	(3, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:1036:450/q:100/plain/https://dashboard.cellphones.com.vn/storage/690x300_open_iPhone%2017e.png', '2026-03-11 06:51:22'),
	(4, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:1036:450/q:100/plain/https://dashboard.cellphones.com.vn/storage/mbam5homepae.png', '2026-03-11 06:51:30');

-- Dumping structure for table storelyminhkhang.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table storelyminhkhang.category: ~5 rows (approximately)
INSERT INTO `category` (`id`, `name`, `description`) VALUES
	(1, 'Điện thoại', 'Danh mục các loại điện thoại'),
	(2, 'Laptop', 'Danh mục các loại laptop'),
	(3, 'Máy tính bảng', 'Danh mục các loại máy tính bảng'),
	(4, 'Phụ kiện', 'Danh mục phụ kiện điện tử'),
	(5, 'Thiết bị âm thanh', 'Danh mục loa, tai nghe, micro');

-- Dumping structure for table storelyminhkhang.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `fullname` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `total_money` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table storelyminhkhang.orders: ~4 rows (approximately)
INSERT INTO `orders` (`id`, `user_id`, `fullname`, `phone`, `address`, `total_money`, `created_at`, `payment_method`) VALUES
	(1, 2, 'khangtest', '21313111', '213132', 360000.00, '2026-03-04 07:59:08', 'cod'),
	(2, 3, 'khangtest2', '0905344444', 'hcm', 10690000.00, '2026-03-04 08:00:11', 'cod'),
	(3, 3, 'khangtest2', '14165516551', 'adsadasdasdasd', 10690000.00, '2026-03-04 08:09:32', 'cod'),
	(4, 4, 'test2', '0345678912', '112 Ngo Yen Lang', 24608800.00, '2026-03-11 09:09:27', 'cod'),
	(5, 4, 'test2', '0345678912', '112 Ngo Yen Lang', 17767200.00, '2026-03-11 09:19:01', 'cod'),
	(6, 4, 'test2', '0345678912', '112 Ngo Yen Lang', 6841600.00, '2026-03-11 09:24:08', 'momo'),
	(7, 4, 'test2', '0345678912', '112 Ngo Yen Lang', 17767200.00, '2026-03-11 09:32:00', 'cod');

-- Dumping structure for table storelyminhkhang.order_details
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table storelyminhkhang.order_details: ~5 rows (approximately)
INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `price`, `quantity`) VALUES
	(1, 1, 7, 360000.00, 1),
	(2, 2, 6, 10690000.00, 1),
	(3, 3, 6, 10690000.00, 1),
	(4, 4, 6, 6841600.00, 1),
	(5, 4, 11, 17767200.00, 1),
	(6, 6, 6, 6841600.00, 1),
	(7, 7, 11, 17767200.00, 1);

-- Dumping structure for table storelyminhkhang.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `discount` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table storelyminhkhang.product: ~11 rows (approximately)
INSERT INTO `product` (`id`, `name`, `description`, `price`, `image`, `category_id`, `discount`) VALUES
	(1, 'iPhone 17 Pro Max 512GB | Chính hãng', '	\r\nMàn hình Luôn Bật, ProMotion 120Hz, HDR, True Tone, Dải màu rộng (P3), Haptic Touch, Tỷ lệ tương phản 2.000.000:1, Độ sáng 1000 nit (tiêu chuẩn), 1600 nit (HDR), 3000 nit (ngoài trời) / tối thiểu 1 nit, Lớp phủ kháng dầu, Chống phản chiếu, Hỗ trợ đa ngôn', 43890000.00, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/i/p/iphone-17-pro-cam_3.jpg', 1, 0),
	(2, 'iPhone 16 Pro Max 1TB | Chính hãng VN/A', 'Dynamic Island\r\nMàn hình Luôn Bật\r\nCông nghệ ProMotion với tốc độ làm mới thích ứng lên đến 120Hz\r\nMàn hình HDR\r\nTrue Tone\r\nDải màu rộng (P3)\r\nHaptic Touch\r\nTỷ lệ tương phản 2.000.000:1', 43990000.00, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/i/p/iphone-16-pro-max_2.png', 1, 0),
	(3, 'Laptop Acer Aspire Lite Gen 2 AL14-52M-32KV', 'Laptop Acer Aspire Lite Gen 2 AL14-52M-32KV nổi bật với màn hình IPS 14 inches WUXGA, bộ vi xử lý Intel Core i3-1305U, và RAM 8GB cho hiệu năng ổn định. Máy sở hữu SSD 256GB PCIe, kết nối Wi-Fi 6, Bluetooth 5.1, cùng đa dạng cổng giao tiếp như USB Type-C, HDMI 1.4 và đầu đọc thẻ MicroSD. Thiết kế gọn nhẹ 1.5kg cùng bàn phím tiêu chuẩn mang đến sự tiện lợi cho hầu hết công việc.', 12490000.00, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/g/r/group_659_1__4.png', 2, 0),
	(4, 'Laptop Lenovo LOQ 15ARP10E 83S0007AVN', 'Laptop Lenovo LOQ 15ARP10E 83S0007AVN sử dụng CPU AMD Ryzen 7 7735HS, cung cấp đạt hiệu suất ổn định khi xử lý các tác vụ nặng và đáp ứng nhu cầu làm việc. Model sở hữu GPU RTX 3050 6GB GDDR6 hỗ trợ dựng hình ổn định. Máy dùng RAM DDR5-4800 giúp người dùng đa nhiệm tốt trong nhiều bối cảnh.', 26290000.00, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/t/e/text_d_i_8_16.png', 2, 0),
	(5, 'iPad Pro chip M5 11 inch Wifi 256GB | Chính hãng Apple Việt Nam', 'iPad Pro 11 2025 M5 Wifi 256GB gây ấn tượng với chip M5 xử lý mạnh mẽ, RAM lên tới 12GB cùng màn hình OLED Ultra Retina XDR 120Hz hiển thị mượt mà. Máy hỗ trợ WiFi 7, cổng Thunderbolt tốc độ cao cùng pin 31,29Wh. Camera sau 12MP quay 4K HDR, cho hình ảnh sắc nét và chuyên nghiệp.', 29090000.00, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/i/p/ipad-pro-m5.jpg', 3, 0),
	(6, 'Samsung Galaxy Tab S10 FE Wifi 12GB 256GB', 'Tab S10 FE Wifi 12GB 256GB sở hữu RAM 12GB mạnh mẽ, tích hợp chip Exynos 1580, hỗ trợ đa nhiệm mượt mà, xử lý nhanh chóng mọi ứng dụng và tác vụ nặng. ROM 256GB cung cấp không gian lưu trữ rộng lớn, thoải mái chứa hàng nghìn ảnh, video, tài liệu và ứng dụng. Thiết bị sở hữu màn hình 10.9 inch sắc nét, pin 8000mAh và sạc nhanh 45W tiện lợi.', 10690000.00, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:358:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/m/a/may-tinh-bang-samsung-galaxy-tab-s10-fe.1_1_1.png', 3, 36),
	(7, 'Dán kính cường lực màn hình Apple iPhone 17 Zeelot Solidsleek Ultra HD Full Cao Cấp', 'Kính cường lực iPhone 17 Zeelot Solidsleek Ultra HD Full có độ cứng cao, bảo vệ hiệu quả, hạn chế trầy xước hiệu quả với cấu trúc Explosion-Proof. Lớp phủ oleophobic trên bề mặt hạn chế bám vân tay, đồng thời cho cảm giác vuốt chạm mượt mà. Sản phẩm có độ trong suốt đến 92.5% hiển thị rõ nét.', 360000.00, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/k/i/kinh-cuong-luc-iphone-17-zeelot-solidsleek-ultra-hd-full_1_.png', 4, 5),
	(8, 'Bao Da Mutural Design Folio cho iPad Pro 11 2021', 'Bao da Mutural Design Folio cho Apple iPad Pro 11 2021 – Thẩm mỹ, cao cấp\r\nBao da Mutural Design Folio cho Apple iPad Pro 11 2021 là món phụ kiện phổ biến mà người dùng iPad 11 2021 không thể không trang bị. Với thiết kế mềm dẻo cùng khả năng chống sốc tốt, sản phẩm sẽ giúp bảo vệ iPad của bạn được an toàn và mang đến trải nghiệm tốt cho người dùng.', 53100.00, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/b/a/bao-da-mutural-ipad-pro-11-update.png', 4, 0),
	(9, 'MacBook Pro 14 M5 10CPU 10GPU 16GB 512GB', 'Macbook Pro 14 inch chip M5 16GB 512GB trang bị chip M5, RAM 16GB cùng ổ cứng SSD 512GB, mang đến hiệu năng mạnh mẽ và đa nhiệm mượt mà trong mọi tác vụ. Máy trang bị màn hình Liquid Retina XDR 14.2 inch sắc nét và hỗ trợ ProMotion 120Hz. Mẫu Macbook Pro này còn sở hữu hệ điều hành macOS Tahoe mới tích hợp Apple Intelligence.', 41490000.00, 'https://cdn2.cellphones.com.vn/200x/media/catalog/product/m/a/macbook_13.png', 2, 0),
	(10, 'Mac mini M4 2024 16gb 512GB', 'Mua Mac mini M4 2024 16gb 512GB chính hãng, giá rẻ - Bảo hành 12 tháng tại Việt Nam, đổi mới 30 ngày, trả góp 0%. Không trả trước, phụ phí.', 20090000.00, 'https://cdn2.cellphones.com.vn/200x/media/catalog/product/m/a/macbook_1__2_3.png', 2, 0),
	(11, 'Apple Macbook Air M2 16GB 256GB', 'Apple Macbook Air M2 2024 16GB 256GB thiết kế siêu mỏng 1.13cm, trang bị chip M2 8 nhân GPU, 16 nhân Neural Engine, RAM khủng 16GB, SSD 256GB, màn hình IPS Liquid Retina Display cùng hệ thống 4 loa cho trải nghiệm đỉnh cao.', 20190000.00, 'https://cdn2.cellphones.com.vn/200x/media/catalog/product/i/m/image_1396_1.png', 2, 12);

-- Dumping structure for table storelyminhkhang.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT 'user',
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table storelyminhkhang.user: ~4 rows (approximately)
INSERT INTO `user` (`id`, `username`, `password`, `role`, `email`) VALUES
	(1, 'admin', '12345', 'admin', NULL),
	(2, 'khangtest', '123123', 'khach', NULL),
	(3, 'khangtest2', '123123', 'khach', NULL),
	(4, 'test2', '$2y$10$WLPFZ2jOLlKr49vQVE3jje18gC84TOe6CIMcZxKSGymvuOpeunqKe', 'user', 'ljrui999@gmail.com');

-- Dumping structure for table storelyminhkhang.vouchers
CREATE TABLE IF NOT EXISTS `vouchers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `discount_percent` int NOT NULL,
  `expiry_date` date NOT NULL,
  `status` tinyint DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table storelyminhkhang.vouchers: ~1 rows (approximately)
INSERT INTO `vouchers` (`id`, `code`, `discount_percent`, `expiry_date`, `status`) VALUES
	(1, 'LJRUI10', 10, '2026-12-31', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
