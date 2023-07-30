-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2021 at 10:49 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `naoria_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_type`
--

CREATE TABLE `account_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `account_type`
--

INSERT INTO `account_type` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Personal', 1, '2021-02-10 01:48:47', '2021-02-10 01:49:48'),
(2, 'Company', 1, '2021-02-10 01:49:55', '2021-02-10 01:49:55'),
(3, 'abcd', 1, '2021-02-13 01:14:30', '2021-02-13 01:14:30'),
(4, 'abcd2', 1, '2021-02-13 01:14:45', '2021-02-13 01:14:45');

-- --------------------------------------------------------

--
-- Table structure for table `assign_class_teacher`
--

CREATE TABLE `assign_class_teacher` (
  `id` int(11) NOT NULL,
  `class` int(11) DEFAULT NULL,
  `section` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teacher` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assign_class_teacher`
--

INSERT INTO `assign_class_teacher` (`id`, `class`, `section`, `teacher`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 'B', '{\"1\":{\"value\":\"John Doe\"},\"2\":{\"value\":\"Amit\"}}', 1, '2021-02-08 00:52:16', '2021-02-08 01:14:36');

-- --------------------------------------------------------

--
-- Table structure for table `bank_account`
--

CREATE TABLE `bank_account` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `account_type` int(11) DEFAULT NULL,
  `bank_branch` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` decimal(15,2) DEFAULT NULL,
  `opening_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_by` int(11) DEFAULT NULL COMMENT 'User Id',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bank_account`
--

INSERT INTO `bank_account` (`id`, `bank_name`, `account_name`, `account_no`, `account_type`, `bank_branch`, `balance`, `opening_date`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Brac Bank', 'Brac Bank', '123012451201', 1, 'Uttara', '74360.00', '2021-02-09', 1, 1, '2021-02-09 05:17:34', '2021-02-09 05:20:30'),
(2, 'abcd', 'abcd', '123', 1, 'uttara', '4479.00', '2021-02-09', 1, 1, '2021-02-09 05:44:06', '2021-02-09 06:05:19'),
(3, 'AMit', 'amit', '233', 2, 'Uttara', '13980.00', '2021-02-10', 1, 1, '2021-02-10 01:59:36', '2021-02-10 02:00:22');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `cus_sup_id` int(11) DEFAULT NULL COMMENT 'customer id/supplier id',
  `product_id` int(11) DEFAULT NULL,
  `unit_price` decimal(15,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_by` tinyint(2) DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'purchase, sell',
  `session` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `cus_sup_id`, `product_id`, `unit_price`, `quantity`, `created_by`, `type`, `session`, `created_at`, `updated_at`) VALUES
(27, 1, 3, '90.00', 2, 3, 'sell', '35ad9895148524900ff433533da87b53', '2021-02-15 03:32:37', '2021-02-15 03:32:37');

-- --------------------------------------------------------

--
-- Table structure for table `cheque_book`
--

CREATE TABLE `cheque_book` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank` int(11) DEFAULT NULL COMMENT 'Bank Id',
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cheque_book`
--

