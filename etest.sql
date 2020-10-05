-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2020 at 07:41 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `account_id` int(11) NOT NULL,
  `account_code` varchar(8) DEFAULT NULL,
  `account_nm` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `batch`
--

CREATE TABLE `batch` (
  `account_id` int(11) NOT NULL,
  `batch_id` int(11) NOT NULL,
  `insert_user_id` varchar(25) NOT NULL,
  `insert_date` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `company_id` int(11) NOT NULL,
  `company_nm` varchar(65) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(65) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `phone` varchar(14) DEFAULT NULL,
  `fax` varchar(14) DEFAULT NULL,
  `logo_file_nm` varchar(144) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `division_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `division_nm` varchar(100) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(65) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `phone` varchar(14) DEFAULT NULL,
  `fax` varchar(14) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `comments` varchar(1000) DEFAULT NULL,
  `email` varchar(65) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `drugform`
--

CREATE TABLE `drugform` (
  `form_id` int(11) NOT NULL,
  `form_nm` varchar(100) NOT NULL,
  `form_type` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `drugs`
--

CREATE TABLE `drugs` (
  `drug_id` int(11) NOT NULL,
  `drug_nm` varchar(100) NOT NULL,
  `type` varchar(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `emp_id` varchar(25) NOT NULL,
  `account_id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `first_nm` varchar(65) DEFAULT NULL,
  `last_nm` varchar(65) DEFAULT NULL,
  `random_marker` varchar(1) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `insert_user_id` varchar(25) DEFAULT NULL,
  `insert_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `account_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `amount` decimal(10,0) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `formdrugs`
--

CREATE TABLE `formdrugs` (
  `form_id` int(11) NOT NULL,
  `drug_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `invoice_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `terms` varchar(65) DEFAULT NULL,
  `reference_nm` varchar(65) DEFAULT NULL,
  `invoice_date` datetime DEFAULT NULL,
  `check_no` int(11) DEFAULT NULL,
  `check_date` datetime DEFAULT NULL,
  `amount_paid` decimal(10,0) DEFAULT NULL,
  `pay_date` datetime DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `paid` varchar(1) DEFAULT NULL,
  `comments` varchar(1000) DEFAULT NULL,
  `insert_user_id` varchar(25) DEFAULT NULL,
  `insert_date` datetime DEFAULT NULL,
  `update_user_id` varchar(25) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `sent` varchar(1) DEFAULT NULL,
  `send_type` varchar(1) DEFAULT NULL,
  `send_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoiceitems`
--

CREATE TABLE `invoiceitems` (
  `invoice_item_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `insert_user_id` varchar(25) DEFAULT NULL,
  `insert_date` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lab`
--

CREATE TABLE `lab` (
  `lab_id` int(11) NOT NULL,
  `lab_nm` varchar(100) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `fax` varchar(10) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `practitioner`
--

CREATE TABLE `practitioner` (
  `practitioner_id` int(11) NOT NULL,
  `practitioner_nm` varchar(100) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `fax` varchar(10) DEFAULT NULL,
  `sig_file_nm` varchar(144) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `preferences`
--

CREATE TABLE `preferences` (
  `pref_id` int(11) NOT NULL,
  `practitioner_id` int(11) DEFAULT NULL,
  `lab_id` int(11) DEFAULT NULL,
  `sample_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `reason_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `random`
--

CREATE TABLE `random` (
  `random_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `insert_user_id` varchar(25) DEFAULT NULL,
  `insert_date` datetime DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `randomitems`
--

CREATE TABLE `randomitems` (
  `random_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `emp_id` varchar(25) NOT NULL,
  `test_id` int(11) DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `reasons`
--

CREATE TABLE `reasons` (
  `reason_id` int(11) NOT NULL,
  `reason_code` varchar(10) NOT NULL,
  `reason_nm` varchar(65) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sampletype`
--

CREATE TABLE `sampletype` (
  `sample_id` int(11) NOT NULL,
  `sample_nm` varchar(65) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `systemid`
--

CREATE TABLE `systemid` (
  `type` varchar(25) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `systemtables`
--

CREATE TABLE `systemtables` (
  `table_nm` varchar(32) NOT NULL,
  `sequence_nbr` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `systemversion`
--

CREATE TABLE `systemversion` (
  `dbversion` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `test_id` int(11) NOT NULL,
  `status` varchar(1) NOT NULL,
  `account_id` int(11) NOT NULL,
  `division_id` int(11) NOT NULL,
  `emp_id` varchar(25) DEFAULT NULL,
  `collection_date` datetime NOT NULL,
  `company_id` int(11) NOT NULL,
  `lab_id` int(11) NOT NULL,
  `reason_id` int(11) NOT NULL,
  `result` varchar(1) NOT NULL,
  `practitioner_id` int(11) NOT NULL,
  `test_date` datetime DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `sample_id` int(11) DEFAULT NULL,
  `amount` decimal(10,0) DEFAULT NULL,
  `dot` varchar(1) DEFAULT NULL,
  `batch_id` int(11) DEFAULT NULL,
  `insert_user_id` varchar(25) DEFAULT NULL,
  `insert_date` datetime DEFAULT NULL,
  `update_user_id` varchar(25) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `form_id` int(11) NOT NULL,
  `other` varchar(1) DEFAULT NULL,
  `other_nm` varchar(25) DEFAULT NULL,
  `invoice_id` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `testresult`
--

CREATE TABLE `testresult` (
  `test_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `drug_id` int(11) NOT NULL,
  `result` varchar(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `testtype`
--

CREATE TABLE `testtype` (
  `type_id` int(11) NOT NULL,
  `type_nm` varchar(65) NOT NULL,
  `report_include` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(25) NOT NULL,
  `first_nm` varchar(65) NOT NULL,
  `last_nm` varchar(65) NOT NULL,
  `admin` varchar(1) DEFAULT NULL,
  `password` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`account_id`);

--
-- Indexes for table `batch`
--
ALTER TABLE `batch`
  ADD PRIMARY KEY (`account_id`,`batch_id`) USING BTREE;

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`division_id`);

--
-- Indexes for table `drugform`
--
ALTER TABLE `drugform`
  ADD PRIMARY KEY (`form_id`);

--
-- Indexes for table `drugs`
--
ALTER TABLE `drugs`
  ADD PRIMARY KEY (`drug_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`emp_id`,`account_id`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`account_id`,`type_id`);

--
-- Indexes for table `formdrugs`
--
ALTER TABLE `formdrugs`
  ADD PRIMARY KEY (`form_id`,`drug_id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `practitioner`
--
ALTER TABLE `practitioner`
  ADD PRIMARY KEY (`practitioner_id`);

--
-- Indexes for table `random`
--
ALTER TABLE `random`
  ADD PRIMARY KEY (`random_id`);

--
-- Indexes for table `randomitems`
--
ALTER TABLE `randomitems`
  ADD PRIMARY KEY (`random_id`,`emp_id`);

--
-- Indexes for table `reasons`
--
ALTER TABLE `reasons`
  ADD PRIMARY KEY (`reason_id`);

--
-- Indexes for table `sampletype`
--
ALTER TABLE `sampletype`
  ADD PRIMARY KEY (`sample_id`);

--
-- Indexes for table `systemtables`
--
ALTER TABLE `systemtables`
  ADD PRIMARY KEY (`table_nm`);

--
-- Indexes for table `systemversion`
--
ALTER TABLE `systemversion`
  ADD PRIMARY KEY (`dbversion`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`test_id`);

--
-- Indexes for table `testresult`
--
ALTER TABLE `testresult`
  ADD PRIMARY KEY (`test_id`,`drug_id`);

--
-- Indexes for table `testtype`
--
ALTER TABLE `testtype`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `account_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `company_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `division_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `drugform`
--
ALTER TABLE `drugform`
  MODIFY `form_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `drugs`
--
ALTER TABLE `drugs`
  MODIFY `drug_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `practitioner`
--
ALTER TABLE `practitioner`
  MODIFY `practitioner_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `random`
--
ALTER TABLE `random`
  MODIFY `random_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reasons`
--
ALTER TABLE `reasons`
  MODIFY `reason_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sampletype`
--
ALTER TABLE `sampletype`
  MODIFY `sample_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `testtype`
--
ALTER TABLE `testtype`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
