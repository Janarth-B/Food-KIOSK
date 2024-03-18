-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2024 at 08:33 AM
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
-- Database: `web_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_phoneNum` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`admin_id`, `admin_username`, `admin_password`, `admin_email`, `admin_phoneNum`) VALUES
(1, 'admin_1', '202cb962ac59075b964b07152d234b70', 'admin_1@gmail.com', '011-1111111');

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `food_id` int(11) NOT NULL,
  `kiosk_id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `food_description` text NOT NULL,
  `food_price` decimal(10,2) NOT NULL,
  `food_image` varchar(255) NOT NULL,
  `food_remainingQuantity` int(11) NOT NULL,
  `food_category` varchar(255) NOT NULL,
  `food_availability` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`food_id`, `kiosk_id`, `food_name`, `food_description`, `food_price`, `food_image`, `food_remainingQuantity`, `food_category`, `food_availability`) VALUES
(1, 1, 'Chicken Biryani Rice', 'An authentic arabic biryani rice', 9.00, 'Food_Name_3463.jpg', 0, 'rice', 'Non-Available'),
(2, 1, 'Curry Laksa Mee', 'Malaysian local curry mee.', 8.50, 'Food_Name_1990.jpg', 0, 'mee', 'Non-Available'),
(3, 1, 'Egg Fried Rice', 'A traditional egg fried with rice.', 7.00, 'Food_Name_933.jpg', 0, 'rice', 'Available'),
(4, 1, 'Corn Soup', 'Made from 100% fresh corn.', 5.00, 'Food_Name_1493.jpg', 0, 'soup', 'Available'),
(5, 1, 'Mee Jawa', 'This is mee jawa, not mee rebus.', 7.00, 'Food_Name_5791.jpeg', 0, 'mee', 'Available'),
(6, 1, 'Mee Goreng', 'An authentic indo mee.', 8.00, 'Food_Name_887.jpg', 1, 'mee', 'Available'),
(7, 1, 'Kopi Ice', 'Iced milk coffee.', 3.50, 'Food_Name_2158.jpg', 23, 'drink', 'Available'),
(8, 1, 'Potato Soup', '100% natural ingredient.', 6.00, 'Food_Name_5268.jpg', 13, 'soup', 'Available'),
(9, 1, 'Fried Chicken Plate', 'Crispy & crunchy fried chickens.', 25.00, 'Food_Name_3024.jpeg', 2, 'sides', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `food_vendor`
--

CREATE TABLE `food_vendor` (
  `vendor_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `vendor_username` varchar(255) NOT NULL,
  `vendor_password` varchar(255) NOT NULL,
  `vendor_email` varchar(255) NOT NULL,
  `vendor_phoneNum` varchar(20) NOT NULL,
  `vendor_registerStatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food_vendor`
--

INSERT INTO `food_vendor` (`vendor_id`, `admin_id`, `vendor_username`, `vendor_password`, `vendor_email`, `vendor_phoneNum`, `vendor_registerStatus`) VALUES
(1, 1, 'vendor_1', '202cb962ac59075b964b07152d234b70', 'vendor_1@gmail.com', '019-8765432', 'approve'),
(2, 1, 'vendor_2', '202cb962ac59075b964b07152d234b70', 'vendor_2@gmail.com', '019-8765432', 'approve'),
(3, 1, 'vendor_3', '202cb962ac59075b964b07152d234b70', 'vendor_3@gmail.com', '019-8765432', 'approve');

-- --------------------------------------------------------

--
-- Table structure for table `kiosk`
--

CREATE TABLE `kiosk` (
  `kiosk_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `kiosk_name` varchar(255) NOT NULL,
  `kiosk_businessDay` int(11) NOT NULL,
  `kiosk_openHour` int(11) NOT NULL,
  `kiosk_closeHour` int(11) NOT NULL,
  `kiosk_picture` varchar(255) NOT NULL,
  `kiosk_status` varchar(5) NOT NULL,
  `kiosk_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kiosk`
--

INSERT INTO `kiosk` (`kiosk_id`, `vendor_id`, `kiosk_name`, `kiosk_businessDay`, `kiosk_openHour`, `kiosk_closeHour`, `kiosk_picture`, `kiosk_status`, `kiosk_description`) VALUES
(1, 1, 'Cafe Zul', 5, 8, 20, 'Kiosk1.jpg', 'Open', 'Delicious, Tasty and Yummy Food'),
(2, 2, 'Cafe Abu', 6, 10, 20, 'Kiosk2.jpg', 'Close', 'Clean food, Ganges flavour, Masala taste'),
(3, 3, 'Cafe Shawarma', 5, 10, 22, 'Kiosk3.jpg', 'Close', 'Traditional arabic cuisines are provided here.');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orders_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `orders_subtotal` decimal(10,2) NOT NULL,
  `orders_status` varchar(50) DEFAULT NULL,
  `orders_collectTime` datetime NOT NULL,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orders_id`, `user_id`, `vendor_id`, `orders_subtotal`, `orders_status`, `orders_collectTime`, `order_date`) VALUES
