
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
-- Indexes for table `yvdnsddqu_theme_color`
--
ALTER TABLE `yvdnsddqu_theme_color`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables