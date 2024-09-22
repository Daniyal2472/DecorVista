-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2024 at 07:41 PM
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
-- Database: `decorvista_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `product_id`, `user_id`, `created_at`) VALUES
(6, 1, 5, '2024-09-22 13:53:20');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(4, 'Bathrooms'),
(2, 'Bedrooms'),
(3, 'Kitchens'),
(1, 'Living Rooms'),
(5, 'Offices');

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `designer_id` int(11) DEFAULT NULL,
  `slot_id` int(11) DEFAULT NULL,
  `booking_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `message` varchar(255) DEFAULT NULL,
  `status` enum('Approved','Disapproved','Pending approval','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consultation_slots`
--

CREATE TABLE `consultation_slots` (
  `slot_id` int(11) NOT NULL,
  `designer_id` int(11) DEFAULT NULL,
  `slot_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `is_booked` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultation_slots`
--

INSERT INTO `consultation_slots` (`slot_id`, `designer_id`, `slot_date`, `start_time`, `end_time`, `is_booked`, `created_at`) VALUES
(9, 2, '2024-09-01', '11:00:00', '13:00:00', 0, '2024-09-22 12:52:47'),
(10, 2, '2024-09-02', '15:00:00', '17:00:00', 0, '2024-09-22 12:53:07'),
(11, 2, '2024-09-03', '19:00:00', '21:00:00', 0, '2024-09-22 12:53:27');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `designer_portfolio`
--

CREATE TABLE `designer_portfolio` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `designer_portfolio`
--

INSERT INTO `designer_portfolio` (`id`, `title`, `category_id`, `description`, `image`, `user_id`, `created_at`) VALUES
(1, 'Modern Living Room Design', 1, 'A sleek and modern living room design.', 'pexels-netoo-24380940.jpg', 2, '2024-09-22 12:48:48'),
(2, 'Cozy Bedroom Remodel', 2, 'A cozy and comfortable bedroom remodel.	', 'pexels-belle-shang-21953574-6606354.jpg', 2, '2024-09-22 12:49:37'),
(3, 'Stylish Office Space', 5, 'A contemporary and stylish office space.', 'pexels-drew-williams-1285451-3143791.jpg', 2, '2024-09-22 12:50:04'),
(4, 'Open-Concept Kitchen', 3, 'An open-concept kitchen with modern touches.', 'pexels-pixabay-279648.jpg', 2, '2024-09-22 12:50:42');

-- --------------------------------------------------------

--
-- Table structure for table `inspiration_gallery`
--

CREATE TABLE `inspiration_gallery` (
  `inspiration_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `category` int(11) DEFAULT NULL,
  `date_added` datetime DEFAULT current_timestamp(),
  `added_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inspiration_gallery`
--

INSERT INTO `inspiration_gallery` (`inspiration_id`, `title`, `description`, `image_url`, `category`, `date_added`, `added_by`) VALUES
(1, 'Minimalist Living Room', 'A clean and modern living room design.', 'pexels-belle-shang-21953574-6606354.jpg', 1, '2024-09-22 17:25:57', NULL),
(2, 'Cozy Bedroom Retreat', 'A warm and inviting bedroom with neutral tones.', 'pexels-netoo-24380940.jpg', 2, '2024-09-22 17:26:50', NULL),
(3, 'Sleek Kitchen Design', 'A modern kitchen with stainless steel appliances.', 'pexels-pixabay-279648.jpg', 3, '2024-09-22 17:28:24', NULL),
(4, 'Luxury Office Space', 'A high-end office space with elegant furniture.	', 'pexels-drew-williams-1285451-3143791.jpg', 5, '2024-09-22 17:29:57', NULL),
(5, 'Spa-Inspired Bathroom', 'A bathroom with spa-like features for relaxation.', 'pexels-pu-ca-adryan-163345030-28457986.jpg', 4, '2024-09-22 17:31:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `product_price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `order_date` datetime DEFAULT current_timestamp(),
  `payment_method` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `product_id`, `product_image`, `product_price`, `quantity`, `order_date`, `payment_method`) VALUES
(1, 5, 2, 'luxury-bathroom-authentic-interior-design.jpg', 25000.00, 1, '2024-09-22 18:29:15', 'bank_transfer'),
(2, 5, 1, 'modern-bathroom-with-small-space-contemporary-decor.jpg', 15000.00, 1, '2024-09-22 18:29:15', 'bank_transfer'),
(3, 5, 3, 'small-bathroom-with-modern-style-ai-generated.jpg', 12000.00, 1, '2024-09-22 18:29:15', 'bank_transfer'),
(4, 5, 6, 'pexels-kseniachernaya-11112750.jpg', 8000.00, 1, '2024-09-22 18:29:15', 'bank_transfer'),
(5, 5, 2, 'luxury-bathroom-authentic-interior-design.jpg', 25000.00, 1, '2024-09-22 18:42:57', 'bank_transfer');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `category_id`, `price`, `description`, `image_url`) VALUES
(1, 'Modern Bathroom Vanity', 4, 15000.00, 'A sleek bathroom vanity with storage.	', 'modern-bathroom-with-small-space-contemporary-decor.jpg'),
(2, 'Elegant Bathtub', 4, 25000.00, 'A luxurious bathtub for a relaxing soak.	', 'luxury-bathroom-authentic-interior-design.jpg'),
(3, 'Modern Toilet', 4, 12000.00, 'A compact toilet with water-saving features.	', 'small-bathroom-with-modern-style-ai-generated.jpg'),
(4, 'Queen Size Bed', 2, 30000.00, 'A comfortable queen size bed with a frame.', '10414.jpg'),
(5, 'King Size Mattress', 2, 40000.00, 'A premium mattress for ultimate comfort.', 'pexels-netoo-21345931.jpg'),
(6, 'Nightstand with Drawers', 2, 8000.00, 'A stylish nightstand for bedroom storage.	', 'pexels-kseniachernaya-11112750.jpg'),
(7, 'Kitchen Island', 3, 22000.00, 'A spacious kitchen island with seating.', 'pexels-ali-moradi-167146005-18185916.jpg'),
(8, 'Stylish Kitchen Cabinets', 3, 30000.00, 'Modern cabinets for all your kitchen needs.', 'pexels-kseniachernaya-11112748.jpg'),
(9, 'Dining Table Set', 3, 35000.00, 'A beautiful dining table with matching chairs.', 'pexels-vlada-karpovich-3958213.jpg'),
(10, 'Sectional Sofa', 1, 35000.00, 'A cozy sectional sofa perfect for living rooms.', 'pexels-pu-ca-adryan-163345030-28518251.jpg'),
(11, 'Coffee Table', 1, 10000.00, 'A chic coffee table that complements any room.', 'pexels-drew-williams-1285451-3098621.jpg'),
(12, 'Recliner Chair', 1, 20000.00, 'A comfortable recliner for relaxation.', 'pexels-pu-ca-adryan-163345030-25857376.jpg'),
(13, 'Office Desk with Drawer', 5, 18000.00, 'A functional office desk with ample storage.', 'pexels-drew-williams-1285451-3143813.jpg'),
(14, 'Ergonomic Office Chair', 5, 12000.00, 'An ergonomic chair for long hours of work.', 'pexels-pu-ca-adryan-163345030-27920699.jpg'),
(15, 'File Cabinet', 5, 15000.00, 'A secure file cabinet for office organization.', 'pexels-hakimsatoso-9646747.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `designer_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `user_id`, `product_id`, `designer_id`, `rating`, `comment`, `review_date`) VALUES
(1, 5, NULL, 2, NULL, '\"Your design work is truly impressive! The space feels well-balanced, with a perfect mix of functionality and style. I love how you’ve used color and lighting to create a warm, inviting atmosphere. Keep up the great work!\"', '2024-09-22 13:16:18'),
(2, 5, 1, NULL, NULL, 'The Modern Bathroom Vanity is stylish, well-built, and fits perfectly with my contemporary bathroom design. The soft-close drawers add a premium feel, and the storage is ample. Assembly instructions could be clearer, but overall, I’m very happy with the purchase. Highly recommended!', '2024-09-22 13:21:50'),
(3, 5, 2, NULL, NULL, 'The Elegant Bathtub is a beautiful addition to my bathroom. Its sleek design and comfortable depth make for a relaxing experience. The material feels high-quality, and it retains heat well. Installation was smooth, though the size is slightly larger than expected. Overall, it\\\'s a fantastic product that adds both luxury and function.', '2024-09-22 13:22:56'),
(5, 5, 1, NULL, NULL, 'I recently installed the Modern Bathroom Vanity, and I couldn’t be happier with my choice. The sleek, minimalist design adds a sophisticated touch to my bathroom, perfectly aligning with my contemporary decor. The quality of materials is impressive; the surface is easy to clean, and the finish has held up beautifully.', '2024-09-22 13:25:04'),
(6, 5, 2, NULL, NULL, 'I recently added the Elegant Bathtub to my bathroom, and it has transformed my space into a luxurious retreat. The design is stunning, with clean lines and a contemporary silhouette that truly enhances the overall aesthetic. It’s not only visually appealing but also incredibly comfortable; the depth and shape provide a perfect lounging experience.', '2024-09-22 13:25:45'),
(7, 5, NULL, 2, NULL, 'I recently collaborated with an interior designer, and the experience exceeded my expectations. They took the time to understand my vision and preferences, transforming my space into a beautifully cohesive design. Their attention to detail, from color palettes to furniture selection, created a warm and inviting atmosphere. I was particularly impressed by how they maximized the use of space while ensuring functionality without sacrificing style.', '2024-09-22 13:30:44'),
(8, 5, NULL, 2, NULL, 'I recently had the pleasure of working with an interior designer, and the experience was nothing short of transformative. From our initial consultation, they took the time to understand my vision, lifestyle, and preferences. Their ability to blend aesthetics with functionality was remarkable. They curated a stunning color palette and thoughtfully selected furniture that not only matched my style but also maximized the space. The result is a harmonious environment that feels both inviting and practical, making it a joy to spend time in my home.', '2024-09-22 13:31:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('User','Designer','Admin') NOT NULL,
  `profile_photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `portfolio_url` varchar(255) DEFAULT NULL,
  `years_of_experience` int(11) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `first_name`, `last_name`, `contact`, `password`, `role`, `profile_photo`, `created_at`, `portfolio_url`, `years_of_experience`, `specialization`) VALUES
(1, 'admin', 'admin@gmail.com', 'Admin', 'Admin', '', '$2y$10$NyW3J9ndR4n2sr4BDOi3euH/TLktu48y49AihBsBc6TelYwF6n21i', 'Admin', 'pexels-vojtech-okenka-127162-399772.jpg', '2024-09-22 11:47:51', NULL, NULL, NULL),
(2, 'designerjohn', 'john@example.com', 'John', 'Doe', '1234567890', '$2y$10$zgHhzFsD8UwnssEJFZzk9u3GE9mH4G5.YBihpqCM1jOVz08ZOGbDu', 'Designer', 'pexels-rodrigo-souza-1275988-2531552.jpg', '2024-09-22 12:41:05', 'https://johnsdesignportfolio.com/', 5, 'Interior Design'),
(3, 'designerjane', 'jane@example.com', 'Jane', 'Smith', '2345678901', '$2y$10$bWiOVfRntmxLeN.xSOISy.ijRSbjm3VX2XDzfHoYED0iXdfWoxmMq', 'Designer', 'pexels-rodrigo-souza-1275988-2531552.jpg', '2024-09-22 12:43:05', 'https://www.etsy.com/shop/JANESDESIGNHOUSE', 8, 'Kitchen &amp; Bathroom Design'),
(4, 'designeralex', 'alex@example.com', 'Alex', 'Johnson', '3456789012', '$2y$10$WZqJQ12RoARDVMIVnxl3p.a6EMLz0YETiwMQgg3eq445j0RC0Ku/.', 'Designer', 'pexels-rodrigo-souza-1275988-2531552.jpg', '2024-09-22 12:44:36', 'https://alexhomedecor.com/', 3, 'Modern Furniture Design'),
(5, 'emma', 'emma@example.com', 'Emma', 'Watson', '', '$2y$10$scx.8kiTKbYMvNamZY3abuQJAk.ISNhdAZ32r63lj.dbP5DwvI6re', 'User', 'pexels-annetnavi-789303.jpg', '2024-09-22 13:05:26', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gallery_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `gallery_id`, `image`) VALUES
(1, 5, 2, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `slot_id` (`slot_id`),
  ADD KEY `consultations_ibfk_3` (`designer_id`);

--
-- Indexes for table `consultation_slots`
--
ALTER TABLE `consultation_slots`
  ADD PRIMARY KEY (`slot_id`),
  ADD KEY `designer_id` (`designer_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `designer_portfolio`
--
ALTER TABLE `designer_portfolio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `designer_portfolio_ibfk_1` (`category_id`),
  ADD KEY `designer_portfolio_ibfk_2` (`user_id`);

--
-- Indexes for table `inspiration_gallery`
--
ALTER TABLE `inspiration_gallery`
  ADD PRIMARY KEY (`inspiration_id`),
  ADD KEY `inspiration_gallery_ibfk_1` (`added_by`),
  ADD KEY `category` (`category`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user_id`),
  ADD KEY `gallery_image` (`gallery_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consultation_slots`
--
ALTER TABLE `consultation_slots`
  MODIFY `slot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `designer_portfolio`
--
ALTER TABLE `designer_portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `inspiration_gallery`
--
ALTER TABLE `inspiration_gallery`
  MODIFY `inspiration_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `consultations`
--
ALTER TABLE `consultations`
  ADD CONSTRAINT `consultations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `consultations_ibfk_2` FOREIGN KEY (`slot_id`) REFERENCES `consultation_slots` (`slot_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `consultations_ibfk_3` FOREIGN KEY (`designer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `consultation_slots`
--
ALTER TABLE `consultation_slots`
  ADD CONSTRAINT `consultation_slots_ibfk_1` FOREIGN KEY (`designer_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `designer_portfolio`
--
ALTER TABLE `designer_portfolio`
  ADD CONSTRAINT `designer_portfolio_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `designer_portfolio_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inspiration_gallery`
--
ALTER TABLE `inspiration_gallery`
  ADD CONSTRAINT `category` FOREIGN KEY (`category`) REFERENCES `categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `gallery_image` FOREIGN KEY (`gallery_id`) REFERENCES `inspiration_gallery` (`inspiration_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
