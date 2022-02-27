-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2022 at 10:37 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-commerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `notes` longtext DEFAULT NULL,
  `street` varchar(50) NOT NULL,
  `building` varchar(50) NOT NULL,
  `floor` varchar(50) NOT NULL,
  `flat` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_fk_id` bigint(20) UNSIGNED NOT NULL,
  `region_fk_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `name-ar` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `img` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name_en`, `name-ar`, `status`, `img`, `created_at`, `updated_at`) VALUES
(1, 'Apple', '', 1, '', '2022-02-23 08:23:01', '2022-02-27 08:25:10'),
(2, 'Dell', '', 1, '', '2022-02-23 08:24:01', '2022-02-27 08:25:20'),
(3, 'HP', '', 1, '', '2022-02-23 08:24:21', '2022-02-27 08:25:25'),
(4, 'Nivea', 'نيفيا', 1, '', '2022-02-23 08:24:32', '2022-02-27 08:25:29'),
(5, 'Kiko', 'كيكو', 1, '', '2022-02-23 08:24:47', '2022-02-27 08:25:32'),
(6, 'Ikea', 'ايكيا', 1, '', '2022-02-23 08:24:57', '2022-02-27 08:25:36');

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `quantity` smallint(3) UNSIGNED NOT NULL DEFAULT 1,
  `product_fk_id` bigint(20) UNSIGNED NOT NULL,
  `user_fk_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(50) NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `img` varchar(50) NOT NULL DEFAULT 'default.jpg',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name_ar`, `name_en`, `status`, `img`, `created_at`, `updated_at`) VALUES
(1, 'خضروات', 'vegetable', 1, 'default.jpg', '2022-02-23 08:27:40', '2022-02-27 08:28:01'),
(2, 'الكترونيات', 'electronics', 1, 'default.jpg', '2022-02-23 08:27:47', '2022-02-27 08:28:04'),
(3, 'مطبخ', 'kitchin', 1, 'default.jpg', '2022-02-23 08:27:54', '2022-02-27 08:28:08'),
(4, 'عناية للجسم', 'body care', 1, 'default.jpg', '2022-02-23 08:27:57', '2022-02-27 08:28:14');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `name_ar` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` mediumint(5) UNSIGNED NOT NULL,
  `max_usage_number` tinyint(3) UNSIGNED NOT NULL,
  `max_usage_number_per_user` tinyint(3) UNSIGNED NOT NULL,
  `discount` smallint(5) UNSIGNED NOT NULL,
  `dis_type` varchar(50) NOT NULL,
  `start_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_at` timestamp NULL DEFAULT NULL,
  `max_dis_value` decimal(18,2) NOT NULL,
  `min_dis_value` decimal(18,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL,
  `title_ar` longtext NOT NULL,
  `title_en` longtext NOT NULL,
  `img` varchar(50) NOT NULL,
  `start_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `end_at` timestamp NULL DEFAULT NULL,
  `discount` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL,
  `total_price` decimal(18,2) NOT NULL,
  `payment_fk_id` bigint(20) UNSIGNED NOT NULL,
  `coupon_fk_id` bigint(20) UNSIGNED NOT NULL,
  `address_fk_id` bigint(20) UNSIGNED NOT NULL,
  `delivered_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `status` tinyint(1) NOT NULL,
  `payment_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payments_users`
--

CREATE TABLE `payments_users` (
  `payment_fk_id` bigint(20) UNSIGNED NOT NULL,
  `user_fk_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `privilege`
--

CREATE TABLE `privilege` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `privilege_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `privileges_users`
--

CREATE TABLE `privileges_users` (
  `user_fk_id` bigint(20) UNSIGNED NOT NULL,
  `privilege_fk_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(50) NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `desc_en` longtext NOT NULL,
  `desc_ar` longtext NOT NULL,
  `status` tinyint(1) NOT NULL,
  `img` varchar(50) NOT NULL DEFAULT 'default.jpg',
  `price` decimal(18,2) UNSIGNED NOT NULL,
  `quantity` smallint(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `brand_fk_id` bigint(20) UNSIGNED NOT NULL,
  `subcatergories_fk_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name_ar`, `name_en`, `desc_en`, `desc_ar`, `status`, `img`, `price`, `quantity`, `created_at`, `updated_at`, `brand_fk_id`, `subcatergories_fk_id`) VALUES
(1, 'ايفون بلس', 'Iphone plus', 'Details', 'تفاصيل', 1, 'iphone.jpg', '21000.00', 50, '2022-02-23 17:32:06', '2022-02-27 09:05:27', 1, 1),
(2, 'اطباق عشاء', 'Dinner Dishes', 'Details', 'تفاصيل', 1, 'dinner.jpg', '5000.00', 10, '2022-02-23 17:40:18', '2022-02-27 18:10:41', 6, 5),
(3, 'نوت بوك', 'note book', 'Details', 'تفاصيل', 1, 'hpnotebook.jpg', '15000.00', 5, '2022-02-23 17:35:12', '2022-02-27 09:05:35', 3, 2),
(4, 'ديل جميز', 'Dell Games', 'Details', 'تفاصيل', 1, 'dell.jpg', '17000.00', 4, '2022-02-23 17:40:18', '2022-02-27 09:05:42', 2, 2),
(5, 'نوت بوك برو', 'note book pro', 'Details', 'تفاصيل', 1, 'hpnotebook0.jpg', '15000.00', 5, '2022-02-23 17:35:39', '2022-02-27 09:05:48', 3, 2),
(6, 'كريم', 'Cream', 'Details', 'تفاصيل', 1, 'Nivea.jpg', '50.00', 1, '2022-02-23 17:34:04', '2022-02-27 09:05:53', 4, 4);

-- --------------------------------------------------------

--
-- Stand-in structure for view `products_details`
-- (See below for the actual view)
--
CREATE TABLE `products_details` (
`id` bigint(20) unsigned
,`name_ar` varchar(50)
,`name_en` varchar(50)
,`desc_en` longtext
,`desc_ar` longtext
,`status` tinyint(1)
,`img` varchar(50)
,`price` decimal(18,2) unsigned
,`quantity` smallint(6)
,`created_at` timestamp
,`updated_at` timestamp
,`brand_fk_id` bigint(20) unsigned
,`subcatergories_fk_id` bigint(20) unsigned
,`sub_name_en` varchar(50)
,`brand_name_en` varchar(50)
,`category_id` bigint(20) unsigned
,`category_name_en` varchar(50)
,`reviews_count` bigint(21)
,`reviews_average` decimal(4,0)
);

-- --------------------------------------------------------

--
-- Table structure for table `products_offers`
--

CREATE TABLE `products_offers` (
  `product-fk-id` bigint(20) UNSIGNED NOT NULL,
  `offer_fk_id` bigint(20) UNSIGNED NOT NULL,
  `final_price` decimal(18,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `products_orders`
--

CREATE TABLE `products_orders` (
  `product_fk_id` bigint(20) UNSIGNED NOT NULL,
  `order_fk_id` bigint(20) UNSIGNED NOT NULL,
  `price` decimal(18,2) NOT NULL,
  `quantity` smallint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `regions`
--

CREATE TABLE `regions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `name_ar` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `city_fk_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `value` tinyint(1) UNSIGNED NOT NULL,
  `product_fk_id` bigint(20) UNSIGNED NOT NULL,
  `user_fk_id` bigint(20) UNSIGNED NOT NULL,
  `comment` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`value`, `product_fk_id`, `user_fk_id`, `comment`, `created_at`, `updated_at`) VALUES
(3, 1, 3, 'good', '2022-02-23 17:00:39', '2022-02-27 17:00:39'),
(3, 2, 3, 'not bad', '2022-02-23 16:58:19', '2022-02-27 16:58:19'),
(5, 2, 6, 'very good', '2022-02-23 16:58:19', '2022-02-27 16:58:19'),
(2, 3, 3, 'good', '2022-02-23 18:59:42', '2022-02-27 18:59:42'),
(5, 3, 6, 'excellent', '2022-02-23 17:20:31', '2022-02-27 17:20:31'),
(3, 4, 4, 'good', '2022-02-23 17:20:31', '2022-02-27 17:20:31'),
(2, 4, 6, 'eeee', '2022-02-23 18:53:23', '2022-02-27 18:53:23'),
(4, 5, 3, 'fine', '2022-02-23 17:00:39', '2022-02-27 17:00:39');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name_ar` varchar(50) NOT NULL,
  `name_en` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `img` varchar(50) NOT NULL DEFAULT 'default.jpg',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `categories_fk_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `name_ar`, `name_en`, `status`, `img`, `created_at`, `updated_at`, `categories_fk_id`) VALUES
(1, 'موبيلات', 'mobiles', 1, 'default.jpg', '2022-02-23 16:16:25', '2022-02-27 16:16:25', 2),
(2, 'لابات', 'laptops', 1, 'default.jpg', '2022-02-23 16:16:25', '2022-02-27 16:16:25', 2),
(3, 'عناية للشعر', 'hair care', 1, 'default.jpg', '2022-02-23 16:17:25', '2022-02-27 09:00:23', 4),
(4, 'عناية بالبشرة', 'face care', 1, 'default.jpg', '2022-02-23 16:17:25', '2022-02-27 09:00:32', 4),
(5, 'ادوات التقديم', 'serving equipments', 1, 'default.jpg', '2022-02-23 16:20:57', '2022-02-27 09:00:40', 3),
(6, 'ادوات اعداد الطعام', 'food preparation equipments', 1, 'default.jpg', '2022-02-23 16:20:57', '2022-02-27 09:00:48', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `gender` enum('m','f') NOT NULL,
  `phone` varchar(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `password` longtext NOT NULL,
  `img` varchar(50) NOT NULL DEFAULT 'default.jpg',
  `code` mediumint(5) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `gender`, `phone`, `email`, `status`, `password`, `img`, `code`, `created_at`, `updated_at`) VALUES
(3, 'yasmin ', 'f', '01002789942', 'yasmin@gmail.com', 0, 'db2fd4255908bda9761fdafa9eeeb1eff6cb609a', 'default.jpg', 99999, '2022-02-23 18:14:33', '2022-02-27 21:36:04'),
(4, 'heba', 'f', '01210332246', 'heba@gmail.com', 1, 'db2fd4255908bda9761fdafa9eeeb1eff6cb609a', 'default.jpg', 74281, '2022-02-23 18:16:19', '2022-02-27 09:15:02'),
(6, 'raghad', 'f', '01210332245', 'raghad@gmail.com', 0, 'db2fd4255908bda9761fdafa9eeeb1eff6cb609a', 'default.jpg', 63464, '2022-02-23 18:21:43', '2022-02-27 09:14:42'),
(13, 'mohammed', 'm', '01244556677', 'mohammed@gmail.com', 1, 'db2fd4255908bda9761fdafa9eeeb1eff6cb609a', 'default.jpg', 17042, '2022-02-23 17:40:40', '2022-02-27 09:16:24');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `products_fk_id` bigint(20) UNSIGNED NOT NULL,
  `users_fk_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure for view `products_details`
--
DROP TABLE IF EXISTS `products_details`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `products_details`  AS   (select `products`.`id` AS `id`,`products`.`name_ar` AS `name_ar`,`products`.`name_en` AS `name_en`,`products`.`desc_en` AS `desc_en`,`products`.`desc_ar` AS `desc_ar`,`products`.`status` AS `status`,`products`.`img` AS `img`,`products`.`price` AS `price`,`products`.`quantity` AS `quantity`,`products`.`created_at` AS `created_at`,`products`.`updated_at` AS `updated_at`,`products`.`brand_fk_id` AS `brand_fk_id`,`products`.`subcatergories_fk_id` AS `subcatergories_fk_id`,`subcategories`.`name_en` AS `sub_name_en`,`brands`.`name_en` AS `brand_name_en`,`categories`.`id` AS `category_id`,`categories`.`name_en` AS `category_name_en`,count(`products`.`id`) AS `reviews_count`,round(if(avg(`reviews`.`value`) is null,0,avg(`reviews`.`value`)),0) AS `reviews_average` from ((((`products` left join `subcategories` on(`products`.`subcatergories_fk_id` = `subcategories`.`id`)) join `brands` on(`brands`.`id` = `products`.`brand_fk_id`)) join `categories` on(`categories`.`id` = `subcategories`.`categories_fk_id`)) left join `reviews` on(`reviews`.`product_fk_id` = `products`.`id`)) where `products`.`status` = 1 group by `products`.`id` order by `products`.`price`,`products`.`name_en`)  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_regions_fk` (`region_fk_id`),
  ADD KEY `addresses_users_fk` (`user_fk_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`user_fk_id`,`product_fk_id`),
  ADD KEY `carts_products_fk` (`product_fk_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_orders` (`payment_fk_id`),
  ADD KEY `coupons_orders` (`coupon_fk_id`),
  ADD KEY `addresses_orders` (`address_fk_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments_users`
--
ALTER TABLE `payments_users`
  ADD PRIMARY KEY (`payment_fk_id`,`user_fk_id`),
  ADD KEY `Users_fk` (`user_fk_id`);

--
-- Indexes for table `privilege`
--
ALTER TABLE `privilege`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privileges_users`
--
ALTER TABLE `privileges_users`
  ADD PRIMARY KEY (`user_fk_id`,`privilege_fk_id`),
  ADD KEY `privileges_fk` (`privilege_fk_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brands_products_fk` (`brand_fk_id`),
  ADD KEY `subcategories_products_fk` (`subcatergories_fk_id`);

--
-- Indexes for table `products_offers`
--
ALTER TABLE `products_offers`
  ADD PRIMARY KEY (`product-fk-id`,`offer_fk_id`),
  ADD KEY `offers_fk` (`offer_fk_id`);

--
-- Indexes for table `products_orders`
--
ALTER TABLE `products_orders`
  ADD PRIMARY KEY (`product_fk_id`,`order_fk_id`),
  ADD KEY `orders_fk` (`order_fk_id`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cities_regions_fk` (`city_fk_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`product_fk_id`,`user_fk_id`),
  ADD KEY `reviews_users_fk` (`user_fk_id`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_subcategories_fk` (`categories_fk_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`products_fk_id`,`users_fk_id`),
  ADD KEY `favs_users_fk` (`users_fk_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `privilege`
--
ALTER TABLE `privilege`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_regions_fk` FOREIGN KEY (`region_fk_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `addresses_users_fk` FOREIGN KEY (`user_fk_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_products_fk` FOREIGN KEY (`product_fk_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `carts_users_fk` FOREIGN KEY (`user_fk_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `addresses_orders` FOREIGN KEY (`address_fk_id`) REFERENCES `addresses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `coupons_orders` FOREIGN KEY (`coupon_fk_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_orders` FOREIGN KEY (`payment_fk_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payments_users`
--
ALTER TABLE `payments_users`
  ADD CONSTRAINT `Users_fk` FOREIGN KEY (`user_fk_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `payments_fk` FOREIGN KEY (`payment_fk_id`) REFERENCES `payments` (`id`);

--
-- Constraints for table `privileges_users`
--
ALTER TABLE `privileges_users`
  ADD CONSTRAINT `privileges_fk` FOREIGN KEY (`privilege_fk_id`) REFERENCES `privilege` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `privileges_users_fk` FOREIGN KEY (`user_fk_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `brands_products_fk` FOREIGN KEY (`brand_fk_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `subcategories_products_fk` FOREIGN KEY (`subcatergories_fk_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products_offers`
--
ALTER TABLE `products_offers`
  ADD CONSTRAINT `offers_fk` FOREIGN KEY (`offer_fk_id`) REFERENCES `offers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_offers_fk` FOREIGN KEY (`product-fk-id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products_orders`
--
ALTER TABLE `products_orders`
  ADD CONSTRAINT `orders_fk` FOREIGN KEY (`order_fk_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_products_fk` FOREIGN KEY (`product_fk_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `regions`
--
ALTER TABLE `regions`
  ADD CONSTRAINT `cities_regions_fk` FOREIGN KEY (`city_fk_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_products_fk` FOREIGN KEY (`product_fk_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_users_fk` FOREIGN KEY (`user_fk_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `categories_subcategories_fk` FOREIGN KEY (`categories_fk_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `favs_products_fk` FOREIGN KEY (`products_fk_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favs_users_fk` FOREIGN KEY (`users_fk_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
