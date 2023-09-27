-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 27, 2023 at 02:10 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `luvmystory`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` bigint(20) NOT NULL,
  `story_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_deleted` tinyint(1) DEFAULT NULL,
  `email` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guest_name` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `story_id`, `user_id`, `message`, `created_by`, `created_at`, `updated_by`, `updated_at`, `is_deleted`, `email`, `guest_name`) VALUES
(1, NULL, NULL, 'sads', 'System', '2023-08-24 05:07:00', 'System', '2023-08-24 05:07:00', 0, 'kenneth.marco09@gmail.com', 'kenneth marco'),
(2, 1, NULL, 'asds', 'System', '2023-08-24 05:09:09', 'System', '2023-08-24 05:09:09', 0, 'btcopsen@protonmail.com', 'Alfrdo unson'),
(3, 1, NULL, 'sads', 'System', '2023-08-24 05:34:57', 'System', '2023-08-24 05:34:57', 0, 'test@email.com', 'Alfrdo unson'),
(4, 1, NULL, 'czxc', 'System', '2023-08-24 05:36:54', 'System', '2023-08-24 05:36:54', 0, 'kenneth.marco09@gmail.com', 'zxcx'),
(5, 1, NULL, 'sads', 'System', '2023-08-24 05:37:19', 'System', '2023-08-24 05:37:19', 0, 'test@email.com', 'admins admins'),
(6, 1, NULL, 'dsad', 'System', '2023-08-24 05:37:27', 'System', '2023-08-24 05:37:27', 0, 'kenneth.marco09@gmail.com', 'sads'),
(7, 1, 1, 'this is a test', 'kenneth.marco09@gmail.com', '2023-08-24 05:43:03', 'kenneth.marco09@gmail.com', '2023-08-24 05:43:03', 0, NULL, NULL),
(8, 1, 1, 'asdsadsd', 'kenneth.marco09@gmail.com', '2023-08-24 05:44:51', 'kenneth.marco09@gmail.com', '2023-08-24 05:44:51', 0, NULL, NULL),
(9, 1, 1, 'adsadsa', 'kenneth.marco09@gmail.com', '2023-08-24 05:44:57', 'kenneth.marco09@gmail.com', '2023-08-24 05:44:57', 0, NULL, NULL),
(10, 1, 1, 'this is a test comment', 'kenneth.marco09@gmail.com', '2023-08-24 05:51:01', 'kenneth.marco09@gmail.com', '2023-08-24 05:51:01', 0, NULL, NULL),
(11, 1, 5, 'sadsd', 'superadmin@email.com', '2023-08-24 05:57:46', 'superadmin@email.com', '2023-08-24 05:57:46', 0, NULL, NULL),
(12, 1, 5, 'asdsa', 'superadmin@email.com', '2023-08-24 05:59:18', 'superadmin@email.com', '2023-08-24 05:59:18', 0, NULL, NULL),
(13, 1, 5, 'dasdsad', 'superadmin@email.com', '2023-08-24 12:27:43', 'superadmin@email.com', '2023-08-24 12:27:43', 0, NULL, NULL),
(14, 1, 5, 'this is a super test', 'superadmin@email.com', '2023-08-24 12:27:54', 'superadmin@email.com', '2023-08-24 12:27:54', 0, NULL, NULL),
(15, 1, 5, 'this is a test', 'superadmin@email.com', '2023-08-24 12:30:19', 'superadmin@email.com', '2023-08-24 12:30:19', 0, NULL, NULL),
(16, 1, 5, 'dsadsd', 'superadmin@email.com', '2023-08-24 12:30:59', 'superadmin@email.com', '2023-08-24 12:30:59', 0, NULL, NULL),
(17, 1, 5, 'sadsad', 'superadmin@email.com', '2023-08-24 12:48:56', 'superadmin@email.com', '2023-08-24 12:48:56', 0, NULL, NULL),
(18, 1, 5, 'test\r\nasdsad', 'superadmin@email.com', '2023-08-24 12:49:13', 'superadmin@email.com', '2023-08-24 12:49:13', 0, NULL, NULL),
(19, 1, 5, 'dasdsads\r\ndsad\r\ndsad\r\n', 'superadmin@email.com', '2023-08-24 12:49:22', 'superadmin@email.com', '2023-08-24 12:49:22', 0, NULL, NULL),
(20, 1, 5, 'comment\r\n', 'superadmin@email.com', '2023-08-24 12:50:14', 'superadmin@email.com', '2023-08-24 12:50:14', 0, NULL, NULL),
(21, 1, 5, 'waadsdsad \r\nasds\r\nasdsad', 'superadmin@email.com', '2023-08-24 12:51:24', 'superadmin@email.com', '2023-08-24 12:51:24', 0, NULL, NULL),
(22, 1, 5, 'dsads\r\nsdsa\r\nsadd', 'superadmin@email.com', '2023-08-24 12:52:13', 'superadmin@email.com', '2023-08-24 12:52:13', 0, NULL, NULL),
(23, 1, 5, 'asdsad\r\nsadsa\r\nsadasds', 'superadmin@email.com', '2023-08-24 12:52:35', 'superadmin@email.com', '2023-08-24 12:52:35', 0, NULL, NULL),
(24, 1, 5, 'dasds\r\nadsa\r\nasd\r\nsad', 'superadmin@email.com', '2023-08-24 13:47:07', 'superadmin@email.com', '2023-08-24 13:47:07', 0, NULL, NULL),
(25, 1, 1, 'asdsadasd', 'kenneth.marco09@gmail.com', '2023-09-08 07:16:21', 'kenneth.marco09@gmail.com', '2023-09-08 07:16:21', 0, NULL, NULL),
(26, 1, 1, 'asdsdsa', 'kenneth.marco09@gmail.com', '2023-09-08 07:16:24', 'kenneth.marco09@gmail.com', '2023-09-08 07:16:24', 0, NULL, NULL),
(27, 1, 1, 'asdsd', 'kenneth.marco09@gmail.com', '2023-09-08 07:16:28', 'kenneth.marco09@gmail.com', '2023-09-08 07:16:28', 0, NULL, NULL),
(28, 1, 1, 'sdfsdfds', 'kenneth.marco09@gmail.com', '2023-09-08 07:16:35', 'kenneth.marco09@gmail.com', '2023-09-08 07:16:35', 0, NULL, NULL),
(29, 1, 1, '', 'kenneth.marco09@gmail.com', '2023-09-08 07:18:43', 'kenneth.marco09@gmail.com', '2023-09-08 07:18:43', 0, NULL, NULL),
(30, 1, 1, 'sdasdsd\r\nsadsad', 'kenneth.marco09@gmail.com', '2023-09-08 07:44:47', 'kenneth.marco09@gmail.com', '2023-09-08 07:44:47', 0, NULL, NULL),
(31, 1, 1, 'dasdasdsa', 'kenneth.marco09@gmail.com', '2023-09-08 07:44:53', 'kenneth.marco09@gmail.com', '2023-09-08 07:44:53', 0, NULL, NULL),
(32, 1, 1, 'testing', 'kenneth.marco09@gmail.com', '2023-09-08 07:45:07', 'kenneth.marco09@gmail.com', '2023-09-08 07:45:07', 0, NULL, NULL),
(33, 1, 1, 'wewewew\r\nwewewq\r\nqwewqe', 'kenneth.marco09@gmail.com', '2023-09-08 07:45:18', 'kenneth.marco09@gmail.com', '2023-09-08 07:45:18', 0, NULL, NULL),
(34, 1, 1, 'sadsd\r\ndasds\r\nasdsa\r\nasdsad\r\n', 'kenneth.marco09@gmail.com', '2023-09-08 07:45:46', 'kenneth.marco09@gmail.com', '2023-09-08 07:45:46', 0, NULL, NULL),
(35, 1, 1, 'that is aweome\r\ndasdsa\r\nasdasd', 'kenneth.marco09@gmail.com', '2023-09-08 07:46:16', 'kenneth.marco09@gmail.com', '2023-09-08 07:46:16', 0, NULL, NULL),
(36, 1, 1, '', 'kenneth.marco09@gmail.com', '2023-09-08 07:53:49', 'kenneth.marco09@gmail.com', '2023-09-08 07:53:49', 0, NULL, NULL),
(37, 1, 1, 'zcxzcxzcx', 'kenneth.marco09@gmail.com', '2023-09-08 07:54:12', 'kenneth.marco09@gmail.com', '2023-09-08 07:54:12', 0, NULL, NULL),
(38, 1, 1, '', 'kenneth.marco09@gmail.com', '2023-09-08 07:54:18', 'kenneth.marco09@gmail.com', '2023-09-08 07:54:18', 0, NULL, NULL),
(39, 1, 1, '', 'kenneth.marco09@gmail.com', '2023-09-08 07:54:19', 'kenneth.marco09@gmail.com', '2023-09-08 07:54:19', 0, NULL, NULL),
(40, 1, 1, '', 'kenneth.marco09@gmail.com', '2023-09-08 07:54:29', 'kenneth.marco09@gmail.com', '2023-09-08 07:54:29', 0, NULL, NULL),
(41, 1, 1, '', 'kenneth.marco09@gmail.com', '2023-09-08 07:54:30', 'kenneth.marco09@gmail.com', '2023-09-08 07:54:30', 0, NULL, NULL),
(42, 1, 1, 'wa', 'kenneth.marco09@gmail.com', '2023-09-08 08:00:59', 'kenneth.marco09@gmail.com', '2023-09-08 08:00:59', 0, NULL, NULL),
(43, 1, 1, '', 'kenneth.marco09@gmail.com', '2023-09-08 08:01:03', 'kenneth.marco09@gmail.com', '2023-09-08 08:01:03', 0, NULL, NULL),
(44, 1, 1, '', 'kenneth.marco09@gmail.com', '2023-09-08 08:01:31', 'kenneth.marco09@gmail.com', '2023-09-08 08:01:31', 0, NULL, NULL),
(45, 1, 1, '', 'kenneth.marco09@gmail.com', '2023-09-08 08:01:33', 'kenneth.marco09@gmail.com', '2023-09-08 08:01:33', 0, NULL, NULL),
(46, 1, 1, '', 'kenneth.marco09@gmail.com', '2023-09-08 08:01:35', 'kenneth.marco09@gmail.com', '2023-09-08 08:01:35', 0, NULL, NULL),
(47, 1, 1, '', 'kenneth.marco09@gmail.com', '2023-09-08 08:01:39', 'kenneth.marco09@gmail.com', '2023-09-08 08:01:39', 0, NULL, NULL),
(48, 1, 1, '', 'kenneth.marco09@gmail.com', '2023-09-08 08:01:43', 'kenneth.marco09@gmail.com', '2023-09-08 08:01:43', 0, NULL, NULL),
(49, 1, 1, '', 'kenneth.marco09@gmail.com', '2023-09-08 08:01:56', 'kenneth.marco09@gmail.com', '2023-09-08 08:01:56', 0, NULL, NULL),
(50, 1, 1, '', 'kenneth.marco09@gmail.com', '2023-09-08 08:01:59', 'kenneth.marco09@gmail.com', '2023-09-08 08:01:59', 0, NULL, NULL),
(51, 1, 1, 'fsdfsdfsdf', 'kenneth.marco09@gmail.com', '2023-09-08 08:10:05', 'kenneth.marco09@gmail.com', '2023-09-08 08:10:05', 0, NULL, NULL),
(52, 1, 1, '', 'kenneth.marco09@gmail.com', '2023-09-08 08:10:12', 'kenneth.marco09@gmail.com', '2023-09-08 08:10:12', 0, NULL, NULL),
(53, 1, 1, 'sdfdsfdsf', 'kenneth.marco09@gmail.com', '2023-09-08 08:17:41', 'kenneth.marco09@gmail.com', '2023-09-08 08:17:41', 0, NULL, NULL),
(54, 1, 1, 'asdsadsads\r\nasdasdas\r\n', 'kenneth.marco09@gmail.com', '2023-09-08 08:17:50', 'kenneth.marco09@gmail.com', '2023-09-08 08:17:50', 0, NULL, NULL),
(55, 1, 1, 'sadasda\r\nsadasdsa\r\ndasdasdsa\r\n', 'kenneth.marco09@gmail.com', '2023-09-08 08:19:39', 'kenneth.marco09@gmail.com', '2023-09-08 08:19:39', 0, NULL, NULL),
(56, 1, 1, 'asdsad\r\nasds\r\nasdasdas', 'kenneth.marco09@gmail.com', '2023-09-08 08:21:20', 'kenneth.marco09@gmail.com', '2023-09-08 08:21:20', 0, NULL, NULL),
(57, 1, 1, 'asds\r\nasdasd\r\nasdsa', 'kenneth.marco09@gmail.com', '2023-09-08 08:21:39', 'kenneth.marco09@gmail.com', '2023-09-08 08:21:39', 0, NULL, NULL),
(58, 1, 1, 'dsdd\r\nasda\r\nasds', 'kenneth.marco09@gmail.com', '2023-09-08 08:22:01', 'kenneth.marco09@gmail.com', '2023-09-08 08:22:01', 0, NULL, NULL),
(59, 1, 1, 'sdasdsa\r\nasdsad\r\nasdas\r\nasdas\r\ndasda\r\nsdasd\r\nasdas\r\ndasd\r\nasd\r\nasd', 'kenneth.marco09@gmail.com', '2023-09-08 08:22:22', 'kenneth.marco09@gmail.com', '2023-09-08 08:22:22', 0, NULL, NULL),
(60, 1, 1, 'dasdasd\r\nasdas\r\ndsa\r\nasdas', 'kenneth.marco09@gmail.com', '2023-09-08 08:22:40', 'kenneth.marco09@gmail.com', '2023-09-08 08:22:40', 0, NULL, NULL),
(61, 1, 1, 'fsdfdsfklsjdflkjsdjlkfds\r\nsdfkls;djfsdf\r\ndsf\r\nsdfs\r\ndf\r\nsd\r\nfsd\r\nf\r\nsd\r\nf\r\nsdf\r\ns\r\ndf\r\nsd\r\nfds\r\nfds', 'kenneth.marco09@gmail.com', '2023-09-08 08:25:51', 'kenneth.marco09@gmail.com', '2023-09-08 08:25:51', 0, NULL, NULL),
(62, 1, 1, 'dsfdf', 'kenneth.marco09@gmail.com', '2023-09-08 08:26:52', 'kenneth.marco09@gmail.com', '2023-09-08 08:26:52', 0, NULL, NULL),
(63, 1, 1, '', 'kenneth.marco09@gmail.com', '2023-09-08 08:27:01', 'kenneth.marco09@gmail.com', '2023-09-08 08:27:01', 0, NULL, NULL),
(64, 1, 1, 'asdasdasdas', 'kenneth.marco09@gmail.com', '2023-09-08 08:28:08', 'kenneth.marco09@gmail.com', '2023-09-08 08:28:08', 0, NULL, NULL),
(65, 1, 1, '', 'kenneth.marco09@gmail.com', '2023-09-08 08:28:16', 'kenneth.marco09@gmail.com', '2023-09-08 08:28:16', 0, NULL, NULL),
(66, 1, 1, 'asdasdsadsdsad', 'kenneth.marco09@gmail.com', '2023-09-08 08:29:14', 'kenneth.marco09@gmail.com', '2023-09-08 08:29:14', 0, NULL, NULL),
(67, 2, 1, 'gdfgfdgf', 'kenneth.marco09@gmail.com', '2023-09-14 02:23:15', 'kenneth.marco09@gmail.com', '2023-09-14 02:23:15', 0, NULL, NULL),
(68, 2, 1, 'gfgfg', 'kenneth.marco09@gmail.com', '2023-09-14 02:23:23', 'kenneth.marco09@gmail.com', '2023-09-14 02:23:23', 0, NULL, NULL),
(69, 2, 1, 'gdfgf', 'kenneth.marco09@gmail.com', '2023-09-14 02:23:30', 'kenneth.marco09@gmail.com', '2023-09-14 02:23:30', 0, NULL, NULL),
(70, 2, 1, 'xzcxzcx', 'kenneth.marco09@gmail.com', '2023-09-14 04:32:07', 'kenneth.marco09@gmail.com', '2023-09-14 04:32:07', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` bigint(20) NOT NULL,
  `story_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `notification_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_deleted` tinyint(1) DEFAULT NULL,
  `comment_id` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `story_id`, `user_id`, `notification_type`, `is_read`, `created_by`, `created_at`, `updated_by`, `updated_at`, `is_deleted`, `comment_id`) VALUES
