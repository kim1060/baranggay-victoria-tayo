-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2025 at 04:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appointmate`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_report`
--

CREATE TABLE `admin_report` (
  `AR_ID` int(11) NOT NULL,
  `Category` varchar(45) NOT NULL,
  `Description` text NOT NULL,
  `LinkAddress` text NOT NULL,
  `Year` varchar(45) NOT NULL,
  `Section` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `ID` int(11) NOT NULL,
  `Filename` text NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Details` text NOT NULL,
  `DateCreated` datetime DEFAULT NULL,
  `CreatedBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`ID`, `Filename`, `Title`, `Details`, `DateCreated`, `CreatedBy`) VALUES
(2, 'APP_LOGO2.png', 'APP LOGO', 'This is our system logo.', '2025-01-21 08:23:47', 'admin'),
(3, '664af724-7b32-4f6d-9c81-d45b145c4642.jfif', 'wqeqe', 'qwewqeqwewq', '2025-05-30 02:07:07', 'admin'),
(4, '510fda37-9771-4841-977f-f7c72692f415.jfif', '232131', 'wqeqweqwe', '2025-05-30 02:07:19', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `ID` int(11) NOT NULL,
  `Category` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`ID`, `Category`) VALUES
(1, 'YES'),
(2, 'NO');

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `read` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `chat_messages`
--

INSERT INTO `chat_messages` (`id`, `sender`, `receiver`, `message`, `created_at`, `read`) VALUES
(1, 'kevin', 'admin', 'test', '2025-02-12 03:48:28', 1),
(2, 'admin', 'kevin', 'h', '2025-02-12 03:49:39', 1),
(3, 'kevin', 'admin', 'test', '2025-02-12 05:49:03', 1),
(4, 'kevin', 'admin', 'hello po', '2025-02-13 02:31:32', 1);

-- --------------------------------------------------------

--
-- Table structure for table `civilstatus`
--

