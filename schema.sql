-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 15, 2025 at 06:53 AM
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
-- Database: `school_news_paper`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `article_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `photo_url` varchar(500) DEFAULT NULL,
  `author_id` int(11) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`article_id`, `title`, `content`, `photo_url`, `author_id`, `is_active`, `created_at`) VALUES
(1, 'heheheh', 'watashiwa', '/oop_school_news_paper/uploads/68c5628f62cb1_icon_imresizer.png', 1, 0, '2025-09-10 11:03:31'),
(16, 'ehehehehe', 'eheheheheh', '/oop_school_news_paper/uploads/68c5583a7ec1a_34c12c44-d934-4f7a-b54e-08c2525b96b0.jpg', 2, 1, '2025-09-13 11:40:42'),
(17, 'wataaa', 'efwef', '/oop_school_news_paper/uploads/68c56a1c807fd_IMG20230418073314.jpg', 3, 1, '2025-09-13 12:57:00'),
(18, 'please wrok', 'w32gwe', '/oop_school_news_paper/uploads/68c586d51582c_1000032635.jpg', 1, 1, '2025-09-13 14:59:33');

-- --------------------------------------------------------

--
-- Table structure for table `edit_requests`
--

CREATE TABLE `edit_requests` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `requester_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `edit_requests`
--

INSERT INTO `edit_requests` (`id`, `article_id`, `requester_id`, `owner_id`, `status`, `created_at`) VALUES
(6, 17, 1, 3, 'rejected', '2025-09-13 14:16:09'),
(7, 17, 1, 3, 'rejected', '2025-09-13 14:56:54'),
(8, 17, 1, 3, 'rejected', '2025-09-14 13:08:02'),
(9, 17, 1, 3, 'accepted', '2025-09-14 13:22:14'),
(10, 18, 3, 1, 'accepted', '2025-09-15 04:48:13');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `is_read`, `created_at`) VALUES
(3, 2, 'Your article \'\' was deleted by an admin.', 0, '2025-09-13 11:05:51'),
(4, 2, 'Your article \'frefef\' was deleted by an admin.', 0, '2025-09-13 11:06:41'),
(24, 3, 'A user requested to edit your article.', 0, '2025-09-14 13:08:02'),
(27, 3, 'A user requested to edit your article.', 0, '2025-09-14 13:22:14'),
(28, 1, 'Your edit request for article ID 17 was accepted.', 0, '2025-09-14 13:25:58'),
(29, 1, 'Your article \'Hi there\' was deleted by an admin.', 0, '2025-09-15 04:47:15'),
(30, 1, 'A user requested to edit your article.', 0, '2025-09-15 04:48:13'),
(31, 3, 'Your edit request for article ID 18 was accepted.', 0, '2025-09-15 04:50:30');

-- --------------------------------------------------------

--
-- Table structure for table `school_publication_users`
--

CREATE TABLE `school_publication_users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_publication_users`
--

INSERT INTO `school_publication_users` (`user_id`, `username`, `email`, `password`, `is_admin`, `created_at`) VALUES
(1, 'Gav', 'yerikyvesgavrie.talaboc.cvt@eac.edu.ph', '$2y$10$JZWBJnIsn38wvVmikYqbOeuIUGYGUkYEi4p.thCAagUSymyMA/D5C', 0, '2025-09-10 11:00:25'),
(2, 'adminGav', 'yerikyvesgavrie.talaboc1.cvt@eac.edu.ph', '$2y$10$1/uKOEBtJRaY.mkDshvMK.0lKlvPTn9jaNIDJcAre0gs6UOgVHDwq', 1, '2025-09-10 13:36:24'),
(3, 'writerGav2', 'hehe@gmail.com', '$2y$10$89k1Yt7mAPER6J6rfjL6LOMcoPJUjHHcVMs3Oj70GbQbu.kohvZ8S', 0, '2025-09-13 12:56:40');

-- --------------------------------------------------------

--
-- Table structure for table `shared_articles`
--

CREATE TABLE `shared_articles` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shared_articles`
--

INSERT INTO `shared_articles` (`id`, `article_id`, `user_id`) VALUES
(1, 17, 1),
(2, 17, 1),
(3, 17, 1),
(4, 17, 1),
(5, 17, 1),
(6, 18, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`article_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `edit_requests`
--
ALTER TABLE `edit_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `requester_id` (`requester_id`),
  ADD KEY `fk_owner` (`owner_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `school_publication_users`
--
ALTER TABLE `school_publication_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `shared_articles`
--
ALTER TABLE `shared_articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `edit_requests`
--
ALTER TABLE `edit_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `school_publication_users`
--
ALTER TABLE `school_publication_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shared_articles`
--
ALTER TABLE `shared_articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `school_publication_users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `edit_requests`
--
ALTER TABLE `edit_requests`
  ADD CONSTRAINT `edit_requests_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `edit_requests_ibfk_2` FOREIGN KEY (`requester_id`) REFERENCES `school_publication_users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_owner` FOREIGN KEY (`owner_id`) REFERENCES `school_publication_users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `school_publication_users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `shared_articles`
--
ALTER TABLE `shared_articles`
  ADD CONSTRAINT `shared_articles_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`article_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `shared_articles_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `school_publication_users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