(1, 1, 1, 'Story', 1, 'admin@email.com', '2023-08-02 17:18:27', 'kenneth.marco09@gmail.com', '2023-08-02 17:19:08', 0, NULL),
(2, 2, 1, 'Story', 1, 'admin@email.com', '2023-08-02 17:18:44', 'kenneth.marco09@gmail.com', '2023-08-02 17:19:15', 0, NULL),
(4, 2, 9, 'Share', 1, 'kenneth.marco09@gmail.com', '2023-08-31 12:32:43', 'kenneth.marco0s9@gmail.com', '2023-08-31 12:33:29', 0, NULL),
(5, 2, 2, 'Share', 1, 'kenneth.marco09@gmail.com', '2023-08-31 12:37:24', 'solomiachepka@gmail.com', '2023-09-14 04:37:00', 0, NULL),
(6, 2, 9, 'Share', 0, 'kenneth.marco09@gmail.com', '2023-09-02 12:38:32', 'kenneth.marco09@gmail.com', '2023-09-02 12:38:32', 0, NULL),
(7, 2, 2, 'Share', 0, 'kenneth.marco09@gmail.com', '2023-09-04 08:48:43', 'kenneth.marco09@gmail.com', '2023-09-04 08:48:43', 0, NULL),
(8, 2, 9, 'Share', 0, 'kenneth.marco09@gmail.com', '2023-09-04 10:03:58', 'kenneth.marco09@gmail.com', '2023-09-04 10:03:58', 0, NULL),
(9, 2, 2, 'Share', 0, 'kenneth.marco09@gmail.com', '2023-09-04 10:05:21', 'kenneth.marco09@gmail.com', '2023-09-04 10:05:21', 0, NULL),
(10, 2, 9, 'Share', 0, 'kenneth.marco09@gmail.com', '2023-09-04 10:06:26', 'kenneth.marco09@gmail.com', '2023-09-04 10:06:26', 0, NULL),
(11, 2, 2, 'Share', 0, 'kenneth.marco09@gmail.com', '2023-09-04 10:07:25', 'kenneth.marco09@gmail.com', '2023-09-04 10:07:25', 0, NULL),
(12, 2, 2, 'Share', 0, 'kenneth.marco09@gmail.com', '2023-09-04 10:08:45', 'kenneth.marco09@gmail.com', '2023-09-04 10:08:45', 0, NULL),
(13, 2, 9, 'Share', 0, 'kenneth.marco09@gmail.com', '2023-09-04 10:09:32', 'kenneth.marco09@gmail.com', '2023-09-04 10:09:32', 0, NULL),
(14, 2, 9, 'Share', 0, 'kenneth.marco09@gmail.com', '2023-09-04 10:15:15', 'kenneth.marco09@gmail.com', '2023-09-04 10:15:15', 0, NULL),
(15, 2, 2, 'Share', 0, 'kenneth.marco09@gmail.com', '2023-09-04 10:16:06', 'kenneth.marco09@gmail.com', '2023-09-04 10:16:06', 0, NULL),
(16, 2, 2, 'Share', 0, 'kenneth.marco09@gmail.com', '2023-09-04 10:30:16', 'kenneth.marco09@gmail.com', '2023-09-04 10:30:16', 0, NULL),
(17, 2, 2, 'Share', 0, 'kenneth.marco09@gmail.com', '2023-09-04 10:31:02', 'kenneth.marco09@gmail.com', '2023-09-04 10:31:02', 0, NULL),
(18, 2, 2, 'Share', 0, 'kenneth.marco09@gmail.com', '2023-09-04 10:32:16', 'kenneth.marco09@gmail.com', '2023-09-04 10:32:16', 0, NULL),
(19, 2, 2, 'Share', 0, 'kenneth.marco09@gmail.com', '2023-09-04 10:34:40', 'kenneth.marco09@gmail.com', '2023-09-04 10:34:40', 0, NULL),
(20, 2, 9, 'Share', 0, 'kenneth.marco09@gmail.com', '2023-09-04 10:44:09', 'kenneth.marco09@gmail.com', '2023-09-04 10:44:09', 0, NULL),
(21, 2, 2, 'Share', 0, 'kenneth.marco09@gmail.com', '2023-09-04 10:46:08', 'kenneth.marco09@gmail.com', '2023-09-04 10:46:08', 0, NULL),
(22, 2, 9, 'Share', 0, 'kenneth.marco09@gmail.com', '2023-09-04 10:46:39', 'kenneth.marco09@gmail.com', '2023-09-04 10:46:39', 0, NULL),
(23, 2, 9, 'Share', 0, 'kenneth.marco09@gmail.com', '2023-09-04 10:46:54', 'kenneth.marco09@gmail.com', '2023-09-04 10:46:54', 0, NULL),
(24, 2, 2, 'Share', 0, 'kenneth.marco09@gmail.com', '2023-09-04 10:47:00', 'kenneth.marco09@gmail.com', '2023-09-04 10:47:00', 0, NULL),
(25, 1, 8, 'Share', 0, 'kenneth.marco09@gmail.com', '2023-09-08 09:01:17', 'kenneth.marco09@gmail.com', '2023-09-08 09:01:17', 0, NULL),
(26, 1, 2, 'Share', 1, 'kenneth.marco09@gmail.com', '2023-09-08 09:08:21', 'solomiachepka@gmail.com', '2023-09-08 09:32:03', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `acuity_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schedule_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_created` datetime NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `isPaid` tinyint(1) DEFAULT NULL,
  `schedule_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calendar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `calendar_time_zone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `acuity_time_zone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmation_page` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmation_page_payment_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_deleted` tinyint(1) DEFAULT NULL,
  `file_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parsed_file_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `user_id`, `acuity_id`, `schedule_date`, `start_time`, `end_time`, `date_created`, `price`, `isPaid`, `schedule_type`, `calendar`, `calendar_time_zone`, `acuity_time_zone`, `confirmation_page`, `category`, `confirmation_page_payment_link`, `created_by`, `created_at`, `updated_by`, `updated_at`, `is_deleted`, `file_desc`, `parsed_file_desc`) VALUES
