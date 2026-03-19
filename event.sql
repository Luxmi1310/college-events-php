-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 19, 2026 at 05:58 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event`
--

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `message`) VALUES
(1, 'Luxmi Singh', 'singhluxmi86@gmail.com', 'Subject: demo | Message: yguycduy'),
(2, 'Luxmi Singh', 'singhluxmi86@gmail.com', 'Subject: demo | Message: yguycduy'),
(3, 'Luxmi Singh', 'singhluxmi86@gmail.com', 'Subject: demo | Message: yguycduy'),
(4, 'Luxmi Singh', 'singhluxmi86@gmail.com', 'Subject: demo | Message: yguycduy'),
(5, 'hbis ldh', 'hbis@gmail.com', 'Subject: demo | Message: uyiiio');

-- --------------------------------------------------------

--
-- Table structure for table `create_events`
--

CREATE TABLE `create_events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `event_type` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `event_image` varchar(255) DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `registration_deadline` datetime DEFAULT NULL,
  `vanue` varchar(255) NOT NULL,
  `capacity` int(255) NOT NULL,
  `status` varchar(50) DEFAULT 'upcoming',
  `event_date` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `create_events`
--

INSERT INTO `create_events` (`id`, `title`, `event_type`, `description`, `event_image`, `start_date`, `end_date`, `registration_deadline`, `vanue`, `capacity`, `status`, `event_date`) VALUES
(17, 'Machine Learning', 'workshop', '\"Explore the fundamentals of artificial intelligence and predictive modeling. This session delves into supervised and unsupervised learning algorithms, data preprocessing, and model evaluation techniques. Learn how to transform raw data into actionable insights and build intelligent systems capable of solving complex real-world problems.\"', '1769080294_697205e626e2b.jpg', '2026-01-27 12:00:00', '2026-01-27 14:00:00', NULL, 'Conference Hall A', 100, 'upcoming', '2026-01-22'),
(18, 'iot', 'Workshop', 'vgrkgh', '1770650898_6989fd1245659.jpg', '2026-02-10 20:57:00', '2026-02-11 20:57:00', '2026-02-09 13:07:00', 'Conference Hall A', 10, 'Upcoming', '2026-02-04'),
(21, 'Python', 'workshop', 'Widely used programing language with the help of python you can do AI/ml', '1770651578_6989ffba7729d.jpg', '2026-02-25 10:10:00', '2026-02-25 12:05:00', '2026-02-20 21:08:00', 'Auditorium', 100, 'upcoming', '2026-02-09'),
(22, 'full stack', 'workshop', 'demo', '1772870980_69abdd445089e.jpg', '2026-03-07 13:39:00', '2026-03-13 13:39:00', NULL, 'Auditorium', 100, 'upcoming', '2026-03-07'),
(23, 'AI/Ml', 'workshop', 'Overview of Artificial Intelligence and Machine Learning, key concepts, real-world applications, and industry trends.', '1773396511_69b3e21f20f08.jpg', '2026-03-26 15:37:00', '2026-03-26 17:37:00', '2026-03-14 15:38:00', 'Auditorium', 100, 'upcoming', '2026-03-13'),
(24, 'full Stack', 'workshop', 'Overview of front-end, back-end, and databases; how modern web applications work end-to-end.Connecting front-end with back-end, building a simple full-stack project, and deploying the application online. ', '1773396753_69b3e311907bb.jpeg', '2026-03-31 11:00:00', '2026-03-31 14:00:00', '2026-03-27 15:41:00', 'Conference Hall A', 100, 'upcoming', '2026-03-13'),
(25, 'Cloud Computing', 'seminar', 'Basics of Cloud Computing, cloud architecture, and service models like IaaS, PaaS, and SaaS.', '1773396976_69b3e3f02aee4.webp', '2026-04-15 15:45:00', '2026-04-13 17:45:00', '2026-04-12 15:45:00', 'Auditorium', 50, 'upcoming', '2026-03-13'),
(26, 'Web Development', 'workshop', 'Overview of how websites work, basic structure of the web, and roles of front-end and back-end development.', '1773397135_69b3e48f6847c.jpg', '2026-04-22 15:48:00', '2026-04-22 17:48:00', '2026-04-20 15:48:00', 'Online', 100, 'upcoming', '2026-03-13'),
(27, 'Team work', 'workshop', 'Task delegation, conflict resolution, motivation techniques, and building collaboration among team members.', '1773397315_69b3e543048c0.jpg', '2026-04-25 13:51:00', '2026-04-25 17:51:00', '2026-04-23 15:51:00', 'Library', 100, 'upcoming', '2026-03-13');

