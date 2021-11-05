-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主机： MYSQL
-- 生成日期： 2021-11-05 10:39:10
-- 服务器版本： 8.0.26
-- PHP 版本： 7.4.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `shop_q`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin_extensions`
--

CREATE TABLE `admin_extensions` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `version` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `is_enabled` tinyint NOT NULL DEFAULT '0',
  `options` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_extensions`
--

INSERT INTO `admin_extensions` (`id`, `name`, `version`, `is_enabled`, `options`, `created_at`, `updated_at`) VALUES
(1, 'dcat-admin.form-step', '1.0.0', 1, NULL, '2021-11-02 16:44:22', '2021-11-02 16:44:28');

-- --------------------------------------------------------

--
-- 表的结构 `admin_extension_histories`
--

CREATE TABLE `admin_extension_histories` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint NOT NULL DEFAULT '1',
  `version` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `detail` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_extension_histories`
--

INSERT INTO `admin_extension_histories` (`id`, `name`, `type`, `version`, `detail`, `created_at`, `updated_at`) VALUES
(1, 'dcat-admin.form-step', 1, '1.0.0', 'Initialize extension.', '2021-11-02 16:44:22', '2021-11-02 16:44:22');

-- --------------------------------------------------------

--
-- 表的结构 `admin_menu`
--

CREATE TABLE `admin_menu` (
  `id` bigint UNSIGNED NOT NULL,
  `parent_id` bigint NOT NULL DEFAULT '0',
  `order` int NOT NULL DEFAULT '0',
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `uri` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `extension` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `show` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_menu`
--

INSERT INTO `admin_menu` (`id`, `parent_id`, `order`, `title`, `icon`, `uri`, `extension`, `show`, `created_at`, `updated_at`) VALUES
(1, 0, 1, 'Index', 'feather icon-bar-chart-2', '/', '', 1, '2021-11-02 07:54:37', NULL),
(2, 0, 2, 'Admin', 'feather icon-settings', '', '', 1, '2021-11-02 07:54:37', NULL),
(3, 2, 3, 'Users', '', 'auth/users', '', 1, '2021-11-02 07:54:37', NULL),
(4, 2, 4, 'Roles', '', 'auth/roles', '', 1, '2021-11-02 07:54:37', NULL),
(5, 2, 5, 'Permission', '', 'auth/permissions', '', 1, '2021-11-02 07:54:37', NULL),
(6, 2, 6, 'Menu', '', 'auth/menu', '', 1, '2021-11-02 07:54:37', NULL),
(7, 2, 7, 'Extensions', '', 'auth/extensions', '', 1, '2021-11-02 07:54:37', NULL),
(8, 0, 8, '商品管理', NULL, NULL, '', 1, '2021-11-02 16:01:11', '2021-11-02 23:24:48'),
(9, 8, 9, '商品属性', NULL, '/attributes', '', 1, '2021-11-02 16:01:24', '2021-11-02 23:25:12'),
(10, 8, 10, '商品分类', NULL, '/categories', '', 1, '2021-11-02 16:12:13', '2021-11-02 23:25:05'),
(11, 8, 11, '商品列表', NULL, '/products', '', 1, '2021-11-02 16:38:23', '2021-11-02 23:24:56'),
(12, 0, 12, '订单列表', NULL, '/orders', '', 1, '2021-11-02 23:24:31', '2021-11-02 23:24:31');

-- --------------------------------------------------------

--
-- 表的结构 `admin_permissions`
--

