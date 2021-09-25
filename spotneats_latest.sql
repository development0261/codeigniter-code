-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2020 at 07:23 AM
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
-- Table structure for table `yvdnsddqu_stories`
--

CREATE TABLE `yvdnsddqu_stories` (
  `id` int(220) NOT NULL,
  `story_image` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` longtext NOT NULL,
  `added_by` int(100) NOT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(100) DEFAULT NULL,
  `modified_date` datetime DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0->Inactive, 1->Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_stories_access`
--

CREATE TABLE `yvdnsddqu_stories_access` (
  `id` int(100) NOT NULL,
  `story_id` int(100) NOT NULL,
  `location_id` int(100) NOT NULL,
  `added_by` int(100) NOT NULL,
  `added_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_theme_color`
--

CREATE TABLE `yvdnsddqu_theme_color` (
  `id` int(100) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `staff_id` int(100) NOT NULL,
  `logo` varchar(200) NOT NULL,
  `site_color` varchar(50) NOT NULL,
  `added_by` int(100) NOT NULL,
  `added_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `yvdnsddqu_stories`
--
ALTER TABLE `yvdnsddqu_stories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yvdnsddqu_stories_access`
--
ALTER TABLE `yvdnsddqu_stories_access`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yvdnsddqu_theme_color`
--
ALTER TABLE `yvdnsddqu_theme_color`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `yvdnsddqu_stories`
--
ALTER TABLE `yvdnsddqu_stories`
  MODIFY `id` int(220) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `yvdnsddqu_stories_access`
--
ALTER TABLE `yvdnsddqu_stories_access`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `yvdnsddqu_theme_color`
--
ALTER TABLE `yvdnsddqu_theme_color`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
