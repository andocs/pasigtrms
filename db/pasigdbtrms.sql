-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2024 at 05:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pasigdbtrms`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `permission_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_log`
--

INSERT INTO `audit_log` (`id`, `userid`, `action`, `description`, `timestamp`, `permission_id`) VALUES
(4, 23, 'login', 'User logged in', '2024-05-21 08:02:56', NULL),
(5, 23, 'login', 'User logged in', '2024-05-21 08:13:32', NULL),
(7, 23, 'login', 'User logged in', '2024-05-21 14:00:17', NULL),
(8, 20, 'login', 'User logged in', '2024-05-21 14:16:31', NULL),
(9, 23, 'login', 'User logged in', '2024-05-22 00:33:26', NULL),
(10, 23, 'logout', 'User logged out', '2024-05-22 00:53:13', NULL),
(11, 20, 'login', 'User logged in', '2024-05-22 01:49:44', NULL),
(12, 20, 'logout', 'User logged out', '2024-05-22 01:49:51', NULL),
(13, 20, 'login', 'User logged in', '2024-05-22 01:50:07', NULL),
(14, 20, 'login', 'User logged in', '2024-05-22 05:06:40', NULL),
(20, 20, 'login', 'User logged in', '2024-05-24 00:30:53', NULL),
(21, 20, 'logout', 'User logged out', '2024-05-24 00:41:14', NULL),
(23, 20, 'login', 'User logged in', '2024-05-24 01:03:38', NULL),
(24, 20, 'logout', 'User logged out', '2024-05-24 06:39:06', NULL),
(25, 37, 'login', 'User logged in', '2024-05-24 06:39:16', NULL),
(26, 37, 'logout', 'User logged out', '2024-05-24 08:27:39', NULL),
(27, 20, 'login', 'User logged in', '2024-05-24 08:30:11', NULL),
(28, 20, 'logout', 'User logged out', '2024-05-24 08:43:48', NULL),
(29, 23, 'login', 'User logged in', '2024-05-24 13:45:55', NULL),
(30, 23, 'login', 'User logged in', '2024-05-24 13:48:48', NULL),
(33, 20, 'login', 'User logged in', '2024-05-24 14:11:34', NULL),
(38, 20, 'login', 'User logged in', '2024-05-25 00:05:32', NULL),
(39, 20, 'logout', 'User logged out', '2024-05-25 00:52:47', NULL),
(41, 23, 'login', 'User logged in', '2024-05-25 02:44:57', NULL),
(42, 37, 'login', 'User logged in', '2024-05-25 02:56:41', NULL),
(43, 37, 'logout', 'User logged out', '2024-05-25 03:17:20', NULL),
(44, 37, 'login', 'User logged in', '2024-05-25 04:52:40', NULL),
(45, 20, 'login', 'User logged in', '2024-05-25 12:29:20', NULL),
(46, 20, 'logout', 'User logged out', '2024-05-25 13:03:54', NULL),
(54, 20, 'login', 'User logged in', '2024-05-27 04:26:10', NULL),
(55, 20, 'logout', 'User logged out', '2024-05-27 06:20:16', NULL),
(56, 23, 'login', 'User logged in', '2024-05-27 07:22:51', NULL),
(58, 37, 'login', 'User logged in', '2024-05-28 00:05:41', NULL),
(61, 37, 'login', 'User logged in', '2024-05-28 04:03:50', NULL),
(62, 37, 'login', 'User logged in', '2024-05-28 04:08:13', NULL),
(63, 37, 'logout', 'User logged out', '2024-05-28 04:13:50', NULL),
(64, 37, 'login', 'User logged in', '2024-05-28 06:07:28', NULL),
(65, 37, 'logout', 'User logged out', '2024-05-28 07:24:19', NULL),
(66, 37, 'login', 'User logged in', '2024-05-28 07:24:27', NULL),
(67, 37, 'logout', 'User logged out', '2024-05-28 08:12:12', NULL),
(89, 20, 'login', 'User logged in', '2024-05-31 05:23:00', NULL),
(90, 20, 'logout', 'User logged out', '2024-05-31 05:23:40', NULL),
(91, 23, 'login', 'User logged in', '2024-05-31 05:23:54', NULL),
(92, 23, 'logout', 'User logged out', '2024-05-31 05:24:01', NULL),
(97, 20, 'login', 'User logged in', '2024-05-31 08:47:45', NULL),
(98, 20, 'logout', 'User logged out', '2024-05-31 08:47:51', NULL),
(99, 37, 'login', 'User logged in', '2024-05-31 08:48:04', NULL),
(100, 37, 'logout', 'User logged out', '2024-05-31 08:48:09', NULL),
(115, 20, 'login', 'User logged in', '2024-06-01 01:22:45', NULL),
(116, 20, 'logout', 'User logged out', '2024-06-01 01:23:07', NULL),
(124, 37, 'login', 'User logged in', '2024-06-03 03:55:35', NULL),
(125, 37, 'logout', 'User logged out', '2024-06-03 04:29:22', NULL),
(126, 37, 'login', 'User logged in', '2024-06-03 04:29:46', NULL),
(127, 49, 'login', 'User logged in', '2024-06-03 05:51:52', NULL),
(128, 49, 'logout', 'User logged out', '2024-06-03 06:35:27', NULL),
(129, 49, 'login', 'User logged in', '2024-06-03 06:52:31', NULL),
(130, 37, 'login', 'User logged in', '2024-06-03 09:00:03', NULL),
(131, 37, 'logout', 'User logged out', '2024-06-03 09:01:00', NULL),
(132, 37, 'login', 'User logged in', '2024-06-03 09:01:06', NULL),
(133, 49, 'logout', 'User logged out', '2024-06-03 09:04:43', NULL),
(134, 49, 'login', 'User logged in', '2024-06-04 06:57:28', NULL),
(135, 49, 'logout', 'User logged out', '2024-06-04 07:21:35', NULL),
(136, 37, 'login', 'User logged in', '2024-06-04 07:21:41', NULL),
(137, 37, 'logout', 'User logged out', '2024-06-04 07:59:06', NULL),
(138, 37, 'login', 'User logged in', '2024-06-04 08:01:38', NULL),
(139, 37, 'logout', 'User logged out', '2024-06-04 08:55:09', NULL),
(140, 49, 'login', 'User logged in', '2024-06-05 01:26:34', NULL),
(141, 49, 'logout', 'User logged out', '2024-06-05 01:48:23', NULL),
(142, 37, 'login', 'User logged in', '2024-06-05 01:48:30', NULL),
(143, 49, 'login', 'User logged in', '2024-06-05 02:32:22', NULL),
(144, 49, 'logout', 'User logged out', '2024-06-05 02:33:26', NULL),
(145, 23, 'login', 'User logged in', '2024-06-05 03:12:03', NULL),
(146, 23, 'logout', 'User logged out', '2024-06-05 06:04:35', NULL),
(147, 37, 'logout', 'User logged out', '2024-06-05 07:12:09', NULL),
(148, 50, 'login', 'User logged in', '2024-06-05 07:36:29', NULL),
(149, 23, 'login', 'User logged in', '2024-06-05 07:42:56', NULL),
(150, 23, 'logout', 'User logged out', '2024-06-05 08:06:22', NULL),
(151, 50, 'logout', 'User logged out', '2024-06-05 09:03:45', NULL),
(152, 37, 'login', 'User logged in', '2024-06-05 12:29:34', NULL),
(153, 23, 'login', 'User logged in', '2024-06-05 12:38:09', NULL),
(154, 23, 'logout', 'User logged out', '2024-06-05 12:54:09', NULL),
(155, 23, 'login', 'User logged in', '2024-06-05 12:57:52', NULL),
(156, 37, 'logout', 'User logged out', '2024-06-05 13:01:56', NULL),
(157, 37, 'login', 'User logged in', '2024-06-05 13:05:00', NULL),
(158, 23, 'logout', 'User logged out', '2024-06-05 13:41:23', NULL),
(159, 37, 'logout', 'User logged out', '2024-06-05 13:41:30', NULL),
(160, 37, 'login', 'User logged in', '2024-06-05 13:41:57', NULL),
(161, 37, 'logout', 'User logged out', '2024-06-05 13:55:57', NULL),
(162, 37, 'login', 'User logged in', '2024-06-06 05:55:40', NULL),
(163, 23, 'login', 'User logged in', '2024-06-06 05:57:22', NULL),
(164, 37, 'logout', 'User logged out', '2024-06-06 06:06:17', NULL),
(165, 23, 'logout', 'User logged out', '2024-06-06 06:06:20', NULL),
(166, 37, 'login', 'User logged in', '2024-06-06 06:08:12', NULL),
(167, 37, 'logout', 'User logged out', '2024-06-06 06:08:37', NULL),
(168, 37, 'login', 'User logged in', '2024-06-06 06:08:45', NULL),
(169, 37, 'logout', 'User logged out', '2024-06-06 06:27:06', NULL),
(170, 37, 'login', 'User logged in', '2024-06-06 06:32:19', NULL),
(171, 37, 'logout', 'User logged out', '2024-06-06 06:35:47', NULL),
(172, 37, 'login', 'User logged in', '2024-06-06 06:46:32', NULL),
(173, 37, 'logout', 'User logged out', '2024-06-06 07:06:18', NULL),
(174, 37, 'login', 'User logged in', '2024-06-06 07:09:01', NULL),
(175, 37, 'logout', 'User logged out', '2024-06-06 07:13:36', NULL),
(176, 37, 'login', 'User logged in', '2024-06-06 07:13:50', NULL),
(177, 37, 'logout', 'User logged out', '2024-06-06 07:47:21', NULL),
(178, 37, 'login', 'User logged in', '2024-06-06 12:43:53', NULL),
(179, 37, 'logout', 'User logged out', '2024-06-06 13:25:45', NULL),
(180, 51, 'login', 'User logged in', '2024-06-06 13:46:17', NULL),
(181, 50, 'login', 'User logged in', '2024-06-06 13:50:28', NULL),
(182, 50, 'login', 'User logged in', '2024-06-06 14:05:33', NULL),
(183, 51, 'logout', 'User logged out', '2024-06-06 14:46:42', NULL),
(184, 50, 'logout', 'User logged out', '2024-06-06 14:47:31', NULL),
(185, 37, 'login', 'User logged in', '2024-06-07 01:24:16', NULL),
(186, 37, 'logout', 'User logged out', '2024-06-07 06:35:53', NULL),
(187, 37, 'login', 'User logged in', '2024-06-14 05:50:11', NULL),
(188, 37, 'logout', 'User logged out', '2024-06-14 06:02:32', NULL),
(189, 37, 'login', 'User logged in', '2024-06-14 06:15:45', NULL),
(190, 37, 'logout', 'User logged out', '2024-06-14 06:49:59', NULL),
(191, 50, 'login', 'User logged in', '2024-06-15 09:27:36', NULL),
(192, 50, 'logout', 'User logged out', '2024-06-15 09:30:57', NULL),
(193, 37, 'login', 'User logged in', '2024-06-15 09:31:09', NULL),
(194, 37, 'logout', 'User logged out', '2024-06-15 09:32:59', NULL),
(195, 23, 'login', 'User logged in', '2024-06-15 09:33:14', NULL),
(196, 23, 'logout', 'User logged out', '2024-06-15 09:36:01', NULL),
(197, 49, 'login', 'User logged in', '2024-07-04 06:16:24', NULL),
(198, 49, 'login', 'User logged in', '2024-07-04 11:30:04', NULL),
(199, 49, 'login', 'User logged in', '2024-07-04 12:14:20', NULL),
(200, 49, 'logout', 'User logged out', '2024-07-04 12:39:48', NULL),
(201, 49, 'login', 'User logged in', '2024-07-04 12:40:13', NULL),
(202, 49, 'login', 'User logged in', '2024-07-08 01:32:24', NULL),
(203, 49, 'login', 'User logged in', '2024-07-08 05:41:15', NULL),
(204, 49, 'logout', 'User logged out', '2024-07-08 05:53:27', NULL),
(205, 49, 'login', 'User logged in', '2024-07-08 05:57:33', NULL),
(206, 49, 'logout', 'User logged out', '2024-07-08 05:58:29', NULL),
(207, 49, 'login', 'User logged in', '2024-07-08 05:58:51', NULL),
(208, 49, 'logout', 'User logged out', '2024-07-08 05:58:57', NULL),
(209, 49, 'login', 'User logged in', '2024-07-08 13:18:07', NULL),
(210, 49, 'login', 'User logged in', '2024-07-09 03:33:23', NULL),
(211, 49, 'logout', 'User logged out', '2024-07-09 03:37:39', NULL),
(212, 49, 'login', 'User logged in', '2024-07-09 03:38:23', NULL),
(213, 49, 'logout', 'User logged out', '2024-07-09 04:14:00', NULL),
(214, 49, 'login', 'User logged in', '2024-07-09 04:18:01', NULL),
(215, 49, 'logout', 'User logged out', '2024-07-09 04:18:05', NULL),
(216, 49, 'login', 'User logged in', '2024-07-09 04:18:22', NULL),
(217, 49, 'logout', 'User logged out', '2024-07-09 04:25:34', NULL),
(218, 49, 'login', 'User logged in', '2024-07-09 04:35:25', NULL),
(219, 49, 'login', 'User logged in', '2024-07-09 04:35:28', NULL),
(220, 49, 'logout', 'User logged out', '2024-07-09 05:21:08', NULL),
(221, 49, 'login', 'User logged in', '2024-07-09 05:21:16', NULL),
(222, 49, 'logout', 'User logged out', '2024-07-09 05:24:56', NULL),
(223, 49, 'login', 'User logged in', '2024-07-09 05:28:18', NULL),
(224, 49, 'logout', 'User logged out', '2024-07-09 05:29:29', NULL),
(225, 49, 'login', 'User logged in', '2024-07-09 05:29:34', NULL),
(226, 49, 'login', 'User logged in', '2024-07-09 05:30:34', NULL),
(227, 49, 'login', 'User logged in', '2024-07-09 05:36:50', NULL),
(228, 49, 'logout', 'User logged out', '2024-07-09 05:36:53', NULL),
(229, 49, 'login', 'User logged in', '2024-07-09 05:37:15', NULL),
(230, 49, 'logout', 'User logged out', '2024-07-09 05:39:55', NULL),
(231, 49, 'login', 'User logged in', '2024-07-09 05:40:18', NULL),
(232, 49, 'logout', 'User logged out', '2024-07-09 05:40:27', NULL),
(233, 49, 'login', 'User logged in', '2024-07-09 05:43:49', NULL),
(234, 49, 'logout', 'User logged out', '2024-07-09 05:45:52', NULL),
(235, 49, 'login', 'User logged in', '2024-07-09 05:48:22', NULL),
(236, 49, 'login', 'User logged in', '2024-07-09 06:06:14', NULL),
(237, 49, 'logout', 'User logged out', '2024-07-09 07:48:27', NULL),
(238, 49, 'login', 'User logged in', '2024-07-09 07:48:33', NULL),
(239, 49, 'login', 'User logged in', '2024-07-09 08:43:16', NULL),
(240, 49, 'logout', 'User logged out', '2024-07-09 09:15:32', NULL),
(241, 49, 'login', 'User logged in', '2024-07-09 10:51:05', NULL),
(242, 49, 'logout', 'User logged out', '2024-07-09 10:51:10', NULL),
(243, 49, 'login', 'User logged in', '2024-07-09 10:51:14', NULL),
(244, 49, 'login', 'User logged in', '2024-07-09 10:51:34', NULL),
(245, 49, 'logout', 'User logged out', '2024-07-09 10:53:03', NULL),
(246, 49, 'login', 'User logged in', '2024-07-09 10:53:13', NULL),
(247, 49, 'login', 'User logged in', '2024-07-09 10:53:37', NULL),
(248, 49, 'login', 'User logged in', '2024-07-09 10:54:11', NULL),
(249, 49, 'login', 'User logged in', '2024-07-09 10:54:29', NULL),
(250, 49, 'logout', 'User logged out', '2024-07-09 10:54:41', NULL),
(251, 49, 'login', 'User logged in', '2024-07-09 10:54:50', NULL),
(252, 49, 'login', 'User logged in', '2024-07-09 10:56:02', NULL),
(253, 49, 'logout', 'User logged out', '2024-07-09 10:56:26', NULL),
(254, 49, 'login', 'User logged in', '2024-07-09 11:24:39', NULL),
(255, 49, 'logout', 'User logged out', '2024-07-09 11:28:35', NULL),
(256, 49, 'login', 'User logged in', '2024-07-09 11:28:44', NULL),
(257, 49, 'login', 'User logged in', '2024-07-09 13:54:53', NULL),
(258, 49, 'login', 'User logged in', '2024-07-09 13:55:29', NULL),
(259, 49, 'login', 'User logged in', '2024-07-09 14:52:31', NULL),
(260, 49, 'login', 'User logged in', '2024-07-09 15:02:24', NULL),
(261, 49, 'logout', 'User logged out', '2024-07-09 16:02:16', NULL),
(262, 49, 'login', 'User logged in', '2024-07-09 16:02:23', NULL),
(263, 49, 'login', 'User logged in', '2024-07-10 01:04:52', NULL),
(264, 49, 'login', 'User logged in', '2024-07-10 01:05:54', NULL),
(265, 49, 'logout', 'User logged out', '2024-07-10 01:10:17', NULL),
(266, 49, 'login', 'User logged in', '2024-07-10 01:11:08', NULL),
(267, 49, 'logout', 'User logged out', '2024-07-10 01:14:50', NULL),
(268, 49, 'login', 'User logged in', '2024-07-10 01:15:10', NULL),
(269, 49, 'logout', 'User logged out', '2024-07-10 01:44:07', NULL),
(270, 49, 'login', 'User logged in', '2024-07-10 01:46:54', NULL),
(271, 49, 'login', 'User logged in', '2024-07-11 02:14:48', NULL),
(272, 49, 'login', 'User logged in', '2024-07-15 08:43:25', NULL),
(273, 49, 'login', 'User logged in', '2024-07-15 09:41:08', NULL),
(274, 49, 'logout', 'User logged out', '2024-07-15 11:53:52', NULL),
(275, 49, 'login', 'User logged in', '2024-07-15 11:59:30', NULL),
(276, 49, 'logout', 'User logged out', '2024-07-15 12:02:13', NULL),
(277, 49, 'login', 'User logged in', '2024-07-15 12:03:12', NULL),
(278, 49, 'logout', 'User logged out', '2024-07-15 12:07:01', NULL),
(279, 49, 'login', 'User logged in', '2024-07-15 12:07:59', NULL),
(280, 49, 'logout', 'User logged out', '2024-07-15 12:10:31', NULL),
(281, 49, 'login', 'User logged in', '2024-07-15 12:14:09', NULL),
(282, 49, 'logout', 'User logged out', '2024-07-15 12:14:56', NULL),
(283, 49, 'login', 'User logged in', '2024-07-15 12:15:12', NULL),
(284, 49, 'logout', 'User logged out', '2024-07-15 12:28:13', NULL),
(285, 49, 'login', 'User logged in', '2024-07-15 12:28:27', NULL),
(286, 49, 'login', 'User logged in', '2024-07-16 13:37:59', NULL),
(287, 49, 'login', 'User logged in', '2024-07-17 01:09:33', NULL),
(288, 49, 'login', 'User logged in', '2024-07-17 01:09:38', NULL),
(289, 49, 'logout', 'User logged out', '2024-07-17 02:27:24', NULL),
(290, 49, 'login', 'User logged in', '2024-07-17 02:28:55', NULL),
(291, 49, 'login', 'User logged in', '2024-07-17 17:01:32', NULL),
(292, 49, 'login', 'User logged in', '2024-07-18 02:24:28', NULL),
(293, 49, 'login', 'User logged in', '2024-07-18 07:36:08', NULL),
(294, 49, 'login', 'User logged in', '2024-07-20 05:29:04', NULL),
(295, 49, 'login', 'User logged in', '2024-07-20 09:12:25', NULL),
(296, 49, 'login', 'User logged in', '2024-07-21 10:40:46', NULL),
(297, 49, 'login', 'User logged in', '2024-07-21 11:27:35', NULL),
(298, 49, 'login', 'User logged in', '2024-07-21 14:43:31', NULL),
(299, 49, 'login', 'User logged in', '2024-07-22 01:12:31', NULL),
(300, 49, 'login', 'User logged in', '2024-07-23 00:45:02', NULL),
(301, 49, 'login', 'User logged in', '2024-07-23 01:48:30', NULL),
(302, 49, 'login', 'User logged in', '2024-07-24 03:49:44', NULL),
(303, 49, 'login', 'User logged in', '2024-07-25 06:09:02', NULL),
(304, 49, 'login', 'User logged in', '2024-07-25 11:56:58', NULL),
(305, 49, 'login', 'User logged in', '2024-07-25 14:45:19', NULL),
(306, 49, 'logout', 'User logged out', '2024-07-25 14:51:28', NULL),
(307, 49, 'login', 'User logged in', '2024-07-25 14:51:30', NULL),
(308, 49, 'logout', 'User logged out', '2024-07-25 20:07:36', NULL),
(309, 49, 'login', 'User logged in', '2024-07-25 20:07:38', NULL),
(310, 49, 'logout', 'User logged out', '2024-07-25 20:08:03', NULL),
(311, 49, 'login', 'User logged in', '2024-07-25 20:08:06', NULL),
(312, 49, 'logout', 'User logged out', '2024-07-25 20:09:06', NULL),
(313, 49, 'login', 'User logged in', '2024-07-25 20:09:09', NULL),
(314, 49, 'login', 'User logged in', '2024-07-25 20:10:10', NULL),
(315, 49, 'login', 'User logged in', '2024-07-25 20:16:19', NULL),
(316, 49, 'logout', 'User logged out', '2024-07-25 20:16:22', NULL),
(317, 49, 'login', 'User logged in', '2024-07-25 20:17:51', NULL),
(318, 49, 'Add', 'Added new record to vehicle_unit: {\"veh_id\":9,\"plate_no\":\"dasdsd\",\"case_id\":\"1\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"1\",\"group_id\":\"1\",\"cr_no\":\"asd\",\"engine_no\":\"sadsad\",\"chassis_no\":\"sadasd\"}', '2024-07-25 20:18:49', NULL),
(319, 49, 'login', 'User logged in', '2024-07-26 02:10:50', NULL),
(320, 49, 'Edit', 'Edited record in vehicle_unit. Old values: null; New values: {\"plate_no\":\"GHG-4758\",\"case_id\":\"2\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"1\",\"group_id\":\"1\",\"cr_no\":\"SDAS\",\"engine_no\":\"DSADASDSA\",\"chassis_no\":\"DASASDS\"}', '2024-07-26 04:24:39', NULL),
(321, 49, 'logout', 'User logged out', '2024-07-26 04:44:56', NULL),
(322, 49, 'login', 'User logged in', '2024-07-26 04:45:56', NULL),
(323, 49, 'login', 'User logged in', '2024-07-26 04:46:19', NULL),
(324, 49, 'Add', 'Added new record to vehicle_unit: {\"veh_id\":10,\"plate_no\":\"AVB-0987\",\"case_id\":\"2\",\"vtype_id\":\"3\",\"optr_id\":\"1\",\"terminal_id\":\"3\",\"group_id\":\"2\",\"cr_no\":\"asdas\",\"engine_no\":\"dasdasd\",\"chassis_no\":\"sadasd\"}', '2024-07-26 04:48:38', NULL),
(325, 49, 'Edit', 'Edited record in vehicle_unit. Old values: null; New values: {\"plate_no\":\"AVB-0981\",\"case_id\":\"2\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"1\",\"group_id\":\"1\",\"cr_no\":\"asdas\",\"engine_no\":\"dasdasd\",\"chassis_no\":\"sadasd\"}', '2024-07-26 04:49:56', NULL),
(326, 49, 'Edit', 'Edited record in vehicle_unit. Old values: null; New values: {\"plate_no\":\"AVB-0981\",\"case_id\":\"2\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"1\",\"group_id\":\"1\",\"cr_no\":\"asdas\",\"engine_no\":\"dasdasd\",\"chassis_no\":\"sadasd\"}', '2024-07-26 04:51:42', NULL),
(327, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":10,\"veh_id\":\"V2024-00006\",\"case_id\":2,\"vtype_id\":3,\"optr_id\":1,\"terminal_id\":3,\"group_id\":2,\"plate_no\":\"AVB-0987\",\"cr_no\":\"asdas\",\"engine_no\":\"dasdasd\",\"chassis_no\":\"sadasd\",\"created_at\":\"2024-07-26 12:48:38\"}; New values: {\"plate_no\":\"AVB-0981\",\"case_id\":\"2\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"1\",\"group_id\":\"1\",\"cr_no\":\"asdas\",\"engine_no\":\"dasdasd\",\"chassis_no\":\"sadasd\"}', '2024-07-26 04:58:14', NULL),
(328, 49, 'Add', 'Added new record to vehicle_unit: {\"veh_id\":11,\"plate_no\":\"CAR-1234\",\"case_id\":\"2\",\"vtype_id\":\"2\",\"optr_id\":\"3\",\"terminal_id\":\"3\",\"group_id\":\"1\",\"cr_no\":\"asd\",\"engine_no\":\"asdasdas\",\"chassis_no\":\"asdasda\"}', '2024-07-26 04:58:59', NULL),
(329, 49, 'Delete', 'Deleted record from vehicle_unit: null', '2024-07-26 05:03:57', NULL),
(330, 49, 'Delete', 'Deleted record from vehicle_unit: {\"id\":10,\"veh_id\":\"V2024-00006\",\"case_id\":2,\"vtype_id\":1,\"optr_id\":1,\"terminal_id\":1,\"group_id\":1,\"plate_no\":\"AVB-0981\",\"cr_no\":\"asdas\",\"engine_no\":\"dasdasd\",\"chassis_no\":\"sadasd\",\"created_at\":\"2024-07-26 12:58:14\"}', '2024-07-26 05:10:25', NULL),
(331, 49, 'Add', 'Added new record to vehicle_unit: {\"veh_id\":12,\"plate_no\":\"das\",\"case_id\":\"1\",\"vtype_id\":\"2\",\"optr_id\":\"1\",\"terminal_id\":\"1\",\"group_id\":\"1\",\"cr_no\":\"asdas\",\"engine_no\":\"dasdas\",\"chassis_no\":\"dasdas\"}', '2024-07-26 05:11:56', NULL),
(332, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":12,\"veh_id\":\"V2024-00006\",\"case_id\":1,\"vtype_id\":2,\"optr_id\":1,\"terminal_id\":1,\"group_id\":1,\"plate_no\":\"das\",\"cr_no\":\"asdas\",\"engine_no\":\"dasdas\",\"chassis_no\":\"dasdas\",\"created_at\":\"2024-07-26 13:11:56\"}; New values: {\"plate_no\":\"das\",\"case_id\":\"1\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"1\",\"group_id\":\"1\",\"cr_no\":\"asdas\",\"engine_no\":\"dasdas\",\"chassis_no\":\"dasdas\"}', '2024-07-26 05:12:06', NULL),
(333, 49, 'Delete', 'Deleted record from vehicle_unit: {\"id\":12,\"veh_id\":\"V2024-00006\",\"case_id\":1,\"vtype_id\":1,\"optr_id\":1,\"terminal_id\":1,\"group_id\":1,\"plate_no\":\"das\",\"cr_no\":\"asdas\",\"engine_no\":\"dasdas\",\"chassis_no\":\"dasdas\",\"created_at\":\"2024-07-26 13:12:06\"}', '2024-07-26 05:12:33', NULL),
(334, 49, 'Add', 'Added new record to operator: {\"optr_id\":\"OPR2024-0004\",\"resi_id\":\"1\",\"optr_name\":\"asd\",\"optr_add\":\"asdsa\",\"optr_contact\":\"asdasd\"}', '2024-07-26 05:14:41', NULL),
(335, 49, 'Edit', 'Edited record in operator. Old values: {\"id\":11,\"optr_id\":\"OPR2024-0004\",\"resi_id\":1,\"optr_name\":\"asd\",\"optr_add\":\"asdsa\",\"optr_contact\":\"asdasd\"}; New values: {\"optr_id\":\"OPR2024-0004\",\"resi_id\":\"2\",\"optr_name\":\"asd\",\"optr_add\":\"asdsa\",\"optr_contact\":\"asdasd\"}', '2024-07-26 05:15:13', NULL),
(336, 49, 'Delete', 'Deleted record from operator: {\"id\":11,\"optr_id\":\"OPR2024-0004\",\"resi_id\":2,\"optr_name\":\"asd\",\"optr_add\":\"asdsa\",\"optr_contact\":\"asdasd\"}', '2024-07-26 05:15:31', NULL),
(337, 49, 'Add', 'Added new record to driver: {\"driver_id\":\"DRV-2024-0005\",\"resi_id\":\"1\",\"driver_name\":\"asdas\",\"driver_address\":\"dasdas\",\"driver_contact\":\"sadasdas\"}', '2024-07-26 05:16:05', NULL),
(338, 49, 'Edit', 'Edited record in driver. Old values: {\"id\":6,\"driver_id\":\"DRV-2024-0005\",\"driver_name\":\"asdas\",\"driver_address\":\"dasdas\",\"driver_contact\":\"sadasdas\",\"resi_id\":1,\"created_at\":\"2024-07-26 13:16:05\",\"updated_at\":\"2024-07-26 13:16:05\"}; New values: {\"driver_id\":\"DRV-2024-0005\",\"resi_id\":\"2\",\"driver_name\":\"asdas\",\"driver_address\":\"dasdas\",\"driver_contact\":\"sadasdas\"}', '2024-07-26 05:16:16', NULL),
(339, 49, 'Delete', 'Deleted record from driver: {\"id\":6,\"driver_id\":\"DRV-2024-0005\",\"driver_name\":\"asdas\",\"driver_address\":\"dasdas\",\"driver_contact\":\"sadasdas\",\"resi_id\":2,\"created_at\":\"2024-07-26 13:16:05\",\"updated_at\":\"2024-07-26 13:16:16\"}', '2024-07-26 05:16:30', NULL),
(340, 49, 'Add', 'Added new record to trans_group: {\"group_id\":\"GRP-2024-003\",\"group_pres\":null,\"group_name\":\"PH\"}', '2024-07-26 05:21:08', NULL),
(341, 49, 'Add', 'Added new record to group_officers: \"BBM\"', '2024-07-26 05:21:08', NULL),
(342, 49, 'Add', 'Added new record to group_officers: \"Sara\"', '2024-07-26 05:21:08', NULL),
(343, 49, 'Delete', 'Deleted record from trans_group: {\"id\":4,\"group_id\":\"GRP-2024-003\",\"group_name\":\"PH\"}', '2024-07-26 05:21:22', NULL),
(344, 49, 'Add', 'Added new record to trans_group: {\"group_id\":\"GRP-2024-003\",\"group_name\":\"asdasdass\"}', '2024-07-26 05:21:39', NULL),
(345, 49, 'Add', 'Added new record to group_officers: \"BBM\"', '2024-07-26 05:21:39', NULL),
(346, 49, 'Add', 'Added new record to group_officers: \"Sara\"', '2024-07-26 05:21:39', NULL),
(347, 49, 'Delete', 'Deleted record from trans_group: {\"id\":5,\"group_id\":\"GRP-2024-003\",\"group_name\":\"asdasdass\"}', '2024-07-26 05:24:19', NULL),
(348, 49, 'Add', 'Added new record to trans_group: {\"group_id\":\"GRP-2024-003\",\"group_name\":\"asdasdas\"}', '2024-07-26 05:24:27', NULL),
(349, 49, 'Add', 'Added new record to group_officers: \"Asdasd\"', '2024-07-26 05:24:27', NULL),
(350, 49, 'Add', 'Added new record to group_officers: \"asdasdasd\"', '2024-07-26 05:24:27', NULL),
(351, 49, 'Delete', 'Deleted record from trans_group: {\"id\":6,\"group_id\":\"GRP-2024-003\",\"group_name\":\"asdasdas\"}', '2024-07-26 05:28:33', NULL),
(352, 49, 'Add', 'Added new record to trans_group: {\"group_id\":\"GRP-2024-003\",\"group_name\":\"asdasda\"}', '2024-07-26 05:28:41', NULL),
(353, 49, 'Add', 'Added new record to group_officers: {\"group_id\":7,\"officer_position\":\"Pres\",\"officer_name\":\"dasda\"}', '2024-07-26 05:28:41', NULL),
(354, 49, 'Add', 'Added new record to group_officers: {\"group_id\":7,\"officer_position\":\"VP\",\"officer_name\":\"adsadasdas\"}', '2024-07-26 05:28:41', NULL),
(355, 49, 'Edit', 'Edited record in trans_group. Old values: {\"id\":7,\"group_id\":\"GRP-2024-003\",\"group_name\":\"asdasda\"}; New values: {\"group_id\":\"GRP-2024-003\",\"group_name\":\"asdasda\"}', '2024-07-26 05:35:05', NULL),
(356, 49, 'Add', 'Added new record to group_officers: {\"group_id\":\"7\",\"officer_position\":\"Pres\",\"officer_name\":\"BBM\"}', '2024-07-26 05:35:05', NULL),
(357, 49, 'Add', 'Added new record to group_officers: {\"group_id\":\"7\",\"officer_position\":\"VP\",\"officer_name\":\"Sara\"}', '2024-07-26 05:35:05', NULL),
(358, 49, 'Edit', 'Edited record in trans_group. Old values: {\"id\":7,\"group_id\":\"GRP-2024-003\",\"group_name\":\"asdasda\"}; New values: {\"group_id\":\"GRP-2024-003\",\"group_name\":\"Ankol\"}', '2024-07-26 05:36:04', NULL),
(359, 49, 'Edit', 'Edited record in trans_group. Old values: {\"id\":7,\"group_id\":\"GRP-2024-003\",\"group_name\":\"Ankol\"}; New values: {\"group_id\":\"GRP-2024-003\",\"group_name\":\"Ankol\"}', '2024-07-26 05:36:36', NULL),
(360, 49, 'Add', 'Added new record to group_officers: {\"group_id\":\"7\",\"officer_position\":\"Pres\",\"officer_name\":\"BBM\"}', '2024-07-26 05:36:36', NULL),
(361, 49, 'Add', 'Added new record to group_officers: {\"group_id\":\"7\",\"officer_position\":\"VP\",\"officer_name\":\"Sara\"}', '2024-07-26 05:36:36', NULL),
(362, 49, 'Delete', 'Deleted record from trans_group: {\"id\":7,\"group_id\":\"GRP-2024-003\",\"group_name\":\"Ankol\"}', '2024-07-26 05:36:52', NULL),
(363, 49, 'Add', 'Added new record to terminal: {\"terminal_id\":\"T0003\",\"terminal_name\":\"asdasdasd\",\"terminal_add\":\"asdasd\",\"route_id\":\"5\",\"insp_id\":\"1\",\"reso_id\":\"2\",\"group_id\":\"2\",\"busi_permit\":\"asdasdas\",\"busi_date\":\"2024-07-01\",\"busi_expire\":\"2024-07-31\"}', '2024-07-26 05:38:51', NULL),
(364, 49, 'Edit', 'Edited record in terminal. Old values: {\"id\":6,\"terminal_id\":\"T0003\",\"terminal_name\":\"asdasdasd\",\"terminal_add\":\"asdasd\",\"route_id\":5,\"insp_id\":1,\"reso_id\":2,\"group_id\":2,\"busi_permit\":\"asdasdas\",\"busi_date\":\"2024-07-01\",\"busi_expire\":\"2024-07-31\",\"date\":\"2024-07-26 13:38:51\"}; New values: {\"terminal_id\":\"T0003\",\"terminal_name\":\"as\",\"terminal_add\":\"asdasd\",\"route_id\":\"5\",\"insp_id\":\"1\",\"reso_id\":\"2\",\"group_id\":\"2\",\"busi_permit\":\"asdasdas\",\"busi_date\":\"2024-07-01\",\"busi_expire\":\"2024-07-31\"}', '2024-07-26 05:39:16', NULL),
(365, 49, 'Delete', 'Deleted record from terminal: {\"id\":6,\"terminal_id\":\"T0003\",\"terminal_name\":\"as\",\"terminal_add\":\"asdasd\",\"route_id\":5,\"insp_id\":1,\"reso_id\":2,\"group_id\":2,\"busi_permit\":\"asdasdas\",\"busi_date\":\"2024-07-01\",\"busi_expire\":\"2024-07-31\",\"date\":\"2024-07-26 13:39:16\"}', '2024-07-26 05:39:49', NULL),
(366, 49, 'Add', 'Added new record to route: {\"route_id\":\"R2024-00001\",\"route_line\":\"asd\",\"route_struct\":\"asdasdasda\"}', '2024-07-26 05:40:19', NULL),
(367, 49, 'Edit', 'Edited record in route. Old values: {\"id\":7,\"route_id\":\"R2024-00001\",\"route_struct\":\"asdasdasda\",\"route_line\":\"asd\",\"route_modify\":null,\"date\":\"2024-07-26 13:40:19\"}; New values: {\"route_id\":\"R2024-00001\",\"route_line\":\"a\",\"route_struct\":\"asdasdasda\"}', '2024-07-26 05:40:28', NULL),
(368, 49, 'Add', 'Added new record to route: {\"route_id\":\"R2024-00001\",\"route_line\":\"asd\",\"route_struct\":\"asdsadasdas\"}', '2024-07-26 05:41:53', NULL),
(369, 49, 'Add', 'Added new record to route: {\"route_id\":\"R2024-00001\",\"route_line\":\"asd\",\"route_struct\":\"asdasdasdas\"}', '2024-07-26 05:42:36', NULL),
(370, 49, 'Delete', 'Deleted record from route: {\"id\":9,\"route_id\":\"R2024-00001\",\"route_struct\":\"asdasdasdas\",\"route_line\":\"asd\",\"route_modify\":null,\"date\":\"2024-07-26 13:42:36\"}', '2024-07-26 05:42:38', NULL),
(371, 49, 'Add', 'Added new record to users: {\"name\":\"asdsa\",\"username\":\"dasdasdas\",\"email\":\"docotkat@gmail.com\",\"role\":\"1\",\"picture\":\"\",\"verification_code\":\"8201a15dec\",\"status\":\"inactive\"}', '2024-07-26 05:44:22', NULL),
(372, 49, 'Edit', 'Edited record in users. Old values: {\"userid\":103,\"name\":\"asd\",\"username\":\"adadas\",\"password\":\"$2y$10$QojFXOT43L5LHToe4ks76.QiYLJvWNTzP1QBMIssdIhGjrVGQenOy\",\"email\":\"docotkat@gmail.com\",\"role\":1,\"picture\":\"\",\"verification_code\":\"042f37beee\",\"status\":\"activated\",\"reset_code\":null,\"last_code_sent_at\":null,\"remember_token\":null}; New values: {\"name\":\"a\",\"username\":\"adadas\",\"email\":\"docotkat@gmail.com\",\"role\":\"1\",\"picture\":\"\"}', '2024-07-26 05:45:32', NULL),
(373, 49, 'Delete', 'Deleted record from users: {\"userid\":103,\"name\":\"a\",\"username\":\"adadas\",\"password\":\"$2y$10$QojFXOT43L5LHToe4ks76.QiYLJvWNTzP1QBMIssdIhGjrVGQenOy\",\"email\":\"docotkat@gmail.com\",\"role\":1,\"picture\":\"\",\"verification_code\":\"042f37beee\",\"status\":\"activated\",\"reset_code\":null,\"last_code_sent_at\":null,\"remember_token\":null}', '2024-07-26 05:45:43', NULL),
(374, 49, 'Add', 'Added new record to users: {\"name\":\"asd\",\"username\":\"sadasd\",\"email\":\"docs1502@gmail.com\",\"role\":\"2\",\"picture\":\"\",\"verification_code\":\"dfc8cfac44\",\"status\":\"inactive\"}', '2024-07-26 05:47:05', NULL),
(375, 49, 'Delete', 'Deleted record from users: {\"userid\":105,\"name\":\"asd\",\"username\":\"sadasd\",\"password\":\"$2y$10$XrhyKwQcdjsgNDwpXlYl7OnqaEG83YzdkV0BrOiL8PM0O2IMgothi\",\"email\":\"docs1502@gmail.com\",\"role\":2,\"picture\":\"\",\"verification_code\":\"dfc8cfac44\",\"status\":\"inactive\",\"reset_code\":null,\"last_code_sent_at\":null,\"remember_token\":null}', '2024-07-26 05:48:25', NULL),
(376, 49, 'Edit', 'Edited record in role_permissions. Old values: [7,8,9,1]; New values: [\"7\",\"8\",\"9\"]', '2024-07-26 05:49:17', NULL),
(377, 49, 'Edit', 'Edited record in role_permissions. Old values: [1,2,3,4,5,6,7,8,9,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38]; New values: [\"1\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\"]', '2024-07-26 05:49:25', NULL),
(378, 49, 'Edit', 'Edited record in role_permissions. Old values: [1,4,5,6,7,8,9,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38]; New values: [\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\"]', '2024-07-26 05:49:30', NULL),
(379, 49, 'Edit', 'Edited record in users. Old values: {\"userid\":49,\"name\":\"Angeli Khang\",\"username\":\"angeli\",\"password\":\"$2y$10$n9lsl\\/gEw.UUYx7rEE9Pde5g0nLrCz1cTWAig\\/\\/7m\\/vpjCcm7CHci\",\"email\":\"jerry.obico@gmail.com\",\"role\":1,\"picture\":\"uploads\\/angeli.jpg\",\"verification_code\":\"853592\",\"status\":\"activated\",\"reset_code\":null,\"last_code_sent_at\":null,\"remember_token\":\"02def14b117c367dd2bd470d79be46f56c8cede6d89430abb88efa99f4e6a2e4\"}; New values: {\"name\":\"Angeli Khangs\",\"username\":\"angeli\",\"email\":\"jerry.obico@gmail.com\",\"picture\":\"\"}', '2024-07-26 06:08:20', NULL),
(380, 49, 'Edit', 'Edited record in users. Old values: {\"userid\":49,\"name\":\"Angeli Khangs\",\"username\":\"angeli\",\"password\":\"$2y$10$n9lsl\\/gEw.UUYx7rEE9Pde5g0nLrCz1cTWAig\\/\\/7m\\/vpjCcm7CHci\",\"email\":\"jerry.obico@gmail.com\",\"role\":1,\"picture\":\"uploads\\/angeli.jpg\",\"verification_code\":\"853592\",\"status\":\"activated\",\"reset_code\":null,\"last_code_sent_at\":null,\"remember_token\":\"02def14b117c367dd2bd470d79be46f56c8cede6d89430abb88efa99f4e6a2e4\"}; New values: {\"name\":\"Angeli Khang\",\"username\":\"angeli\",\"email\":\"jerry.obico@gmail.com\",\"picture\":\"\"}', '2024-07-26 06:08:25', NULL),
(381, 49, 'Logout', 'User logged out', '2024-07-26 06:21:34', NULL),
(382, 104, 'Login', 'User logged in', '2024-07-26 06:53:59', NULL),
(383, 104, 'Logout', 'User logged out', '2024-07-26 06:54:13', NULL),
(384, 49, 'Login', 'User logged in', '2024-07-26 06:54:17', NULL),
(385, 112, 'Login', 'User logged in', '2024-07-26 07:39:54', NULL),
(386, 49, 'Login', 'User logged in', '2024-07-26 17:14:25', NULL),
(387, 49, 'Login', 'User logged in', '2024-07-27 03:03:27', NULL),
(388, 49, 'Logout', 'User logged out', '2024-07-27 06:06:57', NULL),
(389, 49, 'Login', 'User logged in', '2024-07-27 06:07:00', NULL),
(390, 49, 'Logout', 'User logged out', '2024-07-27 06:13:38', NULL),
(391, 49, 'Login', 'User logged in', '2024-07-27 06:13:51', NULL),
(392, 49, 'Add', 'Added new record to operator: {\"optr_id\":\"OPR2024-0004\",\"resi_id\":\"2\",\"optr_name\":\"asdas\",\"optr_add\":\"sada\",\"optr_contact\":\"dasdasd\"}', '2024-07-27 06:30:32', NULL),
(393, 49, 'Delete', 'Deleted record from operator: {\"id\":12,\"optr_id\":\"OPR2024-0004\",\"resi_id\":2,\"optr_name\":\"asdas\",\"optr_add\":\"sada\",\"optr_contact\":\"dasdasd\"}', '2024-07-27 06:30:39', NULL),
(394, 49, 'Logout', 'User logged out', '2024-07-27 06:38:27', NULL),
(395, 49, 'Login', 'User logged in', '2024-07-27 08:00:01', NULL),
(396, 49, 'Login', 'User logged in', '2024-07-28 02:05:20', NULL),
(397, 49, 'Login', 'User logged in', '2024-07-28 05:16:05', NULL),
(398, 49, 'Edit', 'Edited record in role_permissions. Old values: [1,2,3,4,5,6,7,8,9,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38]; New values: [\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"10\",\"11\",\"12\",\"13\",\"14\",\"15\",\"16\",\"17\",\"18\",\"19\",\"20\",\"21\",\"22\",\"23\",\"24\",\"25\",\"26\",\"27\",\"28\",\"29\",\"30\",\"31\",\"32\",\"33\",\"34\",\"35\",\"36\",\"37\",\"38\"]', '2024-07-28 06:16:45', NULL),
(399, 49, 'Edit', 'Edited record in role_permissions. Old values: [9]; New values: [\"1\",\"2\",\"3\",\"9\"]', '2024-07-28 06:40:40', NULL),
(400, 49, 'Edit', 'Edited record in users. Old values: {\"userid\":112,\"name\":\"adsad\",\"username\":\"sam\",\"password\":\"$2y$10$\\/pZnD2y8KQblRajh2agc4OB0QLTm6ijamDgp4z.EKjYE67CcArav.\",\"email\":\"docs1502@gmail.com\",\"role\":3,\"picture\":null,\"verification_code\":\"163698\",\"status\":\"activated\",\"reset_code\":null,\"last_code_sent_at\":null,\"remember_token\":null}; New values: {\"name\":\"adsad\",\"username\":\"sam\",\"email\":\"docs1502@gmail.com\",\"role\":\"2\",\"picture\":\"\"}', '2024-07-28 06:40:50', NULL),
(401, 49, 'Logout', 'User logged out', '2024-07-28 06:40:54', NULL),
(402, 112, 'Login', 'User logged in', '2024-07-28 06:41:02', NULL),
(403, 112, 'Logout', 'User logged out', '2024-07-28 06:58:40', NULL),
(404, 49, 'Login', 'User logged in', '2024-07-28 06:58:42', NULL),
(405, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":4,\"veh_id\":\"V2024-00004\",\"case_id\":2,\"vtype_id\":1,\"optr_id\":1,\"terminal_id\":1,\"group_id\":1,\"plate_no\":\"GHG-4758\",\"cr_no\":\"SDAS\",\"engine_no\":\"DSADASDSA\",\"chassis_no\":\"DASASDS\",\"created_at\":\"2024-07-26 10:09:57\"}; New values: {\"plate_no\":\"GHG-4758\",\"case_id\":\"2\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"3\",\"group_id\":\"1\",\"cr_no\":\"SDAS\",\"engine_no\":\"DSADASDSA\",\"chassis_no\":\"DASASDS\"}', '2024-07-28 10:54:49', NULL),
(406, 49, 'Add', 'Added new record to vehicle_unit: {\"veh_id\":13,\"plate_no\":\"dasdsadsa\",\"case_id\":\"1\",\"vtype_id\":\"2\",\"optr_id\":\"2\",\"terminal_id\":\"1\",\"group_id\":\"1\",\"cr_no\":\"asds\",\"engine_no\":\"adadsa\",\"chassis_no\":\"asdasdasda\"}', '2024-07-28 10:58:29', NULL),
(407, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":6,\"veh_id\":\"V2024-00005\",\"case_id\":2,\"vtype_id\":1,\"optr_id\":1,\"terminal_id\":1,\"group_id\":1,\"plate_no\":\"PSG-1234\",\"cr_no\":\"asdas\",\"engine_no\":\"dasdasda\",\"chassis_no\":\"sdasdas\",\"created_at\":\"2024-07-26 10:09:57\"}; New values: {\"plate_no\":\"PSG-1234\",\"case_id\":\"2\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"1\",\"group_id\":\"1\",\"cr_no\":\"asdas\",\"engine_no\":\"dasdasda\",\"chassis_no\":\"sdasdas\"}', '2024-07-28 11:06:39', NULL),
(408, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":6,\"veh_id\":\"V2024-00005\",\"case_id\":2,\"vtype_id\":1,\"optr_id\":1,\"terminal_id\":1,\"group_id\":1,\"plate_no\":\"PSG-1234\",\"cr_no\":\"asdas\",\"engine_no\":\"dasdasda\",\"chassis_no\":\"sdasdas\",\"created_at\":\"2024-07-26 10:09:57\"}; New values: {\"plate_no\":\"PSG-1234\",\"case_id\":\"2\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"1\",\"group_id\":\"1\",\"cr_no\":\"asdas\",\"engine_no\":\"dasdasda\",\"chassis_no\":\"sdasdas\"}', '2024-07-28 11:07:55', NULL),
(409, 49, 'Login', 'User logged in', '2024-07-28 14:36:48', NULL),
(410, 49, 'Logout', 'User logged out', '2024-07-28 14:56:55', NULL),
(411, 37, 'Login', 'User logged in', '2024-07-28 14:57:19', NULL),
(412, 37, 'Logout', 'User logged out', '2024-07-28 14:58:06', NULL),
(413, 50, 'Login', 'User logged in', '2024-07-28 14:58:18', NULL),
(414, 50, 'Logout', 'User logged out', '2024-07-28 14:58:55', NULL),
(415, 49, 'Login', 'User logged in', '2024-07-28 14:59:04', NULL),
(416, 49, 'Logout', 'User logged out', '2024-07-28 15:23:50', NULL),
(417, 49, 'Login', 'User logged in', '2024-07-28 23:47:55', NULL),
(418, 49, 'Edit', 'Edited record in route. Old values: {\"id\":1,\"route_id\":\"R2023-00001\",\"route_struct\":\"Ugong Terminal - Pasig via Pasig Market Terminal\",\"route_line\":\"Pasig Market - Ugong\",\"route_modify\":\"\",\"date\":\"2023-12-09 14:45:18\"}; New values: {\"route_id\":\"R2023-00001\",\"route_line\":\"Pasig Market via Ugong\",\"route_struct\":\"Ugong Terminal - Pasig via Pasig Market Terminal\"}', '2024-07-28 23:49:37', NULL),
(419, 49, 'Edit', 'Edited record in route. Old values: {\"id\":2,\"route_id\":\"R2023-00002\",\"route_struct\":\"Quiapo - Pasig via Pasig Market Terminal\",\"route_line\":\"Pasig Market - Quiapo\\t\\t\",\"route_modify\":\"\",\"date\":\"2023-12-09 14:46:18\"}; New values: {\"route_id\":\"R2023-00002\",\"route_line\":\"Pasig Market via Quiapo\\t\\t\",\"route_struct\":\"Quiapo - Pasig via Pasig Market Terminal\"}', '2024-07-28 23:49:46', NULL),
(420, 49, 'Edit', 'Edited record in route. Old values: {\"id\":3,\"route_id\":\"R2023-00003\",\"route_struct\":\"Taguig - Pasig via Pasig Market Terminal\",\"route_line\":\"Pasig Market - Taguig\",\"route_modify\":\"\",\"date\":\"2023-12-09 14:46:53\"}; New values: {\"route_id\":\"R2023-00003\",\"route_line\":\"Pasig Market via Taguig\",\"route_struct\":\"Taguig - Pasig via Pasig Market Terminal\"}', '2024-07-28 23:49:56', NULL),
(421, 49, 'Edit', 'Edited record in route. Old values: {\"id\":4,\"route_id\":\"R2023-00004\",\"route_struct\":\"Pasig-Quiapo\",\"route_line\":\"Quiapo - Pasig Market \",\"route_modify\":\"\",\"date\":\"2023-12-09 14:47:04\"}; New values: {\"route_id\":\"R2023-00004\",\"route_line\":\"Quiapo via Pasig Market \",\"route_struct\":\"Pasig-Quiapo\"}', '2024-07-28 23:50:09', NULL),
(422, 49, 'Edit', 'Edited record in route. Old values: {\"id\":4,\"route_id\":\"R2023-00004\",\"route_struct\":\"Pasig-Quiapo\",\"route_line\":\"Quiapo via Pasig Market \",\"route_modify\":\"\",\"date\":\"2023-12-09 14:47:04\"}; New values: {\"route_id\":\"R2023-00004\",\"route_line\":\"Quiapo via Pasig Market \",\"route_struct\":\"Pasig Market - Caruncho Avenue - Shaw Blvd - Quiapo\"}', '2024-07-28 23:51:10', NULL),
(423, 49, 'Edit', 'Edited record in route. Old values: {\"id\":5,\"route_id\":\"R2023-00005\",\"route_struct\":\"Cubao via Rosario\",\"route_line\":\"Rosario via Cubao\",\"route_modify\":\"\",\"date\":\"2023-12-11 19:38:49\"}; New values: {\"route_id\":\"R2023-00005\",\"route_line\":\"Rosario via Cubao\",\"route_struct\":\"Cubao - Libis - Ortigas Extension - Rosario\"}', '2024-07-28 23:52:08', NULL),
(424, 49, 'Edit', 'Edited record in route. Old values: {\"id\":1,\"route_id\":\"R2023-00001\",\"route_struct\":\"Ugong Terminal - Pasig via Pasig Market Terminal\",\"route_line\":\"Pasig Market via Ugong\",\"route_modify\":\"\",\"date\":\"2023-12-09 14:45:18\"}; New values: {\"route_id\":\"R2023-00001\",\"route_line\":\"Pasig Market via Ugong\",\"route_struct\":\"Ugong Terminal - C5 - Julia Vargas Bridge - Dr. Sixto Avenue - Pasig Market Terminal\"}', '2024-07-28 23:53:42', NULL),
(425, 49, 'Edit', 'Edited record in route. Old values: {\"id\":2,\"route_id\":\"R2023-00002\",\"route_struct\":\"Quiapo - Pasig via Pasig Market Terminal\",\"route_line\":\"Pasig Market via Quiapo\\t\\t\",\"route_modify\":\"\",\"date\":\"2023-12-09 14:46:18\"}; New values: {\"route_id\":\"R2023-00002\",\"route_line\":\"Pasig Market via Quiapo\\t\\t\",\"route_struct\":\"Quiapo - Mandaluyong Shaw Blvd Pasig via Pasig Market Terminal\"}', '2024-07-29 00:15:59', NULL),
(426, 49, 'Edit', 'Edited record in route. Old values: {\"id\":2,\"route_id\":\"R2023-00002\",\"route_struct\":\"Quiapo - Mandaluyong Shaw Blvd Pasig via Pasig Market Terminal\",\"route_line\":\"Pasig Market via Quiapo\\t\\t\",\"route_modify\":\"\",\"date\":\"2023-12-09 14:46:18\"}; New values: {\"route_id\":\"R2023-00002\",\"route_line\":\"Pasig Market via Quiapo\\t\\t\",\"route_struct\":\"Quiapo - Mandaluyong Shaw Blvd Pasig - Pasig Market Terminal\"}', '2024-07-29 00:16:11', NULL),
(427, 49, 'Edit', 'Edited record in route. Old values: {\"id\":3,\"route_id\":\"R2023-00003\",\"route_struct\":\"Taguig - Pasig via Pasig Market Terminal\",\"route_line\":\"Pasig Market via Taguig\",\"route_modify\":\"\",\"date\":\"2023-12-09 14:46:53\"}; New values: {\"route_id\":\"R2023-00003\",\"route_line\":\"Pasig Market via Taguig\",\"route_struct\":\"Taguig - San Joaquin Pasig - Pasig Market Terminal\"}', '2024-07-29 00:16:49', NULL),
(428, 49, 'Add', 'Added new record to route: {\"route_id\":\"R2024-00001\",\"route_line\":\"Pasig San Joaquin - Robinson\'s Galleria\",\"route_struct\":\"Pasig San Joaquin - Dr. Sixto Avenue - Rotonda - Ortigas Center\"}', '2024-07-29 00:18:33', NULL),
(429, 49, 'Add', 'Added new record to route: {\"route_id\":\"R2024-00002\",\"route_line\":\"Pasig (Santolan) \\u2013 SM Megamall via Robinson\",\"route_struct\":\"Pasig (Santolan) \\u2013 SM Megamall - Robinson\"}', '2024-07-29 00:20:04', NULL),
(430, 49, 'Add', 'Added new record to route: {\"route_id\":\"R2024-00003\",\"route_line\":\"Pasig \\u2013 SM Megamall via Robinson\\u2019s Galleria\",\"route_struct\":\"Pasig \\u2013 SM Megamall - Robinson\\u2019s Galleria\"}', '2024-07-29 00:20:28', NULL),
(431, 49, 'Add', 'Added new record to route: {\"route_id\":\"R2024-00004\",\"route_line\":\"Cubao via Rosario - Sta. Lucia\",\"route_struct\":\"Cubao - Rosario - Sta. Lucia\"}', '2024-07-29 00:20:52', NULL),
(432, 49, 'Add', 'Added new record to route: {\"route_id\":\"R2024-00005\",\"route_line\":\"Angono via Pasig Market\",\"route_struct\":\"Caruncho Ave., Pasig City and Angono Public Market...\"}', '2024-07-29 00:21:29', NULL),
(433, 49, 'Add', 'Added new record to trans_group: {\"group_id\":\"GRP-2024-003\",\"group_name\":\"Manibela\"}', '2024-07-29 00:25:53', NULL),
(434, 49, 'Add', 'Added new record to group_officers: {\"group_id\":8,\"officer_position\":\"President\",\"officer_name\":\"Ramon Revilla Jr.\"}', '2024-07-29 00:25:53', NULL),
(435, 49, 'Add', 'Added new record to trans_group: {\"group_id\":\"GRP-2024-004\",\"group_name\":\"PISTON\"}', '2024-07-29 00:26:06', NULL),
(436, 49, 'Add', 'Added new record to group_officers: {\"group_id\":9,\"officer_position\":\"President\",\"officer_name\":\"Robin Padilla\"}', '2024-07-29 00:26:06', NULL),
(437, 49, 'Add', 'Added new record to trans_group: {\"group_id\":\"GRP-2024-005\",\"group_name\":\"JEEPNEY\"}', '2024-07-29 00:26:20', NULL),
(438, 49, 'Add', 'Added new record to group_officers: {\"group_id\":10,\"officer_position\":\"President\",\"officer_name\":\"Jinggoy Estrada\"}', '2024-07-29 00:26:20', NULL),
(439, 49, 'Add', 'Added new record to trans_group: {\"group_id\":\"GRP-2024-006\",\"group_name\":\"TARIPA\"}', '2024-07-29 00:26:44', NULL),
(440, 49, 'Add', 'Added new record to group_officers: {\"group_id\":11,\"officer_position\":\"President\",\"officer_name\":\"Win Gatchalian\"}', '2024-07-29 00:26:44', NULL),
(441, 49, 'Add', 'Added new record to trans_group: {\"group_id\":\"GRP-2024-007\",\"group_name\":\"PAMAQODA\"}', '2024-07-29 00:26:58', NULL),
(442, 49, 'Add', 'Added new record to group_officers: {\"group_id\":12,\"officer_position\":\"Chairman\",\"officer_name\":\"Ruben Velasquez\"}', '2024-07-29 00:26:58', NULL),
(443, 49, 'Add', 'Added new record to trans_group: {\"group_id\":\"GRP-2024-008\",\"group_name\":\"CURODA\"}', '2024-07-29 00:27:28', NULL),
(444, 49, 'Add', 'Added new record to group_officers: {\"group_id\":13,\"officer_position\":\"Chairman\",\"officer_name\":\"Ramil Padrigo\"}', '2024-07-29 00:27:28', NULL),
(445, 49, 'Add', 'Added new record to trans_group: {\"group_id\":\"GRP-2024-009\",\"group_name\":\"PPJODA\"}', '2024-07-29 00:27:53', NULL),
(446, 49, 'Add', 'Added new record to group_officers: {\"group_id\":14,\"officer_position\":\"Chairman\",\"officer_name\":\"Basil Valdez\"}', '2024-07-29 00:27:53', NULL),
(447, 49, 'Add', 'Added new record to trans_group: {\"group_id\":\"GRP-2024-010\",\"group_name\":\"MJPUV\"}', '2024-07-29 00:29:08', NULL),
(448, 49, 'Add', 'Added new record to group_officers: {\"group_id\":15,\"officer_position\":\"President\",\"officer_name\":\"George Estregan\"}', '2024-07-29 00:29:08', NULL),
(449, 49, 'Add', 'Added new record to terminal: {\"terminal_id\":\"T0003\",\"terminal_name\":\"Mavericks Terminal\",\"terminal_add\":\"Urbano Ave., Pinagbuhatan Pasig City\",\"route_id\":\"5\",\"insp_id\":\"1\",\"reso_id\":\"1\",\"group_id\":\"2\",\"busi_permit\":\"PSG-00533570\",\"busi_date\":\"2024-01-01\",\"busi_expire\":\"2024-12-31\"}', '2024-07-29 00:30:13', NULL),
(450, 49, 'Edit', 'Edited record in terminal. Old values: {\"id\":7,\"terminal_id\":\"T0003\",\"terminal_name\":\"Mavericks Terminal\",\"terminal_add\":\"Urbano Ave., Pinagbuhatan Pasig City\",\"route_id\":5,\"insp_id\":1,\"reso_id\":1,\"group_id\":2,\"busi_permit\":\"PSG-00533570\",\"busi_date\":\"2024-01-01\",\"busi_expire\":\"2024-12-31\",\"date\":\"2024-07-29 08:30:13\"}; New values: {\"terminal_id\":\"T0003\",\"terminal_name\":\"Mavericks Terminal\",\"terminal_add\":\"Urbano Ave., Pinagbuhatan Pasig City\",\"route_id\":\"5\",\"insp_id\":\"1\",\"reso_id\":\"1\",\"group_id\":\"8\",\"busi_permit\":\"PSG-00533570\",\"busi_date\":\"2024-01-01\",\"busi_expire\":\"2024-12-31\"}', '2024-07-29 00:30:21', NULL),
(451, 49, 'Add', 'Added new record to terminal: {\"terminal_id\":\"T0004\",\"terminal_name\":\"Warriors Terminal\",\"terminal_add\":\"Urbano Ave., Pinagbuhatan Pasig City\",\"route_id\":\"10\",\"insp_id\":\"1\",\"reso_id\":\"1\",\"group_id\":\"9\",\"busi_permit\":\"PSG-00554569\",\"busi_date\":\"2024-01-01\",\"busi_expire\":\"2024-12-31\"}', '2024-07-29 00:31:04', NULL),
(452, 49, 'Add', 'Added new record to terminal: {\"terminal_id\":\"T0005\",\"terminal_name\":\"Orlando Terminal\",\"terminal_add\":\"Caruncho Ave, Malinao Pasig City\",\"route_id\":\"11\",\"insp_id\":\"1\",\"reso_id\":\"2\",\"group_id\":\"10\",\"busi_permit\":\"PSG-00554570\",\"busi_date\":\"2024-01-01\",\"busi_expire\":\"2024-12-31\"}', '2024-07-29 00:31:44', NULL),
(453, 49, 'Add', 'Added new record to terminal: {\"terminal_id\":\"T0006\",\"terminal_name\":\"PasMarTag Terminal\",\"terminal_add\":\"F. Manalo Santo Tomas Pasig City\",\"route_id\":\"13\",\"insp_id\":\"1\",\"reso_id\":\"1\",\"group_id\":\"11\",\"busi_permit\":\"PSG-00554534\",\"busi_date\":\"2024-01-01\",\"busi_expire\":\"2024-12-31\"}', '2024-07-29 00:33:09', NULL),
(454, 49, 'Add', 'Added new record to terminal: {\"terminal_id\":\"T0007\",\"terminal_name\":\"AngPas Market  Terminal\",\"terminal_add\":\"Pineda Pasig City\",\"route_id\":\"14\",\"insp_id\":\"1\",\"reso_id\":\"1\",\"group_id\":\"12\",\"busi_permit\":\"PSG-00588569\",\"busi_date\":\"2024-01-01\",\"busi_expire\":\"2024-12-31\"}', '2024-07-29 00:34:18', NULL),
(455, 49, 'Add', 'Added new record to terminal: {\"terminal_id\":\"T0008\",\"terminal_name\":\"Kamao Terminal\",\"terminal_add\":\"Sta Lucia Pasig City\",\"route_id\":\"13\",\"insp_id\":\"1\",\"reso_id\":\"1\",\"group_id\":\"13\",\"busi_permit\":\"PSG-02854569\",\"busi_date\":\"2024-01-01\",\"busi_expire\":\"2024-12-31\"}', '2024-07-29 00:35:16', NULL),
(456, 49, 'Add', 'Added new record to terminal: {\"terminal_id\":\"T0009\",\"terminal_name\":\"Utah Jazz Terminal\",\"terminal_add\":\"Life Homes Manggahan Pasig City\",\"route_id\":\"5\",\"insp_id\":\"1\",\"reso_id\":\"2\",\"group_id\":\"14\",\"busi_permit\":\"PSG-12377569\",\"busi_date\":\"2024-01-01\",\"busi_expire\":\"2024-12-31\"}', '2024-07-29 00:36:43', NULL),
(457, 49, 'Add', 'Added new record to terminal: {\"terminal_id\":\"T0010\",\"terminal_name\":\"PPRDOTA\",\"terminal_add\":\"Bambang Pasig City\",\"route_id\":\"12\",\"insp_id\":\"1\",\"reso_id\":\"1\",\"group_id\":\"15\",\"busi_permit\":\"PSG-01154570\",\"busi_date\":\"2024-01-01\",\"busi_expire\":\"2024-12-31\"}', '2024-07-29 00:48:53', NULL),
(458, 49, 'Add', 'Added new record to driver: {\"driver_id\":\"DRV-2024-0005\",\"resi_id\":\"1\",\"driver_name\":\"Rodrigo Duterte\",\"driver_address\":\"Eusebio Bliss 1 Maybunga Pasig City\",\"driver_contact\":\"09878456132\"}', '2024-07-29 00:50:17', NULL),
(459, 49, 'Add', 'Added new record to driver: {\"driver_id\":\"DRV-2024-0006\",\"resi_id\":\"1\",\"driver_name\":\"John Regala\",\"driver_address\":\"PIneda, Pasig City\",\"driver_contact\":\"09878451111\"}', '2024-07-29 00:50:29', NULL),
(460, 49, 'Add', 'Added new record to driver: {\"driver_id\":\"DRV-2024-0007\",\"resi_id\":\"2\",\"driver_name\":\"Paul Salas\",\"driver_address\":\"Wakwak Mandaluyong City\",\"driver_contact\":\"09878456213\"}', '2024-07-29 00:50:48', NULL),
(461, 49, 'Add', 'Added new record to driver: {\"driver_id\":\"DRV-2024-0008\",\"resi_id\":\"1\",\"driver_name\":\"Buboy Villar\",\"driver_address\":\"Cuaresma St. Kalawaan Pasig City\",\"driver_contact\":\"09878456213\"}', '2024-07-29 00:50:59', NULL);
INSERT INTO `audit_log` (`id`, `userid`, `action`, `description`, `timestamp`, `permission_id`) VALUES
(462, 49, 'Add', 'Added new record to driver: {\"driver_id\":\"DRV-2024-0009\",\"resi_id\":\"1\",\"driver_name\":\"Mikael Daez\",\"driver_address\":\"Villa alfonso bambang Pasig City\",\"driver_contact\":\"09878450000\"}', '2024-07-29 00:51:12', NULL),
(463, 49, 'Add', 'Added new record to driver: {\"driver_id\":\"DRV-2024-0010\",\"resi_id\":\"1\",\"driver_name\":\"Kokoy Delos Reyes\",\"driver_address\":\"Centenial II Nagpayong Pinagbuhatan Pasig City\",\"driver_contact\":\"09878452222\"}', '2024-07-29 00:51:23', NULL),
(464, 49, 'Add', 'Added new record to operator: {\"optr_id\":\"OPR2024-0004\",\"resi_id\":\"1\",\"optr_name\":\"Ricky Davao\",\"optr_add\":\"Pineda, Pasig City\",\"optr_contact\":\"09123456789\"}', '2024-07-29 00:52:04', NULL),
(465, 49, 'Add', 'Added new record to operator: {\"optr_id\":\"OPR2024-0005\",\"resi_id\":\"2\",\"optr_name\":\"Michael Jordan\",\"optr_add\":\"Mandaluyong City\",\"optr_contact\":\"09178886666\"}', '2024-07-29 00:52:17', NULL),
(466, 49, 'Add', 'Added new record to operator: {\"optr_id\":\"OPR2024-0006\",\"resi_id\":\"1\",\"optr_name\":\"Scottie Pippen\",\"optr_add\":\"Caruncho Ave., Pasig Market, Pasig City\",\"optr_contact\":\"09178882222\"}', '2024-07-29 00:52:27', NULL),
(467, 49, 'Add', 'Added new record to operator: {\"optr_id\":\"OPR2024-0007\",\"resi_id\":\"1\",\"optr_name\":\"Willie Revillame\",\"optr_add\":\"A. Luna Pasig Simbahan, Malinao, Pasig City\",\"optr_contact\":\"09178886555\"}', '2024-07-29 00:53:02', NULL),
(468, 49, 'Add', 'Added new record to operator: {\"optr_id\":\"OPR2024-0008\",\"resi_id\":\"1\",\"optr_name\":\"Chot Reyes\",\"optr_add\":\"Urbano Velasco Pinagbuhatan Pasig City\",\"optr_contact\":\"09178883333\"}', '2024-07-29 00:53:30', NULL),
(469, 49, 'Add', 'Added new record to operator: {\"optr_id\":\"OPR2024-0009\",\"resi_id\":\"1\",\"optr_name\":\"Tim Cone\",\"optr_add\":\"F. Manalo near City Hall Malinao Pasig City\",\"optr_contact\":\"09178884444\"}', '2024-07-29 00:53:48', NULL),
(470, 49, 'Add', 'Added new record to operator: {\"optr_id\":\"OPR2024-0010\",\"resi_id\":\"1\",\"optr_name\":\"Gerald Anderson\",\"optr_add\":\"Ismar Kalawaan Pasig City\",\"optr_contact\":\"09178899966\"}', '2024-07-29 00:54:26', NULL),
(471, 49, 'Add', 'Added new record to vehicle_unit: {\"veh_id\":14,\"plate_no\":\"UCF-820\",\"case_id\":\"1\",\"vtype_id\":\"1\",\"optr_id\":\"19\",\"terminal_id\":\"14\",\"group_id\":\"15\",\"cr_no\":\"08201981\",\"engine_no\":\"E08201981\",\"chassis_no\":\"UCF08201981\"}', '2024-07-29 00:55:49', NULL),
(472, 49, 'Add', 'Added new record to vehicle_unit: {\"veh_id\":15,\"plate_no\":\"EYF-707\",\"case_id\":\"2\",\"vtype_id\":\"2\",\"optr_id\":\"18\",\"terminal_id\":\"13\",\"group_id\":\"14\",\"cr_no\":\"07071981\",\"engine_no\":\"E07071981\",\"chassis_no\":\"EYF07071981\"}', '2024-07-29 00:56:33', NULL),
(473, 49, 'Add', 'Added new record to vehicle_unit: {\"veh_id\":16,\"plate_no\":\"ABC-123\",\"case_id\":\"1\",\"vtype_id\":\"3\",\"optr_id\":\"17\",\"terminal_id\":\"12\",\"group_id\":\"13\",\"cr_no\":\"07071666\",\"engine_no\":\"E08201765\",\"chassis_no\":\"EYF07982925\"}', '2024-07-29 00:57:29', NULL),
(474, 49, 'Add', 'Added new record to vehicle_unit: {\"veh_id\":17,\"plate_no\":\"FUC-028\",\"case_id\":\"2\",\"vtype_id\":\"2\",\"optr_id\":\"17\",\"terminal_id\":\"11\",\"group_id\":\"12\",\"cr_no\":\"07071981002\",\"engine_no\":\"E08201765003\",\"chassis_no\":\"EYF07071321004\"}', '2024-07-29 01:00:17', NULL),
(475, 49, 'Edit', 'Edited record in role_permissions. Old values: [1,2,3,9]; New values: [\"1\",\"2\",\"3\",\"9\",\"11\",\"14\",\"15\",\"18\",\"34\",\"38\"]', '2024-07-29 01:12:39', NULL),
(476, 49, 'Edit', 'Edited record in role_permissions. Old values: [7,8,9]; New values: [\"1\",\"2\",\"3\",\"7\",\"8\",\"9\",\"12\",\"14\",\"16\",\"18\",\"34\",\"35\",\"36\",\"38\"]', '2024-07-29 01:13:29', NULL),
(477, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":16,\"veh_id\":\"V2024-00009\",\"case_id\":1,\"vtype_id\":3,\"optr_id\":17,\"terminal_id\":12,\"group_id\":13,\"plate_no\":\"ABC-123\",\"cr_no\":\"07071666\",\"engine_no\":\"E08201765\",\"chassis_no\":\"EYF07982925\",\"created_at\":\"2024-07-29 08:57:29\"}; New values: {\"plate_no\":\"ABC-123\",\"case_id\":\"1\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"1\",\"group_id\":\"10\",\"cr_no\":\"07071666\",\"engine_no\":\"E08201765\",\"chassis_no\":\"EYF07982925\"}', '2024-07-29 03:28:38', NULL),
(478, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":17,\"veh_id\":\"V2024-00010\",\"case_id\":2,\"vtype_id\":2,\"optr_id\":17,\"terminal_id\":11,\"group_id\":12,\"plate_no\":\"FUC-028\",\"cr_no\":\"07071981002\",\"engine_no\":\"E08201765003\",\"chassis_no\":\"EYF07071321004\",\"created_at\":\"2024-07-29 09:00:17\"}; New values: {\"plate_no\":\"FUC-028\",\"case_id\":\"2\",\"vtype_id\":\"1\",\"optr_id\":\"3\",\"terminal_id\":\"9\",\"group_id\":\"10\",\"cr_no\":\"07071981002\",\"engine_no\":\"E08201765003\",\"chassis_no\":\"EYF07071321004\"}', '2024-07-29 03:33:36', NULL),
(479, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":17,\"veh_id\":\"V2024-00010\",\"case_id\":2,\"vtype_id\":1,\"optr_id\":3,\"terminal_id\":9,\"group_id\":10,\"plate_no\":\"FUC-028\",\"cr_no\":\"07071981002\",\"engine_no\":\"E08201765003\",\"chassis_no\":\"EYF07071321004\",\"created_at\":\"2024-07-29 11:33:36\"}; New values: {\"plate_no\":\"FUC-028\",\"case_id\":\"2\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"9\",\"group_id\":\"10\",\"cr_no\":\"07071981002\",\"engine_no\":\"E08201765003\",\"chassis_no\":\"EYF07071321004\"}', '2024-07-29 03:34:19', NULL),
(480, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":17,\"veh_id\":\"V2024-00010\",\"case_id\":2,\"vtype_id\":1,\"optr_id\":1,\"terminal_id\":9,\"group_id\":10,\"plate_no\":\"FUC-028\",\"cr_no\":\"07071981002\",\"engine_no\":\"E08201765003\",\"chassis_no\":\"EYF07071321004\",\"created_at\":\"2024-07-29 11:34:19\"}; New values: {\"plate_no\":\"FUC-028\",\"case_id\":\"1\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"9\",\"group_id\":\"10\",\"cr_no\":\"07071981002\",\"engine_no\":\"E08201765003\",\"chassis_no\":\"EYF07071321004\"}', '2024-07-29 03:38:46', NULL),
(481, 49, 'Logout', 'User logged out', '2024-07-29 09:18:05', NULL),
(482, 49, 'Login', 'User logged in', '2024-07-30 06:46:31', NULL),
(483, 49, 'Logout', 'User logged out', '2024-07-30 08:56:59', NULL),
(484, 49, 'Login', 'User logged in', '2024-07-31 01:03:56', NULL),
(485, 37, 'Login', 'User logged in', '2024-07-31 01:12:40', NULL),
(486, 49, 'Logout', 'User logged out', '2024-07-31 09:11:23', NULL),
(487, 49, 'Login', 'User logged in', '2024-07-31 14:13:28', NULL),
(488, 49, 'Add', 'Added new record to cases: {\"case_id\":\"C2024-00003\",\"route_id\":\"3\",\"case_no\":\"2003-1234\",\"case_granted\":\"2024-06-30\",\"case_expire\":\"2024-08-10\"}', '2024-07-31 14:20:51', NULL),
(489, 49, 'Add', 'Added new record to cases: {\"case_id\":\"C2024-00004\",\"route_id\":\"4\",\"case_no\":\"1985-5438\",\"case_granted\":\"2024-06-30\",\"case_expire\":\"2024-08-10\"}', '2024-07-31 14:26:18', NULL),
(490, 49, 'Add', 'Added new record to cases: {\"case_id\":\"C2024-00005\",\"route_id\":\"5\",\"case_no\":\"1998-2483\",\"case_granted\":\"2024-06-30\",\"case_expire\":\"2024-08-08\"}', '2024-07-31 14:26:36', NULL),
(491, 49, 'Add', 'Added new record to cases: {\"case_id\":\"C2024-00006\",\"route_id\":\"10\",\"case_no\":\"2001-4268\",\"case_granted\":\"2024-06-30\",\"case_expire\":\"2024-07-30\"}', '2024-07-31 14:26:53', NULL),
(492, 49, 'Add', 'Added new record to cases: {\"case_id\":\"C2024-00007\",\"route_id\":\"11\",\"case_no\":\"2005-3548\",\"case_granted\":\"2024-06-30\",\"case_expire\":\"2024-09-06\"}', '2024-07-31 14:27:10', NULL),
(493, 49, 'Add', 'Added new record to cases: {\"case_id\":\"C2024-00008\",\"route_id\":\"12\",\"case_no\":\"2012-4527\",\"case_granted\":\"2024-05-26\",\"case_expire\":\"2024-10-12\"}', '2024-07-31 14:27:34', NULL),
(494, 49, 'Add', 'Added new record to cases: {\"case_id\":\"C2024-00009\",\"route_id\":\"13\",\"case_no\":\"2020-1621\",\"case_granted\":\"2024-07-17\",\"case_expire\":\"2024-12-07\"}', '2024-07-31 14:27:58', NULL),
(495, 49, 'Add', 'Added new record to cases: {\"case_id\":\"C2024-00010\",\"route_id\":\"14\",\"case_no\":\"1999-3501\",\"case_granted\":\"2024-01-28\",\"case_expire\":\"2025-01-11\"}', '2024-07-31 14:28:20', NULL),
(496, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":6,\"veh_id\":\"V2024-00005\",\"case_id\":2,\"vtype_id\":1,\"optr_id\":1,\"terminal_id\":1,\"group_id\":1,\"plate_no\":\"PSG-1234\",\"cr_no\":\"asdas\",\"engine_no\":\"dasdasda\",\"chassis_no\":\"sdasdas\",\"created_at\":\"2024-07-26 10:09:57\"}; New values: {\"plate_no\":\"PSG-1234\",\"case_id\":\"3\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"3\",\"group_id\":\"1\",\"cr_no\":\"asdas\",\"engine_no\":\"dasdasda\",\"chassis_no\":\"sdasdas\"}', '2024-07-31 14:30:38', NULL),
(497, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":4,\"veh_id\":\"V2024-00004\",\"case_id\":2,\"vtype_id\":1,\"optr_id\":1,\"terminal_id\":3,\"group_id\":1,\"plate_no\":\"GHG-4758\",\"cr_no\":\"SDAS\",\"engine_no\":\"DSADASDSA\",\"chassis_no\":\"DASASDS\",\"created_at\":\"2024-07-28 18:54:49\"}; New values: {\"plate_no\":\"GHG-4758\",\"case_id\":\"3\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"3\",\"group_id\":\"1\",\"cr_no\":\"SDAS\",\"engine_no\":\"DSADASDSA\",\"chassis_no\":\"DASASDS\"}', '2024-07-31 14:34:36', NULL),
(498, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":17,\"veh_id\":\"V2024-00010\",\"case_id\":1,\"vtype_id\":1,\"optr_id\":1,\"terminal_id\":9,\"group_id\":10,\"plate_no\":\"FUC-028\",\"cr_no\":\"07071981002\",\"engine_no\":\"E08201765003\",\"chassis_no\":\"EYF07071321004\",\"created_at\":\"2024-07-29 11:38:46\"}; New values: {\"plate_no\":\"FUC-028\",\"case_id\":\"7\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"9\",\"group_id\":\"10\",\"cr_no\":\"07071981002\",\"engine_no\":\"E08201765003\",\"chassis_no\":\"EYF07071321004\"}', '2024-07-31 14:53:10', NULL),
(499, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":4,\"veh_id\":\"V2024-00004\",\"case_id\":3,\"vtype_id\":1,\"optr_id\":1,\"terminal_id\":3,\"group_id\":1,\"plate_no\":\"GHG-4758\",\"cr_no\":\"SDAS\",\"engine_no\":\"DSADASDSA\",\"chassis_no\":\"DASASDS\",\"created_at\":\"2024-07-31 22:34:36\"}; New values: {\"plate_no\":\"GHG-4758\",\"case_id\":\"3\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"3\",\"group_id\":\"1\",\"cr_no\":\"SDAS\",\"engine_no\":\"DSADASDSA\",\"chassis_no\":\"DASASDS\"}', '2024-07-31 14:53:20', NULL),
(500, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":13,\"veh_id\":\"V2024-00006\",\"case_id\":1,\"vtype_id\":2,\"optr_id\":2,\"terminal_id\":1,\"group_id\":1,\"plate_no\":\"dasdsadsa\",\"cr_no\":\"asds\",\"engine_no\":\"adadsa\",\"chassis_no\":\"asdasdasda\",\"created_at\":\"2024-07-28 18:58:29\"}; New values: {\"plate_no\":\"dasdsadsa\",\"case_id\":\"1\",\"vtype_id\":\"2\",\"optr_id\":\"2\",\"terminal_id\":\"1\",\"group_id\":\"1\",\"cr_no\":\"asds\",\"engine_no\":\"adadsa\",\"chassis_no\":\"asdasdasda\"}', '2024-07-31 14:53:23', NULL),
(501, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":14,\"veh_id\":\"V2024-00007\",\"case_id\":1,\"vtype_id\":1,\"optr_id\":19,\"terminal_id\":14,\"group_id\":15,\"plate_no\":\"UCF-820\",\"cr_no\":\"08201981\",\"engine_no\":\"E08201981\",\"chassis_no\":\"UCF08201981\",\"created_at\":\"2024-07-29 08:55:49\"}; New values: {\"plate_no\":\"UCF-820\",\"case_id\":\"8\",\"vtype_id\":\"1\",\"optr_id\":\"19\",\"terminal_id\":\"14\",\"group_id\":\"15\",\"cr_no\":\"08201981\",\"engine_no\":\"E08201981\",\"chassis_no\":\"UCF08201981\"}', '2024-07-31 14:53:28', NULL),
(502, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":16,\"veh_id\":\"V2024-00009\",\"case_id\":1,\"vtype_id\":1,\"optr_id\":1,\"terminal_id\":1,\"group_id\":10,\"plate_no\":\"ABC-123\",\"cr_no\":\"07071666\",\"engine_no\":\"E08201765\",\"chassis_no\":\"EYF07982925\",\"created_at\":\"2024-07-29 11:28:38\"}; New values: {\"plate_no\":\"ABC-123\",\"case_id\":\"1\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"1\",\"group_id\":\"10\",\"cr_no\":\"07071666\",\"engine_no\":\"E08201765\",\"chassis_no\":\"EYF07982925\"}', '2024-07-31 14:53:38', NULL),
(503, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":4,\"veh_id\":\"V2024-00004\",\"case_id\":3,\"vtype_id\":1,\"optr_id\":1,\"terminal_id\":3,\"group_id\":1,\"plate_no\":\"GHG-4758\",\"cr_no\":\"SDAS\",\"engine_no\":\"DSADASDSA\",\"chassis_no\":\"DASASDS\",\"created_at\":\"2024-07-31 22:34:36\"}; New values: {\"plate_no\":\"GHG-4758\",\"case_id\":\"3\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"3\",\"group_id\":\"1\",\"cr_no\":\"SDAS\",\"engine_no\":\"DSADASDSA\",\"chassis_no\":\"DASASDS\"}', '2024-07-31 14:54:33', NULL),
(504, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":13,\"veh_id\":\"V2024-00006\",\"case_id\":1,\"vtype_id\":2,\"optr_id\":2,\"terminal_id\":1,\"group_id\":1,\"plate_no\":\"dasdsadsa\",\"cr_no\":\"asds\",\"engine_no\":\"adadsa\",\"chassis_no\":\"asdasdasda\",\"created_at\":\"2024-07-28 18:58:29\"}; New values: {\"plate_no\":\"dasdsadsa\",\"case_id\":\"1\",\"vtype_id\":\"2\",\"optr_id\":\"2\",\"terminal_id\":\"1\",\"group_id\":\"1\",\"cr_no\":\"asds\",\"engine_no\":\"adadsa\",\"chassis_no\":\"asdasdasda\"}', '2024-07-31 14:54:36', NULL),
(505, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":15,\"veh_id\":\"V2024-00008\",\"case_id\":2,\"vtype_id\":2,\"optr_id\":18,\"terminal_id\":13,\"group_id\":14,\"plate_no\":\"EYF-707\",\"cr_no\":\"07071981\",\"engine_no\":\"E07071981\",\"chassis_no\":\"EYF07071981\",\"created_at\":\"2024-07-29 08:56:33\"}; New values: {\"plate_no\":\"EYF-707\",\"case_id\":\"5\",\"vtype_id\":\"2\",\"optr_id\":\"18\",\"terminal_id\":\"13\",\"group_id\":\"14\",\"cr_no\":\"07071981\",\"engine_no\":\"E07071981\",\"chassis_no\":\"EYF07071981\"}', '2024-07-31 14:54:40', NULL),
(506, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":13,\"veh_id\":\"V2024-00006\",\"case_id\":1,\"vtype_id\":2,\"optr_id\":2,\"terminal_id\":1,\"group_id\":1,\"plate_no\":\"dasdsadsa\",\"cr_no\":\"asds\",\"engine_no\":\"adadsa\",\"chassis_no\":\"asdasdasda\",\"created_at\":\"2024-07-28 18:58:29\"}; New values: {\"plate_no\":\"dasdsadsa\",\"case_id\":\"1\",\"vtype_id\":\"2\",\"optr_id\":\"2\",\"terminal_id\":\"1\",\"group_id\":\"1\",\"cr_no\":\"asds\",\"engine_no\":\"adadsa\",\"chassis_no\":\"asdasdasda\"}', '2024-07-31 14:54:44', NULL),
(507, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":16,\"veh_id\":\"V2024-00009\",\"case_id\":1,\"vtype_id\":1,\"optr_id\":1,\"terminal_id\":1,\"group_id\":10,\"plate_no\":\"ABC-123\",\"cr_no\":\"07071666\",\"engine_no\":\"E08201765\",\"chassis_no\":\"EYF07982925\",\"created_at\":\"2024-07-29 11:28:38\"}; New values: {\"plate_no\":\"ABC-123\",\"case_id\":\"1\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"1\",\"group_id\":\"10\",\"cr_no\":\"07071666\",\"engine_no\":\"E08201765\",\"chassis_no\":\"EYF07982925\"}', '2024-07-31 14:55:52', NULL),
(508, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":13,\"veh_id\":\"V2024-00006\",\"case_id\":1,\"vtype_id\":2,\"optr_id\":2,\"terminal_id\":1,\"group_id\":1,\"plate_no\":\"dasdsadsa\",\"cr_no\":\"asds\",\"engine_no\":\"adadsa\",\"chassis_no\":\"asdasdasda\",\"created_at\":\"2024-07-28 18:58:29\"}; New values: {\"plate_no\":\"dasdsadsa\",\"case_id\":\"1\",\"vtype_id\":\"2\",\"optr_id\":\"2\",\"terminal_id\":\"1\",\"group_id\":\"1\",\"cr_no\":\"asds\",\"engine_no\":\"adadsa\",\"chassis_no\":\"asdasdasda\"}', '2024-07-31 14:55:56', NULL),
(509, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":15,\"veh_id\":\"V2024-00008\",\"case_id\":5,\"vtype_id\":2,\"optr_id\":18,\"terminal_id\":13,\"group_id\":14,\"plate_no\":\"EYF-707\",\"cr_no\":\"07071981\",\"engine_no\":\"E07071981\",\"chassis_no\":\"EYF07071981\",\"created_at\":\"2024-07-31 22:54:40\"}; New values: {\"plate_no\":\"EYF-707\",\"case_id\":\"5\",\"vtype_id\":\"2\",\"optr_id\":\"18\",\"terminal_id\":\"13\",\"group_id\":\"14\",\"cr_no\":\"07071981\",\"engine_no\":\"E07071981\",\"chassis_no\":\"EYF07071981\"}', '2024-07-31 14:55:59', NULL),
(510, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":17,\"veh_id\":\"V2024-00010\",\"case_id\":7,\"vtype_id\":1,\"optr_id\":1,\"terminal_id\":9,\"group_id\":10,\"plate_no\":\"FUC-028\",\"cr_no\":\"07071981002\",\"engine_no\":\"E08201765003\",\"chassis_no\":\"EYF07071321004\",\"created_at\":\"2024-07-31 22:53:10\"}; New values: {\"plate_no\":\"FUC-028\",\"case_id\":\"7\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"9\",\"group_id\":\"10\",\"cr_no\":\"07071981002\",\"engine_no\":\"E08201765003\",\"chassis_no\":\"EYF07071321004\"}', '2024-07-31 14:56:03', NULL),
(511, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":4,\"veh_id\":\"V2024-00004\",\"case_id\":3,\"vtype_id\":1,\"optr_id\":1,\"terminal_id\":3,\"group_id\":1,\"plate_no\":\"GHG-4758\",\"cr_no\":\"SDAS\",\"engine_no\":\"DSADASDSA\",\"chassis_no\":\"DASASDS\",\"created_at\":\"2024-07-31 22:34:36\"}; New values: {\"plate_no\":\"GHG-4758\",\"case_id\":\"3\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"3\",\"group_id\":\"1\",\"cr_no\":\"SDAS\",\"engine_no\":\"DSADASDSA\",\"chassis_no\":\"DASASDS\"}', '2024-07-31 14:56:08', NULL),
(512, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":6,\"veh_id\":\"V2024-00005\",\"case_id\":3,\"vtype_id\":1,\"optr_id\":1,\"terminal_id\":3,\"group_id\":1,\"plate_no\":\"PSG-1234\",\"cr_no\":\"asdas\",\"engine_no\":\"dasdasda\",\"chassis_no\":\"sdasdas\",\"created_at\":\"2024-07-31 22:30:38\"}; New values: {\"plate_no\":\"PSG-1234\",\"case_id\":\"3\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"3\",\"group_id\":\"1\",\"cr_no\":\"asdas\",\"engine_no\":\"dasdasda\",\"chassis_no\":\"sdasdas\"}', '2024-07-31 14:56:14', NULL),
(513, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":14,\"veh_id\":\"V2024-00007\",\"case_id\":8,\"vtype_id\":1,\"optr_id\":19,\"terminal_id\":14,\"group_id\":15,\"plate_no\":\"UCF-820\",\"cr_no\":\"08201981\",\"engine_no\":\"E08201981\",\"chassis_no\":\"UCF08201981\",\"created_at\":\"2024-07-31 22:53:28\"}; New values: {\"plate_no\":\"UCF-820\",\"case_id\":\"8\",\"vtype_id\":\"1\",\"optr_id\":\"19\",\"terminal_id\":\"14\",\"group_id\":\"15\",\"cr_no\":\"08201981\",\"engine_no\":\"E08201981\",\"chassis_no\":\"UCF08201981\"}', '2024-07-31 14:56:18', NULL),
(514, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":16,\"veh_id\":\"V2024-00009\",\"case_id\":1,\"vtype_id\":1,\"optr_id\":1,\"terminal_id\":1,\"group_id\":10,\"plate_no\":\"ABC-123\",\"cr_no\":\"07071666\",\"engine_no\":\"E08201765\",\"chassis_no\":\"EYF07982925\",\"created_at\":\"2024-07-29 11:28:38\"}; New values: {\"plate_no\":\"ABC-123\",\"case_id\":\"5\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"7\",\"group_id\":\"10\",\"cr_no\":\"07071666\",\"engine_no\":\"E08201765\",\"chassis_no\":\"EYF07982925\"}', '2024-07-31 14:57:33', NULL),
(515, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":6,\"veh_id\":\"V2024-00005\",\"case_id\":3,\"vtype_id\":1,\"optr_id\":1,\"terminal_id\":3,\"group_id\":1,\"plate_no\":\"PSG-1234\",\"cr_no\":\"asdas\",\"engine_no\":\"dasdasda\",\"chassis_no\":\"sdasdas\",\"created_at\":\"2024-07-31 22:30:38\"}; New values: {\"plate_no\":\"PSG-1234\",\"case_id\":\"5\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"7\",\"group_id\":\"1\",\"cr_no\":\"asdas\",\"engine_no\":\"dasdasda\",\"chassis_no\":\"sdasdas\"}', '2024-07-31 14:58:21', NULL),
(516, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":15,\"veh_id\":\"V2024-00008\",\"case_id\":5,\"vtype_id\":2,\"optr_id\":18,\"terminal_id\":13,\"group_id\":14,\"plate_no\":\"EYF-707\",\"cr_no\":\"07071981\",\"engine_no\":\"E07071981\",\"chassis_no\":\"EYF07071981\",\"created_at\":\"2024-07-31 22:54:40\"}; New values: {\"plate_no\":\"EYF-707\",\"case_id\":\"2\",\"vtype_id\":\"2\",\"optr_id\":\"18\",\"terminal_id\":\"13\",\"group_id\":\"14\",\"cr_no\":\"07071981\",\"engine_no\":\"E07071981\",\"chassis_no\":\"EYF07071981\"}', '2024-07-31 14:59:31', NULL),
(517, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":16,\"veh_id\":\"V2024-00009\",\"case_id\":5,\"vtype_id\":1,\"optr_id\":1,\"terminal_id\":7,\"group_id\":10,\"plate_no\":\"ABC-123\",\"cr_no\":\"07071666\",\"engine_no\":\"E08201765\",\"chassis_no\":\"EYF07982925\",\"created_at\":\"2024-07-31 22:57:33\"}; New values: {\"plate_no\":\"ABC-123\",\"case_id\":\"8\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"14\",\"group_id\":\"10\",\"cr_no\":\"07071666\",\"engine_no\":\"E08201765\",\"chassis_no\":\"EYF07982925\"}', '2024-07-31 14:59:40', NULL),
(518, 49, 'Edit', 'Edited record in vehicle_unit. Old values: {\"id\":16,\"veh_id\":\"V2024-00009\",\"case_id\":8,\"vtype_id\":1,\"optr_id\":1,\"terminal_id\":14,\"group_id\":10,\"plate_no\":\"ABC-123\",\"cr_no\":\"07071666\",\"engine_no\":\"E08201765\",\"chassis_no\":\"EYF07982925\",\"created_at\":\"2024-07-31 22:59:40\"}; New values: {\"plate_no\":\"ABC-123\",\"case_id\":\"9\",\"vtype_id\":\"1\",\"optr_id\":\"1\",\"terminal_id\":\"12\",\"group_id\":\"10\",\"cr_no\":\"07071666\",\"engine_no\":\"E08201765\",\"chassis_no\":\"EYF07982925\"}', '2024-07-31 14:59:48', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `carousel_images`
--

CREATE TABLE `carousel_images` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `image_type` enum('announcement','event','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `carousel_images`
--

INSERT INTO `carousel_images` (`id`, `image_path`, `image_type`) VALUES
(3, 'announcement.jpg', 'event'),
(7, 'dpwh.jpg', 'announcement'),
(8, 'manalobridge.jpg', 'announcement'),
(9, 'meralco.jpg', 'announcement'),
(10, 'tempoclose.jpg', 'announcement'),
(11, 'civicparade.jpg', 'event'),
(12, 'grandparade.jpg', 'event');

-- --------------------------------------------------------

--
-- Table structure for table `cases`
--

CREATE TABLE `cases` (
  `id` int(11) NOT NULL,
  `case_id` varchar(255) NOT NULL,
  `route_id` int(11) DEFAULT NULL,
  `case_no` varchar(255) DEFAULT NULL,
  `case_granted` date DEFAULT NULL,
  `case_expire` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cases`