CREATE TABLE `admin_permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `http_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `http_path` text COLLATE utf8mb4_unicode_ci,
  `order` int NOT NULL DEFAULT '0',
  `parent_id` bigint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_permissions`
--

INSERT INTO `admin_permissions` (`id`, `name`, `slug`, `http_method`, `http_path`, `order`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Auth management', 'auth-management', '', '', 1, 0, '2021-11-02 07:54:37', NULL),
(2, 'Users', 'users', '', '/auth/users*', 2, 1, '2021-11-02 07:54:37', NULL),
(3, 'Roles', 'roles', '', '/auth/roles*', 3, 1, '2021-11-02 07:54:37', NULL),
(4, 'Permissions', 'permissions', '', '/auth/permissions*', 4, 1, '2021-11-02 07:54:37', NULL),
(5, 'Menu', 'menu', '', '/auth/menu*', 5, 1, '2021-11-02 07:54:37', NULL),
(6, 'Extension', 'extension', '', '/auth/extensions*', 6, 1, '2021-11-02 07:54:37', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `admin_permission_menu`
--

CREATE TABLE `admin_permission_menu` (
  `permission_id` bigint NOT NULL,
  `menu_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `admin_roles`
--

CREATE TABLE `admin_roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_roles`
--

INSERT INTO `admin_roles` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'administrator', '2021-11-02 07:54:37', '2021-11-02 07:54:38');

-- --------------------------------------------------------

--
-- 表的结构 `admin_role_menu`
--

CREATE TABLE `admin_role_menu` (
  `role_id` bigint NOT NULL,
  `menu_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `admin_role_permissions`
--

CREATE TABLE `admin_role_permissions` (
  `role_id` bigint NOT NULL,
  `permission_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `admin_role_users`
--

CREATE TABLE `admin_role_users` (
  `role_id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_role_users`
--

INSERT INTO `admin_role_users` (`role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-11-02 07:54:38', '2021-11-02 07:54:38');

-- --------------------------------------------------------

--
-- 表的结构 `admin_settings`
--

CREATE TABLE `admin_settings` (
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `admin_users`
--

CREATE TABLE `admin_users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`, `name`, `avatar`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$vPE9jl9smxcCQ0sV2l0/PeeB7sww9pWNynzU87OuO10.69Bu5xX5a', 'Administrator', NULL, NULL, '2021-11-02 07:54:37', '2021-11-02 07:54:37');

-- --------------------------------------------------------

--
-- 表的结构 `attributes`
--

CREATE TABLE `attributes` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `attributes` json DEFAULT NULL,
  `skus` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `attributes`
--

INSERT INTO `attributes` (`id`, `name`, `attributes`, `skus`, `created_at`, `updated_at`) VALUES
(1, '大衣-默认', '[\"布料\", \"品牌\"]', '[\"大小\", \"颜色\"]', '2021-11-02 16:03:23', '2021-11-02 16:03:23');

-- --------------------------------------------------------

--
-- 表的结构 `categories`
--

CREATE TABLE `categories` (
  `id` bigint UNSIGNED NOT NULL,
  `parent_id` bigint UNSIGNED NOT NULL DEFAULT '0',
  `order` int DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `show` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `order`, `title`, `show`, `created_at`, `updated_at`) VALUES
(1, 0, 2, '2021新品', 1, '2021-11-02 16:13:45', '2021-11-02 16:13:59'),
(2, 0, 1, '2022新品', 1, '2021-11-02 16:13:55', '2021-11-02 16:13:59');

-- --------------------------------------------------------

--
-- 表的结构 `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_01_04_173148_create_admin_tables', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2020_09_07_090635_create_admin_settings_table', 1),
(6, '2020_09_22_015815_create_admin_extensions_table', 1),
(7, '2020_11_01_083237_update_admin_menu_table', 1),
(8, '2021_11_02_155618_create_attributes_table', 2),
(9, '2021_11_02_160449_create_categories_table', 3),
(13, '2021_11_02_161424_create_products_table', 4),
(14, '2021_11_02_230205_create_orders_table', 5);

-- --------------------------------------------------------

--
-- 表的结构 `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `pay_date` datetime DEFAULT NULL,
  `product_id` bigint UNSIGNED DEFAULT NULL,
  `snapshot` json DEFAULT NULL,
  `product_sku` json DEFAULT NULL,
  `custom_info` json DEFAULT NULL,
  `status` int NOT NULL DEFAULT '0',
  `pay_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pay_info` json DEFAULT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `orders`
--

INSERT INTO `orders` (`id`, `pay_date`, `product_id`, `snapshot`, `product_sku`, `custom_info`, `status`, `pay_method`, `pay_info`, `price`, `order_id`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, '\"{\\\"id\\\":1,\\\"title\\\":\\\"\\\\u5927\\\\u8863\\\",\\\"price\\\":222,\\\"show\\\":1,\\\"sales\\\":1,\\\"attribute_id\\\":1,\\\"description\\\":\\\"<p>23<\\\\/p>\\\",\\\"images\\\":\\\"[{\\\\\\\"value\\\\\\\":\\\\\\\"images\\\\\\\\\\\\/8eb1151bd2ed8eb5af75223371f75bf0.jpg\\\\\\\"},{\\\\\\\"value\\\\\\\":\\\\\\\"images\\\\\\\\\\\\/WX20211031-175353@2x.png\\\\\\\"},{\\\\\\\"value\\\\\\\":\\\\\\\"images\\\\\\\\\\\\/WX20211031-175757@2x.png\\\\\\\"}]\\\",\\\"attributes\\\":\\\"{\\\\\\\"\\\\\\\\u5e03\\\\\\\\u6599\\\\\\\":\\\\\\\"\\\\\\\\u6da4\\\\\\\\u7eb6\\\\\\\",\\\\\\\"\\\\\\\\u54c1\\\\\\\\u724c\\\\\\\":\\\\\\\"\\\\\\\\u53ca\\\\\\\\u5206\\\\\\\\u6790\\\\\\\"}\\\",\\\"skus\\\":\\\"{\\\\\\\"\\\\\\\\u5927\\\\\\\\u5c0f\\\\\\\":{\\\\\\\"new_1\\\\\\\":{\\\\\\\"value\\\\\\\":null,\\\\\\\"title\\\\\\\":\\\\\\\"x\\\\\\\",\\\\\\\"_remove_\\\\\\\":null,\\\\\\\"id\\\\\\\":\\\\\\\"new_1\\\\\\\"},\\\\\\\"new_2\\\\\\\":{\\\\\\\"value\\\\\\\":null,\\\\\\\"title\\\\\\\":\\\\\\\"l\\\\\\\",\\\\\\\"_remove_\\\\\\\":null,\\\\\\\"id\\\\\\\":\\\\\\\"new_2\\\\\\\"},\\\\\\\"new_3\\\\\\\":{\\\\\\\"value\\\\\\\":null,\\\\\\\"title\\\\\\\":\\\\\\\"xl\\\\\\\",\\\\\\\"_remove_\\\\\\\":null,\\\\\\\"id\\\\\\\":\\\\\\\"new_3\\\\\\\"},\\\\\\\"new_4\\\\\\\":{\\\\\\\"value\\\\\\\":null,\\\\\\\"title\\\\\\\":\\\\\\\"xxl\\\\\\\",\\\\\\\"_remove_\\\\\\\":null,\\\\\\\"id\\\\\\\":\\\\\\\"new_4\\\\\\\"}},\\\\\\\"\\\\\\\\u989c\\\\\\\\u8272\\\\\\\":{\\\\\\\"new_1\\\\\\\":{\\\\\\\"value\\\\\\\":null,\\\\\\\"title\\\\\\\":\\\\\\\"\\\\\\\\u9ec4\\\\\\\\u8272\\\\\\\",\\\\\\\"_remove_\\\\\\\":null,\\\\\\\"id\\\\\\\":\\\\\\\"new_1\\\\\\\"},\\\\\\\"new_2\\\\\\\":{\\\\\\\"value\\\\\\\":null,\\\\\\\"title\\\\\\\":\\\\\\\"\\\\\\\\u7ea2\\\\\\\\u8272\\\\\\\",\\\\\\\"_remove_\\\\\\\":null,\\\\\\\"id\\\\\\\":\\\\\\\"new_2\\\\\\\"},\\\\\\\"new_3\\\\\\\":{\\\\\\\"value\\\\\\\":null,\\\\\\\"title\\\\\\\":\\\\\\\"\\\\\\\\u7eff\\\\\\\\u8272\\\\\\\",\\\\\\\"_remove_\\\\\\\":null,\\\\\\\"id\\\\\\\":\\\\\\\"new_3\\\\\\\"}}}\\\",\\\"created_at\\\":\\\"2021-11-02 22:41:04\\\",\\\"updated_at\\\":\\\"2021-11-02 22:53:18\\\",\\\"sku\\\":\\\"{\\\\\\\"\\\\\\\\u5927\\\\\\\\u5c0f\\\\\\\":\\\\\\\"x\\\\\\\",\\\\\\\"\\\\\\\\u989c\\\\\\\\u8272\\\\\\\":\\\\\\\"\\\\\\\\u9ec4\\\\\\\\u8272\\\\\\\"}\\\"}\"', NULL, '\"{\\\"\\\\u6536\\\\u8d27\\\\u4eba\\\":\\\"\\\\u738b\\\\u82b1\\\\u82b1\\\",\\\"\\\\u6536\\\\u8d27\\\\u4eba\\\\u7535\\\\u8bdd\\\":\\\"13112344321\\\",\\\"\\\\u6536\\\\u8d27\\\\u4eba\\\\u5730\\\\u5740\\\":\\\"\\\\u56db\\\\u5ddd\\\\u7701\\\\u6210\\\\u90fd\\\\u5e02\\\\u82b1\\\\u90fd\\\\u5927\\\\u9053100\\\\u53f7\\\\u4e16\\\\u7eaa\\\\u5149\\\\u82b1\\\\u5c0f\\\\u533a3023\\\\u53f7\\\"}\"', 1, NULL, NULL, '222', '20211102235336192169', '2021-11-02 23:53:36', '2021-11-02 23:53:36');

-- --------------------------------------------------------

--
-- 表的结构 `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` int DEFAULT NULL,
  `show` tinyint(1) NOT NULL DEFAULT '1',
  `sales` int DEFAULT NULL,
  `attribute_id` bigint UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `images` json DEFAULT NULL,
  `attributes` json DEFAULT NULL,
  `skus` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `products`
--

INSERT INTO `products` (`id`, `title`, `price`, `show`, `sales`, `attribute_id`, `description`, `images`, `attributes`, `skus`, `created_at`, `updated_at`) VALUES
(1, '大衣', 222, 1, 1, 1, '<p>23</p>', '\"[{\\\"value\\\":\\\"images\\\\/8eb1151bd2ed8eb5af75223371f75bf0.jpg\\\"},{\\\"value\\\":\\\"images\\\\/WX20211031-175353@2x.png\\\"},{\\\"value\\\":\\\"images\\\\/WX20211031-175757@2x.png\\\"}]\"', '\"{\\\"\\\\u5e03\\\\u6599\\\":\\\"\\\\u6da4\\\\u7eb6\\\",\\\"\\\\u54c1\\\\u724c\\\":\\\"\\\\u53ca\\\\u5206\\\\u6790\\\"}\"', '\"{\\\"\\\\u5927\\\\u5c0f\\\":{\\\"new_1\\\":{\\\"value\\\":null,\\\"title\\\":\\\"x\\\",\\\"_remove_\\\":null,\\\"id\\\":\\\"new_1\\\"},\\\"new_2\\\":{\\\"value\\\":null,\\\"title\\\":\\\"l\\\",\\\"_remove_\\\":null,\\\"id\\\":\\\"new_2\\\"},\\\"new_3\\\":{\\\"value\\\":null,\\\"title\\\":\\\"xl\\\",\\\"_remove_\\\":null,\\\"id\\\":\\\"new_3\\\"},\\\"new_4\\\":{\\\"value\\\":null,\\\"title\\\":\\\"xxl\\\",\\\"_remove_\\\":null,\\\"id\\\":\\\"new_4\\\"}},\\\"\\\\u989c\\\\u8272\\\":{\\\"new_1\\\":{\\\"value\\\":null,\\\"title\\\":\\\"\\\\u9ec4\\\\u8272\\\",\\\"_remove_\\\":null,\\\"id\\\":\\\"new_1\\\"},\\\"new_2\\\":{\\\"value\\\":null,\\\"title\\\":\\\"\\\\u7ea2\\\\u8272\\\",\\\"_remove_\\\":null,\\\"id\\\":\\\"new_2\\\"},\\\"new_3\\\":{\\\"value\\\":null,\\\"title\\\":\\\"\\\\u7eff\\\\u8272\\\",\\\"_remove_\\\":null,\\\"id\\\":\\\"new_3\\\"}}}\"', '2021-11-02 22:41:04', '2021-11-02 22:53:18');

-- --------------------------------------------------------

--
-- 表的结构 `product_has_categories`
--

CREATE TABLE `product_has_categories` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `product_has_categories`
--

INSERT INTO `product_has_categories` (`id`, `product_id`, `category_id`) VALUES
(1, 1, 2),
(2, 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转储表的索引
--

--
-- 表的索引 `admin_extensions`
--
ALTER TABLE `admin_extensions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_extensions_name_unique` (`name`);

--
-- 表的索引 `admin_extension_histories`
--
ALTER TABLE `admin_extension_histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_extension_histories_name_index` (`name`);

--
-- 表的索引 `admin_menu`
--
ALTER TABLE `admin_menu`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `admin_permissions`
--
ALTER TABLE `admin_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_permissions_slug_unique` (`slug`);

--
-- 表的索引 `admin_permission_menu`
--
ALTER TABLE `admin_permission_menu`
  ADD UNIQUE KEY `admin_permission_menu_permission_id_menu_id_unique` (`permission_id`,`menu_id`);

--
-- 表的索引 `admin_roles`
--
ALTER TABLE `admin_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_roles_slug_unique` (`slug`);

--
-- 表的索引 `admin_role_menu`
--
ALTER TABLE `admin_role_menu`
  ADD UNIQUE KEY `admin_role_menu_role_id_menu_id_unique` (`role_id`,`menu_id`);

--
-- 表的索引 `admin_role_permissions`
--
ALTER TABLE `admin_role_permissions`
  ADD UNIQUE KEY `admin_role_permissions_role_id_permission_id_unique` (`role_id`,`permission_id`);

--
-- 表的索引 `admin_role_users`
--
ALTER TABLE `admin_role_users`
  ADD UNIQUE KEY `admin_role_users_role_id_user_id_unique` (`role_id`,`user_id`);

--
-- 表的索引 `admin_settings`
--
ALTER TABLE `admin_settings`
  ADD PRIMARY KEY (`slug`);

--
-- 表的索引 `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_users_username_unique` (`username`);

--
-- 表的索引 `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_order_id_index` (`order_id`);

--
-- 表的索引 `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- 表的索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `product_has_categories`
--
ALTER TABLE `product_has_categories`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `admin_extensions`
--
ALTER TABLE `admin_extensions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `admin_extension_histories`
--
ALTER TABLE `admin_extension_histories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `admin_menu`
--
ALTER TABLE `admin_menu`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用表AUTO_INCREMENT `admin_permissions`
--
ALTER TABLE `admin_permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `admin_roles`
--
ALTER TABLE `admin_roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- 使用表AUTO_INCREMENT `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `product_has_categories`
--
ALTER TABLE `product_has_categories`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
