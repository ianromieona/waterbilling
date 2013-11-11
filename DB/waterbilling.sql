-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 10, 2013 at 12:37 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `waterbilling`
--

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE IF NOT EXISTS `billing` (
  `bill_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `previousUse` int(11) NOT NULL,
  `presentUse` int(11) NOT NULL,
  `billDate` date NOT NULL,
  `dueDate` date NOT NULL,
  `consumption` int(11) NOT NULL,
  `billAmt` int(11) NOT NULL,
  `pricePer` int(11) NOT NULL,
  `savings` float NOT NULL,
  `status` enum('PAID','UNPAID') NOT NULL DEFAULT 'UNPAID',
  PRIMARY KEY (`bill_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`bill_id`, `client_id`, `previousUse`, `presentUse`, `billDate`, `dueDate`, `consumption`, `billAmt`, `pricePer`, `savings`, `status`) VALUES
(4, 10005, 0, 78, '2013-01-27', '2013-01-27', 78, 13354, 171, 0, 'PAID'),
(5, 10002, 103, 105, '2013-03-01', '2013-03-02', 2, 298, 1181, 0, 'PAID'),
(6, 10001, 0, 100, '2013-03-02', '2013-03-03', 100, 372, 372, 0, 'UNPAID');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meter_num` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `middlename` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `contact` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL,
  `connected` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `meter_num`, `firstname`, `lastname`, `middlename`, `address`, `contact`, `status`, `connected`) VALUES
(1, 10001, 'Ian Romie', 'Ona', 'Perez', 'Mataasnakahoy', '9462123110', 'INSTALLED', 'CONNECTED'),
(2, 10002, 'Edbert', 'Guinto', 'Cuevas', 'Lipa', '09812312312', 'INSTALLED', 'CONNECTED'),
(3, 10003, 'Rienier', 'Patron', 'Santos', 'Rosario', '1234567890', 'NOT INSTALLED', 'DISCONNECTED'),
(4, 10004, 'Ariel', 'Moris', 'SingSing', 'Anilao', '34563', 'NOT INSTALLED', 'DISCONNECTED'),
(5, 10005, 'Bhen', 'Lenard', 'Collins', 'Bayorbor', '345678', 'INSTALLED', 'CONNECTED'),
(6, 10006, 'NAsh', 'Fernando', 'Camille', 'Vito cruz', '345534', 'INSTALLED', 'DISCONNECTED'),
(8, 10008, 'Ken', 'PAt', 'T', 'Cuenca', '7686', 'NOT INSTALLED', 'DISCONNECTED');

-- --------------------------------------------------------

--
-- Table structure for table `clientmode`
--

CREATE TABLE IF NOT EXISTS `clientmode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `clientmode`
--

INSERT INTO `clientmode` (`id`, `user`, `password`) VALUES
(1, 10008, '12345'),
(2, 10005, '12345'),
(3, 10009, '123456');

-- --------------------------------------------------------

--
-- Table structure for table `connection`
--

CREATE TABLE IF NOT EXISTS `connection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meter_num` int(11) NOT NULL,
  `date` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=120 ;

--
-- Dumping data for table `connection`
--

