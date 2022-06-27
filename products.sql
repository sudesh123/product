-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2022 at 05:57 PM
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
-- Database: `products`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` varchar(255) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_image` varchar(1000) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_price`, `product_description`, `product_image`, `created_at`) VALUES
(1, 'Car', '25000', 'Best Car Model', 'tbXIEH.jpg', '2022-06-26 15:35:06'),
(2, 'Bike', '15000', 'Bike Is Best', 'c351f5d3cdcf553f302dbf8d7987323f.jpg', '2022-06-26 15:37:39'),
(3, 'Gold', '500000', 'Best God', 'MMERV2MEYNLV3LZGSRX4BE7M5E.jpg', '2022-06-26 15:39:14'),
(4, 'Shirts', '400', 'Best Shirts', 'types-of-shirts-for-men-bewakoof-blog-1-1610963787.jpg', '2022-06-26 15:40:30'),
(5, 'T shirt', '550', 'Best T shirt', 'x6j4i_512.jpg', '2022-06-26 15:42:04'),
(6, 'Saree', '850', 'Best Saree', 'designer-banarasi-saree-fresh-yellow-designer-banarasi-saree-with-embroidered-silk-blouse-wedding-wardrobe-collection-silk-saree-online-28454596673729_363x@3x_progressive.jpg', '2022-06-26 15:43:32'),
(7, 'Smart Phone', '7600', 'Nice', 'SPARK8T-blue.png', '2022-06-26 15:45:03');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `file_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uploaded_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `file_name`, `uploaded_on`) VALUES
(1, 1, 'tbXIEH1.jpg', '2022-06-26 15:35:06'),
(2, 2, '12244812_453531751522313_7401891787906334477_o-975x1024.jpg', '2022-06-26 15:37:39'),
(3, 3, 'GettyImages-1130532216.jpg', '2022-06-26 15:39:14'),
(4, 4, 't2.jpg', '2022-06-26 15:40:30'),
(5, 5, '817XuR9YMEL__UX569_.jpg', '2022-06-26 15:42:04'),
(6, 6, '91xFztqLz2L__UL1500_.jpg', '2022-06-26 15:43:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
