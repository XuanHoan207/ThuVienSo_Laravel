-- ============================================
-- THƯ VIỆN SỐ - DIGITAL LIBRARY DATABASE
-- Updated: 2026-05-15
-- Based on: Yêu cầu thêm cho database
-- ============================================

-- 1. TÁCH AUTHORS VÀ BOOKS THÀNH MANY-TO-MANY
-- 2. THÊM TAGS (book_tag pivot)
-- 3. THÊM FULLTEXT INDEX
-- 4. THÊM DELETED_AT (SOFT DELETE)
-- 5. RATING GIỚI HẠN 1-5 VỚI UNIQUE
-- 6. BOOK STATUS ENUM
-- 7. THÊM NOTIFICATIONS
-- 8. THÊM REPORTS
-- 9. THÊM INDEXES
-- 10. THÊM ISBN, FILE_SIZE, FILE_TYPE
-- 11. THÊM SECURITY FIELDS
-- 12. ĐỔI TÊN BOOK_USER THÀNH PURCHASES
-- 13. THÊM DAILY_STATISTICS
-- ============================================

CREATE DATABASE IF NOT EXISTS `ThuVienSo_Laravel` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ThuVienSo_Laravel`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- ============================================
-- 1. USERS TABLE (với security fields)
-- ============================================
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  `role` enum('user','author','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `last_login_ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_index` (`role`),
  KEY `users_status_index` (`status`),
  KEY `users_deleted_at_index` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 2. AUTHORS TABLE (với soft delete)
-- ============================================
CREATE TABLE IF NOT EXISTS `authors` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `authors_slug_unique` (`slug`),
  KEY `authors_deleted_at_index` (`deleted_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 3. CATEGORIES TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_parent_id_foreign` (`parent_id`),
  CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 4. PUBLISHERS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS `publishers` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `info` text COLLATE utf8mb4_unicode_ci,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `publishers_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 5. BOOKS TABLE (nâng cấp)
-- - Bỏ author_id (dùng book_author)
-- - Thêm ENUM status
-- - Thêm ISBN, file_size, file_type
-- - Thêm FULLTEXT INDEX
-- - Thêm soft delete
-- ============================================
CREATE TABLE IF NOT EXISTS `books` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isbn` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_size` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'File size in bytes',
  `file_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'pdf, epub, mobi...',
  `description` text COLLATE utf8mb4_unicode_ci,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `publisher_id` bigint(20) UNSIGNED NOT NULL,
  `published_year` year(4) DEFAULT NULL,
  `pages` int(11) DEFAULT NULL,
  `language` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Vietnamese',
  `price_points` int(11) NOT NULL DEFAULT '0',
  `user_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Uploader',
  `status` enum('pending','approved','rejected','hidden') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `view_count` int(11) NOT NULL DEFAULT '0',
  `download_count` int(11) NOT NULL DEFAULT '0',
  `rating_avg` decimal(3,2) DEFAULT '0.00' COMMENT 'Cached average rating',
  `rating_count` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `books_slug_unique` (`slug`),
  UNIQUE KEY `books_isbn_unique` (`isbn`),
  FULLTEXT KEY `books_fulltext_index` (`title`, `description`),
  KEY `books_category_id_foreign` (`category_id`),
  KEY `books_publisher_id_foreign` (`publisher_id`),
  KEY `books_user_id_foreign` (`user_id`),
  KEY `books_status_index` (`status`),
  KEY `books_view_count_index` (`view_count`),
  KEY `books_download_count_index` (`download_count`),
  KEY `books_price_points_index` (`price_points`),
  KEY `books_created_at_index` (`created_at`),
  KEY `books_deleted_at_index` (`deleted_at`),
  CONSTRAINT `books_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `books_publisher_id_foreign` FOREIGN KEY (`publisher_id`) REFERENCES `publishers` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `books_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 6. BOOK_AUTHOR TABLE (MANY-TO-MANY)
-- ============================================
CREATE TABLE IF NOT EXISTS `book_author` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `author_id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('author','co-author','translator','editor') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'author',
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `book_author_unique` (`book_id`, `author_id`, `role`),
  KEY `book_author_book_id_index` (`book_id`),
  KEY `book_author_author_id_index` (`author_id`),
  CONSTRAINT `book_author_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `book_author_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `authors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 7. TAGS TABLE (MỚI)