-- --------------------------------------------------------

--
-- Table structure for table `event_register`
--

CREATE TABLE `event_register` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `status` varchar(20) DEFAULT NULL,
  `add_dated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_register`
--

INSERT INTO `event_register` (`id`, `event_id`, `student_id`, `status`, `add_dated`) VALUES
(7, 17, 40, '0', '2026-02-01 19:41:04'),
(8, 18, 42, '0', '2026-02-11 07:55:14'),
(9, 21, 42, '0', '2026-02-11 07:56:43'),
(10, 18, 43, '0', '2026-02-11 10:45:06'),
(11, 18, 44, '0', '2026-02-11 11:00:29'),
(12, 18, 45, '0', '2026-02-11 11:07:53'),
(13, 18, 48, '0', '2026-02-11 11:23:36'),
(14, 18, 50, '0', '2026-02-12 10:00:42'),
(15, 23, 88, '0', '2026-03-17 07:54:01');

-- --------------------------------------------------------

--
-- Table structure for table `sponsors`
--

CREATE TABLE `sponsors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo_image` varchar(255) NOT NULL,
  `banner_image` varchar(255) DEFAULT NULL,
  `sponsor_type` enum('paid','normal') DEFAULT 'normal',
  `website_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sponsors`
--

INSERT INTO `sponsors` (`id`, `name`, `logo_image`, `banner_image`, `sponsor_type`, `website_url`) VALUES
(6, 'infosys', 'in.webp', 'inb.jpg', 'paid', 'https://www.infosys.com/'),
(7, 'hbis ldh', 'hb.jpg', 'hbis.webp', 'paid', 'https://hbinfotechsolutions.com/'),
(8, 'microsoft', 'micro.webp', 'micb.png', 'paid', 'https://www.infosys.com/');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `OTP` varchar(10) NOT NULL,
  `Status` tinyint(11) NOT NULL,
  `Add_dated` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `Name`, `Email`, `Password`, `Phone`, `OTP`, `Status`, `Add_dated`) VALUES
