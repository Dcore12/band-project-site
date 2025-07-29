-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 24, 2025 at 04:17 PM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `suicide_silence_site`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_log`
--

CREATE TABLE `cart_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `status` enum('pending','processing','paid','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_amount`, `status`, `created_at`) VALUES
(8, 5, '0.00', 'cancelled', '2025-07-10 16:27:00'),
(12, 5, '31.98', 'pending', '2025-07-12 07:22:11'),
(13, 7, '62.70', 'processing', '2025-07-12 07:24:12'),
(14, 5, '148.06', 'paid', '2025-07-12 07:27:48'),
(15, 5, '27.98', 'shipped', '2025-07-12 07:30:42'),
(16, 5, '27.98', 'delivered', '2025-07-12 07:33:07'),
(17, 5, '34.89', 'paid', '2025-07-14 13:18:55'),
(18, 8, '34.89', 'pending', '2025-07-24 12:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`) VALUES
(1, 12, 6, 1, '15.99'),
(2, 12, 5, 1, '15.99'),
(3, 13, 10, 1, '21.90'),
(4, 13, 11, 1, '29.90'),
(5, 13, 12, 1, '10.90'),
(6, 14, 5, 2, '15.99'),
(7, 14, 4, 1, '15.99'),
(8, 14, 7, 1, '16.49'),
(9, 14, 8, 4, '20.90'),
(10, 15, 1, 1, '13.99'),
(11, 15, 2, 1, '13.99'),
(12, 16, 1, 1, '13.99'),
(13, 16, 2, 1, '13.99'),
(14, 17, 8, 1, '20.90'),
(15, 17, 2, 1, '13.99'),
(16, 18, 1, 1, '13.99'),
(17, 18, 8, 1, '20.90');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `is_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image`, `created_at`, `active`, `is_deleted`) VALUES
(1, 'The Cleansing (CD)', 'The Cleansing is the debut studio album, released in 2007.', '15.99', 47, 'uploads/prod_68712ae1db411.jpg', '2025-07-11 13:34:34', 1, 0),
(2, 'No Time to Bleed (CD)', 'No Time to Bleed is the second studio album, released in 2009.', '13.99', 44, 'Imagens/Albuns/No_Time_to_Bleed_high-res.jpg', '2025-07-11 13:34:34', 1, 0),
(3, 'The Black Crown (CD)', 'The Black Crown is the third studio album, released in 2011.', '14.99', 39, 'Imagens/Albuns/SS_The_Black_Crown.jpg', '2025-07-11 13:34:34', 1, 0),
(4, 'You Can\'t Stop Me (CD)', 'You Can\'t Stop Me is the fourth studio album, released in 2014.', '15.99', 50, 'Imagens/Albuns/You_Can\'t_Stop_Me_(Suicide_Silence).jpg', '2025-07-11 13:34:34', 1, 0),
(5, 'Suicide Silence (CD)', 'Suicide Silence is the fifth studio album, released in 2017.', '15.99', 35, 'Imagens/Albuns/SuicideSilence2017.jpg', '2025-07-11 13:34:34', 1, 0),
(6, 'Become the Hunter (CD)', 'Become the Hunter is the sixth studio album, released in 2020.', '15.99', 42, 'Imagens/Albuns/Become_the_Hunter.jpg', '2025-07-11 13:34:34', 1, 0),
(7, 'Remember... You Must Die (CD)', 'Latest album with intense themes and heavy sound, released in 2023.', '16.49', 29, 'Imagens/Albuns/SuicideSilenceRYMD.jpg', '2025-07-11 13:34:34', 1, 0),
(8, 'T-Shirt Green Logo', 'Unisex t-shirt with green band logo.', '20.90', 15, 'Imagens/Merch/137762_aw002.jpg', '2025-07-11 13:34:34', 1, 0),
(9, 'T-Shirt Where is your God?', 'T-shirt with art from the track \'Where is your God?\'.', '20.90', 8, 'Imagens/Merch/137769_aw014.jpg', '2025-07-11 13:34:34', 1, 0),
(10, 'T-Shirt Mitch White', 'White t-shirt with Mitch Lucker\'s portrait.', '21.90', 17, 'Imagens/Merch/61KM1CAADtL._AC_UY1000_.jpg', '2025-07-11 13:34:34', 1, 0),
(11, 'Hoodie Pull the trigger', 'Black Hoodie with the lyrics \'Pull the trigger\'.', '29.90', 6, 'Imagens/Merch/suicidesilence_pullthetrigger_tops_hoodie_hoosuitri2_art10-035139_2500000214455_30843-324_nomodel_whitebackground_back.webp', '2025-07-11 13:34:34', 1, 0),
(12, 'Dan Kenny', 'Dan - Bass Action Figure.', '10.90', 12, 'Imagens/Merch/action-figure-dan.jpg', '2025-07-11 13:34:34', 1, 0),
(15, 'teste', NULL, '1.00', 1, 'uploads/prod_6875026889b0e.jpg', '2025-07-11 19:27:13', 1, 1),
(16, 'T-shirt Live Life Hard', NULL, '16.99', 5, 'uploads/prod_687265a2159bd.jpg', '2025-07-12 13:39:46', 1, 1),
(17, 'teste2', NULL, '15.00', 4, '../uploads/prod_68824536df3e0.jpg', '2025-07-24 14:37:42', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `user_type` enum('user','admin') NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `message` text,
  `is_deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `full_name`, `birthdate`, `email`, `password_hash`, `user_type`, `profile_pic`, `message`, `is_deleted`) VALUES
(5, 'DuarteS', 'Duarte Santos', '1987-12-03', 'duarte.n.santos@gmail.com', '$2y$10$1wgL9d7tIcAPGIt2RUgOm.oTpjZBVnKM60xHAW3vXkpZzYtdI7SSK', 'admin', 'uploads/687217485dd03_DuarteS.jpg', 'Olá a todos', 0),
(6, 'Di_byNature', 'Diana Matos', '1988-10-11', 'diana.matos@mail.com', '$2y$10$CA.8qArs.znYwpxJMEmAe.s7rIT/jy1zv3CjmPyq6o7u.VOnlt8Ua', 'user', 'uploads/686e6b922522d_DianaM.jpg', 'Olá a todos', 0),
(7, 'MaraH', 'Mara Harper', '2016-02-18', 'mara@msn.com', '$2y$10$JMCm5BtkYPHc7YvIIRbN8.jehr8aXHderRnuNp4pGOPGJ/ctJ4Ptq', 'user', 'uploads/686f93326f499_20221209_suicide_silence__header.webp', 'Olá mundo', 0),
(8, 'QuebraNozes12', 'Mel Santos', '2022-11-23', 'mel@msn.com', '$2y$10$8/HpiJDmZyWReONZ/4ioX.7oWVjfHr397nIzA.Dke9NYzvBKqPY/2', 'user', '../uploads/68810316b88d0_WhatsApp Image 2025-04-15 at 11.32.46 (2).jpeg', 'ola mundo', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_log`
--
ALTER TABLE `cart_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_ibfk_1` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_log`
--
ALTER TABLE `cart_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