CREATE TABLE `civilstatus` (
  `ID` int(11) NOT NULL,
  `CivilStatus` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `civilstatus`
--

INSERT INTO `civilstatus` (`ID`, `CivilStatus`) VALUES
(1, 'Single'),
(2, 'Married'),
(3, 'Widowed');

-- --------------------------------------------------------

--
-- Table structure for table `downloadablefile`
--

CREATE TABLE `downloadablefile` (
  `ID` int(11) NOT NULL,
  `Filename` text NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `financial_report_folder`
--

CREATE TABLE `financial_report_folder` (
  `ID` int(11) NOT NULL,
  `FolderName` varchar(50) NOT NULL,
  `Section` varchar(45) NOT NULL,
  `Category` varchar(45) NOT NULL,
  `Year` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `financial_report_folder`
--

INSERT INTO `financial_report_folder` (`ID`, `FolderName`, `Section`, `Category`, `Year`) VALUES
(12, '2024 - Folder One', 'Budget', 'Monthly', '2024'),
(13, 'asdasd', 'Budget', 'Monthly', '2024'),
(14, 'dddd', 'Accounting', 'Monthly', '2024'),
(16, 'qq', 'Accounting', 'Monthly', '2023'),
(21, 'QMS', 'QMS', 'QMS', 'QMS');

-- --------------------------------------------------------

--
-- Table structure for table `monthlydues`
--

CREATE TABLE `monthlydues` (
  `ID` int(11) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `Details` text NOT NULL,
  `DateCreated` datetime DEFAULT NULL,
  `CreatedBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `monthlydues`
--

INSERT INTO `monthlydues` (`ID`, `Title`, `Details`, `DateCreated`, `CreatedBy`) VALUES
(1, 'test', 'test', '2025-04-25 05:54:10', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `officials`
--

CREATE TABLE `officials` (
  `ID` int(11) NOT NULL,
  `Filename` text NOT NULL,
  `Fullname` varchar(100) NOT NULL,
  `Position` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `officials`
--

INSERT INTO `officials` (`ID`, `Filename`, `Fullname`, `Position`) VALUES
(1, 'ADMIN.png', 'asdas', 'asaadsddda'),
(2, 'logo1.jpg', 'asdas', 'asdasdas'),
(3, 'logo4.jpg', 'asdsa', 'dasdasd');

-- --------------------------------------------------------

--
-- Table structure for table `procurement_tracking`
--

CREATE TABLE `procurement_tracking` (
  `PT_ID` int(11) NOT NULL,
  `Category` varchar(45) NOT NULL,
  `Description` text NOT NULL,
  `LinkAddress` text NOT NULL,
  `Year` varchar(45) NOT NULL,
  `Section` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `procurement_tracking`
--

INSERT INTO `procurement_tracking` (`PT_ID`, `Category`, `Description`, `LinkAddress`, `Year`, `Section`) VALUES
(2, 'Monthly', 'QMS', 'http://localhost:8012/phpmyadmin/index.php?route=/sql&pos=0&db=dilg&table=procurement_tracking', ' 2024', 'QMS');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_test`
--

CREATE TABLE `tbl_test` (
  `ID` int(11) NOT NULL,
  `PNAME` varchar(45) DEFAULT NULL,
  `CATEGORY` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_test`
--

INSERT INTO `tbl_test` (`ID`, `PNAME`, `CATEGORY`) VALUES
(1, 'KEVIN', 'CORP'),
(2, 'KEVIN', 'HMO'),
(3, 'ARMAN', 'CORP');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_type`
--

CREATE TABLE `transaction_type` (
  `ID` int(10) UNSIGNED ZEROFILL NOT NULL,
  `Transaction` varchar(45) DEFAULT NULL,
  `Path` varchar(100) DEFAULT NULL,
  `Img` varchar(45) DEFAULT NULL,
  `ModalID` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transaction_type`
--

INSERT INTO `transaction_type` (`ID`, `Transaction`, `Path`, `Img`, `ModalID`) VALUES
(0000000001, 'Barangay Clearance', 'index.php?view=_clearance', 'IMAGE7.png', '_clearance'),
(0000000002, 'Cedula', 'index.php?view=_cedula', 'IMAGE8.png', '_cedula'),
(0000000003, 'Certificate Of Indigency', 'index.php?view=_indigency', 'IMAGE6.png', '_indigency'),
(0000000004, 'Business Permit', 'index.php?view=_permit', 'IMAGE9.png', '_permit'),
(0000000005, 'Court Booking', 'index.php?view=_court', 'IMAGE10.png', '_court');

-- --------------------------------------------------------

--
-- Table structure for table `usertype`
--

CREATE TABLE `usertype` (
  `UserTypeID` int(11) NOT NULL,
  `UserType` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `usertype`
--

INSERT INTO `usertype` (`UserTypeID`, `UserType`) VALUES
(1, 'ADMIN'),
(2, 'USER');

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `UserID` int(11) NOT NULL,
  `Firstname` varchar(45) NOT NULL,
  `Middlename` varchar(45) DEFAULT NULL,
  `Lastname` varchar(45) NOT NULL,
  `Address` varchar(250) NOT NULL,
  `Age` varchar(45) NOT NULL,
  `Status` varchar(45) NOT NULL,
  `Citizenship` varchar(45) NOT NULL,
  `Email` varchar(45) NOT NULL,
  `Contact` varchar(45) NOT NULL,
  `Username` varchar(45) NOT NULL,
  `Password` varchar(45) NOT NULL,
  `UserType` varchar(45) NOT NULL,
  `VerCode` varchar(45) DEFAULT NULL,
  `IsVerified` tinyint(4) NOT NULL DEFAULT 0,
  `Laman` text DEFAULT NULL,
  `Filename` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`UserID`, `Firstname`, `Middlename`, `Lastname`, `Address`, `Age`, `Status`, `Citizenship`, `Email`, `Contact`, `Username`, `Password`, `UserType`, `VerCode`, `IsVerified`, `Laman`, `Filename`) VALUES
(2, 'Admin', 'e', 'Admin', 'Admin Address', '27', 'Married', 'Filipino', 'reyeskeb17@gmail.com', '09618363774', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'ADMIN', '', 1, '', NULL),
(23, 'John', 'Smith', 'Doe', 'USA', '23', 'Single', 'American', 'john@gmail.com', '09618363774', 'john', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'USER', '574181', 1, '', NULL),
(24, 'Kevin', 'Bariso', 'Reyes', 'Cavite', '27', 'Married', 'Filipino', 'reyeskeb17@gmail.com', '09159205929', 'kevin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'USER', '', 1, ' REPUBLIKA NG PILIPINAS Republic of the PhilippinesPARAEANS NS PAGKAKAKILAPbinpping Identification. card eeS eS ApelyidoLast  Name REYES Ye Mga PangalanGiven Names iKEVIN ZAGitna ng ApelyidoMidale NameBARISOv iiTiptsa ng KapanganakanDate of Birth JANUARY 10 1997TirananAdd pe gs201 MABUHAY oust DON JULIO GREGORIO SAUYO QUEZON ZCITY. NCR SECOND DISTRICT', 'FRONT1.jpg'),
(31, 'JHUNE-ACE', 'PAULAR', 'ACEBRON', 'Cavite', '23', 'Single', 'Filipino', 'reyeskeb17@gmail.com', '09618363774', 'ace', 'd86caede0264d429ed6b1d3fe83ec87a18eed990', 'USER', '493756', 0, 'mREPUBLIC OF THE PHILIPPINESPhilippine Health Insurance Corporation082502934437GALOS MA LOURDES PFEBRUARY 11 2002  FEMALEBLK 79 LOT 60 PUROK 7 VICTORIA REYESeT so2INFORMAL ECONOMY', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `_cedula`
--

CREATE TABLE `_cedula` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Status` varchar(45) DEFAULT NULL,
  `Date` datetime NOT NULL,
  `ConfirmDate` datetime DEFAULT NULL,
  `ApprovedDate` datetime DEFAULT NULL,
  `AppointmentDate` datetime DEFAULT NULL,
  `PaymentReference` varchar(100) DEFAULT NULL,
  `Reason` varchar(100) NOT NULL,
  `CancelDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `_cedula`
--

INSERT INTO `_cedula` (`ID`, `UserID`, `Comment`, `Status`, `Date`, `ConfirmDate`, `ApprovedDate`, `AppointmentDate`, `PaymentReference`, `Reason`, `CancelDate`) VALUES
(1, 24, 'dasd', 'REQUEST FOR CANCEL', '2025-06-30 05:11:17', NULL, NULL, '2025-07-02 00:00:00', NULL, 'sss', '2025-06-30 11:11:17');

-- --------------------------------------------------------

--
-- Table structure for table `_clearance`
--

CREATE TABLE `_clearance` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Status` varchar(45) DEFAULT NULL,
  `Date` datetime NOT NULL,
  `ConfirmDate` datetime DEFAULT NULL,
  `ApprovedDate` datetime DEFAULT NULL,
  `AppointmentDate` datetime DEFAULT NULL,
  `FirstTimeJob` varchar(45) NOT NULL,
  `PaymentReference` varchar(100) DEFAULT NULL,
  `Reason` varchar(100) NOT NULL,
  `CancelDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `_clearance`
--

INSERT INTO `_clearance` (`ID`, `UserID`, `Comment`, `Status`, `Date`, `ConfirmDate`, `ApprovedDate`, `AppointmentDate`, `FirstTimeJob`, `PaymentReference`, `Reason`, `CancelDate`) VALUES
(1, 24, 'For Employment', 'CANCELLED', '2025-05-30 02:34:25', NULL, NULL, '2025-06-03 00:00:00', 'YES', NULL, 'sdadda', '2025-07-10 03:48:36');

-- --------------------------------------------------------

--
-- Table structure for table `_court`
--

CREATE TABLE `_court` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Status` varchar(45) DEFAULT NULL,
  `Date` datetime NOT NULL,
  `ConfirmDate` datetime DEFAULT NULL,
  `ApprovedDate` datetime DEFAULT NULL,
  `AppointmentDate` datetime DEFAULT NULL,
  `FromTime` time NOT NULL,
  `ToTime` time NOT NULL,
  `PaymentReference` varchar(100) DEFAULT NULL,
  `Reason` varchar(100) NOT NULL,
  `CancelDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `_court`
--

INSERT INTO `_court` (`ID`, `UserID`, `Comment`, `Status`, `Date`, `ConfirmDate`, `ApprovedDate`, `AppointmentDate`, `FromTime`, `ToTime`, `PaymentReference`, `Reason`, `CancelDate`) VALUES
(1, 24, 'basketball', 'PENDING', '2025-06-30 05:07:09', NULL, NULL, '2025-07-02 00:00:00', '17:00:00', '21:00:00', NULL, 'ddaaa', '2025-06-30 11:07:09');

-- --------------------------------------------------------

--
-- Table structure for table `_indigency`
--

CREATE TABLE `_indigency` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Status` varchar(45) DEFAULT NULL,
  `Date` datetime NOT NULL,
  `ConfirmDate` datetime DEFAULT NULL,
  `ApprovedDate` datetime DEFAULT NULL,
  `AppointmentDate` datetime DEFAULT NULL,
  `PaymentReference` varchar(100) DEFAULT NULL,
  `Reason` varchar(100) NOT NULL,
  `CancelDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `_indigency`
--

INSERT INTO `_indigency` (`ID`, `UserID`, `Comment`, `Status`, `Date`, `ConfirmDate`, `ApprovedDate`, `AppointmentDate`, `PaymentReference`, `Reason`, `CancelDate`) VALUES
(1, 24, 'test', 'REQUEST FOR CANCEL', '2025-05-30 07:36:34', NULL, NULL, '2025-06-04 00:00:00', NULL, 'sss', '2025-06-30 09:03:44');

-- --------------------------------------------------------

--
-- Table structure for table `_permit`
--

CREATE TABLE `_permit` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Status` varchar(45) DEFAULT NULL,
  `Date` datetime NOT NULL,
  `ConfirmDate` datetime DEFAULT NULL,
  `ApprovedDate` datetime DEFAULT NULL,
  `AppointmentDate` datetime DEFAULT NULL,
  `_permitcol` varchar(45) DEFAULT NULL,
  `PaymentReference` varchar(100) DEFAULT NULL,
  `Reason` varchar(100) NOT NULL,
  `CancelDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `_permit`
--

INSERT INTO `_permit` (`ID`, `UserID`, `Comment`, `Status`, `Date`, `ConfirmDate`, `ApprovedDate`, `AppointmentDate`, `_permitcol`, `PaymentReference`, `Reason`, `CancelDate`) VALUES
(1, 24, 'dasdasdas', 'REQUEST FOR CANCEL', '2025-05-30 07:41:17', NULL, NULL, '2025-06-05 00:00:00', NULL, NULL, 'n', '2025-06-30 09:03:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_report`
--
ALTER TABLE `admin_report`
  ADD PRIMARY KEY (`AR_ID`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `civilstatus`
--
ALTER TABLE `civilstatus`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `downloadablefile`
--
ALTER TABLE `downloadablefile`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `financial_report_folder`
--
ALTER TABLE `financial_report_folder`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `monthlydues`
--
ALTER TABLE `monthlydues`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `officials`
--
ALTER TABLE `officials`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `procurement_tracking`
--
ALTER TABLE `procurement_tracking`
  ADD PRIMARY KEY (`PT_ID`);

--
-- Indexes for table `tbl_test`
--
ALTER TABLE `tbl_test`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `transaction_type`
--
ALTER TABLE `transaction_type`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `usertype`
--
ALTER TABLE `usertype`
  ADD PRIMARY KEY (`UserTypeID`);

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `_cedula`
--
ALTER TABLE `_cedula`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `_clearance`
--
ALTER TABLE `_clearance`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `_court`
--
ALTER TABLE `_court`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `_indigency`
--
ALTER TABLE `_indigency`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `_permit`
--
ALTER TABLE `_permit`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_report`
--
ALTER TABLE `admin_report`
  MODIFY `AR_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `civilstatus`
--
ALTER TABLE `civilstatus`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `downloadablefile`
--
ALTER TABLE `downloadablefile`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `financial_report_folder`
--
ALTER TABLE `financial_report_folder`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `monthlydues`
--
ALTER TABLE `monthlydues`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `officials`
--
ALTER TABLE `officials`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `procurement_tracking`
--
ALTER TABLE `procurement_tracking`
  MODIFY `PT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_test`
--
ALTER TABLE `tbl_test`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaction_type`
--
ALTER TABLE `transaction_type`
  MODIFY `ID` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `usertype`
--
ALTER TABLE `usertype`
  MODIFY `UserTypeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `_cedula`
--
ALTER TABLE `_cedula`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `_clearance`
--
ALTER TABLE `_clearance`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `_court`
--
ALTER TABLE `_court`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `_indigency`
--
ALTER TABLE `_indigency`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `_permit`
--
ALTER TABLE `_permit`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