-- ============================================
CREATE TABLE IF NOT EXISTS `tags` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '#ED553B',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 8. BOOK_TAG TABLE (PIVOT - MỚI)
-- ============================================
CREATE TABLE IF NOT EXISTS `book_tag` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `book_tag_unique` (`book_id`, `tag_id`),
  KEY `book_tag_book_id_index` (`book_id`),
  KEY `book_tag_tag_id_index` (`tag_id`),
  CONSTRAINT `book_tag_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `book_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 9. FAVORITES TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `favorites_user_id_book_id_unique` (`user_id`,`book_id`),
  KEY `favorites_book_id_foreign` (`book_id`),
  CONSTRAINT `favorites_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 10. COMMENTS TABLE (với soft delete)
-- ============================================
CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'For replies',
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'approved',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_user_id_foreign` (`user_id`),
  KEY `comments_book_id_foreign` (`book_id`),
  KEY `comments_parent_id_index` (`parent_id`),
  KEY `comments_deleted_at_index` (`deleted_at`),
  CONSTRAINT `comments_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `comments_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 11. RATINGS TABLE (nâng cấp)
-- - Giới hạn stars 1-5
-- - UNIQUE user_id + book_id
-- ============================================
CREATE TABLE IF NOT EXISTS `ratings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `stars` tinyint(3) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ratings_user_id_book_id_unique` (`user_id`, `book_id`),
  KEY `ratings_user_id_foreign` (`user_id`),
  KEY `ratings_book_id_foreign` (`book_id`),
  KEY `ratings_stars_index` (`stars`),
  CONSTRAINT `ratings_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ratings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `ratings_stars_check` CHECK (`stars` BETWEEN 1 AND 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 12. SETTINGS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'text',
  `group` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 13. SLIDERS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link_text` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'Xem thêm',
  `order` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sliders_status_order_index` (`status`, `order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 14. POINTS TRANSACTIONS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS `points_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT '0.00' COMMENT 'Số tiền thanh toán (VNĐ)',
  `points` int(11) NOT NULL COMMENT 'Số điểm nhận được/trừ',
  `type` enum('recharge','download','upload','refund','bonus','purchase') COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','completed','failed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reference_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `points_transactions_user_id_foreign` (`user_id`),
  KEY `points_transactions_type_index` (`type`),
  KEY `points_transactions_status_index` (`status`),
  KEY `points_transactions_created_at_index` (`created_at`),
  CONSTRAINT `points_transactions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 15. PURCHASES TABLE (ĐỔI TÊN TỪ BOOK_USER)
