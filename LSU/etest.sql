-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2020 at 05:00 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `etest`
--

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE `form` (
  `Id` int(11) NOT NULL,
  `Client` varchar(100) NOT NULL,
  `Dept` varchar(100) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `SSN` varchar(100) NOT NULL,
  `Specimen` varchar(100) NOT NULL,
  `Collection` varchar(100) NOT NULL,
  `Account` varchar(100) NOT NULL,
  `Fund` varchar(100) NOT NULL,
  `Department` varchar(100) NOT NULL,
  `Program` varchar(100) NOT NULL,
  `Class` varchar(100) NOT NULL,
  `Project` varchar(100) NOT NULL,
  `Contact` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `RequestedBy` varchar(100) NOT NULL,
  `RequestedDate` date NOT NULL,
  `Deadline` varchar(100) NOT NULL,
  `TestType` varchar(100) NOT NULL,
  `Reason` varchar(100) NOT NULL,
  `Type2` varchar(100) NOT NULL,
  `Type3` varchar(100) NOT NULL,
  `Safety` varchar(100) NOT NULL,
  `Comments` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `form`
--

INSERT INTO `form` (`Id`, `Client`, `Dept`, `FirstName`, `LastName`, `SSN`, `Specimen`, `Collection`, `Account`, `Fund`, `Department`, `Program`, `Class`, `Project`, `Contact`, `Email`, `RequestedBy`, `RequestedDate`, `Deadline`, `TestType`, `Reason`, `Type2`, `Type3`, `Safety`, `Comments`) VALUES
(1, 'Urgent Care Centers', '12', '123', '2', '23', '123', 'Urgent Care Centers', '', '123', '12', '2', '2', '2', '23', '12', '12', '2020-08-05', '2020-08-06', 'Hospital', 'Hospital', 'Hospital', 'Hospital', '1', '12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `form`
--
ALTER TABLE `form`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