INSERT INTO `connection` (`id`, `meter_num`, `date`, `status`) VALUES
(7, 10001, '2013/Jan/25', 'CONNECTED'),
(8, 10001, '2013/Jan/25', 'DISCONNECTED'),
(9, 10001, '2013/Jan/25', 'CONNECTED'),
(10, 10001, '2013/Jan/25', 'DISCONNECTED'),
(11, 10001, '2013/Jan/25', 'CONNECTED'),
(12, 10001, '2013/Jan/25', 'DISCONNECTED'),
(13, 10003, '2013/Jan/25', 'DISCONNECTED'),
(14, 10001, '2013/Jan/25', 'CONNECTED'),
(15, 10001, '2013/Jan/25', 'DISCONNECTED'),
(16, 10001, '2013/Jan/25', 'CONNECTED'),
(17, 10003, '2013/Jan/26', 'CONNECTED'),
(18, 10001, '2013/Jan/26', 'DISCONNECTED'),
(19, 10001, '2013/Jan/26', 'CONNECTED'),
(20, 10001, '2013/Jan/26', 'DISCONNECTED'),
(21, 10001, '2013/Jan/26', 'CONNECTED'),
(22, 10001, '2013/Jan/27', 'DISCONNECTED'),
(23, 10003, '2013/Jan/27', 'DISCONNECTED'),
(24, 10001, '2013/Jan/27', 'CONNECTED'),
(25, 10003, '2013/Jan/27', 'CONNECTED'),
(26, 10001, '2013/Jan/27', 'DISCONNECTED'),
(27, 10001, '2013/Jan/27', 'CONNECTED'),
(28, 10001, '2013/Jan/27', 'DISCONNECTED'),
(29, 10001, '2013/Jan/27', 'CONNECTED'),
(30, 10001, '2013/Jan/27', 'DISCONNECTED'),
(31, 10003, '2013/Jan/27', 'DISCONNECTED'),
(32, 10001, '2013/Jan/27', 'CONNECTED'),
(33, 10003, '2013/Jan/27', 'CONNECTED'),
(34, 10001, '2013/Jan/27', 'DISCONNECTED'),
(35, 10003, '2013/Jan/27', 'DISCONNECTED'),
(36, 10001, '2013/Jan/27', 'CONNECTED'),
(37, 10003, '2013/Jan/27', 'CONNECTED'),
(38, 10001, '2013/Jan/27', 'DISCONNECTED'),
(39, 10003, '2013/Jan/27', 'DISCONNECTED'),
(40, 10001, '2013/Jan/27', 'CONNECTED'),
(41, 10001, '2013/Jan/27', 'DISCONNECTED'),
(42, 10001, '2013/Jan/27', 'CONNECTED'),
(43, 10003, '2013/Jan/27', 'CONNECTED'),
(44, 10001, '2013/Jan/27', 'DISCONNECTED'),
(45, 10001, '2013/Jan/27', 'CONNECTED'),
(46, 10001, '2013/Jan/27', 'DISCONNECTED'),
(47, 10003, '2013/Jan/27', 'DISCONNECTED'),
(48, 10001, '2013/Jan/27', 'CONNECTED'),
(49, 10003, '2013/Jan/27', 'CONNECTED'),
(50, 10001, '2013/Jan/27', 'DISCONNECTED'),
(51, 10001, '2013/Jan/27', 'CONNECTED'),
(52, 10001, '2013/Jan/27', 'DISCONNECTED'),
(53, 10001, '2013/Jan/27', 'CONNECTED'),
(54, 10001, '2013/Jan/27', 'DISCONNECTED'),
(55, 10003, '2013/Jan/27', 'DISCONNECTED'),
(56, 10005, '2013/Jan/27', 'CONNECTED'),
(57, 10005, '2013/Jan/27', 'DISCONNECTED'),
(58, 10002, '2013/Jan/27', 'CONNECTED'),
(59, 10005, '2013/Jan/27', 'CONNECTED'),
(60, 10002, '2013/Jan/27', 'DISCONNECTED'),
(61, 10005, '2013/Jan/27', 'DISCONNECTED'),
(62, 10001, '2013/Jan/27', 'CONNECTED'),
(63, 10001, '2013/Jan/27', 'DISCONNECTED'),
(64, 10001, '2013/Jan/27', 'CONNECTED'),
(65, 10002, '2013/Jan/27', 'CONNECTED'),
(66, 10005, '2013/Jan/27', 'CONNECTED'),
(67, 10001, '2013/Jan/27', 'DISCONNECTED'),
(68, 10002, '2013/Jan/27', 'DISCONNECTED'),
(69, 10001, '2013/Jan/27', 'CONNECTED'),
(70, 10002, '2013/Jan/27', 'CONNECTED'),
(71, 10001, '2013/Jan/27', 'DISCONNECTED'),
(72, 10002, '2013/Jan/27', 'DISCONNECTED'),
(73, 10001, '2013/Jan/27', 'CONNECTED'),
(74, 10002, '2013/Jan/27', 'CONNECTED'),
(75, 10001, '2013/Jan/27', 'DISCONNECTED'),
(76, 10002, '2013/Jan/27', 'DISCONNECTED'),
(77, 10001, '2013/Jan/27', 'CONNECTED'),
(78, 10002, '2013/Jan/27', 'CONNECTED'),
(79, 10001, '2013/Jan/27', 'CONNECTED'),
(80, 10001, '2013/Jan/27', 'CONNECTED'),
(81, 10001, '2013/Jan/27', 'CONNECTED'),
(82, 10002, '2013/Jan/27', 'CONNECTED'),
(83, 10005, '2013/Jan/27', 'CONNECTED'),
(84, 10001, '2013/Jan/27', 'DISCONNECTED'),
(85, 10002, '2013/Jan/27', 'DISCONNECTED'),
(86, 10005, '2013/Jan/27', 'DISCONNECTED'),
(87, 10002, '2013/Jan/27', 'CONNECTED'),
(88, 10001, '2013/Jan/27', 'CONNECTED'),
(89, 10005, '2013/Jan/27', 'CONNECTED'),
(90, 10002, '2013/Jan/27', 'DISCONNECTED'),
(91, 10005, '2013/Jan/27', 'DISCONNECTED'),
(92, 10001, '2013/Jan/27', 'DISCONNECTED'),
(93, 10002, '2013/Jan/27', 'CONNECTED'),
(94, 10001, '2013/Jan/27', 'CONNECTED'),
(95, 10002, '2013/Jan/27', 'DISCONNECTED'),
(96, 10002, '2013/Jan/27', 'CONNECTED'),
(97, 10005, '2013/Jan/27', 'CONNECTED'),
(98, 10005, '2013/Jan/27', 'DISCONNECTED'),
(99, 10001, '2013/Jan/27', 'DISCONNECTED'),
(100, 10005, '2013/Jan/27', 'CONNECTED'),
(101, 10001, '2013/Jan/27', 'CONNECTED'),
(102, 10001, '2013/Jan/27', 'DISCONNECTED'),
(103, 10001, '2013/Jan/27', 'CONNECTED'),
(104, 10001, '2013/Jan/27', 'DISCONNECTED'),
(105, 10002, '2013/Jan/27', 'DISCONNECTED'),
(106, 10002, '2013/Jan/27', 'CONNECTED'),
(107, 10002, '2013/Jan/27', 'DISCONNECTED'),
(108, 10005, '2013/Jan/27', 'DISCONNECTED'),
(109, 10005, '2013/Jan/27', 'CONNECTED'),
(110, 10002, '2013/Jan/27', 'CONNECTED'),
(111, 10001, '2013/Jan/27', 'CONNECTED'),
(112, 10005, '2013/Jan/27', 'DISCONNECTED'),
(113, 10001, '2013/Jan/27', 'DISCONNECTED'),
(114, 10006, '2013/Jan/28', 'CONNECTED'),
(115, 10006, '2013/Jan/28', 'DISCONNECTED'),
(116, 10006, '2013/Jan/28', 'CONNECTED'),
(117, 10006, '2013/Jan/28', 'DISCONNECTED'),
(118, 10005, '2013/Mar/04', 'CONNECTED'),
(119, 10001, '2013/Mar/04', 'CONNECTED');