(1, 1, 1, 9.00, 'Completed', '2023-01-02 16:34:29', '2023-01-02'),
(2, 1, 1, 4.00, 'Completed', '2023-01-10 18:14:04', '2023-01-10'),
(3, 2, 1, 5.00, 'Completed', '2023-01-18 18:14:43', '2023-01-18'),
(4, 4, 1, 8.00, 'Completed', '2023-02-06 16:44:58', '2023-02-06'),
(5, 1, 1, 10.00, 'Completed', '2023-02-14 16:51:07', '2023-02-14'),
(6, 1, 1, 7.00, 'Completed', '2023-02-28 18:16:10', '2023-02-28'),
(7, 1, 1, 25.00, 'Completed', '2023-03-04 18:16:38', '2023-03-04'),
(8, 1, 1, 7.00, 'Completed', '2023-03-17 18:22:28', '2023-03-17'),
(9, 1, 1, 3.50, 'Completed', '2023-03-29 18:22:50', '2023-03-29'),
(10, 1, 1, 3.50, 'Completed', '2023-04-03 18:24:11', '2023-04-03'),
(11, 1, 1, 5.00, 'Completed', '2023-04-14 18:24:53', '2023-04-14'),
(12, 3, 1, 7.00, 'Completed', '2023-05-01 18:25:19', '2023-05-01'),
(13, 3, 1, 8.00, 'Completed', '2023-05-17 17:11:39', '2023-05-17'),
(14, 3, 1, 7.00, 'Completed', '2023-05-28 18:27:08', '2023-05-28'),
(15, 3, 1, 8.00, 'Completed', '2023-06-03 18:27:56', '2023-06-03'),
(16, 3, 1, 8.00, 'Completed', '2023-06-12 18:28:29', '2023-06-12'),
(17, 3, 1, 9.50, 'Completed', '2023-06-23 18:28:50', '2023-06-23'),
(18, 3, 1, 25.00, 'Completed', '2023-07-05 18:29:12', '2023-07-05'),
(19, 2, 1, 8.00, 'Completed', '2023-07-14 17:16:40', '2023-07-14'),
(20, 2, 1, 6.00, 'Completed', '2023-07-26 18:30:00', '2023-07-26'),
(21, 2, 1, 3.50, 'Completed', '2023-08-10 18:30:22', '2023-08-10'),
(22, 2, 1, 9.50, 'Completed', '2023-08-19 18:30:42', '2023-08-19'),
(23, 2, 1, 25.00, 'Completed', '2023-08-31 18:31:00', '2023-08-31'),
(24, 2, 1, 6.00, 'Completed', '2023-09-04 18:31:16', '2023-09-04'),
(25, 2, 1, 6.00, 'Completed', '2023-09-16 18:31:32', '2023-09-16'),
(26, 2, 1, 8.00, 'Completed', '2023-09-25 18:31:51', '2023-09-25'),
(27, 2, 1, 7.00, 'Completed', '2023-10-06 18:32:10', '2023-10-06'),
(28, 2, 1, 8.00, 'Completed', '2023-10-18 18:32:30', '2023-10-18'),
(29, 2, 1, 8.00, 'Completed', '2023-10-31 18:32:45', '2023-10-31'),
(30, 2, 1, 8.00, 'Completed', '2023-11-03 18:32:58', '2023-11-03'),
(31, 2, 1, 5.00, 'Completed', '2023-11-13 18:33:11', '2023-11-13'),
(32, 2, 1, 8.00, 'Completed', '2023-11-23 18:33:28', '2023-11-23'),
(33, 2, 1, 10.50, 'Completed', '2024-01-29 22:21:27', '2024-01-29'),
(34, 4, 1, 8.00, 'Completed', '2023-12-18 17:24:15', '2023-12-18'),
(35, 4, 1, 24.00, 'Completed', '2023-12-25 18:34:09', '2023-12-25'),
(36, 4, 1, 12.00, 'Completed', '2023-12-30 18:34:21', '2023-12-30'),
(37, 1, 1, 5.00, 'Completed', '2024-01-15 17:34:13', '2024-01-15'),
(39, 1, 1, 37.00, 'Completed', '2024-01-29 22:09:57', '2024-01-29'),
(40, 5, 1, 11.50, 'Completed', '2024-01-29 22:29:15', '2024-01-29'),
(41, 1, 1, 16.50, 'Completed', '2024-01-31 11:52:35', '2024-01-31');

