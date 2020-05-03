-- phpMyAdmin SQL Dump
-- version 5.0.0
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: May 03, 2020 at 10:21 AM
-- Server version: 10.3.21-MariaDB-1:10.3.21+maria~bionic
-- PHP Version: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u898008546_ams`
--

-- --------------------------------------------------------

--
-- Table structure for table `distribution`
--

CREATE TABLE `distribution` (
  `ID` int(11) NOT NULL,
  `SUPPLIESID` int(11) NOT NULL COMMENT 'References the item id on table SUPPLIES',
  `ITEM_DESCRIPTION` varchar(250) NOT NULL COMMENT 'The name of the item (supply/property)',
  `ASSIGNED_QTY` int(11) NOT NULL,
  `ASSIGNED_TO_PERSON` varchar(30) DEFAULT NULL,
  `ASSIGNED_TO_OFFICE` varchar(50) DEFAULT NULL,
  `ASSIGNED_BY` varchar(30) NOT NULL,
  `ASSIGNED_DATE` datetime NOT NULL,
  `ASSIGNED_STATUS` enum('current use','transferred','removed') NOT NULL DEFAULT 'current use',
  `DATECREATED` timestamp NULL DEFAULT current_timestamp(),
  `ACTIVE` tinyint(1) DEFAULT 1,
  `RIS_ITEMS` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `distribution`
--

INSERT INTO `distribution` (`ID`, `SUPPLIESID`, `ITEM_DESCRIPTION`, `ASSIGNED_QTY`, `ASSIGNED_TO_PERSON`, `ASSIGNED_TO_OFFICE`, `ASSIGNED_BY`, `ASSIGNED_DATE`, `ASSIGNED_STATUS`, `DATECREATED`, `ACTIVE`, `RIS_ITEMS`) VALUES
(1, 29, 'ballpoint pen', 10, NULL, '1', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(2, 29, 'ballpoint pen', 15, NULL, '2', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(3, 29, 'ballpoint pen', 10, NULL, '3', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(4, 29, 'ballpoint pen', 15, NULL, '4', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(5, 29, 'ballpoint pen', 15, NULL, '5', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(6, 29, 'ballpoint pen', 10, NULL, '6', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(7, 29, 'ballpoint pen', 10, NULL, '7', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(8, 29, 'ballpoint pen', 10, NULL, '8', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(9, 29, 'ballpoint pen', 25, NULL, '9', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(10, 29, 'ballpoint pen', 15, NULL, '10', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(11, 29, 'ballpoint pen', 15, NULL, '11', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(12, 29, 'ballpoint pen', 25, NULL, '12', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(13, 29, 'ballpoint pen', 15, NULL, '13', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(14, 29, 'ballpoint pen', 15, NULL, '14', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(15, 29, 'ballpoint pen', 15, NULL, '15', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(16, 29, 'ballpoint pen', 15, NULL, '16', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(17, 29, 'ballpoint pen', 15, NULL, '17', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(18, 29, 'ballpoint pen', 15, NULL, '18', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(19, 29, 'ballpoint pen', 25, NULL, '19', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(20, 29, 'ballpoint pen', 15, NULL, '20', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(21, 29, 'ballpoint pen', 15, NULL, '21', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(22, 29, 'ballpoint pen', 15, NULL, '22', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(23, 29, 'ballpoint pen', 15, NULL, '23', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(24, 29, 'ballpoint pen', 15, NULL, '24', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(25, 29, 'ballpoint pen', 15, NULL, '25', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(26, 29, 'ballpoint pen', 10, NULL, '26', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(27, 29, 'ballpoint pen', 15, NULL, '27', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(28, 29, 'ballpoint pen', 15, NULL, '28', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(29, 29, 'ballpoint pen', 15, NULL, '29', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(30, 29, 'ballpoint pen', 15, NULL, '30', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(31, 29, 'ballpoint pen', 20, NULL, '31', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(32, 29, 'ballpoint pen', 10, NULL, '32', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(33, 29, 'ballpoint pen', 15, NULL, '33', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:34:27', 1, 0),
(64, 4, 'bond paper letter', 20, NULL, '1', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(65, 4, 'bond paper letter', 20, NULL, '2', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(66, 4, 'bond paper letter', 20, NULL, '3', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(67, 4, 'bond paper letter', 20, NULL, '4', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(68, 4, 'bond paper letter', 20, NULL, '5', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(69, 4, 'bond paper letter', 20, NULL, '6', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(70, 4, 'bond paper letter', 20, NULL, '7', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(71, 4, 'bond paper letter', 20, NULL, '8', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(72, 4, 'bond paper letter', 20, NULL, '9', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(73, 4, 'bond paper letter', 20, NULL, '10', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(74, 4, 'bond paper letter', 20, NULL, '11', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(75, 4, 'bond paper letter', 20, NULL, '12', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(76, 4, 'bond paper letter', 20, NULL, '13', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(77, 4, 'bond paper letter', 20, NULL, '14', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(78, 4, 'bond paper letter', 20, NULL, '15', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(79, 4, 'bond paper letter', 20, NULL, '16', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(80, 4, 'bond paper letter', 20, NULL, '17', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(81, 4, 'bond paper letter', 20, NULL, '18', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(82, 4, 'bond paper letter', 20, NULL, '19', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(83, 4, 'bond paper letter', 20, NULL, '20', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(84, 4, 'bond paper letter', 20, NULL, '21', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(85, 4, 'bond paper letter', 20, NULL, '22', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(86, 4, 'bond paper letter', 20, NULL, '23', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(87, 4, 'bond paper letter', 20, NULL, '24', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(88, 4, 'bond paper letter', 20, NULL, '25', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(89, 4, 'bond paper letter', 20, NULL, '26', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(90, 4, 'bond paper letter', 20, NULL, '27', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(91, 4, 'bond paper letter', 20, NULL, '28', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(92, 4, 'bond paper letter', 20, NULL, '29', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(93, 4, 'bond paper letter', 20, NULL, '30', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(94, 4, 'bond paper letter', 20, NULL, '31', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(95, 4, 'bond paper letter', 20, NULL, '32', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(96, 4, 'bond paper letter', 20, NULL, '33', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:36:46', 1, 0),
(127, 5, 'bond paper legal', 15, NULL, '1', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(128, 5, 'bond paper legal', 20, NULL, '2', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(129, 5, 'bond paper legal', 20, NULL, '3', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(130, 5, 'bond paper legal', 15, NULL, '4', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(131, 5, 'bond paper legal', 20, NULL, '5', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(132, 5, 'bond paper legal', 15, NULL, '6', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(133, 5, 'bond paper legal', 10, NULL, '7', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(134, 5, 'bond paper legal', 10, NULL, '8', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(135, 5, 'bond paper legal', 30, NULL, '9', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(136, 5, 'bond paper legal', 20, NULL, '10', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(137, 5, 'bond paper legal', 20, NULL, '11', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(138, 5, 'bond paper legal', 30, NULL, '12', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(139, 5, 'bond paper legal', 20, NULL, '13', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(140, 5, 'bond paper legal', 20, NULL, '14', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(141, 5, 'bond paper legal', 20, NULL, '15', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(142, 5, 'bond paper legal', 20, NULL, '16', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(143, 5, 'bond paper legal', 20, NULL, '17', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(144, 5, 'bond paper legal', 20, NULL, '18', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(145, 5, 'bond paper legal', 30, NULL, '19', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(146, 5, 'bond paper legal', 20, NULL, '20', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(147, 5, 'bond paper legal', 20, NULL, '21', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(148, 5, 'bond paper legal', 25, NULL, '22', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(149, 5, 'bond paper legal', 20, NULL, '23', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(150, 5, 'bond paper legal', 20, NULL, '24', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(151, 5, 'bond paper legal', 10, NULL, '25', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(152, 5, 'bond paper legal', 10, NULL, '26', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(153, 5, 'bond paper legal', 20, NULL, '27', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(154, 5, 'bond paper legal', 20, NULL, '28', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(155, 5, 'bond paper legal', 30, NULL, '29', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(156, 5, 'bond paper legal', 30, NULL, '30', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(157, 5, 'bond paper legal', 25, NULL, '31', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(158, 5, 'bond paper legal', 15, NULL, '32', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(159, 5, 'bond paper legal', 20, NULL, '33', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:11', 1, 0),
(190, 6, 'bond paper a4', 20, NULL, '1', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(191, 6, 'bond paper a4', 20, NULL, '2', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(192, 6, 'bond paper a4', 20, NULL, '3', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(193, 6, 'bond paper a4', 20, NULL, '4', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(194, 6, 'bond paper a4', 20, NULL, '5', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(195, 6, 'bond paper a4', 20, NULL, '6', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(196, 6, 'bond paper a4', 20, NULL, '7', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(197, 6, 'bond paper a4', 20, NULL, '8', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(198, 6, 'bond paper a4', 20, NULL, '9', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(199, 6, 'bond paper a4', 20, NULL, '10', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(200, 6, 'bond paper a4', 20, NULL, '11', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(201, 6, 'bond paper a4', 20, NULL, '12', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(202, 6, 'bond paper a4', 20, NULL, '13', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(203, 6, 'bond paper a4', 20, NULL, '14', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(204, 6, 'bond paper a4', 20, NULL, '15', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(205, 6, 'bond paper a4', 20, NULL, '16', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(206, 6, 'bond paper a4', 20, NULL, '17', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(207, 6, 'bond paper a4', 20, NULL, '18', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(208, 6, 'bond paper a4', 20, NULL, '19', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(209, 6, 'bond paper a4', 20, NULL, '20', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(210, 6, 'bond paper a4', 20, NULL, '21', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(211, 6, 'bond paper a4', 20, NULL, '22', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(212, 6, 'bond paper a4', 20, NULL, '23', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(213, 6, 'bond paper a4', 20, NULL, '24', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(214, 6, 'bond paper a4', 20, NULL, '25', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(215, 6, 'bond paper a4', 20, NULL, '26', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(216, 6, 'bond paper a4', 20, NULL, '27', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(217, 6, 'bond paper a4', 20, NULL, '28', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(218, 6, 'bond paper a4', 20, NULL, '29', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(219, 6, 'bond paper a4', 20, NULL, '30', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(220, 6, 'bond paper a4', 20, NULL, '31', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(221, 6, 'bond paper a4', 20, NULL, '32', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(222, 6, 'bond paper a4', 20, NULL, '33', 'E-556-2278', '2016-03-29 00:00:00', 'current use', '2017-04-18 10:38:20', 1, 0),
(223, 8, 'Computer', 20, 'E-340-5800', '1', 'E-427-1140', '2017-06-02 12:00:00', 'current use', '2017-06-02 15:00:19', 1, 0),
(224, 10, 'Laptop', 10, 'E-340-5800', '1', 'E-427-1140', '2017-06-02 12:00:00', 'current use', '2017-06-02 15:52:34', 1, 0),
(225, 13, 'Aircon Window type', 1, 'E-340-5800', '1', 'E-427-1140', '2017-06-21 12:00:00', 'current use', '2017-06-21 05:08:29', 1, 0),
(226, 29, 'Ballpoint pen', 10, NULL, '1', 'E-427-1140', '2017-09-28 12:00:00', 'current use', '2017-09-28 02:16:14', 1, 0),
(227, 5, 'Bond Paper Legal', 1, NULL, '1', 'E-427-1140', '2017-09-28 12:00:00', 'current use', '2017-09-28 02:34:43', 1, 0),
(228, 5, '', 1, NULL, '25', 'E-427-1140', '2020-04-30 07:32:39', 'current use', '2020-04-30 07:32:39', 1, 34);

-- --------------------------------------------------------

--
-- Table structure for table `ics`
--

CREATE TABLE `ics` (
  `ID` int(11) NOT NULL,
  `ICS_NO` varchar(250) DEFAULT NULL,
  `ENTITY_NAME` varchar(250) DEFAULT NULL,
  `FUND_CLUSTER` varchar(250) DEFAULT NULL,
  `RECEIVED_FROM` varchar(250) DEFAULT NULL,
  `RECEIVED_FROM_POSITION` varchar(250) DEFAULT NULL,
  `RECEIVED_FROM_DATE` date DEFAULT NULL,
  `ISSUED_BY` varchar(250) DEFAULT NULL,
  `ISSUED_BY_POSITION` varchar(250) DEFAULT NULL,
  `ISSUED_BY_DATE` date DEFAULT NULL,
  `CREATED_BY` int(11) DEFAULT NULL,
  `CREATED_DATE` timestamp NOT NULL DEFAULT current_timestamp(),
  `MODIFIED_BY` int(11) DEFAULT NULL,
  `MODIFIED_DATE` datetime DEFAULT NULL,
  `ACTIVE` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ics`
