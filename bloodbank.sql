-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2018 at 12:43 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bloodbank`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `parent` int(11) NOT NULL,
  `Ordring` int(11) DEFAULT NULL,
  `Visibility` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'to hide the catigoris',
  `Allow_comm` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'to allow the comments ',
  `Allow_adver` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'to allow the advertises'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `Name`, `Description`, `parent`, `Ordring`, `Visibility`, `Allow_comm`, `Allow_adver`) VALUES
(1, 'mobile phone', 'new mopile phone', 0, 0, 0, 0, 0),
(5, 'nokia', 'nokia phone', 1, 20, 0, 0, 0),
(6, 'black bery', 'its easy mobile ', 1, 20, 0, 0, 0),
(7, 'fans', 'its fans easy', 9, 55, 1, 1, 1),
(9, 'electronic', 'its nice electronicand attractive', 0, 55, 0, 0, 0),
(10, 'games', 'its funny games', 0, 10, 1, 1, 0),
(11, 'furniture', 'its nice furnitureand attractive', 0, 0, 0, 0, 0),
(12, 'nokia phone', 'its mobile phone easy', 1, 120, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `comment_date` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `status`, `comment_date`, `item_id`, `user_id`) VALUES
(1, 'that wonderful home page ', 0, '2017-08-04', 7, 13),
(2, 'hello my friend', 0, '2017-08-06', 8, 13),
(3, 'efw3rgtgth', 0, '2017-08-07', 9, 13),
(4, 'I am Hesham tarek Programmer\r\n', 0, '2017-10-21', 8, 1),
(5, 'ssssssssssssssssss\r\n', 0, '2018-01-26', 9, 21),
(6, 'ahla w shla\r\n', 0, '2018-01-26', 9, 21),
(7, '..., m n nhvhbmn', 0, '2018-01-26', 7, 21),
(8, 'good\r\n', 0, '2018-02-26', 10, 22),
(9, 'it very good\r\n', 0, '2018-02-26', 10, 22);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `request_id` int(11) NOT NULL,
  `pation_name` varchar(255) NOT NULL,
  `hospital_name` varchar(255) NOT NULL,
  `phone_number` text NOT NULL,
  `blood_type` int(11) NOT NULL,
  `avatar` varchar(200) NOT NULL,
  `Rating` smallint(6) NOT NULL,
  `Approve` tinyint(4) NOT NULL DEFAULT '0',
  `Member_id` int(11) NOT NULL,
  `add_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`request_id`, `pation_name`, `hospital_name`, `phone_number`, `blood_type`, `avatar`, `Rating`, `Approve`, `Member_id`, `add_date`) VALUES
(3, 'سالي السد', 'العبور', '0120125879897', 8, '', 0, 0, 2, '2018-04-11 00:00:00'),
(6, 'مصطفي علي ', 'الجامعه', '0120015554', 8, '', 0, 0, 1, '2018-04-07 21:35:16'),
(10, 'علي السيد', 'النزهه', '1126272062', 8, '', 0, 0, 1, '2018-04-07 22:08:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL COMMENT 'to identify user',
  `Username` varchar(255) NOT NULL COMMENT 'user to log in',
  `Password` varchar(255) NOT NULL COMMENT 'password to log in ',
  `Email` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT '0' COMMENT 'to identify the user or admin ',
  `phone` varchar(200) NOT NULL DEFAULT '0' COMMENT 'phone  number',
  `region` int(11) NOT NULL DEFAULT '0' COMMENT 'region of request',
  `Cur_date` datetime NOT NULL,
  `last_doniation` int(11) NOT NULL,
  `gender` int(11) NOT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `Password`, `Email`, `age`, `GroupID`, `phone`, `region`, `Cur_date`, `last_doniation`, `gender`, `avatar`) VALUES
(1, 'هشام طارق', 'bee522cf378eaf9d787488b3153541b8ce77db03', 'htarek@yahoo.com', 25, 1, '(002) 01126272062', 10, '2018-03-31 00:02:55', 1, 1, ''),
(2, 'محمد هشام احمد', 'bee522cf378eaf9d787488b3153541b8ce77db03', 'htarek@yahoo.com', 25, 0, '00201126272062', 1, '2018-03-31 22:36:16', 4, 0, ''),
(4, 'سالي عبد السلام ابراهيم', '340c495522a681b6e0e14924746cc7165bd291e1', 'sally@yahoo.com', 0, 0, '0', 0, '2018-04-06 19:13:16', 4, 0, '854462_13658856_1596878633944991_1257657725_n.jpg'),
(5, 'ابراهيم السيد علي', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'hima@yahoo.com', 255, 0, '1126272062', 0, '2018-04-07 23:52:52', 4, 1, '116058_pation.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `comment_items` (`item_id`),
  ADD KEY `comment_user` (`user_id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `member_1` (`Member_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'to identify user', AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `request`
--
ALTER TABLE `request`
  ADD CONSTRAINT `members` FOREIGN KEY (`Member_id`) REFERENCES `users` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
