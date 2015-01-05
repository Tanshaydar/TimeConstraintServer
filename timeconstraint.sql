-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 05, 2015 at 10:33 PM
-- Server version: 5.6.21
-- PHP Version: 5.5.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `timeconstraint`
--

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE IF NOT EXISTS `device` (
  `uniqueId` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `deviceName` varchar(50) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `override` enum('EVET','HAYIR') CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `timeStart` datetime DEFAULT NULL,
  `timeEnd` datetime DEFAULT NULL,
  `notes` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `device`
--

INSERT INTO `device` (`uniqueId`, `deviceName`, `override`, `timeStart`, `timeEnd`, `notes`) VALUES
('123sdgas64', 'test device 4 test güncellemesi', 'EVET', '2015-01-04 10:30:42', '2015-01-04 16:30:42', 'Bu bir test cihazıdır 4 test güncellemesi'),
('312fgahf342652', 'Virtual 2', 'HAYIR', NULL, NULL, 'Test amaçlı virtual device 2'),
('3426tafgafg345r', 'test device 1', 'HAYIR', NULL, NULL, 'test device 1'),
('684sdgas64', 'test device 2', 'EVET', '2014-12-12 09:37:59', '2014-12-21 17:24:46', 'Bu bir test cihazıdır'),
('gas1234agfsg', 'Virtual 1', 'HAYIR', NULL, NULL, 'Test amaçlı virtual device 1');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
`gameId` int(11) NOT NULL,
  `gameName` varchar(25) COLLATE utf8_turkish_ci NOT NULL,
  `notes` varchar(250) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`gameId`, `gameName`, `notes`) VALUES
(1, 'Hafıza Oyunu', 'ilk oyun'),
(2, 'Test oyunu 2', 'Test notu 2'),
(3, 'Half Life 2', 'Mobil versiyonu yok'),
(4, 'Resident Evil Revelations', 'Jill Chris'),
(6, 'Silent Hill Homecoming', 'PC XBOX360 PS3'),
(7, 'test 3', 'test 3');

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE IF NOT EXISTS `scores` (
  `device_unique_id` varchar(25) COLLATE utf8_turkish_ci NOT NULL,
  `game_id` int(11) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `scores`
--

INSERT INTO `scores` (`device_unique_id`, `game_id`, `score`) VALUES
('312fgahf342652', 1, 5626),
('gas1234agfsg', 1, 4230),
('684sdgas64', 1, 7896),
('gas1234agfsg', 2, 789600);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`userId` int(10) unsigned NOT NULL,
  `userName` varchar(25) COLLATE utf8_turkish_ci NOT NULL,
  `userPassword` varchar(25) COLLATE utf8_turkish_ci NOT NULL,
  `userAccess` enum('admin','watcher') COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userId`, `userName`, `userPassword`, `userAccess`) VALUES
(1, 'test', 'test', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `zaman`
--

CREATE TABLE IF NOT EXISTS `zaman` (
`id` int(11) NOT NULL,
  `timeStart` datetime NOT NULL,
  `timeEnd` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `zaman`
--

INSERT INTO `zaman` (`id`, `timeStart`, `timeEnd`) VALUES
(1, '2015-01-04 10:30:36', '2015-01-04 16:30:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `device`
--
ALTER TABLE `device`
 ADD PRIMARY KEY (`uniqueId`), ADD UNIQUE KEY `device_unique_id` (`uniqueId`), ADD KEY `device_unique_id_2` (`uniqueId`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
 ADD PRIMARY KEY (`gameId`), ADD KEY `game_id` (`gameId`), ADD KEY `game_id_2` (`gameId`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `zaman`
--
ALTER TABLE `zaman`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
MODIFY `gameId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `userId` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `zaman`
--
ALTER TABLE `zaman`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
