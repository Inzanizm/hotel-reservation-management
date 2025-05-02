-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2025 at 09:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hotel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `assigned_services_tb`
--

CREATE TABLE `assigned_services_tb` (
  `assigned_id` int(10) NOT NULL,
  `request_id` int(10) NOT NULL,
  `staff_id` int(10) NOT NULL,
  `date_assigned` date NOT NULL,
  `status` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_log_tb`
--

CREATE TABLE `audit_log_tb` (
  `log_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `operation_type_id` int(10) NOT NULL,
  `timestamp` datetime NOT NULL,
  `affected_table` varchar(45) NOT NULL,
  `record_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cancellations_tb`
--

CREATE TABLE `cancellations_tb` (
  `cancellation_id` int(10) NOT NULL,
  `reservation_id` int(10) NOT NULL,
  `reason` varchar(500) NOT NULL,
  `date` datetime NOT NULL,
  `cancellation_status_id` int(10) NOT NULL,
  `cancelled_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cancellation_status_tb`
--

CREATE TABLE `cancellation_status_tb` (
  `cancellation_status_id` int(10) NOT NULL,
  `status_name` varchar(45) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_responses_tb`
--

CREATE TABLE `chatbot_responses_tb` (
  `response_id` int(10) NOT NULL,
  `trigger_question` varchar(45) NOT NULL,
  `response_message` varchar(500) NOT NULL,
  `response_category_id` int(10) NOT NULL,
  `updated_by` int(10) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_templates_tb`
--

CREATE TABLE `email_templates_tb` (
  `template_id` int(10) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `purpose` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faq_tb`
--

CREATE TABLE `faq_tb` (
  `faq_id` int(10) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback_tb`
--

CREATE TABLE `feedback_tb` (
  `feedback_id` int(10) NOT NULL,
  `guest_id` int(10) NOT NULL,
  `message` varchar(500) NOT NULL,
  `feedback_type_id` int(10) NOT NULL,
  `submitted_at` datetime NOT NULL,
  `status` varchar(45) NOT NULL,
  `response_message` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback_type_tb`
--

CREATE TABLE `feedback_type_tb` (
  `feedback_type_id` int(10) NOT NULL,
  `type_name` varchar(45) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guests_tb`
--

CREATE TABLE `guests_tb` (
  `guests_id` int(10) NOT NULL,
  `fname` varchar(45) NOT NULL,
  `mname` varchar(45) DEFAULT NULL,
  `lname` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `contact_number` int(11) NOT NULL,
  `home_address` varchar(45) NOT NULL,
  `street_name` varchar(45) DEFAULT NULL,
  `barangay` varchar(45) NOT NULL,
  `city_municipality` varchar(45) NOT NULL,
  `province` varchar(45) NOT NULL,
  `estimated_arrival_time` varchar(45) NOT NULL,
  `special_request_id` int(11) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `guests_tb`
--

INSERT INTO `guests_tb` (`guests_id`, `fname`, `mname`, `lname`, `email`, `contact_number`, `home_address`, `street_name`, `barangay`, `city_municipality`, `province`, `estimated_arrival_time`, `special_request_id`, `created_date`) VALUES
(2, 'Ephraim John', NULL, 'San Jose', 'lupellusvonpierre@gmail.com', 2147483647, 'Kalye 7 Sitio Mata Palangoy Binangonan, Rizal', 'Kalye 7', 'Palangoy', 'Binangonan', 'Rizal', '', NULL, '2025-04-28 15:56:09'),
(3, 'Ephraim John', NULL, 'San Jose', 'johnlouelpulumbarit23@gmail.com', 2147483647, 'Kalye 7 Sitio Mata Palangoy Binangonan, Rizal', 'Kalye 7', 'Palangoy', 'Binangonan', 'Rizal', '', 1, '2025-04-28 16:46:26'),
(4, 'Pulumbarit', NULL, 'John Louel', 'johnlouelpulumbarit23@gmail.com', 2147483647, 'Kalye 7 Sitio Mata Palangoy Binangonan, Rizal', 'Kalye 7', 'Palangoy', 'Binangonan', 'Rizal', '', 2, '2025-04-28 16:49:22'),
(5, 'Ephraim John', NULL, 'San Jose', 'lupellusvonpierre@gmail.com', 2147483647, 'Kalye 7 Sitio Mata Palangoy Binangonan, Rizal', 'Kalye 7', 'Palangoy', 'Binangonan', 'Rizal', '9:30am', 3, '2025-04-28 16:54:46'),
(6, 'Ephraim John', NULL, 'San Jose', 'lupellusvonpierre@gmail.com', 2147483647, 'Kalye 7 Sitio Mata Palangoy Binangonan, Rizal', 'Kalye 7', 'Palangoy', 'Binangonan', 'Rizal', '9:30am', 4, '2025-04-30 14:55:10');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries_tb`
--

CREATE TABLE `inquiries_tb` (
  `inquiry_id` int(10) NOT NULL,
  `sender_name` varchar(45) NOT NULL,
  `sender_email` varchar(100) NOT NULL,
  `contact_number` int(11) NOT NULL,
  `inquiry_type` varchar(45) NOT NULL,
  `message_body` text NOT NULL,
  `received_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status_id` int(10) NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiries_tb`
--

INSERT INTO `inquiries_tb` (`inquiry_id`, `sender_name`, `sender_email`, `contact_number`, `inquiry_type`, `message_body`, `received_date`, `status_id`, `is_read`) VALUES
(2, 'Intellectraxis', 'lupellusvonpierre@gmail.com', 2147483647, 'bbookok', 'U NUBBBB', '2025-04-29 15:49:52', 1, 0),
(3, 'Diving', 'lupellusvonpierre@gmail.com', 2147483647, 'bbookok', 'vfssfgfdgsdgs\r\n', '2025-04-29 15:51:33', 1, 0),
(4, 'Room 101', 'pulumbaritjohnlouel@gmail.com', 2147483647, 'bbookok', 'cvgfgsgsdk', '2025-04-29 15:52:21', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `inquiry_replies_tb`
--

CREATE TABLE `inquiry_replies_tb` (
  `reply_id` int(10) NOT NULL,
  `inquiry_id` int(10) NOT NULL,
  `responder_id` int(10) NOT NULL,
  `reply_message` text NOT NULL,
  `replied_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inquiry_status_tb`
--

CREATE TABLE `inquiry_status_tb` (
  `status_id` int(10) NOT NULL,
  `status_name` enum('Unread','Read','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiry_status_tb`
--

INSERT INTO `inquiry_status_tb` (`status_id`, `status_name`) VALUES
(1, 'Unread'),
(2, 'Read');

-- --------------------------------------------------------

--
-- Table structure for table `operation_type_tb`
--

CREATE TABLE `operation_type_tb` (
  `operation_type_id` int(10) NOT NULL,
  `operation_name` varchar(45) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments_tb`
--

CREATE TABLE `payments_tb` (
  `payment_id` int(10) NOT NULL,
  `reservation_id` int(10) NOT NULL,
  `amount_paid` float NOT NULL,
  `date_paid` date NOT NULL,
  `method` varchar(45) NOT NULL,
  `payment_status_id` int(10) NOT NULL,
  `reference_number` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_status_tb`
--

CREATE TABLE `payment_status_tb` (
  `payment_status_id` int(10) NOT NULL,
  `status_name` enum('Paid','Pending','Refund','') NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promo_codes_tb`
--

CREATE TABLE `promo_codes_tb` (
  `promo_code_id` int(10) NOT NULL,
  `code` varchar(45) NOT NULL,
  `discount_percent` float NOT NULL,
  `valid_from` date NOT NULL,
  `valid_to` date NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `refund_status_tb`
--

CREATE TABLE `refund_status_tb` (
  `refund_status_id` int(10) NOT NULL,
  `status_name` enum('Pending','Approved','Processing','Completed','Rejected','Cancelled') NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `refund_tb`
--

CREATE TABLE `refund_tb` (
  `refund_id` int(10) NOT NULL,
  `payment_id` int(10) NOT NULL,
  `amount_refunded` float NOT NULL,
  `date` datetime NOT NULL,
  `method` varchar(45) NOT NULL,
  `approved_by` int(10) NOT NULL,
  `reason` varchar(500) NOT NULL,
  `refund_status_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports_tb`
--

CREATE TABLE `reports_tb` (
  `report_id` int(10) NOT NULL,
  `generated_by` int(10) NOT NULL,
  `report_type` varchar(45) NOT NULL,
  `content` varchar(500) NOT NULL,
  `generated_date` date NOT NULL,
  `report_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservations_tb`
--

CREATE TABLE `reservations_tb` (
  `reservation_id` int(10) NOT NULL,
  `guest_id` int(10) NOT NULL,
  `booking_date` date DEFAULT NULL,
  `check_in_date` datetime NOT NULL,
  `check_out_date` datetime NOT NULL,
  `total_guests` int(10) NOT NULL,
  `reservation_status_id` int(10) NOT NULL,
  `promo_code_id` int(10) DEFAULT NULL,
  `total_amount` float NOT NULL,
  `confirmed_by` int(10) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations_tb`
--

INSERT INTO `reservations_tb` (`reservation_id`, `guest_id`, `booking_date`, `check_in_date`, `check_out_date`, `total_guests`, `reservation_status_id`, `promo_code_id`, `total_amount`, `confirmed_by`, `created_date`) VALUES
(4, 2, '2025-04-29', '2025-04-30 00:00:00', '2025-05-03 00:00:00', 2, 1, NULL, 5000, 2, '2025-04-30 13:24:12');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_details_tb`
--

CREATE TABLE `reservation_details_tb` (
  `details_id` int(10) NOT NULL,
  `reservation_id` int(10) NOT NULL,
  `room_id` int(10) NOT NULL,
  `promo_code_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_rooms_tb`
--

CREATE TABLE `reservation_rooms_tb` (
  `reservation_room_id` int(10) NOT NULL,
  `reservation_id` int(10) NOT NULL,
  `room_id` int(10) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation_status_tb`
--

CREATE TABLE `reservation_status_tb` (
  `reservation_status_id` int(10) NOT NULL,
  `status_name` enum('Cancelled','Pending','Completed','Confirmed') NOT NULL,
  `description` varchar(45) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation_status_tb`
--

INSERT INTO `reservation_status_tb` (`reservation_status_id`, `status_name`, `description`, `created_date`) VALUES
(1, 'Completed', 'Reservation was successfully completed', '2025-04-30 13:21:38'),
(2, 'Pending', 'Reservation is awaiting confirmation', '2025-04-30 13:26:04'),
(3, 'Confirmed', 'Reservation has been confirmed', '2025-04-30 13:28:35'),
(4, 'Cancelled', 'Reservation has been cancelled', '2025-04-30 13:28:35');

-- --------------------------------------------------------

--
-- Table structure for table `response_category_tb`
--

CREATE TABLE `response_category_tb` (
  `response_category_id` int(10) NOT NULL,
  `category_name` varchar(45) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms_tb`
--

CREATE TABLE `rooms_tb` (
  `room_id` int(10) NOT NULL,
  `room_number` varchar(45) NOT NULL,
  `room_type_id` int(10) NOT NULL,
  `room_status_id` int(10) NOT NULL,
  `promo_code_id` int(10) DEFAULT NULL,
  `description` varchar(500) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms_tb`
--

INSERT INTO `rooms_tb` (`room_id`, `room_number`, `room_type_id`, `room_status_id`, `promo_code_id`, `description`, `created_date`) VALUES
(1, '101', 1, 1, NULL, 'Deluxe room with garden view', '2025-04-29 23:02:58'),
(2, '102', 2, 2, NULL, 'Seaview Villa', '2025-04-29 23:05:43'),
(3, '103', 3, 3, NULL, 'Seaview Villa Deluxe', '2025-04-29 23:08:06'),
(4, '101', 4, 4, NULL, 'Deluxe room with garden view', '2025-04-29 23:38:57');

-- --------------------------------------------------------

--
-- Table structure for table `room_pricing_tb`
--

CREATE TABLE `room_pricing_tb` (
  `room_pricing_id` int(10) NOT NULL,
  `room_type_id` int(10) NOT NULL,
  `season_name` varchar(45) NOT NULL,
  `description` varchar(45) NOT NULL,
  `price` float NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_pricing_tb`
--

INSERT INTO `room_pricing_tb` (`room_pricing_id`, `room_type_id`, `season_name`, `description`, `price`, `start_date`, `end_date`, `created_date`) VALUES
(1, 1, 'Peak Season', 'Pricing during holidays and high demand perio', 7000, '2025-12-15 00:00:00', '2026-01-10 00:00:00', '2025-04-29 23:15:05'),
(2, 1, 'Off-Peak Season', 'Lower pricing during low demand periods', 4500, '2025-06-01 00:00:00', '2025-09-15 00:00:00', '2025-04-29 23:15:05'),
(3, 1, 'Regular Season', 'Standard pricing for most of the year', 5000, '2025-01-11 00:00:00', '2025-05-31 00:00:00', '2025-04-29 23:15:05'),
(4, 2, 'Peak Season', 'Pricing during holidays and high demand perio', 6000, '2025-12-15 00:00:00', '2026-01-10 00:00:00', '2025-04-29 23:15:46'),
(5, 2, 'Off-Peak Season', 'Lower pricing during low demand periods', 4000, '2025-06-01 00:00:00', '2025-09-15 00:00:00', '2025-04-29 23:15:46'),
(6, 2, 'Regular Season', 'Standard pricing for most of the year', 4500, '2025-01-11 00:00:00', '2025-05-31 00:00:00', '2025-04-29 23:15:46'),
(7, 3, 'Peak Season', 'Pricing during holidays and high demand perio', 7000, '2025-12-15 00:00:00', '2026-01-10 00:00:00', '2025-04-29 23:15:59'),
(8, 3, 'Off-Peak Season', 'Lower pricing during low demand periods', 4500, '2025-06-01 00:00:00', '2025-09-15 00:00:00', '2025-04-29 23:15:59'),
(9, 3, 'Regular Season', 'Standard pricing for most of the year', 5000, '2025-01-11 00:00:00', '2025-05-31 00:00:00', '2025-04-29 23:15:59');

-- --------------------------------------------------------

--
-- Table structure for table `room_status_tb`
--

CREATE TABLE `room_status_tb` (
  `room_status_id` int(10) NOT NULL,
  `status_name` enum('Available','Reserved','Maintenance','Occupied') NOT NULL,
  `description` varchar(45) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_status_tb`
--

INSERT INTO `room_status_tb` (`room_status_id`, `status_name`, `description`, `created_date`) VALUES
(1, 'Available', 'Room is ready for booking', '2025-04-29 23:02:58'),
(2, 'Reserved', 'Room is on pending to booked', '2025-04-29 23:05:43'),
(3, 'Maintenance', 'Room is in maintenance', '2025-04-29 23:08:06'),
(4, 'Occupied', 'Room is ready for booking', '2025-04-29 23:38:57');

-- --------------------------------------------------------

--
-- Table structure for table `room_type_tb`
--

CREATE TABLE `room_type_tb` (
  `room_type_id` int(10) NOT NULL,
  `room_name` varchar(45) NOT NULL,
  `base_price` float NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room_type_tb`
--

INSERT INTO `room_type_tb` (`room_type_id`, `room_name`, `base_price`, `created_date`) VALUES
(1, 'Deluxe', 5000, '2025-04-29 23:02:58'),
(2, 'King Bed', 5000, '2025-04-29 23:05:43'),
(3, '2 queen beds', 5000, '2025-04-29 23:08:06'),
(4, 'Deluxe', 5000, '2025-04-29 23:38:57'),
(5, 'Deluxe', 5000, '2025-04-29 23:39:21'),
(6, 'Deluxe', 5000, '2025-04-29 23:41:16');

-- --------------------------------------------------------

--
-- Table structure for table `service_requests_tb`
--

CREATE TABLE `service_requests_tb` (
  `request_id` int(10) NOT NULL,
  `reservation_id` int(10) NOT NULL,
  `request_type` varchar(45) NOT NULL,
  `description` varchar(100) NOT NULL,
  `status` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `special_requests`
--

CREATE TABLE `special_requests` (
  `request_id` int(11) NOT NULL,
  `guest_id` int(11) DEFAULT NULL,
  `special_request` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `special_requests`
--

INSERT INTO `special_requests` (`request_id`, `guest_id`, `special_request`) VALUES
(1, NULL, ''),
(2, NULL, 'vhgffuj'),
(3, NULL, 'fgdfgdfgf'),
(4, NULL, 'spa, home service');

-- --------------------------------------------------------

--
-- Table structure for table `users_tb`
--

CREATE TABLE `users_tb` (
  `userid` int(11) NOT NULL,
  `fname` varchar(45) NOT NULL,
  `mname` varchar(45) DEFAULT NULL,
  `lname` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `contact_number` int(11) NOT NULL,
  `role_id` int(10) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `active` tinyint(1) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_tb`
--

INSERT INTO `users_tb` (`userid`, `fname`, `mname`, `lname`, `email`, `contact_number`, `role_id`, `created_date`, `active`, `password`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(2, 'Lupellus', NULL, 'von Pierre', 'lupellusvonpierre@gmail.com', 0, 1, '2025-04-27 13:35:45', 1, 'insan1234', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `role_id` int(10) NOT NULL,
  `role_name` varchar(45) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`role_id`, `role_name`, `description`) VALUES
(1, 'staff', 'staff');

-- --------------------------------------------------------

--
-- Table structure for table `website_selection_tb`
--

CREATE TABLE `website_selection_tb` (
  `section_id` int(10) NOT NULL,
  `title` varchar(45) NOT NULL,
  `content` varchar(500) NOT NULL,
  `picture` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assigned_services_tb`
--
ALTER TABLE `assigned_services_tb`
  ADD PRIMARY KEY (`assigned_id`),
  ADD KEY `request_id` (`request_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `audit_log_tb`
--
ALTER TABLE `audit_log_tb`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `operation_type_id` (`operation_type_id`);

--
-- Indexes for table `cancellations_tb`
--
ALTER TABLE `cancellations_tb`
  ADD PRIMARY KEY (`cancellation_id`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `cancellation_status_id` (`cancellation_status_id`),
  ADD KEY `cancelled_by` (`cancelled_by`);

--
-- Indexes for table `cancellation_status_tb`
--
ALTER TABLE `cancellation_status_tb`
  ADD PRIMARY KEY (`cancellation_status_id`);

--
-- Indexes for table `chatbot_responses_tb`
--
ALTER TABLE `chatbot_responses_tb`
  ADD PRIMARY KEY (`response_id`),
  ADD KEY `response_category_id` (`response_category_id`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `email_templates_tb`
--
ALTER TABLE `email_templates_tb`
  ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `faq_tb`
--
ALTER TABLE `faq_tb`
  ADD PRIMARY KEY (`faq_id`);

--
-- Indexes for table `feedback_tb`
--
ALTER TABLE `feedback_tb`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `guest_id` (`guest_id`),
  ADD KEY `feedback_type_id` (`feedback_type_id`);

--
-- Indexes for table `feedback_type_tb`
--
ALTER TABLE `feedback_type_tb`
  ADD PRIMARY KEY (`feedback_type_id`);

--
-- Indexes for table `guests_tb`
--
ALTER TABLE `guests_tb`
  ADD PRIMARY KEY (`guests_id`),
  ADD KEY `fk_special_request` (`special_request_id`);

--
-- Indexes for table `inquiries_tb`
--
ALTER TABLE `inquiries_tb`
  ADD PRIMARY KEY (`inquiry_id`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `inquiry_replies_tb`
--
ALTER TABLE `inquiry_replies_tb`
  ADD PRIMARY KEY (`reply_id`),
  ADD KEY `inquiry_id` (`inquiry_id`),
  ADD KEY `responder_id` (`responder_id`);

--
-- Indexes for table `inquiry_status_tb`
--
ALTER TABLE `inquiry_status_tb`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `operation_type_tb`
--
ALTER TABLE `operation_type_tb`
  ADD PRIMARY KEY (`operation_type_id`);

--
-- Indexes for table `payments_tb`
--
ALTER TABLE `payments_tb`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `payment_status_id` (`payment_status_id`);

--
-- Indexes for table `payment_status_tb`
--
ALTER TABLE `payment_status_tb`
  ADD PRIMARY KEY (`payment_status_id`);

--
-- Indexes for table `promo_codes_tb`
--
ALTER TABLE `promo_codes_tb`
  ADD PRIMARY KEY (`promo_code_id`);

--
-- Indexes for table `refund_status_tb`
--
ALTER TABLE `refund_status_tb`
  ADD PRIMARY KEY (`refund_status_id`);

--
-- Indexes for table `refund_tb`
--
ALTER TABLE `refund_tb`
  ADD PRIMARY KEY (`refund_id`),
  ADD KEY `payment_id` (`payment_id`),
  ADD KEY `approved_by` (`approved_by`),
  ADD KEY `refund_status_id` (`refund_status_id`);

--
-- Indexes for table `reports_tb`
--
ALTER TABLE `reports_tb`
  ADD PRIMARY KEY (`report_id`),
  ADD KEY `generated_by` (`generated_by`);

--
-- Indexes for table `reservations_tb`
--
ALTER TABLE `reservations_tb`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `guest_id` (`guest_id`),
  ADD KEY `reservation_status_id` (`reservation_status_id`),
  ADD KEY `promo_code_id` (`promo_code_id`),
  ADD KEY `confirmed_by` (`confirmed_by`);

--
-- Indexes for table `reservation_details_tb`
--
ALTER TABLE `reservation_details_tb`
  ADD PRIMARY KEY (`details_id`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `promo_code_id` (`promo_code_id`);

--
-- Indexes for table `reservation_rooms_tb`
--
ALTER TABLE `reservation_rooms_tb`
  ADD PRIMARY KEY (`reservation_room_id`),
  ADD KEY `reservation_id` (`reservation_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `reservation_status_tb`
--
ALTER TABLE `reservation_status_tb`
  ADD PRIMARY KEY (`reservation_status_id`);

--
-- Indexes for table `response_category_tb`
--
ALTER TABLE `response_category_tb`
  ADD PRIMARY KEY (`response_category_id`);

--
-- Indexes for table `rooms_tb`
--
ALTER TABLE `rooms_tb`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `fk_room_type` (`room_type_id`),
  ADD KEY `fk_room_status` (`room_status_id`),
  ADD KEY `fk_promo_code` (`promo_code_id`);

--
-- Indexes for table `room_pricing_tb`
--
ALTER TABLE `room_pricing_tb`
  ADD PRIMARY KEY (`room_pricing_id`),
  ADD KEY `fk_pricing_room_type` (`room_type_id`);

--
-- Indexes for table `room_status_tb`
--
ALTER TABLE `room_status_tb`
  ADD PRIMARY KEY (`room_status_id`);

--
-- Indexes for table `room_type_tb`
--
ALTER TABLE `room_type_tb`
  ADD PRIMARY KEY (`room_type_id`);

--
-- Indexes for table `service_requests_tb`
--
ALTER TABLE `service_requests_tb`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `reservation_id` (`reservation_id`);

--
-- Indexes for table `special_requests`
--
ALTER TABLE `special_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `guest_id` (`guest_id`);

--
-- Indexes for table `users_tb`
--
ALTER TABLE `users_tb`
  ADD PRIMARY KEY (`userid`),
  ADD KEY `fk_users_role` (`role_id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `website_selection_tb`
--
ALTER TABLE `website_selection_tb`
  ADD PRIMARY KEY (`section_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assigned_services_tb`
--
ALTER TABLE `assigned_services_tb`
  MODIFY `assigned_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_log_tb`
--
ALTER TABLE `audit_log_tb`
  MODIFY `log_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cancellations_tb`
--
ALTER TABLE `cancellations_tb`
  MODIFY `cancellation_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cancellation_status_tb`
--
ALTER TABLE `cancellation_status_tb`
  MODIFY `cancellation_status_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chatbot_responses_tb`
--
ALTER TABLE `chatbot_responses_tb`
  MODIFY `response_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_templates_tb`
--
ALTER TABLE `email_templates_tb`
  MODIFY `template_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faq_tb`
--
ALTER TABLE `faq_tb`
  MODIFY `faq_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback_tb`
--
ALTER TABLE `feedback_tb`
  MODIFY `feedback_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback_type_tb`
--
ALTER TABLE `feedback_type_tb`
  MODIFY `feedback_type_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guests_tb`
--
ALTER TABLE `guests_tb`
  MODIFY `guests_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `inquiries_tb`
--
ALTER TABLE `inquiries_tb`
  MODIFY `inquiry_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inquiry_replies_tb`
--
ALTER TABLE `inquiry_replies_tb`
  MODIFY `reply_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inquiry_status_tb`
--
ALTER TABLE `inquiry_status_tb`
  MODIFY `status_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `operation_type_tb`
--
ALTER TABLE `operation_type_tb`
  MODIFY `operation_type_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments_tb`
--
ALTER TABLE `payments_tb`
  MODIFY `payment_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_status_tb`
--
ALTER TABLE `payment_status_tb`
  MODIFY `payment_status_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promo_codes_tb`
--
ALTER TABLE `promo_codes_tb`
  MODIFY `promo_code_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `refund_status_tb`
--
ALTER TABLE `refund_status_tb`
  MODIFY `refund_status_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `refund_tb`
--
ALTER TABLE `refund_tb`
  MODIFY `refund_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reports_tb`
--
ALTER TABLE `reports_tb`
  MODIFY `report_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations_tb`
--
ALTER TABLE `reservations_tb`
  MODIFY `reservation_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reservation_details_tb`
--
ALTER TABLE `reservation_details_tb`
  MODIFY `details_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservation_rooms_tb`
--
ALTER TABLE `reservation_rooms_tb`
  MODIFY `reservation_room_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservation_status_tb`
--
ALTER TABLE `reservation_status_tb`
  MODIFY `reservation_status_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `response_category_tb`
--
ALTER TABLE `response_category_tb`
  MODIFY `response_category_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms_tb`
--
ALTER TABLE `rooms_tb`
  MODIFY `room_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `room_pricing_tb`
--
ALTER TABLE `room_pricing_tb`
  MODIFY `room_pricing_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `room_status_tb`
--
ALTER TABLE `room_status_tb`
  MODIFY `room_status_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `room_type_tb`
--
ALTER TABLE `room_type_tb`
  MODIFY `room_type_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `service_requests_tb`
--
ALTER TABLE `service_requests_tb`
  MODIFY `request_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `special_requests`
--
ALTER TABLE `special_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users_tb`
--
ALTER TABLE `users_tb`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `role_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `website_selection_tb`
--
ALTER TABLE `website_selection_tb`
  MODIFY `section_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assigned_services_tb`
--
ALTER TABLE `assigned_services_tb`
  ADD CONSTRAINT `assigned_services_tb_ibfk_1` FOREIGN KEY (`request_id`) REFERENCES `service_requests_tb` (`request_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `assigned_services_tb_ibfk_2` FOREIGN KEY (`staff_id`) REFERENCES `users_tb` (`userid`) ON UPDATE CASCADE;

--
-- Constraints for table `audit_log_tb`
--
ALTER TABLE `audit_log_tb`
  ADD CONSTRAINT `audit_log_tb_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users_tb` (`userid`) ON UPDATE CASCADE,
  ADD CONSTRAINT `audit_log_tb_ibfk_2` FOREIGN KEY (`operation_type_id`) REFERENCES `operation_type_tb` (`operation_type_id`) ON UPDATE CASCADE;

--
-- Constraints for table `cancellations_tb`
--
ALTER TABLE `cancellations_tb`
  ADD CONSTRAINT `cancellations_tb_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations_tb` (`reservation_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cancellations_tb_ibfk_2` FOREIGN KEY (`cancellation_status_id`) REFERENCES `cancellation_status_tb` (`cancellation_status_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `cancellations_tb_ibfk_3` FOREIGN KEY (`cancelled_by`) REFERENCES `users_tb` (`userid`) ON UPDATE CASCADE;

--
-- Constraints for table `chatbot_responses_tb`
--
ALTER TABLE `chatbot_responses_tb`
  ADD CONSTRAINT `chatbot_responses_tb_ibfk_1` FOREIGN KEY (`response_category_id`) REFERENCES `response_category_tb` (`response_category_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `chatbot_responses_tb_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `users_tb` (`userid`) ON UPDATE CASCADE;

--
-- Constraints for table `feedback_tb`
--
ALTER TABLE `feedback_tb`
  ADD CONSTRAINT `feedback_tb_ibfk_1` FOREIGN KEY (`guest_id`) REFERENCES `guests_tb` (`guests_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `feedback_tb_ibfk_2` FOREIGN KEY (`feedback_type_id`) REFERENCES `feedback_type_tb` (`feedback_type_id`) ON UPDATE CASCADE;

--
-- Constraints for table `guests_tb`
--
ALTER TABLE `guests_tb`
  ADD CONSTRAINT `fk_special_request` FOREIGN KEY (`special_request_id`) REFERENCES `special_requests` (`request_id`);

--
-- Constraints for table `inquiries_tb`
--
ALTER TABLE `inquiries_tb`
  ADD CONSTRAINT `inquiries_tb_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `inquiry_status_tb` (`status_id`) ON UPDATE CASCADE;

--
-- Constraints for table `inquiry_replies_tb`
--
ALTER TABLE `inquiry_replies_tb`
  ADD CONSTRAINT `inquiry_replies_tb_ibfk_1` FOREIGN KEY (`inquiry_id`) REFERENCES `inquiries_tb` (`inquiry_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inquiry_replies_tb_ibfk_2` FOREIGN KEY (`responder_id`) REFERENCES `users_tb` (`userid`) ON UPDATE CASCADE;

--
-- Constraints for table `payments_tb`
--
ALTER TABLE `payments_tb`
  ADD CONSTRAINT `payments_tb_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations_tb` (`reservation_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_tb_ibfk_2` FOREIGN KEY (`payment_status_id`) REFERENCES `payment_status_tb` (`payment_status_id`) ON UPDATE CASCADE;

--
-- Constraints for table `refund_tb`
--
ALTER TABLE `refund_tb`
  ADD CONSTRAINT `refund_tb_ibfk_1` FOREIGN KEY (`payment_id`) REFERENCES `payments_tb` (`payment_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `refund_tb_ibfk_2` FOREIGN KEY (`approved_by`) REFERENCES `users_tb` (`userid`) ON UPDATE CASCADE,
  ADD CONSTRAINT `refund_tb_ibfk_3` FOREIGN KEY (`refund_status_id`) REFERENCES `refund_status_tb` (`refund_status_id`) ON UPDATE CASCADE;

--
-- Constraints for table `reports_tb`
--
ALTER TABLE `reports_tb`
  ADD CONSTRAINT `reports_tb_ibfk_1` FOREIGN KEY (`generated_by`) REFERENCES `users_tb` (`userid`) ON UPDATE CASCADE;

--
-- Constraints for table `reservations_tb`
--
ALTER TABLE `reservations_tb`
  ADD CONSTRAINT `reservations_tb_ibfk_1` FOREIGN KEY (`guest_id`) REFERENCES `guests_tb` (`guests_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_tb_ibfk_2` FOREIGN KEY (`reservation_status_id`) REFERENCES `reservation_status_tb` (`reservation_status_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_tb_ibfk_3` FOREIGN KEY (`promo_code_id`) REFERENCES `promo_codes_tb` (`promo_code_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_tb_ibfk_4` FOREIGN KEY (`confirmed_by`) REFERENCES `users_tb` (`userid`) ON UPDATE CASCADE;

--
-- Constraints for table `reservation_details_tb`
--
ALTER TABLE `reservation_details_tb`
  ADD CONSTRAINT `reservation_details_tb_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations_tb` (`reservation_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_details_tb_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms_tb` (`room_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_details_tb_ibfk_3` FOREIGN KEY (`promo_code_id`) REFERENCES `promo_codes_tb` (`promo_code_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `reservation_rooms_tb`
--
ALTER TABLE `reservation_rooms_tb`
  ADD CONSTRAINT `reservation_rooms_tb_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations_tb` (`reservation_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_rooms_tb_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms_tb` (`room_id`) ON UPDATE CASCADE;

--
-- Constraints for table `rooms_tb`
--
ALTER TABLE `rooms_tb`
  ADD CONSTRAINT `fk_promo_code` FOREIGN KEY (`promo_code_id`) REFERENCES `promo_codes_tb` (`promo_code_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_room_status` FOREIGN KEY (`room_status_id`) REFERENCES `room_status_tb` (`room_status_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_room_type` FOREIGN KEY (`room_type_id`) REFERENCES `room_type_tb` (`room_type_id`) ON UPDATE CASCADE;

--
-- Constraints for table `room_pricing_tb`
--
ALTER TABLE `room_pricing_tb`
  ADD CONSTRAINT `fk_pricing_room_type` FOREIGN KEY (`room_type_id`) REFERENCES `room_type_tb` (`room_type_id`) ON UPDATE CASCADE;

--
-- Constraints for table `service_requests_tb`
--
ALTER TABLE `service_requests_tb`
  ADD CONSTRAINT `service_requests_tb_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations_tb` (`reservation_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `special_requests`
--
ALTER TABLE `special_requests`
  ADD CONSTRAINT `special_requests_ibfk_1` FOREIGN KEY (`guest_id`) REFERENCES `guests_tb` (`guests_id`) ON DELETE CASCADE;

--
-- Constraints for table `users_tb`
--
ALTER TABLE `users_tb`
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `user_roles` (`role_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
