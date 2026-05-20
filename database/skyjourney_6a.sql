-- ============================================================
--  SkyJourney Database - skyjourney_6a
--  Siap copy-paste ke phpMyAdmin
--  Engine: InnoDB | Charset: utf8mb4
-- ============================================================

-- 1. CREATE DATABASE
CREATE DATABASE IF NOT EXISTS `skyjourney_6a`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `skyjourney_6a`;

-- ============================================================
-- 2. DROP TABLES (urutan: child dulu, lalu parent)
-- ============================================================
DROP TABLE IF EXISTS `order_items`;
DROP TABLE IF EXISTS `orders`;
DROP TABLE IF EXISTS `carts`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `categories`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `migrations`;

-- ============================================================
-- 3. CREATE TABLES
-- ============================================================

-- MIGRATIONS (Laravel internal)
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- USERS
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- PASSWORD RESET TOKENS
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- SESSIONS
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- CACHE
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- JOBS
CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- CATEGORIES
CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- PRODUCTS (Tiket Pesawat)
CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `nama_tiket` varchar(255) NOT NULL,
  `maskapai` varchar(255) NOT NULL,
  `asal` varchar(255) NOT NULL,
  `tujuan` varchar(255) NOT NULL,
  `tanggal_keberangkatan` datetime NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `stok_kursi` int(11) NOT NULL DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign`
    FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- CARTS
CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `carts_user_id_foreign` (`user_id`),
  KEY `carts_product_id_foreign` (`product_id`),
  CONSTRAINT `carts_user_id_foreign`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `carts_product_id_foreign`
    FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ORDERS
CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `kode_pesanan` varchar(255) NOT NULL,
  `nama_pembeli` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `total_pembayaran` decimal(15,2) NOT NULL,
  `status_pesanan` enum('pending','dibayar','selesai','dibatalkan') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_kode_pesanan_unique` (`kode_pesanan`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ORDER ITEMS
CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_satuan` decimal(15,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign`
    FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign`
    FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 4. INSERT DATA DUMMY
-- ============================================================

-- USERS (password: admin123 dan password -> bcrypt)
INSERT INTO `users` (`name`, `email`, `password`, `role`, `phone`, `address`, `created_at`, `updated_at`) VALUES
('Administrator', 'admin@skyjourney.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '081234567890', 'Jakarta, Indonesia', NOW(), NOW()),
('Budi Santoso', 'budi@example.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', '082345678901', 'Jl. Merdeka No. 10, Bandung', NOW(), NOW()),
('Siti Rahayu', 'siti@example.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', '083456789012', 'Jl. Diponegoro No. 5, Surabaya', NOW(), NOW()),
('Ahmad Fauzi', 'ahmad@example.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user', '085678901234', 'Jl. Sudirman No. 3, Medan', NOW(), NOW());

-- NOTE: Password di atas adalah hash bcrypt untuk string 'password'
-- Admin password: admin123 (gunakan php artisan tinker lalu Hash::make('admin123') untuk generate)
-- ATAU gunakan php artisan migrate --seed yang sudah include seeder dengan password benar

-- CATEGORIES
INSERT INTO `categories` (`nama_kategori`, `deskripsi`, `created_at`, `updated_at`) VALUES
('Domestik', 'Penerbangan dalam negeri Indonesia', NOW(), NOW()),
('Internasional', 'Penerbangan ke luar negeri', NOW(), NOW()),
('Promo', 'Tiket dengan harga promo spesial', NOW(), NOW()),
('Bisnis', 'Kelas bisnis premium', NOW(), NOW());

-- PRODUCTS (Tiket Pesawat)
INSERT INTO `products` (`category_id`, `nama_tiket`, `maskapai`, `asal`, `tujuan`, `tanggal_keberangkatan`, `harga`, `stok_kursi`, `deskripsi`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'Jakarta - Bali Economy', 'Garuda Indonesia', 'Jakarta (CGK)', 'Bali (DPS)', '2025-07-15 08:00:00', 850000.00, 50, 'Penerbangan langsung Jakarta ke Bali dengan Garuda Indonesia. Termasuk bagasi 20kg, makan, dan minuman.', NULL, NOW(), NOW()),
(1, 'Jakarta - Surabaya Economy', 'Lion Air', 'Jakarta (CGK)', 'Surabaya (SUB)', '2025-07-20 10:30:00', 450000.00, 80, 'Penerbangan Jakarta - Surabaya dengan harga terjangkau. Bagasi kabin 7kg.', NULL, NOW(), NOW()),
(2, 'Jakarta - Singapura Economy', 'Singapore Airlines', 'Jakarta (CGK)', 'Singapura (SIN)', '2025-08-01 14:00:00', 2500000.00, 30, 'Penerbangan internasional ke Singapura. Termasuk makan dan bagasi 25kg.', NULL, NOW(), NOW()),
(3, 'Bali - Lombok PROMO', 'Citilink', 'Bali (DPS)', 'Lombok (LOP)', '2025-07-25 07:00:00', 199000.00, 100, 'Promo spesial Bali - Lombok! Harga terbaik terbatas. Bagasi 7kg.', NULL, NOW(), NOW()),
(4, 'Jakarta - Tokyo Business Class', 'Garuda Indonesia', 'Jakarta (CGK)', 'Tokyo (NRT)', '2025-08-10 22:00:00', 15000000.00, 10, 'Kelas bisnis premium Jakarta - Tokyo. Termasuk lounge, makan premium, bagasi 35kg, seat 180 derajat.', NULL, NOW(), NOW()),
(1, 'Medan - Jakarta Economy', 'Batik Air', 'Medan (KNO)', 'Jakarta (CGK)', '2025-07-18 06:00:00', 650000.00, 60, 'Penerbangan Medan - Jakarta pagi hari. Bagasi 20kg.', NULL, NOW(), NOW()),
(2, 'Jakarta - Kuala Lumpur Economy', 'AirAsia', 'Jakarta (CGK)', 'Kuala Lumpur (KUL)', '2025-07-30 09:00:00', 1200000.00, 45, 'Penerbangan Jakarta ke Kuala Lumpur Malaysia. Bagasi 20kg termasuk.', NULL, NOW(), NOW()),
(3, 'Yogyakarta - Bali PROMO', 'Wings Air', 'Yogyakarta (JOG)', 'Bali (DPS)', '2025-07-22 11:00:00', 350000.00, 70, 'Tiket promo spesial Yogyakarta ke Bali. Terbatas!', NULL, NOW(), NOW()),
(1, 'Makassar - Jakarta Economy', 'Garuda Indonesia', 'Makassar (UPG)', 'Jakarta (CGK)', '2025-07-28 07:30:00', 750000.00, 55, 'Penerbangan Makassar - Jakarta dengan Garuda Indonesia. Bagasi 20kg.', NULL, NOW(), NOW()),
(2, 'Jakarta - Dubai Economy', 'Emirates', 'Jakarta (CGK)', 'Dubai (DXB)', '2025-08-15 23:00:00', 5500000.00, 25, 'Penerbangan Jakarta ke Dubai dengan Emirates. Termasuk makan, hiburan, bagasi 30kg.', NULL, NOW(), NOW());

-- ORDERS
INSERT INTO `orders` (`user_id`, `kode_pesanan`, `nama_pembeli`, `email`, `no_hp`, `alamat`, `total_pembayaran`, `status_pesanan`, `created_at`, `updated_at`) VALUES
(2, 'SKY-DEMO001', 'Budi Santoso', 'budi@example.com', '082345678901', 'Jl. Merdeka No. 10, Bandung', 850000.00, 'dibayar', NOW(), NOW()),
(3, 'SKY-DEMO002', 'Siti Rahayu', 'siti@example.com', '083456789012', 'Jl. Diponegoro No. 5, Surabaya', 5000000.00, 'pending', NOW(), NOW()),
(4, 'SKY-DEMO003', 'Ahmad Fauzi', 'ahmad@example.com', '085678901234', 'Jl. Sudirman No. 3, Medan', 398000.00, 'selesai', NOW(), NOW());

-- ORDER ITEMS
INSERT INTO `order_items` (`order_id`, `product_id`, `jumlah`, `harga_satuan`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 850000.00, 850000.00, NOW(), NOW()),
(2, 3, 2, 2500000.00, 5000000.00, NOW(), NOW()),
(3, 4, 2, 199000.00, 398000.00, NOW(), NOW());

-- ============================================================
-- 5. VERIFIKASI RELASI
-- ============================================================
-- Cek relasi berhasil:
-- SELECT p.nama_tiket, c.nama_kategori FROM products p JOIN categories c ON p.category_id = c.id;
-- SELECT o.kode_pesanan, u.name, oi.jumlah, pr.nama_tiket FROM orders o JOIN users u ON o.user_id = u.id JOIN order_items oi ON oi.order_id = o.id JOIN products pr ON oi.product_id = pr.id;

-- ============================================================
-- SELESAI!
-- Login Admin: admin@skyjourney.com / admin123
-- Login User : budi@example.com / password
-- CATATAN: Gunakan "php artisan migrate --seed" untuk password yang benar
-- ============================================================
