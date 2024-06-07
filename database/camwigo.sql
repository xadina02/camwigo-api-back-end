-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 07, 2024 at 08:54 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `camwigo`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_05_26_205801_create_routes_table', 1),
(6, '2024_05_26_205802_create_route_destinations_table', 1),
(7, '2024_05_26_205803_create_vehicle_categories_table', 1),
(8, '2024_05_26_205804_create_vehicles_table', 1),
(9, '2024_05_26_205805_create_route_schedules_table', 1),
(10, '2024_05_26_205806_create_vehicle_route_destinations_table', 1),
(11, '2024_05_26_205807_create_reservations_table', 1),
(12, '2024_05_26_205808_create_tickets_table', 1),
(13, '2024_05_26_225050_add_deleted_at_column_on_all_tables', 1),
(14, '2024_06_03_103631_create_settings_table', 1),
(15, '2024_06_03_232252_create_permission_tables', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'LT01347I5IWML7YBFA05AuthToken', 'b981e91bdf26e88fc7bcbe78622eadae868b3037955294ef278b07b2a2be6804', '[\"*\"]', '2024-06-07 05:52:30', NULL, '2024-06-07 02:23:21', '2024-06-07 05:52:30');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_route_destination_id` bigint(20) UNSIGNED NOT NULL,
  `position` int(11) NOT NULL,
  `amount_paid` double NOT NULL DEFAULT 0,
  `status` enum('completed','blocked','pending','paid','partial') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `vehicle_route_destination_id`, `position`, `amount_paid`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 33, 18, 500, 'completed', '2024-06-07 05:44:25', '2024-06-07 05:48:32', NULL),
(2, 1, 33, 19, 500, 'completed', '2024-06-07 05:44:54', '2024-06-07 05:52:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'passenger', 'web', '2024-06-07 02:23:09', '2024-06-07 02:23:09'),
(2, 'admin', 'web', '2024-06-07 02:23:09', '2024-06-07 02:23:09');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `origin` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`origin`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`id`, `origin`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '{\"en\":\"Buea\"}', '2024-06-07 04:37:19', '2024-06-07 04:37:19', NULL),
(2, '{\"en\":\"Kumba\"}', '2024-06-07 04:40:19', '2024-06-07 04:40:19', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `route_destinations`
--

CREATE TABLE `route_destinations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `route_id` bigint(20) UNSIGNED NOT NULL,
  `destination` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`destination`)),
  `price` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `route_destinations`
--

