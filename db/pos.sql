-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 09, 2021 at 09:45 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos`
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
(1, 'Current', 1, '2021-03-02 06:28:32', '2021-03-02 06:28:32');

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
(1, 'Cash', 'BinaryIT', '123012312014', 1, 'Uttara', '5000.00', '2021-03-02', 1, 1, '2021-03-02 06:29:24', '2021-03-02 06:29:24'),
(2, 'Card', 'BinaryIT', '123012312015', 1, 'Uttara', '2000.00', '2021-03-02', 1, 1, '2021-03-02 06:29:57', '2021-03-02 06:29:57');

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
(1, 1000, 'Amit', 'admin@gmail.com', '01524102145', 'Uttara', 1, '2021-03-02 06:31:35', '2021-03-02 06:31:35'),
(2, 1001, 'AR Cosmetics', 'admin@gmail.com', '01524102145', 'Uttara', 1, '2021-03-03 00:49:18', '2021-03-03 00:49:18');

-- --------------------------------------------------------

--
-- Table structure for table `customer_ledger`
--

CREATE TABLE `customer_ledger` (
  `id` int(11) NOT NULL,
  `date` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL COMMENT 'sell(bill), receive',
  `tok` varchar(255) DEFAULT NULL,
  `created_by` tinyint(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_ledger`
--

INSERT INTO `customer_ledger` (`id`, `date`, `customer_id`, `amount`, `reason`, `tok`, `created_by`, `created_at`, `updated_at`) VALUES
(1, '2021-03-02', 1, '340.00', 'sell', '20210302123155', 1, '2021-03-02 06:31:55', '2021-03-02 06:31:55'),
(2, '2021-03-02', 1, '137.00', 'sell', '20210302010550', 1, '2021-03-02 07:05:50', '2021-03-02 07:05:50'),
(3, '2021-03-03', 2, '392.00', 'sell', '20210303065010', 1, '2021-03-03 00:50:10', '2021-03-03 00:50:10');

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

-- --------------------------------------------------------

--
-- Table structure for table `gift_point`
--

CREATE TABLE `gift_point` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `bill_amount` decimal(15,2) DEFAULT NULL,
  `achieve_point` decimal(15,2) DEFAULT NULL,
  `date` varchar(255) DEFAULT NULL,
  `tok` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gift_point`
--

INSERT INTO `gift_point` (`id`, `customer_id`, `bill_amount`, `achieve_point`, `date`, `tok`, `created_at`, `updated_at`) VALUES
(1, 1, '340.00', '3.40', '2021-03-02', '20210302123155', '2021-03-02 06:31:55', '2021-03-02 06:31:55'),
(2, 2, '392.00', '3.92', '2021-03-03', '20210303065010', '2021-03-03 00:50:10', '2021-03-03 00:50:10');

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

-- --------------------------------------------------------

--
-- Table structure for table `other_payment_sub_type`
--

CREATE TABLE `other_payment_sub_type` (
  `id` int(11) NOT NULL,
  `payment_type_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `other_payment_type`
--

CREATE TABLE `other_payment_type` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `other_payment_voucher`
--