(36, 'demo', 'hbis@gmail.com', '', '4638746934', '7895', 0, '0000-00-00 00:00:00.000000'),
(37, 'Manpreet Singh', 'demo234@gmail.com', '$2y$10$QxBAN3z7IXZjdBhzl4WenO5lMiBgBhyaMeYqFOHcepbPiDoIUc8wm', '5628292892', '', 0, '2026-02-01 12:07:32.000000'),
(39, 'hbis', 'admin@gmail.com', '$2y$10$kVtypmqcj5W80RwRmnCn3.RpeT5RSh7rqzDjdEw/pkqGbMrAxNq4S', '9876543210', '', 1, '2026-02-01 12:23:48.000000'),
(40, 'demo', 'demo@gmail.com', 'fe01ce2a7fbac8fafaed7c982a04e229', '6284841004', '', 1, '2026-02-02 11:08:46.000000'),
(41, 'Amit Kumar', 'amit@yahoo.com', '$2y$10$r5sxSB7H4xc3HYvXU6uKVerQ.GuYdj2p.QsODw3icVxohl6rQBwoK', '9876541230', '', 0, '2026-02-10 11:59:49.000000'),
(42, 'arushi', 'arushi@gmail.com', '$2y$10$6dCH6Nk6P/4PtEAo5jxSAOvyuD..FRhhxBvRilcaHNqfrlnK5qxRe', '7489574954', '', 1, '2026-02-11 08:55:08.000000'),
(43, 'sakshi', 'sakshi77@gmail.com', '$2y$10$lqxZCp872brhf58UnFVOE.eBbYbV9zZdRElsVfvSxwnwXYeyhVIs6', '4794797497', '', 1, '2026-02-11 11:31:47.000000'),
(44, 'nandni', 'nandni34@gmail.com', '$2y$10$nXM1FN/f/YCRFIsVj9osD.WzIk3bQ1POSwFJrdHyKJ6Ipm1Yjoa/2', '7856945749', '', 1, '2026-02-11 11:52:18.000000'),
(45, 'neha', 'neha12@gmail.com', '$2y$10$tLir6Q6DEJO4VlRbqPA.peL6X6tziIguOgEpWFZH7ge9GP36fQ2f.', '8579857957', '', 1, '2026-02-11 12:01:50.000000'),
(46, 'neha', 'neha1234@gmail.com', '', '3286293238', '', 1, '0000-00-00 00:00:00.000000'),
(47, 'demo', 'demijjd@gmail.com', '', '6574957459', '8437', 0, '0000-00-00 00:00:00.000000'),
(48, 'bfhvif', 'gfhfhriu@gmail.com', '$2y$10$pGVBmFWX6XN/woQ9qC240eePUYPsuUBB1LCL/7Tg3EiejazV9ZlBa', '7487490458', '', 1, '2026-02-11 12:20:12.000000'),
(49, 'priya', 'priya@gmail.com', '$2y$10$/Fk5mvsPJtiDhGjfKtcpmuwlMIZFUTeip0CEcMWw6zUmRGwALPKsa', '7947349038', '', 1, '2026-02-11 12:29:13.000000'),
(50, 'babita', 'babita@gmail.com', '$2y$10$hmMUJ5q5NONEcEe4PJywdO0.MFw51YDzYFeouAxW5oA4jBwyx7xrK', '9041098231', '', 1, '2026-02-12 11:00:29.000000'),
(51, 'bhumi', 'bhumi@gmail.com', '$2y$10$M966ebnjlN.nu1x6uEzReuadujek.ERzydoBg/UDqWj/SVtrZWiyK', '6574564857', '', 1, '2026-02-14 08:43:34.000000'),
(52, 'shagun', 'shagun@gmail.com', '$2y$10$A/Kv5YVyXdVcA3gJhHdv1OfhRKXNlKci9vsRYbqfSUfll33wzHlKi', '6478564957', '', 1, '2026-02-16 06:45:29.000000'),
(88, 'Luxmi Singh', 'singhluxmi86@gmail.com', '$2y$10$ENUp.V3FtM7Fo9BZE8JtAumsn5F5PWgmMm8PjnEgZr1ceEsHoDVqG', '7973642515', '906158', 0, '2026-03-17 08:53:13.000000'),
(89, 'ruhi', 'luxmisingh028@gmail.com', '', '7973642518', '643900', 0, '0000-00-00 00:00:00.000000');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `date`) VALUES
(5, 'neha', 'neha12@gmail.com', '3fede54cd3cf786471ca20e4d40d9b8c', '2025-11-12'),
(6, 'anjali', 'anjali12@gmail.com', '73cf25d56e3fe00e398b81fef7c32615', '2025-11-12'),
(7, 'nandni', 'nandni1234@gmail.com', '77d9800b539d5bdecb7b65facfb87615', '2025-11-13'),
(8, 'preeti', 'preeti123@gmail.com', '875d48192ccbbb18f32a13cec13cac14', '2025-11-14'),
(9, 'luxmi', 'luxmi10@gmail.com', 'f3e7cbbdf34ec0655026ca29e7839270', '2025-11-12'),
(14, 'demo', 'demo@email.com', '62cc2d8b4bf2d8728120d052163a77df', '0000-00-00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `create_events`
--
ALTER TABLE `create_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_register`
--
ALTER TABLE `event_register`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `create_events`
--
ALTER TABLE `create_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `event_register`
--
ALTER TABLE `event_register`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `sponsors`
--
ALTER TABLE `sponsors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event_register`
--
ALTER TABLE `event_register`
  ADD CONSTRAINT `event_register_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `create_events` (`id`),
  ADD CONSTRAINT `event_register_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
