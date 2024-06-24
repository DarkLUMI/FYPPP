-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2024 at 08:57 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `librarydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `acc_type`
--

CREATE TABLE `acc_type` (
  `ACCTYPE_ID` int(4) NOT NULL COMMENT 'Acc Identification',
  `TYPE_NAME` varchar(100) NOT NULL COMMENT 'Name of Acc Type'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `BOOK_ID` int(4) NOT NULL COMMENT 'Book Identification',
  `TITLE` varchar(255) NOT NULL COMMENT 'Book Title',
  `BOOK_IMG` longblob NOT NULL COMMENT 'Book Cover Image',
  `PUB_NAME` varchar(255) NOT NULL COMMENT 'Publication Company',
  `BOOK_BDATE` date NOT NULL COMMENT 'Book Purchase Date',
  `BOOK_PRICE` double NOT NULL COMMENT 'Book''s Price',
  `AUTHOR` varchar(255) NOT NULL COMMENT 'Book Author Names',
  `AVAILABLE` tinyint(1) NOT NULL COMMENT 'Availability'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `book_rec`
--

CREATE TABLE `book_rec` (
  `RECORD_ID` int(3) NOT NULL COMMENT 'Requested Book ID',
  `REQBOOK_N` varchar(255) NOT NULL COMMENT 'Requested Book Name',
  `REQBOOK_URL` text NOT NULL COMMENT 'Requested Book URL',
  `ISSUED` tinyint(1) NOT NULL COMMENT 'Book Issued Status'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `borrow_history`
--

CREATE TABLE `borrow_history` (
  `TRANS_ID` int(5) NOT NULL COMMENT 'Transaction ID',
  `PENALTY` double NOT NULL COMMENT 'Penalty Fees',
  `BORROW_DATE` date NOT NULL COMMENT 'Borrow Book Date',
  `EXP_DATE` date NOT NULL COMMENT 'Expect Return Date',
  `RETURN_DATE` date NOT NULL COMMENT 'Return Book Date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `GENRES_ID` int(4) NOT NULL COMMENT 'Genres Identification',
  `G_NAME` varchar(100) NOT NULL COMMENT 'Genres Names'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `USER_RENO` int(11) NOT NULL COMMENT 'User Register Number',
  `USER_RNAME` varchar(100) NOT NULL COMMENT 'User Real Name',
  `USER_NAME` varchar(100) NOT NULL COMMENT 'User Name',
  `USER_EMAIL` varchar(100) NOT NULL COMMENT 'User Email',
  `USER_PASS` varchar(255) NOT NULL COMMENT 'User Password',
  `USER_PHONE` varchar(20) NOT NULL COMMENT 'User Phone Number',
  `USER_ADDR` varchar(255) NOT NULL COMMENT 'User''s Address',
  `USER_SESS` varchar(100) NOT NULL COMMENT 'User''s Session',
  `USER_DEP` varchar(100) NOT NULL COMMENT 'User''s Department',
  `USER_REDATE` date NOT NULL DEFAULT current_timestamp() COMMENT 'User Register Date',
  `USER_IMG` longblob NOT NULL COMMENT 'User Profile Image'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `acc_type`
--
ALTER TABLE `acc_type`
  ADD PRIMARY KEY (`ACCTYPE_ID`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`BOOK_ID`);

--
-- Indexes for table `book_rec`
--
ALTER TABLE `book_rec`
  ADD PRIMARY KEY (`RECORD_ID`);

--
-- Indexes for table `borrow_history`
--
ALTER TABLE `borrow_history`
  ADD PRIMARY KEY (`TRANS_ID`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`GENRES_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`USER_RENO`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `acc_type`
--
ALTER TABLE `acc_type`
  MODIFY `ACCTYPE_ID` int(4) NOT NULL AUTO_INCREMENT COMMENT 'Acc Identification';

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `BOOK_ID` int(4) NOT NULL AUTO_INCREMENT COMMENT 'Book Identification';

--
-- AUTO_INCREMENT for table `book_rec`
--
ALTER TABLE `book_rec`
  MODIFY `RECORD_ID` int(3) NOT NULL AUTO_INCREMENT COMMENT 'Requested Book ID';

--
-- AUTO_INCREMENT for table `borrow_history`
--
ALTER TABLE `borrow_history`
  MODIFY `TRANS_ID` int(5) NOT NULL AUTO_INCREMENT COMMENT 'Transaction ID';

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `GENRES_ID` int(4) NOT NULL AUTO_INCREMENT COMMENT 'Genres Identification';

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `USER_RENO` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User Register Number';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