--

INSERT INTO `cases` (`id`, `case_id`, `route_id`, `case_no`, `case_granted`, `case_expire`) VALUES
(1, 'C2024-00001', 1, '1981-0820', '0000-00-00', '0000-00-00'),
(2, 'C2024-00002', 2, '1981-0821\n', '2006-08-20', '2010-12-01'),
(3, 'C2024-00003', 3, '2003-1234', '2024-06-30', '2024-08-10'),
(4, 'C2024-00004', 4, '1985-5438', '2024-06-30', '2024-08-10'),
(5, 'C2024-00005', 5, '1998-2483', '2024-06-30', '2024-08-08'),
(6, 'C2024-00006', 10, '2001-4268', '2024-06-30', '2024-07-30'),
(7, 'C2024-00007', 11, '2005-3548', '2024-06-30', '2024-09-06'),
(8, 'C2024-00008', 12, '2012-4527', '2024-05-26', '2024-10-12'),
(9, 'C2024-00009', 13, '2020-1621', '2024-07-17', '2024-12-07'),
(10, 'C2024-00010', 14, '1999-3501', '2024-01-28', '2025-01-11');

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `id` int(11) NOT NULL,
  `driver_id` varchar(255) NOT NULL,
  `driver_name` varchar(50) DEFAULT NULL,
  `driver_address` varchar(100) DEFAULT NULL,
  `driver_contact` varchar(20) DEFAULT NULL,
  `resi_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`id`, `driver_id`, `driver_name`, `driver_address`, `driver_contact`, `resi_id`, `created_at`, `updated_at`) VALUES
(1, 'DRV-2024-0001', 'Daniel Padilla', 'De Castro Brgy Sta Lucia', '09911234567', 1, '2023-12-09 02:10:03', '2024-07-24 04:01:45'),
(2, 'DRV-2024-0002', 'Jericho Rosales', 'Crossing Terminal - Ortigas Extension', '09911234587', 2, '2023-12-09 05:46:17', '2024-07-23 12:20:29'),
(3, 'DRV-2024-0003', 'Coco Martin', 'Ugong Pasig City', '09912834567', 1, '2023-12-11 12:05:40', '2024-07-23 12:20:32'),
(4, 'DRV-2024-0004', 'Aga Muhlach', 'Ugong', '09123323456', 1, '2024-07-23 12:17:35', '2024-07-23 12:20:35'),
(7, 'DRV-2024-0005', 'Rodrigo Duterte', 'Eusebio Bliss 1 Maybunga Pasig City', '09878456132', 1, '2024-07-29 00:50:17', '2024-07-29 00:50:17'),
(8, 'DRV-2024-0006', 'John Regala', 'PIneda, Pasig City', '09878451111', 1, '2024-07-29 00:50:29', '2024-07-29 00:50:29'),
(9, 'DRV-2024-0007', 'Paul Salas', 'Wakwak Mandaluyong City', '09878456213', 2, '2024-07-29 00:50:48', '2024-07-29 00:50:48'),
(10, 'DRV-2024-0008', 'Buboy Villar', 'Cuaresma St. Kalawaan Pasig City', '09878456213', 1, '2024-07-29 00:50:59', '2024-07-29 00:50:59'),
(11, 'DRV-2024-0009', 'Mikael Daez', 'Villa alfonso bambang Pasig City', '09878450000', 1, '2024-07-29 00:51:12', '2024-07-29 00:51:12'),
(12, 'DRV-2024-0010', 'Kokoy Delos Reyes', 'Centenial II Nagpayong Pinagbuhatan Pasig City', '09878452222', 1, '2024-07-29 00:51:23', '2024-07-29 00:51:23');

-- --------------------------------------------------------

--
-- Table structure for table `group_officers`
--

CREATE TABLE `group_officers` (
  `id` int(11) NOT NULL,
  `officer_id` varchar(255) NOT NULL COMMENT 'Do not add. Automated with triggers. Only edit the year after insertion',
  `group_id` int(11) NOT NULL,
  `officer_name` varchar(255) DEFAULT NULL,
  `officer_position` varchar(255) DEFAULT NULL,
  `officer_contact` varchar(20) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `group_officers`
--

INSERT INTO `group_officers` (`id`, `officer_id`, `group_id`, `officer_name`, `officer_position`, `officer_contact`, `date`) VALUES
(1, 'GO-023-001', 1, 'Eddie Garcia', 'President', '09123456789', '2024-07-26 02:41:48'),
(2, 'GO-023-002', 1, 'Ana Capri', 'Vice-President', '09887410258', '2024-07-26 02:41:58'),
(3, 'GO-023-003', 2, 'Dondon Hontiveros', 'President', '09147852369', '2024-07-26 02:42:00'),
(15, 'GO-2024-015', 8, 'Ramon Revilla Jr.', 'President', NULL, '2024-07-29 00:25:53'),
(16, 'GO-2024-016', 9, 'Robin Padilla', 'President', NULL, '2024-07-29 00:26:06'),
(17, 'GO-2024-017', 10, 'Jinggoy Estrada', 'President', NULL, '2024-07-29 00:26:20'),
(18, 'GO-2024-018', 11, 'Win Gatchalian', 'President', NULL, '2024-07-29 00:26:44'),
(19, 'GO-2024-019', 12, 'Ruben Velasquez', 'Chairman', NULL, '2024-07-29 00:26:58'),
(20, 'GO-2024-020', 13, 'Ramil Padrigo', 'Chairman', NULL, '2024-07-29 00:27:28'),
(21, 'GO-2024-021', 14, 'Basil Valdez', 'Chairman', NULL, '2024-07-29 00:27:53'),
(22, 'GO-2024-022', 15, 'George Estregan', 'President', NULL, '2024-07-29 00:29:08');

--
-- Triggers `group_officers`
--
DELIMITER $$
CREATE TRIGGER `before_insert_group_officers` BEFORE INSERT ON `group_officers` FOR EACH ROW BEGIN
    DECLARE current_year CHAR(4);
    DECLARE auto_increment_value INT;
    DECLARE padded_auto_increment_value CHAR(5);

    SET current_year = YEAR(CURDATE());
    
    SELECT AUTO_INCREMENT INTO auto_increment_value
    FROM information_schema.TABLES
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'group_officers';

    SET padded_auto_increment_value = LPAD(auto_increment_value, 3, '0');
    SET NEW.officer_id = CONCAT('GO-', current_year,'-',padded_auto_increment_value);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `insp_clearance`
--

CREATE TABLE `insp_clearance` (
  `id` int(11) NOT NULL,
  `insp_id` varchar(255) NOT NULL,
  `terminal_id` int(11) DEFAULT NULL,
  `insp_date` date NOT NULL DEFAULT current_timestamp(),
  `officer_list` text DEFAULT NULL,
  `billboard` varchar(255) DEFAULT NULL,
  `comfort_room` varchar(255) DEFAULT NULL,
  `tenm_away` varchar(255) DEFAULT NULL,
  `lot_area` varchar(255) DEFAULT NULL,
  `waiting_shed` varchar(255) DEFAULT NULL,
  `xerox` varchar(255) NOT NULL,
  `insp_remark` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `insp_clearance`
--

INSERT INTO `insp_clearance` (`id`, `insp_id`, `terminal_id`, `insp_date`, `officer_list`, `billboard`, `comfort_room`, `tenm_away`, `lot_area`, `waiting_shed`, `xerox`, `insp_remark`) VALUES
(1, 'INSP-2024-001', 1, '2007-08-20', 'Complied', 'Complied', 'Complied', 'Complied', 'Complied', 'Complied', 'Complied', 'Billboard 4ft (W) x 8ft (L) - indicating the official list of officers, official route and fare {billboard} Comfort Room with sufficient water and ample lightning - one (1) Male / one (1) Female {comfort_room} Sketch map of the terminal (Area / vicinity road and inside) - with ten meters (10m) away from the corner / intersection {tenm_away} Actual photographs and pictures - with a lot area of 300 sqm. (minimum area) {lot_area} Waiting Shed - 10m (L) x 1.0m (W) - after the approval of permit within 30 days {waiting_shed} Xerox of OR, CR, Decision of each units');

-- --------------------------------------------------------

--
-- Table structure for table `operator`
--

CREATE TABLE `operator` (
  `id` int(11) NOT NULL,
  `optr_id` varchar(255) NOT NULL,
  `resi_id` int(11) DEFAULT NULL,
  `optr_name` varchar(255) DEFAULT NULL,
  `optr_add` varchar(255) DEFAULT NULL,
  `optr_contact` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `operator`
--

INSERT INTO `operator` (`id`, `optr_id`, `resi_id`, `optr_name`, `optr_add`, `optr_contact`) VALUES
(1, 'OPR2024-0001', 1, 'Boy Abunda', 'Palengke', '01234567891'),
(2, 'OPR2024-0002', 2, 'Samboy Lim', 'Simbahan', '09123456789'),
(3, 'OPR2024-0003', 1, 'Benjie Paras', 'Munisipyo', '09987456321'),
(13, 'OPR2024-0004', 1, 'Ricky Davao', 'Pineda, Pasig City', '09123456789'),
(14, 'OPR2024-0005', 2, 'Michael Jordan', 'Mandaluyong City', '09178886666'),
(15, 'OPR2024-0006', 1, 'Scottie Pippen', 'Caruncho Ave., Pasig Market, Pasig City', '09178882222'),
(16, 'OPR2024-0007', 1, 'Willie Revillame', 'A. Luna Pasig Simbahan, Malinao, Pasig City', '09178886555'),
(17, 'OPR2024-0008', 1, 'Chot Reyes', 'Urbano Velasco Pinagbuhatan Pasig City', '09178883333'),
(18, 'OPR2024-0009', 1, 'Tim Cone', 'F. Manalo near City Hall Malinao Pasig City', '09178884444'),
(19, 'OPR2024-0010', 1, 'Gerald Anderson', 'Ismar Kalawaan Pasig City', '09178899966');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `permission_id` int(11) NOT NULL,
  `permission_name` varchar(255) NOT NULL,
  `permission_desc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permission_id`, `permission_name`, `permission_desc`) VALUES
(1, 'Dashboard', 'View Dashboard'),
(2, 'PUV Information', 'View PUV Information'),
(3, 'Public Transport', 'View Public Transport'),
(4, 'Audit Logs', 'View Audit Logs'),
(5, 'User Accounts', 'View User Accounts'),
(6, 'Role Access', 'View Role Access'),
(7, 'User Reports', 'View User Reports'),
(8, 'Signatory', 'View Signatory'),
(9, 'About', 'View About'),
(10, 'Carousel', 'Manage Carousel'),
(11, 'ADD', 'Add PUV Information'),
(12, 'EDIT', 'Edit PUV Information'),
(13, 'DELETE', 'Delete PUV Information'),
(14, 'PRINT', 'Print PUV Information'),
(15, 'ADD', 'Add Public Transport'),
(16, 'EDIT', 'Edit Public Transport'),
(17, 'DELETE', 'Delete Public Transport'),
(18, 'PRINT', 'Print Public Transport'),
(19, 'ADD', 'Add Audit Logs'),
(20, 'EDIT', 'Edit Audit Logs'),
(21, 'DELETE', 'Delete Audit Logs'),
(22, 'PRINT', 'Print Audit Logs'),
(23, 'ADD', 'Add User Accounts'),
(24, 'EDIT', 'Edit User Accounts'),
(25, 'DELETE', 'Delete User Accounts'),
(26, 'PRINT', 'Print User Accounts'),
(27, 'ADD', 'Add Role Access'),
(28, 'EDIT', 'Edit Role Access'),
(29, 'DELETE', 'Delete Role Access'),
(30, 'PRINT', 'Print Role Access'),
(31, 'ADD', 'Add User Reports'),
(32, 'EDIT', 'Edit User Reports'),
(33, 'DELETE', 'Delete User Reports'),
(34, 'PRINT', 'Print User Reports'),
(35, 'ADD', 'Add Signatory'),
(36, 'EDIT', 'Edit Signatory'),
(37, 'DELETE', 'Delete Signatory'),
(38, 'PRINT', 'Print Signatory'),
(40, 'Case Management', 'Case Management'),
(41, 'Vehicle Type Management', 'Vehicle Type Management'),
(42, 'Inspection Clearance Management', 'Inspection Clearance Management'),
(43, 'Resolution Management', 'Resolution Management'),
(44, 'ADD', 'Add Case'),
(45, 'EDIT', 'Edit Case'),
(46, 'DELETE', 'Delete Case'),
(47, 'PRINT', 'Print Case'),
(48, 'ADD', 'Add Vehicle Type'),
(49, 'EDIT', 'Edit Vehicle Type'),
(50, 'DELETE', 'Delete Vehicle Type'),
(51, 'PRINT', 'Print Vehicle Type'),
(52, 'ADD', 'Add Inspection Clearance'),
(53, 'EDIT', 'Edit Inspection Clearance'),
(54, 'DELETE', 'Delete Inspection Clearance'),
(55, 'PRINT', 'Print Inspection Clearance'),
(56, 'ADD', 'Add Resolution'),
(57, 'EDIT', 'Edit Resolution'),
(58, 'DELETE', 'Delete Resolution'),
(59, 'PRINT', 'Print Resolution');

-- --------------------------------------------------------

--
-- Table structure for table `residency`
--

CREATE TABLE `residency` (
  `id` int(11) NOT NULL,
  `resi_id` varchar(255) NOT NULL,
  `resi_code` varchar(255) DEFAULT NULL,
  `resi_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `residency`