(1, 1, '1083192796', 'July 20, 2023', '2:00pm', '2:30pm', '2023-07-17 08:04:27', '0.00', 0, 'Test', 'Dean ', 'America/Denver', 'Asia/Shanghai', 'https://app.acuityscheduling.com/schedule.php?owner=27019921&action=appt&id%5B%5D=639c7ecbf02ab49daa72d9292d0c4631', 'LuvMy Story', 'https://app.acuityscheduling.com/schedule.php?owner=27019921&action=appt&id%5B%5D=639c7ecbf02ab49daa72d9292d0c4631&paymentLink=true#payment', 'System', '2023-07-17 08:04:28', 'admin@email.com', '2023-08-02 17:18:44', 0, 'Text-to-Speech_17-Jul-2023_23-45.mp3', '1-1690989524.mp3'),
(2, 1, '1085767790', 'July 21, 2023', '7:00pm', '7:30pm', '2023-07-20 23:39:33', '0.00', 0, 'Test', 'Dean ', 'America/Denver', 'Asia/Shanghai', 'https://app.acuityscheduling.com/schedule.php?owner=27019921&action=appt&id%5B%5D=869c54746640fdf9e1d8bdeaf6dc03a6', 'LuvMy Story', 'https://app.acuityscheduling.com/schedule.php?owner=27019921&action=appt&id%5B%5D=869c54746640fdf9e1d8bdeaf6dc03a6&paymentLink=true#payment', 'System', '2023-07-20 23:39:35', 'admin@email.com', '2023-08-02 17:18:26', 0, 'Text-to-Speech_17-Jul-2023_23-45.mp3', '2-1690989506.mp3');

