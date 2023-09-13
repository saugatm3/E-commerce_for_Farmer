-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2023 at 06:58 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `provothon`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `question`, `answer`) VALUES
(1, 'hi', 'Hello!'),
(2, 'what is the use of this platform', 'In this platform, you can buy crops directly from the farmers without any third person, and as a farmer, you can also sell your crop.'),
(3, 'who are you', 'i am your assistant.');

-- --------------------------------------------------------

--
-- Table structure for table `crop_details`
--

CREATE TABLE `crop_details` (
  `crop_id` int(11) NOT NULL,
  `crop_name` varchar(100) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `crop_image` varchar(255) DEFAULT NULL,
  `crop_type` varchar(50) NOT NULL,
  `price_per_kg` decimal(10,2) NOT NULL,
  `available_quantity` int(11) NOT NULL,
  `crop_description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crop_details`
--

INSERT INTO `crop_details` (`crop_id`, `crop_name`, `farmer_id`, `crop_image`, `crop_type`, `price_per_kg`, `available_quantity`, `crop_description`) VALUES
(10000, 'raita', 3, 'crop_image/IMG_20220301_171305_Snapseed.jpg', 'rtg', '5.00', 50, 'kjhjkhl,');

-- --------------------------------------------------------

--
-- Table structure for table `customer_details`
--

CREATE TABLE `customer_details` (
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `district` varchar(50) NOT NULL,
  `pin` int(6) NOT NULL,
  `area_name` varchar(100) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_details`
--

INSERT INTO `customer_details` (`customer_id`, `first_name`, `last_name`, `password`, `contact_number`, `email_id`, `district`, `pin`, `area_name`, `profile_image`) VALUES
(1000003, 'rasmi', 'mishra', '$2y$10$TEj6zpksZyF8e067OoxBRelccqq9CTAQkYWYAeulodie36IhxJEd.', '4565768976', 'rasmi@gmail.com', 'Riyadh', 56734, 'bagicha sahi', 'customer_dp/IMG_20220220_173731.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `customer_orders`
--

CREATE TABLE `customer_orders` (
  `order_id` int(11) NOT NULL,
  `crop_id` int(11) NOT NULL,
  `farmer_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `order_status` varchar(50) NOT NULL,
  `price_per_kg` decimal(10,2) NOT NULL,
  `total_order_amount` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `delivered_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_orders`
--

INSERT INTO `customer_orders` (`order_id`, `crop_id`, `farmer_id`, `customer_id`, `order_date`, `order_status`, `price_per_kg`, `total_order_amount`, `total_price`, `delivered_date`) VALUES
(1, 10000, 3, 1000003, '2023-07-14', 'Confirmed', '5.00', '10.00', '50.00', '2023-07-14'),
(3, 10000, 3, 1000003, '2023-07-14', 'Pending', '5.00', '10.00', '50.00', '2023-07-14');

-- --------------------------------------------------------

--
-- Table structure for table `farmers`
--

CREATE TABLE `farmers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `district` varchar(50) NOT NULL,
  `pin` int(6) NOT NULL,
  `area_name` varchar(100) NOT NULL,
  `email_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farmers`
--

INSERT INTO `farmers` (`id`, `first_name`, `last_name`, `password`, `contact_number`, `district`, `pin`, `area_name`, `email_id`) VALUES
(3, 'rajiv', 'illam', '$2y$10$vUYfwG8X.Rt2k0NE0VhNmOI40ygAFMbZ43f16rDAceykEzdpCQigi', '7675463452', 'Riyadh', 56734, 'makka', 'illam@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crop_details`
--
ALTER TABLE `crop_details`
  ADD PRIMARY KEY (`crop_id`),
  ADD KEY `fk_crop_details_farmer` (`farmer_id`);

--
-- Indexes for table `customer_details`
--
ALTER TABLE `customer_details`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_orders`
--
ALTER TABLE `customer_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_customer_orders_crop` (`crop_id`),
  ADD KEY `fk_customer_orders_farmer` (`farmer_id`),
  ADD KEY `fk_customer_orders_customer` (`customer_id`);

--
-- Indexes for table `farmers`
--
ALTER TABLE `farmers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `crop_details`
--
ALTER TABLE `crop_details`
  MODIFY `crop_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10002;

--
-- AUTO_INCREMENT for table `customer_details`
--
ALTER TABLE `customer_details`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000005;

--
-- AUTO_INCREMENT for table `customer_orders`
--
ALTER TABLE `customer_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `farmers`
--
ALTER TABLE `farmers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `crop_details`
--
ALTER TABLE `crop_details`
  ADD CONSTRAINT `fk_crop_details_farmer` FOREIGN KEY (`farmer_id`) REFERENCES `farmers` (`id`);

--
-- Constraints for table `customer_orders`
--
ALTER TABLE `customer_orders`
  ADD CONSTRAINT `fk_customer_orders_crop` FOREIGN KEY (`crop_id`) REFERENCES `crop_details` (`crop_id`),
  ADD CONSTRAINT `fk_customer_orders_customer` FOREIGN KEY (`customer_id`) REFERENCES `customer_details` (`customer_id`),
  ADD CONSTRAINT `fk_customer_orders_farmer` FOREIGN KEY (`farmer_id`) REFERENCES `farmers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