--

INSERT INTO `ics` (`ID`, `ICS_NO`, `ENTITY_NAME`, `FUND_CLUSTER`, `RECEIVED_FROM`, `RECEIVED_FROM_POSITION`, `RECEIVED_FROM_DATE`, `ISSUED_BY`, `ISSUED_BY_POSITION`, `ISSUED_BY_DATE`, `CREATED_BY`, `CREATED_DATE`, `MODIFIED_BY`, `MODIFIED_DATE`, `ACTIVE`) VALUES
(1, '2017-03-0009', 'Valencia City', 'Special Account - Locally Funded(151)', 'Ronel T. Cueto', 'State Auditor II', NULL, 'Rosela L. Manalaysay', 'Administrative Officer V', NULL, NULL, '2017-07-24 19:26:23', NULL, NULL, 1),
(2, '2017-03-0010', NULL, 'Special Account - Locally Funded (151)', 'Ronel T. Cueto', 'State Auditor II', '0000-00-00', 'Rosela L. Manalysay', 'Administrative Officer V', '0000-00-00', NULL, '2017-07-24 19:54:15', NULL, NULL, 1),
(3, '234354', NULL, 'Special Account - Locally Funded (151)', '', '', '2018-02-09', '', '', '2018-02-09', NULL, '2018-02-09 13:07:59', NULL, NULL, 1),
(4, 'tewgd', NULL, 'twrt', '', '', '2020-04-30', '', '', '2020-04-30', NULL, '2020-04-30 19:40:19', NULL, NULL, 1),
(5, '313', NULL, '13123', NULL, NULL, '2020-05-02', NULL, NULL, '2020-05-02', NULL, '2020-05-02 21:01:27', NULL, NULL, 1),
(6, '313', NULL, '13123', 'Karen Daguio', 'IT', '2020-07-08', 'Fritz Moran', 'GSO', '2020-06-03', NULL, '2020-05-02 21:09:39', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `par`
--

CREATE TABLE `par` (
  `ID` int(11) NOT NULL,
  `PAR_NO` varchar(250) DEFAULT NULL,
  `ENTITY_NAME` varchar(250) DEFAULT NULL,
  `FUND_CLUSTER` varchar(250) DEFAULT NULL,
  `RECEIVED_BY` varchar(250) DEFAULT NULL,
  `RECEIVED_BY_POSITION` varchar(250) DEFAULT NULL,
  `RECEIVED_BY_DATE` date DEFAULT NULL,
  `ISSUED_BY` varchar(250) DEFAULT NULL,
  `ISSUED_BY_POSITION` varchar(250) DEFAULT NULL,
  `ISSUED_BY_DATE` date DEFAULT NULL,
  `CREATED_BY` int(11) DEFAULT NULL,
  `CREATED_DATE` timestamp NULL DEFAULT current_timestamp(),
  `MODIFIED_BY` int(11) DEFAULT NULL,
  `MODIFIED_DATE` datetime DEFAULT NULL,
  `ACTIVE` int(11) DEFAULT 1,
  `STATUS` int(11) DEFAULT 0 COMMENT '1=assigned; 2=transferred; 3=condemned'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `par`
--

INSERT INTO `par` (`ID`, `PAR_NO`, `ENTITY_NAME`, `FUND_CLUSTER`, `RECEIVED_BY`, `RECEIVED_BY_POSITION`, `RECEIVED_BY_DATE`, `ISSUED_BY`, `ISSUED_BY_POSITION`, `ISSUED_BY_DATE`, `CREATED_BY`, `CREATED_DATE`, `MODIFIED_BY`, `MODIFIED_DATE`, `ACTIVE`, `STATUS`) VALUES
(1, '2017', 'VALENCIA CITY', 'Special Account - Locally Funded (151)', 'Lorenzo M. David', 'Intelligence Officer I', '0000-00-00', 'Rosela L. Manalaysay', 'Administrative Officer V', '0000-00-00', 3, '2017-07-18 01:34:04', NULL, NULL, 0, 2),
(2, '2017-02-0001A', NULL, 'Special Account - Locally Funded (151)', 'Lorenzo M. David', 'Intelligence Officer I', '0000-00-00', 'Rosela L. Manalysay', 'Administrative Officer V', '0000-00-00', NULL, '2017-07-21 19:59:56', NULL, NULL, 0, 2),
(11, NULL, 'City of Valencia', 'Special Account - Locally Funded (151)', NULL, NULL, NULL, NULL, NULL, NULL, 3, '2017-09-13 04:16:16', NULL, NULL, 1, 1),
(14, '2017-02-0001D', NULL, NULL, 'Karen Tags', 'Head', '2017-09-13', 'Rosela L. Manalysay', 'Administrative Officer V', '2017-09-13', NULL, '2017-09-13 06:32:37', NULL, NULL, 1, 2),
(15, '2017-02-0001E', NULL, 'Special Account - Locally Funded (151)', 'Karen Tags', 'Head', '0000-00-00', 'Rosela L. Manalysay', 'Administrative Officer V', '0000-00-00', NULL, '2017-09-13 13:10:18', NULL, NULL, 1, 2),
(19, '2017-02-0001F', NULL, NULL, 'Karen Tags', 'Head', '2017-09-13', 'Rosela L. Manalysay', 'Administrative Officer V', '2017-09-13', 3, '2017-09-13 14:33:19', NULL, NULL, 1, 2),
(20, '2017-02-0001G', NULL, NULL, 'Karen Tags', 'Head', '2017-09-13', 'Rosela L. Manalysay', 'Administrative Officer V', '2017-09-13', 3, '2017-09-13 14:34:27', NULL, NULL, 0, 2),
(22, '2017-02-0001G', NULL, 'Special Account - Locally Funded (151)', 'Karen Tags', 'Head', '2017-09-15', 'Rosela L. Manalysay', 'Administrative Officer V', '2017-09-15', 6, '2017-09-15 03:16:16', NULL, NULL, 1, 0),
(25, '2017-02-0001H', NULL, 'Special Account - Locally Funded (151)', 'Karen Tags', 'Head', '2017-09-15', 'Rosela L. Manalysay', 'Administrative Officer V', '2017-09-15', 6, '2017-09-15 04:20:39', NULL, NULL, 0, 2),
(26, '2017-02-0001I', NULL, 'Special Account - Locally Funded (151)', 'Karen Tags', 'Head', '2017-09-15', 'Rosela L. Manalysay', 'Administrative Officer V', '2017-09-15', 6, '2017-09-15 04:21:45', NULL, NULL, 1, 1),
(27, '2017-02-0001Z', NULL, 'Special Account - Locally Funded (151)', 'Karen Tags', 'Employee', '2017-09-15', 'Rosela L. Manalysay', 'Administrative Officer V', '2017-09-15', 1, '2017-09-15 21:13:41', NULL, NULL, 1, 1),
(28, '2017-02-0001X', NULL, 'Special Account - Locally Funded (151)', 'Karen Tags', 'Employee', '0000-00-00', 'Rosela L. Manalysay', 'Administrative Officer V', '0000-00-00', 1, '2017-09-15 21:32:49', NULL, NULL, 0, 2),
(29, '2017-02-0001V', NULL, 'Special Account - Locally Funded (151)', 'E-427-1140', 'Employee', '2017-09-15', 'Rosela L. Manalysay', 'Administrative Officer V', '2017-09-15', 1, '2017-09-15 21:35:17', NULL, NULL, 1, 1),
(30, '2017-02-0001FBuilding', NULL, 'Special Account - Locally Funded (151) Sample 2018', 'Lorenzo M. Davids', 'Head', '0000-00-00', 'Rosela L. Manalysays', 'Administrative Officer V', '0000-00-00', 1, '2018-02-06 12:41:35', NULL, NULL, 1, 1),
(31, '2017-02-0001B', NULL, 'Special Account - Locally Funded (151)', '', '', '2018-02-09', '', '', '2018-02-09', 1, '2018-02-09 12:39:18', NULL, NULL, 1, 1),
(32, 'e34635', NULL, 'dfgd', '', '', '0000-00-00', '', '', '0000-00-00', 3, '2020-04-30 19:38:48', NULL, NULL, 0, 2),
(33, '23436', NULL, '3646', NULL, NULL, '2020-05-02', NULL, NULL, '2020-05-02', 3, '2020-05-02 21:24:18', NULL, NULL, 1, 0),
(34, '23423', NULL, '3425', 'Karen Daguio', 'IT', '2020-06-03', 'Fritz Moran', 'GSO', '2020-06-03', 3, '2020-05-02 21:26:07', NULL, NULL, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `par_details`
--

CREATE TABLE `par_details` (
  `ID` int(11) NOT NULL,
  `PAR` int(11) DEFAULT NULL,
  `PROPERTY` int(11) DEFAULT NULL,
  `CREATEDBY` int(11) DEFAULT NULL,
  `CREATEDDATE` timestamp NULL DEFAULT current_timestamp(),
  `ACTIVE` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `par_details`
--

INSERT INTO `par_details` (`ID`, `PAR`, `PROPERTY`, `CREATEDBY`, `CREATEDDATE`, `ACTIVE`) VALUES
(1, 11, NULL, NULL, NULL, 1),
(6, 15, 7, NULL, NULL, 0),
(8, 14, 7, NULL, NULL, 0),
(9, 1, 1, NULL, NULL, 0),
(10, 2, 7, NULL, NULL, 0),
(11, 19, 2, 3, '2017-09-13 14:33:33', 0),
(12, 20, 2, 3, '2017-09-13 14:34:37', 0),
(13, 22, 3, 6, '2017-09-15 03:16:42', 1),
(14, 22, 7, 6, '2017-09-15 03:18:34', 1),
(17, 25, 4, 6, '2017-09-15 04:21:04', 0),
(18, 26, 4, 6, '2017-09-15 04:22:07', 1),
(19, 27, 12, 1, '2017-09-15 21:14:31', 1),
(20, 28, 19, 1, '2017-09-15 21:34:17', 0),
(21, 29, 19, 1, '2017-09-15 21:35:36', 1),
(22, 30, 15, 1, '2018-02-06 12:41:41', 1),
(23, 1, 1, 3, '2019-05-03 13:35:23', 0),
(24, 1, 2, 3, '2019-05-03 13:35:50', 1),
(25, 32, 5, 3, '2020-04-30 19:38:56', 1),
(26, 32, 1, 3, '2020-04-30 19:39:01', 0),
(27, 34, 6, 3, '2020-05-02 21:26:21', 0),
(28, 34, 6, 3, '2020-05-02 21:26:30', 1),
(29, 34, 1, 3, '2020-05-02 21:26:47', 1),
(30, 34, 14, 3, '2020-05-02 21:26:56', 0),
(31, 34, 14, 3, '2020-05-02 21:27:47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `ID` int(11) NOT NULL,
  `ARE` int(11) DEFAULT NULL,
  `PROPERTYNO` varchar(150) NOT NULL,
  `ITEMS` int(11) NOT NULL,
  `CATEGORY` varchar(250) DEFAULT NULL,
  `FORM_TYPE` int(11) NOT NULL COMMENT '1=ICS; 2=PAR',
  `CLASSCODE` varchar(50) DEFAULT NULL,
  `DESCRIPTION` varchar(250) NOT NULL,
  `DATEACQUIRED` int(11) NOT NULL,
  `UNITCOST` double NOT NULL,
  `EST_USEFUL_LIFE` float DEFAULT NULL,
  `EUL_UNIT` varchar(30) DEFAULT NULL,
  `CREATEDDATE` timestamp NOT NULL DEFAULT current_timestamp(),
  `CREATEDBY` varchar(50) NOT NULL,
  `MODIFIEDDATE` datetime DEFAULT NULL,
  `MODIFIEDBY` varchar(50) DEFAULT NULL,
  `ACTIVE` bigint(1) NOT NULL DEFAULT 1,
  `QTYONHAND` int(11) DEFAULT NULL,
  `ONQUEUE` tinyint(1) DEFAULT 0,
  `STATUS` int(11) DEFAULT 0 COMMENT '0=unassigned; 1=assigned; 2=transferred; 3=condemned',
  `UNIT` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ris`
--

CREATE TABLE `ris` (
  `ID` int(11) NOT NULL,
  `ENTITY_NAME` varchar(250) DEFAULT NULL,
  `SUPPLIER` varchar(250) DEFAULT NULL,
  `PO_NO` varchar(250) DEFAULT NULL,
  `FUND_CLUSTER` varchar(50) DEFAULT NULL,
  `OFFICES` int(11) NOT NULL,
  `RCC` varchar(30) DEFAULT NULL COMMENT 'Responsibility Center Code',
  `RIS_NO` varchar(30) NOT NULL,
  `PURPOSE` text DEFAULT NULL,
  `REQUESTED_BY` varchar(50) DEFAULT NULL,
  `REQUESTED_DATE` date DEFAULT NULL,
  `REQUESTED_DESIGNATION` varchar(250) DEFAULT NULL,
  `APPROVED_BY` varchar(50) DEFAULT NULL,
  `APPROVED_DATE` date DEFAULT NULL,
  `APPROVED_DESIGNATION` varchar(250) DEFAULT NULL,
  `ISSUED_BY` varchar(50) DEFAULT NULL,
  `ISSUED_DATE` date DEFAULT NULL,
  `ISSUED_DESIGNATION` varchar(250) DEFAULT NULL,
  `RECEIVED_BY` varchar(50) DEFAULT NULL,
  `RECEIVED_DATE` date DEFAULT NULL,
  `RECEIVED_DESIGNATION` varchar(250) DEFAULT NULL,
  `CREATEDDATE` timestamp NOT NULL DEFAULT current_timestamp(),
  `CREATEDBY` varchar(50) NOT NULL,
  `ACTIVE` int(11) NOT NULL DEFAULT 1,
  `NOTED_BY` varchar(250) DEFAULT NULL,
  `POSTED_BY` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ris`
--

INSERT INTO `ris` (`ID`, `ENTITY_NAME`, `SUPPLIER`, `PO_NO`, `FUND_CLUSTER`, `OFFICES`, `RCC`, `RIS_NO`, `PURPOSE`, `REQUESTED_BY`, `REQUESTED_DATE`, `REQUESTED_DESIGNATION`, `APPROVED_BY`, `APPROVED_DATE`, `APPROVED_DESIGNATION`, `ISSUED_BY`, `ISSUED_DATE`, `ISSUED_DESIGNATION`, `RECEIVED_BY`, `RECEIVED_DATE`, `RECEIVED_DESIGNATION`, `CREATEDDATE`, `CREATEDBY`, `ACTIVE`, `NOTED_BY`, `POSTED_BY`) VALUES
(1, '', NULL, NULL, '', 26, 'RCC-00001', 'RIS-00001', 'For computerization', 'Juan Maximo Dela Cruz', '0000-00-00', 'City Budget Office Head', 'Ralph Louie Sarno Cruz', NULL, NULL, '', NULL, NULL, '', NULL, NULL, '2017-05-03 03:42:51', '3', 1, 'Ger', ''),
(2, '', NULL, NULL, '', 1, 'RCC-00002', 'RIS-00002', 'For computerization', 'Juan Maximo Dela Cruz', '2017-05-06', 'Office Head', 'Ralph Louie Sarno Cruz', '2017-05-06', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2017-05-03 03:45:20', '3', 1, NULL, NULL),
(3, '', NULL, NULL, '', 1, 'RCC-00003', 'RIS-00003', 'For computerization', 'Juan Maximo Dela Cruz', '2017-05-06', 'Office Head', 'Ralph Louie Sarno Cruz', '2017-05-06', 'Sample', NULL, NULL, NULL, NULL, NULL, NULL, '2017-05-03 03:46:05', '3', 1, NULL, NULL),
(4, '', NULL, NULL, '', 1, 'RCC-00003', 'RIS-00003', 'For computerization', 'Juan Maximo Dela Cruz', '2017-05-06', 'Office Head', 'Ralph Louie Sarno Cruz', '2017-05-06', 'Sample', 'Karen Tags', NULL, NULL, NULL, NULL, NULL, '2017-05-03 03:46:52', '3', 1, NULL, NULL),
(5, '', NULL, NULL, '', 1, 'RCC-00003', 'RIS-00003', 'For computerization', 'Juan Maximo Dela Cruz', '2017-05-06', 'Office Head', 'Ralph Louie Sarno Cruz', '2017-05-06', 'Sample', 'Karen Tags', '2017-05-06', NULL, NULL, NULL, NULL, '2017-05-03 03:47:29', '3', 1, NULL, NULL),
(6, '', NULL, NULL, '', 1, 'RCC-00003', 'RIS-00003', 'For computerization', 'Juan Maximo Dela Cruz', '2017-05-06', 'Office Head', 'Ralph Louie Sarno Cruz', '2017-05-06', 'Sample', 'Karen Tags', '2017-05-06', 'Office Head', NULL, NULL, NULL, '2017-05-03 03:48:28', '3', 1, NULL, NULL),
(7, '', NULL, NULL, '', 1, 'RCC-00003', 'RIS-00003', 'For computerization', 'Juan Maximo Dela Cruz', '2017-05-06', 'Office Head', 'Ralph Louie Sarno Cruz', '2017-05-06', 'Sample', 'Karen Tags', '2017-05-06', 'Office Head', 'Karen Tags', NULL, NULL, '2017-05-03 03:49:37', '3', 1, NULL, NULL),
(8, '', NULL, NULL, '', 1, 'RCC-00003', 'RIS-00003', 'For computerization', 'Juan Maximo Dela Cruz', '2017-05-06', 'Office Head', 'Ralph Louie Sarno Cruz', '2017-05-06', 'Sample', 'Karen Tags', '2017-05-06', 'Office Head', 'Karen Tags', '2017-05-08', '0', '2017-05-03 03:50:29', '3', 1, NULL, NULL),
(9, '', NULL, NULL, '', 1, 'RCC-00003', 'RIS-00003', 'For computerization', 'Juan Maximo Dela Cruz', '2017-05-06', 'Office Head', 'Ralph Louie Sarno Cruz', '2017-05-06', 'Sample', 'Karen Tags', '2017-05-06', 'Office Head', 'Karen Tags', '2017-05-08', '0', '2017-05-03 03:51:33', '3', 1, NULL, NULL),
(10, '', NULL, NULL, '', 1, 'RCC-00003', 'RIS-00003', 'For computerization', 'Juan Maximo Dela Cruz', '2017-05-06', 'Office Head', 'Ralph Louie Sarno Cruz', '2017-05-06', 'Sample', 'Karen Tags', '2017-05-06', 'Office Head', 'Karen Tags', '2017-05-08', 'Office Head', '2017-05-03 03:52:05', '3', 1, NULL, NULL),
(11, '', NULL, NULL, '', 1, 'RCC-00003', 'RIS-00003', 'For computerization', 'Juan Maximo Dela Cruz', '2017-09-28', 'Office Head', 'Ralph Louie Sarno Cruz', '2017-05-06', 'Sample', 'Karen Tags', '2017-05-08', 'Office Head', 'Karen Tags', '2017-05-08', 'Office Head', '2017-05-03 04:29:27', '3', 1, NULL, NULL),
(12, '', NULL, NULL, '', 2, 'RCC-00001', 'RIS-00003', 'For computerization', 'Juan Maximo Dela Cruz', '2017-09-28', 'Office Head', 'Ralph Louie Sarno Cruz', '2017-06-01', 'Sample', 'Karen Tags', '2017-06-02', 'Office Head', 'Karen Tags', '2017-06-03', 'Office Head', '2017-05-31 02:42:07', '3', 1, NULL, NULL),
(23, NULL, NULL, NULL, NULL, 25, NULL, 'RIS-00001', NULL, '', '0000-00-00', NULL, '', NULL, NULL, '', NULL, NULL, '', NULL, NULL, '2018-02-09 13:10:02', '1', 1, '', ''),
(25, NULL, NULL, NULL, NULL, 0, NULL, 'RIS-000123', NULL, 'Elzhor', '0000-00-00', NULL, 'Lanie', NULL, NULL, '', NULL, NULL, '', NULL, NULL, '2018-02-09 14:09:11', '1', 1, 'Elzhor', ''),
(26, NULL, NULL, NULL, NULL, 0, NULL, 'RIS-000123', NULL, 'Elzhor', '0000-00-00', NULL, 'Lanie', NULL, NULL, '', NULL, NULL, '', NULL, NULL, '2018-02-09 14:09:40', '1', 1, 'Elzhor', ''),
(27, NULL, NULL, NULL, NULL, 0, NULL, 'RIS-00002', NULL, 'Juan Maximo Dela Cruz', '0000-00-00', NULL, 'Karen Daguio', NULL, NULL, '', NULL, NULL, '', NULL, NULL, '2019-05-03 06:22:57', '3', 1, '', ''),
(28, NULL, NULL, NULL, NULL, 0, NULL, 'RIS-00002', NULL, 'Juan Maximo Dela Cruz', '0000-00-00', NULL, 'Karen Daguio', NULL, NULL, '', NULL, NULL, '', NULL, NULL, '2019-05-03 06:24:46', '3', 1, '', ''),
(29, NULL, NULL, NULL, NULL, 0, NULL, 'RIS-00002', NULL, 'Juan Maximo Dela Cruz', '0000-00-00', NULL, 'Karen Daguio', NULL, NULL, '', NULL, NULL, '', NULL, NULL, '2019-05-03 06:24:56', '3', 1, '', ''),
(30, NULL, NULL, NULL, NULL, 0, NULL, 'RIS-00001', NULL, 'Juan Maximo Dela Cruz', '0000-00-00', NULL, 'Ralph Louie Sarno Cruz', NULL, NULL, '', NULL, NULL, '', NULL, NULL, '2019-05-03 09:38:35', '3', 1, '', ''),
(31, NULL, NULL, NULL, NULL, 25, NULL, 'RIS-00001', NULL, 'Juan Maximo Dela Cruz', '0000-00-00', NULL, 'Ralph Louie Sarno Cruz', NULL, NULL, '', NULL, NULL, '', NULL, NULL, '2019-05-03 10:25:04', '3', 1, '', ''),
(43, NULL, NULL, NULL, NULL, 25, NULL, 'RIS-00002', NULL, 'E-427-1140', '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-04-29 06:56:21', 'E-427-1140', 1, NULL, NULL),
(44, NULL, NULL, NULL, NULL, 26, NULL, 'RIS-00003', NULL, 'E-427-1140', '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-04-29 07:00:52', 'E-427-1140', 1, NULL, NULL),
(45, NULL, NULL, NULL, NULL, 9, NULL, 'RIS-00004', NULL, 'E-427-1140', '0000-00-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-04-29 07:08:33', 'E-427-1140', 1, NULL, NULL),
(46, NULL, NULL, NULL, NULL, 27, NULL, 'RIS-00005', NULL, 'E-427-1140', '1970-01-01', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-04-29 07:15:48', 'E-427-1140', 1, NULL, NULL),
(47, NULL, NULL, NULL, NULL, 26, NULL, 'RIS-00006', NULL, 'E-427-1140', '2020-04-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-04-29 07:24:33', 'E-427-1140', 1, NULL, NULL),
(48, NULL, NULL, NULL, NULL, 25, NULL, 'RIS-00007', NULL, 'E-427-1140', '2020-04-30', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2020-04-30 10:26:35', 'E-427-1140', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ris_items`
--

CREATE TABLE `ris_items` (
  `ID` int(11) NOT NULL,
  `RIS_NO` varchar(250) NOT NULL,
  `REQ_STOCK_NO` varchar(50) DEFAULT NULL,
  `REQ_UNIT` varchar(30) DEFAULT NULL,
  `REQ_DESCRIPTION` int(11) DEFAULT NULL COMMENT 'Supply name',
  `REQ_QTY` int(11) DEFAULT NULL,
  `AVAILABILITY` int(11) NOT NULL,
  `ISSUED_QTY` int(11) DEFAULT NULL,
  `ISSUED_REMARKS` varchar(250) DEFAULT NULL,
  `ACTIVE` bit(1) DEFAULT b'1',
  `CREATEDDATE` date NOT NULL,
  `CREATEDBY` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ris_items`
--

INSERT INTO `ris_items` (`ID`, `RIS_NO`, `REQ_STOCK_NO`, `REQ_UNIT`, `REQ_DESCRIPTION`, `REQ_QTY`, `AVAILABILITY`, `ISSUED_QTY`, `ISSUED_REMARKS`, `ACTIVE`, `CREATEDDATE`, `CREATEDBY`) VALUES
(1, '11', '100-001', 'box', 29, 5, 10000000, 220, NULL, b'0', '0000-00-00', ''),
(2, '11', '200-002', 'box', 28, 12, 0, 20, NULL, b'0', '0000-00-00', ''),
(3, '2', '100-001', 'rim', 4, 100, 0, 70, NULL, b'0', '0000-00-00', ''),
(4, '13', '100-001-100-001', 'box', 29, 4, 0, 4, 'SAMPLE', b'1', '0000-00-00', ''),
(5, '13', '100-001-200-001', 'box', 27, 3, 10000000, 3, NULL, b'1', '0000-00-00', ''),
(6, '15', '100-001-100-001', 'box', 29, NULL, 10000000, NULL, NULL, b'1', '0000-00-00', ''),
(7, '16', '100-200-100-002', 'rim', 5, 2, 0, 2, NULL, b'0', '0000-00-00', ''),
(8, '16', '100-200-100-002', 'rim', 5, 4, 0, 4, NULL, b'0', '0000-00-00', ''),
(9, '18', '100-001-300-300', 'box', 36, 5, 10000000, 5, NULL, b'1', '0000-00-00', ''),
(10, '1', '100-001-100-001', 'box', 5, NULL, 10000000, 10, NULL, b'0', '0000-00-00', ''),
(11, '19', '100-001-100-001', 'box', 5, 20, 0, 42, NULL, b'0', '0000-00-00', ''),
(12, '20', '100-001-200-000', NULL, 2, NULL, 0, NULL, NULL, b'1', '0000-00-00', ''),
(13, '21', '100-001-200-000', NULL, 2, NULL, 0, NULL, NULL, b'1', '0000-00-00', ''),
(14, '22', '100-001-100-001', 'box', 29, NULL, 10000000, NULL, NULL, b'1', '0000-00-00', ''),
(15, '4', '100-001-200-002', 'box', 28, NULL, 0, NULL, NULL, b'1', '0000-00-00', ''),
(16, '25', '100-001-100-001', 'box', 29, NULL, 10000000, NULL, NULL, b'1', '0000-00-00', ''),
(17, '27', '100-001-100-001', 'box', 29, NULL, 10000000, NULL, NULL, b'1', '0000-00-00', ''),
(18, '28', '100-001-100-001', 'box', 29, NULL, 10000000, NULL, NULL, b'1', '0000-00-00', ''),
(19, '29', '100-001-100-001', 'box', 29, NULL, 10000000, NULL, NULL, b'1', '0000-00-00', ''),
(20, '29', '100-001-200-002', 'box', 28, NULL, 0, NULL, NULL, b'1', '0000-00-00', ''),
(21, '1', '100-001-100-001', 'box', 29, 10, 0, 5, NULL, b'1', '0000-00-00', ''),
(32, 'RIS-00006', '100-200-100-002', 'rim', 5, NULL, 0, NULL, NULL, b'1', '0000-00-00', ''),
(33, 'RIS-00006', '100-001-100-001', 'box', 29, NULL, 0, NULL, NULL, b'1', '0000-00-00', ''),
(34, 'RIS-00007', '100-200-100-002', 'rim', 5, 1, 0, 1, NULL, b'1', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Table structure for table `supplies`
--

CREATE TABLE `supplies` (
  `ID` int(11) NOT NULL,
  `ITEMS` int(11) NOT NULL,
  `IA_ID` int(11) DEFAULT NULL,
  `UNITCOST` double NOT NULL,
  `QTYACQUIRED` int(11) NOT NULL,
  `DATEACQUIRED` date NOT NULL,
  `QTYONHAND` int(11) NOT NULL,
  `EST_USEFUL_LIFE` float NOT NULL,
  `EUL_UNIT` varchar(30) NOT NULL,
  `SALVAGE_VALUE` double DEFAULT NULL,
  `SUPPLIER` int(11) DEFAULT NULL,
  `ONQUEUE` tinyint(1) NOT NULL DEFAULT 0,
  `CREATEDDATE` timestamp NOT NULL DEFAULT current_timestamp(),
  `CREATEDBY` varchar(50) NOT NULL,
  `MODIFIEDDATE` datetime DEFAULT NULL,
  `MODIFIEDBY` varchar(50) DEFAULT NULL,
  `ACTIVE` bigint(1) NOT NULL DEFAULT 1,
  `QTYSTATUS` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `distribution`
--
ALTER TABLE `distribution`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ics`
--
ALTER TABLE `ics`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `par`
--
ALTER TABLE `par`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `par_details`
--
ALTER TABLE `par_details`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `PROPERTYNO` (`PROPERTYNO`);

--
-- Indexes for table `ris`
--
ALTER TABLE `ris`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `ris_items`
--
ALTER TABLE `ris_items`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `supplies`
--
ALTER TABLE `supplies`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `distribution`
--
ALTER TABLE `distribution`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;

--
-- AUTO_INCREMENT for table `ics`
--
ALTER TABLE `ics`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `par`
--
ALTER TABLE `par`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `par_details`
--
ALTER TABLE `par_details`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ris`
--
ALTER TABLE `ris`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `ris_items`
--
ALTER TABLE `ris_items`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `supplies`
--
ALTER TABLE `supplies`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

