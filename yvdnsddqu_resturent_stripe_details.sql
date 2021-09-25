-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2020 at 10:03 AM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spotneats`
--

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_resturent_stripe_details`
--

CREATE TABLE `yvdnsddqu_resturent_stripe_details` (
  `id` int(100) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `location_id` int(100) NOT NULL,
  `publishable_test_key` varchar(200) NOT NULL,
  `secret_test_key` varchar(200) NOT NULL,
  `publishable_key` varchar(200) NOT NULL,
  `secret_key` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `yvdnsddqu_resturent_stripe_details`
--

INSERT INTO `yvdnsddqu_resturent_stripe_details` (`id`, `status`, `location_id`, `publishable_test_key`, `secret_test_key`, `publishable_key`, `secret_key`) VALUES
(1, '1', 4, 'pub_test_saasia89asasww212', 'secretsaasia89asasxxs', 'publishaasas3ewewew', 'secretasdsadsadyyuiop');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `yvdnsddqu_resturent_stripe_details`
--
ALTER TABLE `yvdnsddqu_resturent_stripe_details`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `yvdnsddqu_resturent_stripe_details`
--
ALTER TABLE `yvdnsddqu_resturent_stripe_details`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
