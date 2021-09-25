-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 18, 2020 at 04:45 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `RestaurantCart`
--

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_activities`
--

CREATE TABLE `yvdnsddqu_activities` (
  `activity_id` int(11) NOT NULL,
  `domain` varchar(10) NOT NULL,
  `context` varchar(128) NOT NULL,
  `user` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `action` varchar(32) NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_addresses`
--

CREATE TABLE `yvdnsddqu_addresses` (
  `address_id` int(11) NOT NULL,
  `customer_id` int(15) NOT NULL,
  `address_1` varchar(128) NOT NULL,
  `address_2` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL,
  `state` varchar(128) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `country_id` int(11) DEFAULT '0',
  `specification` varchar(255) NOT NULL,
  `default_address` varchar(10) NOT NULL DEFAULT 'off',
  `clatitude` varchar(50) NOT NULL,
  `clongitude` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_addresses`
--

INSERT INTO `yvdnsddqu_addresses` (`address_id`, `customer_id`, `address_1`, `address_2`, `city`, `state`, `postcode`, `country_id`, `specification`, `default_address`, `clatitude`, `clongitude`) VALUES
(2, 2, 'Madurai Meenakshi Amman Temple Road, Dharmathupatti, Tamil Nadu, India', '', 'Dharmathupatti', 'Madurai', '625008', 0, 'home', 'on', '', ''),
(4, 2, 'Madurai Meenakshi Amman Temple Road, Dharmathupatti, Tamil Nadu, India', '', 'Dharmathupatti', 'Madurai', '625008', 0, 'home', 'off', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_admin_payments`
--

CREATE TABLE `yvdnsddqu_admin_payments` (
  `id` int(11) NOT NULL,
  `receipt_no` varchar(50) NOT NULL,
  `total_booking_amount` double NOT NULL,
  `total_amount_received` double NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_transaction_id` varchar(100) NOT NULL,
  `description` longtext NOT NULL,
  `no_of_orders` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_banners`
--

CREATE TABLE `yvdnsddqu_banners` (
  `banner_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` char(8) NOT NULL,
  `click_url` varchar(255) NOT NULL,
  `language_id` int(11) NOT NULL,
  `alt_text` varchar(255) NOT NULL,
  `image_code` text NOT NULL,
  `custom_code` text NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_banners`
--

INSERT INTO `yvdnsddqu_banners` (`banner_id`, `name`, `type`, `click_url`, `language_id`, `alt_text`, `image_code`, `custom_code`, `status`) VALUES
(1, 'Home banner', 'carousel', 'http://sponeats.uplogictech.com/', 11, 'Home banner', 'a:1:{s:5:\"paths\";a:3:{i:0;s:19:\"data/2-300x1920.png\";i:1;s:19:\"data/3-300x1920.png\";i:2;s:19:\"data/5-300x1920.png\";}}', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_categories`
--

CREATE TABLE `yvdnsddqu_categories` (
  `category_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `name_ar` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `description_ar` text NOT NULL,
  `parent_id` int(11) NOT NULL,
  `priority` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `alcohol_status` int(2) NOT NULL DEFAULT '0',
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_categories`
--

INSERT INTO `yvdnsddqu_categories` (`category_id`, `name`, `name_ar`, `description`, `description_ar`, `parent_id`, `priority`, `image`, `status`, `alcohol_status`, `added_by`) VALUES
(1, 'Veg starter', '', 'Veg starters.. start it now', '', 3, 0, 'data/Fatoush.jpg', 1, 0, 12),
(2, 'Dessert', '', 'Dessert dishes to satisfy you', '', 0, 0, 'data/bursa-4.jpg', 1, 0, 12),
(3, 'Starter', '', 'starter dishes', '', 0, 0, 'data/2018-08-15.jpg', 1, 0, 12),
(5, 'Non-Veg starter', '', 'Non-Veg starter', '', 3, 0, 'data/1.png', 1, 0, 12),
(8, 'Main Dish', '', 'main dishes ..........................main dishes', '', 0, 0, 'data/1558504025_3GIF.gif', 1, 0, 12),
(9, 'New dish', '', 'newdish', '', 0, 0, 'data/147432473_ee9f191439_b.jpg', 1, 0, 13),
(10, 'Chicken', '', '', '', 0, 0, '', 1, 0, 13),
(11, 'Test', '', '', '', 0, 0, '', 1, 0, 14),
(12, 'NV', '', '', '', 0, 0, '', 1, 0, 13);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_countries`
--

CREATE TABLE `yvdnsddqu_countries` (
  `country_id` int(11) NOT NULL,
  `country_name` varchar(128) NOT NULL,
  `iso_code_2` varchar(2) NOT NULL,
  `iso_code_3` varchar(3) NOT NULL,
  `format` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `flag` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_countries`
--

INSERT INTO `yvdnsddqu_countries` (`country_id`, `country_name`, `iso_code_2`, `iso_code_3`, `format`, `status`, `flag`) VALUES
(1, 'Afghanistan', 'AF', 'AFG', '', 0, 'data/flags/af.png'),
(2, 'Albania', 'AL', 'ALB', '', 0, 'data/flags/al.png'),
(3, 'Algeria', 'DZ', 'DZA', '', 0, 'data/flags/dz.png'),
(4, 'American Samoa', 'AS', 'ASM', '', 0, 'data/flags/as.png'),
(5, 'Andorra', 'AD', 'AND', '', 0, 'data/flags/ad.png'),
(6, 'Angola', 'AO', 'AGO', '', 0, 'data/flags/ao.png'),
(7, 'Anguilla', 'AI', 'AIA', '', 0, 'data/flags/ai.png'),
(8, 'Antarctica', 'AQ', 'ATA', '', 0, 'data/flags/aq.png'),
(9, 'Antigua and Barbuda', 'AG', 'ATG', '', 0, 'data/flags/ag.png'),
(10, 'Argentina', 'AR', 'ARG', '', 0, 'data/flags/ar.png'),
(11, 'Armenia', 'AM', 'ARM', '', 0, 'data/flags/am.png'),
(12, 'Aruba', 'AW', 'ABW', '', 0, 'data/flags/aw.png'),
(13, 'Australia', 'AU', 'AUS', '', 0, 'data/flags/au.png'),
(14, 'Austria', 'AT', 'AUT', '', 0, 'data/flags/at.png'),
(15, 'Azerbaijan', 'AZ', 'AZE', '', 0, 'data/flags/az.png'),
(16, 'Bahamas', 'BS', 'BHS', '', 0, 'data/flags/bs.png'),
(17, 'Bahrain', 'BH', 'BHR', '', 0, 'data/flags/bh.png'),
(18, 'Bangladesh', 'BD', 'BGD', '', 0, 'data/flags/bd.png'),
(19, 'Barbados', 'BB', 'BRB', '', 0, 'data/flags/bb.png'),
(20, 'Belarus', 'BY', 'BLR', '', 0, 'data/flags/by.png'),
(21, 'Belgium', 'BE', 'BEL', '', 0, 'data/flags/be.png'),
(22, 'Belize', 'BZ', 'BLZ', '', 0, 'data/flags/bz.png'),
(23, 'Benin', 'BJ', 'BEN', '', 0, 'data/flags/bj.png'),
(24, 'Bermuda', 'BM', 'BMU', '', 0, 'data/flags/bm.png'),
(25, 'Bhutan', 'BT', 'BTN', '', 0, 'data/flags/bt.png'),
(26, 'Bolivia', 'BO', 'BOL', '', 0, 'data/flags/bo.png'),
(27, 'Bosnia and Herzegowina', 'BA', 'BIH', '', 0, 'data/flags/ba.png'),
(28, 'Botswana', 'BW', 'BWA', '', 0, 'data/flags/bw.png'),
(29, 'Bouvet Island', 'BV', 'BVT', '', 0, 'data/flags/bv.png'),
(30, 'Brazil', 'BR', 'BRA', '', 0, 'data/flags/br.png'),
(31, 'British Indian Ocean Territory', 'IO', 'IOT', '', 0, 'data/flags/io.png'),
(32, 'Brunei Darussalam', 'BN', 'BRN', '', 0, 'data/flags/bn.png'),
(33, 'Bulgaria', 'BG', 'BGR', '', 0, 'data/flags/bg.png'),
(34, 'Burkina Faso', 'BF', 'BFA', '', 0, 'data/flags/bf.png'),
(35, 'Burundi', 'BI', 'BDI', '', 0, 'data/flags/bi.png'),
(36, 'Cambodia', 'KH', 'KHM', '', 0, 'data/flags/kh.png'),
(37, 'Cameroon', 'CM', 'CMR', '', 0, 'data/flags/cm.png'),
(38, 'Canada', 'CA', 'CAN', '', 0, 'data/flags/ca.png'),
(39, 'Cape Verde', 'CV', 'CPV', '', 0, 'data/flags/cv.png'),
(40, 'Cayman Islands', 'KY', 'CYM', '', 0, 'data/flags/ky.png'),
(41, 'Central African Republic', 'CF', 'CAF', '', 0, 'data/flags/cf.png'),
(42, 'Chad', 'TD', 'TCD', '', 0, 'data/flags/td.png'),
(43, 'Chile', 'CL', 'CHL', '', 0, 'data/flags/cl.png'),
(44, 'China', 'CN', 'CHN', '', 0, 'data/flags/cn.png'),
(45, 'Christmas Island', 'CX', 'CXR', '', 0, 'data/flags/cx.png'),
(46, 'Cocos (Keeling) Islands', 'CC', 'CCK', '', 0, 'data/flags/cc.png'),
(47, 'Colombia', 'CO', 'COL', '', 1, 'data/flags/co.png'),
(48, 'Comoros', 'KM', 'COM', '', 0, 'data/flags/km.png'),
(49, 'Congo', 'CG', 'COG', '', 0, 'data/flags/cg.png'),
(50, 'Cook Islands', 'CK', 'COK', '', 0, 'data/flags/ck.png'),
(51, 'Costa Rica', 'CR', 'CRI', '', 0, 'data/flags/cr.png'),
(52, 'Cote D\'Ivoire', 'CI', 'CIV', '', 0, 'data/flags/ci.png'),
(53, 'Croatia', 'HR', 'HRV', '', 0, 'data/flags/hr.png'),
(54, 'Cuba', 'CU', 'CUB', '', 0, 'data/flags/cu.png'),
(55, 'Cyprus', 'CY', 'CYP', '', 0, 'data/flags/cy.png'),
(56, 'Czech Republic', 'CZ', 'CZE', '', 0, 'data/flags/cz.png'),
(57, 'Denmark', 'DK', 'DNK', '', 0, 'data/flags/dk.png'),
(58, 'Djibouti', 'DJ', 'DJI', '', 0, 'data/flags/dj.png'),
(59, 'Dominica', 'DM', 'DMA', '', 0, 'data/flags/dm.png'),
(60, 'Dominican Republic', 'DO', 'DOM', '', 0, 'data/flags/do.png'),
(61, 'East Timor', 'TP', 'TMP', '', 0, 'data/flags/tp.png'),
(62, 'Ecuador', 'EC', 'ECU', '', 0, 'data/flags/ec.png'),
(63, 'Egypt', 'EG', 'EGY', '', 0, 'data/flags/eg.png'),
(64, 'El Salvador', 'SV', 'SLV', '', 0, 'data/flags/sv.png'),
(65, 'Equatorial Guinea', 'GQ', 'GNQ', '', 0, 'data/flags/gq.png'),
(66, 'Eritrea', 'ER', 'ERI', '', 0, 'data/flags/er.png'),
(67, 'Estonia', 'EE', 'EST', '', 0, 'data/flags/ee.png'),
(68, 'Ethiopia', 'ET', 'ETH', '', 0, 'data/flags/et.png'),
(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', '', 0, 'data/flags/fk.png'),
(70, 'Faroe Islands', 'FO', 'FRO', '', 0, 'data/flags/fo.png'),
(71, 'Fiji', 'FJ', 'FJI', '', 0, 'data/flags/fj.png'),
(72, 'Finland', 'FI', 'FIN', '', 0, 'data/flags/fi.png'),
(73, 'France', 'FR', 'FRA', '', 0, 'data/flags/fr.png'),
(74, 'France, Metropolitan', 'FX', 'FXX', '', 0, 'data/flags/fx.png'),
(75, 'French Guiana', 'GF', 'GUF', '', 0, 'data/flags/gf.png'),
(76, 'French Polynesia', 'PF', 'PYF', '', 0, 'data/flags/pf.png'),
(77, 'French Southern Territories', 'TF', 'ATF', '', 0, 'data/flags/tf.png'),
(78, 'Gabon', 'GA', 'GAB', '', 0, 'data/flags/ga.png'),
(79, 'Gambia', 'GM', 'GMB', '', 0, 'data/flags/gm.png'),
(80, 'Georgia', 'GE', 'GEO', '', 0, 'data/flags/ge.png'),
(81, 'Germany', 'DE', 'DEU', '', 0, 'data/flags/de.png'),
(82, 'Ghana', 'GH', 'GHA', '', 0, 'data/flags/gh.png'),
(83, 'Gibraltar', 'GI', 'GIB', '', 0, 'data/flags/gi.png'),
(84, 'Greece', 'GR', 'GRC', '', 0, 'data/flags/gr.png'),
(85, 'Greenland', 'GL', 'GRL', '', 0, 'data/flags/gl.png'),
(86, 'Grenada', 'GD', 'GRD', '', 0, 'data/flags/gd.png'),
(87, 'Guadeloupe', 'GP', 'GLP', '', 0, 'data/flags/gp.png'),
(88, 'Guam', 'GU', 'GUM', '', 0, 'data/flags/gu.png'),
(89, 'Guatemala', 'GT', 'GTM', '', 0, 'data/flags/gt.png'),
(90, 'Guinea', 'GN', 'GIN', '', 0, 'data/flags/gn.png'),
(91, 'Guinea-bissau', 'GW', 'GNB', '', 0, 'data/flags/gw.png'),
(92, 'Guyana', 'GY', 'GUY', '', 0, 'data/flags/gy.png'),
(93, 'Haiti', 'HT', 'HTI', '', 0, 'data/flags/ht.png'),
(94, 'Heard and Mc Donald Islands', 'HM', 'HMD', '', 0, 'data/flags/hm.png'),
(95, 'Honduras', 'HN', 'HND', '', 0, 'data/flags/hn.png'),
(96, 'Hong Kong', 'HK', 'HKG', '', 0, 'data/flags/hk.png'),
(97, 'Hungary', 'HU', 'HUN', '', 0, 'data/flags/hu.png'),
(98, 'Iceland', 'IS', 'ISL', '', 0, 'data/flags/is.png'),
(99, 'India', 'IN', 'IND', '', 0, 'data/flags/in.png'),
(100, 'Indonesia', 'ID', 'IDN', '', 0, 'data/flags/id.png'),
(101, 'Iran (Islamic Republic of)', 'IR', 'IRN', '', 0, 'data/flags/ir.png'),
(102, 'Iraq', 'IQ', 'IRQ', '', 0, 'data/flags/iq.png'),
(103, 'Ireland', 'IE', 'IRL', '', 0, 'data/flags/ie.png'),
(104, 'Israel', 'IL', 'ISR', '', 0, 'data/flags/il.png'),
(105, 'Italy', 'IT', 'ITA', '', 0, 'data/flags/it.png'),
(106, 'Jamaica', 'JM', 'JAM', '', 0, 'data/flags/jm.png'),
(107, 'Japan', 'JP', 'JPN', '', 0, 'data/flags/jp.png'),
(108, 'Jordan', 'JO', 'JOR', '', 0, 'data/flags/jo.png'),
(109, 'Kazakhstan', 'KZ', 'KAZ', '', 0, 'data/flags/kz.png'),
(110, 'Kenya', 'KE', 'KEN', '', 0, 'data/flags/ke.png'),
(111, 'Kiribati', 'KI', 'KIR', '', 0, 'data/flags/ki.png'),
(112, 'North Korea', 'KP', 'PRK', '', 0, 'data/flags/kp.png'),
(113, 'Korea, Republic of', 'KR', 'KOR', '', 0, 'data/flags/kr.png'),
(114, 'Kuwait', 'KW', 'KWT', '', 1, 'data/flags/kw.png'),
(115, 'Kyrgyzstan', 'KG', 'KGZ', '', 0, 'data/flags/kg.png'),
(116, 'Lao People\'s Democratic Republic', 'LA', 'LAO', '', 0, 'data/flags/la.png'),
(117, 'Latvia', 'LV', 'LVA', '', 0, 'data/flags/lv.png'),
(118, 'Lebanon', 'LB', 'LBN', '', 0, 'data/flags/lb.png'),
(119, 'Lesotho', 'LS', 'LSO', '', 0, 'data/flags/ls.png'),
(120, 'Liberia', 'LR', 'LBR', '', 0, 'data/flags/lr.png'),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', '', 0, 'data/flags/ly.png'),
(122, 'Liechtenstein', 'LI', 'LIE', '', 0, 'data/flags/li.png'),
(123, 'Lithuania', 'LT', 'LTU', '', 0, 'data/flags/lt.png'),
(124, 'Luxembourg', 'LU', 'LUX', '', 0, 'data/flags/lu.png'),
(125, 'Macau', 'MO', 'MAC', '', 0, 'data/flags/mo.png'),
(126, 'FYROM', 'MK', 'MKD', '', 0, 'data/flags/mk.png'),
(127, 'Madagascar', 'MG', 'MDG', '', 0, 'data/flags/mg.png'),
(128, 'Malawi', 'MW', 'MWI', '', 0, 'data/flags/mw.png'),
(129, 'Malaysia', 'MY', 'MYS', '', 0, 'data/flags/my.png'),
(130, 'Maldives', 'MV', 'MDV', '', 0, 'data/flags/mv.png'),
(131, 'Mali', 'ML', 'MLI', '', 0, 'data/flags/ml.png'),
(132, 'Malta', 'MT', 'MLT', '', 0, 'data/flags/mt.png'),
(133, 'Marshall Islands', 'MH', 'MHL', '', 0, 'data/flags/mh.png'),
(134, 'Martinique', 'MQ', 'MTQ', '', 0, 'data/flags/mq.png'),
(135, 'Mauritania', 'MR', 'MRT', '', 0, 'data/flags/mr.png'),
(136, 'Mauritius', 'MU', 'MUS', '', 0, 'data/flags/mu.png'),
(137, 'Mayotte', 'YT', 'MYT', '', 0, 'data/flags/yt.png'),
(138, 'Mexico', 'MX', 'MEX', '', 0, 'data/flags/mx.png'),
(139, 'Micronesia, Federated States of', 'FM', 'FSM', '', 0, 'data/flags/fm.png'),
(140, 'Moldova, Republic of', 'MD', 'MDA', '', 0, 'data/flags/md.png'),
(141, 'Monaco', 'MC', 'MCO', '', 0, 'data/flags/mc.png'),
(142, 'Mongolia', 'MN', 'MNG', '', 0, 'data/flags/mn.png'),
(143, 'Montserrat', 'MS', 'MSR', '', 0, 'data/flags/ms.png'),
(144, 'Morocco', 'MA', 'MAR', '', 0, 'data/flags/ma.png'),
(145, 'Mozambique', 'MZ', 'MOZ', '', 0, 'data/flags/mz.png'),
(146, 'Myanmar', 'MM', 'MMR', '', 0, 'data/flags/mm.png'),
(147, 'Namibia', 'NA', 'NAM', '', 0, 'data/flags/na.png'),
(148, 'Nauru', 'NR', 'NRU', '', 0, 'data/flags/nr.png'),
(149, 'Nepal', 'NP', 'NPL', '', 0, 'data/flags/np.png'),
(150, 'Netherlands', 'NL', 'NLD', '', 0, 'data/flags/nl.png'),
(151, 'Netherlands Antilles', 'AN', 'ANT', '', 0, 'data/flags/an.png'),
(152, 'New Caledonia', 'NC', 'NCL', '', 0, 'data/flags/nc.png'),
(153, 'New Zealand', 'NZ', 'NZL', '', 0, 'data/flags/nz.png'),
(154, 'Nicaragua', 'NI', 'NIC', '', 0, 'data/flags/ni.png'),
(155, 'Niger', 'NE', 'NER', '', 0, 'data/flags/ne.png'),
(156, 'Nigeria', 'NG', 'NGA', '', 0, 'data/flags/ng.png'),
(157, 'Niue', 'NU', 'NIU', '', 0, 'data/flags/nu.png'),
(158, 'Norfolk Island', 'NF', 'NFK', '', 0, 'data/flags/nf.png'),
(159, 'Northern Mariana Islands', 'MP', 'MNP', '', 0, 'data/flags/mp.png'),
(160, 'Norway', 'NO', 'NOR', '', 0, 'data/flags/no.png'),
(161, 'Oman', 'OM', 'OMN', '', 0, 'data/flags/om.png'),
(162, 'Pakistan', 'PK', 'PAK', '', 0, 'data/flags/pk.png'),
(163, 'Palau', 'PW', 'PLW', '', 0, 'data/flags/pw.png'),
(164, 'Panama', 'PA', 'PAN', '', 0, 'data/flags/pa.png'),
(165, 'Papua New Guinea', 'PG', 'PNG', '', 0, 'data/flags/pg.png'),
(166, 'Paraguay', 'PY', 'PRY', '', 0, 'data/flags/py.png'),
(167, 'Peru', 'PE', 'PER', '', 0, 'data/flags/pe.png'),
(168, 'Philippines', 'PH', 'PHL', '', 0, 'data/flags/ph.png'),
(169, 'Pitcairn', 'PN', 'PCN', '', 0, 'data/flags/pn.png'),
(170, 'Poland', 'PL', 'POL', '', 0, 'data/flags/pl.png'),
(171, 'Portugal', 'PT', 'PRT', '', 0, 'data/flags/pt.png'),
(172, 'Puerto Rico', 'PR', 'PRI', '', 0, 'data/flags/pr.png'),
(173, 'Qatar', 'QA', 'QAT', '', 0, 'data/flags/qa.png'),
(174, 'Reunion', 'RE', 'REU', '', 0, 'data/flags/re.png'),
(175, 'Romania', 'RO', 'ROM', '', 0, 'data/flags/ro.png'),
(176, 'Russian Federation', 'RU', 'RUS', '', 0, 'data/flags/ru.png'),
(177, 'Rwanda', 'RW', 'RWA', '', 0, 'data/flags/rw.png'),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA', '', 0, 'data/flags/kn.png'),
(179, 'Saint Lucia', 'LC', 'LCA', '', 0, 'data/flags/lc.png'),
(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', '', 0, 'data/flags/vc.png'),
(181, 'Samoa', 'WS', 'WSM', '', 0, 'data/flags/ws.png'),
(182, 'San Marino', 'SM', 'SMR', '', 0, 'data/flags/sm.png'),
(183, 'Sao Tome and Principe', 'ST', 'STP', '', 0, 'data/flags/st.png'),
(184, 'Saudi Arabia', 'SA', 'SAU', '', 0, 'data/flags/sa.png'),
(185, 'Senegal', 'SN', 'SEN', '', 0, 'data/flags/sn.png'),
(186, 'Seychelles', 'SC', 'SYC', '', 0, 'data/flags/sc.png'),
(187, 'Sierra Leone', 'SL', 'SLE', '', 0, 'data/flags/sl.png'),
(188, 'Singapore', 'SG', 'SGP', '', 0, 'data/flags/sg.png'),
(189, 'Slovak Republic', 'SK', 'SVK', '', 0, 'data/flags/sk.png'),
(190, 'Slovenia', 'SI', 'SVN', '', 0, 'data/flags/si.png'),
(191, 'Solomon Islands', 'SB', 'SLB', '', 0, 'data/flags/sb.png'),
(192, 'Somalia', 'SO', 'SOM', '', 0, 'data/flags/so.png'),
(193, 'South Africa', 'ZA', 'ZAF', '', 0, 'data/flags/za.png'),
(194, 'South Georgia &amp; South Sandwich Islands', 'GS', 'SGS', '', 0, 'data/flags/gs.png'),
(195, 'Spain', 'ES', 'ESP', '', 0, 'data/flags/es.png'),
(196, 'Sri Lanka', 'LK', 'LKA', '', 0, 'data/flags/lk.png'),
(197, 'St. Helena', 'SH', 'SHN', '', 0, 'data/flags/sh.png'),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM', '', 0, 'data/flags/pm.png'),
(199, 'Sudan', 'SD', 'SDN', '', 0, 'data/flags/sd.png'),
(200, 'Suriname', 'SR', 'SUR', '', 0, 'data/flags/sr.png'),
(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', '', 0, 'data/flags/sj.png'),
(202, 'Swaziland', 'SZ', 'SWZ', '', 0, 'data/flags/sz.png'),
(203, 'Sweden', 'SE', 'SWE', '', 0, 'data/flags/se.png'),
(204, 'Switzerland', 'CH', 'CHE', '', 0, 'data/flags/ch.png'),
(205, 'Syrian Arab Republic', 'SY', 'SYR', '', 0, 'data/flags/sy.png'),
(206, 'Taiwan', 'TW', 'TWN', '', 0, 'data/flags/tw.png'),
(207, 'Tajikistan', 'TJ', 'TJK', '', 0, 'data/flags/tj.png'),
(208, 'Tanzania, United Republic of', 'TZ', 'TZA', '', 0, 'data/flags/tz.png'),
(209, 'Thailand', 'TH', 'THA', '', 0, 'data/flags/th.png'),
(210, 'Togo', 'TG', 'TGO', '', 0, 'data/flags/tg.png'),
(211, 'Tokelau', 'TK', 'TKL', '', 0, 'data/flags/tk.png'),
(212, 'Tonga', 'TO', 'TON', '', 0, 'data/flags/to.png'),
(213, 'Trinidad and Tobago', 'TT', 'TTO', '', 0, 'data/flags/tt.png'),
(214, 'Tunisia', 'TN', 'TUN', '', 0, 'data/flags/tn.png'),
(215, 'Turkey', 'TR', 'TUR', '', 0, 'data/flags/tr.png'),
(216, 'Turkmenistan', 'TM', 'TKM', '', 0, 'data/flags/tm.png'),
(217, 'Turks and Caicos Islands', 'TC', 'TCA', '', 0, 'data/flags/tc.png'),
(218, 'Tuvalu', 'TV', 'TUV', '', 0, 'data/flags/tv.png'),
(219, 'Uganda', 'UG', 'UGA', '', 0, 'data/flags/ug.png'),
(220, 'Ukraine', 'UA', 'UKR', '', 0, 'data/flags/ua.png'),
(221, 'United Arab Emirates', 'AE', 'ARE', '', 0, 'data/flags/ae.png'),
(222, 'United Kingdom', 'GB', 'GBR', '{address_1}\n{address_2}\n{city} {postcode} {state}\n{country}', 0, 'data/flags/gb.png'),
(223, 'United States', 'US', 'USA', '', 0, 'data/flags/us.png'),
(224, 'United States Minor Outlying Islands', 'UM', 'UMI', '', 0, 'data/flags/um.png'),
(225, 'Uruguay', 'UY', 'URY', '', 0, 'data/flags/uy.png'),
(226, 'Uzbekistan', 'UZ', 'UZB', '', 0, 'data/flags/uz.png'),
(227, 'Vanuatu', 'VU', 'VUT', '', 0, 'data/flags/vu.png'),
(228, 'Vatican City State (Holy See)', 'VA', 'VAT', '', 0, 'data/flags/va.png'),
(229, 'Venezuela', 'VE', 'VEN', '', 0, 'data/flags/ve.png'),
(230, 'Viet Nam', 'VN', 'VNM', '', 0, 'data/flags/vn.png'),
(231, 'Virgin Islands (British)', 'VG', 'VGB', '', 0, 'data/flags/vg.png'),
(232, 'Virgin Islands (U.S.)', 'VI', 'VIR', '', 0, 'data/flags/vi.png'),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF', '', 0, 'data/flags/wf.png'),
(234, 'Western Sahara', 'EH', 'ESH', '', 0, 'data/flags/eh.png'),
(235, 'Yemen', 'YE', 'YEM', '', 0, 'data/flags/ye.png'),
(236, 'Yugoslavia', 'YU', 'YUG', '', 0, 'data/flags/yu.png'),
(237, 'Democratic Republic of Congo', 'CD', 'COD', '', 0, 'data/flags/cd.png'),
(238, 'Zambia', 'ZM', 'ZMB', '', 0, 'data/flags/zm.png'),
(239, 'Zimbabwe', 'ZW', 'ZWE', '', 0, 'data/flags/zw.png');

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_coupons`
--

CREATE TABLE `yvdnsddqu_coupons` (
  `coupon_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `code` varchar(15) NOT NULL,
  `type` char(1) NOT NULL,
  `discount` decimal(15,4) DEFAULT NULL,
  `min_total` decimal(15,4) DEFAULT NULL,
  `redemptions` int(11) NOT NULL DEFAULT '0',
  `customer_redemptions` int(11) NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` date NOT NULL,
  `validity` char(15) NOT NULL,
  `fixed_date` date DEFAULT NULL,
  `fixed_from_time` time DEFAULT NULL,
  `fixed_to_time` time DEFAULT NULL,
  `period_start_date` date DEFAULT NULL,
  `period_end_date` date DEFAULT NULL,
  `recurring_every` varchar(35) NOT NULL,
  `recurring_from_time` time DEFAULT NULL,
  `recurring_to_time` time DEFAULT NULL,
  `order_restriction` tinyint(4) NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_coupons_history`
--

CREATE TABLE `yvdnsddqu_coupons_history` (
  `coupon_history_id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `code` varchar(15) NOT NULL,
  `min_total` decimal(15,4) DEFAULT NULL,
  `amount` decimal(15,4) DEFAULT NULL,
  `date_used` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_currencies`
--

CREATE TABLE `yvdnsddqu_currencies` (
  `currency_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `currency_name` varchar(32) NOT NULL,
  `currency_code` varchar(3) NOT NULL,
  `currency_symbol` varchar(3) NOT NULL,
  `currency_rate` decimal(15,8) NOT NULL,
  `symbol_position` tinyint(4) NOT NULL,
  `thousand_sign` char(1) NOT NULL,
  `decimal_sign` char(1) NOT NULL,
  `decimal_position` char(1) NOT NULL,
  `iso_alpha2` varchar(2) NOT NULL,
  `iso_alpha3` varchar(3) NOT NULL,
  `iso_numeric` int(11) NOT NULL,
  `flag` varchar(6) NOT NULL,
  `currency_status` int(1) NOT NULL,
  `date_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_currencies`
--

INSERT INTO `yvdnsddqu_currencies` (`currency_id`, `country_id`, `currency_name`, `currency_code`, `currency_symbol`, `currency_rate`, `symbol_position`, `thousand_sign`, `decimal_sign`, `decimal_position`, `iso_alpha2`, `iso_alpha3`, `iso_numeric`, `flag`, `currency_status`, `date_modified`) VALUES
(1, 47, 'Prueba 2', 'AFN', '؋', '0.00000000', 0, ',', '.', '2', 'AF', 'AFG', 4, 'AF.png', 0, '2018-08-29 11:24:25'),
(2, 2, 'Lek', 'ALL', 'Lek', '0.00000000', 0, ',', '.', '2', 'AL', 'ALB', 8, 'AL.png', 0, '2018-08-29 11:24:25'),
(3, 3, 'Dinar', 'DZD', 'د.ج', '0.00000000', 0, ',', '.', '2', 'DZ', 'DZA', 12, 'DZ.png', 0, '2018-08-29 11:24:25'),
(4, 4, 'Dollar', 'USD', '$', '0.00000000', 0, ',', '.', '2', 'AS', 'ASM', 16, 'AS.png', 0, '2018-08-29 11:24:25'),
(5, 5, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'AD', 'AND', 20, 'AD.png', 0, '2018-08-29 11:24:25'),
(6, 6, 'Kwanza', 'AOA', 'Kz', '0.00000000', 0, ',', '.', '2', 'AO', 'AGO', 24, 'AO.png', 0, '2018-08-29 11:24:25'),
(7, 7, 'Dollar', 'XCD', '$', '0.00000000', 0, ',', '.', '2', 'AI', 'AIA', 660, 'AI.png', 0, '2018-08-29 11:24:25'),
(8, 8, 'Antarctican', 'AQD', 'A$', '0.00000000', 1, ',', '.', '2', 'AQ', 'ATA', 10, 'AQ.png', 0, '2018-08-29 11:24:25'),
(9, 9, 'Dollar', 'XCD', '$', '0.00000000', 0, ',', '.', '2', 'AG', 'ATG', 28, 'AG.png', 0, '2018-08-29 11:24:25'),
(10, 10, 'Peso', 'ARS', '$', '0.00000000', 0, ',', '.', '2', 'AR', 'ARG', 32, 'AR.png', 0, '2018-08-29 11:24:25'),
(11, 11, 'Dram', 'AMD', 'դր.', '0.00000000', 0, ',', '.', '2', 'AM', 'ARM', 51, 'AM.png', 0, '2018-08-29 11:24:25'),
(12, 12, 'Guilder', 'AWG', 'ƒ', '0.00000000', 0, ',', '.', '2', 'AW', 'ABW', 533, 'AW.png', 0, '2018-08-29 11:24:25'),
(13, 13, 'Dollar', 'AUD', '$', '0.00000000', 0, ',', '.', '2', 'AU', 'AUS', 36, 'AU.png', 0, '2018-08-29 11:24:25'),
(14, 14, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'AT', 'AUT', 40, 'AT.png', 0, '2018-08-29 11:24:25'),
(15, 15, 'Manat', 'AZN', 'ман', '0.00000000', 0, ',', '.', '2', 'AZ', 'AZE', 31, 'AZ.png', 0, '2018-08-29 11:24:25'),
(16, 16, 'Dollar', 'BSD', '$', '0.00000000', 0, ',', '.', '2', 'BS', 'BHS', 44, 'BS.png', 0, '2018-08-29 11:24:25'),
(17, 17, 'Dinar', 'BHD', '.د.', '0.00000000', 0, ',', '.', '2', 'BH', 'BHR', 48, 'BH.png', 0, '2018-08-29 11:24:25'),
(18, 18, 'Taka', 'BDT', '৳', '0.00000000', 0, ',', '.', '2', 'BD', 'BGD', 50, 'BD.png', 0, '2018-08-29 11:24:25'),
(19, 19, 'Dollar', 'BBD', '$', '0.00000000', 0, ',', '.', '2', 'BB', 'BRB', 52, 'BB.png', 0, '2018-08-29 11:24:25'),
(20, 20, 'Ruble', 'BYR', 'p.', '0.00000000', 0, ',', '.', '2', 'BY', 'BLR', 112, 'BY.png', 0, '2018-08-29 11:24:25'),
(21, 21, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'BE', 'BEL', 56, 'BE.png', 0, '2018-08-29 11:24:25'),
(22, 22, 'Dollar', 'BZD', 'BZ$', '0.00000000', 0, ',', '.', '2', 'BZ', 'BLZ', 84, 'BZ.png', 0, '2018-08-29 11:24:25'),
(23, 23, 'Franc', 'XOF', '', '0.00000000', 0, ',', '.', '2', 'BJ', 'BEN', 204, 'BJ.png', 0, '2018-08-29 11:24:25'),
(24, 24, 'Dollar', 'BMD', '$', '0.00000000', 0, ',', '.', '2', 'BM', 'BMU', 60, 'BM.png', 0, '2018-08-29 11:24:25'),
(25, 25, 'Ngultrum', 'BTN', 'Nu.', '0.00000000', 0, ',', '.', '2', 'BT', 'BTN', 64, 'BT.png', 0, '2018-08-29 11:24:25'),
(26, 26, 'Boliviano', 'BOB', '$b', '0.00000000', 0, ',', '.', '2', 'BO', 'BOL', 68, 'BO.png', 0, '2018-08-29 11:24:25'),
(27, 27, 'Marka', 'BAM', 'KM', '0.00000000', 0, ',', '.', '2', 'BA', 'BIH', 70, 'BA.png', 0, '2018-08-29 11:24:25'),
(28, 28, 'Pula', 'BWP', 'P', '0.00000000', 0, ',', '.', '2', 'BW', 'BWA', 72, 'BW.png', 0, '2018-08-29 11:24:25'),
(29, 29, 'Krone', 'NOK', 'kr', '0.00000000', 0, ',', '.', '2', 'BV', 'BVT', 74, 'BV.png', 0, '2018-08-29 11:24:25'),
(30, 30, 'Real', 'BRL', 'R$', '0.00000000', 0, ',', '.', '2', 'BR', 'BRA', 76, 'BR.png', 0, '2018-08-29 11:24:25'),
(31, 31, 'Dollar', 'USD', '$', '0.00000000', 0, ',', '.', '2', 'IO', 'IOT', 86, 'IO.png', 0, '2018-08-29 11:24:25'),
(32, 231, 'Dollar', 'USD', '$', '0.00000000', 0, ',', '.', '2', 'VG', 'VGB', 92, 'VG.png', 0, '2018-08-29 11:24:25'),
(33, 32, 'Dollar', 'BND', '$', '0.00000000', 0, ',', '.', '2', 'BN', 'BRN', 96, 'BN.png', 0, '2018-08-29 11:24:25'),
(34, 33, 'Lev', 'BGN', 'лв', '0.00000000', 0, ',', '.', '2', 'BG', 'BGR', 100, 'BG.png', 0, '2018-08-29 11:24:25'),
(35, 34, 'Franc', 'XOF', '', '0.00000000', 0, ',', '.', '2', 'BF', 'BFA', 854, 'BF.png', 0, '2018-08-29 11:24:25'),
(36, 35, 'Franc', 'BIF', 'Fr', '0.00000000', 0, ',', '.', '2', 'BI', 'BDI', 108, 'BI.png', 0, '2018-08-29 11:24:25'),
(37, 36, 'Riels', 'KHR', '៛', '0.00000000', 0, ',', '.', '2', 'KH', 'KHM', 116, 'KH.png', 0, '2018-08-29 11:24:25'),
(38, 37, 'Franc', 'XAF', 'FCF', '0.00000000', 0, ',', '.', '2', 'CM', 'CMR', 120, 'CM.png', 0, '2018-08-29 11:24:25'),
(39, 38, 'Dollar', 'CAD', '$', '0.00000000', 0, ',', '.', '2', 'CA', 'CAN', 124, 'CA.png', 0, '2018-08-29 11:24:25'),
(40, 39, 'Escudo', 'CVE', '', '0.00000000', 0, ',', '.', '2', 'CV', 'CPV', 132, 'CV.png', 0, '2018-08-29 11:24:25'),
(41, 40, 'Dollar', 'KYD', '$', '0.00000000', 0, ',', '.', '2', 'KY', 'CYM', 136, 'KY.png', 0, '2018-08-29 11:24:25'),
(42, 41, 'Franc', 'XAF', 'FCF', '0.00000000', 0, ',', '.', '2', 'CF', 'CAF', 140, 'CF.png', 0, '2018-08-29 11:24:25'),
(43, 42, 'Franc', 'XAF', '', '0.00000000', 0, ',', '.', '2', 'TD', 'TCD', 148, 'TD.png', 0, '2018-08-29 11:24:25'),
(44, 43, 'Peso', 'CLP', '', '0.00000000', 0, ',', '.', '2', 'CL', 'CHL', 152, 'CL.png', 0, '2018-08-29 11:24:25'),
(45, 44, 'Yuan Renminbi', 'CNY', '¥', '0.00000000', 0, ',', '.', '2', 'CN', 'CHN', 156, 'CN.png', 0, '2018-08-29 11:24:25'),
(46, 45, 'Dollar', 'AUD', '$', '0.00000000', 0, ',', '.', '2', 'CX', 'CXR', 162, 'CX.png', 0, '2018-08-29 11:24:25'),
(47, 46, 'Dollar', 'AUD', '$', '0.00000000', 0, ',', '.', '2', 'CC', 'CCK', 166, 'CC.png', 0, '2018-08-29 11:24:25'),
(48, 47, 'Peso', 'COP', '$', '0.00000000', 0, ',', '.', '2', 'CO', 'COL', 170, 'CO.png', 0, '2018-08-29 11:24:25'),
(49, 48, 'Franc', 'KMF', '', '0.00000000', 0, ',', '.', '2', 'KM', 'COM', 174, 'KM.png', 0, '2018-08-29 11:24:25'),
(50, 50, 'Dollar', 'NZD', '$', '0.00000000', 0, ',', '.', '2', 'CK', 'COK', 184, 'CK.png', 0, '2018-08-29 11:24:25'),
(51, 51, 'Colon', 'CRC', '₡', '0.00000000', 0, ',', '.', '2', 'CR', 'CRI', 188, 'CR.png', 0, '2018-08-29 11:24:25'),
(52, 53, 'Kuna', 'HRK', 'kn', '0.00000000', 0, ',', '.', '2', 'HR', 'HRV', 191, 'HR.png', 0, '2018-08-29 11:24:25'),
(53, 54, 'Peso', 'CUP', '₱', '0.00000000', 0, ',', '.', '2', 'CU', 'CUB', 192, 'CU.png', 0, '2018-08-29 11:24:25'),
(54, 55, 'Pound', 'CYP', '', '0.00000000', 0, ',', '.', '2', 'CY', 'CYP', 196, 'CY.png', 0, '2018-08-29 11:24:25'),
(55, 56, 'Koruna', 'CZK', 'Kč', '0.00000000', 0, ',', '.', '2', 'CZ', 'CZE', 203, 'CZ.png', 0, '2018-08-29 11:24:25'),
(56, 49, 'Franc', 'CDF', 'FC', '0.00000000', 0, ',', '.', '2', 'CD', 'COD', 180, 'CD.png', 0, '2018-08-29 11:24:25'),
(57, 57, 'Krone', 'DKK', 'kr', '0.00000000', 0, ',', '.', '2', 'DK', 'DNK', 208, 'DK.png', 0, '2018-08-29 11:24:25'),
(58, 58, 'Franc', 'DJF', '', '0.00000000', 0, ',', '.', '2', 'DJ', 'DJI', 262, 'DJ.png', 0, '2018-08-29 11:24:25'),
(59, 59, 'Dollar', 'XCD', '$', '0.00000000', 0, ',', '.', '2', 'DM', 'DMA', 212, 'DM.png', 0, '2018-08-29 11:24:25'),
(60, 60, 'Peso', 'DOP', 'RD$', '0.00000000', 0, ',', '.', '2', 'DO', 'DOM', 214, 'DO.png', 0, '2018-08-29 11:24:25'),
(61, 61, 'Dollar', 'USD', '$', '0.00000000', 0, ',', '.', '2', 'TL', 'TLS', 626, 'TL.png', 0, '2018-08-29 11:24:25'),
(62, 62, 'Dollar', 'USD', '$', '0.00000000', 0, ',', '.', '2', 'EC', 'ECU', 218, 'EC.png', 0, '2018-08-29 11:24:25'),
(63, 63, 'Pound', 'EGP', '£', '0.00000000', 0, ',', '.', '2', 'EG', 'EGY', 818, 'EG.png', 0, '2018-08-29 11:24:25'),
(64, 64, 'Colone', 'SVC', '$', '0.00000000', 0, ',', '.', '2', 'SV', 'SLV', 222, 'SV.png', 0, '2018-08-29 11:24:25'),
(65, 65, 'Franc', 'XAF', 'FCF', '0.00000000', 0, ',', '.', '2', 'GQ', 'GNQ', 226, 'GQ.png', 0, '2018-08-29 11:24:25'),
(66, 66, 'Nakfa', 'ERN', 'Nfk', '0.00000000', 0, ',', '.', '2', 'ER', 'ERI', 232, 'ER.png', 0, '2018-08-29 11:24:25'),
(67, 67, 'Kroon', 'EEK', 'kr', '0.00000000', 0, ',', '.', '2', 'EE', 'EST', 233, 'EE.png', 0, '2018-08-29 11:24:25'),
(68, 68, 'Birr', 'ETB', '', '0.00000000', 0, ',', '.', '2', 'ET', 'ETH', 231, 'ET.png', 0, '2018-08-29 11:24:25'),
(69, 69, 'Pound', 'FKP', '£', '0.00000000', 0, ',', '.', '2', 'FK', 'FLK', 238, 'FK.png', 0, '2018-08-29 11:24:25'),
(70, 70, 'Krone', 'DKK', 'kr', '0.00000000', 0, ',', '.', '2', 'FO', 'FRO', 234, 'FO.png', 0, '2018-08-29 11:24:25'),
(71, 71, 'Dollar', 'FJD', '$', '0.00000000', 0, ',', '.', '2', 'FJ', 'FJI', 242, 'FJ.png', 0, '2018-08-29 11:24:25'),
(72, 72, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'FI', 'FIN', 246, 'FI.png', 0, '2018-08-29 11:24:25'),
(73, 73, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'FR', 'FRA', 250, 'FR.png', 0, '2018-08-29 11:24:25'),
(74, 75, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'GF', 'GUF', 254, 'GF.png', 0, '2018-08-29 11:24:25'),
(75, 76, 'Franc', 'XPF', '', '0.00000000', 0, ',', '.', '2', 'PF', 'PYF', 258, 'PF.png', 0, '2018-08-29 11:24:25'),
(76, 77, 'Euro  ', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'TF', 'ATF', 260, 'TF.png', 0, '2018-08-29 11:24:25'),
(77, 78, 'Franc', 'XAF', 'FCF', '0.00000000', 0, ',', '.', '2', 'GA', 'GAB', 266, 'GA.png', 0, '2018-08-29 11:24:25'),
(78, 79, 'Dalasi', 'GMD', 'D', '0.00000000', 0, ',', '.', '2', 'GM', 'GMB', 270, 'GM.png', 0, '2018-08-29 11:24:25'),
(79, 80, 'Lari', 'GEL', '', '0.00000000', 0, ',', '.', '2', 'GE', 'GEO', 268, 'GE.png', 0, '2018-08-29 11:24:25'),
(80, 81, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'DE', 'DEU', 276, 'DE.png', 0, '2018-08-29 11:24:25'),
(81, 82, 'Cedi', 'GHC', '¢', '0.00000000', 0, ',', '.', '2', 'GH', 'GHA', 288, 'GH.png', 0, '2018-08-29 11:24:25'),
(82, 83, 'Pound', 'GIP', '£', '0.00000000', 0, ',', '.', '2', 'GI', 'GIB', 292, 'GI.png', 0, '2018-08-29 11:24:25'),
(83, 84, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'GR', 'GRC', 300, 'GR.png', 0, '2018-08-29 11:24:25'),
(84, 85, 'Krone', 'DKK', 'kr', '0.00000000', 0, ',', '.', '2', 'GL', 'GRL', 304, 'GL.png', 0, '2018-08-29 11:24:25'),
(85, 86, 'Dollar', 'XCD', '$', '0.00000000', 0, ',', '.', '2', 'GD', 'GRD', 308, 'GD.png', 0, '2018-08-29 11:24:25'),
(86, 87, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'GP', 'GLP', 312, 'GP.png', 0, '2018-08-29 11:24:25'),
(87, 88, 'Dollar', 'USD', '$', '0.00000000', 0, ',', '.', '2', 'GU', 'GUM', 316, 'GU.png', 0, '2018-08-29 11:24:25'),
(88, 89, 'Quetzal', 'GTQ', 'Q', '0.00000000', 0, ',', '.', '2', 'GT', 'GTM', 320, 'GT.png', 0, '2018-08-29 11:24:25'),
(89, 90, 'Franc', 'GNF', '', '0.00000000', 0, ',', '.', '2', 'GN', 'GIN', 324, 'GN.png', 0, '2018-08-29 11:24:25'),
(90, 91, 'Franc', 'XOF', '', '0.00000000', 0, ',', '.', '2', 'GW', 'GNB', 624, 'GW.png', 0, '2018-08-29 11:24:25'),
(91, 92, 'Dollar', 'GYD', '$', '0.00000000', 0, ',', '.', '2', 'GY', 'GUY', 328, 'GY.png', 0, '2018-08-29 11:24:25'),
(92, 93, 'Gourde', 'HTG', 'G', '0.00000000', 0, ',', '.', '2', 'HT', 'HTI', 332, 'HT.png', 0, '2018-08-29 11:24:25'),
(93, 94, 'Dollar', 'AUD', '$', '0.00000000', 0, ',', '.', '2', 'HM', 'HMD', 334, 'HM.png', 0, '2018-08-29 11:24:25'),
(94, 95, 'Lempira', 'HNL', 'L', '0.00000000', 0, ',', '.', '2', 'HN', 'HND', 340, 'HN.png', 0, '2018-08-29 11:24:25'),
(95, 96, 'Dollar', 'HKD', '$', '0.00000000', 0, ',', '.', '2', 'HK', 'HKG', 344, 'HK.png', 0, '2018-08-29 11:24:25'),
(96, 97, 'Forint', 'HUF', 'Ft', '0.00000000', 0, ',', '.', '2', 'HU', 'HUN', 348, 'HU.png', 0, '2018-08-29 11:24:25'),
(97, 98, 'Krona', 'ISK', 'kr', '0.00000000', 0, ',', '.', '2', 'IS', 'ISL', 352, 'IS.png', 0, '2018-08-29 11:24:25'),
(98, 99, 'Rupee', 'INR', 'र', '0.01400000', 0, ',', '.', '2', 'IN', 'IND', 356, 'IN.png', 1, '2018-08-29 11:24:25'),
(99, 100, 'Rupiah', 'IDR', 'Rp', '0.00000000', 0, ',', '.', '2', 'ID', 'IDN', 360, 'ID.png', 0, '2018-08-29 11:24:25'),
(100, 101, 'Rial', 'IRR', '﷼', '0.00000000', 0, ',', '.', '2', 'IR', 'IRN', 364, 'IR.png', 0, '2018-08-29 11:24:25'),
(101, 102, 'Dinar', 'IQD', '', '0.00000000', 0, ',', '.', '2', 'IQ', 'IRQ', 368, 'IQ.png', 0, '2018-08-29 11:24:25'),
(102, 103, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'IE', 'IRL', 372, 'IE.png', 0, '2018-08-29 11:24:25'),
(103, 104, 'Shekel', 'ILS', '₪', '0.00000000', 0, ',', '.', '2', 'IL', 'ISR', 376, 'IL.png', 0, '2018-08-29 11:24:25'),
(104, 105, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'IT', 'ITA', 380, 'IT.png', 0, '2018-08-29 11:24:25'),
(105, 52, 'Franc', 'XOF', '', '0.00000000', 0, ',', '.', '2', 'CI', 'CIV', 384, 'CI.png', 0, '2018-08-29 11:24:25'),
(106, 106, 'Dollar', 'JMD', '$', '0.00000000', 0, ',', '.', '2', 'JM', 'JAM', 388, 'JM.png', 0, '2018-08-29 11:24:25'),
(107, 107, 'Yen', 'JPY', '¥', '0.00000000', 0, ',', '.', '2', 'JP', 'JPN', 392, 'JP.png', 0, '2018-08-29 11:24:25'),
(108, 108, 'Dinar', 'JOD', '', '0.00000000', 0, ',', '.', '2', 'JO', 'JOR', 400, 'JO.png', 0, '2018-08-29 11:24:25'),
(109, 109, 'Tenge', 'KZT', 'лв', '0.00000000', 0, ',', '.', '2', 'KZ', 'KAZ', 398, 'KZ.png', 0, '2018-08-29 11:24:25'),
(110, 110, 'Shilling', 'KES', '', '0.00000000', 0, ',', '.', '2', 'KE', 'KEN', 404, 'KE.png', 0, '2018-08-29 11:24:25'),
(111, 111, 'Dollar', 'AUD', '$', '0.00000000', 0, ',', '.', '2', 'KI', 'KIR', 296, 'KI.png', 0, '2018-08-29 11:24:25'),
(112, 114, 'Dinar', 'KWD', 'د.ك', '0.00000000', 0, ',', '.', '2', 'KW', 'KWT', 414, 'KW.png', 0, '2018-08-29 11:24:25'),
(113, 115, 'Som', 'KGS', 'лв', '0.00000000', 0, ',', '.', '2', 'KG', 'KGZ', 417, 'KG.png', 0, '2018-08-29 11:24:25'),
(114, 116, 'Kip', 'LAK', '₭', '0.00000000', 0, ',', '.', '2', 'LA', 'LAO', 418, 'LA.png', 0, '2018-08-29 11:24:25'),
(115, 117, 'Lat', 'LVL', 'Ls', '0.00000000', 0, ',', '.', '2', 'LV', 'LVA', 428, 'LV.png', 0, '2018-08-29 11:24:25'),
(116, 118, 'Pound', 'LBP', '£', '0.00000000', 0, ',', '.', '2', 'LB', 'LBN', 422, 'LB.png', 0, '2018-08-29 11:24:25'),
(117, 119, 'Loti', 'LSL', 'L', '0.00000000', 0, ',', '.', '2', 'LS', 'LSO', 426, 'LS.png', 0, '2018-08-29 11:24:25'),
(118, 120, 'Dollar', 'LRD', '$', '0.00000000', 0, ',', '.', '2', 'LR', 'LBR', 430, 'LR.png', 0, '2018-08-29 11:24:25'),
(119, 121, 'Dinar', 'LYD', 'ل.د', '0.00000000', 0, ',', '.', '2', 'LY', 'LBY', 434, 'LY.png', 0, '2018-08-29 11:24:25'),
(120, 122, 'Franc', 'CHF', 'CHF', '0.00000000', 0, ',', '.', '2', 'LI', 'LIE', 438, 'LI.png', 0, '2018-08-29 11:24:25'),
(121, 123, 'Litas', 'LTL', 'Lt', '0.00000000', 0, ',', '.', '2', 'LT', 'LTU', 440, 'LT.png', 0, '2018-08-29 11:24:25'),
(122, 124, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'LU', 'LUX', 442, 'LU.png', 0, '2018-08-29 11:24:25'),
(123, 125, 'Pataca', 'MOP', 'MOP', '0.00000000', 0, ',', '.', '2', 'MO', 'MAC', 446, 'MO.png', 0, '2018-08-29 11:24:25'),
(124, 140, 'Denar', 'MKD', 'ден', '0.00000000', 0, ',', '.', '2', 'MK', 'MKD', 807, 'MK.png', 0, '2018-08-29 11:24:25'),
(125, 127, 'Ariary', 'MGA', 'Ar', '0.00000000', 0, ',', '.', '2', 'MG', 'MDG', 450, 'MG.png', 0, '2018-08-29 11:24:25'),
(126, 128, 'Kwacha', 'MWK', 'MK', '0.00000000', 0, ',', '.', '2', 'MW', 'MWI', 454, 'MW.png', 0, '2018-08-29 11:24:25'),
(127, 129, 'Ringgit', 'MYR', 'RM', '0.00000000', 0, ',', '.', '2', 'MY', 'MYS', 458, 'MY.png', 0, '2018-08-29 11:24:25'),
(128, 130, 'Rufiyaa', 'MVR', 'Rf', '0.00000000', 0, ',', '.', '2', 'MV', 'MDV', 462, 'MV.png', 0, '2018-08-29 11:24:25'),
(129, 131, 'Franc', 'XOF', 'MAF', '0.00000000', 0, ',', '.', '2', 'ML', 'MLI', 466, 'ML.png', 0, '2018-08-29 11:24:25'),
(130, 132, 'Lira', 'MTL', 'Lm', '0.00000000', 0, ',', '.', '2', 'MT', 'MLT', 470, 'MT.png', 0, '2018-08-29 11:24:25'),
(131, 133, 'Dollar', 'USD', '$', '0.00000000', 0, ',', '.', '2', 'MH', 'MHL', 584, 'MH.png', 0, '2018-08-29 11:24:25'),
(132, 134, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'MQ', 'MTQ', 474, 'MQ.png', 0, '2018-08-29 11:24:25'),
(133, 135, 'Ouguiya', 'MRO', 'UM', '0.00000000', 0, ',', '.', '2', 'MR', 'MRT', 478, 'MR.png', 0, '2018-08-29 11:24:25'),
(134, 136, 'Rupee', 'MUR', '₨', '0.00000000', 0, ',', '.', '2', 'MU', 'MUS', 480, 'MU.png', 0, '2018-08-29 11:24:25'),
(135, 137, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'YT', 'MYT', 175, 'YT.png', 0, '2018-08-29 11:24:25'),
(136, 138, 'Peso', 'MXN', '$', '0.00000000', 0, ',', '.', '2', 'MX', 'MEX', 484, 'MX.png', 0, '2018-08-29 11:24:25'),
(137, 139, 'Dollar', 'USD', '$', '0.00000000', 0, ',', '.', '2', 'FM', 'FSM', 583, 'FM.png', 0, '2018-08-29 11:24:25'),
(138, 140, 'Leu', 'MDL', 'MDL', '0.00000000', 0, ',', '.', '2', 'MD', 'MDA', 498, 'MD.png', 0, '2018-08-29 11:24:25'),
(139, 141, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'MC', 'MCO', 492, 'MC.png', 0, '2018-08-29 11:24:25'),
(140, 142, 'Tugrik', 'MNT', '₮', '0.00000000', 0, ',', '.', '2', 'MN', 'MNG', 496, 'MN.png', 0, '2018-08-29 11:24:25'),
(141, 143, 'Dollar', 'XCD', '$', '0.00000000', 0, ',', '.', '2', 'MS', 'MSR', 500, 'MS.png', 0, '2018-08-29 11:24:25'),
(142, 144, 'Dirham', 'MAD', '', '0.00000000', 0, ',', '.', '2', 'MA', 'MAR', 504, 'MA.png', 0, '2018-08-29 11:24:25'),
(143, 145, 'Meticail', 'MZN', 'MT', '0.00000000', 0, ',', '.', '2', 'MZ', 'MOZ', 508, 'MZ.png', 0, '2018-08-29 11:24:25'),
(144, 146, 'Kyat', 'MMK', 'K', '0.00000000', 0, ',', '.', '2', 'MM', 'MMR', 104, 'MM.png', 0, '2018-08-29 11:24:25'),
(145, 147, 'Dollar', 'NAD', '$', '0.00000000', 0, ',', '.', '2', 'NA', 'NAM', 516, 'NA.png', 0, '2018-08-29 11:24:25'),
(146, 148, 'Dollar', 'AUD', '$', '0.00000000', 0, ',', '.', '2', 'NR', 'NRU', 520, 'NR.png', 0, '2018-08-29 11:24:25'),
(147, 149, 'Rupee', 'NPR', '₨', '0.00000000', 0, ',', '.', '2', 'NP', 'NPL', 524, 'NP.png', 0, '2018-08-29 11:24:25'),
(148, 150, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'NL', 'NLD', 528, 'NL.png', 0, '2018-08-29 11:24:25'),
(149, 151, 'Guilder', 'ANG', 'ƒ', '0.00000000', 0, ',', '.', '2', 'AN', 'ANT', 530, 'AN.png', 0, '2018-08-29 11:24:25'),
(150, 152, 'Franc', 'XPF', '', '0.00000000', 0, ',', '.', '2', 'NC', 'NCL', 540, 'NC.png', 0, '2018-08-29 11:24:25'),
(151, 153, 'Dollar', 'NZD', '$', '0.00000000', 0, ',', '.', '2', 'NZ', 'NZL', 554, 'NZ.png', 0, '2018-08-29 11:24:25'),
(152, 154, 'Cordoba', 'NIO', 'C$', '0.00000000', 0, ',', '.', '2', 'NI', 'NIC', 558, 'NI.png', 0, '2018-08-29 11:24:25'),
(153, 155, 'Franc', 'XOF', '', '0.00000000', 0, ',', '.', '2', 'NE', 'NER', 562, 'NE.png', 0, '2018-08-29 11:24:25'),
(154, 156, 'Naira', 'NGN', '₦', '0.00000000', 0, ',', '.', '2', 'NG', 'NGA', 566, 'NG.png', 0, '2018-08-29 11:24:25'),
(155, 157, 'Dollar', 'NZD', '$', '0.00000000', 0, ',', '.', '2', 'NU', 'NIU', 570, 'NU.png', 0, '2018-08-29 11:24:25'),
(156, 158, 'Dollar', 'AUD', '$', '0.00000000', 0, ',', '.', '2', 'NF', 'NFK', 574, 'NF.png', 0, '2018-08-29 11:24:25'),
(157, 112, 'Won', 'KPW', '₩', '0.00000000', 0, ',', '.', '2', 'KP', 'PRK', 408, 'KP.png', 0, '2018-08-29 11:24:25'),
(158, 159, 'Dollar', 'USD', '$', '0.00000000', 0, ',', '.', '2', 'MP', 'MNP', 580, 'MP.png', 0, '2018-08-29 11:24:25'),
(159, 160, 'Krone', 'NOK', 'kr', '0.00000000', 0, ',', '.', '2', 'NO', 'NOR', 578, 'NO.png', 0, '2018-08-29 11:24:25'),
(160, 161, 'Rial', 'OMR', '﷼', '0.00000000', 0, ',', '.', '2', 'OM', 'OMN', 512, 'OM.png', 0, '2018-08-29 11:24:25'),
(161, 162, 'Rupee', 'PKR', '₨', '0.00000000', 0, ',', '.', '2', 'PK', 'PAK', 586, 'PK.png', 0, '2018-08-29 11:24:25'),
(162, 163, 'Dollar', 'USD', '$', '0.00000000', 0, ',', '.', '2', 'PW', 'PLW', 585, 'PW.png', 0, '2018-08-29 11:24:25'),
(163, 0, 'Shekel', 'ILS', '₪', '0.00000000', 0, ',', '.', '2', 'PS', 'PSE', 275, 'PS.png', 0, '2018-08-29 11:24:25'),
(164, 164, 'Balboa', 'PAB', 'B/.', '0.00000000', 0, ',', '.', '2', 'PA', 'PAN', 591, 'PA.png', 0, '2018-08-29 11:24:25'),
(165, 165, 'Kina', 'PGK', '', '0.00000000', 0, ',', '.', '2', 'PG', 'PNG', 598, 'PG.png', 0, '2018-08-29 11:24:25'),
(166, 166, 'Guarani', 'PYG', 'Gs', '0.00000000', 0, ',', '.', '2', 'PY', 'PRY', 600, 'PY.png', 0, '2018-08-29 11:24:25'),
(167, 167, 'Sol', 'PEN', 'S/.', '0.00000000', 0, ',', '.', '2', 'PE', 'PER', 604, 'PE.png', 0, '2018-08-29 11:24:25'),
(168, 168, 'Peso', 'PHP', 'Php', '0.00000000', 0, ',', '.', '2', 'PH', 'PHL', 608, 'PH.png', 0, '2018-08-29 11:24:25'),
(169, 169, 'Dollar', 'NZD', '$', '0.00000000', 0, ',', '.', '2', 'PN', 'PCN', 612, 'PN.png', 0, '2018-08-29 11:24:25'),
(170, 170, 'Zloty', 'PLN', 'zł', '0.00000000', 0, ',', '.', '2', 'PL', 'POL', 616, 'PL.png', 0, '2018-08-29 11:24:25'),
(171, 171, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'PT', 'PRT', 620, 'PT.png', 0, '2018-08-29 11:24:25'),
(172, 172, 'Dollar', 'USD', '$', '0.00000000', 0, ',', '.', '2', 'PR', 'PRI', 630, 'PR.png', 0, '2018-08-29 11:24:25'),
(173, 173, 'Rial', 'QAR', '﷼', '0.00000000', 0, ',', '.', '2', 'QA', 'QAT', 634, 'QA.png', 0, '2018-08-29 11:24:25'),
(174, 49, 'Franc', 'XAF', 'FCF', '0.00000000', 0, ',', '.', '2', 'CG', 'COG', 178, 'CG.png', 0, '2018-08-29 11:24:25'),
(175, 174, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'RE', 'REU', 638, 'RE.png', 0, '2018-08-29 11:24:25'),
(176, 175, 'Leu', 'RON', 'lei', '0.00000000', 0, ',', '.', '2', 'RO', 'ROU', 642, 'RO.png', 0, '2018-08-29 11:24:25'),
(177, 176, 'Ruble', 'RUB', 'руб', '0.00000000', 0, ',', '.', '2', 'RU', 'RUS', 643, 'RU.png', 0, '2018-08-29 11:24:25'),
(178, 177, 'Franc', 'RWF', '', '0.00000000', 0, ',', '.', '2', 'RW', 'RWA', 646, 'RW.png', 0, '2018-08-29 11:24:25'),
(179, 179, 'Pound', 'SHP', '£', '0.00000000', 0, ',', '.', '2', 'SH', 'SHN', 654, 'SH.png', 0, '2018-08-29 11:24:25'),
(180, 178, 'Dollar', 'XCD', '$', '0.00000000', 0, ',', '.', '2', 'KN', 'KNA', 659, 'KN.png', 0, '2018-08-29 11:24:25'),
(181, 179, 'Dollar', 'XCD', '$', '0.00000000', 0, ',', '.', '2', 'LC', 'LCA', 662, 'LC.png', 0, '2018-08-29 11:24:25'),
(182, 180, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'PM', 'SPM', 666, 'PM.png', 0, '2018-08-29 11:24:25'),
(183, 180, 'Dollar', 'XCD', '$', '0.00000000', 0, ',', '.', '2', 'VC', 'VCT', 670, 'VC.png', 0, '2018-08-29 11:24:25'),
(184, 181, 'Tala', 'WST', 'WS$', '0.00000000', 0, ',', '.', '2', 'WS', 'WSM', 882, 'WS.png', 0, '2018-08-29 11:24:25'),
(185, 182, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'SM', 'SMR', 674, 'SM.png', 0, '2018-08-29 11:24:25'),
(186, 183, 'Dobra', 'STD', 'Db', '0.00000000', 0, ',', '.', '2', 'ST', 'STP', 678, 'ST.png', 0, '2018-08-29 11:24:25'),
(187, 184, 'Rial', 'SAR', '﷼', '0.00000000', 0, ',', '.', '2', 'SA', 'SAU', 682, 'SA.png', 0, '2018-08-29 11:24:25'),
(188, 185, 'Franc', 'XOF', '', '0.00000000', 0, ',', '.', '2', 'SN', 'SEN', 686, 'SN.png', 0, '2018-08-29 11:24:25'),
(189, 142, 'Dinar', 'RSD', 'Дин', '0.00000000', 0, ',', '.', '2', 'CS', 'SCG', 891, 'CS.png', 0, '2018-08-29 11:24:25'),
(190, 186, 'Rupee', 'SCR', '₨', '0.00000000', 0, ',', '.', '2', 'SC', 'SYC', 690, 'SC.png', 0, '2018-08-29 11:24:25'),
(191, 187, 'Leone', 'SLL', 'Le', '0.00000000', 0, ',', '.', '2', 'SL', 'SLE', 694, 'SL.png', 0, '2018-08-29 11:24:25'),
(192, 188, 'Dollar', 'SGD', '$', '0.00000000', 0, ',', '.', '2', 'SG', 'SGP', 702, 'SG.png', 0, '2018-08-29 11:24:25'),
(193, 189, 'Koruna', 'SKK', 'Sk', '0.00000000', 0, ',', '.', '2', 'SK', 'SVK', 703, 'SK.png', 0, '2018-08-29 11:24:25'),
(194, 190, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'SI', 'SVN', 705, 'SI.png', 0, '2018-08-29 11:24:25'),
(195, 191, 'Dollar', 'SBD', '$', '0.00000000', 0, ',', '.', '2', 'SB', 'SLB', 90, 'SB.png', 0, '2018-08-29 11:24:25'),
(196, 192, 'Shilling', 'SOS', 'S', '0.00000000', 0, ',', '.', '2', 'SO', 'SOM', 706, 'SO.png', 0, '2018-08-29 11:24:25'),
(197, 193, 'Rand', 'ZAR', 'R', '0.00000000', 0, ',', '.', '2', 'ZA', 'ZAF', 710, 'ZA.png', 0, '2018-08-29 11:24:25'),
(198, 113, 'Pound', 'GBP', '£', '0.00000000', 0, ',', '.', '2', 'GS', 'SGS', 239, 'GS.png', 0, '2018-08-29 11:24:25'),
(199, 194, 'Won', 'KRW', '₩', '0.00000000', 0, ',', '.', '2', 'KR', 'KOR', 410, 'KR.png', 0, '2018-08-29 11:24:25'),
(200, 195, 'Euro', 'EUR', '€', '0.00000000', 1, ',', '.', '2', 'ES', 'ESP', 724, 'ES.png', 0, '2018-08-29 11:24:25'),
(201, 196, 'Rupee', 'LKR', '₨', '0.00000000', 0, ',', '.', '2', 'LK', 'LKA', 144, 'LK.png', 0, '2018-08-29 11:24:25'),
(202, 199, 'Dinar', 'SDD', '', '0.00000000', 0, ',', '.', '2', 'SD', 'SDN', 736, 'SD.png', 0, '2018-08-29 11:24:25'),
(203, 200, 'Dollar', 'SRD', '$', '0.00000000', 0, ',', '.', '2', 'SR', 'SUR', 740, 'SR.png', 0, '2018-08-29 11:24:25'),
(204, 0, 'Krone', 'NOK', 'kr', '0.00000000', 0, ',', '.', '2', 'SJ', 'SJM', 744, 'SJ.png', 0, '2018-08-29 11:24:25'),
(205, 202, 'Lilangeni', 'SZL', '', '0.00000000', 0, ',', '.', '2', 'SZ', 'SWZ', 748, 'SZ.png', 0, '2018-08-29 11:24:25'),
(206, 203, 'Krona', 'SEK', 'kr', '0.00000000', 0, ',', '.', '2', 'SE', 'SWE', 752, 'SE.png', 0, '2018-08-29 11:24:25'),
(207, 204, 'Franc', 'CHF', 'CHF', '0.00000000', 0, ',', '.', '2', 'CH', 'CHE', 756, 'CH.png', 0, '2018-08-29 11:24:25'),
(208, 205, 'Pound', 'SYP', '£', '0.00000000', 0, ',', '.', '2', 'SY', 'SYR', 760, 'SY.png', 0, '2018-08-29 11:24:25'),
(209, 206, 'Dollar', 'TWD', 'NT$', '0.00000000', 0, ',', '.', '2', 'TW', 'TWN', 158, 'TW.png', 0, '2018-08-29 11:24:25'),
(210, 207, 'Somoni', 'TJS', '', '0.00000000', 0, ',', '.', '2', 'TJ', 'TJK', 762, 'TJ.png', 0, '2018-08-29 11:24:25'),
(211, 208, 'Shilling', 'TZS', '', '0.00000000', 0, ',', '.', '2', 'TZ', 'TZA', 834, 'TZ.png', 0, '2018-08-29 11:24:25'),
(212, 209, 'Baht', 'THB', '฿', '0.00000000', 0, ',', '.', '2', 'TH', 'THA', 764, 'TH.png', 0, '2018-08-29 11:24:25'),
(213, 210, 'Franc', 'XOF', '', '0.00000000', 0, ',', '.', '2', 'TG', 'TGO', 768, 'TG.png', 0, '2018-08-29 11:24:25'),
(214, 211, 'Dollar', 'NZD', '$', '0.00000000', 0, ',', '.', '2', 'TK', 'TKL', 772, 'TK.png', 0, '2018-08-29 11:24:25'),
(215, 212, 'Pa\'anga', 'TOP', 'T$', '0.00000000', 0, ',', '.', '2', 'TO', 'TON', 776, 'TO.png', 0, '2018-08-29 11:24:25'),
(216, 213, 'Dollar', 'TTD', 'TT$', '0.00000000', 0, ',', '.', '2', 'TT', 'TTO', 780, 'TT.png', 0, '2018-08-29 11:24:25'),
(217, 214, 'Dinar', 'TND', '', '0.00000000', 0, ',', '.', '2', 'TN', 'TUN', 788, 'TN.png', 0, '2018-08-29 11:24:25'),
(218, 215, 'Lira', 'TRY', 'YTL', '0.00000000', 0, ',', '.', '2', 'TR', 'TUR', 792, 'TR.png', 0, '2018-08-29 11:24:25'),
(219, 216, 'Manat', 'TMM', 'm', '0.00000000', 0, ',', '.', '2', 'TM', 'TKM', 795, 'TM.png', 0, '2018-08-29 11:24:25'),
(220, 217, 'Dollar', 'USD', '$', '0.00000000', 0, ',', '.', '2', 'TC', 'TCA', 796, 'TC.png', 0, '2018-08-29 11:24:25'),
(221, 218, 'Dollar', 'AUD', '$', '0.00000000', 0, ',', '.', '2', 'TV', 'TUV', 798, 'TV.png', 0, '2018-08-29 11:24:25'),
(222, 232, 'Dollar', 'USD', '$', '0.00000000', 0, ',', '.', '2', 'VI', 'VIR', 850, 'VI.png', 0, '2018-08-29 11:24:25'),
(223, 219, 'Shilling', 'UGX', '', '0.00000000', 0, ',', '.', '2', 'UG', 'UGA', 800, 'UG.png', 0, '2018-08-29 11:24:25'),
(224, 220, 'Hryvnia', 'UAH', '₴', '0.00000000', 0, ',', '.', '2', 'UA', 'UKR', 804, 'UA.png', 0, '2018-08-29 11:24:25'),
(225, 221, 'Dirham', 'AED', '', '0.00000000', 0, ',', '.', '2', 'AE', 'ARE', 784, 'AE.png', 0, '2018-08-29 11:24:25'),
(226, 222, 'Pound', 'GBP', '£', '0.00000000', 0, ',', '.', '2', 'GB', 'GBR', 826, 'GB.png', 0, '2018-08-29 11:24:25'),
(227, 223, 'Dollar', 'USD', '$', '0.00000000', 0, ',', '.', '2', 'US', 'USA', 840, 'US.png', 0, '2018-08-29 11:24:25'),
(228, 224, 'Dollar ', 'USD', '$', '0.00000000', 0, ',', '.', '2', 'UM', 'UMI', 581, 'UM.png', 0, '2018-08-29 11:24:25'),
(229, 225, 'Peso', 'UYU', '$U', '0.00000000', 0, ',', '.', '2', 'UY', 'URY', 858, 'UY.png', 0, '2018-08-29 11:24:25'),
(230, 226, 'Som', 'UZS', 'лв', '0.00000000', 0, ',', '.', '2', 'UZ', 'UZB', 860, 'UZ.png', 0, '2018-08-29 11:24:25'),
(231, 227, 'Vatu', 'VUV', 'Vt', '0.00000000', 0, ',', '.', '2', 'VU', 'VUT', 548, 'VU.png', 0, '2018-08-29 11:24:25'),
(232, 228, 'Euro', 'EUR', '€', '0.00000000', 0, ',', '.', '2', 'VA', 'VAT', 336, 'VA.png', 0, '2018-08-29 11:24:25'),
(233, 229, 'Bolivar', 'VEF', 'Bs', '0.00000000', 0, ',', '.', '2', 'VE', 'VEN', 862, 'VE.png', 0, '2018-08-29 11:24:25'),
(234, 230, 'Dong', 'VND', '₫', '0.00000000', 0, ',', '.', '2', 'VN', 'VNM', 704, 'VN.png', 0, '2018-08-29 11:24:25'),
(235, 233, 'Franc', 'XPF', '', '0.00000000', 0, ',', '.', '2', 'WF', 'WLF', 876, 'WF.png', 0, '2018-08-29 11:24:25'),
(236, 234, 'Dirham', 'MAD', '', '0.00000000', 0, ',', '.', '2', 'EH', 'ESH', 732, 'EH.png', 0, '2018-08-29 11:24:25'),
(237, 235, 'Rial', 'YER', '﷼', '0.00000000', 0, ',', '.', '2', 'YE', 'YEM', 887, 'YE.png', 0, '2018-08-29 11:24:25'),
(238, 238, 'Kwacha', 'ZMK', 'ZK', '0.00000000', 0, ',', '.', '2', 'ZM', 'ZMB', 894, 'ZM.png', 0, '2018-08-29 11:24:25'),
(239, 239, 'Dollar', 'ZWD', 'Z$', '0.00000000', 0, ',', '.', '2', 'ZW', 'ZWE', 716, 'ZW.png', 0, '2018-08-29 11:24:25'),
(240, 99, 'Rupee', 'INR', 'Rs.', '1.00000000', 0, ',', '.', '2', '', '', 0, '', 0, '0000-00-00 00:00:00'),
(241, 113, 'Won', 'KRW', '₩', '100.50000000', 0, ',', '.', '3', '', '', 0, '', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_customers`
--

CREATE TABLE `yvdnsddqu_customers` (
  `customer_id` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `language` varchar(20) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `deviceid` varchar(500) DEFAULT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(9) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `address_id` int(11) NOT NULL,
  `security_question_id` int(11) NOT NULL,
  `security_answer` varchar(32) NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `newsletter` tinyint(1) NOT NULL,
  `customer_group_id` int(11) NOT NULL,
  `ip_address` varchar(40) NOT NULL,
  `date_added` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `otp` varchar(50) DEFAULT NULL,
  `verify_otp` varchar(50) DEFAULT NULL,
  `vip_status` int(2) NOT NULL DEFAULT '0',
  `cart` text NOT NULL,
  `profile_picture` varchar(250) NOT NULL,
  `notification_status` int(11) NOT NULL DEFAULT '1',
  `reward_points` int(5) NOT NULL,
  `verified_status` int(10) NOT NULL DEFAULT '0',
  `added_by` int(10) NOT NULL DEFAULT '11',
  `location_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_customers`
--

INSERT INTO `yvdnsddqu_customers` (`customer_id`, `first_name`, `last_name`, `email`, `language`, `currency`, `deviceid`, `password`, `salt`, `telephone`, `address_id`, `security_question_id`, `security_answer`, `profile_image`, `newsletter`, `customer_group_id`, `ip_address`, `date_added`, `status`, `otp`, `verify_otp`, `vip_status`, `cart`, `profile_picture`, `notification_status`, `reward_points`, `verified_status`, `added_by`, `location_id`) VALUES
(2, 'Mary', 'Rose', 'mary@yopmail.com', NULL, NULL, NULL, 'ca715542c79bf06c4263d9ebf852417b5b6b97d9', 'b20bcf1db', '+355-9876543210', 2, 11, 'Black', '', 0, 11, '157.50.98.179', '2020-05-05 00:00:00', 1, NULL, NULL, 0, '', '', 1, 0, 0, 11, NULL),
(3, 'Testuser', 'test', 'testuser@yopmail.com', NULL, NULL, NULL, 'ae07ee2c4cd7c56bc41a9c3b4c0916904200873d', '692b82dfd', '+41-6775555555', 0, 15, 'testuser', '', 0, 11, '::1', '2020-05-15 00:00:00', 1, NULL, NULL, 0, '', '', 1, 0, 0, 11, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_customers_online`
--

CREATE TABLE `yvdnsddqu_customers_online` (
  `activity_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `access_type` varchar(128) NOT NULL,
  `browser` varchar(128) NOT NULL,
  `ip_address` varchar(40) NOT NULL,
  `country_code` varchar(2) NOT NULL,
  `request_uri` text NOT NULL,
  `referrer_uri` text NOT NULL,
  `date_added` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `user_agent` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_customers_online`
--

INSERT INTO `yvdnsddqu_customers_online` (`activity_id`, `customer_id`, `access_type`, `browser`, `ip_address`, `country_code`, `request_uri`, `referrer_uri`, `date_added`, `status`, `user_agent`) VALUES
(1, 0, 'browser', 'Chrome', '223.181.247.31', 'IN', '', 'local/15655_dffjd?action=find_table&location=23&guest_num=12&tables=0&table_price=&reserve_date=30-04-2020&reserve_time=12%3A15', '2020-04-30 11:52:14', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(2, 0, 'browser', 'Chrome', '106.198.35.182', 'IN', '', '', '2020-04-30 12:31:56', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.81 Safari/537.36'),
(3, 0, 'browser', 'Chrome', '157.50.213.167', 'ID', '', '', '2020-05-02 07:18:39', 0, 'Mozilla/5.0 (Windows NT 6.1; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(4, 0, 'browser', 'Chrome', '157.50.213.167', 'ID', 'account/check_reg', 'register', '2020-05-02 07:20:43', 0, 'Mozilla/5.0 (Windows NT 6.1; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(5, 1, 'browser', 'Chrome', '157.50.213.167', 'ID', '^localmenus|reservation|contact|local|cart|checkout|pages)?/data)$?action=select_time&menu_page=true', 'home', '2020-05-02 07:24:16', 0, 'Mozilla/5.0 (Windows NT 6.1; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(6, 1, 'browser', 'Chrome', '157.50.213.167', 'ID', '^localmenus|reservation|contact|local|cart|checkout|pages)?/data)$?action=checkout&', 'local/data?action=select_time&menu_page=true', '2020-05-02 07:27:58', 0, 'Mozilla/5.0 (Windows NT 6.1; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(7, 1, 'browser', 'Chrome', '157.50.213.167', 'ID', '^localmenus|reservation|contact|local|cart|checkout|pages)?/data)$?action=select_time&menu_page=true', '', '2020-05-02 07:30:53', 0, 'Mozilla/5.0 (Windows NT 6.1; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(8, 1, 'browser', 'Chrome', '157.50.213.167', 'ID', 'account', 'local/data?action=checkout&', '2020-05-02 07:37:52', 0, 'Mozilla/5.0 (Windows NT 6.1; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(9, 1, 'browser', 'Chrome', '157.50.213.167', 'ID', '', '', '2020-05-02 08:56:53', 0, 'Mozilla/5.0 (Windows NT 6.1; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(10, 1, 'browser', 'Chrome', '157.50.213.167', 'ID', '^reservationmenus|reservation|contact|local|cart|checkout|pages)?/get_table_details)$', 'local/data', '2020-05-02 09:00:46', 0, 'Mozilla/5.0 (Windows NT 6.1; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(11, 1, 'browser', 'Chrome', '157.50.213.167', 'ID', '^localmenus|reservation|contact|local|cart|checkout|pages)?/data)$', 'local/data?action=select_time&menu_page=true', '2020-05-02 09:04:16', 0, 'Mozilla/5.0 (Windows NT 6.1; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(12, 1, 'browser', 'Chrome', '157.50.213.167', 'ID', '^localmenus|reservation|contact|local|cart|checkout|pages)?/data)$', 'local/data?action=select_time&menu_page=true', '2020-05-02 09:06:18', 0, 'Mozilla/5.0 (Windows NT 6.1; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(13, 1, 'browser', 'Chrome', '157.50.213.167', 'ID', '^localmenus|reservation|contact|local|cart|checkout|pages)?/data)$', 'local/data?action=select_time&menu_page=true', '2020-05-02 09:09:01', 0, 'Mozilla/5.0 (Windows NT 6.1; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(14, 1, 'browser', 'Chrome', '157.50.213.167', 'ID', '^reservationmenus|reservation|contact|local|cart|checkout|pages)?/get_table_details)$', 'local/data', '2020-05-02 09:11:03', 0, 'Mozilla/5.0 (Windows NT 6.1; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(15, 1, 'browser', 'Chrome', '157.50.213.167', 'ID', 'reservation_module/get_timings', 'local/data?action=find_table&location=1&guest_num=1500&tables=100&table_price=0&reserve_date=13-05-2020&reserve_time=00%3A15', '2020-05-02 09:13:09', 0, 'Mozilla/5.0 (Windows NT 6.1; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(16, 0, 'browser', 'Chrome', '117.196.249.137', 'IN', '', '', '2020-05-02 09:55:48', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(17, 0, 'browser', 'Chrome', '117.196.249.137', 'IN', '', '', '2020-05-02 14:43:28', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(18, 0, 'mobile', 'Android', '157.50.241.93', 'ID', '^localmenus|reservation|contact|local|cart|checkout|pages)?/sdsfsfsdf)$?action=select_time&menu_page=true', 'home', '2020-05-03 08:28:43', 0, 'Mozilla/5.0 (Linux; Android 9; RMX1805) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Mobile Safari/537.36'),
(19, 0, 'browser', 'Chrome', '157.46.4.113', 'ID', '', '', '2020-05-04 07:36:04', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36'),
(20, 0, 'browser', 'Chrome', '106.198.33.37', 'IN', '', '', '2020-05-04 09:36:37', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36'),
(21, 0, 'browser', 'Chrome', '157.50.209.247', 'ID', '', '', '2020-05-04 10:45:22', 0, 'Mozilla/5.0 (Windows NT 6.1; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(22, 1, 'browser', 'Chrome', '157.50.209.247', 'ID', 'home', 'login', '2020-05-04 11:46:25', 0, 'Mozilla/5.0 (Windows NT 6.1; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(23, 0, 'browser', 'Chrome', '157.51.204.180', 'ID', '', 'admin/dashboard', '2020-05-04 14:34:10', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(24, 0, 'browser', 'Chrome', '157.51.115.63', 'ID', '', 'admin/dashboard', '2020-05-04 15:00:30', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(25, 0, 'browser', 'Chrome', '106.198.74.241', 'IN', '', '', '2020-05-05 07:09:02', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36'),
(26, 0, 'browser', 'Chrome', '106.198.20.234', 'IN', '', 'admin/dashboard', '2020-05-05 07:14:10', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(27, 0, 'browser', 'Chrome', '106.198.20.234', 'IN', '^localmenus|reservation|contact|local|cart|checkout|pages)?/data)$?action=select_time&menu_page=true', '', '2020-05-05 07:34:14', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(28, 0, 'browser', 'Chrome', '106.198.20.234', 'IN', 'account/check_reg', 'register', '2020-05-05 07:37:13', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(29, 0, 'browser', 'Chrome', '157.51.104.67', 'ID', 'login', 'register', '2020-05-05 08:02:18', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(30, 0, 'browser', 'Chrome', '157.51.104.67', 'ID', 'login', 'login', '2020-05-05 08:20:27', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(31, 2, 'browser', 'Chrome', '157.51.239.168', 'ID', 'account/address/edit', 'account/address', '2020-05-05 08:21:22', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(32, 2, 'browser', 'Chrome', '157.51.104.67', 'ID', 'account/address', 'admin/customers_online', '2020-05-05 08:22:56', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(33, 2, 'browser', 'Chrome', '157.46.80.68', 'ID', 'account/orders', 'account/address', '2020-05-05 12:22:29', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(34, 2, 'browser', 'Chrome', '157.46.80.68', 'ID', '', 'account/orders', '2020-05-05 13:43:47', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(35, 2, 'browser', 'Chrome', '157.46.80.68', 'ID', '^localmenus|reservation|contact|local|cart|checkout|pages)?/data)$?action=select_time&menu_page=true', 'home', '2020-05-05 13:55:38', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(36, 2, 'browser', 'Chrome', '157.46.80.68', 'ID', 'home', 'locations?search=Madurai,%20Tamil%20Nadu,%20India&type=both', '2020-05-05 15:07:32', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(37, 2, 'browser', 'Chrome', '157.46.80.68', 'ID', '^localmenus|reservation|contact|local|cart|checkout|pages)?/levelup)$?action=select_time&menu_page=true', 'home', '2020-05-05 15:11:19', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(38, 0, '', '', '3.82.223.254', 'US', 'home', '', '2020-05-05 15:15:36', 0, 'Slackbot-LinkExpanding 1.0 (+https://api.slack.com/robots)'),
(39, 2, 'browser', 'Chrome', '157.46.80.68', 'ID', 'home', '', '2020-05-05 15:21:51', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(40, 2, 'browser', 'Chrome', '157.46.80.68', 'ID', 'home', '', '2020-05-05 15:24:03', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(41, 2, 'browser', 'Chrome', '157.46.80.68', 'ID', '^localmenus|reservation|contact|local|cart|checkout|pages)?/data)$?action=checkout&', 'local/data?action=select_time&menu_page=true', '2020-05-05 15:26:38', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(42, 2, 'browser', 'Chrome', '157.46.80.68', 'ID', 'account/orders', 'account/orders/view/2', '2020-05-05 15:34:53', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(43, 2, 'browser', 'Chrome', '157.46.80.68', 'ID', 'account', 'account/orders/view/2', '2020-05-05 16:11:15', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(44, 2, 'browser', 'Chrome', '157.46.80.68', 'ID', 'account', 'account/orders/view/3', '2020-05-05 16:16:13', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(45, 2, 'browser', 'Chrome', '157.46.80.68', 'ID', 'account/orders', 'account/reviews', '2020-05-05 16:18:52', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(46, 0, 'browser', 'Chrome', '106.198.46.42', 'IN', '', 'admin/locations', '2020-05-06 09:04:47', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(47, 2, 'browser', 'Chrome', '106.198.46.42', 'IN', 'cart_module/cart_module/options?menu_id=2&row_id=1', 'local/data?action=select_time&menu_page=true', '2020-05-06 09:16:59', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(48, 2, 'browser', 'Chrome', '106.198.46.42', 'IN', 'account/orders/view/3', 'account/orders', '2020-05-06 09:19:41', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(49, 0, 'browser', 'Chrome', '106.198.27.121', 'IN', '', '', '2020-05-06 09:23:42', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36'),
(50, 0, 'browser', 'Chrome', '157.51.158.129', 'ID', '', '', '2020-05-06 16:26:37', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36'),
(51, 0, 'browser', 'Chrome', '106.211.209.3', 'IN', '', '', '2020-05-06 20:16:30', 0, 'Mozilla/5.0 (Windows NT 6.1; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(52, 2, 'browser', 'Chrome', '106.211.209.3', 'IN', 'account/orders/view/4', 'Local/reserve_order_insert', '2020-05-06 20:18:35', 0, 'Mozilla/5.0 (Windows NT 6.1; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(53, 0, 'browser', 'Chrome', '106.211.209.227', 'IN', 'account/orders/view/4', 'Local/reserve_order_insert', '2020-05-07 08:47:09', 0, 'Mozilla/5.0 (Windows NT 6.1; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(54, 0, 'browser', 'Chrome', '106.211.234.196', 'IN', '', '', '2020-05-07 10:11:34', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.129 Safari/537.36'),
(55, 0, 'browser', 'Chrome', '223.181.225.59', 'IN', '', '', '2020-05-07 19:00:11', 0, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36'),
(56, 0, 'browser', 'Chrome', '61.68.34.74', 'AU', 'login', '', '2020-05-08 05:06:04', 0, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(57, 0, 'browser', 'Chrome', '157.50.98.179', 'ID', '', '', '2020-05-08 13:45:59', 0, 'Mozilla/5.0 (Windows NT 6.1; ) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(58, 0, 'mobile', 'Android', '157.50.98.179', 'ID', 'login', '', '2020-05-08 14:03:15', 0, 'Mozilla/5.0 (Linux; Android 9; RMX1805) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Mobile Safari/537.36'),
(59, 0, 'mobile', 'Android', '157.50.98.179', 'ID', 'login', 'login', '2020-05-08 14:05:30', 0, 'Mozilla/5.0 (Linux; Android 9; RMX1805) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Mobile Safari/537.36'),
(60, 2, 'mobile', 'Android', '157.50.98.179', 'ID', 'cart_module/cart_module/add', 'local/data?action=select_time&menu_page=true', '2020-05-08 14:07:37', 0, 'Mozilla/5.0 (Linux; Android 9; RMX1805) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Mobile Safari/537.36'),
(61, 2, 'mobile', 'Android', '157.50.98.179', 'ID', '', 'local/data?action=select_time&menu_page=true', '2020-05-08 14:11:58', 0, 'Mozilla/5.0 (Linux; Android 9; RMX1805) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Mobile Safari/537.36'),
(62, 2, 'mobile', 'Android', '157.50.98.179', 'ID', '', 'local/data?action=select_time&menu_page=true', '2020-05-08 14:14:03', 0, 'Mozilla/5.0 (Linux; Android 9; RMX1805) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Mobile Safari/537.36'),
(63, 2, 'mobile', 'Android', '157.50.98.179', 'ID', '', 'local/data?action=select_time&menu_page=true', '2020-05-08 14:17:35', 0, 'Mozilla/5.0 (Linux; Android 9; RMX1805) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Mobile Safari/537.36'),
(64, 2, 'mobile', 'Android', '157.50.98.179', 'ID', '', 'local/levelup?action=select_time&menu_page=true', '2020-05-08 14:20:03', 0, 'Mozilla/5.0 (Linux; Android 9; RMX1805) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Mobile Safari/537.36'),
(65, 0, 'mobile', 'Android', '157.50.98.179', 'ID', '^localmenus|reservation|contact|local|cart|checkout|pages)?/levelup)$?action=select_time&menu_page=true', '', '2020-05-08 15:35:50', 0, 'Mozilla/5.0 (Linux; Android 9; RMX1805) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Mobile Safari/537.36'),
(66, 0, 'browser', 'Chrome', '::1', '0', '', '', '2020-05-11 19:22:38', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(67, 0, 'browser', 'Chrome', '::1', '0', '', '', '2020-05-11 19:36:27', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(68, 0, 'browser', 'Chrome', '::1', '0', '^localmenus|reservation|contact|local|cart|checkout|pages)?/data)$?action=select_time&menu_page=true', '', '2020-05-11 20:39:23', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(69, 0, 'browser', 'Chrome', '::1', '0', 'locations?search=%20', 'local/data?action=select_time&menu_page=true', '2020-05-11 20:45:33', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(70, 0, 'browser', 'Chrome', '::1', '0', '^localmenus|reservation|contact|local|cart|checkout|pages)?/levelup)$', 'local/levelup?action=select_time&menu_page=true', '2020-05-11 20:47:58', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(71, 0, 'browser', 'Chrome', '::1', '0', '', '', '2020-05-11 21:30:29', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(72, 0, 'browser', 'Chrome', '::1', '0', '', 'http://localhost/Nadesh/', '2020-05-12 19:36:01', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(73, 0, 'browser', 'Chrome', '::1', '0', '', '', '2020-05-12 21:09:30', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(74, 0, 'browser', 'Chrome', '::1', '0', '', 'http://localhost/Nadesh/', '2020-05-14 12:21:54', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(75, 0, 'browser', 'Chrome', '::1', '0', '', '', '2020-05-15 13:22:11', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(76, 0, 'browser', 'Chrome', '::1', '0', '', '', '2020-05-15 13:42:48', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(77, 0, 'browser', 'Chrome', '::1', '0', '', 'http://localhost/Nadesh/', '2020-05-15 14:04:15', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(78, 0, 'browser', 'Chrome', '::1', '0', '', '', '2020-05-15 17:54:05', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(79, 0, 'browser', 'Chrome', '::1', '0', 'locations?keyword=&search=Madurai%2C+Tamil+Nadu%2C+India&type=&rating=&sort_by=&veg_type=&delivery_fee=&offer_collection=', 'locations?keyword=&search=Melbourne%20VIC,%20Australia&type=', '2020-05-15 17:56:15', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(80, 0, 'browser', 'Chrome', '::1', '0', 'locations?keyword=ne&search=Madurai%2C+Tamil+Nadu%2C+India&type=&rating=&sort_by=&veg_type=&delivery_fee=&offer_collection=', 'locations?keyword=next&search=Madurai%2C+Tamil+Nadu%2C+India&type=&rating=&sort_by=&veg_type=&delivery_fee=&offer_collection=', '2020-05-15 17:59:22', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(81, 0, 'browser', 'Chrome', '::1', '0', 'locations?keyword=&search=Madurai%2C+Tamil+Nadu%2C+India&type=&rating=&sort_by=&veg_type=&delivery_fee=&offer_collection=', 'locations?keyword=ne&search=Madurai%2C+Tamil+Nadu%2C+India&type=&rating=&sort_by=&veg_type=&delivery_fee=&offer_collection=', '2020-05-15 18:15:44', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(82, 0, 'browser', 'Chrome', '::1', '0', '', '', '2020-05-16 12:51:26', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(83, 0, 'browser', 'Chrome', '::1', '0', '', '', '2020-05-16 12:54:50', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(84, 0, 'browser', 'Chrome', '::1', '0', '', '', '2020-05-16 12:57:06', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(85, 0, 'browser', 'Chrome', '::1', '0', '', '', '2020-05-16 13:00:05', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(86, 0, 'browser', 'Chrome', '::1', '0', '', '', '2020-05-16 13:03:52', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(87, 0, 'browser', 'Chrome', '::1', '0', '', 'http://localhost/Nadesh/', '2020-05-16 13:11:53', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(88, 0, 'browser', 'Chrome', '::1', '0', '', 'http://localhost/Nadesh/', '2020-05-16 18:41:05', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(89, 0, 'browser', 'Chrome', '::1', '0', '', 'http://localhost/Nadesh/', '2020-05-16 18:44:16', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(90, 0, 'browser', 'Chrome', '::1', '0', '', '', '2020-05-18 14:20:36', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(91, 0, 'browser', 'Chrome', '::1', '0', '', 'admin/customers/edit?id=2', '2020-05-18 14:28:05', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(92, 0, 'browser', 'Chrome', '::1', '0', 'main/views/themes/spotneat/css/bootstrap.css.map', '', '2020-05-18 14:30:07', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(93, 0, 'browser', 'Chrome', '::1', '0', 'login', 'local/data?action=select_time&menu_page=true', '2020-05-18 14:33:36', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(94, 0, 'browser', 'Chrome', '::1', '0', 'login', 'local/data?action=select_time&menu_page=true', '2020-05-18 15:25:50', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(95, 3, 'browser', 'Chrome', '::1', '0', '', 'local/levelup?action=select_time&menu_page=true', '2020-05-18 15:28:22', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(96, 3, 'browser', 'Chrome', '::1', '0', 'locations?search=Madurai,%20Tamil%20Nadu,%20India&type=both', '', '2020-05-18 15:31:20', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(97, 3, 'browser', 'Chrome', '::1', '0', 'main/views/themes/spotneat/css/bootstrap.css.map', '', '2020-05-18 15:33:21', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(98, 3, 'browser', 'Chrome', '::1', '0', '', 'account/address/edit', '2020-05-18 15:37:15', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(99, 3, 'browser', 'Chrome', '::1', '0', 'locations?search=Madurai,%20Tamil%20Nadu,%20India&type=both', '', '2020-05-18 15:40:46', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(100, 3, 'browser', 'Chrome', '::1', '0', 'locations?search=Madurai,%20Tamil%20Nadu,%20India&type=both', '', '2020-05-18 15:47:05', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(101, 3, 'browser', 'Chrome', '::1', '0', 'locations?search=Madurai,%20Tamil%20Nadu,%20India&type=both', '', '2020-05-18 15:49:10', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(102, 3, 'browser', 'Chrome', '::1', '0', 'locations?search=Madurai,%20Tamil%20Nadu,%20India&type=both', '', '2020-05-18 15:51:41', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(103, 3, 'browser', 'Chrome', '::1', '0', 'account', 'locations?search=Madurai,%20Tamil%20Nadu,%20India&type=both', '2020-05-18 16:15:48', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(104, 3, 'browser', 'Chrome', '::1', '0', '', 'account', '2020-05-18 16:19:00', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(105, 3, 'browser', 'Chrome', '::1', '0', '', 'account', '2020-05-18 16:24:11', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(106, 3, 'browser', 'Chrome', '::1', '0', '', 'admin/settings', '2020-05-18 16:30:18', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(107, 3, 'browser', 'Chrome', '::1', '0', '', 'admin/settings', '2020-05-18 16:32:57', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(108, 0, 'browser', 'Chrome', '::1', '0', '', 'admin/settings', '2020-05-18 17:58:20', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(109, 0, 'browser', 'Chrome', '::1', '0', '', '', '2020-05-18 18:37:07', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(110, 0, 'browser', 'Chrome', '::1', '0', 'cart_module/cart_module/options?menu_id=2&row_id=1', 'local/data?action=select_time&menu_page=true', '2020-05-18 19:41:00', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(111, 0, 'browser', 'Chrome', '::1', '0', '', 'http://localhost/Nadesh/Clone/Techno/WEB_API/', '2020-05-18 19:49:28', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36'),
(112, 0, 'browser', 'Chrome', '::1', '0', '', 'admin/settings', '2020-05-18 20:02:53', 0, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/81.0.4044.138 Safari/537.36');

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_customer_groups`
--

CREATE TABLE `yvdnsddqu_customer_groups` (
  `customer_group_id` int(11) NOT NULL,
  `group_name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `approval` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_customer_groups`
--

INSERT INTO `yvdnsddqu_customer_groups` (`customer_group_id`, `group_name`, `description`, `approval`) VALUES
(11, 'Default', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_delivery`
--

CREATE TABLE `yvdnsddqu_delivery` (
  `delivery_id` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `language` varchar(20) DEFAULT NULL,
  `currency` varchar(20) DEFAULT NULL,
  `deviceid` varchar(500) DEFAULT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(9) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `address_id` int(11) NOT NULL,
  `security_question_id` int(11) NOT NULL,
  `security_answer` varchar(32) NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `newsletter` tinyint(1) NOT NULL,
  `delivery_group_id` int(11) NOT NULL,
  `ip_address` varchar(40) NOT NULL,
  `date_added` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `vip_status` int(2) NOT NULL DEFAULT '0',
  `cart` text NOT NULL,
  `profile_picture` varchar(250) NOT NULL,
  `notification_status` int(11) NOT NULL DEFAULT '1',
  `reward_points` int(5) NOT NULL,
  `verified_status` int(2) NOT NULL DEFAULT '0',
  `verify_otp` int(10) NOT NULL,
  `wallet` varchar(100) NOT NULL DEFAULT '0',
  `bank_name` varchar(100) DEFAULT NULL,
  `account_number` varchar(100) DEFAULT NULL,
  `routing_number` varchar(100) DEFAULT NULL,
  `otp` varchar(10) DEFAULT NULL,
  `added_by` int(10) DEFAULT NULL,
  `account_name` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_delivery_addresses`
--

CREATE TABLE `yvdnsddqu_delivery_addresses` (
  `address_id` int(11) NOT NULL,
  `customer_id` int(15) NOT NULL,
  `address_1` varchar(128) NOT NULL,
  `address_2` varchar(128) NOT NULL,
  `city` varchar(128) NOT NULL,
  `state` varchar(128) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `country_id` int(11) DEFAULT '0',
  `specification` varchar(255) NOT NULL,
  `default_address` varchar(10) NOT NULL DEFAULT 'off',
  `clatitude` varchar(50) NOT NULL,
  `clongitude` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_delivery_booking`
--

CREATE TABLE `yvdnsddqu_delivery_booking` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `today_date` date NOT NULL,
  `status` int(11) NOT NULL,
  `amount` double(8,2) NOT NULL,
  `fare` varchar(11) DEFAULT NULL,
  `Surge_charge` varchar(11) DEFAULT NULL,
  `rest_fee` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_delivery_groups`
--

CREATE TABLE `yvdnsddqu_delivery_groups` (
  `delivery_group_id` int(11) NOT NULL,
  `group_name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `approval` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_delivery_groups`
--

INSERT INTO `yvdnsddqu_delivery_groups` (`delivery_group_id`, `group_name`, `description`, `approval`) VALUES
(11, 'Default', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_delivery_history`
--

CREATE TABLE `yvdnsddqu_delivery_history` (
  `id` int(11) NOT NULL,
  `invoice_id` varchar(150) NOT NULL,
  `deliver_id` int(11) NOT NULL,
  `payment_type` varchar(11) NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `amount` double(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_delivery_online`
--

CREATE TABLE `yvdnsddqu_delivery_online` (
  `activity_id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `access_type` varchar(128) NOT NULL,
  `browser` varchar(128) NOT NULL,
  `ip_address` varchar(40) NOT NULL,
  `country_code` varchar(2) NOT NULL,
  `request_uri` text NOT NULL,
  `referrer_uri` text NOT NULL,
  `date_added` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `user_agent` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_deliver_checkin`
--

CREATE TABLE `yvdnsddqu_deliver_checkin` (
  `checkin_id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `checkin_status` varchar(5) DEFAULT NULL,
  `wallet` double(8,2) DEFAULT '0.00',
  `checkin_date` datetime NOT NULL,
  `checkout_date` datetime DEFAULT NULL,
  `total_hrs` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_extensions`
--

CREATE TABLE `yvdnsddqu_extensions` (
  `extension_id` int(11) NOT NULL,
  `type` varchar(32) NOT NULL,
  `name` varchar(128) NOT NULL,
  `data` text NOT NULL,
  `serialized` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `title` varchar(255) NOT NULL,
  `version` varchar(11) NOT NULL DEFAULT '1.0.0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_extensions`
--

INSERT INTO `yvdnsddqu_extensions` (`extension_id`, `type`, `name`, `data`, `serialized`, `status`, `title`, `version`) VALUES
(11, 'module', 'account_module', 'a:1:{s:7:\"layouts\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"11\";s:8:\"position\";s:4:\"left\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}', 1, 1, 'Account', '1.0.0'),
(12, 'module', 'local_module', 'a:3:{s:20:\"location_search_mode\";s:5:\"multi\";s:12:\"use_location\";s:1:\"0\";s:6:\"status\";s:1:\"1\";}', 1, 1, 'Local', '1.0.0'),
(13, 'module', 'categories_module', 'a:1:{s:7:\"layouts\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"12\";s:8:\"position\";s:4:\"left\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}', 1, 1, 'Categories', '1.0.0'),
(14, 'module', 'cart_module', 'a:7:{s:16:\"show_cart_images\";s:1:\"0\";s:13:\"cart_images_h\";s:2:\"40\";s:13:\"cart_images_w\";s:2:\"40\";s:10:\"fixed_cart\";s:1:\"1\";s:16:\"fixed_top_offset\";s:3:\"375\";s:19:\"fixed_bottom_offset\";s:1:\"0\";s:11:\"cart_totals\";a:5:{i:1;a:4:{s:4:\"name\";s:10:\"cart_total\";s:5:\"title\";s:9:\"Sub Total\";s:11:\"admin_title\";s:9:\"Sub Total\";s:6:\"status\";s:1:\"1\";}i:2;a:4:{s:4:\"name\";s:6:\"coupon\";s:5:\"title\";s:15:\"Coupon {coupon}\";s:11:\"admin_title\";s:15:\"Coupon {coupon}\";s:6:\"status\";s:1:\"1\";}i:3;a:4:{s:4:\"name\";s:8:\"delivery\";s:5:\"title\";s:8:\"Delivery\";s:11:\"admin_title\";s:8:\"Delivery\";s:6:\"status\";s:1:\"1\";}i:4;a:4:{s:4:\"name\";s:5:\"taxes\";s:5:\"title\";s:15:\"Total Tax {tax}\";s:11:\"admin_title\";s:15:\"Total Tax {tax}\";s:6:\"status\";s:1:\"1\";}i:5;a:4:{s:4:\"name\";s:11:\"order_total\";s:5:\"title\";s:11:\"Order Total\";s:11:\"admin_title\";s:11:\"Order Total\";s:6:\"status\";s:1:\"1\";}}}', 1, 1, 'Cart', '1.0.0'),
(15, 'module', 'reservation_module', 'a:1:{s:7:\"layouts\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"16\";s:8:\"position\";s:4:\"left\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}', 1, 1, 'Reservation', '1.0.0'),
(16, 'module', 'slideshow', 'a:6:{s:11:\"dimension_w\";s:4:\"1920\";s:11:\"dimension_h\";s:3:\"700\";s:6:\"effect\";s:4:\"fade\";s:5:\"speed\";s:3:\"500\";s:7:\"display\";s:1:\"1\";s:6:\"slides\";a:2:{i:0;a:2:{s:9:\"image_src\";s:20:\"data/restaurant4.jpg\";s:7:\"caption\";s:0:\"\";}i:1;a:2:{s:9:\"image_src\";s:21:\"data/restaurant7.jpeg\";s:7:\"caption\";s:0:\"\";}}}', 1, 1, 'Slideshow', '1.0.0'),
(18, 'payment', 'cod', 'a:5:{s:5:\"title\";s:16:\"Cash On Delivery\";s:11:\"order_total\";s:4:\"0.00\";s:12:\"order_status\";s:1:\"1\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}', 1, 1, 'Cash On Delivery', '1.0.0'),
(20, 'module', 'pages_module', 'a:1:{s:7:\"layouts\";a:1:{i:0;a:4:{s:9:\"layout_id\";s:2:\"17\";s:8:\"position\";s:5:\"right\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}}}', 1, 1, 'Pages', '1.0.0'),
(21, 'payment', 'paypal_express', 'a:10:{s:5:\"title\";s:14:\"PayPal Express\";s:8:\"api_user\";s:23:\"bilal.uplogic@gmail.com\";s:8:\"api_pass\";s:10:\"bilal@1104\";s:13:\"api_signature\";s:70:\"access_token$sandbox$w9pgrs6bmr3y62tn$dd4f997dd54ca7913f7f4a051ae3f521\";s:8:\"api_mode\";s:7:\"sandbox\";s:10:\"api_action\";s:4:\"sale\";s:11:\"order_total\";s:4:\"0.00\";s:12:\"order_status\";s:1:\"2\";s:8:\"priority\";s:0:\"\";s:6:\"status\";s:1:\"1\";}', 1, 1, 'PayPal Express', '1.0.0'),
(23, 'theme', 'tastyigniter-orange', 'a:20:{s:14:\"display_crumbs\";s:1:\"1\";s:15:\"hide_admin_link\";s:1:\"0\";s:16:\"ga_tracking_code\";s:0:\"\";s:4:\"font\";a:5:{s:6:\"family\";s:25:\"\"Oxygen\",Arial,sans-serif\";s:6:\"weight\";s:6:\"normal\";s:5:\"style\";s:6:\"normal\";s:4:\"size\";s:2:\"13\";s:5:\"color\";s:7:\"#333333\";}s:9:\"menu_font\";a:5:{s:6:\"family\";s:25:\"\"Oxygen\",Arial,sans-serif\";s:6:\"weight\";s:6:\"normal\";s:5:\"style\";s:6:\"normal\";s:4:\"size\";s:2:\"16\";s:5:\"color\";s:7:\"#ffffff\";}s:4:\"body\";a:6:{s:10:\"background\";s:7:\"#ffffff\";s:5:\"image\";s:0:\"\";s:7:\"display\";s:7:\"contain\";s:10:\"foreground\";s:7:\"#ffffff\";s:5:\"color\";s:7:\"#ed561a\";s:6:\"border\";s:7:\"#dddddd\";}s:4:\"link\";a:2:{s:5:\"color\";s:7:\"#337ab7\";s:5:\"hover\";s:7:\"#23527c\";}s:7:\"heading\";a:6:{s:10:\"background\";s:0:\"\";s:5:\"image\";s:0:\"\";s:7:\"display\";s:7:\"contain\";s:5:\"color\";s:7:\"#333333\";s:11:\"under_image\";s:0:\"\";s:12:\"under_height\";s:2:\"50\";}s:6:\"button\";a:6:{s:7:\"default\";a:3:{s:10:\"background\";s:7:\"#e7e7e7\";s:5:\"hover\";s:7:\"#e7e7e7\";s:4:\"font\";s:7:\"#333333\";}s:7:\"primary\";a:3:{s:10:\"background\";s:7:\"#428bca\";s:5:\"hover\";s:7:\"#428bca\";s:4:\"font\";s:7:\"#ffffff\";}s:7:\"success\";a:3:{s:10:\"background\";s:7:\"#5cb85c\";s:5:\"hover\";s:7:\"#5cb85c\";s:4:\"font\";s:7:\"#ffffff\";}s:4:\"info\";a:3:{s:10:\"background\";s:7:\"#5bc0de\";s:5:\"hover\";s:7:\"#5bc0de\";s:4:\"font\";s:7:\"#ffffff\";}s:7:\"warning\";a:3:{s:10:\"background\";s:7:\"#f0ad4e\";s:5:\"hover\";s:7:\"#f0ad4e\";s:4:\"font\";s:7:\"#ffffff\";}s:6:\"danger\";a:3:{s:10:\"background\";s:7:\"#d9534f\";s:6:\"border\";s:7:\"#d9534f\";s:4:\"font\";s:7:\"#ffffff\";}}s:7:\"sidebar\";a:5:{s:10:\"background\";s:7:\"#ffffff\";s:5:\"image\";s:0:\"\";s:7:\"display\";s:7:\"contain\";s:4:\"font\";s:7:\"#484848\";s:6:\"border\";s:7:\"#eeeeee\";}s:6:\"header\";a:5:{s:10:\"background\";s:7:\"#ed561a\";s:5:\"image\";s:0:\"\";s:7:\"display\";s:7:\"contain\";s:19:\"dropdown_background\";s:7:\"#ed561a\";s:5:\"color\";s:7:\"#ffffff\";}s:10:\"logo_image\";s:0:\"\";s:9:\"logo_text\";s:0:\"\";s:11:\"logo_height\";s:2:\"40\";s:16:\"logo_padding_top\";s:2:\"10\";s:19:\"logo_padding_bottom\";s:2:\"10\";s:7:\"favicon\";s:0:\"\";s:6:\"footer\";a:8:{s:10:\"background\";s:7:\"#edeff1\";s:5:\"image\";s:0:\"\";s:7:\"display\";s:7:\"contain\";s:17:\"bottom_background\";s:7:\"#fbfbfb\";s:12:\"bottom_image\";s:0:\"\";s:14:\"bottom_display\";s:7:\"contain\";s:12:\"footer_color\";s:7:\"#9ba1a7\";s:19:\"bottom_footer_color\";s:7:\"#a3aaaf\";}s:6:\"social\";a:12:{s:8:\"facebook\";s:1:\"#\";s:7:\"twitter\";s:1:\"#\";s:6:\"google\";s:1:\"#\";s:7:\"youtube\";s:1:\"#\";s:5:\"vimeo\";s:0:\"\";s:8:\"linkedin\";s:0:\"\";s:9:\"pinterest\";s:0:\"\";s:6:\"tumblr\";s:0:\"\";s:6:\"flickr\";s:0:\"\";s:9:\"instagram\";s:0:\"\";s:8:\"dribbble\";s:0:\"\";s:10:\"foursquare\";s:0:\"\";}s:13:\"custom_script\";a:3:{s:3:\"css\";s:0:\"\";s:4:\"head\";s:0:\"\";s:6:\"footer\";s:0:\"\";}}', 1, 1, 'TastyIgniter Orange', '2.0'),
(24, 'theme', 'tastyigniter-blue', '', 1, 0, 'TastyIgniter Blue', '1.0.0'),
(25, 'module', 'banners_module', 'a:1:{s:7:\"banners\";a:1:{i:1;a:5:{s:9:\"banner_id\";s:1:\"1\";s:14:\"layout_partial\";s:17:\"11|content_bottom\";s:5:\"width\";s:4:\"1920\";s:6:\"height\";s:3:\"300\";s:6:\"status\";s:1:\"1\";}}}', 1, 1, 'Banners', '1.0.0'),
(26, 'cart_total', 'cart_total', 'a:5:{s:4:\"name\";s:10:\"cart_total\";s:5:\"title\";s:9:\"Sub Total\";s:11:\"admin_title\";s:9:\"Sub Total\";s:6:\"status\";s:1:\"1\";s:8:\"priority\";i:1;}', 1, 1, 'Sub Total', '1.0.0'),
(27, 'cart_total', 'coupon', 'a:5:{s:4:\"name\";s:6:\"coupon\";s:5:\"title\";s:15:\"Coupon {coupon}\";s:11:\"admin_title\";s:15:\"Coupon {coupon}\";s:6:\"status\";s:1:\"1\";s:8:\"priority\";i:2;}', 1, 1, 'Coupon {coupon}', '1.0.0'),
(28, 'cart_total', 'delivery', 'a:5:{s:4:\"name\";s:8:\"delivery\";s:5:\"title\";s:8:\"Delivery\";s:11:\"admin_title\";s:8:\"Delivery\";s:6:\"status\";s:1:\"1\";s:8:\"priority\";i:3;}', 1, 1, 'Delivery', '1.0.0'),
(29, 'cart_total', 'taxes', 'a:5:{s:4:\"name\";s:5:\"taxes\";s:5:\"title\";s:15:\"Total Tax {tax}\";s:11:\"admin_title\";s:15:\"Total Tax {tax}\";s:6:\"status\";s:1:\"1\";s:8:\"priority\";i:4;}', 1, 1, 'Total Tax {tax}', '1.0.0'),
(30, 'cart_total', 'order_total', 'a:5:{s:4:\"name\";s:11:\"order_total\";s:5:\"title\";s:11:\"Order Total\";s:11:\"admin_title\";s:11:\"Order Total\";s:6:\"status\";s:1:\"1\";s:8:\"priority\";i:5;}', 1, 1, 'Order Total', '1.0.0'),
(31, 'theme', 'trabezah', 'a:20:{s:14:\"display_crumbs\";s:1:\"0\";s:15:\"hide_admin_link\";s:1:\"0\";s:16:\"ga_tracking_code\";s:0:\"\";s:4:\"font\";a:5:{s:6:\"family\";s:28:\"\"Open Sans\",Arial,sans-serif\";s:6:\"weight\";s:6:\"normal\";s:5:\"style\";s:6:\"normal\";s:4:\"size\";s:2:\"13\";s:5:\"color\";s:7:\"#333333\";}s:9:\"menu_font\";a:5:{s:6:\"family\";s:28:\"\"Open Sans\",Arial,sans-serif\";s:6:\"weight\";s:6:\"normal\";s:5:\"style\";s:6:\"normal\";s:4:\"size\";s:2:\"16\";s:5:\"color\";s:7:\"#ffffff\";}s:4:\"body\";a:6:{s:10:\"background\";s:7:\"#ffffff\";s:5:\"image\";s:0:\"\";s:7:\"display\";s:7:\"contain\";s:10:\"foreground\";s:7:\"#ffffff\";s:5:\"color\";s:7:\"#b48d50\";s:6:\"border\";s:7:\"#dddddd\";}s:4:\"link\";a:2:{s:5:\"color\";s:7:\"#b48d50\";s:5:\"hover\";s:7:\"#b48d50\";}s:7:\"heading\";a:6:{s:10:\"background\";s:0:\"\";s:5:\"image\";s:0:\"\";s:7:\"display\";s:7:\"contain\";s:5:\"color\";s:7:\"#000000\";s:11:\"under_image\";s:0:\"\";s:12:\"under_height\";s:2:\"50\";}s:6:\"button\";a:6:{s:7:\"default\";a:3:{s:10:\"background\";s:7:\"#b48d50\";s:5:\"hover\";s:7:\"#b48d50\";s:4:\"font\";s:7:\"#333333\";}s:7:\"primary\";a:3:{s:10:\"background\";s:7:\"#b48d50\";s:5:\"hover\";s:7:\"#b48d50\";s:4:\"font\";s:7:\"#ffffff\";}s:7:\"success\";a:3:{s:10:\"background\";s:7:\"#5cb85c\";s:5:\"hover\";s:7:\"#5cb85c\";s:4:\"font\";s:7:\"#ffffff\";}s:4:\"info\";a:3:{s:10:\"background\";s:7:\"#5bc0de\";s:5:\"hover\";s:7:\"#5bc0de\";s:4:\"font\";s:7:\"#ffffff\";}s:7:\"warning\";a:3:{s:10:\"background\";s:7:\"#f0ad4e\";s:5:\"hover\";s:7:\"#f0ad4e\";s:4:\"font\";s:7:\"#ffffff\";}s:6:\"danger\";a:3:{s:10:\"background\";s:7:\"#d9534f\";s:6:\"border\";s:7:\"#d9534f\";s:4:\"font\";s:7:\"#ffffff\";}}s:7:\"sidebar\";a:5:{s:10:\"background\";s:7:\"#ffffff\";s:5:\"image\";s:0:\"\";s:7:\"display\";s:7:\"contain\";s:4:\"font\";s:7:\"#484848\";s:6:\"border\";s:7:\"#eeeeee\";}s:6:\"header\";a:5:{s:10:\"background\";s:7:\"#b48d50\";s:5:\"image\";s:0:\"\";s:7:\"display\";s:7:\"contain\";s:19:\"dropdown_background\";s:7:\"#ed561a\";s:5:\"color\";s:7:\"#ffffff\";}s:10:\"logo_image\";s:0:\"\";s:9:\"logo_text\";s:0:\"\";s:11:\"logo_height\";s:2:\"40\";s:16:\"logo_padding_top\";s:2:\"10\";s:19:\"logo_padding_bottom\";s:2:\"10\";s:7:\"favicon\";s:0:\"\";s:6:\"footer\";a:8:{s:10:\"background\";s:7:\"#edeff1\";s:5:\"image\";s:0:\"\";s:7:\"display\";s:5:\"tiled\";s:17:\"bottom_background\";s:7:\"#fbfbfb\";s:12:\"bottom_image\";s:0:\"\";s:14:\"bottom_display\";s:5:\"tiled\";s:12:\"footer_color\";s:7:\"#9ba1a7\";s:19:\"bottom_footer_color\";s:7:\"#a3aaaf\";}s:6:\"social\";a:12:{s:8:\"facebook\";s:1:\"#\";s:7:\"twitter\";s:1:\"#\";s:6:\"google\";s:1:\"#\";s:7:\"youtube\";s:1:\"#\";s:5:\"vimeo\";s:0:\"\";s:8:\"linkedin\";s:0:\"\";s:9:\"pinterest\";s:0:\"\";s:6:\"tumblr\";s:0:\"\";s:6:\"flickr\";s:0:\"\";s:9:\"instagram\";s:0:\"\";s:8:\"dribbble\";s:0:\"\";s:10:\"foursquare\";s:0:\"\";}s:13:\"custom_script\";a:3:{s:3:\"css\";s:0:\"\";s:4:\"head\";s:0:\"\";s:6:\"footer\";s:0:\"\";}}', 1, 1, 'Trabezah beige', '2.0'),
(32, 'module', 'twilio_module', 'a:8:{s:5:\"title\";s:18:\"Twilio SMS Gateway\";s:11:\"account_sid\";s:34:\"ACee35f82df60836e724e77310d4afe9a8\";s:11:\"api_version\";s:10:\"2010-04-01\";s:10:\"auth_token\";s:32:\"4632e18bb4f3ffbab74400e289b1cac7\";s:8:\"api_mode\";s:7:\"sandbox\";s:14:\"account_number\";s:12:\"+14792402098\";s:6:\"status\";s:1:\"0\";s:9:\"templates\";a:12:{i:1;a:2:{s:4:\"code\";s:18:\"reservation_arabic\";s:4:\"body\";s:161:\"معرف الحجز الخاص بك هو {reservation_number}. عرض الرمز الفريد - {unique_code} في مكتب الاستقبال في المطعم.\";}i:2;a:2:{s:4:\"code\";s:25:\"reservation_update_arabic\";s:4:\"body\";s:66:\"كان حجزك {status} لمعرف حجزك {reservation_number}.\";}i:3;a:2:{s:4:\"code\";s:19:\"reservation_english\";s:4:\"body\";s:108:\"Your Booking ID is {reservation_number} . Show the Unique code - {unique_code} in the restaurant front desk.\";}i:4;a:2:{s:4:\"code\";s:26:\"reservation_update_english\";s:4:\"body\";s:72:\"Your Booking has been {status} for your Booking ID {reservation_number}.\";}i:14;a:2:{s:4:\"code\";s:27:\"reservation_location_arabic\";s:4:\"body\";s:120:\"حجز جديد مستلم\r\n\r\nمعرف الحجز - {reservation_number}. كود فريد للعملاء - {unique_code}\";}i:15;a:2:{s:4:\"code\";s:30:\"reserve_update_location_arabic\";s:4:\"body\";s:57:\"معرف الحجز {reservation_number} كان {status}.\";}i:13;a:2:{s:4:\"code\";s:28:\"reservation_location_english\";s:4:\"body\";s:98:\"New Booking Received,\r\n\r\nBooking ID - {reservation_number} . Customers Unique code - {unique_code}\";}i:16;a:2:{s:4:\"code\";s:31:\"reserve_update_location_english\";s:4:\"body\";s:50:\"Booking ID {reservation_number} has been {status}.\";}i:6;a:2:{s:4:\"code\";s:16:\"register_english\";s:4:\"body\";s:65:\"Welcome {username} to Trabezah, Please use code {otp} to activate\";}i:5;a:2:{s:4:\"code\";s:15:\"register_arabic\";s:4:\"body\";s:88:\"مرحبا بك {username} في طربيزة ، يرجى استخدام الكود {otp}\";}i:12;a:2:{s:4:\"code\";s:14:\"resend_english\";s:4:\"body\";s:49:\"Greetings From Trabezah, Your 4 digit OTP : {otp}\";}i:11;a:2:{s:4:\"code\";s:13:\"resend_arabic\";s:4:\"body\";s:93:\"تحية من طرابيزة ، رقمك المكتبي المكون من 4 أرقام: {otp}\";}}}', 1, 1, 'Twilio', '1.0.0'),
(33, 'module', 'feedback_module', 'a:1:{s:6:\"status\";s:1:\"1\";}', 1, 1, 'Feedback', '1.0.0'),
(34, 'payment', '2checkout', 'a:8:{s:5:\"title\";s:17:\"2checkout Payment\";s:8:\"username\";s:10:\"joepraveen\";s:8:\"password\";s:9:\"Pass_1234\";s:9:\"seller_id\";s:9:\"901397223\";s:11:\"private_key\";s:36:\"057FA665-FD09-4D1B-9D11-1A5BC7F3A592\";s:12:\"secret_token\";s:48:\"MDJjYzUxMTEtOTYxZC00ZmJhLWE1YTEtZTU5M2IzNmIyYjQ2\";s:8:\"api_mode\";s:7:\"sandbox\";s:6:\"status\";s:1:\"1\";}', 1, 0, '2checkout Payment', '1.0.0'),
(35, 'theme', 'spotneat', 'a:20:{s:14:\"display_crumbs\";s:1:\"1\";s:15:\"hide_admin_link\";s:1:\"0\";s:16:\"ga_tracking_code\";s:0:\"\";s:4:\"font\";a:5:{s:6:\"family\";s:25:\"\"Oxygen\",Arial,sans-serif\";s:6:\"weight\";s:6:\"normal\";s:5:\"style\";s:6:\"normal\";s:4:\"size\";s:2:\"13\";s:5:\"color\";s:7:\"#333333\";}s:9:\"menu_font\";a:5:{s:6:\"family\";s:25:\"\"Oxygen\",Arial,sans-serif\";s:6:\"weight\";s:6:\"normal\";s:5:\"style\";s:6:\"normal\";s:4:\"size\";s:2:\"16\";s:5:\"color\";s:7:\"#ffffff\";}s:4:\"body\";a:6:{s:10:\"background\";s:7:\"#ffffff\";s:5:\"image\";s:0:\"\";s:7:\"display\";s:7:\"contain\";s:10:\"foreground\";s:7:\"#ffffff\";s:5:\"color\";s:7:\"#f5511e\";s:6:\"border\";s:7:\"#dddddd\";}s:4:\"link\";a:2:{s:5:\"color\";s:7:\"#f5511e\";s:5:\"hover\";s:7:\"#f5511e\";}s:7:\"heading\";a:6:{s:10:\"background\";s:0:\"\";s:5:\"image\";s:0:\"\";s:7:\"display\";s:7:\"contain\";s:5:\"color\";s:7:\"#333333\";s:11:\"under_image\";s:0:\"\";s:12:\"under_height\";s:2:\"50\";}s:6:\"button\";a:6:{s:7:\"default\";a:3:{s:10:\"background\";s:7:\"#f5511e\";s:5:\"hover\";s:7:\"#f5511e\";s:4:\"font\";s:7:\"#ffffff\";}s:7:\"primary\";a:3:{s:10:\"background\";s:7:\"#f5511e\";s:5:\"hover\";s:7:\"#f5511e\";s:4:\"font\";s:7:\"#ffffff\";}s:7:\"success\";a:3:{s:10:\"background\";s:7:\"#5cb85c\";s:5:\"hover\";s:7:\"#5cb85c\";s:4:\"font\";s:7:\"#ffffff\";}s:4:\"info\";a:3:{s:10:\"background\";s:7:\"#5bc0de\";s:5:\"hover\";s:7:\"#5bc0de\";s:4:\"font\";s:7:\"#ffffff\";}s:7:\"warning\";a:3:{s:10:\"background\";s:7:\"#f0ad4e\";s:5:\"hover\";s:7:\"#f0ad4e\";s:4:\"font\";s:7:\"#ffffff\";}s:6:\"danger\";a:3:{s:10:\"background\";s:7:\"#d9534f\";s:6:\"border\";s:7:\"#d9534f\";s:4:\"font\";s:7:\"#ffffff\";}}s:7:\"sidebar\";a:5:{s:10:\"background\";s:7:\"#ffffff\";s:5:\"image\";s:0:\"\";s:7:\"display\";s:7:\"contain\";s:4:\"font\";s:7:\"#484848\";s:6:\"border\";s:7:\"#eeeeee\";}s:6:\"header\";a:5:{s:10:\"background\";s:7:\"#f5511e\";s:5:\"image\";s:0:\"\";s:7:\"display\";s:7:\"contain\";s:19:\"dropdown_background\";s:7:\"#f5511e\";s:5:\"color\";s:7:\"#ffffff\";}s:10:\"logo_image\";s:0:\"\";s:9:\"logo_text\";s:0:\"\";s:11:\"logo_height\";s:2:\"40\";s:16:\"logo_padding_top\";s:2:\"10\";s:19:\"logo_padding_bottom\";s:2:\"10\";s:7:\"favicon\";s:0:\"\";s:6:\"footer\";a:8:{s:10:\"background\";s:7:\"#edeff1\";s:5:\"image\";s:0:\"\";s:7:\"display\";s:7:\"contain\";s:17:\"bottom_background\";s:7:\"#fbfbfb\";s:12:\"bottom_image\";s:0:\"\";s:14:\"bottom_display\";s:7:\"contain\";s:12:\"footer_color\";s:7:\"#9ba1a7\";s:19:\"bottom_footer_color\";s:7:\"#a3aaaf\";}s:6:\"social\";a:12:{s:8:\"facebook\";s:1:\"#\";s:7:\"twitter\";s:1:\"#\";s:6:\"google\";s:1:\"#\";s:7:\"youtube\";s:1:\"#\";s:5:\"vimeo\";s:0:\"\";s:8:\"linkedin\";s:0:\"\";s:9:\"pinterest\";s:0:\"\";s:6:\"tumblr\";s:0:\"\";s:6:\"flickr\";s:0:\"\";s:9:\"instagram\";s:0:\"\";s:8:\"dribbble\";s:0:\"\";s:10:\"foursquare\";s:0:\"\";}s:13:\"custom_script\";a:3:{s:3:\"css\";s:0:\"\";s:4:\"head\";s:0:\"\";s:6:\"footer\";s:0:\"\";}}', 1, 1, 'PizzaJuan', '2.0'),
(36, 'payment', 'stripe', 'a:12:{s:5:\"title\";s:21:\"Stripe (Requires SSL)\";s:11:\"description\";s:31:\"Pay by Credit Card using Stripe\";s:16:\"transaction_mode\";s:4:\"test\";s:15:\"test_secret_key\";s:35:\"sk_test_DQYYoyOUiViAeBlFLLZRDNd9789\";s:20:\"test_publishable_key\";s:32:\"pk_test_xVVyfHyNOM12eAJ5xgBhsVwc\";s:15:\"live_secret_key\";s:32:\"sk_test_DQYYoyOUiViAeBlFLLZRDNd9\";s:20:\"live_publishable_key\";s:32:\"sk_test_DQYYoyOUiViAeBlFLLZRDNd9\";s:9:\"force_ssl\";s:1:\"0\";s:11:\"order_total\";s:1:\"1\";s:12:\"order_status\";s:1:\"2\";s:8:\"priority\";s:1:\"1\";s:6:\"status\";s:1:\"1\";}', 1, 1, 'Stripe (Requires SSL)', '1.0.0'),
(37, 'payment', 'authorize_net_aim', '', 0, 0, 'Authorize.Net (AIM)', '1.0.0');

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_faq`
--

CREATE TABLE `yvdnsddqu_faq` (
  `question_id` int(11) NOT NULL,
  `question_en` text CHARACTER SET utf8 NOT NULL,
  `question_ar` text CHARACTER SET utf8 NOT NULL,
  `answer_en` text CHARACTER SET utf8 NOT NULL,
  `answer_ar` text CHARACTER SET utf8 NOT NULL,
  `priority` tinyint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `yvdnsddqu_faq`
--

INSERT INTO `yvdnsddqu_faq` (`question_id`, `question_en`, `question_ar`, `answer_en`, `answer_ar`, `priority`) VALUES
(1, 'How can i book table?', '¿Como puedo reservar mesa?', 'Trabezah Book is a powerful tool that puts you in control of your table management and reservations. ... Allow your customers to book directly from different online channels such as your Trabezah page and your restaurant\'s website.', 'Trabezah Book es una herramienta poderosa que le permite controlar la gestión y las reservas de su mesa. ... Permita que sus clientes reserven directamente desde diferentes canales en línea, como su página Trabezah y el sitio web de su restaurante.', 1),
(2, 'How to redeem my reward point?', '¿Cómo canjear mi punto de recompensa?', 'You can book restaurants with your redeem points.', 'Puede reservar restaurantes con sus puntos de canje.', 2),
(3, 'Where i find restaurants?', '¿Dónde encuentro restaurantes?', 'People looking for information about local restaurants and other businesses say they rely on the internet, especially search engines.', 'Las personas que buscan información sobre restaurantes locales y otras empresas dicen que confían en Internet, especialmente en los motores de búsqueda.', 3);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_favorites`
--

CREATE TABLE `yvdnsddqu_favorites` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_feedback`
--

CREATE TABLE `yvdnsddqu_feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `feedback_type` varchar(150) NOT NULL,
  `feedback_message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_keys`
--

CREATE TABLE `yvdnsddqu_keys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(40) NOT NULL,
  `level` int(2) NOT NULL,
  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
  `is_private_key` tinyint(1) NOT NULL DEFAULT '0',
  `ip_addresses` text,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_keys`
--

INSERT INTO `yvdnsddqu_keys` (`id`, `user_id`, `key`, `level`, `ignore_limits`, `is_private_key`, `ip_addresses`, `date_created`) VALUES
(1, 0, 'RfTjWnZr4u7x!A-D', 0, 0, 0, NULL, '2017-10-12 13:34:33');

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_languages`
--

CREATE TABLE `yvdnsddqu_languages` (
  `language_id` int(11) NOT NULL,
  `code` varchar(7) NOT NULL,
  `name` varchar(32) NOT NULL,
  `image` varchar(32) NOT NULL,
  `idiom` varchar(32) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `can_delete` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_languages`
--

INSERT INTO `yvdnsddqu_languages` (`language_id`, `code`, `name`, `image`, `idiom`, `status`, `can_delete`) VALUES
(11, 'en', 'English', 'data/flags/gb.png', 'english', 1, 1),
(14, 'es', 'Spanish', 'data/flags/es.png', 'spanish', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_layouts`
--

CREATE TABLE `yvdnsddqu_layouts` (
  `layout_id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_layout_modules`
--

CREATE TABLE `yvdnsddqu_layout_modules` (
  `layout_module_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  `module_code` varchar(128) NOT NULL,
  `partial` varchar(32) NOT NULL,
  `priority` int(11) NOT NULL,
  `options` text NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_layout_modules`
--

INSERT INTO `yvdnsddqu_layout_modules` (`layout_module_id`, `layout_id`, `module_code`, `partial`, `priority`, `options`, `status`) VALUES
(60, 17, 'pages_module', 'content_right', 1, '', 1),
(67, 15, 'account_module', 'content_left', 1, '', 1),
(68, 12, 'local_module', 'content_top', 1, '', 1),
(69, 12, 'categories_module', 'content_left', 1, '', 1),
(70, 12, 'cart_module', 'content_right', 1, '', 1),
(71, 13, 'local_module', 'content_top', 1, '', 1),
(72, 13, 'cart_module', 'content_right', 1, '', 1),
(73, 16, 'reservation_module', 'content_top', 1, '', 1),
(74, 18, 'local_module', 'content_top', 1, '', 1),
(75, 18, 'categories_module', 'content_left', 1, '', 1),
(76, 18, 'cart_module', 'content_right', 1, '', 1),
(82, 20, 'account_module', 'content_left', 1, 'a:4:{s:5:\"title\";s:0:\"\";s:5:\"fixed\";s:1:\"0\";s:16:\"fixed_top_offset\";s:0:\"\";s:19:\"fixed_bottom_offset\";s:0:\"\";}', 1),
(89, 11, 'slideshow', 'content_top', 1, 'a:4:{s:5:\"title\";s:0:\"\";s:5:\"fixed\";s:1:\"1\";s:16:\"fixed_top_offset\";s:4:\"1920\";s:19:\"fixed_bottom_offset\";s:3:\"700\";}', 1),
(90, 11, 'local_module', 'content_top', 2, 'a:4:{s:5:\"title\";s:0:\"\";s:5:\"fixed\";s:1:\"0\";s:16:\"fixed_top_offset\";s:0:\"\";s:19:\"fixed_bottom_offset\";s:0:\"\";}', 1),
(91, 11, 'banners_module', 'content_bottom', 1, 'a:4:{s:5:\"title\";s:0:\"\";s:5:\"fixed\";s:1:\"1\";s:16:\"fixed_top_offset\";s:4:\"1920\";s:19:\"fixed_bottom_offset\";s:3:\"300\";}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_layout_routes`
--

CREATE TABLE `yvdnsddqu_layout_routes` (
  `layout_route_id` int(11) NOT NULL,
  `layout_id` int(11) NOT NULL,
  `uri_route` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_layout_routes`
--

INSERT INTO `yvdnsddqu_layout_routes` (`layout_route_id`, `layout_id`, `uri_route`) VALUES
(19, 13, 'checkout'),
(41, 16, 'reservation'),
(44, 12, 'menus'),
(70, 18, 'local'),
(71, 19, 'locations'),
(72, 17, 'pages'),
(100, 15, 'account/account'),
(101, 15, 'account/details'),
(102, 15, 'account/address'),
(103, 15, 'account/orders'),
(104, 15, 'account/reservations'),
(105, 15, 'account/inbox'),
(106, 15, 'account/reviews'),
(110, 20, 'account/cancel_policy'),
(113, 11, 'home');

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_locations`
--

CREATE TABLE `yvdnsddqu_locations` (
  `location_id` int(11) NOT NULL,
  `location_name` varchar(32) NOT NULL,
  `location_name_ar` varchar(100) NOT NULL,
  `location_email` varchar(96) NOT NULL,
  `description` text NOT NULL,
  `description_ar` text NOT NULL,
  `location_address_1` varchar(128) NOT NULL,
  `location_address_1_ar` varchar(1000) NOT NULL,
  `location_address_2` varchar(128) NOT NULL,
  `location_address_2_ar` varchar(1000) NOT NULL,
  `location_city` varchar(128) NOT NULL,
  `location_city_ar` varchar(100) NOT NULL,
  `location_state` varchar(128) NOT NULL,
  `location_state_ar` varchar(100) NOT NULL,
  `location_postcode` varchar(10) NOT NULL,
  `location_country_id` int(11) NOT NULL,
  `location_telephone` varchar(32) NOT NULL,
  `location_lat` float(10,6) NOT NULL,
  `location_lng` float(10,6) NOT NULL,
  `location_radius` int(11) NOT NULL,
  `offer_delivery` tinyint(1) NOT NULL,
  `offer_collection` tinyint(1) NOT NULL,
  `delivery_time` int(11) NOT NULL,
  `delivery_boy_commission` int(10) NOT NULL,
  `last_order_time` int(11) NOT NULL,
  `reservation_time_interval` int(11) NOT NULL,
  `reservation_stay_time` int(11) NOT NULL,
  `location_status` tinyint(1) NOT NULL,
  `collection_time` int(11) NOT NULL,
  `options` text NOT NULL,
  `location_image` varchar(255) NOT NULL,
  `rewards_value` int(3) NOT NULL,
  `reward_status` int(3) NOT NULL DEFAULT '0',
  `rewards_enable` int(1) NOT NULL,
  `point_value` int(3) NOT NULL,
  `point_price` double NOT NULL DEFAULT '0',
  `minimum_price` double NOT NULL DEFAULT '0',
  `cancellation_period` varchar(100) NOT NULL,
  `cancellation_charge` varchar(100) NOT NULL,
  `cancellation_time` int(11) NOT NULL,
  `refund_status` int(3) NOT NULL DEFAULT '0',
  `open_close_status` int(11) NOT NULL,
  `first_table_price` varchar(100) NOT NULL,
  `additional_table_price` varchar(100) NOT NULL,
  `location_type` varchar(100) DEFAULT NULL,
  `veg_type` varchar(255) NOT NULL DEFAULT 'both',
  `location_ratings` double NOT NULL DEFAULT '0',
  `rewards_method` varchar(50) DEFAULT NULL,
  `maximum_amount` double DEFAULT NULL,
  `payment_details` text NOT NULL,
  `added_by` int(11) NOT NULL,
  `tax_type` varchar(526) DEFAULT NULL,
  `tax_perc` varchar(526) DEFAULT NULL,
  `tax_status` varchar(526) DEFAULT NULL,
  `delivery_fee` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_locations`
--

INSERT INTO `yvdnsddqu_locations` (`location_id`, `location_name`, `location_name_ar`, `location_email`, `description`, `description_ar`, `location_address_1`, `location_address_1_ar`, `location_address_2`, `location_address_2_ar`, `location_city`, `location_city_ar`, `location_state`, `location_state_ar`, `location_postcode`, `location_country_id`, `location_telephone`, `location_lat`, `location_lng`, `location_radius`, `offer_delivery`, `offer_collection`, `delivery_time`, `delivery_boy_commission`, `last_order_time`, `reservation_time_interval`, `reservation_stay_time`, `location_status`, `collection_time`, `options`, `location_image`, `rewards_value`, `reward_status`, `rewards_enable`, `point_value`, `point_price`, `minimum_price`, `cancellation_period`, `cancellation_charge`, `cancellation_time`, `refund_status`, `open_close_status`, `first_table_price`, `additional_table_price`, `location_type`, `veg_type`, `location_ratings`, `rewards_method`, `maximum_amount`, `payment_details`, `added_by`, `tax_type`, `tax_perc`, `tax_status`, `delivery_fee`) VALUES
(1, 'Next In', '', 'nextin@yopmail.com', 'Data desc', '', 'Sydney Street', '', 'Sydney Street', '', 'Kempsey', '', 'NSW', '', '2440', 13, '+61-9991111222', -31.081041, 152.837479, 0, 1, 1, 10, 10, 10, 0, 0, 1, 0, 'a:5:{s:12:\"auto_lat_lng\";s:1:\"1\";s:13:\"opening_hours\";a:10:{s:12:\"opening_type\";s:4:\"24_7\";s:10:\"daily_days\";a:7:{i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";i:5;s:1:\"5\";i:6;s:1:\"6\";}s:11:\"daily_hours\";a:2:{s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";}s:14:\"flexible_hours\";a:7:{i:0;a:4:{s:3:\"day\";s:1:\"0\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:1;a:4:{s:3:\"day\";s:1:\"1\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:2;a:4:{s:3:\"day\";s:1:\"2\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:3;a:4:{s:3:\"day\";s:1:\"3\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:4;a:4:{s:3:\"day\";s:1:\"4\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:5;a:4:{s:3:\"day\";s:1:\"5\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:6;a:4:{s:3:\"day\";s:1:\"6\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}}s:13:\"delivery_type\";s:1:\"0\";s:13:\"delivery_days\";a:7:{i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";i:5;s:1:\"5\";i:6;s:1:\"6\";}s:14:\"delivery_hours\";a:2:{s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";}s:15:\"collection_type\";s:1:\"0\";s:15:\"collection_days\";a:7:{i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";i:5;s:1:\"5\";i:6;s:1:\"6\";}s:16:\"collection_hours\";a:2:{s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";}}s:13:\"future_orders\";s:1:\"0\";s:17:\"future_order_days\";a:2:{s:8:\"delivery\";s:1:\"5\";s:10:\"collection\";s:1:\"5\";}s:7:\"gallery\";a:3:{s:5:\"title\";s:8:\"Interior\";s:11:\"description\";s:16:\"Interior gallery\";s:6:\"images\";a:1:{i:1;a:4:{s:4:\"path\";s:16:\"data/Bursa-1.jpg\";s:4:\"name\";s:11:\"Bursa-1.jpg\";s:8:\"alt_text\";s:12:\"Interior one\";s:6:\"status\";s:1:\"0\";}}}}', 'data/Sultan-1.jpg', 0, 0, 2, 0, 0, 0, '', '0', 0, 1, 1, '', '', 'both', 'veg', 0, 'full', 0, '', 12, '[\"GCST\"]', '[\" 5\"]', '[\"1\"]', 10),
(3, 'Level Up', '', 'levelup@yopmail.com', 'Level up desc', '', '215 Spring Street', '', '', '', 'Melbourne', '', 'VIC', '', '3004', 13, '+91-876543210', -37.809822, 144.971939, 0, 1, 1, 10, 10, 10, 10, 10, 1, 0, 'a:5:{s:12:\"auto_lat_lng\";s:1:\"0\";s:13:\"opening_hours\";a:10:{s:12:\"opening_type\";s:4:\"24_7\";s:10:\"daily_days\";a:7:{i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";i:5;s:1:\"5\";i:6;s:1:\"6\";}s:11:\"daily_hours\";a:2:{s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";}s:14:\"flexible_hours\";a:7:{i:0;a:4:{s:3:\"day\";s:1:\"0\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:1;a:4:{s:3:\"day\";s:1:\"1\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:2;a:4:{s:3:\"day\";s:1:\"2\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:3;a:4:{s:3:\"day\";s:1:\"3\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:4;a:4:{s:3:\"day\";s:1:\"4\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:5;a:4:{s:3:\"day\";s:1:\"5\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}i:6;a:4:{s:3:\"day\";s:1:\"6\";s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";s:6:\"status\";s:1:\"1\";}}s:13:\"delivery_type\";s:1:\"0\";s:13:\"delivery_days\";a:7:{i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";i:5;s:1:\"5\";i:6;s:1:\"6\";}s:14:\"delivery_hours\";a:2:{s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";}s:15:\"collection_type\";s:1:\"0\";s:15:\"collection_days\";a:7:{i:0;s:1:\"0\";i:1;s:1:\"1\";i:2;s:1:\"2\";i:3;s:1:\"3\";i:4;s:1:\"4\";i:5;s:1:\"5\";i:6;s:1:\"6\";}s:16:\"collection_hours\";a:2:{s:4:\"open\";s:8:\"12:00 AM\";s:5:\"close\";s:8:\"11:59 PM\";}}s:13:\"future_orders\";s:1:\"0\";s:17:\"future_order_days\";a:2:{s:8:\"delivery\";s:1:\"5\";s:10:\"collection\";s:1:\"5\";}s:7:\"gallery\";a:2:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";}}', 'data/Belajio-1.jpg', 0, 0, 2, 0, 0, 0, '', '0', 0, 0, 1, '', '', 'restaurant', 'veg', 0, 'full', 0, '', 13, '', '', '', 10);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_location_tables`
--

CREATE TABLE `yvdnsddqu_location_tables` (
  `location_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_location_tables`
--

INSERT INTO `yvdnsddqu_location_tables` (`location_id`, `table_id`) VALUES
(1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_mail_templates`
--

CREATE TABLE `yvdnsddqu_mail_templates` (
  `template_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `language_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_mail_templates`
--

INSERT INTO `yvdnsddqu_mail_templates` (`template_id`, `name`, `language_id`, `date_added`, `date_updated`, `status`) VALUES
(11, 'Default', 1, '2014-04-16 01:49:52', '2020-01-20 11:54:15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_mail_templates_data`
--

CREATE TABLE `yvdnsddqu_mail_templates_data` (
  `template_data_id` int(11) NOT NULL,
  `template_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `subject` varchar(128) NOT NULL,
  `body` text NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `new_column_1` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_mail_templates_data`
--

INSERT INTO `yvdnsddqu_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`, `new_column_1`) VALUES
(11, 11, 'registration', 'Welcome to {site_name}', '<div id=\"mailsub\" class=\"notification\" align=\"center\"><table style=\"min-width: 320px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\" bgcolor=\"#eff3f8\"><!--[if gte mso 10]><table width=\"680\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td><![endif]--><table class=\"table_width_100\" style=\"max-width: 680px; min-width: 300px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr><!--header --><tr><td align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- Item --><div class=\"mob_center_bl\" style=\"float: left; display: inline-block; width: 115px;\"><table class=\"mob_center\" style=\"border-collapse: collapse;\" align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td align=\"left\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td class=\"mob_center\" align=\"left\" valign=\"top\"><a href=\"{site_url}\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;\"><font face=\"Arial, Helvetica, sans-seri; font-size: 13px;\" color=\"#596167\" size=\"3\"><img src=\"{site_logo}\" alt=\"{site_name}\" style=\"display: block;\" height=\"121\" border=\"0\" width=\"194\"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align=\"right\"><![endif]--><!-- Item --><div class=\"mob_center_bl\" style=\"float: right; display: inline-block; width: 88px;\"><table style=\"border-collapse: collapse;\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"88\"><tbody><tr><td align=\"right\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"right\"><!--social --><div class=\"mob_center_bl\" style=\"width: 88px;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td style=\"line-height: 19px;\" align=\"center\" width=\"30\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"center\" width=\"39\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"right\" width=\"29\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style=\"height: 50px; line-height: 50px; font-size: 10px;\"></div></td></tr><!--header END--><!--content 1 --><tr><td align=\"center\" bgcolor=\"#fbfcfd\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div><div style=\"line-height: 44px;\"><font style=\"font-size: 34px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"5\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;\">Welcome!</span></font></div><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Hello {first_name} {last_name},</span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Thank you for registrating with {site_name}.</span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Thank you for using.<br> {signature}</span></font></div><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class=\"iage_footer\" align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\"><font style=\"font-size: 13px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#96a5b5\" size=\"3\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;\">2019 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2014-04-16 00:56:00', '2020-01-20 11:54:15', NULL),
(12, 11, 'password_reset', 'Password reset at {site_name}', '<div id=\"mailsub\" class=\"notification\" align=\"center\"><table style=\"min-width: 320px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\" bgcolor=\"#eff3f8\"><!--[if gte mso 10]><table width=\"680\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td><![endif]--><table class=\"table_width_100\" style=\"max-width: 680px; min-width: 300px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr><!--header --><tr><td align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- Item --><div class=\"mob_center_bl\" style=\"float: left; display: inline-block; width: 115px;\"><table class=\"mob_center\" style=\"border-collapse: collapse;\" align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td align=\"left\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td class=\"mob_center\" align=\"left\" valign=\"top\"><a href=\"{site_url}\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;\"><font face=\"Arial, Helvetica, sans-seri; font-size: 13px;\" color=\"#596167\" size=\"3\"><img src=\"{site_logo}\" alt=\"{site_name}\" style=\"display: block;\" height=\"121\" border=\"0\" width=\"194\"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align=\"right\"><![endif]--><!-- Item --><div class=\"mob_center_bl\" style=\"float: right; display: inline-block; width: 88px;\"><table style=\"border-collapse: collapse;\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"88\"><tbody><tr><td align=\"right\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"right\"><!--social --><div class=\"mob_center_bl\" style=\"width: 88px;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td style=\"line-height: 19px;\" align=\"center\" width=\"30\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"center\" width=\"39\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"right\" width=\"29\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style=\"height: 50px; line-height: 50px; font-size: 10px;\"></div></td></tr><!--header END--><!--content 1 --><tr><td align=\"center\" bgcolor=\"#fbfcfd\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div><div style=\"line-height: 44px;\"><font style=\"font-size: 34px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"5\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;\">Reset your password!</span></font></div><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Hello {first_name} {last_name},</span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><span style=\"background-color: transparent; color: rgb(87, 105, 126); font-family: Arial, Helvetica, sans-serif; font-size: 15px;\">Your password has been successfully updated and your new password is&nbsp;</span><span style=\"color: rgb(87, 105, 126); font-family: Arial, Helvetica, sans-serif; font-size: 15px; background-color: transparent;\">{created_password}</span><br></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">{signature}</span></font></div><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class=\"iage_footer\" align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\"><font style=\"font-size: 13px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#96a5b5\" size=\"3\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;\">2019 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2014-04-16 00:56:00', '2020-01-20 11:54:15', NULL),
(13, 11, 'order', '{site_name} order confirmation - {order_number}', '<div id=\"mailsub\" class=\"notification\" align=\"center\"><table style=\"min-width: 320px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\" bgcolor=\"#eff3f8\"><!--[if gte mso 10]><table width=\"680\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td><![endif]--><table class=\"table_width_100\" style=\"max-width: 680px; min-width: 300px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr><!--header --><tr><td align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- Item --><div class=\"mob_center_bl\" style=\"float: left; display: inline-block; width: 115px;\"><table class=\"mob_center\" style=\"border-collapse: collapse;\" align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td align=\"left\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td class=\"mob_center\" align=\"left\" valign=\"top\"><a title=\"\" data-original-title=\"\" href=\"{site_url}\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;\"><font color=\"#596167\" size=\"3\" face=\"Arial, Helvetica, sans-seri; font-size: 13px;\"><img src=\"{site_logo}\" alt=\"{site_name}\" style=\"display: block;\" border=\"0\" height=\"121\" width=\"194\"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align=\"right\"><![endif]--><!-- Item --><div class=\"mob_center_bl\" style=\"float: right; display: inline-block; width: 88px;\"><table style=\"border-collapse: collapse;\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"88\"><tbody><tr><td align=\"right\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"right\"><!--social --><div class=\"mob_center_bl\" style=\"width: 88px;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td style=\"line-height: 19px;\" align=\"center\" width=\"30\"><a title=\"\" data-original-title=\"\" href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font color=\"#596167\" size=\"2\" face=\"Arial, Helvetica, sans-serif\"></font></a></td><td style=\"line-height: 19px;\" align=\"center\" width=\"39\"><a title=\"\" data-original-title=\"\" href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font color=\"#596167\" size=\"2\" face=\"Arial, Helvetica, sans-serif\"></font></a></td><td style=\"line-height: 19px;\" align=\"right\" width=\"29\"><a title=\"\" data-original-title=\"\" href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font color=\"#596167\" size=\"2\" face=\"Arial, Helvetica, sans-serif\"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style=\"height: 50px; line-height: 50px; font-size: 10px;\"></div></td></tr><!--header END--><!--content 1 --><tr><td align=\"center\" bgcolor=\"#fbfcfd\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div><div style=\"line-height: 44px;\"><font style=\"font-size: 34px;\" color=\"#57697e\" size=\"5\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;\">Thank you for your order!</span></font></div><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Hello {first_name} {last_name},</span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Your order has been received and will be with you shortly. <a title=\"\" data-original-title=\"\" href=\"{order_view_url}\">Click here</a> to view your order progress.</span></font><br></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Your order number is {order_number}<br> This is a {order_type} order.</span></font></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\"><br><strong>Order date:</strong> {order_date}<br><strong>Requested {order_type} time</strong> {order_time}<br><strong>Payment Method:</strong> {order_payment}</span></font></div><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td><div style=\"line-height: 24px;\"><font style=\"font-size: 13px;\" color=\"#57697e\" size=\"3\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;\">Name/Description</span></font></div></td><td><div style=\"line-height: 24px;\"><font style=\"font-size: 13px;\" color=\"#57697e\" size=\"3\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;\">Unit Price</span></font></div></td><td><div style=\"line-height: 24px;\"><font style=\"font-size: 13px;\" color=\"#57697e\" size=\"3\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;\">Sub Total</span></font></div></td></tr><tr><td>{order_menus}<br></td><td><br></td><td><br></td></tr><tr style=\"border-top:1px dashed #c3cbd5;\"><td><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;font-weight:bold;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">{menu_quantity} x {menu_name}</span></font></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#96a5b5\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #96a5b5;\">{menu_options}</span></font></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#96a5b5\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #96a5b5;\">{menu_comment}</span></font></div></td><td><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">{menu_price}</span></font></div></td><td><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">{menu_subtotal}</span></font></div></td></tr><tr><td>{/order_menus}</td><td><br></td><td><br></td></tr><tr><td><br></td><td>{order_totals}</td><td><br></td></tr><tr><td><br></td><td><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">{order_total_title}</span></font></div></td><td><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">{order_total_value}</span></font></div></td></tr><tr><td><br></td><td>{/order_totals}<br></td><td><br></td></tr></tbody></table><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">{order_comment}</span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">{order_address}</span></font></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\"><span title=\"\" data-original-title=\"\" style=\"font-weight: bold;\">Restaurant:</span> {location_name}</span></font></div><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">We hope to see you again soon.<br>{signature}</span></font></div><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class=\"iage_footer\" align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\"><font style=\"font-size: 13px;\" color=\"#96a5b5\" size=\"3\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;\">2019 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2014-04-16 00:56:00', '2020-01-20 11:54:15', NULL),
(14, 11, 'reservation', 'Your Reservation Confirmation - {reservation_number}', '<div id=\"mailsub\" class=\"notification\" align=\"center\"><table style=\"min-width: 320px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\" bgcolor=\"#eff3f8\"><!--[if gte mso 10]><table width=\"680\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td><![endif]--><table class=\"table_width_100\" style=\"max-width: 680px; min-width: 300px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr><!--header --><tr><td align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- Item --><div class=\"mob_center_bl\" style=\"float: left; display: inline-block; width: 115px;\"><table class=\"mob_center\" style=\"border-collapse: collapse;\" align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td align=\"left\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td class=\"mob_center\" align=\"left\" valign=\"top\"><a href=\"{site_url}\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;\"><font face=\"Arial, Helvetica, sans-seri; font-size: 13px;\" color=\"#596167\" size=\"3\"><img src=\"{site_logo}\" alt=\"{site_name}\" style=\"display: block;\" height=\"121\" border=\"0\" width=\"194\"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align=\"right\"><![endif]--><!-- Item --><div class=\"mob_center_bl\" style=\"float: right; display: inline-block; width: 88px;\"><table style=\"border-collapse: collapse;\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"88\"><tbody><tr><td align=\"right\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"right\"><!--social --><div class=\"mob_center_bl\" style=\"width: 88px;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td style=\"line-height: 19px;\" align=\"center\" width=\"30\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"center\" width=\"39\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"right\" width=\"29\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style=\"height: 50px; line-height: 50px; font-size: 10px;\"></div></td></tr><!--header END--><!--content 1 --><tr><td align=\"center\" bgcolor=\"#fbfcfd\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div><div style=\"line-height: 44px;\"><font style=\"font-size: 34px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"5\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;\">Thank you for your reservation!</span></font></div><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Hello {first_name} {last_name},</span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Your reservation {reservation_number} at {location_name} has been booked for {reservation_guest_no} person(s) on {reservation_date} at {reservation_time}.</span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Thanks for reserving with us online!</span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><b>Unique Code</b> : <span style=\"font-size: 18px;\">{otp}</span></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">We hope to see you again soon.<br>{signature}</span></font></div><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class=\"iage_footer\" align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\"><font style=\"font-size: 13px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#96a5b5\" size=\"3\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;\">2019 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2014-04-16 00:56:00', '2020-01-20 11:54:15', NULL),
(15, 11, 'contact', 'Contact on {site_name}', '<div id=\"mailsub\" class=\"notification\" align=\"center\"><table style=\"min-width: 320px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\" bgcolor=\"#eff3f8\"><!--[if gte mso 10]><table width=\"680\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td><![endif]--><table class=\"table_width_100\" style=\"max-width: 680px; min-width: 300px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr><!--header --><tr><td align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- Item --><div class=\"mob_center_bl\" style=\"float: left; display: inline-block; width: 115px;\"><table class=\"mob_center\" style=\"border-collapse: collapse;\" align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td align=\"left\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td class=\"mob_center\" align=\"left\" valign=\"top\"><a href=\"{site_url}\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;\"><font face=\"Arial, Helvetica, sans-seri; font-size: 13px;\" color=\"#596167\" size=\"3\"><img src=\"{site_logo}\" alt=\"{site_name}\" style=\"display: block;\" height=\"121\" border=\"0\" width=\"194\"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align=\"right\"><![endif]--><!-- Item --><div class=\"mob_center_bl\" style=\"float: right; display: inline-block; width: 88px;\"><table style=\"border-collapse: collapse;\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"88\"><tbody><tr><td align=\"right\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"right\"><!--social --><div class=\"mob_center_bl\" style=\"width: 88px;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td style=\"line-height: 19px;\" align=\"center\" width=\"30\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"center\" width=\"39\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"right\" width=\"29\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style=\"height: 50px; line-height: 50px; font-size: 10px;\"></div></td></tr><!--header END--><!--content 1 --><tr><td align=\"center\" bgcolor=\"#fbfcfd\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div><div style=\"line-height: 44px;\"><font style=\"font-size: 34px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"5\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;\">Someone just contacted you!</span></font></div><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Hello Admin,</span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"><br></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">From: {full_name}</span></font></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Topic: {contact_topic}.</span></font></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Telephone: {contact_telephone}.</span></font></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\"><br></span></font></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">{contact_message}</span></font></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\"><br></span></font></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">This inquiry was sent from {site_name}</span></font></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">{signature}<br></span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class=\"iage_footer\" align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\"><font style=\"font-size: 13px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#96a5b5\" size=\"3\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;\">2019 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2014-04-16 00:56:00', '2020-01-20 11:54:15', NULL),
(16, 11, 'internal', 'Subject here', 'Body here', '2014-04-16 00:56:00', '2020-01-20 11:54:15', NULL);
INSERT INTO `yvdnsddqu_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`, `new_column_1`) VALUES
(17, 11, 'order_alert', 'New order on {site_name}', '<div id=\"mailsub\" class=\"notification\" align=\"center\"><table style=\"min-width: 320px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\" bgcolor=\"#eff3f8\"><!--[if gte mso 10]><table width=\"680\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td><![endif]--><table class=\"table_width_100\" style=\"max-width: 680px; min-width: 300px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr><!--header --><tr><td align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- Item --><div class=\"mob_center_bl\" style=\"float: left; display: inline-block; width: 115px;\"><table class=\"mob_center\" style=\"border-collapse: collapse;\" align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td align=\"left\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td class=\"mob_center\" align=\"left\" valign=\"top\"><a title=\"\" data-original-title=\"\" href=\"{site_url}\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;\"><font color=\"#596167\" size=\"3\" face=\"Arial, Helvetica, sans-seri; font-size: 13px;\"><img src=\"{site_logo}\" alt=\"{site_name}\" style=\"display: block;\" border=\"0\" height=\"121\" width=\"194\"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align=\"right\"><![endif]--><!-- Item --><div class=\"mob_center_bl\" style=\"float: right; display: inline-block; width: 88px;\"><table style=\"border-collapse: collapse;\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"88\"><tbody><tr><td align=\"right\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"right\"><!--social --><div class=\"mob_center_bl\" style=\"width: 88px;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td style=\"line-height: 19px;\" align=\"center\" width=\"30\"><a title=\"\" data-original-title=\"\" href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font color=\"#596167\" size=\"2\" face=\"Arial, Helvetica, sans-serif\"></font></a></td><td style=\"line-height: 19px;\" align=\"center\" width=\"39\"><a title=\"\" data-original-title=\"\" href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font color=\"#596167\" size=\"2\" face=\"Arial, Helvetica, sans-serif\"></font></a></td><td style=\"line-height: 19px;\" align=\"right\" width=\"29\"><a title=\"\" data-original-title=\"\" href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font color=\"#596167\" size=\"2\" face=\"Arial, Helvetica, sans-serif\"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style=\"height: 50px; line-height: 50px; font-size: 10px;\"></div></td></tr><!--header END--><!--content 1 --><tr><td align=\"center\" bgcolor=\"#fbfcfd\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div><div style=\"line-height: 44px;\"><font style=\"font-size: 34px;\" color=\"#57697e\" size=\"5\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;\">You received an order!</span></font></div><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">You just received an order from {location_name}.</span></font><br></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">The order number is {order_number}<br> This is a {order_type} order.</span></font></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\"><br><strong>Customer name:</strong> {first_name} {last_name}<br><strong>Order date:</strong> {order_date}<br><strong>Requested {order_type} time</strong> {order_time}<br><strong>Payment Method:</strong> {order_payment}<br><br></span></font></div><!-- padding --><div style=\"height: 10px; line-height: 10px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\"></span></font></div><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td><div style=\"line-height: 24px;\"><font style=\"font-size: 13px;\" color=\"#57697e\" size=\"3\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;\">Name/Description</span></font></div></td><td><div style=\"line-height: 24px;\"><font style=\"font-size: 13px;\" color=\"#57697e\" size=\"3\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;\">Unit Price</span></font></div></td><td><div style=\"line-height: 24px;\"><font style=\"font-size: 13px;\" color=\"#57697e\" size=\"3\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;\">Sub Total</span></font></div></td></tr><tr><td>{order_menus}<br></td><td><br></td><td><br></td></tr><tr style=\"border-top:1px dashed #c3cbd5;\"><td><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;font-weight:bold;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">{menu_quantity} x {menu_name}</span></font></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#96a5b5\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #96a5b5;\">{menu_options}</span></font></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#96a5b5\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #96a5b5;\">{menu_comment}</span></font></div></td><td><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">{menu_price}</span></font></div></td><td><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">{menu_subtotal}</span></font></div></td></tr><tr><td>{/order_menus}</td><td><br></td><td><br></td></tr><tr><td><br></td><td>{order_totals}</td><td><br></td></tr><tr><td><br></td><td><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">{order_total_title}</span></font></div></td><td><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">{order_total_value}</span></font></div></td></tr><tr><td><br></td><td>{/order_totals}<br></td><td><br></td></tr></tbody></table><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" color=\"#57697e\" size=\"4\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">{order_comment}</span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class=\"iage_footer\" align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\"><font style=\"font-size: 13px;\" color=\"#96a5b5\" size=\"3\" face=\"Arial, Helvetica, sans-serif\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;\">2019 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2014-04-16 00:56:00', '2020-01-20 11:54:15', NULL),
(18, 11, 'reservation_alert', 'New reservation on {site_name}', '<div id=\"mailsub\" class=\"notification\" align=\"center\"><table style=\"min-width: 320px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\" bgcolor=\"#eff3f8\"><!--[if gte mso 10]><table width=\"680\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td><![endif]--><table class=\"table_width_100\" style=\"max-width: 680px; min-width: 300px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr><!--header --><tr><td align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- Item --><div class=\"mob_center_bl\" style=\"float: left; display: inline-block; width: 115px;\"><table class=\"mob_center\" style=\"border-collapse: collapse;\" align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td align=\"left\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td class=\"mob_center\" align=\"left\" valign=\"top\"><a href=\"{site_url}\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;\"><font face=\"Arial, Helvetica, sans-seri; font-size: 13px;\" color=\"#596167\" size=\"3\"><img src=\"{site_logo}\" alt=\"{site_name}\" style=\"display: block;\" height=\"121\" border=\"0\" width=\"194\"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align=\"right\"><![endif]--><!-- Item --><div class=\"mob_center_bl\" style=\"float: right; display: inline-block; width: 88px;\"><table style=\"border-collapse: collapse;\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"88\"><tbody><tr><td align=\"right\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"right\"><!--social --><div class=\"mob_center_bl\" style=\"width: 88px;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td style=\"line-height: 19px;\" align=\"center\" width=\"30\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"center\" width=\"39\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"right\" width=\"29\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style=\"height: 50px; line-height: 50px; font-size: 10px;\"></div></td></tr><!--header END--><!--content 1 --><tr><td align=\"center\" bgcolor=\"#fbfcfd\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div><div style=\"line-height: 44px;\"><font style=\"font-size: 34px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"5\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;\">You received a table reservation!</span></font></div><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\"><span style=\"font-weight: bold;\">Customer name:</span> {first_name} {last_name}</span></font></div><!-- padding --></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\"><span style=\"font-weight: bold;\">Reservation no:</span> {reservation_number} </span></font></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\"><span style=\"font-weight: bold;\">Restaurant:</span> {location_name} </span></font></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\"><span style=\"font-weight: bold;\">No of guest(s):</span> {reservation_guest_no} person(s) </span></font></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\"><span style=\"font-weight: bold;\">Reservation date:</span> {reservation_date}</span></font></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\"><span style=\"font-weight: bold;\">Reservation time: </span></span></font>{reservation_time}</span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">You received a table reservation from {site_name}<br></span></font></div><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class=\"iage_footer\" align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\"><font style=\"font-size: 13px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#96a5b5\" size=\"3\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;\">2019 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2014-04-16 00:56:00', '2020-01-20 11:54:15', NULL),
(19, 11, 'registration_alert', 'New Customer on {site_name}', '<div id=\"mailsub\" class=\"notification\" align=\"center\"><table style=\"min-width: 320px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\" bgcolor=\"#eff3f8\"><!--[if gte mso 10]><table width=\"680\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td><![endif]--><table class=\"table_width_100\" style=\"max-width: 680px; min-width: 300px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr><!--header --><tr><td align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- Item --><div class=\"mob_center_bl\" style=\"float: left; display: inline-block; width: 115px;\"><table class=\"mob_center\" style=\"border-collapse: collapse;\" align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td align=\"left\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td class=\"mob_center\" align=\"left\" valign=\"top\"><a href=\"{site_url}\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;\"><font face=\"Arial, Helvetica, sans-seri; font-size: 13px;\" color=\"#596167\" size=\"3\"><img src=\"{site_logo}\" alt=\"{site_name}\" style=\"display: block;\" height=\"121\" border=\"0\" width=\"194\"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align=\"right\"><![endif]--><!-- Item --><div class=\"mob_center_bl\" style=\"float: right; display: inline-block; width: 88px;\"><table style=\"border-collapse: collapse;\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"88\"><tbody><tr><td align=\"right\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"right\"><!--social --><div class=\"mob_center_bl\" style=\"width: 88px;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td style=\"line-height: 19px;\" align=\"center\" width=\"30\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"center\" width=\"39\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"right\" width=\"29\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style=\"height: 50px; line-height: 50px; font-size: 10px;\"></div></td></tr><!--header END--><!--content 1 --><tr><td align=\"center\" bgcolor=\"#fbfcfd\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div><div style=\"line-height: 44px;\"><font style=\"font-size: 34px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"5\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;\">You have a new customer!</span></font></div><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\"><span style=\"font-weight: bold;\">Customer name:</span> {first_name} {last_name}</span></font></div><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class=\"iage_footer\" align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\"><font style=\"font-size: 13px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#96a5b5\" size=\"3\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;\">2019 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2018-08-30 00:00:00', '2020-01-20 11:54:15', NULL),
(20, 11, 'password_reset_alert', 'Password reset at {site_name}', '<div id=\"mailsub\" class=\"notification\" align=\"center\"><table style=\"min-width: 320px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\" bgcolor=\"#eff3f8\"><!--[if gte mso 10]><table width=\"680\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td><![endif]--><table class=\"table_width_100\" style=\"max-width: 680px; min-width: 300px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr><!--header --><tr><td align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- Item --><div class=\"mob_center_bl\" style=\"float: left; display: inline-block; width: 115px;\"><table class=\"mob_center\" style=\"border-collapse: collapse;\" align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td align=\"left\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td class=\"mob_center\" align=\"left\" valign=\"top\"><a href=\"{site_url}\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;\"><font face=\"Arial, Helvetica, sans-seri; font-size: 13px;\" color=\"#596167\" size=\"3\"><img src=\"{site_logo}\" alt=\"{site_name}\" style=\"display: block;\" height=\"121\" border=\"0\" width=\"194\"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align=\"right\"><![endif]--><!-- Item --><div class=\"mob_center_bl\" style=\"float: right; display: inline-block; width: 88px;\"><table style=\"border-collapse: collapse;\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"88\"><tbody><tr><td align=\"right\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"right\"><!--social --><div class=\"mob_center_bl\" style=\"width: 88px;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td style=\"line-height: 19px;\" align=\"center\" width=\"30\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"center\" width=\"39\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"right\" width=\"29\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style=\"height: 50px; line-height: 50px; font-size: 10px;\"></div></td></tr><!--header END--><!--content 1 --><tr><td align=\"center\" bgcolor=\"#fbfcfd\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div><div style=\"line-height: 44px;\"><font style=\"font-size: 34px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"5\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;\">Reset your password!</span></font></div><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Hello {staff_name},</span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">You requested that the password be reset for the following account:</span></font></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Username: {staff_username}</span></font></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Password: {created_password}</span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Please do not forget to change your password after you login.<br> {signature}</span></font></div><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class=\"iage_footer\" align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\"><font style=\"font-size: 13px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#96a5b5\" size=\"3\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;\">2019 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2018-08-30 00:00:00', '2020-01-20 11:54:15', NULL),
(21, 11, 'order_update', 'Your Order Update - {order_number}', '<div id=\"mailsub\" class=\"notification\" align=\"center\"><table style=\"min-width: 320px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\" bgcolor=\"#eff3f8\"><!--[if gte mso 10]><table width=\"680\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td><![endif]--><table class=\"table_width_100\" style=\"max-width: 680px; min-width: 300px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr><!--header --><tr><td align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- Item --><div class=\"mob_center_bl\" style=\"float: left; display: inline-block; width: 115px;\"><table class=\"mob_center\" style=\"border-collapse: collapse;\" align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td align=\"left\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td class=\"mob_center\" align=\"left\" valign=\"top\"><a title=\"\" data-original-title=\"\" href=\"{site_url}\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;\"><font face=\"Arial, Helvetica, sans-seri; font-size: 13px;\" color=\"#596167\" size=\"3\"><img src=\"{site_logo}\" alt=\"{site_name}\" style=\"display: block;\" height=\"121\" border=\"0\" width=\"194\"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align=\"right\"><![endif]--><!-- Item --><div class=\"mob_center_bl\" style=\"float: right; display: inline-block; width: 88px;\"><table style=\"border-collapse: collapse;\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"88\"><tbody><tr><td align=\"right\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"right\"><!--social --><div class=\"mob_center_bl\" style=\"width: 88px;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td style=\"line-height: 19px;\" align=\"center\" width=\"30\"><a title=\"\" data-original-title=\"\" href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"center\" width=\"39\"><a title=\"\" data-original-title=\"\" href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"right\" width=\"29\"><a title=\"\" data-original-title=\"\" href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style=\"height: 50px; line-height: 50px; font-size: 10px;\"></div></td></tr><!--header END--><!--content 1 --><tr><td align=\"center\" bgcolor=\"#fbfcfd\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Your order has been updated to the following status: <span title=\"\" data-original-title=\"\" style=\"font-weight: bold;\">{status_name}</span></span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\"><a title=\"\" data-original-title=\"\" href=\"{order_view_url}\">Click here</a> to view your order progress.</span></font><br></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Your order number is: <span title=\"\" data-original-title=\"\" style=\"font-weight: bold;\">{order_number}</span></span></font></div><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><span title=\"\" data-original-title=\"\" style=\"font-weight: bold;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">The comments for your order are:</span></font></span></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">{status_comment}</span></font></div><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">We hope to see you again soon.<br>{signature}</span></font></div><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class=\"iage_footer\" align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\"><font style=\"font-size: 13px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#96a5b5\" size=\"3\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;\">2019 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2018-08-30 00:00:00', '2020-01-20 11:54:15', NULL),
(22, 11, 'reservation_update', 'Your Reservation Update - {reservation_number}', '<div id=\"mailsub\" class=\"notification\" align=\"center\"><table style=\"min-width: 320px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\" bgcolor=\"#eff3f8\"><!--[if gte mso 10]><table width=\"680\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td><![endif]--><table class=\"table_width_100\" style=\"max-width: 680px; min-width: 300px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr><!--header --><tr><td align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- Item --><div class=\"mob_center_bl\" style=\"float: left; display: inline-block; width: 115px;\"><table class=\"mob_center\" style=\"border-collapse: collapse;\" align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td align=\"left\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td class=\"mob_center\" align=\"left\" valign=\"top\"><a title=\"\" data-original-title=\"\" href=\"{site_url}\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;\"><font face=\"Arial, Helvetica, sans-seri; font-size: 13px;\" color=\"#596167\" size=\"3\"><img src=\"{site_logo}\" alt=\"{site_name}\" style=\"display: block;\" height=\"121\" border=\"0\" width=\"194\"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align=\"right\"><![endif]--><!-- Item --><div class=\"mob_center_bl\" style=\"float: right; display: inline-block; width: 88px;\"><table style=\"border-collapse: collapse;\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"88\"><tbody><tr><td align=\"right\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"right\"><!--social --><div class=\"mob_center_bl\" style=\"width: 88px;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td style=\"line-height: 19px;\" align=\"center\" width=\"30\"><a title=\"\" data-original-title=\"\" href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"center\" width=\"39\"><a title=\"\" data-original-title=\"\" href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"right\" width=\"29\"><a title=\"\" data-original-title=\"\" href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style=\"height: 50px; line-height: 50px; font-size: 10px;\"></div></td></tr><!--header END--><!--content 1 --><tr><td align=\"center\" bgcolor=\"#fbfcfd\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Your reservation has been updated to the following status: <span title=\"\" data-original-title=\"\" style=\"font-weight: bold;\">{status_name}</span></span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Your reservation number: <span title=\"\" data-original-title=\"\" style=\"font-weight: bold;\">{reservation_number}</span> at <span title=\"\" data-original-title=\"\" style=\"font-weight: bold;\">{location_name}</span>.</span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><span title=\"\" data-original-title=\"\" style=\"font-weight: bold;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">The comments for your reservation are:</span></font></span></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">{status_comment}<br></span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">We hope to see you again soon.<br>{signature}</span></font></div><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class=\"iage_footer\" align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\"><font style=\"font-size: 13px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#96a5b5\" size=\"3\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;\">2015 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2018-08-30 00:00:00', '2020-01-20 11:54:15', NULL);
INSERT INTO `yvdnsddqu_mail_templates_data` (`template_data_id`, `template_id`, `code`, `subject`, `body`, `date_added`, `date_updated`, `new_column_1`) VALUES
(23, 11, 'refund', 'Your Reservation number - {reservation_number}', '<div id=\"mailsub\" class=\"notification\" align=\"center\"><table style=\"min-width: 320px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\" bgcolor=\"#eff3f8\"><!--[if gte mso 10]><table width=\"680\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td><![endif]--><table class=\"table_width_100\" style=\"max-width: 680px; min-width: 300px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr><!--header --><tr><td align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- Item --><div class=\"mob_center_bl\" style=\"float: left; display: inline-block; width: 115px;\"><table class=\"mob_center\" style=\"border-collapse: collapse;\" align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td align=\"left\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td class=\"mob_center\" align=\"left\" valign=\"top\"><a title=\"\" data-original-title=\"\" href=\"{site_url}\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;\"><font face=\"Arial, Helvetica, sans-seri; font-size: 13px;\" color=\"#596167\" size=\"3\"><center><img src=\"{site_logo}\" alt=\"{site_name}\" style=\"display: block;\" height=\"80\" border=\"0\" width=\"150\"></center></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align=\"right\"><![endif]--><!-- Item --><div class=\"mob_center_bl\" style=\"float: right; display: inline-block; width: 88px;\"><table style=\"border-collapse: collapse;\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"88\"><tbody><tr><td align=\"right\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"right\"><!--social --><div class=\"mob_center_bl\" style=\"width: 88px;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td style=\"line-height: 19px;\" align=\"center\" width=\"30\"><a title=\"\" data-original-title=\"\" href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"center\" width=\"39\"><a title=\"\" data-original-title=\"\" href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"right\" width=\"29\"><a title=\"\" data-original-title=\"\" href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style=\"height: 50px; line-height: 50px; font-size: 10px;\"></div></td></tr><!--header END--><!--content 1 --><tr><td align=\"center\" bgcolor=\"#fbfcfd\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Your Reservation ID: <span title=\"\" data-original-title=\"\" style=\"font-weight: bold;\">{reservation_number}</span></span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Refund Amount: <span title=\"\" data-original-title=\"\" style=\"font-weight: bold;\">{refund_amount}</span> at <span title=\"\" data-original-title=\"\" style=\"font-weight: bold;\">{date}</span>.</span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><span title=\"\" data-original-title=\"\" style=\"font-weight: bold;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Your refund process is initiated</span></font></span></div><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\"><br></span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Thanking You :)<br></span></font></div><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class=\"iage_footer\" align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\"><font style=\"font-size: 13px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#96a5b5\" size=\"3\"><span title=\"\" data-original-title=\"\" style=\"font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;\">2015 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2018-09-05 00:00:00', '2018-09-05 00:00:00', NULL),
(24, 11, 'guest_reservation', 'Your Reservation Confirmation - {reservation_number}', '<div id=\"mailsub\" class=\"notification\" align=\"center\"><table style=\"min-width: 320px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\" bgcolor=\"#eff3f8\"><!--[if gte mso 10]><table width=\"680\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td><![endif]--><table class=\"table_width_100\" style=\"max-width: 680px; min-width: 300px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr><!--header --><tr><td align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- Item --><div class=\"mob_center_bl\" style=\"float: left; display: inline-block; width: 115px;\"><table class=\"mob_center\" style=\"border-collapse: collapse;\" align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td align=\"left\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td class=\"mob_center\" align=\"left\" valign=\"top\"><a href=\"{site_url}\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;\"><font face=\"Arial, Helvetica, sans-seri; font-size: 13px;\" color=\"#596167\" size=\"3\"><img src=\"{site_logo}\" alt=\"{site_name}\" style=\"display: block;\" height=\"121\" border=\"0\" width=\"194\"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align=\"right\"><![endif]--><!-- Item --><div class=\"mob_center_bl\" style=\"float: right; display: inline-block; width: 88px;\"><table style=\"border-collapse: collapse;\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"88\"><tbody><tr><td align=\"right\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"right\"><!--social --><div class=\"mob_center_bl\" style=\"width: 88px;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td style=\"line-height: 19px;\" align=\"center\" width=\"30\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"center\" width=\"39\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"right\" width=\"29\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style=\"height: 50px; line-height: 50px; font-size: 10px;\"></div></td></tr><!--header END--><!--content 1 --><tr><td align=\"center\" bgcolor=\"#fbfcfd\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div><div style=\"line-height: 44px;\"><font style=\"font-size: 34px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"5\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;\">Thank you for your reservation!</span></font></div><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Hello {first_name} {last_name},</span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Your reservation {reservation_number} at {location_name} has been booked for {reservation_guest_no} person(s) on {reservation_date} at {reservation_time}.</span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Thanks for reserving with us online!</span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><b>Unique Code</b> : <span style=\"font-size: 18px;\">{otp}</span></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">{guest_text}<a href=\"{guest_link}\" target=\"_blank\" class=\"btn btn-default\" style=\"color: #fff !important;color: #fff!important;background-color: #b48d50;text-decoration: none;padding: 10px;margin: 10px;border-radius: 5px;\">Click Here</a><br></span></font></div><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">We hope to see you again soon.<br>{signature}</span></font></div><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class=\"iage_footer\" align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\"><font style=\"font-size: 13px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#96a5b5\" size=\"3\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;\">2019 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2018-09-05 00:00:00', '2020-01-20 11:54:15', NULL),
(25, 11, 'password_reset_app', 'Password reset at {site_name}', '<div id=\"mailsub\" class=\"notification\" align=\"center\"><table style=\"min-width: 320px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\" bgcolor=\"#eff3f8\"><!--[if gte mso 10]><table width=\"680\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr><td><![endif]--><table class=\"table_width_100\" style=\"max-width: 680px; min-width: 300px;\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr><!--header --><tr><td align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- Item --><div class=\"mob_center_bl\" style=\"float: left; display: inline-block; width: 115px;\"><table class=\"mob_center\" style=\"border-collapse: collapse;\" align=\"left\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td align=\"left\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"115\"><tbody><tr><td class=\"mob_center\" align=\"left\" valign=\"top\"><a href=\"{site_url}\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;\"><font face=\"Arial, Helvetica, sans-seri; font-size: 13px;\" color=\"#596167\" size=\"3\"><img src=\"{site_logo}\" alt=\"{site_name}\" style=\"display: block;\" height=\"121\" border=\"0\" width=\"194\"></font></a></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--><!--[if gte mso 10]></td><td align=\"right\"><![endif]--><!-- Item --><div class=\"mob_center_bl\" style=\"float: right; display: inline-block; width: 88px;\"><table style=\"border-collapse: collapse;\" align=\"right\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"88\"><tbody><tr><td align=\"right\" valign=\"middle\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"right\"><!--social --><div class=\"mob_center_bl\" style=\"width: 88px;\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody><tr><td style=\"line-height: 19px;\" align=\"center\" width=\"30\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"center\" width=\"39\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td><td style=\"line-height: 19px;\" align=\"right\" width=\"29\"><a href=\"#\" target=\"_blank\" style=\"color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\"><font face=\"Arial, Helvetica, sans-serif\" color=\"#596167\" size=\"2\"></font></a></td></tr></tbody></table></div><!--social END--></td></tr></tbody></table></td></tr></tbody></table></div><!-- Item END--></td></tr></tbody></table><!-- padding --><div style=\"height: 50px; line-height: 50px; font-size: 10px;\"></div></td></tr><!--header END--><!--content 1 --><tr><td align=\"center\" bgcolor=\"#fbfcfd\"><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"90%\"><tbody><tr><td align=\"left\"><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div><div style=\"line-height: 44px;\"><font style=\"font-size: 34px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"5\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 34px; color: #57697e;\">Reset your password!</span></font></div><!-- padding --><div style=\"height: 30px; line-height: 30px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">Hello {first_name} {last_name},</span></font></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><span style=\"background-color: transparent; color: rgb(87, 105, 126); font-family: Arial, Helvetica, sans-serif; font-size: 15px;\">Your OTP for changing new password is &nbsp;</span><span style=\"color: rgb(87, 105, 126); font-family: Arial, Helvetica, sans-serif; font-size: 15px; background-color: transparent;\">{created_password}</span><br></div><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><tr><td align=\"left\"><div style=\"line-height: 24px;\"><font style=\"font-size: 15px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#57697e\" size=\"4\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;\">{signature}</span></font></div><!-- padding --><div style=\"height: 40px; line-height: 40px; font-size: 10px;\"></div></td></tr></tbody></table></td></tr><!--content 1 END--><!--footer --><tr><td class=\"iage_footer\" align=\"center\" bgcolor=\"#ffffff\"><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div><table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tbody><tr><td align=\"center\"><font style=\"font-size: 13px;\" face=\"Arial, Helvetica, sans-serif\" color=\"#96a5b5\" size=\"3\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #96a5b5;\">2019 © {site_name} All Rights Reserved.</span></font></td></tr></tbody></table><!-- padding --><div style=\"height: 20px; line-height: 20px; font-size: 10px;\"></div></td></tr><!--footer END--><tr><td><!-- padding --><div style=\"height: 80px; line-height: 80px; font-size: 10px;\"></div></td></tr></tbody></table><!--[if gte mso 10]></td></tr></table><![endif]--></td></tr></tbody></table></div>', '2014-04-16 00:56:00', '2020-01-20 11:54:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_mealtimes`
--

CREATE TABLE `yvdnsddqu_mealtimes` (
  `mealtime_id` int(11) NOT NULL,
  `mealtime_name` varchar(128) NOT NULL,
  `start_time` time NOT NULL DEFAULT '00:00:00',
  `end_time` time NOT NULL DEFAULT '23:59:59',
  `mealtime_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_mealtimes`
--

INSERT INTO `yvdnsddqu_mealtimes` (`mealtime_id`, `mealtime_name`, `start_time`, `end_time`, `mealtime_status`) VALUES
(11, 'Breakfast', '06:00:00', '11:00:00', 1),
(12, 'Lunch', '12:00:00', '17:30:00', 1),
(13, 'Dinner', '18:00:00', '23:00:00', 1),
(14, 'test', '09:00:00', '22:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_menus`
--

CREATE TABLE `yvdnsddqu_menus` (
  `menu_id` int(11) NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `menu_name_ar` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu_description` text NOT NULL,
  `menu_description_ar` text,
  `menu_price` int(11) NOT NULL,
  `menu_type` varchar(255) NOT NULL,
  `menu_photo` varchar(255) NOT NULL,
  `menu_category_id` int(11) NOT NULL,
  `stock_qty` int(11) NOT NULL,
  `minimum_qty` int(11) NOT NULL,
  `subtract_stock` tinyint(1) NOT NULL,
  `mealtime_id` int(11) NOT NULL,
  `menu_status` tinyint(1) NOT NULL,
  `menu_priority` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_menus`
--

INSERT INTO `yvdnsddqu_menus` (`menu_id`, `menu_name`, `menu_name_ar`, `menu_description`, `menu_description_ar`, `menu_price`, `menu_type`, `menu_photo`, `menu_category_id`, `stock_qty`, `minimum_qty`, `subtract_stock`, `mealtime_id`, `menu_status`, `menu_priority`, `location_id`, `added_by`) VALUES
(1, 'Dosa', NULL, '', NULL, 20, '', 'data/Mandi_(Mutton).jpg', 1, 10, 1, 0, 0, 1, 0, 1, 12),
(2, 'Fried Rice', NULL, 'Schezhwan Fried Rice', NULL, 264, '', 'data/Fatoush.jpg', 8, 95, 1, 1, 0, 1, 0, 1, 12),
(3, 'coffee', NULL, 'coffee', NULL, 120, '', 'data/kalila-3.jpg', 9, 100, 1, 1, 0, 1, 0, 3, 13),
(4, 'Chicken', NULL, '', NULL, 120, '', '', 5, 10, 1, 0, 0, 1, 0, 1, 12),
(5, 'Chicken', NULL, '', NULL, 180, '', 'data/Grilled_Chicken.jpg', 10, 10, 1, 0, 0, 1, 0, 3, 13),
(6, 'EggOnly', NULL, '', NULL, 3, '', 'data/Mix_Houmous.jpg', 12, 0, 1, 0, 0, 1, 0, 3, 13);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_menus_specials`
--

CREATE TABLE `yvdnsddqu_menus_specials` (
  `special_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL DEFAULT '0',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `special_price` decimal(15,4) DEFAULT NULL,
  `special_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_menus_specials`
--

INSERT INTO `yvdnsddqu_menus_specials` (`special_id`, `menu_id`, `start_date`, `end_date`, `special_price`, `special_status`) VALUES
(1, 2, '2020-05-05', '2020-05-20', '230.5500', 0);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_menu_options`
--

CREATE TABLE `yvdnsddqu_menu_options` (
  `menu_option_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `required` tinyint(4) NOT NULL,
  `default_value_id` tinyint(4) NOT NULL,
  `option_values` text NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_menu_options`
--

INSERT INTO `yvdnsddqu_menu_options` (`menu_option_id`, `option_id`, `menu_id`, `required`, `default_value_id`, `option_values`, `added_by`) VALUES
(1, 3, 2, 1, 0, 'a:3:{i:1;a:5:{s:15:\"option_value_id\";s:1:\"4\";s:5:\"price\";s:8:\"270.0000\";s:8:\"quantity\";s:3:\"100\";s:14:\"subtract_stock\";s:1:\"0\";s:20:\"menu_option_value_id\";s:1:\"1\";}i:2;a:5:{s:15:\"option_value_id\";s:1:\"6\";s:5:\"price\";s:8:\"271.5000\";s:8:\"quantity\";s:3:\"100\";s:14:\"subtract_stock\";s:1:\"0\";s:20:\"menu_option_value_id\";s:1:\"2\";}i:3;a:5:{s:15:\"option_value_id\";s:1:\"7\";s:5:\"price\";s:8:\"272.0000\";s:8:\"quantity\";s:3:\"100\";s:14:\"subtract_stock\";s:1:\"0\";s:20:\"menu_option_value_id\";s:1:\"3\";}}', 0),
(2, 2, 2, 1, 0, 'a:3:{i:4;a:5:{s:15:\"option_value_id\";s:1:\"1\";s:5:\"price\";s:8:\"300.0000\";s:8:\"quantity\";s:3:\"100\";s:14:\"subtract_stock\";s:1:\"0\";s:20:\"menu_option_value_id\";s:1:\"4\";}i:5;a:5:{s:15:\"option_value_id\";s:1:\"2\";s:5:\"price\";s:8:\"280.0000\";s:8:\"quantity\";s:3:\"100\";s:14:\"subtract_stock\";s:1:\"0\";s:20:\"menu_option_value_id\";s:1:\"5\";}i:6;a:5:{s:15:\"option_value_id\";s:1:\"3\";s:5:\"price\";s:8:\"310.0000\";s:8:\"quantity\";s:3:\"100\";s:14:\"subtract_stock\";s:1:\"0\";s:20:\"menu_option_value_id\";s:1:\"6\";}}', 0),
(3, 4, 5, 0, 0, 'a:3:{i:1;a:5:{s:15:\"option_value_id\";s:1:\"8\";s:5:\"price\";s:7:\"65.0000\";s:8:\"quantity\";s:2:\"50\";s:14:\"subtract_stock\";s:1:\"0\";s:20:\"menu_option_value_id\";s:1:\"7\";}i:2;a:5:{s:15:\"option_value_id\";s:1:\"9\";s:5:\"price\";s:7:\"70.0000\";s:8:\"quantity\";s:2:\"50\";s:14:\"subtract_stock\";s:1:\"0\";s:20:\"menu_option_value_id\";s:1:\"8\";}i:3;a:5:{s:15:\"option_value_id\";s:2:\"10\";s:5:\"price\";s:7:\"35.0000\";s:8:\"quantity\";s:2:\"50\";s:14:\"subtract_stock\";s:1:\"0\";s:20:\"menu_option_value_id\";s:1:\"9\";}}', 0),
(4, 5, 3, 0, 0, 'a:3:{i:1;a:5:{s:15:\"option_value_id\";s:2:\"11\";s:5:\"price\";s:7:\"20.0000\";s:8:\"quantity\";s:1:\"0\";s:14:\"subtract_stock\";s:1:\"0\";s:20:\"menu_option_value_id\";s:2:\"10\";}i:2;a:5:{s:15:\"option_value_id\";s:2:\"12\";s:5:\"price\";s:7:\"20.0000\";s:8:\"quantity\";s:1:\"0\";s:14:\"subtract_stock\";s:1:\"0\";s:20:\"menu_option_value_id\";s:2:\"11\";}i:3;a:5:{s:15:\"option_value_id\";s:2:\"13\";s:5:\"price\";s:7:\"20.0000\";s:8:\"quantity\";s:1:\"0\";s:14:\"subtract_stock\";s:1:\"0\";s:20:\"menu_option_value_id\";s:2:\"12\";}}', 0),
(5, 6, 6, 1, 0, 'a:1:{i:1;a:5:{s:15:\"option_value_id\";s:2:\"16\";s:5:\"price\";s:7:\"35.0000\";s:8:\"quantity\";s:1:\"0\";s:14:\"subtract_stock\";s:1:\"0\";s:20:\"menu_option_value_id\";s:2:\"13\";}}', 0);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_menu_option_values`
--

CREATE TABLE `yvdnsddqu_menu_option_values` (
  `menu_option_value_id` int(11) NOT NULL,
  `menu_option_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `option_value_id` int(11) NOT NULL,
  `new_price` decimal(15,4) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `subtract_stock` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_menu_option_values`
--

INSERT INTO `yvdnsddqu_menu_option_values` (`menu_option_value_id`, `menu_option_id`, `menu_id`, `option_id`, `option_value_id`, `new_price`, `quantity`, `subtract_stock`) VALUES
(1, 1, 2, 3, 4, '270.0000', 100, 0),
(2, 1, 2, 3, 6, '271.5000', 100, 0),
(3, 1, 2, 3, 7, '272.0000', 100, 0),
(4, 2, 2, 2, 1, '300.0000', 100, 0),
(5, 2, 2, 2, 2, '280.0000', 100, 0),
(6, 2, 2, 2, 3, '310.0000', 100, 0),
(7, 3, 5, 4, 8, '65.0000', 50, 0),
(8, 3, 5, 4, 9, '70.0000', 50, 0),
(9, 3, 5, 4, 10, '35.0000', 50, 0),
(10, 4, 3, 5, 11, '20.0000', 0, 0),
(11, 4, 3, 5, 12, '20.0000', 0, 0),
(12, 4, 3, 5, 13, '20.0000', 0, 0),
(13, 5, 6, 6, 16, '35.0000', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_messages`
--

CREATE TABLE `yvdnsddqu_messages` (
  `message_id` int(15) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  `send_type` varchar(32) NOT NULL,
  `recipient` varchar(32) NOT NULL,
  `subject` text NOT NULL,
  `body` text NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_message_meta`
--

CREATE TABLE `yvdnsddqu_message_meta` (
  `message_meta_id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `item` varchar(32) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_migrations`
--

CREATE TABLE `yvdnsddqu_migrations` (
  `type` varchar(40) DEFAULT NULL,
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_migrations`
--

INSERT INTO `yvdnsddqu_migrations` (`type`, `version`) VALUES
('core', 30),
('cart_module', 1);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_notifications`
--

CREATE TABLE `yvdnsddqu_notifications` (
  `id` int(11) NOT NULL,
  `order_count` int(11) NOT NULL,
  `view_status` int(11) NOT NULL DEFAULT '0' COMMENT '(0-Unread,1-Read)',
  `notify_msg` text,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_options`
--

CREATE TABLE `yvdnsddqu_options` (
  `option_id` int(11) NOT NULL,
  `option_name` varchar(32) NOT NULL,
  `option_name_arabic` varchar(100) NOT NULL,
  `display_type` varchar(15) NOT NULL,
  `priority` int(11) NOT NULL,
  `added_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_options`
--

INSERT INTO `yvdnsddqu_options` (`option_id`, `option_name`, `option_name_arabic`, `display_type`, `priority`, `added_by`) VALUES
(2, 'Option one', '', 'radio', 0, 12),
(3, 'Option two', '', 'checkbox', 0, 12),
(4, 'Chicken', '', 'checkbox', 0, 13),
(5, 'Coffee', '', 'checkbox', 0, 13),
(6, 'Egg', '', 'radio', 0, 13);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_option_values`
--

CREATE TABLE `yvdnsddqu_option_values` (
  `option_value_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `value` varchar(128) NOT NULL,
  `arabic_value` varchar(100) NOT NULL,
  `price` decimal(15,4) DEFAULT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_option_values`
--

INSERT INTO `yvdnsddqu_option_values` (`option_value_id`, `option_id`, `value`, `arabic_value`, `price`, `priority`) VALUES
(1, 2, 'Cheese', '', '1.0000', 1),
(2, 2, 'mayonnaise', '', '2.0000', 2),
(3, 2, 'Paneer', '', '3.0000', 3),
(4, 3, 'Tomato Sauce', '', NULL, 1),
(5, 3, 'Soya Sauce', '', NULL, 2),
(6, 3, 'Chilli Sauce', '', NULL, 3),
(7, 3, 'White butter sauces', '', NULL, 4),
(8, 4, 'Chicken 65', '', '0.0000', 1),
(9, 4, 'Gravy', '', '0.0000', 2),
(10, 4, 'Chicken', '', '0.0000', 3),
(11, 5, 'Black', '', '0.0000', 1),
(12, 5, 'Cold', '', '0.0000', 2),
(13, 5, 'Cool', '', '0.0000', 3),
(14, 6, 'Egg schez', '', NULL, 1),
(15, 6, 'Egg light', '', NULL, 2),
(16, 6, 'Egg heavy', '', '5.0000', 3);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_orders`
--

CREATE TABLE `yvdnsddqu_orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  `location_id` text,
  `address_id` int(11) NOT NULL,
  `cart` text NOT NULL,
  `total_items` int(11) NOT NULL,
  `comment` text NOT NULL,
  `payment` varchar(35) NOT NULL,
  `order_type` varchar(32) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` date NOT NULL,
  `order_time` time NOT NULL,
  `order_date` date NOT NULL,
  `order_total` decimal(15,4) DEFAULT NULL,
  `status_id` int(11) NOT NULL,
  `ip_address` varchar(40) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `notify` tinyint(1) NOT NULL,
  `assignee_id` int(11) NOT NULL,
  `delivery_id` int(10) NOT NULL DEFAULT '0',
  `reason_id` int(11) NOT NULL DEFAULT '0',
  `deliver_comments` varchar(150) DEFAULT NULL,
  `invoice_no` int(11) NOT NULL,
  `invoice_prefix` varchar(32) NOT NULL,
  `invoice_date` datetime NOT NULL,
  `id_proof` varchar(200) DEFAULT NULL,
  `delivery_name` varchar(50) NOT NULL,
  `delivery_fees` double NOT NULL,
  `booking_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_order_menus`
--

CREATE TABLE `yvdnsddqu_order_menus` (
  `order_menu_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `location_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_arabic` varchar(255) DEFAULT NULL,
  `option_name` text,
  `option_value_name` text,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,4) DEFAULT NULL,
  `subtotal` decimal(15,4) DEFAULT NULL,
  `option_values` text NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_order_options`
--

CREATE TABLE `yvdnsddqu_order_options` (
  `order_option_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `order_option_name` varchar(128) NOT NULL,
  `order_sub_option_name` text,
  `order_option_price` decimal(15,4) DEFAULT NULL,
  `order_menu_id` int(11) NOT NULL,
  `order_menu_option_id` int(11) DEFAULT NULL,
  `menu_option_value_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_order_totals`
--

CREATE TABLE `yvdnsddqu_order_totals` (
  `order_total_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `code` varchar(30) NOT NULL,
  `title` varchar(255) NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `priority` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_pages`
--

CREATE TABLE `yvdnsddqu_pages` (
  `page_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `meta_description` varchar(255) NOT NULL,
  `meta_keywords` varchar(255) NOT NULL,
  `layout_id` int(11) NOT NULL,
  `navigation` text NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_pages`
--

INSERT INTO `yvdnsddqu_pages` (`page_id`, `language_id`, `name`, `title`, `heading`, `content`, `meta_description`, `meta_keywords`, `layout_id`, `navigation`, `date_added`, `date_updated`, `status`) VALUES
(11, 11, 'About Us', 'About Us', 'About Us', '<h3 style=\"text-align: center;\"><span style=\"color: #993300;\">Aim</span></h3>\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In venenatis massa ac magna sagittis, sit amet gravida metus gravida. Aenean dictum pellentesque erat, vitae adipiscing libero semper sit amet. Vestibulum nec nunc lorem. Duis vitae libero a libero hendrerit tincidunt in eu tellus. Aliquam consequat ultrices felis ut dictum. Nulla euismod felis a sem mattis ornare. Aliquam ut diam sit amet dolor iaculis molestie ac id nisl. Maecenas hendrerit convallis mi feugiat gravida. Quisque tincidunt, leo a posuere imperdiet, metus leo vestibulum orci, vel volutpat justo ligula id quam. Cras placerat tincidunt lorem eu interdum.</p>\r\n<h3 style=\"text-align: center;\"><span style=\"color: #993300;\">Mission</span></h3>\r\n<p>Ut eu pretium urna. In sed consectetur neque. In ornare odio erat, id ornare arcu euismod a. Ut dapibus sit amet erat commodo vestibulum. Praesent vitae lacus faucibus, rhoncus tortor et, bibendum justo. Etiam pharetra congue orci, eget aliquam orci. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed eleifend justo eros, sit amet fermentum tellus ullamcorper quis. Cras cursus mi at imperdiet faucibus. Proin iaculis, felis vitae luctus venenatis, ante tortor porta nisi, et ornare magna metus sit amet enim. Phasellus et turpis nec metus aliquet adipiscing. Etiam at augue nec odio lacinia tincidunt. Suspendisse commodo commodo ipsum ac sollicitudin. Nunc nec consequat lacus. Donec gravida rhoncus justo sed elementum.</p>\r\n<h3 style=\"text-align: center;\"><span style=\"color: #a52a2a;\">Vision</span></h3>\r\n<p>Praesent erat massa, consequat a nulla et, eleifend facilisis risus. Nullam libero mi, bibendum id eleifend vitae, imperdiet a nulla. Fusce congue porta ultricies. Vivamus felis lectus, egestas at pretium vitae, posuere a nibh. Mauris lobortis urna nec rhoncus consectetur. Fusce sed placerat sem. Nulla venenatis elit risus, non auctor arcu lobortis eleifend. Ut aliquet vitae velit a faucibus. Suspendisse quis risus sit amet arcu varius malesuada. Vestibulum vitae massa consequat, euismod lorem a, euismod lacus. Duis sagittis dolor risus, ac vehicula mauris lacinia quis. Nulla facilisi. Duis tristique ipsum nec egestas auctor. Nullam in felis vel ligula dictum tincidunt nec a neque. Praesent in egestas elit.</p>', '', '', 17, 'a:2:{i:0;s:8:\"side_bar\";i:1;s:6:\"footer\";}', '2014-04-19 16:57:21', '2015-05-07 12:39:52', 1),
(12, 11, 'Policy', 'Policy', 'Policy', '<div id=\"lipsum\">\r\n<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ligula eros, semper a lorem et, venenatis volutpat dolor. Pellentesque hendrerit lectus feugiat nulla cursus, quis dapibus dolor porttitor. Donec velit enim, adipiscing ac orci id, congue tincidunt arcu. Proin egestas nulla eget leo scelerisque, et semper diam ornare. Suspendisse potenti. Suspendisse vitae bibendum enim. Duis eu ligula hendrerit, lacinia felis in, mollis nisi. Sed gravida arcu in laoreet dictum. Nulla faucibus lectus a mollis dapibus. Fusce vehicula convallis urna, et congue nulla ultricies in. Nulla magna velit, bibendum eu odio et, euismod rhoncus sem. Nullam quis magna fermentum, ultricies neque nec, blandit neque. Etiam nec congue arcu. Curabitur sed tellus quam. Cras adipiscing odio odio, et porttitor dui suscipit eget. Aliquam non est commodo, elementum turpis at, pellentesque lorem.</p>\r\n<p>Duis nec diam diam. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vulputate est et lorem sagittis, et mollis libero ultricies. Nunc ultrices tortor vel convallis varius. In dolor dolor, scelerisque ac faucibus ut, aliquet ac sem. Praesent consectetur lacus quis tristique posuere. Nulla sed ultricies odio. Cras tristique vulputate facilisis.</p>\r\n<p>Mauris at metus in magna condimentum gravida eu tincidunt urna. Praesent sodales vel mi eu condimentum. Suspendisse in luctus purus. Vestibulum dignissim, metus non luctus accumsan, odio ligula pharetra massa, in eleifend turpis risus in diam. Sed non lorem nibh. Nam at feugiat urna. Curabitur interdum, diam sit amet pulvinar blandit, mauris ante scelerisque nisi, sit amet placerat mi nunc eget orci. Nulla eget quam sit amet risus rhoncus lacinia a ut eros. Praesent non libero nisi. Mauris tincidunt at purus sit amet adipiscing. Donec interdum, velit nec dignissim vehicula, libero ipsum imperdiet ligula, lacinia mattis augue dui ac lacus. Aenean molestie sed nunc at pulvinar. Fusce ornare lacus non venenatis rhoncus.</p>\r\n<p>Aenean at enim luctus ante commodo consequat nec ut mi. Sed porta adipiscing tempus. Aliquam sit amet ullamcorper ipsum, id adipiscing quam. Fusce iaculis odio ut nisi convallis hendrerit. Morbi auctor adipiscing ligula, sit amet aliquet ante consectetur at. Donec vulputate neque eleifend libero pellentesque, vitae lacinia enim ornare. Vestibulum fermentum erat blandit, ultricies felis ac, facilisis augue. Nulla facilisis mi porttitor, interdum diam in, lobortis ipsum. In molestie quam nisl, lacinia convallis tellus fermentum ac. Nulla quis velit augue. Fusce accumsan, lacus et lobortis blandit, neque magna gravida enim, dignissim ultricies tortor dui in dolor. Vestibulum vel convallis justo, quis venenatis elit. Aliquam erat volutpat. Nunc quis iaculis ligula. Suspendisse dictum sodales neque vitae faucibus. Fusce id tellus pretium, varius nunc et, placerat metus.</p>\r\n<p>Pellentesque quis facilisis mauris. Phasellus porta, metus a dignissim viverra, est elit luctus erat, nec ultricies ligula lorem eget sapien. Pellentesque ac justo velit. Maecenas semper accumsan nulla eget rhoncus. Aliquam vel urna sed nibh dignissim auctor. Integer volutpat lacus ac purus convallis, at lobortis nisi tincidunt. Vestibulum condimentum elit ac sapien placerat, at ornare libero hendrerit. Cras tincidunt nunc sit amet ante bibendum tempor. Fusce quam orci, suscipit sed eros quis, vulputate molestie metus. Nam hendrerit vitae felis et porttitor. Proin et commodo velit, id porta erat. Donec eu consectetur odio. Fusce porta odio risus. Aliquam vel erat feugiat, vestibulum elit eget, ornare sapien. Sed sed nulla justo. Sed a dolor eu justo lacinia blandit</p>\r\n</div>', '', '', 17, 'a:2:{i:0;s:8:\"side_bar\";i:1;s:6:\"footer\";}', '2014-04-19 17:21:23', '2015-05-16 09:18:39', 1),
(13, 11, 'Terms & Condition', 'Terms & Condition', 'Terms & Condition', '<p>Test Terms content</p>', '', '', 0, 'a:2:{i:0;s:8:\"side_bar\";i:1;s:6:\"footer\";}', '2018-10-10 08:09:13', '2018-10-10 08:10:02', 1),
(14, 11, 'Cancellation', 'Cancellation', 'Cancellation', '<p>Test&nbsp;Cancellation content</p>', '', '', 0, 'a:2:{i:0;s:8:\"side_bar\";i:1;s:6:\"footer\";}', '2018-10-10 08:10:31', '2018-10-10 08:10:31', 0),
(15, 11, 'Earnings Help', 'Earnings Help', 'Earnings Help', '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>', '', '', 17, 'a:2:{i:0;s:8:\"side_bar\";i:1;s:6:\"footer\";}', '2014-04-19 16:57:21', '2014-04-19 16:57:21', 1);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_permalinks`
--

CREATE TABLE `yvdnsddqu_permalinks` (
  `permalink_id` int(11) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `controller` varchar(255) NOT NULL,
  `query` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_permalinks`
--

INSERT INTO `yvdnsddqu_permalinks` (`permalink_id`, `slug`, `controller`, `query`) VALUES
(1, 'data', 'local', 'location_id=1'),
(3, 'vegstarters', 'menus', 'category_id=1'),
(4, 'dessert', 'menus', 'category_id=2'),
(5, 'starter', 'menus', 'category_id=3'),
(6, 'non_vegstarter', 'menus', 'category_id=5'),
(9, 'maindishes', 'menus', 'category_id=8'),
(10, 'levelup', 'local', 'location_id=3'),
(11, 'newdish', 'menus', 'category_id=9'),
(12, 'dsfsdfs', 'menus', 'category_id=10');

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_permissions`
--

CREATE TABLE `yvdnsddqu_permissions` (
  `permission_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` varchar(255) NOT NULL,
  `action` text NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_permissions`
--

INSERT INTO `yvdnsddqu_permissions` (`permission_id`, `name`, `description`, `action`, `status`) VALUES
(11, 'Admin.Banners', 'Ability to access, manage, add and delete banners', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(12, 'Admin.Categories', 'Ability to access, manage, add and delete categories', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(13, 'Site.Countries', 'Ability to manage, add and delete site countries', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(14, 'Admin.Coupons', 'Ability to access, manage, add and delete coupons', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(15, 'Site.Currencies', 'Ability to access, manage, add and delete site currencies', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(16, 'Admin.CustomerGroups', 'Ability to access, manage, add and delete customer groups', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(17, 'Admin.Customers', 'Ability to access, manage, add and delete customers', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(18, 'Admin.CustomersOnline', 'Ability to access online customers', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(19, 'Admin.Maintenance', 'Ability to access, backup, restore and migrate database', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(20, 'Admin.ErrorLogs', 'Ability to access and delete error logs file', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(21, 'Admin.Extensions', 'Ability to access, manage, add and delete extension', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(22, 'Admin.MediaManager', 'Ability to access, manage, add and delete media items', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(23, 'Site.Languages', 'Ability to manage, add and delete site languages', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(24, 'Site.Layouts', 'Ability to manage, add and delete site layouts', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(25, 'Admin.Locations', 'Ability to access, manage, add and delete locations', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(26, 'Admin.MailTemplates', 'Ability to access, manage, add and delete mail templates', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(27, 'Admin.MenuOptions', 'Ability to access, manage, add and delete menu option items', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(28, 'Admin.Menus', 'Ability to access, manage, add and delete menu items', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(29, 'Admin.Messages', 'Ability to add and delete messages', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(30, 'Admin.Orders', 'Ability to access, manage, add and delete orders', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(31, 'Site.Pages', 'Ability to manage, add and delete site pages', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(32, 'Admin.Payments', 'Ability to access, add and delete extension payments', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(33, 'Admin.Permissions', 'Ability to manage, add and delete staffs permissions', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(34, 'Admin.Ratings', 'Ability to add and delete review ratings', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(35, 'Admin.Reservations', 'Ability to access, manage, add and delete reservations', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(36, 'Admin.Reviews', 'Ability to access, manage, add and delete user reviews', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(37, 'Admin.SecurityQuestions', 'Ability to add and delete customer registration security questions', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(38, 'Site.Settings', 'Ability to manage system settings', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(39, 'Admin.StaffGroups', 'Ability to access, manage, add and delete staff groups', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(40, 'Admin.Staffs', 'Ability to access, manage, add and delete staffs', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(42, 'Admin.Statuses', 'Ability to access, manage, add and delete orders and reservations statuses', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(43, 'Admin.Tables', 'Ability to access, manage, add and delete reservations tables', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(44, 'Site.Themes', 'Ability to access, manage site themes', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(45, 'Module.AccountModule', 'Ability to manage account module', 'a:1:{i:0;s:6:\"manage\";}', 1),
(47, 'Module.CartModule', 'Ability to manage cart module', 'a:1:{i:0;s:6:\"manage\";}', 1),
(48, 'Module.CategoriesModule', 'Ability to manage categories module', 'a:1:{i:0;s:6:\"manage\";}', 1),
(49, 'Module.LocalModule', 'Ability to manage local module', 'a:1:{i:0;s:6:\"manage\";}', 1),
(50, 'Module.PagesModule', 'Ability to manage pages module', 'a:1:{i:0;s:6:\"manage\";}', 1),
(51, 'Module.ReservationModule', 'Ability to manage reservation module', 'a:1:{i:0;s:6:\"manage\";}', 1),
(52, 'Module.Slideshow', 'Ability to manage slideshow module', 'a:1:{i:0;s:6:\"manage\";}', 1),
(55, 'Site.Updates', 'Ability to apply updates when a new version of TastyIgniter is available', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(56, 'Admin.Mealtimes', 'Ability to access, manage, add and delete mealtimes', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(57, 'Module.TwilioModule', 'Ability to manage Twilio SMS Gateway', 'a:1:{i:0;s:6:\"manage\";}', 1),
(59, 'Admin.Feedback', 'Ability to access, manage, add and delete feedback', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(60, 'Admin.Faq', 'Frequently Answered Questions', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(61, 'Payment.Cod', 'Ability to manage cash on delivery payment', 'a:1:{i:0;s:6:\"manage\";}', 1),
(63, 'Module.BannersModule', 'Ability to manage banners module', 'a:1:{i:0;s:6:\"manage\";}', 1),
(64, 'Payment.Stripe', 'Ability to manage Stripe payment extension', 'a:1:{i:0;s:6:\"manage\";}', 1),
(67, 'Admin.Delivery', 'Ability to access, manage, add and delete delivery boy', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(68, 'Admin.DeliveryOnline', 'Ability to access online Delivery boy', 'a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}', 1),
(69, 'Payment.PaypalExpress', 'Ability to manage paypal express payment', 'a:1:{i:0;s:6:\"manage\";}', 1);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_pp_payments`
--

CREATE TABLE `yvdnsddqu_pp_payments` (
  `transaction_id` varchar(150) NOT NULL,
  `order_id` varchar(100) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `serialized` longtext NOT NULL,
  `method` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_pp_payments`
--

INSERT INTO `yvdnsddqu_pp_payments` (`transaction_id`, `order_id`, `customer_id`, `serialized`, `method`) VALUES
('cash', '1', 1, 'N;', 'cash');

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_refund`
--

CREATE TABLE `yvdnsddqu_refund` (
  `id` int(11) NOT NULL,
  `reservation_id` varchar(50) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `refund_amount` double NOT NULL,
  `type` enum('requested','paid') NOT NULL,
  `response` text NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `payment_type` varchar(25) NOT NULL,
  `cancel_percent` int(10) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_reservations`
--

CREATE TABLE `yvdnsddqu_reservations` (
  `id` int(11) NOT NULL,
  `reservation_id` varchar(20) NOT NULL,
  `location_id` int(11) NOT NULL,
  `table_id` int(11) NOT NULL,
  `guest_num` int(11) NOT NULL,
  `occasion_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(96) NOT NULL,
  `telephone` varchar(45) NOT NULL,
  `comment` text NOT NULL,
  `reserve_time` time NOT NULL,
  `reserve_date` date NOT NULL,
  `date_added` date NOT NULL,
  `date_modified` date NOT NULL,
  `assignee_id` int(11) NOT NULL,
  `notify` tinyint(1) NOT NULL,
  `ip_address` varchar(40) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `otp` varchar(10) NOT NULL,
  `order_id` int(11) NOT NULL,
  `delivery_id` int(50) DEFAULT NULL,
  `paid_status` varchar(100) NOT NULL,
  `order_price` double NOT NULL,
  `booking_price` double NOT NULL,
  `booking_tax` double NOT NULL,
  `booking_tax_amount` double NOT NULL,
  `payment_method` varchar(200) DEFAULT NULL,
  `total_amount` varchar(100) NOT NULL,
  `reward_points` int(5) NOT NULL,
  `payment_key` varchar(150) DEFAULT NULL,
  `reward_using_status` int(11) NOT NULL DEFAULT '0',
  `used_reward_point` int(10) NOT NULL,
  `using_reward_points` int(10) NOT NULL,
  `using_reward_amount` int(10) NOT NULL,
  `reward_used_amount` int(10) NOT NULL,
  `review_status` int(2) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_reviews`
--

CREATE TABLE `yvdnsddqu_reviews` (
  `review_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `sale_id` varchar(255) NOT NULL,
  `sale_type` varchar(32) NOT NULL,
  `author` varchar(32) NOT NULL,
  `location_id` int(11) NOT NULL,
  `quality` int(11) NOT NULL,
  `delivery` int(11) NOT NULL,
  `service` int(11) NOT NULL,
  `review_text` text NOT NULL,
  `date_added` datetime NOT NULL,
  `review_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_reward_histories`
--

CREATE TABLE `yvdnsddqu_reward_histories` (
  `id` int(11) NOT NULL,
  `reservation_id` varchar(100) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_amount` varchar(100) NOT NULL,
  `reward_points` int(11) NOT NULL,
  `reward_amount` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_security_questions`
--

CREATE TABLE `yvdnsddqu_security_questions` (
  `question_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `text_ar` text NOT NULL,
  `priority` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_security_questions`
--

INSERT INTO `yvdnsddqu_security_questions` (`question_id`, `text`, `text_ar`, `priority`) VALUES
(11, 'Whats your pets name?', 'تقوم خدمة Google المجانية على الفور بترجمة الكلمات والعبارات وصفحات الويب بين الإنجليزية وأكثر من 100 لغة أخرى.', 1),
(12, 'What high school did you attend?', 'تقوم خدمة Google المجانية على الفور بترجمة الكلمات والعبارات وصفحات الويب بين الإنجليزية وأكثر من 100 لغة أخرى.', 2),
(13, 'Whats your friend name?', 'تقوم خدمة Google المجانية على الفور بترجمة الكلمات والعبارات وصفحات الويب بين الإنجليزية وأكثر من 100 لغة أخرى.', 6),
(14, 'What is your mother\'s name?', 'تقوم خدمة Google المجانية على الفور بترجمة الكلمات والعبارات وصفحات الويب بين الإنجليزية وأكثر من 100 لغة أخرى.', 3),
(15, 'What is your place of birth?', 'تقوم خدمة Google المجانية على الفور بترجمة الكلمات والعبارات وصفحات الويب بين الإنجليزية وأكثر من 100 لغة أخرى.', 4),
(16, 'Whats your favourite teacher\'s name?', 'تقوم خدمة Google المجانية على الفور بترجمة الكلمات والعبارات وصفحات الويب بين الإنجليزية وأكثر من 100 لغة أخرى.', 5);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_settings`
--

CREATE TABLE `yvdnsddqu_settings` (
  `setting_id` int(11) NOT NULL,
  `sort` varchar(45) NOT NULL,
  `item` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `serialized` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_settings`
--

INSERT INTO `yvdnsddqu_settings` (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES
(7870, 'prefs', 'mail_template_id', '11', 0),
(10972, 'prefs', 'ti_setup', 'installed', 0),
(11135, 'prefs', 'default_themes', 'a:2:{s:5:\"admin\";s:14:\"spotneat-blue/\";s:4:\"main\";s:9:\"spotneat/\";}', 1),
(11138, 'prefs', 'last_version_check', 'a:2:{s:18:\"last_version_check\";s:19:\"03-09-2018 14:19:08\";s:4:\"core\";N;}', 1),
(13510, 'prefs', 'active_theme_options', 'a:1:{s:4:\"main\";a:2:{i:0;s:8:\"spotneat\";i:1;a:20:{s:14:\"display_crumbs\";s:1:\"1\";s:15:\"hide_admin_link\";s:1:\"0\";s:16:\"ga_tracking_code\";s:0:\"\";s:4:\"font\";a:5:{s:6:\"family\";s:25:\"\"Oxygen\",Arial,sans-serif\";s:6:\"weight\";s:6:\"normal\";s:5:\"style\";s:6:\"normal\";s:4:\"size\";s:2:\"13\";s:5:\"color\";s:7:\"#333333\";}s:9:\"menu_font\";a:5:{s:6:\"family\";s:25:\"\"Oxygen\",Arial,sans-serif\";s:6:\"weight\";s:6:\"normal\";s:5:\"style\";s:6:\"normal\";s:4:\"size\";s:2:\"16\";s:5:\"color\";s:7:\"#ffffff\";}s:4:\"body\";a:6:{s:10:\"background\";s:7:\"#ffffff\";s:5:\"image\";s:0:\"\";s:7:\"display\";s:7:\"contain\";s:10:\"foreground\";s:7:\"#ffffff\";s:5:\"color\";s:7:\"#f5511e\";s:6:\"border\";s:7:\"#dddddd\";}s:4:\"link\";a:2:{s:5:\"color\";s:7:\"#f5511e\";s:5:\"hover\";s:7:\"#f5511e\";}s:7:\"heading\";a:6:{s:10:\"background\";s:0:\"\";s:5:\"image\";s:0:\"\";s:7:\"display\";s:7:\"contain\";s:5:\"color\";s:7:\"#333333\";s:11:\"under_image\";s:0:\"\";s:12:\"under_height\";s:2:\"50\";}s:6:\"button\";a:6:{s:7:\"default\";a:3:{s:10:\"background\";s:7:\"#f5511e\";s:5:\"hover\";s:7:\"#f5511e\";s:4:\"font\";s:7:\"#ffffff\";}s:7:\"primary\";a:3:{s:10:\"background\";s:7:\"#f5511e\";s:5:\"hover\";s:7:\"#f5511e\";s:4:\"font\";s:7:\"#ffffff\";}s:7:\"success\";a:3:{s:10:\"background\";s:7:\"#5cb85c\";s:5:\"hover\";s:7:\"#5cb85c\";s:4:\"font\";s:7:\"#ffffff\";}s:4:\"info\";a:3:{s:10:\"background\";s:7:\"#5bc0de\";s:5:\"hover\";s:7:\"#5bc0de\";s:4:\"font\";s:7:\"#ffffff\";}s:7:\"warning\";a:3:{s:10:\"background\";s:7:\"#f0ad4e\";s:5:\"hover\";s:7:\"#f0ad4e\";s:4:\"font\";s:7:\"#ffffff\";}s:6:\"danger\";a:3:{s:10:\"background\";s:7:\"#d9534f\";s:6:\"border\";s:7:\"#d9534f\";s:4:\"font\";s:7:\"#ffffff\";}}s:7:\"sidebar\";a:5:{s:10:\"background\";s:7:\"#ffffff\";s:5:\"image\";s:0:\"\";s:7:\"display\";s:7:\"contain\";s:4:\"font\";s:7:\"#484848\";s:6:\"border\";s:7:\"#eeeeee\";}s:6:\"header\";a:5:{s:10:\"background\";s:7:\"#f5511e\";s:5:\"image\";s:0:\"\";s:7:\"display\";s:7:\"contain\";s:19:\"dropdown_background\";s:7:\"#f5511e\";s:5:\"color\";s:7:\"#ffffff\";}s:10:\"logo_image\";s:0:\"\";s:9:\"logo_text\";s:0:\"\";s:11:\"logo_height\";s:2:\"40\";s:16:\"logo_padding_top\";s:2:\"10\";s:19:\"logo_padding_bottom\";s:2:\"10\";s:7:\"favicon\";s:0:\"\";s:6:\"footer\";a:8:{s:10:\"background\";s:7:\"#edeff1\";s:5:\"image\";s:0:\"\";s:7:\"display\";s:7:\"contain\";s:17:\"bottom_background\";s:7:\"#fbfbfb\";s:12:\"bottom_image\";s:0:\"\";s:14:\"bottom_display\";s:7:\"contain\";s:12:\"footer_color\";s:7:\"#9ba1a7\";s:19:\"bottom_footer_color\";s:7:\"#a3aaaf\";}s:6:\"social\";a:12:{s:8:\"facebook\";s:1:\"#\";s:7:\"twitter\";s:1:\"#\";s:6:\"google\";s:1:\"#\";s:7:\"youtube\";s:1:\"#\";s:5:\"vimeo\";s:0:\"\";s:8:\"linkedin\";s:0:\"\";s:9:\"pinterest\";s:0:\"\";s:6:\"tumblr\";s:0:\"\";s:6:\"flickr\";s:0:\"\";s:9:\"instagram\";s:0:\"\";s:8:\"dribbble\";s:0:\"\";s:10:\"foursquare\";s:0:\"\";}s:13:\"custom_script\";a:3:{s:3:\"css\";s:0:\"\";s:4:\"head\";s:0:\"\";s:6:\"footer\";s:0:\"\";}}}}', 1),
(15113, 'delivery_fee', 'standard_fee', '6', 0),
(15114, 'delivery_fee', 'premium_fee', '12', 0),
(16901, 'prefs', 'ti_version', '2.1.1', 0),
(19441, 'ratings', 'ratings', 'a:1:{s:7:\"ratings\";a:6:{i:1;s:3:\"Mal\";i:2;s:7:\"Muy mal\";i:3;s:4:\"Bien\";i:4;s:6:\"Normal\";i:5;s:9:\"Excelente\";i:6;s:4:\"good\";}}', 1),
(20683, 'prefs', 'default_location_id', '1', 0),
(21003, 'prefs', 'main_address', 'a:21:{s:11:\"location_id\";s:1:\"1\";s:13:\"location_name\";s:7:\"Next In\";s:16:\"location_name_ar\";s:0:\"\";s:9:\"address_1\";s:13:\"Sydney Street\";s:9:\"address_2\";s:13:\"Sydney Street\";s:4:\"city\";s:7:\"Kempsey\";s:5:\"state\";s:3:\"NSW\";s:8:\"postcode\";s:4:\"2440\";s:10:\"country_id\";s:2:\"13\";s:7:\"country\";s:9:\"Australia\";s:12:\"address_1_ar\";s:0:\"\";s:12:\"address_2_ar\";s:0:\"\";s:7:\"city_ar\";s:0:\"\";s:8:\"state_ar\";s:0:\"\";s:11:\"postcode_ar\";N;s:10:\"country_ar\";s:9:\"Australia\";s:10:\"iso_code_2\";s:2:\"AU\";s:10:\"iso_code_3\";s:3:\"AUS\";s:12:\"location_lat\";s:10:\"-31.081041\";s:12:\"location_lng\";s:10:\"152.837479\";s:6:\"format\";s:0:\"\";}', 1),
(21193, 'config', 'site_name', 'RestaurantCart', 0),
(21194, 'config', 'site_email', 'hello@RestaurantCart.com', 0),
(21195, 'config', 'site_logo', 'data/SmallLogo.jpg', 0),
(21196, 'config', 'country_id', '99', 0),
(21197, 'config', 'timezone', 'Asia/Kolkata', 0),
(21198, 'config', 'date_format', '%d/%m/%Y', 0),
(21199, 'config', 'time_format', '%h:%i %A', 0),
(21200, 'config', 'currency_id', '98', 0),
(21201, 'config', 'auto_update_currency_rates', '0', 0),
(21202, 'config', 'accepted_currencies', 'a:1:{i:0;s:2:\"98\";}', 1),
(21203, 'config', 'customer_group_id', '11', 0),
(21204, 'config', 'page_limit', '500', 0),
(21205, 'config', 'meta_description', 'RestaurantCart', 0),
(21206, 'config', 'meta_keywords', 'RestaurantCart', 0),
(21207, 'config', 'menus_page_limit', '500', 0),
(21208, 'config', 'show_menu_images', '1', 0),
(21209, 'config', 'menu_images_h', '80', 0),
(21210, 'config', 'menu_images_w', '95', 0),
(21211, 'config', 'tax_mode', '1', 0),
(21212, 'config', 'tax_percentage', '10', 0),
(21213, 'config', 'tax_menu_price', '1', 0),
(21214, 'config', 'tax_delivery_charge', '1', 0),
(21215, 'config', 'stock_checkout', '0', 0),
(21216, 'config', 'show_stock_warning', '1', 0),
(21217, 'config', 'registration_terms', '0', 0),
(21218, 'config', 'checkout_terms', '0', 0),
(21219, 'config', 'maps_api_key', '', 0),
(21220, 'config', 'distance_unit', 'km', 0),
(21221, 'config', 'future_orders', '0', 0),
(21222, 'config', 'location_order', '1', 0),
(21223, 'config', 'allow_reviews', '0', 0),
(21224, 'config', 'approve_reviews', '0', 0),
(21225, 'config', 'default_order_status', '1', 0),
(21226, 'config', 'canceled_order_status', '0', 0),
(21227, 'config', 'auto_invoicing', '0', 0),
(21228, 'config', 'invoice_prefix', 'INV-{year}-00', 0),
(21229, 'config', 'guest_order', '0', 0),
(21230, 'config', 'delivery_time', '45', 0),
(21231, 'config', 'collection_time', '15', 0),
(21232, 'config', 'reservation_mode', '1', 0),
(21233, 'config', 'default_reservation_status', '21', 0),
(21234, 'config', 'confirmed_reservation_status', '22', 0),
(21235, 'config', 'canceled_reservation_status', '23', 0),
(21236, 'config', 'reservation_time_interval', '15', 0),
(21237, 'config', 'reservation_stay_time', '30', 0),
(21238, 'config', 'image_manager', 'a:11:{s:8:\"max_size\";s:7:\"3000000\";s:11:\"thumb_width\";s:3:\"320\";s:12:\"thumb_height\";s:3:\"220\";s:7:\"uploads\";s:1:\"1\";s:10:\"new_folder\";s:1:\"1\";s:4:\"copy\";s:1:\"1\";s:4:\"move\";s:1:\"1\";s:6:\"rename\";s:1:\"1\";s:6:\"delete\";s:1:\"1\";s:15:\"transliteration\";s:1:\"0\";s:13:\"remember_days\";s:1:\"7\";}', 1),
(21239, 'config', 'registration_email', 'a:2:{i:0;s:8:\"customer\";i:1;s:5:\"admin\";}', 1),
(21240, 'config', 'order_email', 'a:2:{i:0;s:8:\"customer\";i:1;s:5:\"admin\";}', 1),
(21241, 'config', 'reservation_email', 'a:2:{i:0;s:8:\"customer\";i:1;s:5:\"admin\";}', 1),
(21242, 'config', 'protocol', 'sendmail', 0),
(21243, 'config', 'smtp_host', '', 0),
(21244, 'config', 'smtp_port', '', 0),
(21245, 'config', 'smtp_user', 'admin', 0),
(21246, 'config', 'smtp_pass', 'root', 0),
(21247, 'config', 'customer_online_time_out', '120', 0),
(21248, 'config', 'customer_online_archive_time_out', '0', 0),
(21249, 'config', 'permalink', '1', 0),
(21250, 'config', 'maintenance_mode', '0', 0),
(21251, 'config', 'maintenance_message', 'Site is under maintenance. Please check back later.', 0),
(21252, 'config', 'cache_mode', '0', 0),
(21253, 'config', 'cache_time', '0', 0),
(21254, 'config', 'reward_value', '15', 0),
(21255, 'config', 'point_value', '14', 0);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_sms_templates_data`
--

CREATE TABLE `yvdnsddqu_sms_templates_data` (
  `template_data_id` int(11) NOT NULL,
  `code` varchar(32) NOT NULL,
  `body` text NOT NULL,
  `date_added` datetime NOT NULL,
  `date_updated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_staffs`
--

CREATE TABLE `yvdnsddqu_staffs` (
  `staff_id` int(11) NOT NULL,
  `staff_name` varchar(32) NOT NULL,
  `staff_email` varchar(96) NOT NULL,
  `staff_telephone` varchar(32) NOT NULL,
  `staff_group_id` int(11) NOT NULL,
  `staff_location_id` int(11) NOT NULL,
  `commission` int(10) NOT NULL,
  `delivery_commission` float(10,2) NOT NULL,
  `timezone` varchar(32) NOT NULL,
  `language_id` int(11) NOT NULL,
  `staff_permissions` text,
  `payment_details` text,
  `date_added` date NOT NULL,
  `staff_status` tinyint(1) DEFAULT NULL,
  `tax_id` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_staffs`
--

INSERT INTO `yvdnsddqu_staffs` (`staff_id`, `staff_name`, `staff_email`, `staff_telephone`, `staff_group_id`, `staff_location_id`, `commission`, `delivery_commission`, `timezone`, `language_id`, `staff_permissions`, `payment_details`, `date_added`, `staff_status`, `tax_id`) VALUES
(11, 'admin', 'hello@RestaurantCart.com', '+91-5454354543', 11, 0, 0, 0.00, '', 11, 'a:18:{s:10:\"Categories\";s:2:\"on\";s:7:\"Coupons\";s:2:\"on\";s:9:\"Customers\";s:2:\"on\";s:15:\"CustomersOnline\";s:2:\"on\";s:12:\"MediaManager\";s:2:\"on\";s:9:\"Locations\";s:2:\"on\";s:11:\"MenuOptions\";s:2:\"on\";s:5:\"Menus\";s:2:\"on\";s:8:\"Messages\";s:2:\"on\";s:6:\"Orders\";s:2:\"on\";s:8:\"Payments\";s:2:\"on\";s:11:\"Permissions\";s:2:\"on\";s:7:\"Ratings\";s:2:\"on\";s:12:\"Reservations\";s:2:\"on\";s:7:\"Reviews\";s:2:\"on\";s:6:\"Staffs\";s:2:\"on\";s:6:\"Tables\";s:2:\"on\";s:8:\"Feedback\";s:2:\"on\";}', 'a:5:{s:12:\"payment_type\";s:1:\"1\";s:16:\"payment_username\";s:12:\"mohamedbilal\";s:16:\"payment_password\";s:10:\"Bilal@1104\";s:11:\"merchant_id\";s:0:\"\";s:11:\"payment_key\";s:0:\"\";}', '2018-09-27', 1, NULL),
(12, 'Vendor', 'vendor@yopmail.com', '+91-9999111129', 12, 0, 2, 0.00, '', 0, 'a:20:{s:10:\"Categories\";s:2:\"on\";s:7:\"Coupons\";s:2:\"on\";s:9:\"Customers\";s:2:\"on\";s:15:\"CustomersOnline\";s:2:\"on\";s:12:\"MediaManager\";s:2:\"on\";s:9:\"Locations\";s:2:\"on\";s:11:\"MenuOptions\";s:2:\"on\";s:5:\"Menus\";s:2:\"on\";s:8:\"Messages\";s:2:\"on\";s:6:\"Orders\";s:2:\"on\";s:8:\"Payments\";s:2:\"on\";s:11:\"Permissions\";s:2:\"on\";s:7:\"Ratings\";s:2:\"on\";s:12:\"Reservations\";s:2:\"on\";s:7:\"Reviews\";s:2:\"on\";s:6:\"Staffs\";s:2:\"on\";s:6:\"Tables\";s:2:\"on\";s:8:\"Feedback\";s:2:\"on\";s:8:\"Delivery\";s:2:\"on\";s:14:\"DeliveryOnline\";s:2:\"on\";}', 'a:5:{s:12:\"payment_type\";s:1:\"1\";s:16:\"payment_username\";s:0:\"\";s:16:\"payment_password\";s:0:\"\";s:11:\"merchant_id\";s:0:\"\";s:11:\"payment_key\";s:0:\"\";}', '2020-04-30', 1, NULL),
(13, 'johndoe', 'johndoe@yopmail.com', '+61-9876543210', 12, 0, 2, 0.00, '', 0, 'a:20:{s:10:\"Categories\";s:2:\"on\";s:7:\"Coupons\";s:2:\"on\";s:9:\"Customers\";s:2:\"on\";s:15:\"CustomersOnline\";s:2:\"on\";s:12:\"MediaManager\";s:2:\"on\";s:9:\"Locations\";s:2:\"on\";s:11:\"MenuOptions\";s:2:\"on\";s:5:\"Menus\";s:2:\"on\";s:8:\"Messages\";s:2:\"on\";s:6:\"Orders\";s:2:\"on\";s:8:\"Payments\";s:2:\"on\";s:11:\"Permissions\";s:2:\"on\";s:7:\"Ratings\";s:2:\"on\";s:12:\"Reservations\";s:2:\"on\";s:7:\"Reviews\";s:2:\"on\";s:6:\"Staffs\";s:2:\"on\";s:6:\"Tables\";s:2:\"on\";s:8:\"Feedback\";s:2:\"on\";s:8:\"Delivery\";s:2:\"on\";s:14:\"DeliveryOnline\";s:2:\"on\";}', 'a:5:{s:12:\"payment_type\";s:1:\"1\";s:16:\"payment_username\";s:0:\"\";s:16:\"payment_password\";s:0:\"\";s:11:\"merchant_id\";s:0:\"\";s:11:\"payment_key\";s:0:\"\";}', '2020-05-05', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_staffs_commission`
--

CREATE TABLE `yvdnsddqu_staffs_commission` (
  `id` int(11) NOT NULL,
  `staff_id` int(10) NOT NULL,
  `location_id` int(10) NOT NULL,
  `percentage` int(10) NOT NULL,
  `total_amount` double NOT NULL,
  `table_amount` double NOT NULL,
  `table_tax` double NOT NULL,
  `order_amount` double NOT NULL,
  `order_tax` double NOT NULL,
  `commission_amount` float NOT NULL,
  `reservation_id` varchar(50) NOT NULL,
  `status` int(10) NOT NULL,
  `payment_status` varchar(50) NOT NULL,
  `payment_date` datetime NOT NULL,
  `receipt_no` varchar(50) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_staff_groups`
--

CREATE TABLE `yvdnsddqu_staff_groups` (
  `staff_group_id` int(11) NOT NULL,
  `staff_group_name` varchar(32) NOT NULL,
  `customer_account_access` tinyint(4) NOT NULL,
  `location_access` tinyint(1) NOT NULL,
  `permissions` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_staff_groups`
--

INSERT INTO `yvdnsddqu_staff_groups` (`staff_group_id`, `staff_group_name`, `customer_account_access`, `location_access`, `permissions`) VALUES
(11, 'Administrator', 1, 1, 'a:48:{i:11;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:12;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:14;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:16;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:17;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:18;a:1:{i:0;s:6:\"access\";}i:19;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:20;a:2:{i:0;s:6:\"access\";i:1;s:6:\"delete\";}i:21;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:22;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:25;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:26;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:27;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:28;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:29;a:2:{i:0;s:3:\"add\";i:1;s:6:\"delete\";}i:30;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:32;a:3:{i:0;s:6:\"access\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:33;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:34;a:2:{i:0;s:3:\"add\";i:1;s:6:\"delete\";}i:35;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:36;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:37;a:2:{i:0;s:3:\"add\";i:1;s:6:\"delete\";}i:39;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:40;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:42;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:43;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:56;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:13;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:15;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:23;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:24;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:31;a:3:{i:0;s:6:\"manage\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:38;a:1:{i:0;s:6:\"manage\";}i:44;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:55;a:1:{i:0;s:3:\"add\";}i:45;a:1:{i:0;s:6:\"manage\";}i:47;a:1:{i:0;s:6:\"manage\";}i:48;a:1:{i:0;s:6:\"manage\";}i:49;a:1:{i:0;s:6:\"manage\";}i:50;a:1:{i:0;s:6:\"manage\";}i:51;a:1:{i:0;s:6:\"manage\";}i:52;a:1:{i:0;s:6:\"manage\";}i:57;a:1:{i:0;s:6:\"manage\";}i:63;a:1:{i:0;s:6:\"manage\";}i:61;a:1:{i:0;s:6:\"manage\";}i:64;a:1:{i:0;s:6:\"manage\";}i:69;a:1:{i:0;s:6:\"manage\";}i:70;a:1:{i:0;s:6:\"manage\";}}'),
(12, 'Clients', 1, 1, 'a:20:{i:12;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:14;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:17;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:18;a:1:{i:0;s:6:\"access\";}i:22;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:25;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:27;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:28;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:29;a:2:{i:0;s:3:\"add\";i:1;s:6:\"delete\";}i:30;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:32;a:3:{i:0;s:6:\"access\";i:1;s:3:\"add\";i:2;s:6:\"delete\";}i:33;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:34;a:2:{i:0;s:3:\"add\";i:1;s:6:\"delete\";}i:35;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:36;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:40;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:43;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:59;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:67;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}i:68;a:4:{i:0;s:6:\"access\";i:1;s:6:\"manage\";i:2;s:3:\"add\";i:3;s:6:\"delete\";}}');

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_statuses`
--

CREATE TABLE `yvdnsddqu_statuses` (
  `status_id` int(15) NOT NULL,
  `status_name` varchar(45) NOT NULL,
  `status_code` int(2) NOT NULL,
  `status_comment` text NOT NULL,
  `notify_customer` tinyint(1) NOT NULL,
  `status_for` varchar(10) NOT NULL,
  `status_color` varchar(32) NOT NULL,
  `template_id` varchar(200) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_statuses`
--

INSERT INTO `yvdnsddqu_statuses` (`status_id`, `status_name`, `status_code`, `status_comment`, `notify_customer`, `status_for`, `status_color`, `template_id`, `status`) VALUES
(1, 'Cancelled', 0, 'Your order is canceled', 1, 'order', '#ea0b29', 'a4dfe215-9f44-4835-a398-9d024b446bf3', 1),
(2, 'Pending', 1, 'Your order is in pending.', 1, 'order', '#f0ad4e', 'fc00ca76-8bdb-4803-b48e-c296e1f4228f', 1),
(3, 'Confirmed', 2, 'Your order is confirmed by restaurant', 0, 'order', '#00a65a', NULL, 1),
(4, 'Delivery Assign', 3, 'Your order is assigned to the delivery partner.', 0, 'order', '#00c0ef', 'd8f438f6-3283-474c-8aaa-cc9d50e81b25', 0),
(5, 'Picked Up / Delivery on the Way', 4, 'Your order is picked and delivery boy on the way', 0, 'order', '#000000', NULL, 1),
(6, 'Reached Customer Place', 5, 'Your order is confirmed.', 0, 'order', '#000000', NULL, 0),
(7, 'Delivered', 20, 'Your order is Delivered', 1, 'order', '#bf24cc', NULL, 1),
(8, 'Customer Cancelled', 7, 'Your order is in pending.', 0, 'order', '#f70707', NULL, 0),
(9, 'Delivery boy canceled', 8, 'Your order is cancelled by Delivery person.', 0, 'order', '#fa0000', NULL, 0),
(10, 'Restaurant Cancelled', 9, 'Your order is cancelled by restaurant', 0, 'order', '#f50000', NULL, 0),
(11, 'Customer Not Responded', 10, 'No response from Customer.', 0, 'order', '#fc0000', NULL, 0),
(12, 'Address not Located', 11, 'Address not located', 0, 'order', '#f50909', NULL, 0),
(22, 'Pending', 21, 'Your reservation is pending.', 1, 'reserve', '#ffbc00', '5152550a-8c02-44fe-b466-47f34b48ca1f', 1),
(23, 'Confirmed', 22, 'Your reservation was confirmed by restaurant.', 1, 'reserve', '#00a65a', '97b86275-1376-4982-9c24-488b08e69867', 1),
(24, 'Canceled', 23, 'Your reservation is canceled', 1, 'reserve', '#dd4b39', '6269ed74-1463-4c79-b5ae-ba751ba5da26', 1),
(25, 'Completed', 24, 'Your Booking has been completed', 0, 'reserve', '#1f660d', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_status_history`
--

CREATE TABLE `yvdnsddqu_status_history` (
  `status_history_id` int(11) NOT NULL,
  `object_id` varchar(100) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `assignee_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `notify` tinyint(1) NOT NULL,
  `status_for` varchar(32) NOT NULL,
  `comment` text,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_status_history`
--

INSERT INTO `yvdnsddqu_status_history` (`status_history_id`, `object_id`, `staff_id`, `assignee_id`, `status_id`, `notify`, `status_for`, `comment`, `date_added`) VALUES
(1, '1', 0, 0, 1, 0, 'order', 'Your Order is Pending', '2020-05-02 07:28:20'),
(2, '2', 0, 0, 1, 0, 'order', 'Your Order is Pending', '2020-05-05 15:26:45'),
(3, '2', 11, 0, 2, 0, 'order', 'Your order is confirmed by restaurant', '2020-05-05 15:56:23'),
(4, '2', 11, 0, 2, 0, 'order', 'Your order is confirmed by restaurant', '2020-05-05 16:09:53'),
(5, '2', 11, 0, 2, 0, 'order', 'Your order is confirmed by restaurant', '2020-05-05 16:10:08'),
(6, '2', 11, 0, 2, 0, 'order', 'Your order is confirmed by restaurant', '2020-05-05 16:10:41'),
(7, '3', 0, 0, 1, 0, 'order', 'Your Order is Pending', '2020-05-05 16:12:13'),
(8, '3', 11, 0, 20, 0, 'order', 'Your order is Delivered', '2020-05-05 16:17:18'),
(9, '4', 0, 0, 1, 0, 'order', 'Your Order is Pending', '2020-05-06 20:18:20');

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_tables`
--

CREATE TABLE `yvdnsddqu_tables` (
  `table_id` int(11) NOT NULL,
  `table_name` varchar(32) NOT NULL,
  `min_capacity` int(11) NOT NULL,
  `max_capacity` int(11) NOT NULL,
  `table_status` tinyint(1) NOT NULL,
  `added_by` int(11) NOT NULL,
  `additional_charge` varchar(100) NOT NULL,
  `total_price` varchar(100) NOT NULL,
  `location_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_tables`
--

INSERT INTO `yvdnsddqu_tables` (`table_id`, `table_name`, `min_capacity`, `max_capacity`, `table_status`, `added_by`, `additional_charge`, `total_price`, `location_id`) VALUES
(1, 'Birthday table', 2, 2, 0, 12, '', '', 1),
(2, 'Client Meeting table', 10, 15, 1, 12, '', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_uri_routes`
--

CREATE TABLE `yvdnsddqu_uri_routes` (
  `uri_route_id` int(11) NOT NULL,
  `uri_route` varchar(255) NOT NULL,
  `controller` varchar(128) NOT NULL,
  `priority` tinyint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_uri_routes`
--

INSERT INTO `yvdnsddqu_uri_routes` (`uri_route_id`, `uri_route`, `controller`, `priority`) VALUES
(1, 'locations', 'local/locations', 1),
(2, 'account', 'account/account', 2),
(3, '(:any)', 'pages', 3);

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_users`
--

CREATE TABLE `yvdnsddqu_users` (
  `user_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_users`
--

INSERT INTO `yvdnsddqu_users` (`user_id`, `staff_id`, `username`, `password`, `salt`) VALUES
(11, 11, 'admin', 'd2b583ba0cbe4174acfd3ece9fc7651ffe0be025', '826b3c77f'),
(114, 12, 'vendor', 'ebf34576e6636bcc0fdec302e19a83dd05611604', '90d78ded8'),
(115, 13, 'johndoe', '6e6e2690100ad082df7a64074e5fca1d17c6455d', 'ddad3ab1f');

-- --------------------------------------------------------

--
-- Table structure for table `yvdnsddqu_working_hours`
--

CREATE TABLE `yvdnsddqu_working_hours` (
  `location_id` int(11) NOT NULL,
  `weekday` int(11) NOT NULL,
  `opening_time` time NOT NULL DEFAULT '00:00:00',
  `closing_time` time NOT NULL DEFAULT '00:00:00',
  `status` tinyint(1) NOT NULL,
  `type` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `yvdnsddqu_working_hours`
--

INSERT INTO `yvdnsddqu_working_hours` (`location_id`, `weekday`, `opening_time`, `closing_time`, `status`, `type`) VALUES
(1, 0, '00:00:00', '23:59:00', 1, 'collection'),
(1, 0, '00:00:00', '23:59:00', 1, 'delivery'),
(1, 0, '00:00:00', '23:59:00', 1, 'opening'),
(1, 1, '00:00:00', '23:59:00', 1, 'collection'),
(1, 1, '00:00:00', '23:59:00', 1, 'delivery'),
(1, 1, '00:00:00', '23:59:00', 1, 'opening'),
(1, 2, '00:00:00', '23:59:00', 1, 'collection'),
(1, 2, '00:00:00', '23:59:00', 1, 'delivery'),
(1, 2, '00:00:00', '23:59:00', 1, 'opening'),
(1, 3, '00:00:00', '23:59:00', 1, 'collection'),
(1, 3, '00:00:00', '23:59:00', 1, 'delivery'),
(1, 3, '00:00:00', '23:59:00', 1, 'opening'),
(1, 4, '00:00:00', '23:59:00', 1, 'collection'),
(1, 4, '00:00:00', '23:59:00', 1, 'delivery'),
(1, 4, '00:00:00', '23:59:00', 1, 'opening'),
(1, 5, '00:00:00', '23:59:00', 1, 'collection'),
(1, 5, '00:00:00', '23:59:00', 1, 'delivery'),
(1, 5, '00:00:00', '23:59:00', 1, 'opening'),
(1, 6, '00:00:00', '23:59:00', 1, 'collection'),
(1, 6, '00:00:00', '23:59:00', 1, 'delivery'),
(1, 6, '00:00:00', '23:59:00', 1, 'opening'),
(3, 0, '00:00:00', '23:59:00', 1, 'collection'),
(3, 0, '00:00:00', '23:59:00', 1, 'delivery'),
(3, 0, '00:00:00', '23:59:00', 1, 'opening'),
(3, 1, '00:00:00', '23:59:00', 1, 'collection'),
(3, 1, '00:00:00', '23:59:00', 1, 'delivery'),
(3, 1, '00:00:00', '23:59:00', 1, 'opening'),
(3, 2, '00:00:00', '23:59:00', 1, 'collection'),
(3, 2, '00:00:00', '23:59:00', 1, 'delivery'),
(3, 2, '00:00:00', '23:59:00', 1, 'opening'),
(3, 3, '00:00:00', '23:59:00', 1, 'collection'),
(3, 3, '00:00:00', '23:59:00', 1, 'delivery'),
(3, 3, '00:00:00', '23:59:00', 1, 'opening'),
(3, 4, '00:00:00', '23:59:00', 1, 'collection'),
(3, 4, '00:00:00', '23:59:00', 1, 'delivery'),
(3, 4, '00:00:00', '23:59:00', 1, 'opening'),
(3, 5, '00:00:00', '23:59:00', 1, 'collection'),
(3, 5, '00:00:00', '23:59:00', 1, 'delivery'),
(3, 5, '00:00:00', '23:59:00', 1, 'opening'),
(3, 6, '00:00:00', '23:59:00', 1, 'collection'),
(3, 6, '00:00:00', '23:59:00', 1, 'delivery'),
(3, 6, '00:00:00', '23:59:00', 1, 'opening');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `yvdnsddqu_activities`
--
ALTER TABLE `yvdnsddqu_activities`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `yvdnsddqu_addresses`
--
ALTER TABLE `yvdnsddqu_addresses`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `yvdnsddqu_admin_payments`
--
ALTER TABLE `yvdnsddqu_admin_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yvdnsddqu_banners`
--
ALTER TABLE `yvdnsddqu_banners`
  ADD PRIMARY KEY (`banner_id`);

--
-- Indexes for table `yvdnsddqu_categories`
--
ALTER TABLE `yvdnsddqu_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `yvdnsddqu_countries`
--
ALTER TABLE `yvdnsddqu_countries`
  ADD PRIMARY KEY (`country_id`);

--
-- Indexes for table `yvdnsddqu_coupons`
--
ALTER TABLE `yvdnsddqu_coupons`
  ADD PRIMARY KEY (`coupon_id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `yvdnsddqu_coupons_history`
--
ALTER TABLE `yvdnsddqu_coupons_history`
  ADD PRIMARY KEY (`coupon_history_id`);

--
-- Indexes for table `yvdnsddqu_currencies`
--
ALTER TABLE `yvdnsddqu_currencies`
  ADD PRIMARY KEY (`currency_id`);

--
-- Indexes for table `yvdnsddqu_customers`
--
ALTER TABLE `yvdnsddqu_customers`
  ADD PRIMARY KEY (`customer_id`,`email`);

--
-- Indexes for table `yvdnsddqu_customers_online`
--
ALTER TABLE `yvdnsddqu_customers_online`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `yvdnsddqu_customer_groups`
--
ALTER TABLE `yvdnsddqu_customer_groups`
  ADD PRIMARY KEY (`customer_group_id`);

--
-- Indexes for table `yvdnsddqu_delivery`
--
ALTER TABLE `yvdnsddqu_delivery`
  ADD PRIMARY KEY (`delivery_id`,`email`),
  ADD KEY `UNIQUE` (`email`,`telephone`);

--
-- Indexes for table `yvdnsddqu_delivery_addresses`
--
ALTER TABLE `yvdnsddqu_delivery_addresses`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `yvdnsddqu_delivery_booking`
--
ALTER TABLE `yvdnsddqu_delivery_booking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yvdnsddqu_delivery_groups`
--
ALTER TABLE `yvdnsddqu_delivery_groups`
  ADD PRIMARY KEY (`delivery_group_id`);

--
-- Indexes for table `yvdnsddqu_delivery_history`
--
ALTER TABLE `yvdnsddqu_delivery_history`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yvdnsddqu_delivery_online`
--
ALTER TABLE `yvdnsddqu_delivery_online`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `yvdnsddqu_deliver_checkin`
--
ALTER TABLE `yvdnsddqu_deliver_checkin`
  ADD PRIMARY KEY (`checkin_id`);

--
-- Indexes for table `yvdnsddqu_extensions`
--
ALTER TABLE `yvdnsddqu_extensions`
  ADD PRIMARY KEY (`extension_id`),
  ADD UNIQUE KEY `type` (`type`,`name`);

--
-- Indexes for table `yvdnsddqu_faq`
--
ALTER TABLE `yvdnsddqu_faq`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `yvdnsddqu_favorites`
--
ALTER TABLE `yvdnsddqu_favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yvdnsddqu_feedback`
--
ALTER TABLE `yvdnsddqu_feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yvdnsddqu_keys`
--
ALTER TABLE `yvdnsddqu_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yvdnsddqu_languages`
--
ALTER TABLE `yvdnsddqu_languages`
  ADD PRIMARY KEY (`language_id`);

--
-- Indexes for table `yvdnsddqu_layouts`
--
ALTER TABLE `yvdnsddqu_layouts`
  ADD PRIMARY KEY (`layout_id`);

--
-- Indexes for table `yvdnsddqu_layout_modules`
--
ALTER TABLE `yvdnsddqu_layout_modules`
  ADD PRIMARY KEY (`layout_module_id`);

--
-- Indexes for table `yvdnsddqu_layout_routes`
--
ALTER TABLE `yvdnsddqu_layout_routes`
  ADD PRIMARY KEY (`layout_route_id`);

--
-- Indexes for table `yvdnsddqu_locations`
--
ALTER TABLE `yvdnsddqu_locations`
  ADD PRIMARY KEY (`location_id`);

--
-- Indexes for table `yvdnsddqu_location_tables`
--
ALTER TABLE `yvdnsddqu_location_tables`
  ADD PRIMARY KEY (`location_id`,`table_id`);

--
-- Indexes for table `yvdnsddqu_mail_templates`
--
ALTER TABLE `yvdnsddqu_mail_templates`
  ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `yvdnsddqu_mail_templates_data`
--
ALTER TABLE `yvdnsddqu_mail_templates_data`
  ADD PRIMARY KEY (`template_data_id`,`template_id`,`code`);

--
-- Indexes for table `yvdnsddqu_mealtimes`
--
ALTER TABLE `yvdnsddqu_mealtimes`
  ADD PRIMARY KEY (`mealtime_id`);

--
-- Indexes for table `yvdnsddqu_menus`
--
ALTER TABLE `yvdnsddqu_menus`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `yvdnsddqu_menus_specials`
--
ALTER TABLE `yvdnsddqu_menus_specials`
  ADD PRIMARY KEY (`special_id`,`menu_id`);

--
-- Indexes for table `yvdnsddqu_menu_options`
--
ALTER TABLE `yvdnsddqu_menu_options`
  ADD PRIMARY KEY (`menu_option_id`);

--
-- Indexes for table `yvdnsddqu_menu_option_values`
--
ALTER TABLE `yvdnsddqu_menu_option_values`
  ADD PRIMARY KEY (`menu_option_value_id`);

--
-- Indexes for table `yvdnsddqu_messages`
--
ALTER TABLE `yvdnsddqu_messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `yvdnsddqu_message_meta`
--
ALTER TABLE `yvdnsddqu_message_meta`
  ADD PRIMARY KEY (`message_meta_id`);

--
-- Indexes for table `yvdnsddqu_notifications`
--
ALTER TABLE `yvdnsddqu_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yvdnsddqu_options`
--
ALTER TABLE `yvdnsddqu_options`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `yvdnsddqu_option_values`
--
ALTER TABLE `yvdnsddqu_option_values`
  ADD PRIMARY KEY (`option_value_id`);

--
-- Indexes for table `yvdnsddqu_orders`
--
ALTER TABLE `yvdnsddqu_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `yvdnsddqu_order_menus`
--
ALTER TABLE `yvdnsddqu_order_menus`
  ADD PRIMARY KEY (`order_menu_id`);

--
-- Indexes for table `yvdnsddqu_order_options`
--
ALTER TABLE `yvdnsddqu_order_options`
  ADD PRIMARY KEY (`order_option_id`);

--
-- Indexes for table `yvdnsddqu_order_totals`
--
ALTER TABLE `yvdnsddqu_order_totals`
  ADD PRIMARY KEY (`order_total_id`,`order_id`);

--
-- Indexes for table `yvdnsddqu_pages`
--
ALTER TABLE `yvdnsddqu_pages`
  ADD PRIMARY KEY (`page_id`);

--
-- Indexes for table `yvdnsddqu_permalinks`
--
ALTER TABLE `yvdnsddqu_permalinks`
  ADD PRIMARY KEY (`permalink_id`),
  ADD UNIQUE KEY `uniqueSlug` (`slug`,`controller`);

--
-- Indexes for table `yvdnsddqu_permissions`
--
ALTER TABLE `yvdnsddqu_permissions`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `yvdnsddqu_pp_payments`
--
ALTER TABLE `yvdnsddqu_pp_payments`
  ADD PRIMARY KEY (`transaction_id`);

--
-- Indexes for table `yvdnsddqu_refund`
--
ALTER TABLE `yvdnsddqu_refund`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yvdnsddqu_reservations`
--
ALTER TABLE `yvdnsddqu_reservations`
  ADD PRIMARY KEY (`reservation_id`,`location_id`,`table_id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `yvdnsddqu_reviews`
--
ALTER TABLE `yvdnsddqu_reviews`
  ADD PRIMARY KEY (`review_id`,`sale_type`,`sale_id`);

--
-- Indexes for table `yvdnsddqu_reward_histories`
--
ALTER TABLE `yvdnsddqu_reward_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yvdnsddqu_security_questions`
--
ALTER TABLE `yvdnsddqu_security_questions`
  ADD PRIMARY KEY (`question_id`);

--
-- Indexes for table `yvdnsddqu_settings`
--
ALTER TABLE `yvdnsddqu_settings`
  ADD PRIMARY KEY (`setting_id`),
  ADD UNIQUE KEY `item` (`item`);

--
-- Indexes for table `yvdnsddqu_sms_templates_data`
--
ALTER TABLE `yvdnsddqu_sms_templates_data`
  ADD PRIMARY KEY (`template_data_id`,`code`);

--
-- Indexes for table `yvdnsddqu_staffs`
--
ALTER TABLE `yvdnsddqu_staffs`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `staff_email` (`staff_email`);

--
-- Indexes for table `yvdnsddqu_staffs_commission`
--
ALTER TABLE `yvdnsddqu_staffs_commission`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reservation_id` (`reservation_id`);

--
-- Indexes for table `yvdnsddqu_staff_groups`
--
ALTER TABLE `yvdnsddqu_staff_groups`
  ADD PRIMARY KEY (`staff_group_id`);

--
-- Indexes for table `yvdnsddqu_statuses`
--
ALTER TABLE `yvdnsddqu_statuses`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `yvdnsddqu_status_history`
--
ALTER TABLE `yvdnsddqu_status_history`
  ADD PRIMARY KEY (`status_history_id`);

--
-- Indexes for table `yvdnsddqu_tables`
--
ALTER TABLE `yvdnsddqu_tables`
  ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `yvdnsddqu_uri_routes`
--
ALTER TABLE `yvdnsddqu_uri_routes`
  ADD PRIMARY KEY (`uri_route_id`,`uri_route`);

--
-- Indexes for table `yvdnsddqu_users`
--
ALTER TABLE `yvdnsddqu_users`
  ADD PRIMARY KEY (`user_id`,`staff_id`,`username`);

--
-- Indexes for table `yvdnsddqu_working_hours`
--
ALTER TABLE `yvdnsddqu_working_hours`
  ADD PRIMARY KEY (`location_id`,`weekday`,`type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `yvdnsddqu_activities`
--
ALTER TABLE `yvdnsddqu_activities`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_addresses`
--
ALTER TABLE `yvdnsddqu_addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `yvdnsddqu_admin_payments`
--
ALTER TABLE `yvdnsddqu_admin_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_banners`
--
ALTER TABLE `yvdnsddqu_banners`
  MODIFY `banner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `yvdnsddqu_categories`
--
ALTER TABLE `yvdnsddqu_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `yvdnsddqu_countries`
--
ALTER TABLE `yvdnsddqu_countries`
  MODIFY `country_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

--
-- AUTO_INCREMENT for table `yvdnsddqu_coupons`
--
ALTER TABLE `yvdnsddqu_coupons`
  MODIFY `coupon_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_coupons_history`
--
ALTER TABLE `yvdnsddqu_coupons_history`
  MODIFY `coupon_history_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_currencies`
--
ALTER TABLE `yvdnsddqu_currencies`
  MODIFY `currency_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

--
-- AUTO_INCREMENT for table `yvdnsddqu_customers`
--
ALTER TABLE `yvdnsddqu_customers`
  MODIFY `customer_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `yvdnsddqu_customers_online`
--
ALTER TABLE `yvdnsddqu_customers_online`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `yvdnsddqu_customer_groups`
--
ALTER TABLE `yvdnsddqu_customer_groups`
  MODIFY `customer_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `yvdnsddqu_delivery`
--
ALTER TABLE `yvdnsddqu_delivery`
  MODIFY `delivery_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_delivery_addresses`
--
ALTER TABLE `yvdnsddqu_delivery_addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_delivery_booking`
--
ALTER TABLE `yvdnsddqu_delivery_booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_delivery_groups`
--
ALTER TABLE `yvdnsddqu_delivery_groups`
  MODIFY `delivery_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `yvdnsddqu_delivery_history`
--
ALTER TABLE `yvdnsddqu_delivery_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_delivery_online`
--
ALTER TABLE `yvdnsddqu_delivery_online`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_deliver_checkin`
--
ALTER TABLE `yvdnsddqu_deliver_checkin`
  MODIFY `checkin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_extensions`
--
ALTER TABLE `yvdnsddqu_extensions`
  MODIFY `extension_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `yvdnsddqu_faq`
--
ALTER TABLE `yvdnsddqu_faq`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `yvdnsddqu_favorites`
--
ALTER TABLE `yvdnsddqu_favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_feedback`
--
ALTER TABLE `yvdnsddqu_feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_keys`
--
ALTER TABLE `yvdnsddqu_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `yvdnsddqu_languages`
--
ALTER TABLE `yvdnsddqu_languages`
  MODIFY `language_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `yvdnsddqu_layouts`
--
ALTER TABLE `yvdnsddqu_layouts`
  MODIFY `layout_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_layout_modules`
--
ALTER TABLE `yvdnsddqu_layout_modules`
  MODIFY `layout_module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `yvdnsddqu_layout_routes`
--
ALTER TABLE `yvdnsddqu_layout_routes`
  MODIFY `layout_route_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `yvdnsddqu_locations`
--
ALTER TABLE `yvdnsddqu_locations`
  MODIFY `location_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `yvdnsddqu_mail_templates`
--
ALTER TABLE `yvdnsddqu_mail_templates`
  MODIFY `template_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `yvdnsddqu_mail_templates_data`
--
ALTER TABLE `yvdnsddqu_mail_templates_data`
  MODIFY `template_data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `yvdnsddqu_mealtimes`
--
ALTER TABLE `yvdnsddqu_mealtimes`
  MODIFY `mealtime_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `yvdnsddqu_menus`
--
ALTER TABLE `yvdnsddqu_menus`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `yvdnsddqu_menus_specials`
--
ALTER TABLE `yvdnsddqu_menus_specials`
  MODIFY `special_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `yvdnsddqu_menu_options`
--
ALTER TABLE `yvdnsddqu_menu_options`
  MODIFY `menu_option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `yvdnsddqu_menu_option_values`
--
ALTER TABLE `yvdnsddqu_menu_option_values`
  MODIFY `menu_option_value_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `yvdnsddqu_messages`
--
ALTER TABLE `yvdnsddqu_messages`
  MODIFY `message_id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_message_meta`
--
ALTER TABLE `yvdnsddqu_message_meta`
  MODIFY `message_meta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_notifications`
--
ALTER TABLE `yvdnsddqu_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_options`
--
ALTER TABLE `yvdnsddqu_options`
  MODIFY `option_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `yvdnsddqu_option_values`
--
ALTER TABLE `yvdnsddqu_option_values`
  MODIFY `option_value_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `yvdnsddqu_orders`
--
ALTER TABLE `yvdnsddqu_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_order_menus`
--
ALTER TABLE `yvdnsddqu_order_menus`
  MODIFY `order_menu_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_order_options`
--
ALTER TABLE `yvdnsddqu_order_options`
  MODIFY `order_option_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_order_totals`
--
ALTER TABLE `yvdnsddqu_order_totals`
  MODIFY `order_total_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_pages`
--
ALTER TABLE `yvdnsddqu_pages`
  MODIFY `page_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `yvdnsddqu_permalinks`
--
ALTER TABLE `yvdnsddqu_permalinks`
  MODIFY `permalink_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `yvdnsddqu_permissions`
--
ALTER TABLE `yvdnsddqu_permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `yvdnsddqu_refund`
--
ALTER TABLE `yvdnsddqu_refund`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_reservations`
--
ALTER TABLE `yvdnsddqu_reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_reviews`
--
ALTER TABLE `yvdnsddqu_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `yvdnsddqu_reward_histories`
--
ALTER TABLE `yvdnsddqu_reward_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_security_questions`
--
ALTER TABLE `yvdnsddqu_security_questions`
  MODIFY `question_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `yvdnsddqu_settings`
--
ALTER TABLE `yvdnsddqu_settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21256;

--
-- AUTO_INCREMENT for table `yvdnsddqu_sms_templates_data`
--
ALTER TABLE `yvdnsddqu_sms_templates_data`
  MODIFY `template_data_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_staffs`
--
ALTER TABLE `yvdnsddqu_staffs`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `yvdnsddqu_staffs_commission`
--
ALTER TABLE `yvdnsddqu_staffs_commission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `yvdnsddqu_staff_groups`
--
ALTER TABLE `yvdnsddqu_staff_groups`
  MODIFY `staff_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `yvdnsddqu_statuses`
--
ALTER TABLE `yvdnsddqu_statuses`
  MODIFY `status_id` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `yvdnsddqu_status_history`
--
ALTER TABLE `yvdnsddqu_status_history`
  MODIFY `status_history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `yvdnsddqu_tables`
--
ALTER TABLE `yvdnsddqu_tables`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `yvdnsddqu_uri_routes`
--
ALTER TABLE `yvdnsddqu_uri_routes`
  MODIFY `uri_route_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `yvdnsddqu_users`
--
ALTER TABLE `yvdnsddqu_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