--

INSERT INTO `residency` (`id`, `resi_id`, `resi_code`, `resi_name`) VALUES
(1, 'CITY-0001', 'PSG', 'Resident of Pasig City'),
(2, 'CITY-0002', 'Non-PSG', 'Not Resident of Pasig City');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'admin'),
(2, 'encoder'),
(3, 'approver');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `permission_id`) VALUES
(620, 3, 7),
(621, 3, 8),
(622, 3, 9),
(734, 2, 1),
(735, 2, 2),
(736, 2, 3),
(737, 2, 9),
(814, 1, 1),
(815, 1, 2),
(816, 1, 3),
(817, 1, 4),
(818, 1, 5),
(819, 1, 6),
(820, 1, 7),
(821, 1, 8),
(822, 1, 9),
(823, 1, 10),
(824, 1, 40),
(825, 1, 41),
(826, 1, 42),
(827, 1, 43),
(828, 1, 11),
(829, 1, 12),
(830, 1, 13),
(831, 1, 14),
(832, 1, 15),
(833, 1, 16),
(834, 1, 17),
(835, 1, 18),
(836, 1, 19),
(837, 1, 20),
(838, 1, 21),
(839, 1, 22),
(840, 1, 23),
(841, 1, 24),
(842, 1, 25),
(843, 1, 26),
(844, 1, 27),
(845, 1, 28),
(846, 1, 29),
(847, 1, 30),
(848, 1, 31),
(849, 1, 32),
(850, 1, 33),
(851, 1, 34),
(852, 1, 35),
(853, 1, 36),
(854, 1, 37),
(855, 1, 38),
(856, 1, 44),
(857, 1, 45),
(858, 1, 46),
(859, 1, 47),
(860, 1, 48),
(861, 1, 49),
(862, 1, 50),
(863, 1, 51),
(864, 1, 52),
(865, 1, 53),
(866, 1, 54),
(867, 1, 55),
(868, 1, 56),
(869, 1, 57),
(870, 1, 58),
(871, 1, 59);

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

