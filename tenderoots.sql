-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 24, 2018 at 11:19 PM
-- Server version: 5.7.21-0ubuntu0.16.04.1
-- PHP Version: 7.0.25-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tenderoots`
--

-- --------------------------------------------------------

--
-- Table structure for table `children`
--

CREATE TABLE `children` (
  `personPrefix` char(3) NOT NULL,
  `personId` int(11) NOT NULL,
  `childPrefix` char(3) NOT NULL,
  `childId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `children`
--

INSERT INTO `children` (`personPrefix`, `personId`, `childPrefix`, `childId`) VALUES
('REL', 1, 'USR', 1),
('USR', 1, 'REL', 1),
('USR', 1, 'USR', 2),
('USR', 2, 'REL', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fathers`
--

CREATE TABLE `fathers` (
  `personPrefix` char(3) NOT NULL,
  `personId` int(11) NOT NULL,
  `fatherPrefix` char(3) NOT NULL,
  `fatherId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `feed`
--

CREATE TABLE `feed` (
  `id` int(11) NOT NULL,
  `creatorId` int(11) NOT NULL,
  `receiverId` int(11) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` text NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `personId` int(11) NOT NULL,
  `friendId` int(11) NOT NULL,
  `requestDate` date DEFAULT NULL,
  `accepted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `personId` int(11) NOT NULL,
  `personPrefix` char(3) NOT NULL,
  `imageName` varchar(200) NOT NULL,
  `imagePath` varchar(200) NOT NULL,
  `imageDate` date NOT NULL,
  `uploadDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `linked_people`
--

CREATE TABLE `linked_people` (
  `personId` int(11) NOT NULL,
  `linkedPersonId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mothers`
--

CREATE TABLE `mothers` (
  `personPrefix` char(3) NOT NULL,
  `personId` int(11) NOT NULL,
  `motherPrefix` char(3) NOT NULL,
  `motherId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `person_details`
--

CREATE TABLE `person_details` (
  `personPrefix` char(3) NOT NULL,
  `personId` int(11) NOT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `middleNames` varchar(200) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `person_details`
--

INSERT INTO `person_details` (`personPrefix`, `personId`, `firstName`, `lastName`, `middleNames`, `birthday`, `creationDate`) VALUES
('REL', 1, 'Relative', 'One', NULL, NULL, '2018-02-24 23:15:24'),
('REL', 2, 'Relative', 'Two', NULL, NULL, '2018-02-24 23:15:24'),
('USR', 1, 'First', 'User', NULL, NULL, '2018-02-24 23:14:51'),
('USR', 2, 'Second', 'User', NULL, NULL, '2018-02-24 23:14:51'),
('USR', 7, 'Real', 'User', NULL, NULL, '2018-02-25 06:53:35');

-- --------------------------------------------------------

--
-- Table structure for table `relatives`
--

CREATE TABLE `relatives` (
  `id` int(11) NOT NULL,
  `deathDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `relatives`
--

INSERT INTO `relatives` (`id`, `deathDate`) VALUES
(1, '2018-02-06'),
(2, '2018-02-08');

-- --------------------------------------------------------

--
-- Table structure for table `replies`
--

CREATE TABLE `replies` (
  `id` int(11) NOT NULL,
  `feedId` int(11) NOT NULL,
  `creatorId` int(11) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `message` text NOT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `spouses`
--

CREATE TABLE `spouses` (
  `personPrefix` char(3) NOT NULL,
  `personId` int(11) NOT NULL,
  `spousePrefix` char(3) NOT NULL,
  `spouseId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(80) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`) VALUES
(1, 'test@email.com', '123'),
(2, 'second@email.com', '456'),
(7, 'real@email.com', '$2y$10$m0S0xwarsBa.26ilMjKMJu2BxnSvvahYdWDPPwBRYzuwgDersByhS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `children`
--
ALTER TABLE `children`
  ADD PRIMARY KEY (`personPrefix`,`personId`,`childPrefix`,`childId`);

--
-- Indexes for table `fathers`
--
ALTER TABLE `fathers`
  ADD PRIMARY KEY (`personPrefix`,`personId`,`fatherPrefix`,`fatherId`);

--
-- Indexes for table `feed`
--
ALTER TABLE `feed`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`personId`,`friendId`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `linked_people`
--
ALTER TABLE `linked_people`
  ADD PRIMARY KEY (`personId`,`linkedPersonId`);

--
-- Indexes for table `mothers`
--
ALTER TABLE `mothers`
  ADD PRIMARY KEY (`personPrefix`,`personId`,`motherPrefix`,`motherId`);

--
-- Indexes for table `person_details`
--
ALTER TABLE `person_details`
  ADD PRIMARY KEY (`personPrefix`,`personId`);

--
-- Indexes for table `relatives`
--
ALTER TABLE `relatives`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `replies`
--
ALTER TABLE `replies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spouses`
--
ALTER TABLE `spouses`
  ADD PRIMARY KEY (`personPrefix`,`personId`,`spousePrefix`,`spouseId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feed`
--
ALTER TABLE `feed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `relatives`
--
ALTER TABLE `relatives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `replies`
--
ALTER TABLE `replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