INSERT INTO `route_destinations` (`id`, `route_id`, `destination`, `price`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '{\"en\":\"Kumba\"}', 1500, '2024-06-07 04:37:19', '2024-06-07 04:37:19', NULL),
(2, 2, '{\"en\":\"Matoh\"}', 5000, '2024-06-07 04:40:19', '2024-06-07 04:40:19', NULL),
(3, 1, '{\"en\":\"Douala\"}', 1300, '2024-06-07 04:41:15', '2024-06-07 04:41:15', NULL),
(4, 1, '{\"en\":\"Mutengene\"}', 500, '2024-06-07 04:41:34', '2024-06-07 04:41:34', NULL),
(5, 1, '{\"en\":\"Limbe\"}', 1000, '2024-06-07 04:43:17', '2024-06-07 04:43:17', NULL),
(6, 2, '{\"en\":\"Buea\"}', 1500, '2024-06-07 04:43:51', '2024-06-07 04:43:51', NULL),
(7, 2, '{\"en\":\"Douala\"}', 2000, '2024-06-07 04:44:24', '2024-06-07 04:44:24', NULL),
(8, 2, '{\"en\":\"Muyuka\"}', 2000, '2024-06-07 04:44:57', '2024-06-07 04:44:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `route_schedules`
--

CREATE TABLE `route_schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `route_destination_id` bigint(20) UNSIGNED NOT NULL,
  `label` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`label`)),
  `departure_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `route_schedules`
--

INSERT INTO `route_schedules` (`id`, `route_destination_id`, `label`, `departure_time`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '{\"en\":\"Early Morning voyage\"}', '02:00:00', '2024-06-07 04:47:15', '2024-06-07 04:47:15', NULL),
(2, 2, '{\"en\":\"Early Morning voyage\"}', '02:00:00', '2024-06-07 04:47:30', '2024-06-07 04:47:30', NULL),
(3, 3, '{\"en\":\"Early Morning voyage\"}', '02:00:00', '2024-06-07 04:47:35', '2024-06-07 04:47:35', NULL),
(4, 4, '{\"en\":\"Early Morning voyage\"}', '02:00:00', '2024-06-07 04:47:39', '2024-06-07 04:47:39', NULL),
(5, 5, '{\"en\":\"Early Morning voyage\"}', '02:00:00', '2024-06-07 04:47:43', '2024-06-07 04:47:43', NULL),
(6, 6, '{\"en\":\"Early Morning voyage\"}', '02:00:00', '2024-06-07 04:47:47', '2024-06-07 04:47:47', NULL),
(7, 7, '{\"en\":\"Early Morning voyage\"}', '02:00:00', '2024-06-07 04:47:51', '2024-06-07 04:47:51', NULL),
(8, 8, '{\"en\":\"Early Morning voyage\"}', '02:00:00', '2024-06-07 04:47:56', '2024-06-07 04:47:56', NULL),
(9, 1, '{\"en\":\"Morning voyage\"}', '07:00:00', '2024-06-07 04:48:32', '2024-06-07 04:48:32', NULL),
(10, 2, '{\"en\":\"Morning voyage\"}', '07:00:00', '2024-06-07 04:48:36', '2024-06-07 04:48:36', NULL),
(11, 3, '{\"en\":\"Morning voyage\"}', '07:00:00', '2024-06-07 04:48:40', '2024-06-07 04:48:40', NULL),
(12, 4, '{\"en\":\"Morning voyage\"}', '07:00:00', '2024-06-07 04:48:44', '2024-06-07 04:48:44', NULL),
(13, 5, '{\"en\":\"Morning voyage\"}', '07:00:00', '2024-06-07 04:48:48', '2024-06-07 04:48:48', NULL),
(14, 6, '{\"en\":\"Morning voyage\"}', '07:00:00', '2024-06-07 04:49:02', '2024-06-07 04:49:02', NULL),
(15, 7, '{\"en\":\"Morning voyage\"}', '07:00:00', '2024-06-07 04:49:06', '2024-06-07 04:49:06', NULL),
(16, 8, '{\"en\":\"Morning voyage\"}', '07:00:00', '2024-06-07 04:49:10', '2024-06-07 04:49:10', NULL),
(17, 1, '{\"en\":\"Noon-Hour voyage\"}', '12:00:00', '2024-06-07 04:49:46', '2024-06-07 04:49:46', NULL),
(18, 2, '{\"en\":\"Noon-Hour voyage\"}', '12:00:00', '2024-06-07 04:49:51', '2024-06-07 04:49:51', NULL),
(19, 3, '{\"en\":\"Noon-Hour voyage\"}', '12:00:00', '2024-06-07 04:49:55', '2024-06-07 04:49:55', NULL),
(20, 4, '{\"en\":\"Noon-Hour voyage\"}', '12:00:00', '2024-06-07 04:49:59', '2024-06-07 04:49:59', NULL),
(21, 5, '{\"en\":\"Noon-Hour voyage\"}', '12:00:00', '2024-06-07 04:50:04', '2024-06-07 04:50:04', NULL),
(22, 6, '{\"en\":\"Noon-Hour voyage\"}', '12:00:00', '2024-06-07 04:50:08', '2024-06-07 04:50:08', NULL),
(23, 7, '{\"en\":\"Noon-Hour voyage\"}', '12:00:00', '2024-06-07 04:50:13', '2024-06-07 04:50:13', NULL),
(24, 8, '{\"en\":\"Noon-Hour voyage\"}', '12:00:00', '2024-06-07 04:50:17', '2024-06-07 04:50:17', NULL),
(25, 1, '{\"en\":\"Traffic-Hour voyage\"}', '16:00:00', '2024-06-07 04:53:58', '2024-06-07 04:53:58', NULL),
(26, 2, '{\"en\":\"Traffic-Hour voyage\"}', '16:00:00', '2024-06-07 04:54:03', '2024-06-07 04:54:03', NULL),
(27, 3, '{\"en\":\"Traffic-Hour voyage\"}', '16:00:00', '2024-06-07 04:54:11', '2024-06-07 04:54:11', NULL),
(28, 4, '{\"en\":\"Traffic-Hour voyage\"}', '16:00:00', '2024-06-07 04:54:14', '2024-06-07 04:54:14', NULL),
(29, 5, '{\"en\":\"Traffic-Hour voyage\"}', '16:00:00', '2024-06-07 04:54:19', '2024-06-07 04:54:19', NULL),
(30, 6, '{\"en\":\"Traffic-Hour voyage\"}', '16:00:00', '2024-06-07 04:54:23', '2024-06-07 04:54:23', NULL),
(31, 7, '{\"en\":\"Traffic-Hour voyage\"}', '16:00:00', '2024-06-07 04:54:28', '2024-06-07 04:54:28', NULL),
(32, 8, '{\"en\":\"Traffic-Hour voyage\"}', '16:00:00', '2024-06-07 04:54:32', '2024-06-07 04:54:32', NULL),
(33, 1, '{\"en\":\"Late Night voyage\"}', '21:00:00', '2024-06-07 04:55:42', '2024-06-07 04:55:42', NULL),
(34, 2, '{\"en\":\"Late Night voyage\"}', '21:00:00', '2024-06-07 04:55:46', '2024-06-07 04:55:46', NULL),
(35, 3, '{\"en\":\"Late Night voyage\"}', '21:00:00', '2024-06-07 04:55:51', '2024-06-07 04:55:51', NULL),
(36, 4, '{\"en\":\"Late Night voyage\"}', '21:00:00', '2024-06-07 04:55:55', '2024-06-07 04:55:55', NULL),
(37, 5, '{\"en\":\"Late Night voyage\"}', '21:00:00', '2024-06-07 04:56:00', '2024-06-07 04:56:00', NULL),
(38, 6, '{\"en\":\"Late Night voyage\"}', '21:00:00', '2024-06-07 04:56:05', '2024-06-07 04:56:05', NULL),
(39, 7, '{\"en\":\"Late Night voyage\"}', '21:00:00', '2024-06-07 04:56:11', '2024-06-07 04:56:11', NULL),
(40, 8, '{\"en\":\"Late Night voyage\"}', '21:00:00', '2024-06-07 04:56:16', '2024-06-07 04:56:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `label`, `value`, `created_at`, `updated_at`) VALUES
(1, 'agency', 'Mondial Express', '2024-06-07 02:24:19', '2024-06-07 02:24:19'),
(2, 'address', 'Mile 17, Buea', '2024-06-07 02:24:19', '2024-06-07 02:24:19'),
(3, 'email', 'modial@travel.com', '2024-06-07 02:24:19', '2024-06-07 02:24:19'),
(4, 'logo', '/images/agency-logo/1717730659_66627d634180d.png', '2024-06-07 02:24:19', '2024-06-07 02:24:19');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `reservation_id` bigint(20) UNSIGNED NOT NULL,
  `QR_code_image_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('new','used') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `validity` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `reservation_id`, `QR_code_image_link`, `status`, `validity`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, '/images/ticket-qr-codes/1717742912_6662ad4094b37_2024-06-07 06:48:31-2024-06-07 02:30:001_qr_code.png', 'new', '2024-06-07 01:30:00', '2024-06-07 05:48:31', '2024-06-07 05:48:31', NULL),
(2, 2, '/images/ticket-qr-codes/1717743151_6662ae2f7d3e8_2024-06-07 06:52:30-2024-06-07 02:30:002_qr_code.png', 'new', '2024-06-07 01:30:00', '2024-06-07 05:52:30', '2024-06-07 05:52:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NIN` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `phone`, `NIN`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Mosongo', 'Cute', 'yhoungcute@gmail.com', '671586513', 'LT01347I5IWML7YBFA05', NULL, NULL, NULL, '2024-06-07 02:23:21', '2024-06-07 02:23:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `vehicle_category_id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'BUS-LT00975', '2024-06-07 04:32:58', '2024-06-07 04:32:58', NULL),
(2, 1, 'BUS-CT00741', '2024-06-07 04:33:23', '2024-06-07 04:33:23', NULL),
(3, 2, 'BUS-SW54619', '2024-06-07 04:34:02', '2024-06-07 04:34:02', NULL),
(4, 2, 'BUS-NW66710', '2024-06-07 04:34:17', '2024-06-07 04:34:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_categories`
--

CREATE TABLE `vehicle_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`name`)),
  `size` int(11) NOT NULL,
  `icon_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_categories`
--

INSERT INTO `vehicle_categories` (`id`, `name`, `size`, `icon_link`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '{\"en\":\"70-Seater\"}', 70, '/images/vehicle-category/1717738033_66629a3179c73.svg', '2024-06-07 04:27:13', '2024-06-07 04:27:13', NULL),
(2, '{\"en\":\"30-Seater\"}', 30, '/images/vehicle-category/1717738154_66629aaa87736.png', '2024-06-07 04:29:14', '2024-06-07 04:29:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_route_destinations`
--

CREATE TABLE `vehicle_route_destinations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vehicle_id` bigint(20) UNSIGNED NOT NULL,
  `route_schedule_id` bigint(20) UNSIGNED NOT NULL,
  `available_seats` int(11) NOT NULL,
  `reserved_seats` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vehicle_route_destinations`
--

INSERT INTO `vehicle_route_destinations` (`id`, `vehicle_id`, `route_schedule_id`, `available_seats`, `reserved_seats`, `date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:26:59', '2024-06-07 05:26:59', NULL),
(2, 1, 1, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:26:59', '2024-06-07 05:26:59', NULL),
(3, 1, 1, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:26:59', '2024-06-07 05:26:59', NULL),
(4, 1, 1, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:26:59', '2024-06-07 05:26:59', NULL),
(5, 1, 1, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:26:59', '2024-06-07 05:26:59', NULL),
(6, 1, 1, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:26:59', '2024-06-07 05:26:59', NULL),
(7, 1, 1, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:26:59', '2024-06-07 05:26:59', NULL),
(8, 1, 1, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:26:59', '2024-06-07 05:26:59', NULL),
(9, 1, 1, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:26:59', '2024-06-07 05:26:59', NULL),
(10, 1, 1, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:26:59', '2024-06-07 05:26:59', NULL),
(11, 1, 1, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:26:59', '2024-06-07 05:26:59', NULL),
(12, 1, 1, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:26:59', '2024-06-07 05:26:59', NULL),
(13, 1, 1, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:26:59', '2024-06-07 05:26:59', NULL),
(14, 1, 1, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:26:59', '2024-06-07 05:26:59', NULL),
(15, 1, 3, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:27:36', '2024-06-07 05:27:36', NULL),
(16, 1, 3, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:27:36', '2024-06-07 05:27:36', NULL),
(17, 1, 3, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:27:36', '2024-06-07 05:27:36', NULL),
(18, 1, 3, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:27:36', '2024-06-07 05:27:36', NULL),
(19, 1, 3, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:27:36', '2024-06-07 05:27:36', NULL),
(20, 1, 3, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:27:36', '2024-06-07 05:27:36', NULL),
(21, 1, 3, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:27:36', '2024-06-07 05:27:36', NULL),
(22, 1, 3, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:27:36', '2024-06-07 05:27:36', NULL),
(23, 1, 3, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:27:36', '2024-06-07 05:27:36', NULL),
(24, 1, 3, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:27:36', '2024-06-07 05:27:36', NULL),
(25, 1, 3, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:27:36', '2024-06-07 05:27:36', NULL),
(26, 1, 3, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:27:36', '2024-06-07 05:27:36', NULL),
(27, 1, 3, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:27:36', '2024-06-07 05:27:36', NULL),
(28, 1, 3, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:27:36', '2024-06-07 05:27:36', NULL),
(29, 1, 4, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:27:50', '2024-06-07 05:27:50', NULL),
(30, 1, 4, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:27:50', '2024-06-07 05:27:50', NULL),
(31, 1, 4, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:27:50', '2024-06-07 05:27:50', NULL),
(32, 1, 4, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:27:50', '2024-06-07 05:27:50', NULL),
(33, 1, 4, 68, 2, '2024-06-07 06:44:54', '2024-06-07 05:27:50', '2024-06-07 05:44:54', NULL),
(34, 1, 4, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:27:50', '2024-06-07 05:27:50', NULL),
(35, 1, 4, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:27:50', '2024-06-07 05:27:50', NULL),
(36, 1, 4, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:27:50', '2024-06-07 05:27:50', NULL),
(37, 1, 4, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:27:50', '2024-06-07 05:27:50', NULL),
(38, 1, 4, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:27:50', '2024-06-07 05:27:50', NULL),
(39, 1, 4, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:27:50', '2024-06-07 05:27:50', NULL),
(40, 1, 4, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:27:50', '2024-06-07 05:27:50', NULL),
(41, 1, 4, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:27:50', '2024-06-07 05:27:50', NULL),
(42, 1, 4, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:27:50', '2024-06-07 05:27:50', NULL),
(43, 1, 5, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:27:56', '2024-06-07 05:27:56', NULL),
(44, 1, 5, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:27:56', '2024-06-07 05:27:56', NULL),
(45, 1, 5, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:27:56', '2024-06-07 05:27:56', NULL),
(46, 1, 5, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:27:56', '2024-06-07 05:27:56', NULL),
(47, 1, 5, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:27:56', '2024-06-07 05:27:56', NULL),
(48, 1, 5, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:27:56', '2024-06-07 05:27:56', NULL),
(49, 1, 5, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:27:56', '2024-06-07 05:27:56', NULL),
(50, 1, 5, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:27:56', '2024-06-07 05:27:56', NULL),
(51, 1, 5, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:27:56', '2024-06-07 05:27:56', NULL),
(52, 1, 5, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:27:56', '2024-06-07 05:27:56', NULL),
(53, 1, 5, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:27:56', '2024-06-07 05:27:56', NULL),
(54, 1, 5, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:27:56', '2024-06-07 05:27:56', NULL),
(55, 1, 5, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:27:56', '2024-06-07 05:27:56', NULL),
(56, 1, 5, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:27:56', '2024-06-07 05:27:56', NULL),
(57, 1, 8, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:28:02', '2024-06-07 05:28:02', NULL),
(58, 1, 8, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:28:02', '2024-06-07 05:28:02', NULL),
(59, 1, 8, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:28:02', '2024-06-07 05:28:02', NULL),
(60, 1, 8, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:28:02', '2024-06-07 05:28:02', NULL),
(61, 1, 8, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:28:02', '2024-06-07 05:28:02', NULL),
(62, 1, 8, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:28:02', '2024-06-07 05:28:02', NULL),
(63, 1, 8, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:28:02', '2024-06-07 05:28:02', NULL),
(64, 1, 8, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:28:02', '2024-06-07 05:28:02', NULL),
(65, 1, 8, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:28:02', '2024-06-07 05:28:02', NULL),
(66, 1, 8, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:28:02', '2024-06-07 05:28:02', NULL),
(67, 1, 8, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:28:02', '2024-06-07 05:28:02', NULL),
(68, 1, 8, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:28:02', '2024-06-07 05:28:02', NULL),
(69, 1, 8, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:28:02', '2024-06-07 05:28:02', NULL),
(70, 1, 8, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:28:02', '2024-06-07 05:28:02', NULL),
(71, 1, 9, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:28:10', '2024-06-07 05:28:10', NULL),
(72, 1, 9, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:28:10', '2024-06-07 05:28:10', NULL),
(73, 1, 9, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:28:10', '2024-06-07 05:28:10', NULL),
(74, 1, 9, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:28:10', '2024-06-07 05:28:10', NULL),
(75, 1, 9, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:28:10', '2024-06-07 05:28:10', NULL),
(76, 1, 9, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:28:10', '2024-06-07 05:28:10', NULL),
(77, 1, 9, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:28:10', '2024-06-07 05:28:10', NULL),
(78, 1, 9, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:28:10', '2024-06-07 05:28:10', NULL),
(79, 1, 9, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:28:10', '2024-06-07 05:28:10', NULL),
(80, 1, 9, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:28:10', '2024-06-07 05:28:10', NULL),
(81, 1, 9, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:28:10', '2024-06-07 05:28:10', NULL),
(82, 1, 9, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:28:10', '2024-06-07 05:28:10', NULL),
(83, 1, 9, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:28:10', '2024-06-07 05:28:10', NULL),
(84, 1, 9, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:28:10', '2024-06-07 05:28:10', NULL),
(85, 3, 1, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:28:58', '2024-06-07 05:28:58', NULL),
(86, 3, 1, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:28:58', '2024-06-07 05:28:58', NULL),
(87, 3, 1, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:28:58', '2024-06-07 05:28:58', NULL),
(88, 3, 1, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:28:58', '2024-06-07 05:28:58', NULL),
(89, 3, 1, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:28:58', '2024-06-07 05:28:58', NULL),
(90, 3, 1, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:28:58', '2024-06-07 05:28:58', NULL),
(91, 3, 1, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:28:58', '2024-06-07 05:28:58', NULL),
(92, 3, 1, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:28:58', '2024-06-07 05:28:58', NULL),
(93, 3, 1, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:28:58', '2024-06-07 05:28:58', NULL),
(94, 3, 1, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:28:58', '2024-06-07 05:28:58', NULL),
(95, 3, 1, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:28:58', '2024-06-07 05:28:58', NULL),
(96, 3, 1, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:28:58', '2024-06-07 05:28:58', NULL),
(97, 3, 1, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:28:58', '2024-06-07 05:28:58', NULL),
(98, 3, 1, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:28:58', '2024-06-07 05:28:58', NULL),
(99, 3, 3, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:29:03', '2024-06-07 05:29:03', NULL),
(100, 3, 3, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:29:03', '2024-06-07 05:29:03', NULL),
(101, 3, 3, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:29:03', '2024-06-07 05:29:03', NULL),
(102, 3, 3, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:29:03', '2024-06-07 05:29:03', NULL),
(103, 3, 3, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:29:03', '2024-06-07 05:29:03', NULL),
(104, 3, 3, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:29:03', '2024-06-07 05:29:03', NULL),
(105, 3, 3, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:29:03', '2024-06-07 05:29:03', NULL),
(106, 3, 3, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:29:03', '2024-06-07 05:29:03', NULL),
(107, 3, 3, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:29:03', '2024-06-07 05:29:03', NULL),
(108, 3, 3, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:29:03', '2024-06-07 05:29:03', NULL),
(109, 3, 3, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:29:03', '2024-06-07 05:29:03', NULL),
(110, 3, 3, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:29:03', '2024-06-07 05:29:03', NULL),
(111, 3, 3, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:29:03', '2024-06-07 05:29:03', NULL),
(112, 3, 3, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:29:03', '2024-06-07 05:29:03', NULL),
(113, 3, 4, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:29:08', '2024-06-07 05:29:08', NULL),
(114, 3, 4, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:29:08', '2024-06-07 05:29:08', NULL),
(115, 3, 4, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:29:08', '2024-06-07 05:29:08', NULL),
(116, 3, 4, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:29:08', '2024-06-07 05:29:08', NULL),
(117, 3, 4, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:29:08', '2024-06-07 05:29:08', NULL),
(118, 3, 4, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:29:08', '2024-06-07 05:29:08', NULL),
(119, 3, 4, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:29:08', '2024-06-07 05:29:08', NULL),
(120, 3, 4, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:29:08', '2024-06-07 05:29:08', NULL),
(121, 3, 4, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:29:08', '2024-06-07 05:29:08', NULL),
(122, 3, 4, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:29:08', '2024-06-07 05:29:08', NULL),
(123, 3, 4, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:29:08', '2024-06-07 05:29:08', NULL),
(124, 3, 4, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:29:08', '2024-06-07 05:29:08', NULL),
(125, 3, 4, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:29:08', '2024-06-07 05:29:08', NULL),
(126, 3, 4, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:29:08', '2024-06-07 05:29:08', NULL),
(127, 3, 5, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:29:14', '2024-06-07 05:29:14', NULL),
(128, 3, 5, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:29:14', '2024-06-07 05:29:14', NULL),
(129, 3, 5, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:29:14', '2024-06-07 05:29:14', NULL),
(130, 3, 5, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:29:14', '2024-06-07 05:29:14', NULL),
(131, 3, 5, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:29:14', '2024-06-07 05:29:14', NULL),
(132, 3, 5, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:29:14', '2024-06-07 05:29:14', NULL),
(133, 3, 5, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:29:14', '2024-06-07 05:29:14', NULL),
(134, 3, 5, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:29:14', '2024-06-07 05:29:14', NULL),
(135, 3, 5, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:29:14', '2024-06-07 05:29:14', NULL),
(136, 3, 5, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:29:14', '2024-06-07 05:29:14', NULL),
(137, 3, 5, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:29:14', '2024-06-07 05:29:14', NULL),
(138, 3, 5, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:29:14', '2024-06-07 05:29:14', NULL),
(139, 3, 5, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:29:14', '2024-06-07 05:29:14', NULL),
(140, 3, 5, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:29:14', '2024-06-07 05:29:14', NULL),
(141, 3, 8, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:29:19', '2024-06-07 05:29:19', NULL),
(142, 3, 8, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:29:19', '2024-06-07 05:29:19', NULL),
(143, 3, 8, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:29:19', '2024-06-07 05:29:19', NULL),
(144, 3, 8, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:29:19', '2024-06-07 05:29:19', NULL),
(145, 3, 8, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:29:19', '2024-06-07 05:29:19', NULL),
(146, 3, 8, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:29:19', '2024-06-07 05:29:19', NULL),
(147, 3, 8, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:29:19', '2024-06-07 05:29:19', NULL),
(148, 3, 8, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:29:19', '2024-06-07 05:29:19', NULL),
(149, 3, 8, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:29:19', '2024-06-07 05:29:19', NULL),
(150, 3, 8, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:29:19', '2024-06-07 05:29:19', NULL),
(151, 3, 8, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:29:19', '2024-06-07 05:29:19', NULL),
(152, 3, 8, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:29:19', '2024-06-07 05:29:19', NULL),
(153, 3, 8, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:29:19', '2024-06-07 05:29:19', NULL),
(154, 3, 8, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:29:19', '2024-06-07 05:29:19', NULL),
(155, 3, 9, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:29:24', '2024-06-07 05:29:24', NULL),
(156, 3, 9, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:29:24', '2024-06-07 05:29:24', NULL),
(157, 3, 9, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:29:24', '2024-06-07 05:29:24', NULL),
(158, 3, 9, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:29:24', '2024-06-07 05:29:24', NULL),
(159, 3, 9, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:29:24', '2024-06-07 05:29:24', NULL),
(160, 3, 9, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:29:24', '2024-06-07 05:29:24', NULL),
(161, 3, 9, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:29:24', '2024-06-07 05:29:24', NULL),
(162, 3, 9, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:29:24', '2024-06-07 05:29:24', NULL),
(163, 3, 9, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:29:24', '2024-06-07 05:29:24', NULL),
(164, 3, 9, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:29:24', '2024-06-07 05:29:24', NULL),
(165, 3, 9, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:29:24', '2024-06-07 05:29:24', NULL),
(166, 3, 9, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:29:24', '2024-06-07 05:29:24', NULL),
(167, 3, 9, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:29:24', '2024-06-07 05:29:24', NULL),
(168, 3, 9, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:29:24', '2024-06-07 05:29:24', NULL),
(169, 1, 11, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:29:34', '2024-06-07 05:29:34', NULL),
(170, 1, 11, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:29:34', '2024-06-07 05:29:34', NULL),
(171, 1, 11, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:29:34', '2024-06-07 05:29:34', NULL),
(172, 1, 11, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:29:34', '2024-06-07 05:29:34', NULL),
(173, 1, 11, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:29:34', '2024-06-07 05:29:34', NULL),
(174, 1, 11, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:29:34', '2024-06-07 05:29:34', NULL),
(175, 1, 11, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:29:34', '2024-06-07 05:29:34', NULL),
(176, 1, 11, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:29:34', '2024-06-07 05:29:34', NULL),
(177, 1, 11, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:29:34', '2024-06-07 05:29:34', NULL),
(178, 1, 11, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:29:34', '2024-06-07 05:29:34', NULL),
(179, 1, 11, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:29:34', '2024-06-07 05:29:34', NULL),
(180, 1, 11, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:29:34', '2024-06-07 05:29:34', NULL),
(181, 1, 11, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:29:34', '2024-06-07 05:29:34', NULL),
(182, 1, 11, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:29:34', '2024-06-07 05:29:34', NULL),
(183, 3, 11, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:29:42', '2024-06-07 05:29:42', NULL),
(184, 3, 11, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:29:42', '2024-06-07 05:29:42', NULL),
(185, 3, 11, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:29:42', '2024-06-07 05:29:42', NULL),
(186, 3, 11, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:29:42', '2024-06-07 05:29:42', NULL),
(187, 3, 11, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:29:42', '2024-06-07 05:29:42', NULL),
(188, 3, 11, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:29:42', '2024-06-07 05:29:42', NULL),
(189, 3, 11, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:29:42', '2024-06-07 05:29:42', NULL),
(190, 3, 11, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:29:42', '2024-06-07 05:29:42', NULL),
(191, 3, 11, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:29:42', '2024-06-07 05:29:42', NULL),
(192, 3, 11, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:29:42', '2024-06-07 05:29:42', NULL),
(193, 3, 11, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:29:42', '2024-06-07 05:29:42', NULL),
(194, 3, 11, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:29:42', '2024-06-07 05:29:42', NULL),
(195, 3, 11, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:29:42', '2024-06-07 05:29:42', NULL),
(196, 3, 11, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:29:42', '2024-06-07 05:29:42', NULL),
(197, 1, 12, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:29:58', '2024-06-07 05:29:58', NULL),
(198, 1, 12, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:29:58', '2024-06-07 05:29:58', NULL),
(199, 1, 12, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:29:58', '2024-06-07 05:29:58', NULL),
(200, 1, 12, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:29:58', '2024-06-07 05:29:58', NULL),
(201, 1, 12, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:29:58', '2024-06-07 05:29:58', NULL),
(202, 1, 12, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:29:58', '2024-06-07 05:29:58', NULL),
(203, 1, 12, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:29:58', '2024-06-07 05:29:58', NULL),
(204, 1, 12, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:29:58', '2024-06-07 05:29:58', NULL),
(205, 1, 12, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:29:58', '2024-06-07 05:29:58', NULL),
(206, 1, 12, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:29:58', '2024-06-07 05:29:58', NULL),
(207, 1, 12, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:29:58', '2024-06-07 05:29:58', NULL),
(208, 1, 12, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:29:58', '2024-06-07 05:29:58', NULL),
(209, 1, 12, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:29:58', '2024-06-07 05:29:58', NULL),
(210, 1, 12, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:29:58', '2024-06-07 05:29:58', NULL),
(211, 1, 13, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:30:03', '2024-06-07 05:30:03', NULL),
(212, 1, 13, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:30:03', '2024-06-07 05:30:03', NULL),
(213, 1, 13, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:30:03', '2024-06-07 05:30:03', NULL),
(214, 1, 13, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:30:03', '2024-06-07 05:30:03', NULL),
(215, 1, 13, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:30:03', '2024-06-07 05:30:03', NULL),
(216, 1, 13, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:30:03', '2024-06-07 05:30:03', NULL),
(217, 1, 13, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:30:03', '2024-06-07 05:30:03', NULL),
(218, 1, 13, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:30:03', '2024-06-07 05:30:03', NULL),
(219, 1, 13, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:30:03', '2024-06-07 05:30:03', NULL),
(220, 1, 13, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:30:03', '2024-06-07 05:30:03', NULL),
(221, 1, 13, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:30:03', '2024-06-07 05:30:03', NULL),
(222, 1, 13, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:30:03', '2024-06-07 05:30:03', NULL),
(223, 1, 13, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:30:03', '2024-06-07 05:30:03', NULL),
(224, 1, 13, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:30:03', '2024-06-07 05:30:03', NULL),
(225, 1, 16, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:30:09', '2024-06-07 05:30:09', NULL),
(226, 1, 16, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:30:09', '2024-06-07 05:30:09', NULL),
(227, 1, 16, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:30:09', '2024-06-07 05:30:09', NULL),
(228, 1, 16, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:30:09', '2024-06-07 05:30:09', NULL),
(229, 1, 16, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:30:09', '2024-06-07 05:30:09', NULL),
(230, 1, 16, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:30:09', '2024-06-07 05:30:09', NULL),
(231, 1, 16, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:30:09', '2024-06-07 05:30:09', NULL),
(232, 1, 16, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:30:09', '2024-06-07 05:30:09', NULL),
(233, 1, 16, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:30:09', '2024-06-07 05:30:09', NULL),
(234, 1, 16, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:30:09', '2024-06-07 05:30:09', NULL),
(235, 1, 16, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:30:09', '2024-06-07 05:30:09', NULL),
(236, 1, 16, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:30:09', '2024-06-07 05:30:09', NULL),
(237, 1, 16, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:30:09', '2024-06-07 05:30:09', NULL),
(238, 1, 16, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:30:09', '2024-06-07 05:30:09', NULL),
(239, 1, 17, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:30:14', '2024-06-07 05:30:14', NULL),
(240, 1, 17, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:30:14', '2024-06-07 05:30:14', NULL),
(241, 1, 17, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:30:14', '2024-06-07 05:30:14', NULL),
(242, 1, 17, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:30:14', '2024-06-07 05:30:14', NULL),
(243, 1, 17, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:30:14', '2024-06-07 05:30:14', NULL),
(244, 1, 17, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:30:14', '2024-06-07 05:30:14', NULL),
(245, 1, 17, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:30:14', '2024-06-07 05:30:14', NULL),
(246, 1, 17, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:30:14', '2024-06-07 05:30:14', NULL),
(247, 1, 17, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:30:14', '2024-06-07 05:30:14', NULL),
(248, 1, 17, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:30:14', '2024-06-07 05:30:14', NULL),
(249, 1, 17, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:30:14', '2024-06-07 05:30:14', NULL),
(250, 1, 17, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:30:14', '2024-06-07 05:30:14', NULL),
(251, 1, 17, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:30:14', '2024-06-07 05:30:14', NULL),
(252, 1, 17, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:30:14', '2024-06-07 05:30:14', NULL),
(253, 1, 19, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:30:19', '2024-06-07 05:30:19', NULL),
(254, 1, 19, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:30:19', '2024-06-07 05:30:19', NULL),
(255, 1, 19, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:30:19', '2024-06-07 05:30:19', NULL),
(256, 1, 19, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:30:19', '2024-06-07 05:30:19', NULL),
(257, 1, 19, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:30:19', '2024-06-07 05:30:19', NULL),
(258, 1, 19, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:30:19', '2024-06-07 05:30:19', NULL),
(259, 1, 19, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:30:19', '2024-06-07 05:30:19', NULL),
(260, 1, 19, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:30:19', '2024-06-07 05:30:19', NULL),
(261, 1, 19, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:30:19', '2024-06-07 05:30:19', NULL),
(262, 1, 19, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:30:19', '2024-06-07 05:30:19', NULL),
(263, 1, 19, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:30:19', '2024-06-07 05:30:19', NULL),
(264, 1, 19, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:30:19', '2024-06-07 05:30:19', NULL),
(265, 1, 19, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:30:19', '2024-06-07 05:30:19', NULL),
(266, 1, 19, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:30:19', '2024-06-07 05:30:19', NULL),
(267, 1, 20, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:30:25', '2024-06-07 05:30:25', NULL),
(268, 1, 20, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:30:25', '2024-06-07 05:30:25', NULL),
(269, 1, 20, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:30:25', '2024-06-07 05:30:25', NULL),
(270, 1, 20, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:30:25', '2024-06-07 05:30:25', NULL),
(271, 1, 20, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:30:25', '2024-06-07 05:30:25', NULL),
(272, 1, 20, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:30:25', '2024-06-07 05:30:25', NULL),
(273, 1, 20, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:30:25', '2024-06-07 05:30:25', NULL),
(274, 1, 20, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:30:25', '2024-06-07 05:30:25', NULL),
(275, 1, 20, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:30:25', '2024-06-07 05:30:25', NULL),
(276, 1, 20, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:30:25', '2024-06-07 05:30:25', NULL),
(277, 1, 20, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:30:25', '2024-06-07 05:30:25', NULL),
(278, 1, 20, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:30:25', '2024-06-07 05:30:25', NULL),
(279, 1, 20, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:30:25', '2024-06-07 05:30:25', NULL),
(280, 1, 20, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:30:25', '2024-06-07 05:30:25', NULL),
(281, 1, 21, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:30:30', '2024-06-07 05:30:30', NULL),
(282, 1, 21, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:30:30', '2024-06-07 05:30:30', NULL),
(283, 1, 21, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:30:30', '2024-06-07 05:30:30', NULL),
(284, 1, 21, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:30:30', '2024-06-07 05:30:30', NULL),
(285, 1, 21, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:30:30', '2024-06-07 05:30:30', NULL),
(286, 1, 21, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:30:30', '2024-06-07 05:30:30', NULL),
(287, 1, 21, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:30:30', '2024-06-07 05:30:30', NULL),
(288, 1, 21, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:30:30', '2024-06-07 05:30:30', NULL),
(289, 1, 21, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:30:30', '2024-06-07 05:30:30', NULL),
(290, 1, 21, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:30:30', '2024-06-07 05:30:30', NULL),
(291, 1, 21, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:30:30', '2024-06-07 05:30:30', NULL),
(292, 1, 21, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:30:30', '2024-06-07 05:30:30', NULL),
(293, 1, 21, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:30:30', '2024-06-07 05:30:30', NULL),
(294, 1, 21, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:30:30', '2024-06-07 05:30:30', NULL),
(295, 1, 24, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:30:37', '2024-06-07 05:30:37', NULL),
(296, 1, 24, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:30:37', '2024-06-07 05:30:37', NULL),
(297, 1, 24, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:30:37', '2024-06-07 05:30:37', NULL),
(298, 1, 24, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:30:37', '2024-06-07 05:30:37', NULL),
(299, 1, 24, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:30:37', '2024-06-07 05:30:37', NULL),
(300, 1, 24, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:30:37', '2024-06-07 05:30:37', NULL),
(301, 1, 24, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:30:37', '2024-06-07 05:30:37', NULL),
(302, 1, 24, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:30:37', '2024-06-07 05:30:37', NULL),
(303, 1, 24, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:30:37', '2024-06-07 05:30:37', NULL),
(304, 1, 24, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:30:37', '2024-06-07 05:30:37', NULL),
(305, 1, 24, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:30:37', '2024-06-07 05:30:37', NULL),
(306, 1, 24, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:30:37', '2024-06-07 05:30:37', NULL),
(307, 1, 24, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:30:37', '2024-06-07 05:30:37', NULL),
(308, 1, 24, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:30:37', '2024-06-07 05:30:37', NULL),
(309, 1, 25, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:30:42', '2024-06-07 05:30:42', NULL),
(310, 1, 25, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:30:42', '2024-06-07 05:30:42', NULL),
(311, 1, 25, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:30:42', '2024-06-07 05:30:42', NULL),
(312, 1, 25, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:30:42', '2024-06-07 05:30:42', NULL),
(313, 1, 25, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:30:42', '2024-06-07 05:30:42', NULL),
(314, 1, 25, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:30:42', '2024-06-07 05:30:42', NULL),
(315, 1, 25, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:30:42', '2024-06-07 05:30:42', NULL),
(316, 1, 25, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:30:42', '2024-06-07 05:30:42', NULL),
(317, 1, 25, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:30:42', '2024-06-07 05:30:42', NULL),
(318, 1, 25, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:30:42', '2024-06-07 05:30:42', NULL),
(319, 1, 25, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:30:42', '2024-06-07 05:30:42', NULL),
(320, 1, 25, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:30:42', '2024-06-07 05:30:42', NULL),
(321, 1, 25, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:30:42', '2024-06-07 05:30:42', NULL),
(322, 1, 25, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:30:42', '2024-06-07 05:30:42', NULL),
(323, 1, 27, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:30:55', '2024-06-07 05:30:55', NULL),
(324, 1, 27, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:30:55', '2024-06-07 05:30:55', NULL),
(325, 1, 27, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:30:55', '2024-06-07 05:30:55', NULL),
(326, 1, 27, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:30:55', '2024-06-07 05:30:55', NULL),
(327, 1, 27, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:30:55', '2024-06-07 05:30:55', NULL),
(328, 1, 27, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:30:55', '2024-06-07 05:30:55', NULL),
(329, 1, 27, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:30:55', '2024-06-07 05:30:55', NULL),
(330, 1, 27, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:30:55', '2024-06-07 05:30:55', NULL),
(331, 1, 27, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:30:55', '2024-06-07 05:30:55', NULL),
(332, 1, 27, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:30:55', '2024-06-07 05:30:55', NULL),
(333, 1, 27, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:30:55', '2024-06-07 05:30:55', NULL),
(334, 1, 27, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:30:55', '2024-06-07 05:30:55', NULL),
(335, 1, 27, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:30:55', '2024-06-07 05:30:55', NULL),
(336, 1, 27, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:30:55', '2024-06-07 05:30:55', NULL),
(337, 1, 28, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:31:00', '2024-06-07 05:31:00', NULL),
(338, 1, 28, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:31:00', '2024-06-07 05:31:00', NULL),
(339, 1, 28, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:31:00', '2024-06-07 05:31:00', NULL),
(340, 1, 28, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:31:00', '2024-06-07 05:31:00', NULL),
(341, 1, 28, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:31:00', '2024-06-07 05:31:00', NULL),
(342, 1, 28, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:31:00', '2024-06-07 05:31:00', NULL),
(343, 1, 28, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:31:00', '2024-06-07 05:31:00', NULL),
(344, 1, 28, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:31:00', '2024-06-07 05:31:00', NULL),
(345, 1, 28, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:31:00', '2024-06-07 05:31:00', NULL),
(346, 1, 28, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:31:00', '2024-06-07 05:31:00', NULL),
(347, 1, 28, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:31:00', '2024-06-07 05:31:00', NULL),
(348, 1, 28, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:31:00', '2024-06-07 05:31:00', NULL),
(349, 1, 28, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:31:00', '2024-06-07 05:31:00', NULL),
(350, 1, 28, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:31:00', '2024-06-07 05:31:00', NULL),
(351, 1, 29, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:31:05', '2024-06-07 05:31:05', NULL),
(352, 1, 29, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:31:05', '2024-06-07 05:31:05', NULL),
(353, 1, 29, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:31:05', '2024-06-07 05:31:05', NULL),
(354, 1, 29, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:31:05', '2024-06-07 05:31:05', NULL),
(355, 1, 29, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:31:05', '2024-06-07 05:31:05', NULL),
(356, 1, 29, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:31:05', '2024-06-07 05:31:05', NULL),
(357, 1, 29, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:31:05', '2024-06-07 05:31:05', NULL),
(358, 1, 29, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:31:05', '2024-06-07 05:31:05', NULL),
(359, 1, 29, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:31:05', '2024-06-07 05:31:05', NULL),
(360, 1, 29, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:31:05', '2024-06-07 05:31:05', NULL),
(361, 1, 29, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:31:05', '2024-06-07 05:31:05', NULL),
(362, 1, 29, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:31:05', '2024-06-07 05:31:05', NULL),
(363, 1, 29, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:31:05', '2024-06-07 05:31:05', NULL),
(364, 1, 29, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:31:05', '2024-06-07 05:31:05', NULL),
(365, 1, 32, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:31:11', '2024-06-07 05:31:11', NULL),
(366, 1, 32, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:31:11', '2024-06-07 05:31:11', NULL),
(367, 1, 32, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:31:11', '2024-06-07 05:31:11', NULL),
(368, 1, 32, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:31:11', '2024-06-07 05:31:11', NULL),
(369, 1, 32, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:31:11', '2024-06-07 05:31:11', NULL),
(370, 1, 32, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:31:11', '2024-06-07 05:31:11', NULL),
(371, 1, 32, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:31:11', '2024-06-07 05:31:11', NULL),
(372, 1, 32, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:31:11', '2024-06-07 05:31:11', NULL),
(373, 1, 32, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:31:11', '2024-06-07 05:31:11', NULL),
(374, 1, 32, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:31:11', '2024-06-07 05:31:11', NULL),
(375, 1, 32, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:31:11', '2024-06-07 05:31:11', NULL),
(376, 1, 32, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:31:11', '2024-06-07 05:31:11', NULL),
(377, 1, 32, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:31:11', '2024-06-07 05:31:11', NULL),
(378, 1, 32, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:31:11', '2024-06-07 05:31:11', NULL),
(379, 1, 33, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:31:17', '2024-06-07 05:31:17', NULL),
(380, 1, 33, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:31:17', '2024-06-07 05:31:17', NULL),
(381, 1, 33, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:31:17', '2024-06-07 05:31:17', NULL),
(382, 1, 33, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:31:17', '2024-06-07 05:31:17', NULL),
(383, 1, 33, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:31:17', '2024-06-07 05:31:17', NULL),
(384, 1, 33, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:31:17', '2024-06-07 05:31:17', NULL),
(385, 1, 33, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:31:17', '2024-06-07 05:31:17', NULL),
(386, 1, 33, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:31:17', '2024-06-07 05:31:17', NULL),
(387, 1, 33, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:31:17', '2024-06-07 05:31:17', NULL),
(388, 1, 33, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:31:17', '2024-06-07 05:31:17', NULL),
(389, 1, 33, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:31:17', '2024-06-07 05:31:17', NULL),
(390, 1, 33, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:31:17', '2024-06-07 05:31:17', NULL),
(391, 1, 33, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:31:17', '2024-06-07 05:31:17', NULL),
(392, 1, 33, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:31:17', '2024-06-07 05:31:17', NULL),
(393, 1, 35, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:31:24', '2024-06-07 05:31:24', NULL),
(394, 1, 35, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:31:24', '2024-06-07 05:31:24', NULL),
(395, 1, 35, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:31:24', '2024-06-07 05:31:24', NULL),
(396, 1, 35, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:31:24', '2024-06-07 05:31:24', NULL),
(397, 1, 35, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:31:24', '2024-06-07 05:31:24', NULL),
(398, 1, 35, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:31:24', '2024-06-07 05:31:24', NULL),
(399, 1, 35, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:31:24', '2024-06-07 05:31:24', NULL),
(400, 1, 35, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:31:24', '2024-06-07 05:31:24', NULL),
(401, 1, 35, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:31:24', '2024-06-07 05:31:24', NULL),
(402, 1, 35, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:31:24', '2024-06-07 05:31:24', NULL),
(403, 1, 35, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:31:24', '2024-06-07 05:31:24', NULL),
(404, 1, 35, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:31:24', '2024-06-07 05:31:24', NULL),
(405, 1, 35, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:31:24', '2024-06-07 05:31:24', NULL),
(406, 1, 35, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:31:24', '2024-06-07 05:31:24', NULL),
(407, 1, 36, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:31:30', '2024-06-07 05:31:30', NULL),
(408, 1, 36, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:31:30', '2024-06-07 05:31:30', NULL),
(409, 1, 36, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:31:30', '2024-06-07 05:31:30', NULL),
(410, 1, 36, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:31:30', '2024-06-07 05:31:30', NULL),
(411, 1, 36, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:31:30', '2024-06-07 05:31:30', NULL),
(412, 1, 36, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:31:30', '2024-06-07 05:31:30', NULL),
(413, 1, 36, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:31:30', '2024-06-07 05:31:30', NULL),
(414, 1, 36, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:31:30', '2024-06-07 05:31:30', NULL),
(415, 1, 36, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:31:30', '2024-06-07 05:31:30', NULL),
(416, 1, 36, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:31:30', '2024-06-07 05:31:30', NULL),
(417, 1, 36, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:31:30', '2024-06-07 05:31:30', NULL),
(418, 1, 36, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:31:30', '2024-06-07 05:31:30', NULL),
(419, 1, 36, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:31:30', '2024-06-07 05:31:30', NULL),
(420, 1, 36, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:31:30', '2024-06-07 05:31:30', NULL),
(421, 1, 37, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:31:35', '2024-06-07 05:31:35', NULL),
(422, 1, 37, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:31:35', '2024-06-07 05:31:35', NULL),
(423, 1, 37, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:31:35', '2024-06-07 05:31:35', NULL),
(424, 1, 37, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:31:35', '2024-06-07 05:31:35', NULL),
(425, 1, 37, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:31:35', '2024-06-07 05:31:35', NULL),
(426, 1, 37, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:31:35', '2024-06-07 05:31:35', NULL),
(427, 1, 37, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:31:35', '2024-06-07 05:31:35', NULL),
(428, 1, 37, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:31:35', '2024-06-07 05:31:35', NULL),
(429, 1, 37, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:31:35', '2024-06-07 05:31:35', NULL),
(430, 1, 37, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:31:35', '2024-06-07 05:31:35', NULL),
(431, 1, 37, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:31:35', '2024-06-07 05:31:35', NULL),
(432, 1, 37, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:31:35', '2024-06-07 05:31:35', NULL),
(433, 1, 37, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:31:35', '2024-06-07 05:31:35', NULL),
(434, 1, 37, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:31:35', '2024-06-07 05:31:35', NULL),
(435, 1, 40, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:31:40', '2024-06-07 05:31:40', NULL),
(436, 1, 40, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:31:40', '2024-06-07 05:31:40', NULL),
(437, 1, 40, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:31:40', '2024-06-07 05:31:40', NULL),
(438, 1, 40, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:31:40', '2024-06-07 05:31:40', NULL),
(439, 1, 40, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:31:40', '2024-06-07 05:31:40', NULL),
(440, 1, 40, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:31:40', '2024-06-07 05:31:40', NULL),
(441, 1, 40, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:31:40', '2024-06-07 05:31:40', NULL),
(442, 1, 40, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:31:40', '2024-06-07 05:31:40', NULL),
(443, 1, 40, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:31:40', '2024-06-07 05:31:40', NULL),
(444, 1, 40, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:31:40', '2024-06-07 05:31:40', NULL),
(445, 1, 40, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:31:40', '2024-06-07 05:31:40', NULL),
(446, 1, 40, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:31:40', '2024-06-07 05:31:40', NULL),
(447, 1, 40, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:31:40', '2024-06-07 05:31:40', NULL),
(448, 1, 40, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:31:40', '2024-06-07 05:31:40', NULL),
(449, 3, 12, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:31:54', '2024-06-07 05:31:54', NULL),
(450, 3, 12, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:31:54', '2024-06-07 05:31:54', NULL),
(451, 3, 12, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:31:54', '2024-06-07 05:31:54', NULL),
(452, 3, 12, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:31:54', '2024-06-07 05:31:54', NULL),
(453, 3, 12, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:31:54', '2024-06-07 05:31:54', NULL),
(454, 3, 12, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:31:54', '2024-06-07 05:31:54', NULL),
(455, 3, 12, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:31:54', '2024-06-07 05:31:54', NULL),
(456, 3, 12, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:31:54', '2024-06-07 05:31:54', NULL),
(457, 3, 12, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:31:54', '2024-06-07 05:31:54', NULL),
(458, 3, 12, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:31:54', '2024-06-07 05:31:54', NULL),
(459, 3, 12, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:31:54', '2024-06-07 05:31:54', NULL),
(460, 3, 12, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:31:54', '2024-06-07 05:31:54', NULL),
(461, 3, 12, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:31:54', '2024-06-07 05:31:54', NULL),
(462, 3, 12, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:31:54', '2024-06-07 05:31:54', NULL),
(463, 3, 13, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:32:01', '2024-06-07 05:32:01', NULL),
(464, 3, 13, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:32:01', '2024-06-07 05:32:01', NULL),
(465, 3, 13, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:32:01', '2024-06-07 05:32:01', NULL),
(466, 3, 13, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:32:01', '2024-06-07 05:32:01', NULL),
(467, 3, 13, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:32:01', '2024-06-07 05:32:01', NULL),
(468, 3, 13, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:32:01', '2024-06-07 05:32:01', NULL),
(469, 3, 13, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:32:01', '2024-06-07 05:32:01', NULL),
(470, 3, 13, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:32:01', '2024-06-07 05:32:01', NULL),
(471, 3, 13, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:32:01', '2024-06-07 05:32:01', NULL),
(472, 3, 13, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:32:01', '2024-06-07 05:32:01', NULL),
(473, 3, 13, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:32:01', '2024-06-07 05:32:01', NULL),
(474, 3, 13, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:32:01', '2024-06-07 05:32:01', NULL),
(475, 3, 13, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:32:01', '2024-06-07 05:32:01', NULL),
(476, 3, 13, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:32:01', '2024-06-07 05:32:01', NULL),
(477, 3, 16, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:32:05', '2024-06-07 05:32:05', NULL),
(478, 3, 16, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:32:05', '2024-06-07 05:32:05', NULL),
(479, 3, 16, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:32:05', '2024-06-07 05:32:05', NULL),
(480, 3, 16, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:32:05', '2024-06-07 05:32:05', NULL),
(481, 3, 16, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:32:05', '2024-06-07 05:32:05', NULL),
(482, 3, 16, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:32:05', '2024-06-07 05:32:05', NULL),
(483, 3, 16, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:32:05', '2024-06-07 05:32:05', NULL),
(484, 3, 16, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:32:05', '2024-06-07 05:32:05', NULL),
(485, 3, 16, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:32:05', '2024-06-07 05:32:05', NULL),
(486, 3, 16, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:32:05', '2024-06-07 05:32:05', NULL),
(487, 3, 16, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:32:05', '2024-06-07 05:32:05', NULL),
(488, 3, 16, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:32:05', '2024-06-07 05:32:05', NULL),
(489, 3, 16, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:32:05', '2024-06-07 05:32:05', NULL),
(490, 3, 16, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:32:05', '2024-06-07 05:32:05', NULL),
(491, 3, 17, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:32:10', '2024-06-07 05:32:10', NULL),
(492, 3, 17, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:32:10', '2024-06-07 05:32:10', NULL),
(493, 3, 17, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:32:10', '2024-06-07 05:32:10', NULL),
(494, 3, 17, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:32:10', '2024-06-07 05:32:10', NULL),
(495, 3, 17, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:32:10', '2024-06-07 05:32:10', NULL),
(496, 3, 17, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:32:10', '2024-06-07 05:32:10', NULL),
(497, 3, 17, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:32:10', '2024-06-07 05:32:10', NULL),
(498, 3, 17, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:32:10', '2024-06-07 05:32:10', NULL),
(499, 3, 17, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:32:10', '2024-06-07 05:32:10', NULL),
(500, 3, 17, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:32:10', '2024-06-07 05:32:10', NULL),
(501, 3, 17, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:32:10', '2024-06-07 05:32:10', NULL),
(502, 3, 17, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:32:10', '2024-06-07 05:32:10', NULL),
(503, 3, 17, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:32:10', '2024-06-07 05:32:10', NULL),
(504, 3, 17, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:32:10', '2024-06-07 05:32:10', NULL),
(505, 3, 19, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:32:14', '2024-06-07 05:32:14', NULL),
(506, 3, 19, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:32:14', '2024-06-07 05:32:14', NULL),
(507, 3, 19, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:32:14', '2024-06-07 05:32:14', NULL),
(508, 3, 19, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:32:14', '2024-06-07 05:32:14', NULL),
(509, 3, 19, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:32:14', '2024-06-07 05:32:14', NULL),
(510, 3, 19, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:32:14', '2024-06-07 05:32:14', NULL),
(511, 3, 19, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:32:14', '2024-06-07 05:32:14', NULL),
(512, 3, 19, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:32:14', '2024-06-07 05:32:14', NULL),
(513, 3, 19, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:32:14', '2024-06-07 05:32:14', NULL),
(514, 3, 19, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:32:14', '2024-06-07 05:32:14', NULL),
(515, 3, 19, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:32:14', '2024-06-07 05:32:14', NULL),
(516, 3, 19, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:32:14', '2024-06-07 05:32:14', NULL),
(517, 3, 19, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:32:14', '2024-06-07 05:32:14', NULL),
(518, 3, 19, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:32:14', '2024-06-07 05:32:14', NULL),
(519, 3, 20, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:32:31', '2024-06-07 05:32:31', NULL),
(520, 3, 20, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:32:31', '2024-06-07 05:32:31', NULL),
(521, 3, 20, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:32:31', '2024-06-07 05:32:31', NULL),
(522, 3, 20, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:32:31', '2024-06-07 05:32:31', NULL),
(523, 3, 20, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:32:31', '2024-06-07 05:32:31', NULL),
(524, 3, 20, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:32:31', '2024-06-07 05:32:31', NULL),
(525, 3, 20, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:32:31', '2024-06-07 05:32:31', NULL),
(526, 3, 20, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:32:31', '2024-06-07 05:32:31', NULL),
(527, 3, 20, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:32:31', '2024-06-07 05:32:31', NULL),
(528, 3, 20, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:32:31', '2024-06-07 05:32:31', NULL),
(529, 3, 20, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:32:31', '2024-06-07 05:32:31', NULL),
(530, 3, 20, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:32:31', '2024-06-07 05:32:31', NULL),
(531, 3, 20, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:32:31', '2024-06-07 05:32:31', NULL),
(532, 3, 20, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:32:31', '2024-06-07 05:32:31', NULL);
INSERT INTO `vehicle_route_destinations` (`id`, `vehicle_id`, `route_schedule_id`, `available_seats`, `reserved_seats`, `date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(533, 3, 21, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:32:37', '2024-06-07 05:32:37', NULL),
(534, 3, 21, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:32:37', '2024-06-07 05:32:37', NULL),
(535, 3, 21, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:32:37', '2024-06-07 05:32:37', NULL),
(536, 3, 21, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:32:37', '2024-06-07 05:32:37', NULL),
(537, 3, 21, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:32:37', '2024-06-07 05:32:37', NULL),
(538, 3, 21, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:32:37', '2024-06-07 05:32:37', NULL),
(539, 3, 21, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:32:37', '2024-06-07 05:32:37', NULL),
(540, 3, 21, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:32:37', '2024-06-07 05:32:37', NULL),
(541, 3, 21, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:32:37', '2024-06-07 05:32:37', NULL),
(542, 3, 21, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:32:37', '2024-06-07 05:32:37', NULL),
(543, 3, 21, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:32:37', '2024-06-07 05:32:37', NULL),
(544, 3, 21, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:32:37', '2024-06-07 05:32:37', NULL),
(545, 3, 21, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:32:37', '2024-06-07 05:32:37', NULL),
(546, 3, 21, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:32:37', '2024-06-07 05:32:37', NULL),
(547, 3, 24, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:32:41', '2024-06-07 05:32:41', NULL),
(548, 3, 24, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:32:41', '2024-06-07 05:32:41', NULL),
(549, 3, 24, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:32:41', '2024-06-07 05:32:41', NULL),
(550, 3, 24, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:32:41', '2024-06-07 05:32:41', NULL),
(551, 3, 24, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:32:41', '2024-06-07 05:32:41', NULL),
(552, 3, 24, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:32:41', '2024-06-07 05:32:41', NULL),
(553, 3, 24, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:32:41', '2024-06-07 05:32:41', NULL),
(554, 3, 24, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:32:41', '2024-06-07 05:32:41', NULL),
(555, 3, 24, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:32:41', '2024-06-07 05:32:41', NULL),
(556, 3, 24, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:32:41', '2024-06-07 05:32:41', NULL),
(557, 3, 24, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:32:41', '2024-06-07 05:32:41', NULL),
(558, 3, 24, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:32:41', '2024-06-07 05:32:41', NULL),
(559, 3, 24, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:32:41', '2024-06-07 05:32:41', NULL),
(560, 3, 24, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:32:41', '2024-06-07 05:32:41', NULL),
(561, 3, 25, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:32:47', '2024-06-07 05:32:47', NULL),
(562, 3, 25, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:32:47', '2024-06-07 05:32:47', NULL),
(563, 3, 25, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:32:47', '2024-06-07 05:32:47', NULL),
(564, 3, 25, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:32:47', '2024-06-07 05:32:47', NULL),
(565, 3, 25, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:32:47', '2024-06-07 05:32:47', NULL),
(566, 3, 25, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:32:47', '2024-06-07 05:32:47', NULL),
(567, 3, 25, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:32:47', '2024-06-07 05:32:47', NULL),
(568, 3, 25, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:32:47', '2024-06-07 05:32:47', NULL),
(569, 3, 25, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:32:47', '2024-06-07 05:32:47', NULL),
(570, 3, 25, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:32:47', '2024-06-07 05:32:47', NULL),
(571, 3, 25, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:32:47', '2024-06-07 05:32:47', NULL),
(572, 3, 25, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:32:47', '2024-06-07 05:32:47', NULL),
(573, 3, 25, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:32:47', '2024-06-07 05:32:47', NULL),
(574, 3, 25, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:32:47', '2024-06-07 05:32:47', NULL),
(575, 3, 27, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:32:54', '2024-06-07 05:32:54', NULL),
(576, 3, 27, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:32:54', '2024-06-07 05:32:54', NULL),
(577, 3, 27, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:32:54', '2024-06-07 05:32:54', NULL),
(578, 3, 27, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:32:54', '2024-06-07 05:32:54', NULL),
(579, 3, 27, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:32:54', '2024-06-07 05:32:54', NULL),
(580, 3, 27, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:32:54', '2024-06-07 05:32:54', NULL),
(581, 3, 27, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:32:54', '2024-06-07 05:32:54', NULL),
(582, 3, 27, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:32:54', '2024-06-07 05:32:54', NULL),
(583, 3, 27, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:32:54', '2024-06-07 05:32:54', NULL),
(584, 3, 27, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:32:54', '2024-06-07 05:32:54', NULL),
(585, 3, 27, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:32:54', '2024-06-07 05:32:54', NULL),
(586, 3, 27, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:32:54', '2024-06-07 05:32:54', NULL),
(587, 3, 27, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:32:54', '2024-06-07 05:32:54', NULL),
(588, 3, 27, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:32:54', '2024-06-07 05:32:54', NULL),
(589, 3, 28, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:33:01', '2024-06-07 05:33:01', NULL),
(590, 3, 28, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:33:01', '2024-06-07 05:33:01', NULL),
(591, 3, 28, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:33:01', '2024-06-07 05:33:01', NULL),
(592, 3, 28, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:33:01', '2024-06-07 05:33:01', NULL),
(593, 3, 28, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:33:01', '2024-06-07 05:33:01', NULL),
(594, 3, 28, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:33:01', '2024-06-07 05:33:01', NULL),
(595, 3, 28, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:33:01', '2024-06-07 05:33:01', NULL),
(596, 3, 28, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:33:01', '2024-06-07 05:33:01', NULL),
(597, 3, 28, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:33:01', '2024-06-07 05:33:01', NULL),
(598, 3, 28, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:33:01', '2024-06-07 05:33:01', NULL),
(599, 3, 28, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:33:01', '2024-06-07 05:33:01', NULL),
(600, 3, 28, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:33:01', '2024-06-07 05:33:01', NULL),
(601, 3, 28, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:33:01', '2024-06-07 05:33:01', NULL),
(602, 3, 28, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:33:01', '2024-06-07 05:33:01', NULL),
(603, 3, 29, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:33:07', '2024-06-07 05:33:07', NULL),
(604, 3, 29, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:33:07', '2024-06-07 05:33:07', NULL),
(605, 3, 29, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:33:07', '2024-06-07 05:33:07', NULL),
(606, 3, 29, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:33:07', '2024-06-07 05:33:07', NULL),
(607, 3, 29, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:33:07', '2024-06-07 05:33:07', NULL),
(608, 3, 29, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:33:07', '2024-06-07 05:33:07', NULL),
(609, 3, 29, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:33:07', '2024-06-07 05:33:07', NULL),
(610, 3, 29, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:33:07', '2024-06-07 05:33:07', NULL),
(611, 3, 29, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:33:07', '2024-06-07 05:33:07', NULL),
(612, 3, 29, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:33:07', '2024-06-07 05:33:07', NULL),
(613, 3, 29, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:33:07', '2024-06-07 05:33:07', NULL),
(614, 3, 29, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:33:07', '2024-06-07 05:33:07', NULL),
(615, 3, 29, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:33:07', '2024-06-07 05:33:07', NULL),
(616, 3, 29, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:33:07', '2024-06-07 05:33:07', NULL),
(617, 3, 32, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:33:13', '2024-06-07 05:33:13', NULL),
(618, 3, 32, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:33:13', '2024-06-07 05:33:13', NULL),
(619, 3, 32, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:33:13', '2024-06-07 05:33:13', NULL),
(620, 3, 32, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:33:13', '2024-06-07 05:33:13', NULL),
(621, 3, 32, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:33:13', '2024-06-07 05:33:13', NULL),
(622, 3, 32, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:33:13', '2024-06-07 05:33:13', NULL),
(623, 3, 32, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:33:13', '2024-06-07 05:33:13', NULL),
(624, 3, 32, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:33:13', '2024-06-07 05:33:13', NULL),
(625, 3, 32, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:33:13', '2024-06-07 05:33:13', NULL),
(626, 3, 32, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:33:13', '2024-06-07 05:33:13', NULL),
(627, 3, 32, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:33:13', '2024-06-07 05:33:13', NULL),
(628, 3, 32, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:33:13', '2024-06-07 05:33:13', NULL),
(629, 3, 32, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:33:13', '2024-06-07 05:33:13', NULL),
(630, 3, 32, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:33:13', '2024-06-07 05:33:13', NULL),
(631, 3, 33, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:33:19', '2024-06-07 05:33:19', NULL),
(632, 3, 33, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:33:19', '2024-06-07 05:33:19', NULL),
(633, 3, 33, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:33:19', '2024-06-07 05:33:19', NULL),
(634, 3, 33, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:33:19', '2024-06-07 05:33:19', NULL),
(635, 3, 33, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:33:19', '2024-06-07 05:33:19', NULL),
(636, 3, 33, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:33:19', '2024-06-07 05:33:19', NULL),
(637, 3, 33, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:33:19', '2024-06-07 05:33:19', NULL),
(638, 3, 33, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:33:19', '2024-06-07 05:33:19', NULL),
(639, 3, 33, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:33:19', '2024-06-07 05:33:19', NULL),
(640, 3, 33, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:33:19', '2024-06-07 05:33:19', NULL),
(641, 3, 33, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:33:19', '2024-06-07 05:33:19', NULL),
(642, 3, 33, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:33:19', '2024-06-07 05:33:19', NULL),
(643, 3, 33, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:33:19', '2024-06-07 05:33:19', NULL),
(644, 3, 33, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:33:19', '2024-06-07 05:33:19', NULL),
(645, 3, 35, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:33:24', '2024-06-07 05:33:24', NULL),
(646, 3, 35, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:33:24', '2024-06-07 05:33:24', NULL),
(647, 3, 35, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:33:24', '2024-06-07 05:33:24', NULL),
(648, 3, 35, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:33:24', '2024-06-07 05:33:24', NULL),
(649, 3, 35, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:33:24', '2024-06-07 05:33:24', NULL),
(650, 3, 35, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:33:24', '2024-06-07 05:33:24', NULL),
(651, 3, 35, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:33:24', '2024-06-07 05:33:24', NULL),
(652, 3, 35, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:33:24', '2024-06-07 05:33:24', NULL),
(653, 3, 35, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:33:24', '2024-06-07 05:33:24', NULL),
(654, 3, 35, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:33:24', '2024-06-07 05:33:24', NULL),
(655, 3, 35, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:33:24', '2024-06-07 05:33:24', NULL),
(656, 3, 35, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:33:24', '2024-06-07 05:33:24', NULL),
(657, 3, 35, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:33:24', '2024-06-07 05:33:24', NULL),
(658, 3, 35, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:33:24', '2024-06-07 05:33:24', NULL),
(659, 3, 36, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:33:30', '2024-06-07 05:33:30', NULL),
(660, 3, 36, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:33:30', '2024-06-07 05:33:30', NULL),
(661, 3, 36, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:33:30', '2024-06-07 05:33:30', NULL),
(662, 3, 36, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:33:30', '2024-06-07 05:33:30', NULL),
(663, 3, 36, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:33:30', '2024-06-07 05:33:30', NULL),
(664, 3, 36, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:33:30', '2024-06-07 05:33:30', NULL),
(665, 3, 36, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:33:30', '2024-06-07 05:33:30', NULL),
(666, 3, 36, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:33:30', '2024-06-07 05:33:30', NULL),
(667, 3, 36, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:33:30', '2024-06-07 05:33:30', NULL),
(668, 3, 36, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:33:30', '2024-06-07 05:33:30', NULL),
(669, 3, 36, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:33:30', '2024-06-07 05:33:30', NULL),
(670, 3, 36, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:33:30', '2024-06-07 05:33:30', NULL),
(671, 3, 36, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:33:30', '2024-06-07 05:33:30', NULL),
(672, 3, 36, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:33:30', '2024-06-07 05:33:30', NULL),
(673, 3, 37, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:33:34', '2024-06-07 05:33:34', NULL),
(674, 3, 37, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:33:34', '2024-06-07 05:33:34', NULL),
(675, 3, 37, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:33:34', '2024-06-07 05:33:34', NULL),
(676, 3, 37, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:33:34', '2024-06-07 05:33:34', NULL),
(677, 3, 37, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:33:34', '2024-06-07 05:33:34', NULL),
(678, 3, 37, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:33:34', '2024-06-07 05:33:34', NULL),
(679, 3, 37, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:33:34', '2024-06-07 05:33:34', NULL),
(680, 3, 37, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:33:34', '2024-06-07 05:33:34', NULL),
(681, 3, 37, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:33:34', '2024-06-07 05:33:34', NULL),
(682, 3, 37, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:33:34', '2024-06-07 05:33:34', NULL),
(683, 3, 37, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:33:34', '2024-06-07 05:33:34', NULL),
(684, 3, 37, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:33:34', '2024-06-07 05:33:34', NULL),
(685, 3, 37, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:33:34', '2024-06-07 05:33:34', NULL),
(686, 3, 37, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:33:34', '2024-06-07 05:33:34', NULL),
(687, 3, 40, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:33:43', '2024-06-07 05:33:43', NULL),
(688, 3, 40, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:33:43', '2024-06-07 05:33:43', NULL),
(689, 3, 40, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:33:43', '2024-06-07 05:33:43', NULL),
(690, 3, 40, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:33:43', '2024-06-07 05:33:43', NULL),
(691, 3, 40, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:33:43', '2024-06-07 05:33:43', NULL),
(692, 3, 40, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:33:43', '2024-06-07 05:33:43', NULL),
(693, 3, 40, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:33:43', '2024-06-07 05:33:43', NULL),
(694, 3, 40, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:33:43', '2024-06-07 05:33:43', NULL),
(695, 3, 40, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:33:43', '2024-06-07 05:33:43', NULL),
(696, 3, 40, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:33:43', '2024-06-07 05:33:43', NULL),
(697, 3, 40, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:33:43', '2024-06-07 05:33:43', NULL),
(698, 3, 40, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:33:43', '2024-06-07 05:33:43', NULL),
(699, 3, 40, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:33:43', '2024-06-07 05:33:43', NULL),
(700, 3, 40, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:33:43', '2024-06-07 05:33:43', NULL),
(701, 2, 2, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:34:16', '2024-06-07 05:34:16', NULL),
(702, 2, 2, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:34:16', '2024-06-07 05:34:16', NULL),
(703, 2, 2, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:34:16', '2024-06-07 05:34:16', NULL),
(704, 2, 2, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:34:16', '2024-06-07 05:34:16', NULL),
(705, 2, 2, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:34:16', '2024-06-07 05:34:16', NULL),
(706, 2, 2, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:34:16', '2024-06-07 05:34:16', NULL),
(707, 2, 2, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:34:16', '2024-06-07 05:34:16', NULL),
(708, 2, 2, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:34:16', '2024-06-07 05:34:16', NULL),
(709, 2, 2, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:34:16', '2024-06-07 05:34:16', NULL),
(710, 2, 2, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:34:16', '2024-06-07 05:34:16', NULL),
(711, 2, 2, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:34:16', '2024-06-07 05:34:16', NULL),
(712, 2, 2, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:34:16', '2024-06-07 05:34:16', NULL),
(713, 2, 2, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:34:16', '2024-06-07 05:34:16', NULL),
(714, 2, 2, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:34:16', '2024-06-07 05:34:16', NULL),
(715, 2, 6, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:34:22', '2024-06-07 05:34:22', NULL),
(716, 2, 6, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:34:22', '2024-06-07 05:34:22', NULL),
(717, 2, 6, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:34:22', '2024-06-07 05:34:22', NULL),
(718, 2, 6, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:34:22', '2024-06-07 05:34:22', NULL),
(719, 2, 6, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:34:22', '2024-06-07 05:34:22', NULL),
(720, 2, 6, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:34:22', '2024-06-07 05:34:22', NULL),
(721, 2, 6, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:34:22', '2024-06-07 05:34:22', NULL),
(722, 2, 6, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:34:22', '2024-06-07 05:34:22', NULL),
(723, 2, 6, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:34:22', '2024-06-07 05:34:22', NULL),
(724, 2, 6, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:34:22', '2024-06-07 05:34:22', NULL),
(725, 2, 6, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:34:22', '2024-06-07 05:34:22', NULL),
(726, 2, 6, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:34:22', '2024-06-07 05:34:22', NULL),
(727, 2, 6, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:34:22', '2024-06-07 05:34:22', NULL),
(728, 2, 6, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:34:22', '2024-06-07 05:34:22', NULL),
(729, 2, 7, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:34:27', '2024-06-07 05:34:27', NULL),
(730, 2, 7, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:34:27', '2024-06-07 05:34:27', NULL),
(731, 2, 7, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:34:27', '2024-06-07 05:34:27', NULL),
(732, 2, 7, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:34:27', '2024-06-07 05:34:27', NULL),
(733, 2, 7, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:34:27', '2024-06-07 05:34:27', NULL),
(734, 2, 7, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:34:27', '2024-06-07 05:34:27', NULL),
(735, 2, 7, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:34:27', '2024-06-07 05:34:27', NULL),
(736, 2, 7, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:34:27', '2024-06-07 05:34:27', NULL),
(737, 2, 7, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:34:27', '2024-06-07 05:34:27', NULL),
(738, 2, 7, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:34:27', '2024-06-07 05:34:27', NULL),
(739, 2, 7, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:34:27', '2024-06-07 05:34:27', NULL),
(740, 2, 7, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:34:27', '2024-06-07 05:34:27', NULL),
(741, 2, 7, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:34:27', '2024-06-07 05:34:27', NULL),
(742, 2, 7, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:34:27', '2024-06-07 05:34:27', NULL),
(743, 2, 10, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:34:32', '2024-06-07 05:34:32', NULL),
(744, 2, 10, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:34:32', '2024-06-07 05:34:32', NULL),
(745, 2, 10, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:34:32', '2024-06-07 05:34:32', NULL),
(746, 2, 10, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:34:32', '2024-06-07 05:34:32', NULL),
(747, 2, 10, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:34:32', '2024-06-07 05:34:32', NULL),
(748, 2, 10, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:34:32', '2024-06-07 05:34:32', NULL),
(749, 2, 10, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:34:32', '2024-06-07 05:34:32', NULL),
(750, 2, 10, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:34:32', '2024-06-07 05:34:32', NULL),
(751, 2, 10, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:34:32', '2024-06-07 05:34:32', NULL),
(752, 2, 10, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:34:32', '2024-06-07 05:34:32', NULL),
(753, 2, 10, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:34:32', '2024-06-07 05:34:32', NULL),
(754, 2, 10, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:34:32', '2024-06-07 05:34:32', NULL),
(755, 2, 10, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:34:32', '2024-06-07 05:34:32', NULL),
(756, 2, 10, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:34:32', '2024-06-07 05:34:32', NULL),
(757, 2, 14, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:34:37', '2024-06-07 05:34:37', NULL),
(758, 2, 14, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:34:37', '2024-06-07 05:34:37', NULL),
(759, 2, 14, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:34:37', '2024-06-07 05:34:37', NULL),
(760, 2, 14, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:34:37', '2024-06-07 05:34:37', NULL),
(761, 2, 14, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:34:37', '2024-06-07 05:34:37', NULL),
(762, 2, 14, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:34:37', '2024-06-07 05:34:37', NULL),
(763, 2, 14, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:34:37', '2024-06-07 05:34:37', NULL),
(764, 2, 14, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:34:37', '2024-06-07 05:34:37', NULL),
(765, 2, 14, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:34:37', '2024-06-07 05:34:37', NULL),
(766, 2, 14, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:34:37', '2024-06-07 05:34:37', NULL),
(767, 2, 14, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:34:37', '2024-06-07 05:34:37', NULL),
(768, 2, 14, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:34:37', '2024-06-07 05:34:37', NULL),
(769, 2, 14, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:34:37', '2024-06-07 05:34:37', NULL),
(770, 2, 14, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:34:37', '2024-06-07 05:34:37', NULL),
(771, 2, 15, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:34:46', '2024-06-07 05:34:46', NULL),
(772, 2, 15, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:34:46', '2024-06-07 05:34:46', NULL),
(773, 2, 15, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:34:46', '2024-06-07 05:34:46', NULL),
(774, 2, 15, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:34:46', '2024-06-07 05:34:46', NULL),
(775, 2, 15, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:34:46', '2024-06-07 05:34:46', NULL),
(776, 2, 15, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:34:46', '2024-06-07 05:34:46', NULL),
(777, 2, 15, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:34:46', '2024-06-07 05:34:46', NULL),
(778, 2, 15, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:34:46', '2024-06-07 05:34:46', NULL),
(779, 2, 15, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:34:46', '2024-06-07 05:34:46', NULL),
(780, 2, 15, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:34:46', '2024-06-07 05:34:46', NULL),
(781, 2, 15, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:34:46', '2024-06-07 05:34:46', NULL),
(782, 2, 15, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:34:46', '2024-06-07 05:34:46', NULL),
(783, 2, 15, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:34:46', '2024-06-07 05:34:46', NULL),
(784, 2, 15, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:34:46', '2024-06-07 05:34:46', NULL),
(785, 2, 18, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:35:00', '2024-06-07 05:35:00', NULL),
(786, 2, 18, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:35:00', '2024-06-07 05:35:00', NULL),
(787, 2, 18, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:35:00', '2024-06-07 05:35:00', NULL),
(788, 2, 18, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:35:00', '2024-06-07 05:35:00', NULL),
(789, 2, 18, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:35:00', '2024-06-07 05:35:00', NULL),
(790, 2, 18, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:35:00', '2024-06-07 05:35:00', NULL),
(791, 2, 18, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:35:00', '2024-06-07 05:35:00', NULL),
(792, 2, 18, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:35:00', '2024-06-07 05:35:00', NULL),
(793, 2, 18, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:35:00', '2024-06-07 05:35:00', NULL),
(794, 2, 18, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:35:00', '2024-06-07 05:35:00', NULL),
(795, 2, 18, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:35:00', '2024-06-07 05:35:00', NULL),
(796, 2, 18, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:35:00', '2024-06-07 05:35:00', NULL),
(797, 2, 18, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:35:00', '2024-06-07 05:35:00', NULL),
(798, 2, 18, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:35:00', '2024-06-07 05:35:00', NULL),
(799, 2, 22, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:35:25', '2024-06-07 05:35:25', NULL),
(800, 2, 22, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:35:25', '2024-06-07 05:35:25', NULL),
(801, 2, 22, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:35:25', '2024-06-07 05:35:25', NULL),
(802, 2, 22, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:35:25', '2024-06-07 05:35:25', NULL),
(803, 2, 22, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:35:25', '2024-06-07 05:35:25', NULL),
(804, 2, 22, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:35:25', '2024-06-07 05:35:25', NULL),
(805, 2, 22, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:35:25', '2024-06-07 05:35:25', NULL),
(806, 2, 22, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:35:25', '2024-06-07 05:35:25', NULL),
(807, 2, 22, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:35:25', '2024-06-07 05:35:25', NULL),
(808, 2, 22, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:35:25', '2024-06-07 05:35:25', NULL),
(809, 2, 22, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:35:25', '2024-06-07 05:35:25', NULL),
(810, 2, 22, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:35:25', '2024-06-07 05:35:25', NULL),
(811, 2, 22, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:35:25', '2024-06-07 05:35:25', NULL),
(812, 2, 22, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:35:25', '2024-06-07 05:35:25', NULL),
(813, 2, 23, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:35:36', '2024-06-07 05:35:36', NULL),
(814, 2, 23, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:35:36', '2024-06-07 05:35:36', NULL),
(815, 2, 23, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:35:36', '2024-06-07 05:35:36', NULL),
(816, 2, 23, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:35:36', '2024-06-07 05:35:36', NULL),
(817, 2, 23, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:35:36', '2024-06-07 05:35:36', NULL),
(818, 2, 23, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:35:36', '2024-06-07 05:35:36', NULL),
(819, 2, 23, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:35:36', '2024-06-07 05:35:36', NULL),
(820, 2, 23, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:35:36', '2024-06-07 05:35:36', NULL),
(821, 2, 23, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:35:36', '2024-06-07 05:35:36', NULL),
(822, 2, 23, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:35:36', '2024-06-07 05:35:36', NULL),
(823, 2, 23, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:35:36', '2024-06-07 05:35:36', NULL),
(824, 2, 23, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:35:36', '2024-06-07 05:35:36', NULL),
(825, 2, 23, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:35:36', '2024-06-07 05:35:36', NULL),
(826, 2, 23, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:35:36', '2024-06-07 05:35:36', NULL),
(827, 2, 26, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:35:43', '2024-06-07 05:35:43', NULL),
(828, 2, 26, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:35:43', '2024-06-07 05:35:43', NULL),
(829, 2, 26, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:35:43', '2024-06-07 05:35:43', NULL),
(830, 2, 26, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:35:43', '2024-06-07 05:35:43', NULL),
(831, 2, 26, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:35:43', '2024-06-07 05:35:43', NULL),
(832, 2, 26, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:35:43', '2024-06-07 05:35:43', NULL),
(833, 2, 26, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:35:43', '2024-06-07 05:35:43', NULL),
(834, 2, 26, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:35:43', '2024-06-07 05:35:43', NULL),
(835, 2, 26, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:35:43', '2024-06-07 05:35:43', NULL),
(836, 2, 26, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:35:43', '2024-06-07 05:35:43', NULL),
(837, 2, 26, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:35:43', '2024-06-07 05:35:43', NULL),
(838, 2, 26, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:35:43', '2024-06-07 05:35:43', NULL),
(839, 2, 26, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:35:43', '2024-06-07 05:35:43', NULL),
(840, 2, 26, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:35:43', '2024-06-07 05:35:43', NULL),
(841, 2, 30, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:35:49', '2024-06-07 05:35:49', NULL),
(842, 2, 30, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:35:49', '2024-06-07 05:35:49', NULL),
(843, 2, 30, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:35:49', '2024-06-07 05:35:49', NULL),
(844, 2, 30, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:35:49', '2024-06-07 05:35:49', NULL),
(845, 2, 30, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:35:49', '2024-06-07 05:35:49', NULL),
(846, 2, 30, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:35:49', '2024-06-07 05:35:49', NULL),
(847, 2, 30, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:35:49', '2024-06-07 05:35:49', NULL),
(848, 2, 30, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:35:49', '2024-06-07 05:35:49', NULL),
(849, 2, 30, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:35:49', '2024-06-07 05:35:49', NULL),
(850, 2, 30, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:35:49', '2024-06-07 05:35:49', NULL),
(851, 2, 30, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:35:49', '2024-06-07 05:35:49', NULL),
(852, 2, 30, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:35:49', '2024-06-07 05:35:49', NULL),
(853, 2, 30, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:35:49', '2024-06-07 05:35:49', NULL),
(854, 2, 30, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:35:49', '2024-06-07 05:35:49', NULL),
(855, 2, 31, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:35:56', '2024-06-07 05:35:56', NULL),
(856, 2, 31, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:35:56', '2024-06-07 05:35:56', NULL),
(857, 2, 31, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:35:56', '2024-06-07 05:35:56', NULL),
(858, 2, 31, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:35:56', '2024-06-07 05:35:56', NULL),
(859, 2, 31, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:35:56', '2024-06-07 05:35:56', NULL),
(860, 2, 31, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:35:56', '2024-06-07 05:35:56', NULL),
(861, 2, 31, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:35:56', '2024-06-07 05:35:56', NULL),
(862, 2, 31, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:35:56', '2024-06-07 05:35:56', NULL),
(863, 2, 31, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:35:56', '2024-06-07 05:35:56', NULL),
(864, 2, 31, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:35:56', '2024-06-07 05:35:56', NULL),
(865, 2, 31, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:35:56', '2024-06-07 05:35:56', NULL),
(866, 2, 31, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:35:56', '2024-06-07 05:35:56', NULL),
(867, 2, 31, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:35:56', '2024-06-07 05:35:56', NULL),
(868, 2, 31, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:35:56', '2024-06-07 05:35:56', NULL),
(869, 2, 34, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:36:03', '2024-06-07 05:36:03', NULL),
(870, 2, 34, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:36:03', '2024-06-07 05:36:03', NULL),
(871, 2, 34, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:36:03', '2024-06-07 05:36:03', NULL),
(872, 2, 34, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:36:03', '2024-06-07 05:36:03', NULL),
(873, 2, 34, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:36:03', '2024-06-07 05:36:03', NULL),
(874, 2, 34, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:36:03', '2024-06-07 05:36:03', NULL),
(875, 2, 34, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:36:03', '2024-06-07 05:36:03', NULL),
(876, 2, 34, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:36:03', '2024-06-07 05:36:03', NULL),
(877, 2, 34, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:36:03', '2024-06-07 05:36:03', NULL),
(878, 2, 34, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:36:03', '2024-06-07 05:36:03', NULL),
(879, 2, 34, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:36:03', '2024-06-07 05:36:03', NULL),
(880, 2, 34, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:36:03', '2024-06-07 05:36:03', NULL),
(881, 2, 34, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:36:03', '2024-06-07 05:36:03', NULL),
(882, 2, 34, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:36:03', '2024-06-07 05:36:03', NULL),
(883, 2, 38, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:36:14', '2024-06-07 05:36:14', NULL),
(884, 2, 38, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:36:14', '2024-06-07 05:36:14', NULL),
(885, 2, 38, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:36:14', '2024-06-07 05:36:14', NULL),
(886, 2, 38, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:36:14', '2024-06-07 05:36:14', NULL),
(887, 2, 38, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:36:14', '2024-06-07 05:36:14', NULL),
(888, 2, 38, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:36:14', '2024-06-07 05:36:14', NULL),
(889, 2, 38, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:36:14', '2024-06-07 05:36:14', NULL),
(890, 2, 38, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:36:14', '2024-06-07 05:36:14', NULL),
(891, 2, 38, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:36:14', '2024-06-07 05:36:14', NULL),
(892, 2, 38, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:36:14', '2024-06-07 05:36:14', NULL),
(893, 2, 38, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:36:14', '2024-06-07 05:36:14', NULL),
(894, 2, 38, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:36:14', '2024-06-07 05:36:14', NULL),
(895, 2, 38, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:36:14', '2024-06-07 05:36:14', NULL),
(896, 2, 38, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:36:14', '2024-06-07 05:36:14', NULL),
(897, 2, 39, 70, 0, '2024-06-09 23:00:00', '2024-06-07 05:36:23', '2024-06-07 05:36:23', NULL),
(898, 2, 39, 70, 0, '2024-06-10 23:00:00', '2024-06-07 05:36:23', '2024-06-07 05:36:23', NULL),
(899, 2, 39, 70, 0, '2024-06-11 23:00:00', '2024-06-07 05:36:23', '2024-06-07 05:36:23', NULL),
(900, 2, 39, 70, 0, '2024-06-12 23:00:00', '2024-06-07 05:36:23', '2024-06-07 05:36:23', NULL),
(901, 2, 39, 70, 0, '2024-06-13 23:00:00', '2024-06-07 05:36:23', '2024-06-07 05:36:23', NULL),
(902, 2, 39, 70, 0, '2024-06-14 23:00:00', '2024-06-07 05:36:23', '2024-06-07 05:36:23', NULL),
(903, 2, 39, 70, 0, '2024-06-15 23:00:00', '2024-06-07 05:36:23', '2024-06-07 05:36:23', NULL),
(904, 2, 39, 70, 0, '2024-06-16 23:00:00', '2024-06-07 05:36:23', '2024-06-07 05:36:23', NULL),
(905, 2, 39, 70, 0, '2024-06-17 23:00:00', '2024-06-07 05:36:23', '2024-06-07 05:36:23', NULL),
(906, 2, 39, 70, 0, '2024-06-18 23:00:00', '2024-06-07 05:36:23', '2024-06-07 05:36:23', NULL),
(907, 2, 39, 70, 0, '2024-06-19 23:00:00', '2024-06-07 05:36:23', '2024-06-07 05:36:23', NULL),
(908, 2, 39, 70, 0, '2024-06-20 23:00:00', '2024-06-07 05:36:23', '2024-06-07 05:36:23', NULL),
(909, 2, 39, 70, 0, '2024-06-21 23:00:00', '2024-06-07 05:36:23', '2024-06-07 05:36:23', NULL),
(910, 2, 39, 70, 0, '2024-06-22 23:00:00', '2024-06-07 05:36:23', '2024-06-07 05:36:23', NULL),
(911, 4, 2, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:36:37', '2024-06-07 05:36:37', NULL),
(912, 4, 2, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:36:37', '2024-06-07 05:36:37', NULL),
(913, 4, 2, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:36:37', '2024-06-07 05:36:37', NULL),
(914, 4, 2, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:36:37', '2024-06-07 05:36:37', NULL),
(915, 4, 2, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:36:37', '2024-06-07 05:36:37', NULL),
(916, 4, 2, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:36:37', '2024-06-07 05:36:37', NULL),
(917, 4, 2, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:36:37', '2024-06-07 05:36:37', NULL),
(918, 4, 2, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:36:37', '2024-06-07 05:36:37', NULL),
(919, 4, 2, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:36:37', '2024-06-07 05:36:37', NULL),
(920, 4, 2, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:36:37', '2024-06-07 05:36:37', NULL),
(921, 4, 2, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:36:37', '2024-06-07 05:36:37', NULL),
(922, 4, 2, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:36:37', '2024-06-07 05:36:37', NULL),
(923, 4, 2, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:36:37', '2024-06-07 05:36:37', NULL),
(924, 4, 2, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:36:37', '2024-06-07 05:36:37', NULL),
(925, 4, 6, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:36:42', '2024-06-07 05:36:42', NULL),
(926, 4, 6, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:36:42', '2024-06-07 05:36:42', NULL),
(927, 4, 6, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:36:42', '2024-06-07 05:36:42', NULL),
(928, 4, 6, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:36:42', '2024-06-07 05:36:42', NULL),
(929, 4, 6, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:36:42', '2024-06-07 05:36:42', NULL),
(930, 4, 6, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:36:42', '2024-06-07 05:36:42', NULL),
(931, 4, 6, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:36:42', '2024-06-07 05:36:42', NULL),
(932, 4, 6, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:36:42', '2024-06-07 05:36:42', NULL),
(933, 4, 6, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:36:42', '2024-06-07 05:36:42', NULL),
(934, 4, 6, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:36:42', '2024-06-07 05:36:42', NULL),
(935, 4, 6, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:36:42', '2024-06-07 05:36:42', NULL),
(936, 4, 6, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:36:42', '2024-06-07 05:36:42', NULL),
(937, 4, 6, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:36:42', '2024-06-07 05:36:42', NULL),
(938, 4, 6, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:36:42', '2024-06-07 05:36:42', NULL),
(939, 4, 7, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:36:47', '2024-06-07 05:36:47', NULL),
(940, 4, 7, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:36:47', '2024-06-07 05:36:47', NULL),
(941, 4, 7, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:36:47', '2024-06-07 05:36:47', NULL),
(942, 4, 7, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:36:47', '2024-06-07 05:36:47', NULL),
(943, 4, 7, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:36:47', '2024-06-07 05:36:47', NULL),
(944, 4, 7, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:36:47', '2024-06-07 05:36:47', NULL),
(945, 4, 7, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:36:47', '2024-06-07 05:36:47', NULL),
(946, 4, 7, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:36:47', '2024-06-07 05:36:47', NULL),
(947, 4, 7, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:36:47', '2024-06-07 05:36:47', NULL),
(948, 4, 7, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:36:47', '2024-06-07 05:36:47', NULL),
(949, 4, 7, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:36:47', '2024-06-07 05:36:47', NULL),
(950, 4, 7, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:36:47', '2024-06-07 05:36:47', NULL),
(951, 4, 7, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:36:47', '2024-06-07 05:36:47', NULL),
(952, 4, 7, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:36:47', '2024-06-07 05:36:47', NULL),
(953, 4, 10, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:36:52', '2024-06-07 05:36:52', NULL),
(954, 4, 10, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:36:52', '2024-06-07 05:36:52', NULL),
(955, 4, 10, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:36:52', '2024-06-07 05:36:52', NULL),
(956, 4, 10, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:36:52', '2024-06-07 05:36:52', NULL),
(957, 4, 10, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:36:52', '2024-06-07 05:36:52', NULL),
(958, 4, 10, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:36:52', '2024-06-07 05:36:52', NULL),
(959, 4, 10, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:36:52', '2024-06-07 05:36:52', NULL),
(960, 4, 10, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:36:52', '2024-06-07 05:36:52', NULL),
(961, 4, 10, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:36:52', '2024-06-07 05:36:52', NULL),
(962, 4, 10, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:36:52', '2024-06-07 05:36:52', NULL),
(963, 4, 10, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:36:52', '2024-06-07 05:36:52', NULL),
(964, 4, 10, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:36:52', '2024-06-07 05:36:52', NULL),
(965, 4, 10, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:36:52', '2024-06-07 05:36:52', NULL),
(966, 4, 10, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:36:52', '2024-06-07 05:36:52', NULL),
(967, 4, 14, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:36:58', '2024-06-07 05:36:58', NULL),
(968, 4, 14, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:36:58', '2024-06-07 05:36:58', NULL),
(969, 4, 14, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:36:58', '2024-06-07 05:36:58', NULL),
(970, 4, 14, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:36:58', '2024-06-07 05:36:58', NULL),
(971, 4, 14, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:36:58', '2024-06-07 05:36:58', NULL),
(972, 4, 14, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:36:58', '2024-06-07 05:36:58', NULL),
(973, 4, 14, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:36:58', '2024-06-07 05:36:58', NULL),
(974, 4, 14, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:36:58', '2024-06-07 05:36:58', NULL),
(975, 4, 14, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:36:58', '2024-06-07 05:36:58', NULL),
(976, 4, 14, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:36:58', '2024-06-07 05:36:58', NULL),
(977, 4, 14, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:36:58', '2024-06-07 05:36:58', NULL),
(978, 4, 14, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:36:58', '2024-06-07 05:36:58', NULL),
(979, 4, 14, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:36:58', '2024-06-07 05:36:58', NULL),
(980, 4, 14, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:36:58', '2024-06-07 05:36:58', NULL),
(981, 4, 15, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:37:02', '2024-06-07 05:37:02', NULL),
(982, 4, 15, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:37:02', '2024-06-07 05:37:02', NULL),
(983, 4, 15, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:37:02', '2024-06-07 05:37:02', NULL),
(984, 4, 15, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:37:02', '2024-06-07 05:37:02', NULL),
(985, 4, 15, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:37:02', '2024-06-07 05:37:02', NULL),
(986, 4, 15, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:37:02', '2024-06-07 05:37:02', NULL),
(987, 4, 15, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:37:02', '2024-06-07 05:37:02', NULL),
(988, 4, 15, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:37:02', '2024-06-07 05:37:02', NULL),
(989, 4, 15, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:37:02', '2024-06-07 05:37:02', NULL),
(990, 4, 15, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:37:02', '2024-06-07 05:37:02', NULL),
(991, 4, 15, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:37:02', '2024-06-07 05:37:02', NULL),
(992, 4, 15, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:37:02', '2024-06-07 05:37:02', NULL),
(993, 4, 15, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:37:02', '2024-06-07 05:37:02', NULL),
(994, 4, 15, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:37:02', '2024-06-07 05:37:02', NULL),
(995, 4, 18, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:37:07', '2024-06-07 05:37:07', NULL),
(996, 4, 18, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:37:07', '2024-06-07 05:37:07', NULL),
(997, 4, 18, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:37:07', '2024-06-07 05:37:07', NULL),
(998, 4, 18, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:37:07', '2024-06-07 05:37:07', NULL),
(999, 4, 18, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:37:07', '2024-06-07 05:37:07', NULL),
(1000, 4, 18, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:37:07', '2024-06-07 05:37:07', NULL),
(1001, 4, 18, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:37:07', '2024-06-07 05:37:07', NULL),
(1002, 4, 18, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:37:07', '2024-06-07 05:37:07', NULL),
(1003, 4, 18, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:37:07', '2024-06-07 05:37:07', NULL),
(1004, 4, 18, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:37:07', '2024-06-07 05:37:07', NULL),
(1005, 4, 18, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:37:07', '2024-06-07 05:37:07', NULL),
(1006, 4, 18, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:37:07', '2024-06-07 05:37:07', NULL),
(1007, 4, 18, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:37:07', '2024-06-07 05:37:07', NULL),
(1008, 4, 18, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:37:07', '2024-06-07 05:37:07', NULL),
(1009, 4, 22, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:37:11', '2024-06-07 05:37:11', NULL),
(1010, 4, 22, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:37:11', '2024-06-07 05:37:11', NULL),
(1011, 4, 22, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:37:11', '2024-06-07 05:37:11', NULL),
(1012, 4, 22, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:37:11', '2024-06-07 05:37:11', NULL),
(1013, 4, 22, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:37:11', '2024-06-07 05:37:11', NULL),
(1014, 4, 22, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:37:11', '2024-06-07 05:37:11', NULL),
(1015, 4, 22, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:37:11', '2024-06-07 05:37:11', NULL),
(1016, 4, 22, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:37:11', '2024-06-07 05:37:11', NULL),
(1017, 4, 22, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:37:11', '2024-06-07 05:37:11', NULL),
(1018, 4, 22, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:37:11', '2024-06-07 05:37:11', NULL),
(1019, 4, 22, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:37:11', '2024-06-07 05:37:11', NULL),
(1020, 4, 22, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:37:11', '2024-06-07 05:37:11', NULL),
(1021, 4, 22, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:37:11', '2024-06-07 05:37:11', NULL),
(1022, 4, 22, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:37:11', '2024-06-07 05:37:11', NULL),
(1023, 4, 23, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:37:20', '2024-06-07 05:37:20', NULL),
(1024, 4, 23, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:37:20', '2024-06-07 05:37:20', NULL),
(1025, 4, 23, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:37:20', '2024-06-07 05:37:20', NULL),
(1026, 4, 23, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:37:20', '2024-06-07 05:37:20', NULL),
(1027, 4, 23, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:37:20', '2024-06-07 05:37:20', NULL),
(1028, 4, 23, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:37:20', '2024-06-07 05:37:20', NULL),
(1029, 4, 23, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:37:20', '2024-06-07 05:37:20', NULL),
(1030, 4, 23, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:37:20', '2024-06-07 05:37:20', NULL),
(1031, 4, 23, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:37:20', '2024-06-07 05:37:20', NULL),
(1032, 4, 23, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:37:20', '2024-06-07 05:37:20', NULL),
(1033, 4, 23, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:37:20', '2024-06-07 05:37:20', NULL),
(1034, 4, 23, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:37:20', '2024-06-07 05:37:20', NULL),
(1035, 4, 23, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:37:20', '2024-06-07 05:37:20', NULL),
(1036, 4, 23, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:37:20', '2024-06-07 05:37:20', NULL),
(1037, 4, 26, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:37:25', '2024-06-07 05:37:25', NULL),
(1038, 4, 26, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:37:25', '2024-06-07 05:37:25', NULL),
(1039, 4, 26, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:37:25', '2024-06-07 05:37:25', NULL),
(1040, 4, 26, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:37:25', '2024-06-07 05:37:25', NULL),
(1041, 4, 26, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:37:25', '2024-06-07 05:37:25', NULL),
(1042, 4, 26, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:37:25', '2024-06-07 05:37:25', NULL),
(1043, 4, 26, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:37:25', '2024-06-07 05:37:25', NULL),
(1044, 4, 26, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:37:25', '2024-06-07 05:37:25', NULL),
(1045, 4, 26, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:37:25', '2024-06-07 05:37:25', NULL),
(1046, 4, 26, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:37:25', '2024-06-07 05:37:25', NULL),
(1047, 4, 26, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:37:25', '2024-06-07 05:37:25', NULL),
(1048, 4, 26, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:37:25', '2024-06-07 05:37:25', NULL),
(1049, 4, 26, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:37:25', '2024-06-07 05:37:25', NULL),
(1050, 4, 26, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:37:25', '2024-06-07 05:37:25', NULL),
(1051, 4, 30, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:37:30', '2024-06-07 05:37:30', NULL),
(1052, 4, 30, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:37:30', '2024-06-07 05:37:30', NULL),
(1053, 4, 30, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:37:30', '2024-06-07 05:37:30', NULL),
(1054, 4, 30, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:37:30', '2024-06-07 05:37:30', NULL),
(1055, 4, 30, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:37:30', '2024-06-07 05:37:30', NULL),
(1056, 4, 30, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:37:30', '2024-06-07 05:37:30', NULL),
(1057, 4, 30, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:37:30', '2024-06-07 05:37:30', NULL),
(1058, 4, 30, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:37:30', '2024-06-07 05:37:30', NULL),
(1059, 4, 30, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:37:30', '2024-06-07 05:37:30', NULL),
(1060, 4, 30, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:37:30', '2024-06-07 05:37:30', NULL),
(1061, 4, 30, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:37:30', '2024-06-07 05:37:30', NULL),
(1062, 4, 30, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:37:30', '2024-06-07 05:37:30', NULL);
INSERT INTO `vehicle_route_destinations` (`id`, `vehicle_id`, `route_schedule_id`, `available_seats`, `reserved_seats`, `date`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1063, 4, 30, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:37:30', '2024-06-07 05:37:30', NULL),
(1064, 4, 30, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:37:30', '2024-06-07 05:37:30', NULL),
(1065, 4, 31, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:37:34', '2024-06-07 05:37:34', NULL),
(1066, 4, 31, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:37:34', '2024-06-07 05:37:34', NULL),
(1067, 4, 31, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:37:34', '2024-06-07 05:37:34', NULL),
(1068, 4, 31, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:37:34', '2024-06-07 05:37:34', NULL),
(1069, 4, 31, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:37:34', '2024-06-07 05:37:34', NULL),
(1070, 4, 31, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:37:34', '2024-06-07 05:37:34', NULL),
(1071, 4, 31, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:37:34', '2024-06-07 05:37:34', NULL),
(1072, 4, 31, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:37:34', '2024-06-07 05:37:34', NULL),
(1073, 4, 31, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:37:34', '2024-06-07 05:37:34', NULL),
(1074, 4, 31, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:37:34', '2024-06-07 05:37:34', NULL),
(1075, 4, 31, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:37:34', '2024-06-07 05:37:34', NULL),
(1076, 4, 31, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:37:34', '2024-06-07 05:37:34', NULL),
(1077, 4, 31, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:37:34', '2024-06-07 05:37:34', NULL),
(1078, 4, 31, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:37:34', '2024-06-07 05:37:34', NULL),
(1079, 4, 34, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:37:39', '2024-06-07 05:37:39', NULL),
(1080, 4, 34, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:37:39', '2024-06-07 05:37:39', NULL),
(1081, 4, 34, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:37:39', '2024-06-07 05:37:39', NULL),
(1082, 4, 34, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:37:39', '2024-06-07 05:37:39', NULL),
(1083, 4, 34, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:37:39', '2024-06-07 05:37:39', NULL),
(1084, 4, 34, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:37:39', '2024-06-07 05:37:39', NULL),
(1085, 4, 34, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:37:39', '2024-06-07 05:37:39', NULL),
(1086, 4, 34, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:37:39', '2024-06-07 05:37:39', NULL),
(1087, 4, 34, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:37:39', '2024-06-07 05:37:39', NULL),
(1088, 4, 34, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:37:39', '2024-06-07 05:37:39', NULL),
(1089, 4, 34, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:37:39', '2024-06-07 05:37:39', NULL),
(1090, 4, 34, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:37:39', '2024-06-07 05:37:39', NULL),
(1091, 4, 34, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:37:39', '2024-06-07 05:37:39', NULL),
(1092, 4, 34, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:37:39', '2024-06-07 05:37:39', NULL),
(1093, 4, 38, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:37:44', '2024-06-07 05:37:44', NULL),
(1094, 4, 38, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:37:44', '2024-06-07 05:37:44', NULL),
(1095, 4, 38, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:37:44', '2024-06-07 05:37:44', NULL),
(1096, 4, 38, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:37:44', '2024-06-07 05:37:44', NULL),
(1097, 4, 38, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:37:44', '2024-06-07 05:37:44', NULL),
(1098, 4, 38, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:37:44', '2024-06-07 05:37:44', NULL),
(1099, 4, 38, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:37:44', '2024-06-07 05:37:44', NULL),
(1100, 4, 38, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:37:44', '2024-06-07 05:37:44', NULL),
(1101, 4, 38, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:37:44', '2024-06-07 05:37:44', NULL),
(1102, 4, 38, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:37:44', '2024-06-07 05:37:44', NULL),
(1103, 4, 38, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:37:44', '2024-06-07 05:37:44', NULL),
(1104, 4, 38, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:37:44', '2024-06-07 05:37:44', NULL),
(1105, 4, 38, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:37:44', '2024-06-07 05:37:44', NULL),
(1106, 4, 38, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:37:44', '2024-06-07 05:37:44', NULL),
(1107, 4, 39, 30, 0, '2024-06-09 23:00:00', '2024-06-07 05:37:47', '2024-06-07 05:37:47', NULL),
(1108, 4, 39, 30, 0, '2024-06-10 23:00:00', '2024-06-07 05:37:47', '2024-06-07 05:37:47', NULL),
(1109, 4, 39, 30, 0, '2024-06-11 23:00:00', '2024-06-07 05:37:47', '2024-06-07 05:37:47', NULL),
(1110, 4, 39, 30, 0, '2024-06-12 23:00:00', '2024-06-07 05:37:47', '2024-06-07 05:37:47', NULL),
(1111, 4, 39, 30, 0, '2024-06-13 23:00:00', '2024-06-07 05:37:47', '2024-06-07 05:37:47', NULL),
(1112, 4, 39, 30, 0, '2024-06-14 23:00:00', '2024-06-07 05:37:47', '2024-06-07 05:37:47', NULL),
(1113, 4, 39, 30, 0, '2024-06-15 23:00:00', '2024-06-07 05:37:47', '2024-06-07 05:37:47', NULL),
(1114, 4, 39, 30, 0, '2024-06-16 23:00:00', '2024-06-07 05:37:47', '2024-06-07 05:37:47', NULL),
(1115, 4, 39, 30, 0, '2024-06-17 23:00:00', '2024-06-07 05:37:47', '2024-06-07 05:37:47', NULL),
(1116, 4, 39, 30, 0, '2024-06-18 23:00:00', '2024-06-07 05:37:47', '2024-06-07 05:37:47', NULL),
(1117, 4, 39, 30, 0, '2024-06-19 23:00:00', '2024-06-07 05:37:47', '2024-06-07 05:37:47', NULL),
(1118, 4, 39, 30, 0, '2024-06-20 23:00:00', '2024-06-07 05:37:47', '2024-06-07 05:37:47', NULL),
(1119, 4, 39, 30, 0, '2024-06-21 23:00:00', '2024-06-07 05:37:47', '2024-06-07 05:37:47', NULL),
(1120, 4, 39, 30, 0, '2024-06-22 23:00:00', '2024-06-07 05:37:47', '2024-06-07 05:37:47', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservations_user_id_foreign` (`user_id`),
  ADD KEY `reservations_vehicle_route_destination_id_foreign` (`vehicle_route_destination_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `route_destinations`
--
ALTER TABLE `route_destinations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `route_destinations_route_id_foreign` (`route_id`);

--
-- Indexes for table `route_schedules`
--
ALTER TABLE `route_schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `route_schedules_route_destination_id_foreign` (`route_destination_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tickets_reservation_id_foreign` (`reservation_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nin_unique` (`NIN`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicles_vehicle_category_id_foreign` (`vehicle_category_id`);

--
-- Indexes for table `vehicle_categories`
--
ALTER TABLE `vehicle_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_route_destinations`
--
ALTER TABLE `vehicle_route_destinations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vehicle_route_destinations_vehicle_id_foreign` (`vehicle_id`),
  ADD KEY `vehicle_route_destinations_route_schedule_id_foreign` (`route_schedule_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `route_destinations`
--
ALTER TABLE `route_destinations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `route_schedules`
--
ALTER TABLE `route_schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicle_categories`
--
ALTER TABLE `vehicle_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vehicle_route_destinations`
--
ALTER TABLE `vehicle_route_destinations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1121;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_vehicle_route_destination_id_foreign` FOREIGN KEY (`vehicle_route_destination_id`) REFERENCES `vehicle_route_destinations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `route_destinations`
--
ALTER TABLE `route_destinations`
  ADD CONSTRAINT `route_destinations_route_id_foreign` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `route_schedules`
--
ALTER TABLE `route_schedules`
  ADD CONSTRAINT `route_schedules_route_destination_id_foreign` FOREIGN KEY (`route_destination_id`) REFERENCES `route_destinations` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_reservation_id_foreign` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_vehicle_category_id_foreign` FOREIGN KEY (`vehicle_category_id`) REFERENCES `vehicle_categories` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `vehicle_route_destinations`
--
ALTER TABLE `vehicle_route_destinations`
  ADD CONSTRAINT `vehicle_route_destinations_route_schedule_id_foreign` FOREIGN KEY (`route_schedule_id`) REFERENCES `route_schedules` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `vehicle_route_destinations_vehicle_id_foreign` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
