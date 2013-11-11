-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 26, 2013 at 11:22 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


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
  `status` enum('PAID','UNPAID') NOT NULL DEFAULT 'UNPAID',
  PRIMARY KEY (`bill_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`bill_id`, `client_id`, `previousUse`, `presentUse`, `billDate`, `dueDate`, `consumption`, `billAmt`, `pricePer`, `status`) VALUES
(1, 3, 0, 23, '2013-01-27', '2013-01-27', 23, 4031, 176, 'UNPAID'),
(2, 3, 23, 45, '2013-01-27', '2013-01-28', 22, 3865, 176, 'UNPAID'),
(3, 1, 0, 78, '2013-01-27', '2013-01-27', 78, 13354, 171, 'UNPAID');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `meter_num`, `firstname`, `lastname`, `middlename`, `address`, `contact`, `status`, `connected`) VALUES
(1, 1001, 'Ian Romie', 'Ona', 'Perez', 'Mataasnakahoy', '9462123110', 'INSTALLED', 'CONNECTED'),
(2, 1002, 'Edbert', 'Guinto', 'Cuevas', 'Lipa', '09812312312', 'NOT INSTALLED', ''),
(3, 1003, 'Rienier', 'Patron', 'Santos', 'Rosario', '1234567890', 'INSTALLED', 'CONNECTED'),
(4, 1004, 'Ariel', 'Moris', 'SingSing', 'Anilao', '34563', 'NOT INSTALLED', 'DISCONNECTED'),
(5, 1005, 'Bhen', 'Lenard', 'Collins', 'Bayorbor', '345678', 'NOT INSTALLED', 'DISCONNECTED');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `connection`
--

INSERT INTO `connection` (`id`, `meter_num`, `date`, `status`) VALUES
(7, 1001, '2013/Jan/25', 'CONNECTED'),
(8, 1001, '2013/Jan/25', 'DISCONNECTED'),
(9, 1001, '2013/Jan/25', 'CONNECTED'),
(10, 1001, '2013/Jan/25', 'DISCONNECTED'),
(11, 1001, '2013/Jan/25', 'CONNECTED'),
(12, 1001, '2013/Jan/25', 'DISCONNECTED'),
(13, 1003, '2013/Jan/25', 'DISCONNECTED'),
(14, 1001, '2013/Jan/25', 'CONNECTED'),
(15, 1001, '2013/Jan/25', 'DISCONNECTED'),
(16, 1001, '2013/Jan/25', 'CONNECTED'),
(17, 1003, '2013/Jan/26', 'CONNECTED'),
(18, 1001, '2013/Jan/26', 'DISCONNECTED'),
(19, 1001, '2013/Jan/26', 'CONNECTED'),
(20, 1001, '2013/Jan/26', 'DISCONNECTED'),
(21, 1001, '2013/Jan/26', 'CONNECTED');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `installation`
--

INSERT INTO `installation` (`installationId`, `dateInstalled`, `client`, `meter_id`) VALUES
(6, '0', 0, 0),
(11, '2012-02-02', 6, 1001),
(12, '2014-02-02', 12, 1003);

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
(1, 1, '2013-01-27', 4041, 100, 0, 4031);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
