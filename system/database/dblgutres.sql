-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 18, 2024 at 04:28 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dblgutres`
--

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `driver_id` varchar(15) NOT NULL,
  `driver_name` varchar(50) DEFAULT NULL,
  `driver_address` varchar(100) DEFAULT NULL,
  `driver_contact` varchar(20) DEFAULT NULL,
  `residency_id` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`driver_id`, `driver_name`, `driver_address`, `driver_contact`, `residency_id`, `created_at`, `updated_at`) VALUES
('DRV-003-2023', 'Douglas Arthur', 'Balagbag Quezon City', '09992223315', 'CITY-0040', '2023-10-12 05:47:12', '2023-10-12 05:47:12'),
('DRV-2024-0001', 'Daniel Padilla', 'De Castro Brgy Sta Lucia', '09911234567', '2024-01-0001', '2023-12-09 02:10:03', '2023-12-09 02:10:03'),
('DRV-2024-0002', 'Jericho Rosales', 'Crossing Terminal - Ortigas Extension', '09911234587', '2024-01-0002', '2023-12-09 05:46:17', '2023-12-09 05:46:17'),
('DRV-2024-0004', 'Coco Martin', 'Ugong Pasig City', '09912834567', '2024-02-0001', '2023-12-11 12:05:40', '2023-12-11 12:05:40');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `logidtbl` int(11) NOT NULL,
  `logdatetbl` timestamp NOT NULL DEFAULT current_timestamp(),
  `logmodetbl` varchar(50) DEFAULT NULL,
  `usridtbl` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `route`
--

CREATE TABLE `route` (
  `route_id` varchar(20) NOT NULL,
  `route_line` text DEFAULT NULL,
  `route_struct` text DEFAULT NULL,
  `route_modify` text DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `route`
--

INSERT INTO `route` (`route_id`, `route_line`, `route_struct`, `route_modify`, `date`) VALUES
('R2023-00001', 'Ugong Terminal - Pasig via Pasig Market Terminal', 'Pasig Market - Ugong', '', '2023-12-09 06:45:18'),
('R2023-00002', 'Quiapo - Pasig via Pasig Market Terminal', 'Pasig Market - Quiapo		', '', '2023-12-09 06:46:18'),
('R2023-00003', 'Taguig - Pasig via Pasig Market Terminal', 'Pasig Market - Taguig', '', '2023-12-09 06:46:53'),
('R2023-00004', 'Pasig-Quiapo', 'Quiapo - Pasig Market ', '', '2023-12-09 06:47:04'),
('R2023-00005', 'Cubao via Rosario', 'Rosario via Cubao', '', '2023-12-11 11:38:49');

-- --------------------------------------------------------

--
-- Table structure for table `terminal`
--

CREATE TABLE `terminal` (
  `terminal_id` varchar(20) NOT NULL,
  `terminal_name` varchar(255) DEFAULT NULL,
  `terminal_add` varchar(255) DEFAULT NULL,
  `route_id` varchar(20) DEFAULT NULL,
  `reso_id` varchar(20) DEFAULT NULL,
  `group_id` varchar(20) DEFAULT NULL,
  `busi_permit` varchar(20) DEFAULT NULL,
  `busi_date` date DEFAULT NULL,
  `busi_expire` date DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `terminal`
--

INSERT INTO `terminal` (`terminal_id`, `terminal_name`, `terminal_add`, `route_id`, `reso_id`, `group_id`, `busi_permit`, `busi_date`, `busi_expire`, `date`) VALUES
('T0001', 'Bulls Terminal', 'Pasig Market, Pasig City', 'R2023-00001', 'TERM-2006-001', 'GRP-023-001', 'PSG-1234567', '0000-00-00', '0000-00-00', '2024-01-11 14:33:48');

-- --------------------------------------------------------

--
-- Table structure for table `transgrp`
--

CREATE TABLE `transgrp` (
  `officer_id` varchar(20) NOT NULL,
  `officer_name` varchar(255) DEFAULT NULL,
  `officer_position` varchar(255) DEFAULT NULL,
  `officer_contact` varchar(20) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `usridtbl` int(11) NOT NULL,
  `fname` varchar(50) DEFAULT NULL,
  `lname` varchar(50) DEFAULT NULL,
  `user` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `confirm` varchar(50) DEFAULT NULL,
  `urole` varchar(50) DEFAULT NULL,
  `ustatus` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`usridtbl`, `fname`, `lname`, `user`, `password`, `confirm`, `urole`, `ustatus`, `created_at`, `updated_at`) VALUES
(19, 'Jerry', 'Obico', 'jerry', 'a1c5094b239f77840d06fc76a65edf82', 'a1c5094b239f77840d06fc76a65edf82', 'Admin', 'Active', '2023-10-10 00:51:18', '2023-10-10 00:51:18'),
(20, 'Jesaiah', 'Cabungcal', 'aya', '999a566fcfd0d8e0996ebc81710fbd03', '999a566fcfd0d8e0996ebc81710fbd03', 'Encoder', 'Active', '2023-10-10 08:18:09', '2023-10-10 08:18:09');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_unit`
--

CREATE TABLE `vehicle_unit` (
  `vehicle_id` varchar(255) NOT NULL,
  `plate_no` varchar(255) DEFAULT NULL,
  `cr_no` varchar(255) DEFAULT NULL,
  `engine_no` varchar(255) DEFAULT NULL,
  `chassis_no` varchar(255) DEFAULT NULL,
  `case_id` varchar(255) DEFAULT NULL,
  `vtype_id` varchar(255) DEFAULT NULL,
  `operator_id` varchar(255) DEFAULT NULL,
  `terminal_id` varchar(255) DEFAULT NULL,
  `group_id` varchar(255) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`driver_id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`logidtbl`),
  ADD KEY `usridtbl` (`usridtbl`);

--
-- Indexes for table `route`
--
ALTER TABLE `route`
  ADD PRIMARY KEY (`route_id`);

--
-- Indexes for table `terminal`
--
ALTER TABLE `terminal`
  ADD PRIMARY KEY (`terminal_id`);

--
-- Indexes for table `transgrp`
--
ALTER TABLE `transgrp`
  ADD PRIMARY KEY (`officer_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`usridtbl`);

--
-- Indexes for table `vehicle_unit`
--
ALTER TABLE `vehicle_unit`
  ADD PRIMARY KEY (`vehicle_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `logidtbl` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `usridtbl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`usridtbl`) REFERENCES `user` (`usridtbl`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