-- --------------------------------------------------------

--
-- Table structure for table `orders_item`
--

CREATE TABLE `orders_item` (
  `food_id` int(11) NOT NULL,
  `orders_id` int(11) NOT NULL,
  `item_quantity` int(11) NOT NULL,
  `special_instructions` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders_item`
--

INSERT INTO `orders_item` (`food_id`, `orders_id`, `item_quantity`, `special_instructions`) VALUES
(3, 1, 2, 'tanpa nasi'),
(3, 8, 1, ''),
(3, 12, 1, ''),
(3, 14, 1, ''),
(3, 27, 1, ''),
(3, 36, 1, ''),
(3, 39, 1, ''),
(3, 41, 1, ''),
(4, 2, 1, ''),
(4, 5, 2, ''),
(4, 11, 1, ''),
(4, 31, 1, ''),
(4, 36, 1, ''),
(4, 37, 1, ''),
(5, 3, 1, ''),
(5, 6, 1, ''),
(6, 4, 1, 'without mee'),
(6, 13, 1, ''),
(6, 15, 1, ''),
(6, 16, 1, ''),
(6, 19, 1, ''),
(6, 26, 1, ''),
(6, 28, 1, ''),
(6, 29, 1, ''),
(6, 30, 1, ''),
(6, 32, 1, ''),
(6, 34, 1, ''),
(6, 40, 1, ''),
(7, 9, 1, 'hot coffee'),
(7, 10, 1, ''),
(7, 17, 1, ''),
(7, 21, 1, ''),
(7, 22, 1, ''),
(7, 33, 3, ''),
(7, 39, 2, ''),
(7, 40, 1, ''),
(7, 41, 1, ''),
(8, 17, 1, ''),
(8, 20, 1, ''),
(8, 22, 1, ''),
(8, 24, 1, ''),
(8, 25, 1, ''),
(8, 35, 4, ''),
(8, 41, 1, ''),
(9, 7, 1, ''),
(9, 18, 1, ''),
(9, 23, 1, ''),
(9, 39, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `orders_id` int(11) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_dateTime` datetime NOT NULL,
  `points_received` int(11) NOT NULL,
  `points_redeemed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `orders_id`, `payment_method`, `payment_dateTime`, `points_received`, `points_redeemed`) VALUES
(1, 1, 'Membership Card', '2024-01-15 16:33:23', 1, 5),
(2, 2, 'Cash', '2024-01-15 16:36:56', 0, 1),
(3, 3, 'Cash', '2024-01-15 16:38:39', 0, 2),
(4, 4, 'Cash', '2024-01-15 16:39:48', 0, 0),
(5, 5, 'Cash', '2024-01-15 16:50:52', 1, 0),
(6, 6, 'Cash', '2024-01-15 16:52:20', 0, 0),
(7, 7, 'Cash', '2024-01-15 16:52:34', 2, 0),
(8, 8, 'Cash', '2024-01-15 16:52:48', 0, 0),
(9, 9, 'Cash', '2024-01-15 16:54:55', 0, 0),
(10, 10, 'Cash', '2024-01-15 16:55:20', 0, 0),
(11, 11, 'Cash', '2024-01-15 16:57:16', 0, 0),
(12, 12, 'Cash', '2024-01-15 17:00:38', 0, 0),
(13, 13, 'Cash', '2024-01-15 17:10:56', 0, 0),
(14, 14, 'Cash', '2024-01-15 17:12:08', 0, 0),
(15, 15, 'Cash', '2024-01-15 17:12:23', 0, 0),
(16, 16, 'Cash', '2024-01-15 17:12:47', 0, 0),
(17, 17, 'Cash', '2024-01-15 17:14:15', 0, 0),
(18, 18, 'Cash', '2024-01-15 17:15:39', 2, 0),
(19, 19, 'Cash', '2024-01-15 17:16:33', 0, 0),
(20, 20, 'Cash', '2024-01-15 17:17:00', 0, 0),
(21, 21, 'Cash', '2024-01-15 17:17:34', 0, 0),
(22, 22, 'Cash', '2024-01-15 17:18:00', 0, 0),
(23, 23, 'Cash', '2024-01-15 17:18:24', 2, 0),
(24, 24, 'Cash', '2024-01-15 17:19:23', 0, 0),
(25, 25, 'Cash', '2024-01-15 17:19:42', 0, 0),
(26, 26, 'Cash', '2024-01-15 17:20:00', 0, 0),
(27, 27, 'Cash', '2024-01-15 17:20:17', 0, 0),
(28, 28, 'Cash', '2024-01-15 17:20:33', 0, 0),
(29, 29, 'Cash', '2024-01-15 17:21:37', 0, 0),
(30, 30, 'Cash', '2024-01-15 17:21:57', 0, 0),
(31, 31, 'Cash', '2024-01-15 17:22:18', 0, 0),
(32, 32, 'Cash', '2024-01-15 17:22:34', 0, 0),
(33, 33, 'Cash', '2024-01-15 17:22:53', 1, 0),
(34, 34, 'Cash', '2024-01-15 17:24:08', 0, 0),
(35, 35, 'Cash', '2024-01-15 17:24:32', 0, 0),
(36, 36, 'Cash', '2024-01-15 17:25:03', 0, 0),
(37, 37, 'Cash', '2024-01-15 17:34:03', 0, 0),
(39, 39, 'Cash', '2024-01-29 22:06:39', 3, 2),
(41, 40, 'Cash', '2024-01-29 22:27:59', 0, 0),
(42, 41, 'Cash', '2024-01-31 11:51:37', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `registered_or_general_user`
--

CREATE TABLE `registered_or_general_user` (
  `user_id` int(11) NOT NULL,
  `registered_phoneNum` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered_or_general_user`
--

INSERT INTO `registered_or_general_user` (`user_id`, `registered_phoneNum`) VALUES
(1, '012-3456789'),
(2, '012-3456789'),
(3, '012-3456789'),
(4, '010-1010101'),
(5, '0112233445566');

-- --------------------------------------------------------

--
-- Table structure for table `registered_user`
--

CREATE TABLE `registered_user` (
  `user_id` int(11) NOT NULL,
  `registered_username` varchar(255) NOT NULL,
  `registered_password` varchar(255) NOT NULL,
  `registered_email` varchar(255) NOT NULL,
  `registered_points` int(11) NOT NULL,
  `registered_cardBalance` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `registered_user`
--

INSERT INTO `registered_user` (`user_id`, `registered_username`, `registered_password`, `registered_email`, `registered_points`, `registered_cardBalance`) VALUES
(1, 'user_1', '202cb962ac59075b964b07152d234b70', 'user_1@gmail.com', 9, 1.00),
(2, 'user_2', '202cb962ac59075b964b07152d234b70', 'user_2@gmail.com', 11, 10.00),
(3, 'user_3', '202cb962ac59075b964b07152d234b70', 'user_3@gmail.com', 10, 10.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`food_id`),
  ADD KEY `kiosk_id` (`kiosk_id`);

--
-- Indexes for table `food_vendor`
--
ALTER TABLE `food_vendor`
  ADD PRIMARY KEY (`vendor_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `kiosk`
--
ALTER TABLE `kiosk`
  ADD PRIMARY KEY (`kiosk_id`),
  ADD KEY `vendor_id` (`vendor_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orders_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `orders_item`
--
ALTER TABLE `orders_item`
  ADD PRIMARY KEY (`food_id`,`orders_id`),
  ADD KEY `orders_id` (`orders_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `orders_id` (`orders_id`);

--
-- Indexes for table `registered_or_general_user`
--
ALTER TABLE `registered_or_general_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `registered_user`
--
ALTER TABLE `registered_user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `food_vendor`
--
ALTER TABLE `food_vendor`
  MODIFY `vendor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kiosk`
--
ALTER TABLE `kiosk`
  MODIFY `kiosk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orders_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `registered_or_general_user`
--
ALTER TABLE `registered_or_general_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `registered_user`
--
ALTER TABLE `registered_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `food_ibfk_1` FOREIGN KEY (`kiosk_id`) REFERENCES `kiosk` (`kiosk_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `food_vendor`
--
ALTER TABLE `food_vendor`
  ADD CONSTRAINT `food_vendor_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `administrator` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kiosk`
--
ALTER TABLE `kiosk`
  ADD CONSTRAINT `kiosk_ibfk_1` FOREIGN KEY (`vendor_id`) REFERENCES `food_vendor` (`vendor_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `registered_or_general_user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders_item`
--
ALTER TABLE `orders_item`
  ADD CONSTRAINT `orders_item_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `food` (`food_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_item_ibfk_2` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`orders_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`orders_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
