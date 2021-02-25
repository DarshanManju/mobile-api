-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 25, 2021 at 04:40 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testing`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sample`
--

DROP TABLE IF EXISTS `tbl_sample`;
CREATE TABLE IF NOT EXISTS `tbl_sample` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(250) NOT NULL,
  `last_name` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `cpassword` varchar(40) DEFAULT NULL,
  `mobile` varchar(40) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `cpassword`, `mobile`, `date_created`) VALUES
(10, 'testuser', 'test4@gmail.com', '12345678', '12345678', '9876543210', '2021-02-20 14:59:58'),
(2, 'testuser', 'test@gmail.com', '12345', '12345', '9876543210', '2021-02-20 12:29:09'),
(9, 'testuser', 'test3@gmail.com', '12345678', '12345678', '9876543210', '2021-02-20 14:55:07'),
(8, 'testuser', 'test2@gmail.com', '12345678', '12345678', '9876543210', '2021-02-20 14:50:08'),
(5, 'testuser', 'test1@gmail.com', '12345678', '12345678', '9876543210', '2021-02-20 13:42:18'),
(11, 'testuser', 'test5@gmail.com', '12345678', '12345678', '9876543210', '2021-02-20 15:19:30'),
(12, 'testuser', 'test6@gmail.com', '12345678', '12345678', '9876543210', '2021-02-22 06:33:40');

-- --------------------------------------------------------

--
-- Table structure for table `user_signin_otp`
--

DROP TABLE IF EXISTS `user_signin_otp`;
CREATE TABLE IF NOT EXISTS `user_signin_otp` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `user_id` int(4) DEFAULT NULL,
  `otp` int(10) DEFAULT NULL,
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_signin_otp`
--

INSERT INTO `user_signin_otp` (`id`, `user_id`, `otp`, `date_created`) VALUES
(14, 6537, 730159, '2021-02-24 02:49:29'),
(15, 8609, 694182, '2021-02-24 03:41:39'),
(3, 534, 319472, '2021-02-24 12:46:43'),
(4, 1607, 560438, '2021-02-24 12:47:19'),
(13, 4097, 579246, '2021-02-24 02:41:59'),
(12, 7562, 485291, '2021-02-24 02:19:21'),
(11, 3401, 359120, '2021-02-24 01:17:58'),
(10, 7293, 389264, '2021-02-24 01:15:50');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