CREATE TABLE `other_payment_voucher` (
  `id` int(11) NOT NULL,
  `payment_type_id` int(11) DEFAULT NULL,
  `payment_sub_type_id` int(11) DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `payment_for` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `payment_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issue_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_by` int(11) DEFAULT NULL,
  `tok` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `other_receive_sub_type`
--

CREATE TABLE `other_receive_sub_type` (
  `id` int(11) NOT NULL,
  `receive_type_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `other_receive_type`
--

CREATE TABLE `other_receive_type` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `other_receive_voucher`
--

CREATE TABLE `other_receive_voucher` (
  `id` int(11) NOT NULL,
  `receive_type_id` int(11) DEFAULT NULL,
  `receive_sub_type_id` int(11) DEFAULT NULL,
  `bank_id` int(11) DEFAULT NULL,
  `receive_from` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT NULL,
  `receive_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `issue_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_by` int(11) DEFAULT NULL,
  `tok` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bar_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_type_id` int(11) DEFAULT NULL,
  `product_sub_type_id` int(11) DEFAULT NULL,
  `brand_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL COMMENT 'Product Sell Price',
  `vat_percent` decimal(15,2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `bar_code`, `product_type_id`, `product_sub_type_id`, `brand_id`, `unit_id`, `price`, `vat_percent`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Lipsticks', '1234567', 1, 1, 1, 1, '85.00', '5.00', 1, '2021-03-02 06:27:12', '2021-03-02 06:27:12'),
(2, 'abcd', '12345678', 1, 1, 1, 1, '52.00', '5.00', 1, '2021-03-02 06:50:59', '2021-03-02 06:50:59');

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
(1, 'Uniliver', 1, '2021-03-02 06:26:34', '2021-03-02 06:26:34');

-- --------------------------------------------------------

--
-- Table structure for table `product_package`
--

CREATE TABLE `product_package` (
  `id` int(11) NOT NULL,
  `food_type` int(11) DEFAULT NULL,
  `package_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'barcode',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(15,2) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_purchase`
--

CREATE TABLE `product_purchase` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `payment_method` int(11) DEFAULT NULL,
  `sub_total` decimal(15,2) DEFAULT NULL,
  `discount` decimal(15,2) DEFAULT NULL COMMENT 'Discount Percent',
  `paid_amount` decimal(15,2) DEFAULT NULL,
  `purchase_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tok` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` tinyint(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_purchase`
--

INSERT INTO `product_purchase` (`id`, `supplier_id`, `payment_method`, `sub_total`, `discount`, `paid_amount`, `purchase_date`, `note`, `tok`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '7070.00', '0.00', '0.00', '2021-03-02', 'Cash Purchase', '20210302123030', 1, '2021-03-02 06:30:30', '2021-03-02 06:30:30'),
(2, 1, 1, '5100.00', '0.00', '0.00', '2021-03-02', 'noted', '20210302125323', 1, '2021-03-02 06:53:23', '2021-03-02 06:53:23');

-- --------------------------------------------------------

--
-- Table structure for table `product_purchase_details`
--

CREATE TABLE `product_purchase_details` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `unit_price` decimal(15,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `purchase_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tok` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` tinyint(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_purchase_details`
--

INSERT INTO `product_purchase_details` (`id`, `supplier_id`, `product_id`, `unit_price`, `quantity`, `purchase_date`, `tok`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '70.00', 101, '2021-03-02', '20210302123030', 1, '2021-03-02 06:30:30', '2021-03-02 06:30:30'),
(2, 1, 2, '100.00', 51, '2021-03-02', '20210302125323', 1, '2021-03-02 06:53:23', '2021-03-02 06:53:23');

-- --------------------------------------------------------

--
-- Table structure for table `product_return`
--

CREATE TABLE `product_return` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `total_deduction_amount` decimal(15,2) DEFAULT NULL,
  `total_vat` decimal(15,2) DEFAULT NULL,
  `net_return_amount` decimal(15,2) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `return_date` varchar(255) DEFAULT NULL,
  `tok` varchar(255) DEFAULT NULL,
  `created_by` tinyint(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_return`
--

INSERT INTO `product_return` (`id`, `customer_id`, `total_deduction_amount`, `total_vat`, `net_return_amount`, `reason`, `return_date`, `tok`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, '8.00', '6.85', '75.74', 'abcd', '2021-03-09', '20210302010550', 1, '2021-03-09 02:43:19', '2021-03-09 02:43:19');

-- --------------------------------------------------------

--
-- Table structure for table `product_return_details`
--

CREATE TABLE `product_return_details` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `return_qnty` int(11) DEFAULT NULL,
  `deduction_percent` decimal(15,2) DEFAULT NULL,
  `total_amount` decimal(15,2) DEFAULT NULL,
  `tok` varchar(255) DEFAULT NULL,
  `created_by` tinyint(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_return_details`
--

INSERT INTO `product_return_details` (`id`, `customer_id`, `product_id`, `return_qnty`, `deduction_percent`, `total_amount`, `tok`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '10.00', '75.74', '20210302010550', 1, '2021-03-09 02:43:19', '2021-03-09 02:43:19');

-- --------------------------------------------------------

--
-- Table structure for table `product_return_to_supplier`
--

CREATE TABLE `product_return_to_supplier` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `total_deduction_amount` decimal(15,2) DEFAULT NULL,
  `total_vat` decimal(15,2) DEFAULT NULL,
  `net_return_amount` decimal(15,2) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `return_date` varchar(255) DEFAULT NULL,
  `tok` varchar(255) DEFAULT NULL,
  `created_by` tinyint(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_return_to_supplier`
--

INSERT INTO `product_return_to_supplier` (`id`, `supplier_id`, `total_deduction_amount`, `total_vat`, `net_return_amount`, `reason`, `return_date`, `tok`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, '0.00', NULL, '70.00', 'aaaa', '2021-03-09', '20210302123030', 1, '2021-03-09 02:44:24', '2021-03-09 02:44:24');

-- --------------------------------------------------------

--
-- Table structure for table `product_return_to_supplier_details`
--

CREATE TABLE `product_return_to_supplier_details` (
  `id` int(11) NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `return_qnty` int(11) DEFAULT NULL,
  `deduction_percent` decimal(15,2) DEFAULT NULL,
  `total_amount` decimal(15,2) DEFAULT NULL,
  `tok` varchar(255) DEFAULT NULL,
  `created_by` tinyint(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_return_to_supplier_details`
--

INSERT INTO `product_return_to_supplier_details` (`id`, `supplier_id`, `product_id`, `return_qnty`, `deduction_percent`, `total_amount`, `tok`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '0.00', '70.00', '20210302123030', 1, '2021-03-09 02:44:24', '2021-03-09 02:44:24');

-- --------------------------------------------------------

--
-- Table structure for table `product_sell`
--

CREATE TABLE `product_sell` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `payment_method` int(11) DEFAULT NULL,
  `sub_total` decimal(15,2) DEFAULT NULL,
  `discount` decimal(15,2) DEFAULT NULL COMMENT 'Discount Percent',
  `paid_amount` decimal(15,2) DEFAULT NULL,
  `total_vat` decimal(15,2) DEFAULT NULL,
  `sell_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tok` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pos_or_direct_sell` tinyint(4) DEFAULT NULL COMMENT '0=>Pos Sell, 1=>Direct Sell',
  `created_by` tinyint(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sell`
--

INSERT INTO `product_sell` (`id`, `customer_id`, `payment_method`, `sub_total`, `discount`, `paid_amount`, `total_vat`, `sell_date`, `tok`, `pos_or_direct_sell`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '340.00', '0.00', '0.00', '17.00', '2021-03-03', '20210302123155', 0, 1, '2021-03-02 06:31:55', '2021-03-02 06:31:55'),
(2, 1, 1, '137.00', '0.00', '0.00', '6.85', '2021-03-03', '20210302010550', 1, 1, '2021-03-02 07:05:50', '2021-03-02 07:05:50'),
(3, 2, 1, '392.00', '0.00', '0.00', '19.60', '2021-03-03', '20210303065010', 0, 1, '2021-03-03 00:50:10', '2021-03-03 00:50:10');

-- --------------------------------------------------------

--
-- Table structure for table `product_sell_details`
--

CREATE TABLE `product_sell_details` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `unit_price` decimal(15,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `vat_amount` decimal(15,2) DEFAULT NULL,
  `sell_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tok` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `session` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Session Value=>Pos Page, Null Value=>Sell Product Page',
  `created_by` tinyint(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sell_details`
--

INSERT INTO `product_sell_details` (`id`, `customer_id`, `product_id`, `unit_price`, `quantity`, `vat_amount`, `sell_date`, `tok`, `session`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '85.00', 1, '4.25', '2021-03-02', '20210302123155', '7e6d2233eda4388e09e3a9d0046e202c', 1, '2021-03-02 06:31:55', '2021-03-02 06:31:55'),
(2, 1, 1, '85.00', 1, '4.25', '2021-03-02', '20210302123155', '7e6d2233eda4388e09e3a9d0046e202c', 1, '2021-03-02 06:31:55', '2021-03-02 06:31:55'),
(3, 1, 1, '85.00', 1, '4.25', '2021-03-02', '20210302123155', '7e6d2233eda4388e09e3a9d0046e202c', 1, '2021-03-02 06:31:55', '2021-03-02 06:31:55'),
(4, 1, 1, '85.00', 1, '4.25', '2021-03-02', '20210302123155', '7e6d2233eda4388e09e3a9d0046e202c', 1, '2021-03-02 06:31:55', '2021-03-02 06:31:55'),
(5, 1, 1, '85.00', 1, '4.25', '2021-03-02', '20210302010550', NULL, 1, '2021-03-02 07:05:50', '2021-03-02 07:05:50'),
(6, 1, 2, '52.00', 1, '2.60', '2021-03-02', '20210302010550', NULL, 1, '2021-03-02 07:05:50', '2021-03-02 07:05:50'),
(7, 2, 2, '52.00', 1, '2.60', '2021-03-03', '20210303065010', '8d41d68c1da1d70331e251e9e1c0d74b', 1, '2021-03-03 00:50:10', '2021-03-03 00:50:10'),
(8, 2, 1, '85.00', 1, '4.25', '2021-03-03', '20210303065010', '8d41d68c1da1d70331e251e9e1c0d74b', 1, '2021-03-03 00:50:10', '2021-03-03 00:50:10'),
(9, 2, 1, '85.00', 1, '4.25', '2021-03-03', '20210303065010', '8d41d68c1da1d70331e251e9e1c0d74b', 1, '2021-03-03 00:50:10', '2021-03-03 00:50:10'),
(10, 2, 1, '85.00', 1, '4.25', '2021-03-03', '20210303065010', '8d41d68c1da1d70331e251e9e1c0d74b', 1, '2021-03-03 00:50:10', '2021-03-03 00:50:10'),
(11, 2, 1, '85.00', 1, '4.25', '2021-03-03', '20210303065010', '8d41d68c1da1d70331e251e9e1c0d74b', 1, '2021-03-03 00:50:10', '2021-03-03 00:50:10');

-- --------------------------------------------------------

--
-- Table structure for table `product_sub_type`
--

CREATE TABLE `product_sub_type` (
  `id` int(11) NOT NULL,
  `product_type_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_sub_type`
--

INSERT INTO `product_sub_type` (`id`, `product_type_id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Women', 1, '2021-03-02 06:25:57', '2021-03-02 06:25:57');

-- --------------------------------------------------------

--
-- Table structure for table `product_supplier_area`
--

CREATE TABLE `product_supplier_area` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_supplier_area`
--

INSERT INTO `product_supplier_area` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Uttara', 1, '2021-03-02 06:27:37', '2021-03-02 06:27:37');

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
(1, 'Cosmetics', 1, '2021-03-02 06:25:43', '2021-03-02 06:25:43');

-- --------------------------------------------------------

--
-- Table structure for table `product_unit`
--

CREATE TABLE `product_unit` (
  `id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_unit`
--

INSERT INTO `product_unit` (`id`, `name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Pcs', 1, '2021-03-02 06:26:44', '2021-03-02 06:26:44');

-- --------------------------------------------------------

--
-- Table structure for table `product_wastage_details`
--

CREATE TABLE `product_wastage_details` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `return_qnty` int(11) DEFAULT NULL,
  `deduction_percent` decimal(15,2) DEFAULT NULL,
  `total_amount` decimal(15,2) DEFAULT NULL,
  `tok` varchar(255) DEFAULT NULL,
  `created_by` tinyint(2) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `stock_product`
--

CREATE TABLE `stock_product` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 0 COMMENT 'Total Available Quantity',
  `unit_price` decimal(15,2) DEFAULT 0.00 COMMENT '(previous_qnty*previous_unit_price)+(present_qnty*present_unit_price)/(previous_qnty+present_qnty)',
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_product`
--

INSERT INTO `stock_product` (`id`, `product_id`, `quantity`, `unit_price`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 92, '0.00', 1, '2021-03-02 06:30:30', '2021-03-02 06:30:30'),
(2, 2, 49, '0.00', 1, '2021-03-02 06:53:23', '2021-03-02 06:53:23');

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
  `area_id` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '1=>Active, 0=>Inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `supplier_id`, `name`, `email`, `phone`, `address`, `area_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1000, 'AR Cosmetics', 'admin@gmail.com', '01524102145', 'Uttara', 1, 1, '2021-03-02 06:28:06', '2021-03-02 06:28:06');

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
(1, '2021-03-02', 1, '7070.00', 'purchase', '20210302123030', 1, '2021-03-02 06:30:30', '2021-03-02 06:30:30'),
(2, '2021-03-02', 1, '5100.00', 'purchase', '20210302125323', 1, '2021-03-02 06:53:23', '2021-03-02 06:53:23');

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

-- --------------------------------------------------------

--
-- Table structure for table `transation_report`
--

CREATE TABLE `transation_report` (
  `id` int(11) NOT NULL,
  `bank_id` int(11) DEFAULT NULL COMMENT 'Bank Id',
  `transaction_date` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(15,2) DEFAULT 0.00,
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
(1, 1, '2021-03-02', '5000.00', 'Opening Balance', NULL, '20210302122924', 1, 1, '2021-03-02 06:29:24', '2021-03-02 06:29:24'),
(2, 2, '2021-03-02', '2000.00', 'Opening Balance', NULL, '20210302122957', 1, 1, '2021-03-02 06:29:57', '2021-03-02 06:29:57');

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
(1, 'Admin', 'admin@gmail.com', '$2y$10$T3ZX.Ic3IoKRSp1S0z5i9.zi.KZq66gGkQ2cgvPm.DVhi0/eQC.4e', '123456', NULL, 1, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_type`
--
ALTER TABLE `account_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bank_account`
--
ALTER TABLE `bank_account`
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
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_ledger`
--
ALTER TABLE `customer_ledger`
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
-- Indexes for table `gift_point`
--
ALTER TABLE `gift_point`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_type`
--
ALTER TABLE `leave_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_payment_sub_type`
--
ALTER TABLE `other_payment_sub_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_payment_type`
--
ALTER TABLE `other_payment_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_payment_voucher`
--
ALTER TABLE `other_payment_voucher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_receive_sub_type`
--
ALTER TABLE `other_receive_sub_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_receive_type`
--
ALTER TABLE `other_receive_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `other_receive_voucher`
--
ALTER TABLE `other_receive_voucher`
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
-- Indexes for table `product_purchase_details`
--
ALTER TABLE `product_purchase_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_return`
--
ALTER TABLE `product_return`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_return_details`
--
ALTER TABLE `product_return_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_return_to_supplier`
--
ALTER TABLE `product_return_to_supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_return_to_supplier_details`
--
ALTER TABLE `product_return_to_supplier_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_sell`
--
ALTER TABLE `product_sell`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_sell_details`
--
ALTER TABLE `product_sell_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_sub_type`
--
ALTER TABLE `product_sub_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_supplier_area`
--
ALTER TABLE `product_supplier_area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_unit`
--
ALTER TABLE `product_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_wastage_details`
--
ALTER TABLE `product_wastage_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_product`
--
ALTER TABLE `stock_product`
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_type`
--
ALTER TABLE `account_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bank_account`
--
ALTER TABLE `bank_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cheque_book`
--
ALTER TABLE `cheque_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cheque_no`
--
ALTER TABLE `cheque_no`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customer_ledger`
--
ALTER TABLE `customer_ledger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `empolyees`
--
ALTER TABLE `empolyees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `food_type`
--
ALTER TABLE `food_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gift_point`
--
ALTER TABLE `gift_point`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `leave_type`
--
ALTER TABLE `leave_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `other_payment_sub_type`
--
ALTER TABLE `other_payment_sub_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `other_payment_type`
--
ALTER TABLE `other_payment_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `other_payment_voucher`
--
ALTER TABLE `other_payment_voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `other_receive_sub_type`
--
ALTER TABLE `other_receive_sub_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `other_receive_type`
--
ALTER TABLE `other_receive_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `other_receive_voucher`
--
ALTER TABLE `other_receive_voucher`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_brand`
--
ALTER TABLE `product_brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_package`
--
ALTER TABLE `product_package`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_purchase`
--
ALTER TABLE `product_purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_purchase_details`
--
ALTER TABLE `product_purchase_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_return`
--
ALTER TABLE `product_return`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_return_details`
--
ALTER TABLE `product_return_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_return_to_supplier`
--
ALTER TABLE `product_return_to_supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_return_to_supplier_details`
--
ALTER TABLE `product_return_to_supplier_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_sell`
--
ALTER TABLE `product_sell`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_sell_details`
--
ALTER TABLE `product_sell_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_sub_type`
--
ALTER TABLE `product_sub_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_supplier_area`
--
ALTER TABLE `product_supplier_area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_unit`
--
ALTER TABLE `product_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_wastage_details`
--
ALTER TABLE `product_wastage_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_product`
--
ALTER TABLE `stock_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplier_ledger`
--
ALTER TABLE `supplier_ledger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transation_report`
--
ALTER TABLE `transation_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