CREATE TABLE `route` (
  `id` int(11) NOT NULL,
  `route_id` varchar(255) NOT NULL,
  `route_struct` text DEFAULT NULL,
  `route_line` text DEFAULT NULL,
  `route_modify` text DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `route`
--

INSERT INTO `route` (`id`, `route_id`, `route_struct`, `route_line`, `route_modify`, `date`) VALUES
(1, 'R2023-00001', 'Ugong Terminal - C5 - Julia Vargas Bridge - Dr. Sixto Avenue - Pasig Market Terminal', 'Pasig Market via Ugong', '', '2023-12-09 06:45:18'),
(2, 'R2023-00002', 'Quiapo - Mandaluyong Shaw Blvd Pasig - Pasig Market Terminal', 'Pasig Market via Quiapo		', '', '2023-12-09 06:46:18'),
(3, 'R2023-00003', 'Taguig - San Joaquin Pasig - Pasig Market Terminal', 'Pasig Market via Taguig', '', '2023-12-09 06:46:53'),
(4, 'R2023-00004', 'Pasig Market - Caruncho Avenue - Shaw Blvd - Quiapo', 'Quiapo via Pasig Market ', '', '2023-12-09 06:47:04'),
(5, 'R2023-00005', 'Cubao - Libis - Ortigas Extension - Rosario', 'Rosario via Cubao', '', '2023-12-11 11:38:49'),
(10, 'R2024-00001', 'Pasig San Joaquin - Dr. Sixto Avenue - Rotonda - Ortigas Center', 'Pasig San Joaquin - Robinson\'s Galleria', NULL, '2024-07-29 00:18:33'),
(11, 'R2024-00002', 'Pasig (Santolan) – SM Megamall - Robinson', 'Pasig (Santolan) – SM Megamall via Robinson', NULL, '2024-07-29 00:20:04'),
(12, 'R2024-00003', 'Pasig – SM Megamall - Robinson’s Galleria', 'Pasig – SM Megamall via Robinson’s Galleria', NULL, '2024-07-29 00:20:28'),
(13, 'R2024-00004', 'Cubao - Rosario - Sta. Lucia', 'Cubao via Rosario - Sta. Lucia', NULL, '2024-07-29 00:20:52'),
(14, 'R2024-00005', 'Caruncho Ave., Pasig City and Angono Public Market...', 'Angono via Pasig Market', NULL, '2024-07-29 00:21:29');

-- --------------------------------------------------------

--
-- Table structure for table `terminal`
--

CREATE TABLE `terminal` (
  `id` int(11) NOT NULL,
  `terminal_id` varchar(255) NOT NULL,
  `terminal_name` varchar(255) DEFAULT NULL,
  `terminal_add` varchar(255) DEFAULT NULL,
  `route_id` int(11) DEFAULT NULL,
  `insp_id` int(11) NOT NULL,
  `reso_id` int(5) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `busi_permit` varchar(20) DEFAULT NULL,
  `busi_date` date DEFAULT NULL,
  `busi_expire` date DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `terminal`
--

INSERT INTO `terminal` (`id`, `terminal_id`, `terminal_name`, `terminal_add`, `route_id`, `insp_id`, `reso_id`, `group_id`, `busi_permit`, `busi_date`, `busi_expire`, `date`) VALUES
(1, 'T0001', 'Bulls Terminal', 'Pasig Market, Pasig City', 1, 1, 1, 2, 'PSG-1234567', '2024-07-01', '2024-07-31', '2024-07-23 07:27:53'),
(3, 'T0002', 'Lakers Terminal', 'Urbano Velasco, Pasig City	', 3, 1, 2, 1, 'asdasdasda', '2019-01-24', '2028-11-16', '2024-07-24 06:18:58'),
(7, 'T0003', 'Mavericks Terminal', 'Urbano Ave., Pinagbuhatan Pasig City', 5, 1, 1, 8, 'PSG-00533570', '2024-01-01', '2024-12-31', '2024-07-29 00:30:21'),
(8, 'T0004', 'Warriors Terminal', 'Urbano Ave., Pinagbuhatan Pasig City', 10, 1, 1, 9, 'PSG-00554569', '2024-01-01', '2024-12-31', '2024-07-29 00:31:04'),
(9, 'T0005', 'Orlando Terminal', 'Caruncho Ave, Malinao Pasig City', 11, 1, 2, 10, 'PSG-00554570', '2024-01-01', '2024-12-31', '2024-07-29 00:31:44'),
(10, 'T0006', 'PasMarTag Terminal', 'F. Manalo Santo Tomas Pasig City', 13, 1, 1, 11, 'PSG-00554534', '2024-01-01', '2024-12-31', '2024-07-29 00:33:09'),
(11, 'T0007', 'AngPas Market  Terminal', 'Pineda Pasig City', 14, 1, 1, 12, 'PSG-00588569', '2024-01-01', '2024-12-31', '2024-07-29 00:34:18'),
(12, 'T0008', 'Kamao Terminal', 'Sta Lucia Pasig City', 13, 1, 1, 13, 'PSG-02854569', '2024-01-01', '2024-12-31', '2024-07-29 00:35:16'),
(13, 'T0009', 'Utah Jazz Terminal', 'Life Homes Manggahan Pasig City', 2, 1, 2, 14, 'PSG-12377569', '2024-01-01', '2024-12-31', '2024-07-31 14:59:18'),
(14, 'T0010', 'PPRDOTA', 'Bambang Pasig City', 12, 1, 1, 15, 'PSG-01154570', '2024-01-01', '2024-12-31', '2024-07-29 00:48:53');

-- --------------------------------------------------------

--
-- Table structure for table `term_approval`
--

CREATE TABLE `term_approval` (
  `id` int(11) NOT NULL,
  `reso_id` varchar(255) NOT NULL COMMENT 'Do not add. Automated with triggers. Only edit the year after insertion.',
  `insp_id` int(11) DEFAULT NULL,
  `reso_name` varchar(255) DEFAULT NULL,
  `veri_clear` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `term_approval`
--

INSERT INTO `term_approval` (`id`, `reso_id`, `insp_id`, `reso_name`, `veri_clear`) VALUES
(1, 'TERM-2006-001', 1, 'Reso No. 23, Series of 2006', 'Ok'),
(2, 'TERM-2024-002', 1, 'Reso No. 69, Series of 2024', 'Ok');

--
-- Triggers `term_approval`
--
DELIMITER $$
CREATE TRIGGER `before_insert_term_approval` BEFORE INSERT ON `term_approval` FOR EACH ROW BEGIN
    DECLARE current_year CHAR(4);
    DECLARE auto_increment_value INT;
    DECLARE padded_auto_increment_value CHAR(5);

    SET current_year = YEAR(CURDATE());

    SELECT AUTO_INCREMENT INTO auto_increment_value
    FROM information_schema.TABLES
    WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'term_approval';

    SET padded_auto_increment_value = LPAD(auto_increment_value, 3, '0');
    SET NEW.reso_id = CONCAT('TERM-', current_year,'-', padded_auto_increment_value);
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `trans_group`
--

CREATE TABLE `trans_group` (
  `id` int(11) NOT NULL,
  `group_id` varchar(255) NOT NULL,
  `group_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trans_group`
--

INSERT INTO `trans_group` (`id`, `group_id`, `group_name`) VALUES
(1, 'GRP-2024-001', 'Sm East Ortigas'),
(2, 'GRP-2024-002', 'PUKSA'),
(8, 'GRP-2024-003', 'Manibela'),
(9, 'GRP-2024-004', 'PISTON'),
(10, 'GRP-2024-005', 'JEEPNEY'),
(11, 'GRP-2024-006', 'TARIPA'),
(12, 'GRP-2024-007', 'PAMAQODA'),
(13, 'GRP-2024-008', 'CURODA'),
(14, 'GRP-2024-009', 'PPJODA'),
(15, 'GRP-2024-010', 'MJPUV');

-- --------------------------------------------------------

--
-- Table structure for table `unit_type`
--

CREATE TABLE `unit_type` (
  `vtype_id` int(11) NOT NULL,
  `modal` varchar(255) DEFAULT NULL,
  `modal_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unit_type`
--

INSERT INTO `unit_type` (`vtype_id`, `modal`, `modal_name`) VALUES
(1, 'TPUJ', 'Traditional Public Utility Vehicle'),
(2, 'TUVE', 'Traditional Utility Vehicle Express'),
(3, 'MPUJ', 'Modern Public Utility Vehicle');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` int(11) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `verification_code` varchar(10) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'activated',
  `reset_code` varchar(255) DEFAULT NULL,
  `last_code_sent_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `name`, `username`, `password`, `email`, `role`, `picture`, `verification_code`, `status`, `reset_code`, `last_code_sent_at`, `remember_token`) VALUES
(20, 'Ivana Alawi', 'ivana', '$2y$10$Gs2.qc1dr44t2tN93NbUfe/nW5MyqTiS5Yde/LYT7Se5kA2PypI2G', 'jerryobico9680@gmail.com', 1, 'uploads/ivana.jpg', '976062', 'inactive', NULL, NULL, ''),
(23, 'Bea Binene', 'bea', '$2y$10$7OtzjRTvKD7fQ74gUkECdOs/yio6t4Af0VJBRv53Pb6NY.g4bOmSC', 'obico_jerry@plpasig.edu.ph', 2, 'uploads/bea.jpg', '392894', 'inactive', NULL, NULL, ''),
(37, 'Azi Acosta', 'azi', '$2y$10$vHEjuTeeTBEq0iJL.246H.x3N5ly/hZov3lVZhvo7OJawOlbcLgBu', 'obico_jerry@plpasig.edu.ph', 2, 'uploads/azi.jpg', NULL, 'inactive', NULL, NULL, ''),
(49, 'Angeli Khang', 'angeli', '$2y$10$n9lsl/gEw.UUYx7rEE9Pde5g0nLrCz1cTWAig//7m/vpjCcm7CHci', 'jerry.obico@gmail.com', 1, 'uploads/angeli.jpg', '853592', 'activated', NULL, NULL, '02def14b117c367dd2bd470d79be46f56c8cede6d89430abb88efa99f4e6a2e4'),
(50, 'Jerry Obico', 'jerry', '$2y$10$05RwyIuKbxB1m3aEOegocOGH.sI8gk3dQCmRTiiA/fnzYgd7.aQ2i', 'obico.jerry@hotmail.com', 3, NULL, '483611', 'activated', NULL, NULL, ''),
(51, 'Jarvis Obico', 'jarvis', '$2y$10$vUy94XCJm2kLi/SWaT.20eZtRTI6.c0otUvXF5QXF5UWYNwVyQlRG', 'obico.jerry@hotmail.com', 2, NULL, '143862', 'activated', NULL, NULL, ''),
(52, 'Geran Alvarez', 'geran', '$2y$10$3Rk4Dzk8SX7Nc8LOar3YRevP9hzjQRDvnFat537/1gADwvpN.A.VK', 'alvarez_geran@plpasig.edu.ph', 2, NULL, '358329', 'inactive', NULL, NULL, ''),
(104, 'asdsa', 'sample', '$2y$10$mPvJmIM4nPteukYb/9U2buclyJOMk0SqJZ8DYyRPcQ6wG5yP4o9Xm', 'docotkat@gmail.com', 1, '', '8201a15dec', 'inactive', NULL, NULL, NULL),
(112, 'adsad', 'sam', '$2y$10$/pZnD2y8KQblRajh2agc4OB0QLTm6ijamDgp4z.EKjYE67CcArav.', 'docs1502@gmail.com', 2, NULL, '163698', 'activated', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `userslogin`
--

CREATE TABLE `userslogin` (
  `userloginid` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `datelogin` datetime DEFAULT NULL,
  `datelogout` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_driver`
--

CREATE TABLE `vehicle_driver` (
  `vehicle_driver_id` int(11) NOT NULL,
  `veh_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_driver`
--

INSERT INTO `vehicle_driver` (`vehicle_driver_id`, `veh_id`, `driver_id`) VALUES
(99, 13, 2),
(101, 17, 8),
(102, 4, 3),
(105, 14, 12),
(107, 6, 1),
(108, 6, 3),
(109, 15, 11),
(111, 16, 10);

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_unit`
--

CREATE TABLE `vehicle_unit` (
  `id` int(11) NOT NULL,
  `veh_id` varchar(255) NOT NULL,
  `case_id` int(11) DEFAULT NULL,
  `vtype_id` int(11) DEFAULT NULL,
  `optr_id` int(11) DEFAULT NULL,
  `terminal_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `plate_no` varchar(255) DEFAULT NULL,
  `cr_no` varchar(255) DEFAULT NULL,
  `engine_no` varchar(255) DEFAULT NULL,
  `chassis_no` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_unit`
--

INSERT INTO `vehicle_unit` (`id`, `veh_id`, `case_id`, `vtype_id`, `optr_id`, `terminal_id`, `group_id`, `plate_no`, `cr_no`, `engine_no`, `chassis_no`, `created_at`) VALUES
(4, 'V2024-00004', 3, 1, 1, 3, 1, 'GHG-4758', 'SDAS', 'DSADASDSA', 'DASASDS', '2024-07-31 14:34:36'),
(6, 'V2024-00005', 5, 1, 1, 7, 1, 'PSG-1234', 'asdas', 'dasdasda', 'sdasdas', '2024-07-31 14:58:21'),
(13, 'V2024-00006', 1, 2, 2, 1, 1, 'dasdsadsa', 'asds', 'adadsa', 'asdasdasda', '2024-07-28 10:58:29'),
(14, 'V2024-00007', 8, 1, 19, 14, 15, 'UCF-820', '08201981', 'E08201981', 'UCF08201981', '2024-07-31 14:53:28'),
(15, 'V2024-00008', 2, 2, 18, 13, 14, 'EYF-707', '07071981', 'E07071981', 'EYF07071981', '2024-07-31 14:59:31'),
(16, 'V2024-00009', 9, 1, 1, 12, 10, 'ABC-123', '07071666', 'E08201765', 'EYF07982925', '2024-07-31 14:59:48'),
(17, 'V2024-00010', 7, 1, 1, 9, 10, 'FUC-028', '07071981002', 'E08201765003', 'EYF07071321004', '2024-07-31 14:53:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `carousel_images`
--
ALTER TABLE `carousel_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cases`
--
ALTER TABLE `cases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `case_id` (`case_id`),
  ADD KEY `route_id` (`route_id`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `driver_id` (`driver_id`),
  ADD KEY `resi_id` (`resi_id`);

--
-- Indexes for table `group_officers`
--
ALTER TABLE `group_officers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `officer_id` (`officer_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `insp_clearance`
--
ALTER TABLE `insp_clearance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `insp_id` (`insp_id`),
  ADD KEY `terminal_id` (`terminal_id`);

--
-- Indexes for table `operator`
--
ALTER TABLE `operator`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `optr_id` (`optr_id`),
  ADD KEY `resi_id` (`resi_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `residency`
--
ALTER TABLE `residency`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `resi_id` (`resi_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `route`
--
ALTER TABLE `route`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `route_id` (`route_id`);

--
-- Indexes for table `terminal`
--
ALTER TABLE `terminal`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `terminal_id` (`terminal_id`),
  ADD KEY `reso_id` (`reso_id`),
  ADD KEY `insp_id` (`insp_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `route_id` (`route_id`);

--
-- Indexes for table `term_approval`
--
ALTER TABLE `term_approval`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reso_id` (`reso_id`),
  ADD KEY `insp_id` (`insp_id`);

--
-- Indexes for table `trans_group`
--
ALTER TABLE `trans_group`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_id` (`group_id`);

--
-- Indexes for table `unit_type`
--
ALTER TABLE `unit_type`
  ADD PRIMARY KEY (`vtype_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD KEY `role` (`role`);

--
-- Indexes for table `userslogin`
--
ALTER TABLE `userslogin`
  ADD PRIMARY KEY (`userloginid`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `vehicle_driver`
--
ALTER TABLE `vehicle_driver`
  ADD PRIMARY KEY (`vehicle_driver_id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `veh_id` (`veh_id`);

--
-- Indexes for table `vehicle_unit`
--
ALTER TABLE `vehicle_unit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `veh_id` (`veh_id`),
  ADD KEY `case_id` (`case_id`),
  ADD KEY `vtype_id` (`vtype_id`),
  ADD KEY `optr_id` (`optr_id`),
  ADD KEY `terminal_id` (`terminal_id`),
  ADD KEY `group_id` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=519;

--
-- AUTO_INCREMENT for table `carousel_images`
--
ALTER TABLE `carousel_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cases`
--
ALTER TABLE `cases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `group_officers`
--
ALTER TABLE `group_officers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `insp_clearance`
--
ALTER TABLE `insp_clearance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `operator`
--
ALTER TABLE `operator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `residency`
--
ALTER TABLE `residency`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=872;

--
-- AUTO_INCREMENT for table `route`
--
ALTER TABLE `route`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `terminal`
--
ALTER TABLE `terminal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `term_approval`
--
ALTER TABLE `term_approval`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `trans_group`
--
ALTER TABLE `trans_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `unit_type`
--
ALTER TABLE `unit_type`
  MODIFY `vtype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `userslogin`
--
ALTER TABLE `userslogin`
  MODIFY `userloginid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `vehicle_driver`
--
ALTER TABLE `vehicle_driver`
  MODIFY `vehicle_driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `vehicle_unit`
--
ALTER TABLE `vehicle_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD CONSTRAINT `audit_log_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`),
  ADD CONSTRAINT `audit_log_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`);

--
-- Constraints for table `cases`
--
ALTER TABLE `cases`
  ADD CONSTRAINT `cases_ibfk_1` FOREIGN KEY (`route_id`) REFERENCES `route` (`id`);

--
-- Constraints for table `driver`
--
ALTER TABLE `driver`
  ADD CONSTRAINT `driver_ibfk_1` FOREIGN KEY (`resi_id`) REFERENCES `residency` (`id`);

--
-- Constraints for table `group_officers`
--
ALTER TABLE `group_officers`
  ADD CONSTRAINT `group_officers_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `trans_group` (`id`);

--
-- Constraints for table `insp_clearance`
--
ALTER TABLE `insp_clearance`
  ADD CONSTRAINT `insp_clearance_ibfk_1` FOREIGN KEY (`terminal_id`) REFERENCES `terminal` (`id`);

--
-- Constraints for table `operator`
--
ALTER TABLE `operator`
  ADD CONSTRAINT `operator_ibfk_1` FOREIGN KEY (`resi_id`) REFERENCES `residency` (`id`);

--
-- Constraints for table `terminal`
--
ALTER TABLE `terminal`
  ADD CONSTRAINT `terminal_ibfk_2` FOREIGN KEY (`reso_id`) REFERENCES `term_approval` (`id`),
  ADD CONSTRAINT `terminal_ibfk_4` FOREIGN KEY (`insp_id`) REFERENCES `insp_clearance` (`id`),
  ADD CONSTRAINT `terminal_ibfk_5` FOREIGN KEY (`group_id`) REFERENCES `trans_group` (`id`),
  ADD CONSTRAINT `terminal_ibfk_6` FOREIGN KEY (`route_id`) REFERENCES `route` (`id`);

--
-- Constraints for table `term_approval`
--
ALTER TABLE `term_approval`
  ADD CONSTRAINT `term_approval_ibfk_1` FOREIGN KEY (`insp_id`) REFERENCES `insp_clearance` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role`) REFERENCES `roles` (`role_id`);

--
-- Constraints for table `userslogin`
--
ALTER TABLE `userslogin`
  ADD CONSTRAINT `userslogin_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `users` (`userid`);

--
-- Constraints for table `vehicle_driver`
--
ALTER TABLE `vehicle_driver`
  ADD CONSTRAINT `vehicle_driver_ibfk_1` FOREIGN KEY (`veh_id`) REFERENCES `vehicle_unit` (`id`),
  ADD CONSTRAINT `vehicle_driver_ibfk_2` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`id`);

--
-- Constraints for table `vehicle_unit`
--
ALTER TABLE `vehicle_unit`
  ADD CONSTRAINT `vehicle_unit_ibfk_1` FOREIGN KEY (`case_id`) REFERENCES `cases` (`id`),
  ADD CONSTRAINT `vehicle_unit_ibfk_2` FOREIGN KEY (`vtype_id`) REFERENCES `unit_type` (`vtype_id`),
  ADD CONSTRAINT `vehicle_unit_ibfk_3` FOREIGN KEY (`optr_id`) REFERENCES `operator` (`id`),
  ADD CONSTRAINT `vehicle_unit_ibfk_4` FOREIGN KEY (`terminal_id`) REFERENCES `terminal` (`id`),
  ADD CONSTRAINT `vehicle_unit_ibfk_5` FOREIGN KEY (`group_id`) REFERENCES `trans_group` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