-- ============================================
CREATE TABLE IF NOT EXISTS `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `price_paid` int(11) NOT NULL DEFAULT '0' COMMENT 'Điểm đã trả',
  `payment_type` enum('points','free','promotion') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'points',
  `promotion_code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `purchases_user_book_unique` (`user_id`, `book_id`),
  KEY `purchases_book_id_foreign` (`book_id`),
  KEY `purchases_user_id_foreign` (`user_id`),
  KEY `purchases_created_at_index` (`created_at`),
  CONSTRAINT `purchases_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 16. BOOK_USER (GIỮ LẠI ĐỂ TƯƠNG THÍCH - SẼ XÓA SAU)
-- ============================================
-- CREATE TABLE IF NOT EXISTS `book_user` (
--   `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
--   `book_id` bigint(20) UNSIGNED NOT NULL,
--   `user_id` bigint(20) UNSIGNED NOT NULL,
--   `price_paid` int(11) NOT NULL DEFAULT '0',
--   `created_at` timestamp NULL DEFAULT NULL,
--   `updated_at` timestamp NULL DEFAULT NULL,
--   PRIMARY KEY (`id`),
--   KEY `book_user_book_id_foreign` (`book_id`),
--   KEY `book_user_user_id_foreign` (`user_id`),
--   CONSTRAINT `book_user_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
--   CONSTRAINT `book_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 17. CONTACT MESSAGES TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('unread','read','replied','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unread',
  `admin_reply` text COLLATE utf8mb4_unicode_ci,
  `replied_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contact_messages_user_id_foreign` (`user_id`),
  KEY `contact_messages_status_index` (`status`),
  KEY `contact_messages_created_at_index` (`created_at`),
  CONSTRAINT `contact_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 18. ACTIVITY LOGS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `activity_type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `entity_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'books, users, etc.',
  `entity_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  KEY `activity_logs_activity_type_index` (`activity_type`),
  KEY `activity_logs_created_at_index` (`created_at`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 19. BOOK VIEWS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS `book_views` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `book_views_book_id_foreign` (`book_id`),
  KEY `book_views_user_id_foreign` (`user_id`),
  KEY `book_views_viewed_at_index` (`viewed_at`),
  CONSTRAINT `book_views_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `book_views_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 20. BOOK DOWNLOADS TABLE
-- ============================================
CREATE TABLE IF NOT EXISTS `book_downloads` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `download_speed` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `downloaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `book_downloads_book_id_foreign` (`book_id`),
  KEY `book_downloads_user_id_foreign` (`user_id`),
  KEY `book_downloads_downloaded_at_index` (`downloaded_at`),
  CONSTRAINT `book_downloads_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `book_downloads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 21. NOTIFICATIONS TABLE (MỚI)
-- ============================================
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'book_approved, points_recharged, etc.',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'bi-bell',
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`),
  KEY `notifications_type_index` (`type`),
  KEY `notifications_is_read_index` (`is_read`),
  KEY `notifications_created_at_index` (`created_at`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 22. REPORTS TABLE (MỚI - Báo cáo vi phạm)
-- ============================================
CREATE TABLE IF NOT EXISTS `reports` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Người báo cáo',
  `book_id` bigint(20) UNSIGNED NOT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('copyright','inappropriate','broken_link','other') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'other',
  `status` enum('pending','resolved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `admin_note` text COLLATE utf8mb4_unicode_ci,
  `resolved_by` bigint(20) UNSIGNED DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reports_user_id_foreign` (`user_id`),
  KEY `reports_book_id_foreign` (`book_id`),
  KEY `reports_status_index` (`status`),
  KEY `reports_type_index` (`type`),
  KEY `reports_created_at_index` (`created_at`),
  CONSTRAINT `reports_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reports_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reports_resolved_by_foreign` FOREIGN KEY (`resolved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 23. DAILY STATISTICS TABLE (MỚI)
-- ============================================
CREATE TABLE IF NOT EXISTS `daily_statistics` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `total_users` int(11) NOT NULL DEFAULT '0',
  `new_users` int(11) NOT NULL DEFAULT '0',
  `total_books` int(11) NOT NULL DEFAULT '0',
  `new_books` int(11) NOT NULL DEFAULT '0',
  `total_downloads` int(11) NOT NULL DEFAULT '0',
  `total_views` int(11) NOT NULL DEFAULT '0',
  `total_revenue` decimal(15,2) NOT NULL DEFAULT '0.00',
  `total_points_spent` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `daily_statistics_date_unique` (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- 24. LARAVEL STANDARD TABLES
-- ============================================
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`, `tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(10) UNSIGNED DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(10) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- INSERT SAMPLE DATA
-- ============================================

-- Sample Categories
INSERT INTO `categories` (`name`, `slug`, `description`, `order`) VALUES
('Công nghệ thông tin', 'cong-nghe-thong-tin', 'Sách về lập trình, CNTT', 1),
('Khoa học', 'khoa-hoc', 'Sách khoa học tự nhiên', 2),
('Kinh tế', 'kinh-te', 'Sách kinh tế, tài chính', 3),
('Văn học', 'van-hoc', 'Tiểu thuyết, truyện ngắn', 4),
('Kỹ năng sống', 'ky-nang-song', 'Sách phát triển bản thân', 5),
('Giáo dục', 'giao-duc', 'Sách giáo dục, học thuật', 6);

-- Sample Tags
INSERT INTO `tags` (`name`, `slug`, `color`) VALUES
('Laravel', 'laravel', '#FF5722'),
('PHP', 'php', '#777BB4'),
('JavaScript', 'javascript', '#F7DF1E'),
('Python', 'python', '#3776AB'),
('AI', 'ai', '#9C27B0'),
('Machine Learning', 'machine-learning', '#E91E63'),
('Tiểu thuyết', 'tieu-thuyet', '#2196F3'),
('Kỹ năng sống', 'ky-nang-song', '#4CAF50'),
('Business', 'business', '#FF9800'),
('Marketing', 'marketing', '#00BCD4');

-- Sample Publishers
INSERT INTO `publishers` (`name`, `slug`, `info`) VALUES
('Nhà xuất bản Trẻ', 'nha-xuat-ban-tre', 'Nhà xuất bản sách uy tín'),
('Kim Đồng', 'kim-dong', 'Sách thiếu nhi và văn học'),
('FPT Software', 'fpt-software', 'Sách công nghệ'),
('First News', 'first-news', 'Sách ngoại văn');

-- Sample Settings
INSERT INTO `settings` (`key`, `value`, `type`, `group`) VALUES
('site_name', 'Thư Viện Số', 'text', 'general'),
('site_description', 'Thư viện sách trực tuyến hàng đầu Việt Nam', 'text', 'general'),
('contact_email', 'contact@thuvienso.vn', 'text', 'contact'),
('contact_phone', '1900 1234', 'text', 'contact'),
('points_rate', '100', 'text', 'points'), -- 1000 VND = 100 points
('min_recharge', '10000', 'text', 'points'), -- Min 10,000 VND
('max_upload_size', '52428800', 'text', 'upload'), -- 50MB
('allowed_file_types', 'pdf,epub', 'text', 'upload');

COMMIT;