INSERT INTO `cheque_book` (`id`, `name`, `bank`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Checkbook', 2, 1, '2021-02-09 23:54:53', '2021-02-10 00:00:34'),
(2, 'cheque', 2, 1, '2021-02-10 00:15:49', '2021-02-10 00:15:49');

-- --------------------------------------------------------

--
-- Table structure for table `cheque_no`
--

CREATE TABLE `cheque_no` (
  `id` int(11) NOT NULL,
  `cheque_book` int(11) DEFAULT NULL,
  `cheque_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Used',
  `tok` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cheque_no`
--

INSERT INTO `cheque_no` (`id`, `cheque_book`, `cheque_no`, `status`, `tok`, `created_at`, `updated_at`) VALUES
(1, 2, 'A122000', 0, '20210213100641', '2021-02-10 00:34:32', '2021-02-13 04:06:41'),
(3, 1, '123456', 0, '20210210072805', '2021-02-10 01:15:56', '2021-02-10 01:28:05'),
(4, 1, '123456', 0, '20210213100244', '2021-02-10 01:16:00', '2021-02-13 04:02:44'),
(5, 2, '45621', 1, NULL, '2021-02-10 01:16:04', '2021-02-10 01:16:04');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `name`, `section`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Class One', '{\"1\":{\"value\":\"A\"},\"2\":{\"value\":\"B\"}}', 1, '2021-02-01 19:16:05', '2021-02-06 17:22:26'),
(2, 'Class Two 2', '{\"1\":{\"value\":\"A\"},\"2\":{\"value\":\"B\"}}', 1, '2021-02-01 19:16:07', '2021-02-06 19:44:35'),
(4, 'Class Three', '{\"2\":{\"value\":\"A\"}}', 1, '2021-02-06 19:26:02', '2021-02-06 19:38:22'),
(5, 'New', '{\"2\":{\"value\":\"A\"}}', 1, '2021-02-06 19:43:26', '2021-02-06 19:44:45'),
(6, 'aaaa', '{\"1\":{\"value\":\"B\"},\"2\":{\"value\":\"A\"}}', 1, '2021-02-06 19:43:34', '2021-02-06 19:43:34');

-- --------------------------------------------------------

--
-- Table structure for table `class_timetable`
--

CREATE TABLE `class_timetable` (
  `id` int(11) NOT NULL,
  `class` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `section` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `day` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teacher` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_from` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_to` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `room_no` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `class_timetable`
--

INSERT INTO `class_timetable` (`id`, `class`, `section`, `day`, `subject`, `teacher`, `time_from`, `time_to`, `room_no`, `status`, `created_at`, `updated_at`) VALUES
(1, '1', 'B', 'Saturday', 'Bangla', 'John Doe', '19:06', '19:06', '100', 1, '2021-02-08 05:06:49', '2021-02-08 05:06:49'),
(2, '1', 'B', 'Tuesday', 'Bangla', 'John Doe', '10:00', '01:01', '100', 1, '2021-02-08 05:07:55', '2021-02-08 05:07:55'),
(3, '1', 'B', 'Tuesday', 'English', 'Amit', '10:00', '10:00', '101', 1, '2021-02-08 05:07:55', '2021-02-08 05:07:55'),
(4, '1', 'B', 'Monday', 'Mathematics', 'John Doe', '02:00', '10:00', '102', 1, '2021-02-08 05:07:55', '2021-02-08 05:07:55'),
(5, '1', 'B', 'Tuesday', 'Biology', 'Amit', '03:00', '02:00', '103', 1, '2021-02-08 05:07:55', '2021-02-08 05:07:55'),
(6, '1', 'B', 'Sunday', 'Bangla', 'John Doe', '17:14', '17:15', '1001', 1, '2021-02-08 05:11:35', '2021-02-08 05:11:35'),
(7, '1', 'B', 'Thrusday', 'Mathematics', 'Amit', '17:15', '17:17', '1002', 1, '2021-02-08 05:11:35', '2021-02-08 05:11:35'),
(8, '1', 'B', 'Sunday', 'English', 'John Doe', '21:33', '17:37', '1000', 1, '2021-02-08 05:33:22', '2021-02-08 05:33:22'),
(9, '1', 'B', 'Wednessday', 'Mathematics', 'Amit', '17:36', '17:39', '2000', 1, '2021-02-08 05:33:22', '2021-02-08 05:33:22');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `customer_id`, `name`, `email`, `phone`, `address`, `status`, `created_at`, `updated_at`) VALUES
(1, 1000, 'Amit Sarker updated', 'admin@gmail.com', '123356565656', 'Uttara 10', 1, '2021-02-11 03:54:05', '2021-02-11 04:07:32'),
(3, 1001, 'aaaaa', 'admin@gmail.com', '45454', 'aaa', 1, '2021-02-11 03:54:20', '2021-02-11 03:54:20');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class` int(11) DEFAULT NULL COMMENT 'class_id',
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `class`, `status`, `created_at`, `updated_at`) VALUES
(1, 'dept 1', 1, 1, '2021-02-03 11:04:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `empolyees`
--

CREATE TABLE `empolyees` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `role` int(11) DEFAULT NULL,
  `designation` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `marital_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qualification` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_experience` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `joining_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `present_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permanent_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `basic_salary` decimal(15,2) DEFAULT NULL,
  `contract_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `leaves` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_docs` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `empolyees`
--

INSERT INTO `empolyees` (`id`, `employee_id`, `role`, `designation`, `name`, `email`, `father_name`, `mother_name`, `gender`, `marital_status`, `qualification`, `work_experience`, `birth_date`, `religion`, `joining_date`, `contact`, `emergency_contact`, `present_address`, `permanent_address`, `basic_salary`, `contract_type`, `employee_image`, `leaves`, `additional_docs`, `status`, `created_at`, `updated_at`) VALUES
(2, 123020, 2, 'Admin', 'John Doe', 'aass@gmail.com', 'Abcd', 'Abcd', 'Male', 'Single', 'MSC', 'Elcellent', '2021-02-04', 'Hinduism', '2021-02-04', '01708027394', '01708027394', 'Uttara', 'Uttara', '35000.00', 'Permanent', '2021020411103952745.jpg', '{\"1\":{\"key\":\"Maternity Leave\",\"value\":\"10\"}}', '{\"1\":{\"key\":\"Certificate2\",\"value\":\"hhd\"}}', 1, '2021-02-04 19:10:39', '2021-02-08 00:15:39'),
(3, 210, 3, 'Admin', 'John Doe', 'aaa', 'aaa', 'aaa', 'Male', 'Married', 'aaa', 'aaa', '2021-02-04', 'Hinduism', '2021-02-04', '222', '2222', 'aaa', 'aaa', '20000.00', 'Permanent', '2021020411504498398.jpg', '{\"1\":{\"key\":\"Maternity Leave\",\"value\":\"100\"}}', '{\"1\":{\"key\":\"Certificate1\",\"value\":\"hhd\"}}', 1, '2021-02-04 19:13:52', '2021-02-08 00:18:36'),
(4, 10, 3, 'Admin', 'Amit', 'amit', 'aaa', 'aaa', 'Female', 'Single', 'ma', 'uttara', '2021-02-04', 'Hinduism', '2021-02-04', '1210', '1210', 'uttara', 'uttara', '10000.00', 'Permanent', '2021020411521940800.jpg', '{\"1\":{\"key\":\"Medical Leave\",\"value\":\"50\"},\"2\":{\"key\":\"Casual Leave\",\"value\":\"60\"},\"3\":{\"key\":\"Maternity Leave\",\"value\":\"70\"}}', '{\"1\":{\"key\":\"Certificate1\",\"value\":\"hhd\"}}', 1, '2021-02-04 19:51:47', '2021-02-08 00:16:11');

-- --------------------------------------------------------

--
-- Table structure for table `food_type`
--

CREATE TABLE `food_type` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `food_type`
--

INSERT INTO `food_type` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'abcd', 1, '2021-02-13 06:23:57', '2021-02-13 06:23:57'),
(3, 'Chines', 1, '2021-02-15 03:30:54', '2021-02-15 03:30:54');

-- --------------------------------------------------------

--
-- Table structure for table `leave_type`
--

CREATE TABLE `leave_type` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_type`
--

INSERT INTO `leave_type` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Medical Leave', 1, '2021-02-04 18:47:33', '2021-02-04 18:47:33'),
(2, 'Casual Leave', 1, '2021-02-04 18:47:39', '2021-02-04 18:47:39'),
(3, 'Maternity Leave', 1, '2021-02-04 18:47:44', '2021-02-04 18:47:44'),
(4, 'test', 1, '2021-02-04 19:58:38', '2021-02-04 19:58:38');

-- --------------------------------------------------------

--
-- Table structure for table `other_transaction`
--

CREATE TABLE `other_transaction` (
  `id` int(11) NOT NULL,
  `method` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Bank Id, Cash',
  `type` int(11) DEFAULT NULL COMMENT 'From other_transaction_type tbl',
  `transaction_for` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `transaction_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issue_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'receive, payment',
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `tok` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `other_transaction`
--

INSERT INTO `other_transaction` (`id`, `method`, `type`, `transaction_for`, `amount`, `transaction_date`, `issue_by`, `note`, `reason`, `status`, `tok`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '1', 1, 'amit', '5000.00', '2021-02-10', 'amit', 'aaa', 'receive', 1, '20210210121418', 1, '2021-02-10 06:14:18', '2021-02-10 06:14:18'),
(2, 'Cash', 1, 'amit', '1000.00', '2021-02-10', 'admin', 'aaa', 'receive', 1, '20210210121454', 1, '2021-02-10 06:14:54', '2021-02-10 06:14:54'),
(3, '1', 1, 'amit', '5000.00', '2021-02-10', 'admin', 'amit', 'receive', 1, '20210210124309', 1, '2021-02-10 06:43:09', '2021-02-10 06:43:09'),
(5, '1', 1, 'Amit', '1200.00', '2021-02-10', 'admin', 'amit', 'receive', 1, '20210210125001', 1, '2021-02-10 06:50:01', '2021-02-10 06:50:01'),
(6, '1', 4, 'binaryit', '200.00', '2021-02-11', 'admin', 'ass', 'payment', 1, '20210211060918', 1, '2021-02-11 00:09:18', '2021-02-11 00:09:18'),
(9, '1', 1, 'aa', '100.00', '2021-02-12', 'ad', 'aaa', 'receive', 1, '20210211081006', 1, '2021-02-11 02:10:06', '2021-02-11 02:10:06'),
(10, '1', 4, 'aaa', '100.00', '2021-02-11', 'ad', 'sss', 'payment', 1, '20210211081241', 1, '2021-02-11 02:12:41', '2021-02-11 02:12:41');

-- --------------------------------------------------------

--
-- Table structure for table `other_transaction_type`
--

CREATE TABLE `other_transaction_type` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Receive, Payment',
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `other_transaction_type`
--

INSERT INTO `other_transaction_type` (`id`, `name`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Receive One', 'receive', 1, '2021-02-10 05:15:05', '2021-02-10 05:15:48'),
(4, 'payment', 'payment', 1, '2021-02-10 07:11:00', '2021-02-10 07:11:00'),
(6, 'receive 4 update', 'receive', 1, '2021-02-10 23:53:06', '2021-02-10 23:53:14'),
(7, 'pay', 'payment', 1, '2021-02-10 23:56:29', '2021-02-10 23:56:29'),
(8, 'aaa', 'receive', 1, '2021-02-12 23:44:43', '2021-02-12 23:44:43'),
(9, 'abcd', 'receive', 1, '2021-02-13 01:12:18', '2021-02-13 01:12:18'),
(10, 'axc', 'payment', 1, '2021-02-13 01:13:36', '2021-02-13 01:13:36');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `brand` int(11) DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `type`, `brand`, `price`, `status`, `created_at`, `updated_at`) VALUES
(1, 'product 1 updated', 2, 1, '500.00', 1, '2021-02-11 04:47:28', '2021-02-11 04:54:12'),
(2, 'abcd', 3, 1, '100.00', 1, '2021-02-11 05:16:25', '2021-02-11 05:16:25');

-- --------------------------------------------------------

--
-- Table structure for table `product_brand`
--

CREATE TABLE `product_brand` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_brand`
--

INSERT INTO `product_brand` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Brand 1', 1, '2021-02-11 04:36:17', '2021-02-11 04:36:17');

-- --------------------------------------------------------

--
-- Table structure for table `product_package`
--

CREATE TABLE `product_package` (
  `id` int(11) NOT NULL,
  `food_type` int(11) DEFAULT NULL,
  `package_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_package`
--

INSERT INTO `product_package` (`id`, `food_type`, `package_code`, `name`, `details`, `image`, `price`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, '123456a', 'jhjh', 'agfhgha', '2021021312511526817.jpg', '180.00', 1, '2021-02-13 06:51:15', '2021-02-13 06:52:28'),
(3, 3, '101', 'ThaiSoup', 'sasas', '2021021509321851862.png', '90.00', 1, '2021-02-15 03:32:18', '2021-02-15 03:32:18');

-- --------------------------------------------------------

--
-- Table structure for table `product_purchase`
--

CREATE TABLE `product_purchase` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `unit_price` decimal(15,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `tok` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchase_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` tinyint(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_purchase`
--

INSERT INTO `product_purchase` (`id`, `supplier_id`, `product_id`, `unit_price`, `quantity`, `tok`, `purchase_date`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '10.00', 20, '20210213094108', '2021-02-13', 1, '2021-02-13 03:41:08', '2021-02-13 03:41:08'),
(2, 2, 2, '100.00', 100, '20210213094753', '2021-02-13', 1, '2021-02-13 03:47:53', '2021-02-13 03:47:53'),
(4, 2, 1, '10.00', 20, '20210215070942', '2021-02-15', 1, '2021-02-15 01:09:42', '2021-02-15 01:09:42'),
(5, 2, 1, '10.00', 100, '20210215070942', '2021-02-15', 1, '2021-02-15 01:09:42', '2021-02-15 01:09:42'),
(6, 3, 2, '10.00', 20, '20210215071101', '2021-02-15', 1, '2021-02-15 01:11:01', '2021-02-15 01:11:01');

-- --------------------------------------------------------

--
-- Table structure for table `product_sell`
--

CREATE TABLE `product_sell` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `unit_price` decimal(15,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `tok` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sell_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` tinyint(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sell`
--

INSERT INTO `product_sell` (`id`, `customer_id`, `product_id`, `unit_price`, `quantity`, `tok`, `sell_date`, `created_by`, `created_at`, `updated_at`) VALUES
(7, 1, 2, '180.00', 10, '20210214124915', '2021-02-14', 1, '2021-02-14 06:49:15', '2021-02-14 06:49:15'),
(8, 1, 2, '180.00', 12, '20210214124915', '2021-02-14', 1, '2021-02-14 06:54:46', '2021-02-14 06:54:46'),
(9, 1, 2, '180.00', 12, '20210214124915', '2021-02-14', 1, '2021-02-14 06:55:42', '2021-02-14 06:55:42'),
(10, 1, 2, '180.00', 12, '20210214125923', '2021-02-14', 1, '2021-02-14 06:59:23', '2021-02-14 06:59:23'),
(12, 1, 2, '180.00', 2, '20210214010445', '2021-02-14', 1, '2021-02-14 07:04:45', '2021-02-14 07:04:45'),
(13, 1, 2, '180.00', 2, '20210214015916', '2021-02-14', 1, '2021-02-14 07:59:16', '2021-02-14 07:59:16'),
(14, 1, 2, '180.00', 2, '20210215092713', '2021-02-15', 3, '2021-02-15 03:27:13', '2021-02-15 03:27:13');

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Type 1', 1, '2021-02-11 04:36:17', '2021-02-11 04:36:17'),
(3, 'brand v2', 1, '2021-02-11 05:04:37', '2021-02-11 05:04:37'),
(4, 'food 1', 1, '2021-02-13 06:23:06', '2021-02-13 06:23:06'),
(5, 'Chines', 1, '2021-02-15 03:28:31', '2021-02-15 03:28:31');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(2, 'B', 1, '2021-02-01 19:04:25', '2021-02-02 13:32:58'),
(4, 'A', 1, '2021-02-06 17:22:13', '2021-02-06 17:22:13'),
(5, 'abcd', 1, '2021-02-06 20:02:47', '2021-02-06 20:02:47');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(2, 'abcd updaqted m', 1, '2021-02-02 13:33:30', '2021-02-02 13:33:45');

-- --------------------------------------------------------

--
-- Table structure for table `stock_product`
--

CREATE TABLE `stock_product` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL COMMENT 'Total Available Quantity',
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_product`
--

INSERT INTO `stock_product` (`id`, `product_id`, `quantity`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 370, 1, '2021-02-13 03:04:27', '2021-02-15 01:09:42'),
(2, 2, 120, 1, '2021-02-13 03:04:27', '2021-02-15 01:11:01');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roll_no` int(11) DEFAULT NULL,
  `class` int(11) DEFAULT NULL COMMENT 'Class Tbl id',
  `section` int(11) DEFAULT NULL COMMENT 'Section Tbl id',
  `session` int(11) DEFAULT NULL COMMENT 'Session Tbl id',
  `department` int(11) DEFAULT NULL COMMENT 'Department Tbl id',
  `version` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Bangla, English',
  `admission_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blood_group` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `religion` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `father_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mother_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `contact` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emergency_contact` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `present_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permanent_address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admission_fee` decimal(15,2) DEFAULT NULL,
  `tution_fee` decimal(15,2) DEFAULT NULL,
  `student_photo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `additional_docs` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sibling` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `email`, `roll_no`, `class`, `section`, `session`, `department`, `version`, `admission_date`, `birth_date`, `blood_group`, `gender`, `religion`, `father_name`, `mother_name`, `guardian_phone`, `contact`, `emergency_contact`, `present_address`, `permanent_address`, `admission_fee`, `tution_fee`, `student_photo`, `additional_docs`, `sibling`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Amit Sarker', 'amit@gmail.com', 13203038, 1, 2, 2, 1, 'English', '2021-02-03', '2021-02-03', 'AB+', 'Male', 'Hinduism', 'Akhil Chandra', 'Himani Rani', '01708521452', '01708027394', '01708027394', 'uttara', 'Uttara Dhaka 1230', '5000.00', '500.00', '2021020309315761755.jpg', '{\"1\":{\"key\":\"School Cretificate\",\"value\":\"Here is the school certificate\"}}', NULL, 1, '2021-02-03 17:30:05', '2021-02-03 17:31:57'),
(3, 'BinaryIT', 'binaryit@gmail.com', 12320, 1, 2, 2, 1, 'Bangla', '2021-02-11', '2021-02-05', 'AB+', 'Female', 'Islam', 'abcde', 'abcde', '01705421014', '01705421014', '01705421014', 'Uttara', 'Uttara Dhaka 1230', '2000.00', '20.00', '2021020409144726855.jpg', '{\"1\":{\"key\":\"Certificate1\",\"value\":\"abcd\"},\"2\":{\"key\":\"Certificate2\",\"value\":\"abcd2\"}}', 1, 1, '2021-02-04 17:01:48', '2021-02-04 17:14:47');

-- --------------------------------------------------------

--
-- Table structure for table `student_attendance`
--

CREATE TABLE `student_attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `class` int(11) DEFAULT NULL,
  `section` int(11) DEFAULT NULL,
  `attendance` int(11) DEFAULT NULL COMMENT '1=>Present, 0=>Absent',
  `attendance_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `student_attendance`
--

INSERT INTO `student_attendance` (`id`, `student_id`, `class`, `section`, `attendance`, `attendance_date`, `status`, `created_at`, `updated_at`) VALUES
(61, 3, 2, 1, 0, '2021-02-06', 1, '2021-02-06 18:27:51', '2021-02-06 18:27:51'),
(62, 1, 2, 1, 0, '2021-02-05', 1, '2021-02-06 18:28:31', '2021-02-06 18:28:31'),
(63, 3, 2, 1, 1, '2021-02-05', 1, '2021-02-06 18:28:31', '2021-02-06 18:28:31'),
(64, 1, 1, 2, 1, '2021-02-07', 1, '2021-02-07 16:56:41', '2021-02-07 16:56:41'),
(65, 3, 1, 2, 0, '2021-02-07', 1, '2021-02-07 16:56:41', '2021-02-07 16:56:41');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_code` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `name`, `subject_code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Bangla', '120', 1, '2021-02-06 20:01:55', '2021-02-06 20:05:18'),
(3, 'English', '102', 1, '2021-02-07 19:31:11', '2021-02-07 19:31:11'),
(4, 'Mathematics', '201', 1, '2021-02-07 19:31:19', '2021-02-07 19:31:19'),
(5, 'Science', '102', 1, '2021-02-07 19:31:29', '2021-02-07 19:31:29'),
(6, 'Physics', '105', 1, '2021-02-07 19:31:40', '2021-02-07 19:31:40'),
(7, 'Biology', '104', 1, '2021-02-07 19:31:50', '2021-02-07 19:31:50');

-- --------------------------------------------------------

--
-- Table structure for table `subject_group`
--

CREATE TABLE `subject_group` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `class` int(11) DEFAULT NULL,
  `section` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subject_group`
--

INSERT INTO `subject_group` (`id`, `name`, `class`, `section`, `subject`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Class One', 1, '{\"1\":{\"value\":\"B\"},\"2\":{\"value\":\"A\"}}', '{\"1\":{\"value\":\"Bangla\"},\"2\":{\"value\":\"English\"},\"3\":{\"value\":\"Mathematics\"},\"6\":{\"value\":\"Biology\"}}', 1, '2021-02-07 23:35:09', '2021-02-07 23:35:39');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `supplier_id`, `name`, `email`, `phone`, `address`, `status`, `created_at`, `updated_at`) VALUES
(2, 1000, 'Amit Sarker updated 1', 'admin@gmail.com', '123356565656', 'Uttara 10', 1, '2021-02-11 03:54:05', '2021-02-15 03:00:42'),
(3, 1001, 'aaaaa', 'admin@gmail.com', '45454', 'Utt updated', 1, '2021-02-11 03:54:20', '2021-02-11 05:37:04');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_ledger`
--

CREATE TABLE `supplier_ledger` (
  `id` int(11) NOT NULL,
  `date` varchar(255) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL COMMENT 'purchase(bill), payment',
  `tok` varchar(255) DEFAULT NULL,
  `created_by` tinyint(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `supplier_ledger`
--

INSERT INTO `supplier_ledger` (`id`, `date`, `supplier_id`, `amount`, `reason`, `tok`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '2021-02-15', 2, '200.00', 'purchase', '20210215070942', 1, '2021-02-15 01:09:42', '2021-02-15 01:09:42'),
(2, '2021-02-15', 2, '1000.00', 'purchase', '20210215070942', 1, '2021-02-15 01:09:42', '2021-02-15 01:09:42'),
(3, '2021-02-15', 3, '200.00', 'purchase', '20210215071101', 1, '2021-02-15 01:11:01', '2021-02-15 01:11:01'),
(4, '2021-02-15', 2, '100.00', 'payment', '20210215074616', 1, '2021-02-15 01:46:16', '2021-02-15 01:46:16'),
(5, '2021-02-15', 2, '100.00', 'payment', '20210215075645', 1, '2021-02-15 01:56:45', '2021-02-15 01:56:45');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Receive, Payment',
  `amount` decimal(15,2) DEFAULT NULL,
  `tok` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `date`, `reason`, `amount`, `tok`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '2021-02-09', 'Receive', '2500.00', '20210209111949', 1, 1, '2021-02-09 05:19:49', '2021-02-09 05:19:49'),
(2, '2021-02-09', 'Receive', '1000.00', '20210209113550', 1, 1, '2021-02-09 05:35:50', '2021-02-09 05:35:50'),
(3, '2021-02-09', 'Receive', '2000.00', '20210209120423', 1, 1, '2021-02-09 06:04:23', '2021-02-09 06:04:23'),
(4, '2021-02-09', 'Payment', '2000.00', '20210209120423', 1, 1, '2021-02-09 06:04:23', '2021-02-09 06:04:23'),
(5, '2021-02-09', 'Receive', '199.00', '20210209120730', 1, 1, '2021-02-09 06:07:30', '2021-02-09 06:07:30'),
(6, '2021-02-09', 'Receive', '199.00', '20210209120816', 1, 1, '2021-02-09 06:08:16', '2021-02-09 06:08:16'),
(7, '2021-02-09', 'Payment', '199.00', '20210209120816', 1, 1, '2021-02-09 06:08:16', '2021-02-09 06:08:16'),
(8, '2021-02-10', 'Payment', '500.00', '20210210072805', 1, 1, '2021-02-10 01:28:05', '2021-02-10 01:28:05'),
(9, '2021-02-10', 'Receive', '1000.00', '20210210080013', 1, 1, '2021-02-10 02:00:13', '2021-02-10 02:00:13'),
(10, '2021-02-10', 'Receive', '1200.00', '20210210125001', 1, 1, '2021-02-10 06:50:01', '2021-02-10 06:50:01'),
(11, '2021-02-11', 'Payment', '200.00', '20210211060918', 1, 1, '2021-02-11 00:09:18', '2021-02-11 00:09:18'),
(12, '2021-02-11', 'Receive', '1000.00', '20210211080710', 1, 1, '2021-02-11 02:07:10', '2021-02-11 02:07:10'),
(13, '2021-02-11', 'Receive', '100.00', '20210211080911', 1, 1, '2021-02-11 02:09:11', '2021-02-11 02:09:11'),
(14, NULL, 'Receive', '100.00', '20210211081006', 1, 1, '2021-02-11 02:10:06', '2021-02-11 02:10:06'),
(15, NULL, 'Payment', '100.00', '20210211081241', 1, 1, '2021-02-11 02:12:41', '2021-02-11 02:12:41'),
(16, '2021-02-13', 'Payment', '100.00', '20210213100244', 1, 1, '2021-02-13 04:02:44', '2021-02-13 04:02:44'),
(17, '2021-02-13', 'Payment', '120.00', '20210213100641', 1, 1, '2021-02-13 04:06:41', '2021-02-13 04:06:41'),
(18, '2021-02-14', 'Receive', '2160.00', '20210214125923', 1, 1, '2021-02-14 06:59:23', '2021-02-14 06:59:23'),
(19, '2021-02-14', 'Receive', '540.00', '20210214010221', 1, 1, '2021-02-14 07:02:21', '2021-02-14 07:02:21'),
(20, '2021-02-14', 'Receive', '1800.00', '20210214010445', 1, 1, '2021-02-14 07:04:45', '2021-02-14 07:04:45'),
(21, '2021-02-14', 'Receive', '360.00', '20210214015916', 1, 1, '2021-02-14 07:59:16', '2021-02-14 07:59:16'),
(22, '2021-02-15', 'payment', '100.00', '20210215075645', 1, 1, '2021-02-15 01:56:45', '2021-02-15 01:56:45'),
(23, '2021-02-15', 'Receive', '360.00', '20210215092713', 1, 3, '2021-02-15 03:27:13', '2021-02-15 03:27:13');

-- --------------------------------------------------------

--
-- Table structure for table `transation_report`
--

CREATE TABLE `transation_report` (
  `id` int(11) NOT NULL,
  `bank_id` int(11) DEFAULT NULL COMMENT 'Bank Id',
  `transaction_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `reason` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tok` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_by` tinyint(2) DEFAULT NULL COMMENT 'User Id',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transation_report`
--

INSERT INTO `transation_report` (`id`, `bank_id`, `transaction_date`, `amount`, `reason`, `note`, `tok`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-02-09', '2000.00', 'Opening Balance', NULL, '20210209111734', 1, 1, '2021-02-09 05:17:34', '2021-02-09 05:20:30'),
(2, 1, '2021-02-09', '2500.00', 'deposit', 'Deposit', '20210209111949', 1, 1, '2021-02-09 05:19:49', '2021-02-09 05:19:49'),
(4, 2, '2021-02-09', '2000.00', 'Opening Balance', NULL, '20210209114406', 1, 1, '2021-02-09 05:44:06', '2021-02-09 06:05:19'),
(12, 2, '2021-02-09', '2000.00', 'deposit', 'done', '20210209120423', 1, 1, '2021-02-09 06:04:23', '2021-02-09 06:04:23'),
(13, 1, '2021-02-09', '2000.00', 'transfer', 'done', '20210209120423', 1, 1, '2021-02-09 06:04:23', '2021-02-09 06:04:23'),
(14, 1, '2021-02-09', '199.00', 'deposit', '2632', '20210209120730', 1, 1, '2021-02-09 06:07:30', '2021-02-09 06:07:30'),
(15, 2, '2021-02-09', '199.00', 'deposit', '4154', '20210209120816', 1, 1, '2021-02-09 06:08:16', '2021-02-09 06:08:16'),
(16, 1, '2021-02-09', '199.00', 'transfer', '4154', '20210209120816', 1, 1, '2021-02-09 06:08:16', '2021-02-09 06:08:16'),
(17, 2, '2021-02-10', '500.00', 'withdraw (1-3)', 'withdraw', '20210210072805', 1, 1, '2021-02-10 01:28:05', '2021-02-10 01:28:05'),
(18, 3, '2021-02-10', '2000.00', 'Opening Balance', NULL, '20210210075936', 1, 1, '2021-02-10 01:59:36', '2021-02-10 02:00:22'),
(19, 3, '2021-02-10', '1000.00', 'deposit', 'ss', '20210210080013', 1, 1, '2021-02-10 02:00:13', '2021-02-10 02:00:13'),
(20, 1, '2021-02-10', '1200.00', 'receive', 'amit', '20210210125001', 1, 1, '2021-02-10 06:50:01', '2021-02-10 06:50:01'),
(21, 1, '2021-02-11', '200.00', 'payment', 'ass', '20210211060918', 1, 1, '2021-02-11 00:09:18', '2021-02-11 00:09:18'),
(22, 1, '2021-02-11', '1000.00', 'receive', 'aaa', '20210211080710', 1, 1, '2021-02-11 02:07:10', '2021-02-11 02:07:10'),
(23, 1, '2021-02-11', '100.00', 'receive', 'aaa', '20210211080911', 1, 1, '2021-02-11 02:09:11', '2021-02-11 02:09:11'),
(26, 2, '2021-02-13', '100.00', 'withdraw (1-4)', 'withdraw', '20210213100244', 1, 1, '2021-02-13 04:02:44', '2021-02-13 04:02:44'),
(27, 2, '2021-02-13', '120.00', 'withdraw (2-1)', 'note', '20210213100641', 1, 1, '2021-02-13 04:06:41', '2021-02-13 04:06:41'),
(28, 3, '2021-02-14', '2160.00', 'receive', NULL, '20210214125923', 1, 1, '2021-02-14 06:59:23', '2021-02-14 06:59:23'),
(29, 3, '2021-02-14', '540.00', 'receive', NULL, '20210214010221', 1, 1, '2021-02-14 07:02:21', '2021-02-14 07:02:21'),
(30, 3, '2021-02-14', '1800.00', 'receive', NULL, '20210214010445', 1, 1, '2021-02-14 07:04:45', '2021-02-14 07:04:45'),
(31, 3, '2021-02-14', '360.00', 'receive', NULL, '20210214015916', 1, 1, '2021-02-14 07:59:16', '2021-02-14 07:59:16'),
(32, 1, '2021-02-15', '100.00', 'payment', NULL, '20210215075645', 1, 1, '2021-02-15 01:56:45', '2021-02-15 01:56:45'),
(33, 1, '2021-02-15', '360.00', 'receive', NULL, '20210215092713', 1, 3, '2021-02-15 03:27:13', '2021-02-15 03:27:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password_hint` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` tinyint(2) DEFAULT NULL COMMENT '1=>Developer/Superadmin, 2=>Admin',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `password_hint`, `image`, `type`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$T3ZX.Ic3IoKRSp1S0z5i9.zi.KZq66gGkQ2cgvPm.DVhi0/eQC.4e', '123456', NULL, 1, NULL, NULL, NULL),
(3, 'Rashed Ahmed 1 updated', 'ad1min@gmail.com', '$2y$10$2zAbk1CfRSj9jrk7fKX7WekR2FaoVITDlc3I4kVGRPt6ikhKZxBBa', '12345678', NULL, 2, NULL, '2021-02-15 03:09:32', '2021-02-15 03:24:10'),
(4, 'Rashed Ahmed', 'admin1@gmail.com', '$2y$10$P7tYMyvvDYWMHidZyS3a9OgUvH6p5yapbFZusQBDChiuZrTVyCy1W', '1234567', NULL, 2, NULL, '2021-02-15 03:11:14', '2021-02-15 03:11:14');

-- --------------------------------------------------------

--
-- Table structure for table `vat_calculation`
--

CREATE TABLE `vat_calculation` (
  `id` int(11) NOT NULL,
  `sub_total` decimal(15,2) DEFAULT NULL,
  `discount_percent` decimal(15,2) DEFAULT NULL,
  `discount_amount` decimal(15,2) DEFAULT NULL,
  `vat_percent` decimal(15,2) DEFAULT NULL,
  `vat_amount` decimal(15,2) DEFAULT NULL,
  `grand_total` decimal(15,2) DEFAULT NULL,
  `sell_date` varchar(255) DEFAULT NULL,
  `payment_method` int(11) DEFAULT NULL,
  `tok` varchar(255) DEFAULT NULL,
  `created_by` tinyint(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vat_calculation`
--

INSERT INTO `vat_calculation` (`id`, `sub_total`, `discount_percent`, `discount_amount`, `vat_percent`, `vat_amount`, `grand_total`, `sell_date`, `payment_method`, `tok`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '2160.00', '0.00', NULL, '0.00', NULL, '2160.00', '2021-02-14', 3, '20210214125446', 1, '2021-02-14 06:54:46', '2021-02-14 06:54:46'),
(2, '2160.00', '10.00', '216.00', '10.00', '216.00', '2160.00', '2021-02-14', 3, '20210214125542', 1, '2021-02-14 06:55:42', '2021-02-14 06:55:42'),
(3, '2160.00', '10.00', '216.00', '10.00', '216.00', '2160.00', '2021-02-14', 3, '20210214125923', 1, '2021-02-14 06:59:23', '2021-02-14 06:59:23'),
(4, '540.00', '10.00', '54.00', '10.00', '54.00', '540.00', '2021-02-14', 3, '20210214010221', 1, '2021-02-14 07:02:21', '2021-02-14 07:02:21'),
(5, '1800.00', '5.00', '90.00', '5.00', '90.00', '1800.00', '2021-02-14', 3, '20210214010445', 1, '2021-02-14 07:04:45', '2021-02-14 07:04:45'),
(6, '360.00', '5.00', '18.00', '5.00', '18.00', '360.00', '2021-02-14', 3, '20210214015916', 1, '2021-02-14 07:59:16', '2021-02-14 07:59:16'),
(7, '360.00', '0.00', NULL, '0.00', NULL, '360.00', '2021-02-15', 1, '20210215092713', 3, '2021-02-15 03:27:13', '2021-02-15 03:27:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_type`
--
ALTER TABLE `account_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assign_class_teacher`
--
ALTER TABLE `assign_class_teacher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_account`
--
ALTER TABLE `bank_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cheque_book`
--
ALTER TABLE `cheque_book`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cheque_no`
--
ALTER TABLE `cheque_no`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_timetable`
--
ALTER TABLE `class_timetable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empolyees`
--
ALTER TABLE `empolyees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `food_type`
--
ALTER TABLE `food_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_type`
--
ALTER TABLE `leave_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_transaction`
--
ALTER TABLE `other_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_transaction_type`
--
ALTER TABLE `other_transaction_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_brand`
--
ALTER TABLE `product_brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_package`
--
ALTER TABLE `product_package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_purchase`
--
ALTER TABLE `product_purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_sell`
--
ALTER TABLE `product_sell`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_product`
--
ALTER TABLE `stock_product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_attendance`
--
ALTER TABLE `student_attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject_group`
--
ALTER TABLE `subject_group`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_ledger`
--
ALTER TABLE `supplier_ledger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transation_report`
--
ALTER TABLE `transation_report`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `vat_calculation`
--
ALTER TABLE `vat_calculation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_type`
--
ALTER TABLE `account_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `assign_class_teacher`
--
ALTER TABLE `assign_class_teacher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bank_account`
--
ALTER TABLE `bank_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `cheque_book`
--
ALTER TABLE `cheque_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cheque_no`
--
ALTER TABLE `cheque_no`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `class_timetable`
--
ALTER TABLE `class_timetable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `empolyees`
--
ALTER TABLE `empolyees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `food_type`
--
ALTER TABLE `food_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `leave_type`
--
ALTER TABLE `leave_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `other_transaction`
--
ALTER TABLE `other_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `other_transaction_type`
--
ALTER TABLE `other_transaction_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_brand`
--
ALTER TABLE `product_brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_package`
--
ALTER TABLE `product_package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_purchase`
--
ALTER TABLE `product_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_sell`
--
ALTER TABLE `product_sell`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stock_product`
--
ALTER TABLE `stock_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_attendance`
--
ALTER TABLE `student_attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `subject_group`
--
ALTER TABLE `subject_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `supplier_ledger`
--
ALTER TABLE `supplier_ledger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `transation_report`
--
ALTER TABLE `transation_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vat_calculation`
--
ALTER TABLE `vat_calculation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
