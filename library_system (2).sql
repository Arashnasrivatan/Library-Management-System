-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2024 at 02:19 PM
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
-- Database: `library_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `bookid` int(11) NOT NULL,
  `bookimg` varchar(200) NOT NULL DEFAULT 'assets/uploads/notfound.php',
  `bookname` varchar(40) NOT NULL,
  `Author` varchar(15) NOT NULL,
  `bookpage` varchar(10) NOT NULL,
  `confirmed` tinyint(1) NOT NULL,
  `reserved` varchar(2) NOT NULL DEFAULT '1',
  `endres` date NOT NULL,
  `reservedby` varchar(50) NOT NULL DEFAULT 'not_reserved'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`bookid`, `bookimg`, `bookname`, `Author`, `bookpage`, `confirmed`, `reserved`, `endres`, `reservedby`) VALUES
(80, 'assets/uploads/35420905.jpg', 'The Women: A Novel', 'Kristin Hannah ', '472', 1, '1', '0000-00-00', 'not_reserved'),
(81, 'assets/uploads/78557995.jpg', 'Atomic Habits', 'James Clear ', '320', 1, '1', '0000-00-00', 'not_reserved'),
(82, 'assets/uploads/47228751.jpg', 'A Court of Thorns an', 'Sarah J.Maas', '448', 1, '1', '0000-00-00', 'not_reserved'),
(83, 'assets/uploads/76170780.jpg', 'Sweet Tooth', 'Sarah Fennel', '228', 1, '1', '0000-00-00', 'not_reserved'),
(84, 'assets/uploads/56706895.jpg', 'The Teacher', 'Freida McFadden', '400', 1, '1', '0000-00-00', 'not_reserved'),
(87, 'assets/uploads/55047381.jpg', 'The Housemaid', 'Freida McFadden', '336', 1, '1', '0000-00-00', 'not_reserved'),
(88, 'assets/uploads/37468510.jpg', 'James: A Novel', 'Percival Everet', '320', 1, '2', '2024-04-14', 'arashnasrivatan');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `namefull` varchar(20) NOT NULL,
  `username` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;


-- --------------------------------------------------------

--
-- Table structure for table `verifycode`
--

CREATE TABLE `verifycode` (
  `id` int(11) NOT NULL,
  `verifycode` int(11) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`bookid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `verifycode`
--
ALTER TABLE `verifycode`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `bookid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `verifycode`
--
ALTER TABLE `verifycode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