-- --------------------------------------------------------

--
-- Table structure for table `installation`
--

CREATE TABLE IF NOT EXISTS `installation` (
  `installationId` int(11) NOT NULL AUTO_INCREMENT,
  `dateInstalled` varchar(30) NOT NULL,
  `client` int(11) NOT NULL,
  `meter_id` int(11) NOT NULL,
  PRIMARY KEY (`installationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `installation`
--

INSERT INTO `installation` (`installationId`, `dateInstalled`, `client`, `meter_id`) VALUES
(6, '0', 0, 0),
(13, '2013-01-27', 7, 10005),
(14, '2013-01-14', 14, 10002),
(15, '2013-01-14', 15, 10001),
(16, '2013-01-29', 16, 10006);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `orId` int(11) NOT NULL,
  `billingId` int(11) NOT NULL,
  `date` date NOT NULL,
  `amt` int(11) NOT NULL,
  `payment` int(11) NOT NULL,
  `penalty` int(11) NOT NULL,
  `balance` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`orId`, `billingId`, `date`, `amt`, `payment`, `penalty`, `balance`) VALUES
(1, 1, '2013-01-27', 4041, 100, 0, 4031),
(2, 3, '2013-01-27', 13354, 13354, 0, 12019),
(3, 1, '2013-01-27', 4031, 4031, 0, 3628),
(4, 2, '2013-01-28', 3865, 0, 0, 3865),
(5, 1, '2013-01-27', 3628, 3628, 0, 3265),
(6, 2, '2013-01-28', 3865, 3865, 0, 3479),
(7, 2, '2013-01-28', 3479, 3479, 0, 3131),
(8, 2, '2013-01-28', 3131, 3131, 0, 2818),
(9, 2, '2013-01-28', 2818, 3000, 0, 2518),
(10, 2, '2013-01-28', 2518, 2518, 0, 0),
(11, 3, '2013-01-27', 12019, 12019, 0, 0),
(12, 1, '2013-01-27', 3265, 3265, 0, 0),
(13, 4, '2013-01-27', 13354, 13354, 0, 0),
(14, 5, '2013-02-27', 14166, 16000, 992, 0),
(15, 5, '2013-02-27', 100, 110, 7, 0),
(16, 5, '2013-03-01', 298, 293, 0, 3),
(17, 5, '2013-03-01', 298, 0, 0, 0),
(18, 5, '2013-03-01', 298, 303, 0, 0),
(19, 5, '2013-03-01', 298, 324, 21, 0);

-- --------------------------------------------------------

--
-- Table structure for table `readingvalue`
--

CREATE TABLE IF NOT EXISTS `readingvalue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `readingvalue`
--

INSERT INTO `readingvalue` (`id`, `value`) VALUES
(1, 198),
(2, 20.08),
(3, 22.3),
(4, 24.3),
(5, 26.8),
(6, 2.5),
(7, 7);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`) VALUES
(1, 'Admin', 'admin', 'admin'),
(2, 'Sample sample', 'sample', 'sample'),
(3, 'Edbert Guinto', 'edbert', 'edbert');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
