-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 28, 2016 at 08:03 PM
-- Server version: 5.5.44
-- PHP Version: 5.4.45-2+deb.sury.org~precise+2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wp_new`
--

-- --------------------------------------------------------

--
-- Table structure for table `wp_mmi_programs`
--

CREATE TABLE IF NOT EXISTS `wp_mmi_programs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `program_name` varchar(255) NOT NULL,
  `program_description` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `wp_mmi_programs`
--

INSERT INTO `wp_mmi_programs` (`ID`, `program_name`, `program_description`) VALUES
(1, 'AIFTT3', 'This is a test Program.'),
(2, 'AIFTT4', 'This is a test Program.'),
(7, 'test4', 'test4');

-- --------------------------------------------------------

--
-- Table structure for table `wp_mmi_segment`
--

CREATE TABLE IF NOT EXISTS `wp_mmi_segment` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `program_ID` int(11) NOT NULL,
  `segment_name` varchar(255) NOT NULL,
  `segment_description` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `wp_mmi_segment`
--

INSERT INTO `wp_mmi_segment` (`ID`, `program_ID`, `segment_name`, `segment_description`) VALUES
(1, 1, 'AIFTT3  0001 - AIFTT3  0099', 'This is a test'),
(2, 1, 'AIFTT3  0101-AIFTT3  0199', 'this is a test');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
