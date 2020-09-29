-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2020 at 02:02 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_photo` varchar(255) NOT NULL,
  `user_gender` text NOT NULL,
  `user_city` text NOT NULL,
  `user_age` int(3) NOT NULL,
  `user_phone` int(9) NOT NULL,
  `user_status` varchar(7) NOT NULL DEFAULT 'Offline'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_email`, `user_name`, `user_password`, `user_photo`, `user_gender`, `user_city`, `user_age`, `user_phone`, `user_status`) VALUES
(41, 'd@d', 'Domen Hribernik704', 'domen123', 'profile_image/709prenos.jpg', 'Male', 'Vojnik', 18, 123456789, 'Online'),
(42, 't@t', 'Tian Rihter945', 'tiantian', 'profile_image/993icon.jpg', 'Male', 'Celje', 17, 123456789, 'Offline'),
(43, 'test@test', 'Janez Novak301', 'janez123', 'profile_image/114profile.png', 'Male', 'Celje', 15, 123456789, 'Offline'),
(44, 'test2@test', 'Marija Novak323', 'marija123', 'profile_image/915profile.png', 'Female', 'Celje', 21, 123456789, 'Offline'),
(45, 'test3@test', 'Uporabnik 1630', 'testtest', 'profile_image/17profile.png', 'Female', 'Celje', 12, 123456789, 'Offline'),
(46, 'test4@test', 'Uporabnik 2891', 'testtest', 'profile_image/22profile.png', 'Male', 'Celje', 16, 123456789, 'Offline'),
(47, 'test5@test', 'Uporabnik 3382', 'testtest', 'profile_image/650profile.png', 'Male', 'Celje', 15, 123123123, 'Offline');

-- --------------------------------------------------------

--
-- Table structure for table `users_chat`
--

CREATE TABLE `users_chat` (
  `msg_id` int(11) NOT NULL,
  `sender_username` varchar(100) NOT NULL,
  `receiver_username` varchar(100) NOT NULL,
  `msg_content` varchar(255) NOT NULL,
  `msg_image` varchar(255) NOT NULL,
  `msg_status` text NOT NULL,
  `msg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_chat`
--

INSERT INTO `users_chat` (`msg_id`, `sender_username`, `receiver_username`, `msg_content`, `msg_image`, `msg_status`, `msg_date`) VALUES
(415, 'Tian Rihter945', 'Domen Hribernik704', 'poslano sporočilo', '', 'read', '2020-05-17 19:43:08'),
(416, 'Tian Rihter945', 'Domen Hribernik704', 'slika s sporočilom', 'message_image/431pexels-photo-1525041.jpeg', 'read', '2020-05-17 19:43:43'),
(417, 'Domen Hribernik704', 'Tian Rihter945', 'sporočilo', '', 'unread', '2020-05-17 19:44:51'),
(418, 'Domen Hribernik704', 'Tian Rihter945', 'error', '', 'unread', '2020-05-17 19:45:12'),
(419, 'Domen Hribernik704', 'Tian Rihter945', 'slika s sporočilom', 'message_image/436ArtTutor GridPic.jpg', 'unread', '2020-05-17 19:46:45'),
(420, 'Domen Hribernik704', 'Tian Rihter945', '', 'message_image/603prenos.jpg', 'unread', '2020-05-17 19:46:55'),
(421, 'Domen Hribernik704', 'Tian Rihter945', 'test', '', 'unread', '2020-05-19 12:02:09');

-- --------------------------------------------------------

--
-- Table structure for table `users_friends`
--

CREATE TABLE `users_friends` (
  `friends_id` int(11) NOT NULL,
  `friend_a` varchar(200) NOT NULL,
  `friend_b` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_friends`
--

INSERT INTO `users_friends` (`friends_id`, `friend_a`, `friend_b`) VALUES
(63, 'Domen Hribernik704', 'Domen Hribernik704'),
(64, 'Tian Rihter945', 'Tian Rihter945'),
(65, 'Janez Novak301', 'Janez Novak301'),
(66, 'Marija Novak323', 'Marija Novak323'),
(67, 'Uporabnik 1630', 'Uporabnik 1630'),
(68, 'Uporabnik 2891', 'Uporabnik 2891'),
(69, 'Uporabnik 3382', 'Uporabnik 3382'),
(72, 'Tian Rihter945', 'Domen Hribernik704'),
(73, 'Domen Hribernik704', 'Uporabnik 1630'),
(74, 'Domen Hribernik704', 'Uporabnik 2891'),
(75, 'Domen Hribernik704', 'Uporabnik 3382'),
(76, 'Domen Hribernik704', 'Marija Novak323'),
(77, 'Domen Hribernik704', 'Janez Novak301'),
(78, 'Domen Hribernik704', 'Tian Rihter945');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_name` (`user_name`);

--
-- Indexes for table `users_chat`
--
ALTER TABLE `users_chat`
  ADD PRIMARY KEY (`msg_id`),
  ADD KEY `sender_username` (`sender_username`),
  ADD KEY `receiver_username` (`receiver_username`);

--
-- Indexes for table `users_friends`
--
ALTER TABLE `users_friends`
  ADD PRIMARY KEY (`friends_id`),
  ADD KEY `friend_a` (`friend_a`),
  ADD KEY `friend_b` (`friend_b`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `users_chat`
--
ALTER TABLE `users_chat`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=422;

--
-- AUTO_INCREMENT for table `users_friends`
--
ALTER TABLE `users_friends`
  MODIFY `friends_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users_chat`
--
ALTER TABLE `users_chat`
  ADD CONSTRAINT `users_chat_ibfk_1` FOREIGN KEY (`sender_username`) REFERENCES `users` (`user_name`),
  ADD CONSTRAINT `users_chat_ibfk_2` FOREIGN KEY (`receiver_username`) REFERENCES `users` (`user_name`);

--
-- Constraints for table `users_friends`
--
ALTER TABLE `users_friends`
  ADD CONSTRAINT `users_friends_ibfk_1` FOREIGN KEY (`friend_a`) REFERENCES `users` (`user_name`),
  ADD CONSTRAINT `users_friends_ibfk_2` FOREIGN KEY (`friend_b`) REFERENCES `users` (`user_name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