-- --------------------------------------------------------

--
-- Table structure for table `schedule_form`
--

CREATE TABLE `schedule_form` (
  `id` bigint(20) NOT NULL,
  `schedule_id` bigint(20) DEFAULT NULL,
  `schedule_form_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `field_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `field_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `field_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_deleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedule_form`
--

INSERT INTO `schedule_form` (`id`, `schedule_id`, `schedule_form_id`, `field_id`, `form_name`, `field_value`, `field_name`, `created_by`, `created_at`, `updated_by`, `updated_at`, `is_deleted`) VALUES
(1, 1, '2192660', '12264045', 'LuvMy Family or Friend', 'A Special Friend', 'Who is this special gift for?', 'System', '2023-07-17 08:04:28', 'System', '2023-07-17 08:04:28', 0),
(2, 1, '2192660', '12264055', 'LuvMy Family or Friend', 'kenneth marco', 'What is this special person\'s full name?', 'System', '2023-07-17 08:04:28', 'System', '2023-07-17 08:04:28', 0),
(3, 1, '2192660', '12264133', 'LuvMy Family or Friend', 'test@email.com', 'Their Email Address.', 'System', '2023-07-17 08:04:28', 'System', '2023-07-17 08:04:28', 0),
(4, 1, '2192660', '12264142', 'LuvMy Family or Friend', '09923696065', 'Contact Phone Number', 'System', '2023-07-17 08:04:28', 'System', '2023-07-17 08:04:28', 0),
(5, 1, '2192660', '12264113', 'LuvMy Family or Friend', 'How we met?', 'What type of story are you hoping to have recorded?', 'System', '2023-07-17 08:04:28', 'System', '2023-07-17 08:04:28', 0),
(6, 1, '2192660', '12264127', 'LuvMy Family or Friend', 'SDFD', 'If Other, please tell us in a few words what type of story you are hoping to record?', 'System', '2023-07-17 08:04:28', 'System', '2023-07-17 08:04:28', 0),
(7, 2, '2192660', '12264045', 'LuvMy Family or Friend', 'Family Member', 'Who is this special gift for?', 'System', '2023-07-20 23:39:35', 'System', '2023-07-20 23:39:35', 0),
(8, 2, '2192660', '12264055', 'LuvMy Family or Friend', 'test', 'What is this special person\'s full name?', 'System', '2023-07-20 23:39:35', 'System', '2023-07-20 23:39:35', 0),
(9, 2, '2192660', '12264133', 'LuvMy Family or Friend', 'test@email.com', 'Their Email Address.', 'System', '2023-07-20 23:39:35', 'System', '2023-07-20 23:39:35', 0),
(10, 2, '2192660', '12264142', 'LuvMy Family or Friend', '09999999', 'Contact Phone Number', 'System', '2023-07-20 23:39:35', 'System', '2023-07-20 23:39:35', 0),
(11, 2, '2192660', '12264113', 'LuvMy Family or Friend', 'Our first date.', 'What type of story are you hoping to have recorded?', 'System', '2023-07-20 23:39:35', 'System', '2023-07-20 23:39:35', 0),
(12, 2, '2192660', '12264127', 'LuvMy Family or Friend', 'others', 'If Other, please tell us in a few words what type of story you are hoping to record?', 'System', '2023-07-20 23:39:35', 'System', '2023-07-20 23:39:35', 0);

-- --------------------------------------------------------

--
-- Table structure for table `schedule_payment`
--

CREATE TABLE `schedule_payment` (
  `id` bigint(20) NOT NULL,
  `schedule_id` bigint(20) DEFAULT NULL,
  `transaction_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `payment_gateway` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_deleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `share_story`
--

CREATE TABLE `share_story` (
  `id` bigint(20) NOT NULL,
  `story_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_deleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `share_story`
--

INSERT INTO `share_story` (`id`, `story_id`, `user_id`, `is_read`, `created_by`, `created_at`, `updated_by`, `updated_at`, `is_deleted`) VALUES
(9, 2, 9, NULL, 'kenneth.marco09@gmail.com', '2023-09-02 12:38:32', 'kenneth.marco09@gmail.com', '2023-09-04 10:34:28', 1),
(10, 2, 2, NULL, 'kenneth.marco09@gmail.com', '2023-09-04 08:48:43', 'kenneth.marco09@gmail.com', '2023-09-04 10:34:31', 1),
(11, 2, 9, NULL, 'kenneth.marco09@gmail.com', '2023-09-04 10:03:58', 'kenneth.marco09@gmail.com', '2023-09-04 10:04:59', 1),
(12, 2, 2, NULL, 'kenneth.marco09@gmail.com', '2023-09-04 10:05:21', 'kenneth.marco09@gmail.com', '2023-09-04 10:05:49', 1),
(13, 2, 9, NULL, 'kenneth.marco09@gmail.com', '2023-09-04 10:06:26', 'kenneth.marco09@gmail.com', '2023-09-04 10:34:34', 1),
(14, 2, 2, NULL, 'kenneth.marco09@gmail.com', '2023-09-04 10:07:25', 'kenneth.marco09@gmail.com', '2023-09-04 10:08:28', 1),
(15, 2, 2, NULL, 'kenneth.marco09@gmail.com', '2023-09-04 10:08:45', 'kenneth.marco09@gmail.com', '2023-09-04 10:08:52', 1),
(16, 2, 9, NULL, 'kenneth.marco09@gmail.com', '2023-09-04 10:09:32', 'kenneth.marco09@gmail.com', '2023-09-04 10:10:07', 1),
(17, 2, 9, NULL, 'kenneth.marco09@gmail.com', '2023-09-04 10:15:15', 'kenneth.marco09@gmail.com', '2023-09-04 10:15:22', 1),
(18, 2, 2, NULL, 'kenneth.marco09@gmail.com', '2023-09-04 10:16:06', 'kenneth.marco09@gmail.com', '2023-09-04 10:16:13', 1),
(19, 2, 2, NULL, 'kenneth.marco09@gmail.com', '2023-09-04 10:30:16', 'kenneth.marco09@gmail.com', '2023-09-04 10:30:23', 1),
(20, 2, 2, NULL, 'kenneth.marco09@gmail.com', '2023-09-04 10:31:02', 'kenneth.marco09@gmail.com', '2023-09-04 10:31:07', 1),
(21, 2, 2, NULL, 'kenneth.marco09@gmail.com', '2023-09-04 10:32:16', 'kenneth.marco09@gmail.com', '2023-09-04 10:32:23', 1),
(22, 2, 2, NULL, 'kenneth.marco09@gmail.com', '2023-09-04 10:34:40', 'kenneth.marco09@gmail.com', '2023-09-04 10:45:59', 1),
(23, 2, 9, NULL, 'kenneth.marco09@gmail.com', '2023-09-04 10:44:09', 'kenneth.marco09@gmail.com', '2023-09-04 10:46:02', 1),
(24, 2, 2, NULL, 'kenneth.marco09@gmail.com', '2023-09-04 10:46:07', 'kenneth.marco09@gmail.com', '2023-09-04 10:46:46', 1),
(25, 2, 9, NULL, 'kenneth.marco09@gmail.com', '2023-09-04 10:46:39', 'kenneth.marco09@gmail.com', '2023-09-04 10:46:49', 1),
(26, 2, 9, NULL, 'kenneth.marco09@gmail.com', '2023-09-04 10:46:54', 'kenneth.marco09@gmail.com', '2023-09-04 10:46:54', 0),
(27, 2, 2, NULL, 'kenneth.marco09@gmail.com', '2023-09-04 10:47:00', 'solomiachepka@gmail.com', '2023-09-25 14:09:28', 1),
(28, 1, 8, NULL, 'kenneth.marco09@gmail.com', '2023-09-08 09:01:17', 'kenneth.marco09@gmail.com', '2023-09-08 09:01:17', 0),
(29, 1, 2, NULL, 'kenneth.marco09@gmail.com', '2023-09-08 09:08:21', 'kenneth.marco09@gmail.com', '2023-09-08 09:08:21', 0);

-- --------------------------------------------------------

--
-- Table structure for table `story`
--

CREATE TABLE `story` (
  `id` bigint(20) NOT NULL,
  `schedule_id` bigint(20) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `file_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parsed_file_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_deleted` tinyint(1) DEFAULT NULL,
  `is_public` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `story`
--

INSERT INTO `story` (`id`, `schedule_id`, `is_read`, `file_desc`, `parsed_file_desc`, `created_by`, `created_at`, `updated_by`, `updated_at`, `is_deleted`, `is_public`) VALUES
(1, 2, 0, 'Screenshot 2023-05-05 205959.png', '1-1691410054.png', 'admin@email.com', '2023-08-02 17:18:27', 'kenneth.marco09@gmail.com', '2023-09-21 13:04:00', 1, 1),
(2, 1, 0, NULL, NULL, 'admin@email.com', '2023-08-02 17:18:44', 'kenneth.marco09@gmail.com', '2023-08-14 08:06:16', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `story_like`
--

CREATE TABLE `story_like` (
  `id` bigint(20) NOT NULL,
  `story_id` bigint(20) DEFAULT NULL,
  `user_id` bigint(20) DEFAULT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_deleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `story_like`
--

INSERT INTO `story_like` (`id`, `story_id`, `user_id`, `created_by`, `created_at`, `updated_by`, `updated_at`, `is_deleted`) VALUES
(1, 2, 1, 'kenneth.marco09@gmail.com', '2023-09-14 03:41:53', 'kenneth.marco09@gmail.com', '2023-09-14 07:08:19', 1),
(6, 1, 1, 'kenneth.marco09@gmail.com', '2023-09-18 14:11:36', 'kenneth.marco09@gmail.com', '2023-09-18 14:13:03', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` bigint(20) NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` datetime DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_photo_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parsed_profile_photo_desc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_deleted` tinyint(1) DEFAULT NULL,
  `password_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `password`, `type`, `first_name`, `middle_name`, `last_name`, `email`, `phone_no`, `bio`, `gender`, `birth_date`, `token`, `status`, `profile_photo_desc`, `parsed_profile_photo_desc`, `created_by`, `created_at`, `updated_by`, `updated_at`, `is_deleted`, `password_token`) VALUES
(1, '$2a$15$F0lz6OLyXjF790sR3aPyv.V11/soQh3UmF5CEUg1qUGvTUYikT2OW', 'Client', 'kenneth', NULL, 'marco', 'kenneth.marco09@gmail.com', '09923696065', 'this is a test', 'Female', '2023-07-01 00:00:00', 'oYMAU370dfjn', 'Active', 'Screenshot 2023-05-05 205959.png', '1-1691411413.png', 'kenneth.marco09@gmail.com', '2023-07-17 07:41:46', 'System', '2023-08-14 09:08:19', 0, 'Gn3J6jPyPlI6'),
(2, '$2a$15$F0lz6OLyXjF790sR3aPyv.V11/soQh3UmF5CEUg1qUGvTUYikT2OW', 'Client', 'Solomiia', NULL, 'Chepka', 'solomiachepka@gmail.com', '9087976', '.khvljhv', 'Female', '2023-07-12 00:00:00', '0q2NIh1o4ArE', 'Active', 'IMG_7203_Original.jpg', '2-1690542643.jpg', 'System', '2023-07-20 23:35:09', 'solomiachepka@gmail.com', '2023-07-28 06:10:43', 0, NULL),
(5, '$2a$15$ZWFvIwtRs23LoJcWxdaDJeB1TkB3trlQ9HHevmntNh//BmpBhXSay', 'Super Admin', 'super', NULL, 'admin', 'superadmin@email.com', NULL, NULL, NULL, NULL, '', 'Active', NULL, NULL, 'System', '2023-07-28 19:07:44', 'System', '2023-07-28 19:07:44', NULL, NULL),
(6, '$2a$15$jcx60iZgqMzh28golO9hRuw1sa56kKdk3g0ysJYURor0Lcyj2ur8e', 'Admin', 'admin', NULL, 'admin', 'admin@email.com', NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, 'superadmin@email.com', '2023-07-31 21:50:55', 'superadmin@email.com', '2023-07-31 21:50:55', 0, NULL),
(8, '$2a$15$CGuYOKHxU2a0NRJvrc53OOLaqTtaj2EUHUB0mtbrX56I7b9M5T34O', 'Admin', 'test', NULL, 'test', 'neon18f97321@gmail.com', NULL, NULL, NULL, NULL, NULL, 'Active', NULL, NULL, 'superadmin@email.com', '2023-08-24 05:56:32', 'superadmin@email.com', '2023-08-24 05:56:32', 0, NULL),
(9, '$2a$15$F0lz6OLyXjF790sR3aPyv.V11/soQh3UmF5CEUg1qUGvTUYikT2OW', 'Client', 'kenneth', NULL, 'marco', 'kenneth.marco0s9@gmail.com', '09923696065', 'this is a test', 'Female', '2023-07-01 00:00:00', 'oYMAU370dfjn', 'Active', 'Screenshot 2023-05-05 205959.png', '1-1691411413.png', 'kenneth.marco09@gmail.com', '2023-07-17 07:41:46', 'System', '2023-08-14 09:08:19', 0, 'Gn3J6jPyPlI6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9474526CAA5D4036` (`story_id`),
  ADD KEY `IDX_9474526CA76ED395` (`user_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_BF5476CAF8697D13` (`comment_id`),
  ADD KEY `IDX_BF5476CAA76ED395` (`user_id`),
  ADD KEY `IDX_BF5476CAAA5D4036` (`story_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5A3811FBA76ED395` (`user_id`);

--
-- Indexes for table `schedule_form`
--
ALTER TABLE `schedule_form`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_B2C0DD14A40BC2D5` (`schedule_id`);

--
-- Indexes for table `schedule_payment`
--
ALTER TABLE `schedule_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_E042A8BCA40BC2D5` (`schedule_id`);

--
-- Indexes for table `share_story`
--
ALTER TABLE `share_story`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6238E8D5AA5D4036` (`story_id`),
  ADD KEY `IDX_6238E8D5A76ED395` (`user_id`);

--
-- Indexes for table `story`
--
ALTER TABLE `story`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_EB560438A40BC2D5` (`schedule_id`);

--
-- Indexes for table `story_like`
--
ALTER TABLE `story_like`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3ACE2C9DAA5D4036` (`story_id`),
  ADD KEY `IDX_3ACE2C9DA76ED395` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `schedule_form`
--
ALTER TABLE `schedule_form`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `schedule_payment`
--
ALTER TABLE `schedule_payment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `share_story`
--
ALTER TABLE `share_story`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `story`
--
ALTER TABLE `story`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `story_like`
--
ALTER TABLE `story_like`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_9474526CAA5D4036` FOREIGN KEY (`story_id`) REFERENCES `story` (`id`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `FK_BF5476CAA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_BF5476CAAA5D4036` FOREIGN KEY (`story_id`) REFERENCES `story` (`id`),
  ADD CONSTRAINT `FK_BF5476CAF8697D13` FOREIGN KEY (`comment_id`) REFERENCES `comment` (`id`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `FK_5A3811FBA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `schedule_form`
--
ALTER TABLE `schedule_form`
  ADD CONSTRAINT `FK_B2C0DD14A40BC2D5` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`id`);

--
-- Constraints for table `schedule_payment`
--
ALTER TABLE `schedule_payment`
  ADD CONSTRAINT `FK_E042A8BCA40BC2D5` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`id`);

--
-- Constraints for table `share_story`
--
ALTER TABLE `share_story`
  ADD CONSTRAINT `FK_6238E8D5A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_6238E8D5AA5D4036` FOREIGN KEY (`story_id`) REFERENCES `story` (`id`);

--
-- Constraints for table `story`
--
ALTER TABLE `story`
  ADD CONSTRAINT `FK_EB560438A40BC2D5` FOREIGN KEY (`schedule_id`) REFERENCES `schedule` (`id`);

--
-- Constraints for table `story_like`
--
ALTER TABLE `story_like`
  ADD CONSTRAINT `FK_3ACE2C9DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_3ACE2C9DAA5D4036` FOREIGN KEY (`story_id`) REFERENCES `story` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
