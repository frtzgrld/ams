-- phpMyAdmin SQL Dump
-- version 5.0.0
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Apr 13, 2020 at 05:05 PM
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
CREATE DATABASE IF NOT EXISTS `u898008546_ams` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `u898008546_ams`;

-- --------------------------------------------------------

--
-- Table structure for table `access_rights`
--

CREATE TABLE `access_rights` (
  `ID` int(11) NOT NULL,
  `TCODE` varchar(50) NOT NULL,
  `APPROVAL` tinyint(1) NOT NULL DEFAULT 0,
  `ROLECODE` varchar(50) NOT NULL,
  `ACTIVE` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `access_rights` (`ID`, `TCODE`, `APPROVAL`, `ROLECODE`, `ACTIVE`) VALUES
(4, 'CARE', 0, 'UG1000', 1),
(15, 'CINVE', 0, 'UG1000', 1),
(16, 'CITEM', 0, 'UG1000', 1),
(22, 'COFFC', 0, 'UG1000', 1),
(23, 'CPAR', 0, 'UG1000', 1),
(24, 'CPEEQ', 0, 'UG1000', 1),
(31, 'CRIS', 0, 'UG1000', 1),
(33, 'CSUP', 0, 'UG1000', 1),
(35, 'CUSER', 0, 'UG1000', 1),
(40, 'DARE', 0, 'UG1000', 1),
(51, 'DINVE', 0, 'UG1000', 1),
(52, 'DITEM', 0, 'UG1000', 1),
(56, 'DOFFC', 0, 'UG1000', 1),
(57, 'DPAR', 0, 'UG1000', 1),
(58, 'DPEEQ', 0, 'UG1000', 1),
(65, 'DRIS', 0, 'UG1000', 1),
(67, 'DSUP', 0, 'UG1000', 1),
(69, 'DUSER', 0, 'UG1000', 1),
(74, 'PARE', 0, 'UG1000', 1),
(84, 'PINVE', 0, 'UG1000', 1),
(85, 'PITEM', 0, 'UG1000', 1),
(89, 'POFFC', 0, 'UG1000', 1),
(90, 'PPAR', 0, 'UG1000', 1),
(91, 'PPEEQ', 0, 'UG1000', 1),
(98, 'PRIS', 0, 'UG1000', 1),
(100, 'PSUP', 0, 'UG1000', 1),
(102, 'PUSER', 0, 'UG1000', 1),
(107, 'RARE', 0, 'UG1000', 1),
(118, 'RINVE', 0, 'UG1000', 1),
(119, 'RITEM', 0, 'UG1000', 1),
(123, 'ROFFC', 0, 'UG1000', 1),
(124, 'RPAR', 0, 'UG1000', 1),
(125, 'RPEEQ', 0, 'UG1000', 1),
(132, 'RRIS', 0, 'UG1000', 1),
(134, 'RSUP', 0, 'UG1000', 1),
(136, 'RSYST', 0, 'UG1000', 1),
(137, 'RUSER', 0, 'UG1000', 1),
(142, 'UARE', 0, 'UG1000', 1),
(153, 'UINVE', 0, 'UG1000', 1),
(154, 'UITEM', 0, 'UG1000', 1),
(158, 'UOFFC', 0, 'UG1000', 1),
(159, 'UPAR', 0, 'UG1000', 1),
(160, 'UPEEQ', 0, 'UG1000', 1),
(167, 'URIS', 0, 'UG1000', 1),
(169, 'USUP', 0, 'UG1000', 1),
(171, 'UUSER', 0, 'UG1000', 1);

-- --------------------------------------------------------

--
-- Table structure for table `distribution`
--

CREATE TABLE `distribution` (
  `ID` int(11) NOT NULL,
  `ITEMS` int(11) NOT NULL COMMENT 'References the item id on table SUPPLIES',
  `ITEM_DESCRIPTION` varchar(250) NOT NULL COMMENT 'The name of the item (supply/property)',
  `ASSIGNED_QTY` int(11) NOT NULL,
  `ASSIGNED_TO_PERSON` varchar(30) DEFAULT NULL,
  `ASSIGNED_TO_OFFICE` varchar(50) DEFAULT NULL,
  `ASSIGNED_BY` varchar(30) NOT NULL,
  `ASSIGNED_DATE` datetime NOT NULL,
  `ASSIGNED_STATUS` enum('current use','transferred','removed') NOT NULL DEFAULT 'current use',
  `DATECREATED` timestamp NULL DEFAULT current_timestamp(),
  `ACTIVE` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_custodian_slip`
--

CREATE TABLE `inventory_custodian_slip` (
  `ID` int(11) NOT NULL,
  `ICS_NO` varchar(30) NOT NULL,
  `RECEIVEDBY_NAME` varchar(50) DEFAULT NULL,
  `RECEIVEDBY_DATE` date DEFAULT NULL,
  `RECEIVEDBY_POSITION` varchar(250) DEFAULT NULL,
  `RECEIVEDFROM_NAME` varchar(50) DEFAULT NULL,
  `RECEIVEDFROM_DATE` date DEFAULT NULL,
  `RECEIVEDFROM_POSITION` varchar(250) DEFAULT NULL,
  `CREATEDDATE` timestamp NOT NULL DEFAULT current_timestamp(),
  `CREATEDBY` varchar(50) NOT NULL,
  `ACTIVE` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `ID` int(11) NOT NULL,
  `CODE` varchar(25) NOT NULL,
  `DESCRIPTION` varchar(250) NOT NULL,
  `UNIT` varchar(25) DEFAULT NULL,
  `PARENT` int(11) NOT NULL,
  `MINQTY` int(11) DEFAULT NULL,
  `MAXQTY` int(11) DEFAULT NULL,
  `CATEGORY` enum('property','supply','other') NOT NULL,
  `CREATEDDATE` timestamp NOT NULL DEFAULT current_timestamp(),
  `CREATEDBY` varchar(50) NOT NULL,
  `MODIFIEDDATE` datetime DEFAULT NULL,
  `MODIFIEDBY` varchar(50) DEFAULT NULL,
  `ACTIVE` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `offices`
--

CREATE TABLE `offices` (
  `ID` int(11) NOT NULL,
  `CODE` varchar(50) DEFAULT NULL,
  `CATEGORY` int(11) DEFAULT NULL,
  `DESCRIPTION` varchar(250) NOT NULL,
  `ACRONYM` varchar(50) DEFAULT NULL,
  `PARENT` int(11) DEFAULT NULL,
  `RANK` int(11) DEFAULT NULL COMMENT 'Determines the order for the purpose of responsibility center',
  `AIP_ORDER` int(11) DEFAULT NULL,
  `HAS_PPMP` tinyint(1) DEFAULT NULL,
  `CREATEDDATE` timestamp NOT NULL DEFAULT current_timestamp(),
  `CREATEDBY` varchar(50) NOT NULL,
  `MODIFIEDDATE` datetime DEFAULT NULL,
  `MODIFIEDBY` varchar(50) DEFAULT NULL,
  `ACTIVE` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `office_heads`
--

CREATE TABLE `office_heads` (
  `ID` int(11) NOT NULL,
  `OFFICE` int(11) NOT NULL,
  `TERM_FROM` date DEFAULT NULL,
  `TERM_TO` date DEFAULT NULL,
  `FULLNAME` varchar(250) DEFAULT NULL,
  `DESIGNATION` varchar(250) DEFAULT NULL,
  `CREATEDBY` varchar(30) DEFAULT NULL,
  `CREATEDDATE` timestamp NOT NULL DEFAULT current_timestamp(),
  `FLAG` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `ACTIVE` int(11) NOT NULL,
  `NOTED_BY` varchar(250) DEFAULT NULL,
  `POSTED_BY` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ris_items`
--

CREATE TABLE `ris_items` (
  `ID` int(11) NOT NULL,
  `RIS` int(11) NOT NULL,
  `REQ_STOCK_NO` varchar(50) DEFAULT NULL,
  `REQ_UNIT` varchar(30) DEFAULT NULL,
  `REQ_DESCRIPTION` int(11) DEFAULT NULL COMMENT 'Supply name',
  `REQ_QTY` int(11) DEFAULT NULL,
  `AVAILABILITY` int(11) NOT NULL,
  `ISSUED_QTY` int(11) DEFAULT NULL,
  `ISSUED_REMARKS` varchar(250) DEFAULT NULL,
  `ACTIVE` bit(1) DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `ID` int(11) NOT NULL,
  `ITEMS` int(11) NOT NULL,
  `NO_OF_STOCKS` float(11,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supplies`
--

CREATE TABLE `supplies` (
  `ID` int(11) NOT NULL,
  `ITEMS` int(11) NOT NULL,
  `IA_ID` int(11) DEFAULT NULL,
  `UNIT` varchar(30) DEFAULT NULL,
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
  `ACTIVE` bigint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transaction_codes`
--

CREATE TABLE `transaction_codes` (
  `ID` int(11) NOT NULL,
  `MODULE` varchar(150) NOT NULL,
  `TCODE` varchar(25) NOT NULL,
  `OPERATION` enum('C','R','U','D','A','I','P') NOT NULL,
  `DESCRIPTION` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `USER_GROUP` int(11) NOT NULL,
  `EMPLOYEENO` varchar(50) NOT NULL,
  `FIRSTNAME` varchar(50) NOT NULL,
  `MIDDLENAME` varchar(50) DEFAULT NULL,
  `LASTNAME` varchar(50) NOT NULL,
  `USERNAME` varchar(20) NOT NULL,
  `PASSWORD` varchar(100) NOT NULL,
  `USER_OFFICES` int(11) NOT NULL,
  `LASTLOGIN` timestamp NULL DEFAULT NULL,
  `ACTIVE` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE `user_group` (
  `ID` int(11) NOT NULL,
  `CODE` varchar(50) NOT NULL,
  `DESCRIPTION` varchar(250) NOT NULL,
  `ACTIVE` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_offices`
--

CREATE TABLE `user_offices` (
  `ID` int(11) NOT NULL,
  `USERS` int(11) NOT NULL,
  `OFFICES` int(11) NOT NULL,
  `DESIGNATION` varchar(250) DEFAULT NULL,
  `ACTIVE` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_rights`
--
ALTER TABLE `access_rights`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `inventory_custodian_slip`
--
ALTER TABLE `inventory_custodian_slip`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `offices`
--
ALTER TABLE `offices`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `office_heads`
--
ALTER TABLE `office_heads`
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
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `supplies`
--
ALTER TABLE `supplies`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `transaction_codes`
--
ALTER TABLE `transaction_codes`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `IX_TCODE` (`TCODE`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_offices`
--
ALTER TABLE `user_offices`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_rights`
--
ALTER TABLE `access_rights`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_custodian_slip`
--
ALTER TABLE `inventory_custodian_slip`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offices`
--
ALTER TABLE `offices`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `office_heads`
--
ALTER TABLE `office_heads`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `par`
--
ALTER TABLE `par`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `par_details`
--
ALTER TABLE `par_details`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ris`
--
ALTER TABLE `ris`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ris_items`
--
ALTER TABLE `ris_items`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supplies`
--
ALTER TABLE `supplies`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction_codes`
--
ALTER TABLE `transaction_codes`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_group`
--
ALTER TABLE `user_group`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_offices`
--
ALTER TABLE `user_offices`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

