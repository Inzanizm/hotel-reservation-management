-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 01, 2025 at 01:48 PM
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
-- Database: `hotel-reservation-management`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(100) DEFAULT NULL,
  `lastname` varchar(255) NOT NULL,
  `contact_number` int(11) NOT NULL,
  `role_id` int(10) NOT NULL,
  `created_date` datetime DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `reset_token_hash` varchar(64) DEFAULT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userid`, `email`, `password`, `firstname`, `middlename`, `lastname`, `contact_number`, `role_id`, `created_date`, `active`, `reset_token_hash`, `reset_token_expires_at`) VALUES
(1, 'admin1@resort.com', 'admin123', 'Ephraim', NULL, 'San Jose', 0, 0, NULL, 0, NULL, NULL),
(2, 'lupellusvonpierre@gmail.com', 'insan123', 'Lupellus', NULL, 'von Pierre', 0, 0, NULL, 0, NULL, NULL),
(3, 'staff1@resort.com', 'staffpass789', 'John Louel', NULL, 'Pulumbarit', 0, 0, NULL, 0, NULL, NULL),
(4, 'frontdesk@resort.com', 'frontdesk321', 'Julius', NULL, 'Portugues', 0, 0, NULL, 0, NULL, NULL),
(5, 'admin2@resort.com', 'password999', 'Sean Stephan Miguel', NULL, 'Sumugat', 0, 0, NULL, 0, NULL, NULL),
(6, 'manager@resort.com', 'manager456', 'Romina', NULL, 'Villones', 0, 0, NULL, 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `reset_token_hash` (`reset_token_hash`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
