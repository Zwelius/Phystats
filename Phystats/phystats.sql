-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2024 at 03:44 PM
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
-- Database: `phystats`
--

-- --------------------------------------------------------

--
-- Table structure for table `gradesection_tb`
--

CREATE TABLE `gradesection_tb` (
  `grade_ID` int(11) NOT NULL,
  `grade` varchar(5) NOT NULL,
  `section` varchar(25) NOT NULL,
  `teacher_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gradesection_tb`
--

INSERT INTO `gradesection_tb` (`grade_ID`, `grade`, `section`, `teacher_ID`) VALUES
(1, 'Six', 'Integrity', 1);

-- --------------------------------------------------------

--
-- Table structure for table `principal_tb`
--

CREATE TABLE `principal_tb` (
  `principal_ID` int(11) NOT NULL,
  `principal_NAME` varchar(255) NOT NULL,
  `principal_EMAIL` varchar(50) NOT NULL,
  `principal_PASSWORD` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `principal_tb`
--

INSERT INTO `principal_tb` (`principal_ID`, `principal_NAME`, `principal_EMAIL`, `principal_PASSWORD`) VALUES
(1, 'test admin', 'seasideadmin@gmail.com', 'seaside');

-- --------------------------------------------------------

--
-- Table structure for table `quarter_tb`
--

CREATE TABLE `quarter_tb` (
  `quarter_ID` int(11) NOT NULL,
  `quarter` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quarter_tb`
--

INSERT INTO `quarter_tb` (`quarter_ID`, `quarter`) VALUES
(1, '1st Quarter'),
(2, '2nd Quarter'),
(3, '3rd Quarter'),
(4, '4th Quarter');

-- --------------------------------------------------------

--
-- Table structure for table `schoolyear_tb`
--

CREATE TABLE `schoolyear_tb` (
  `schoolyear_ID` int(11) NOT NULL,
  `schoolYEAR` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schoolyear_tb`
--

INSERT INTO `schoolyear_tb` (`schoolyear_ID`, `schoolYEAR`) VALUES
(1, '2023 - 2024'),
(2, '2024 - 2025');

-- --------------------------------------------------------

--
-- Table structure for table `studenttestdata_tb`
--

CREATE TABLE `studenttestdata_tb` (
  `testdata_ID` int(11) NOT NULL,
  `age` int(2) NOT NULL,
  `height` decimal(10,2) NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `BMI` decimal(10,2) NOT NULL,
  `bmiClassification` varchar(20) NOT NULL,
  `HRbefore` decimal(10,2) NOT NULL,
  `HRafter` decimal(10,2) NOT NULL,
  `pushupsNo` int(2) NOT NULL,
  `plankTime` decimal(10,2) NOT NULL,
  `zipperRight` decimal(10,2) NOT NULL,
  `zipperLeft` decimal(10,2) NOT NULL,
  `sitReach1` decimal(10,2) NOT NULL,
  `sitReach2` decimal(10,2) NOT NULL,
  `juggling` int(2) NOT NULL,
  `hexagonClockwise` decimal(10,2) NOT NULL,
  `hexagonCounter` decimal(10,2) NOT NULL,
  `sprintTime` decimal(10,2) NOT NULL,
  `longJump1` decimal(10,2) NOT NULL,
  `longJump2` decimal(10,2) NOT NULL,
  `storkRight` decimal(10,2) NOT NULL,
  `storkLeft` decimal(10,2) NOT NULL,
  `stickDrop1` decimal(10,2) NOT NULL,
  `stickDrop2` decimal(10,2) NOT NULL,
  `stickDrop3` decimal(10,2) NOT NULL,
  `student_ID` int(11) NOT NULL,
  `grade_ID` int(11) NOT NULL,
  `testinfo_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `studenttestresult_tb`
--

CREATE TABLE `studenttestresult_tb` (
  `testresult_ID` int(11) NOT NULL,
  `bodyComposition` varchar(25) NOT NULL,
  `cardiovascularEndurance` varchar(25) NOT NULL,
  `strength` varchar(25) NOT NULL,
  `flexibility` varchar(25) NOT NULL,
  `coordination` varchar(25) NOT NULL,
  `agility` varchar(25) NOT NULL,
  `speed` varchar(25) NOT NULL,
  `power` varchar(25) NOT NULL,
  `balance` varchar(25) NOT NULL,
  `reactionTime` varchar(25) NOT NULL,
  `fitnessResult` varchar(25) NOT NULL,
  `testdata_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_tb`
--

CREATE TABLE `student_tb` (
  `student_ID` int(11) NOT NULL,
  `studentNAME` varchar(100) NOT NULL,
  `studentBIRTHDATE` date NOT NULL,
  `studentSEX` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `teacher_tb`
--

CREATE TABLE `teacher_tb` (
  `teacher_ID` int(11) NOT NULL,
  `teacher_FNAME` varchar(100) NOT NULL,
  `teacher_LNAME` varchar(100) NOT NULL,
  `teacher_EMAIL` varchar(50) NOT NULL,
  `teacher_PASSWORD` varchar(25) NOT NULL,
  `principal_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher_tb`
--

INSERT INTO `teacher_tb` (`teacher_ID`, `teacher_FNAME`, `teacher_LNAME`, `teacher_EMAIL`, `teacher_PASSWORD`, `principal_ID`) VALUES
(1, 'Tests', 'Teachers', 'test@gmail.com', 'test', 1);

-- --------------------------------------------------------

--
-- Table structure for table `testinfo_tb`
--

CREATE TABLE `testinfo_tb` (
  `testinfo_ID` int(11) NOT NULL,
  `teacher_ID` int(11) NOT NULL,
  `schoolyear_ID` int(11) NOT NULL,
  `quarter_ID` int(11) NOT NULL,
  `testtype_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testinfo_tb`
--

INSERT INTO `testinfo_tb` (`testinfo_ID`, `teacher_ID`, `schoolyear_ID`, `quarter_ID`, `testtype_ID`) VALUES
(1, 1, 1, 1, 1),
(2, 1, 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `testtype_tb`
--

CREATE TABLE `testtype_tb` (
  `testtype_ID` int(11) NOT NULL,
  `testTYPE` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testtype_tb`
--

INSERT INTO `testtype_tb` (`testtype_ID`, `testTYPE`) VALUES
(1, 'Pre-Test'),
(2, 'Post-Test');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gradesection_tb`
--
ALTER TABLE `gradesection_tb`
  ADD PRIMARY KEY (`grade_ID`),
  ADD KEY `teacher_ID` (`teacher_ID`);

--
-- Indexes for table `principal_tb`
--
ALTER TABLE `principal_tb`
  ADD PRIMARY KEY (`principal_ID`);

--
-- Indexes for table `quarter_tb`
--
ALTER TABLE `quarter_tb`
  ADD PRIMARY KEY (`quarter_ID`);

--
-- Indexes for table `schoolyear_tb`
--
ALTER TABLE `schoolyear_tb`
  ADD PRIMARY KEY (`schoolyear_ID`);

--
-- Indexes for table `studenttestdata_tb`
--
ALTER TABLE `studenttestdata_tb`
  ADD PRIMARY KEY (`testdata_ID`),
  ADD KEY `student_ID` (`student_ID`),
  ADD KEY `testinfo_ID` (`testinfo_ID`),
  ADD KEY `gradeID` (`grade_ID`);

--
-- Indexes for table `studenttestresult_tb`
--
ALTER TABLE `studenttestresult_tb`
  ADD PRIMARY KEY (`testresult_ID`),
  ADD KEY `testdata_ID` (`testdata_ID`);

--
-- Indexes for table `student_tb`
--
ALTER TABLE `student_tb`
  ADD PRIMARY KEY (`student_ID`);

--
-- Indexes for table `teacher_tb`
--
ALTER TABLE `teacher_tb`
  ADD PRIMARY KEY (`teacher_ID`),
  ADD KEY `principal_ID` (`principal_ID`);

--
-- Indexes for table `testinfo_tb`
--
ALTER TABLE `testinfo_tb`
  ADD PRIMARY KEY (`testinfo_ID`),
  ADD KEY `schoolyear_ID` (`schoolyear_ID`),
  ADD KEY `quarter_ID` (`quarter_ID`),
  ADD KEY `testtype_ID` (`testtype_ID`),
  ADD KEY `teacher_ID` (`teacher_ID`);

--
-- Indexes for table `testtype_tb`
--
ALTER TABLE `testtype_tb`
  ADD PRIMARY KEY (`testtype_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gradesection_tb`
--
ALTER TABLE `gradesection_tb`
  MODIFY `grade_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `principal_tb`
--
ALTER TABLE `principal_tb`
  MODIFY `principal_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quarter_tb`
--
ALTER TABLE `quarter_tb`
  MODIFY `quarter_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schoolyear_tb`
--
ALTER TABLE `schoolyear_tb`
  MODIFY `schoolyear_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `studenttestdata_tb`
--
ALTER TABLE `studenttestdata_tb`
  MODIFY `testdata_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `studenttestresult_tb`
--
ALTER TABLE `studenttestresult_tb`
  MODIFY `testresult_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_tb`
--
ALTER TABLE `student_tb`
  MODIFY `student_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `teacher_tb`
--
ALTER TABLE `teacher_tb`
  MODIFY `teacher_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `testinfo_tb`
--
ALTER TABLE `testinfo_tb`
  MODIFY `testinfo_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `testtype_tb`
--
ALTER TABLE `testtype_tb`
  MODIFY `testtype_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gradesection_tb`
--
ALTER TABLE `gradesection_tb`
  ADD CONSTRAINT `gradesection_tb_ibfk_1` FOREIGN KEY (`teacher_ID`) REFERENCES `teacher_tb` (`teacher_ID`);

--
-- Constraints for table `studenttestdata_tb`
--
ALTER TABLE `studenttestdata_tb`
  ADD CONSTRAINT `studenttestdata_tb_ibfk_1` FOREIGN KEY (`student_ID`) REFERENCES `student_tb` (`student_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `studenttestdata_tb_ibfk_2` FOREIGN KEY (`testinfo_ID`) REFERENCES `testinfo_tb` (`testinfo_ID`),
  ADD CONSTRAINT `studenttestdata_tb_ibfk_3` FOREIGN KEY (`grade_ID`) REFERENCES `gradesection_tb` (`grade_ID`);

--
-- Constraints for table `studenttestresult_tb`
--
ALTER TABLE `studenttestresult_tb`
  ADD CONSTRAINT `studenttestresult_tb_ibfk_1` FOREIGN KEY (`testdata_ID`) REFERENCES `studenttestdata_tb` (`testdata_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `teacher_tb`
--
ALTER TABLE `teacher_tb`
  ADD CONSTRAINT `teacher_tb_ibfk_1` FOREIGN KEY (`principal_ID`) REFERENCES `principal_tb` (`principal_ID`);

--
-- Constraints for table `testinfo_tb`
--
ALTER TABLE `testinfo_tb`
  ADD CONSTRAINT `testinfo_tb_ibfk_1` FOREIGN KEY (`schoolyear_ID`) REFERENCES `schoolyear_tb` (`schoolyear_ID`),
  ADD CONSTRAINT `testinfo_tb_ibfk_2` FOREIGN KEY (`testtype_ID`) REFERENCES `testtype_tb` (`testtype_ID`),
  ADD CONSTRAINT `testinfo_tb_ibfk_3` FOREIGN KEY (`quarter_ID`) REFERENCES `quarter_tb` (`quarter_ID`),
  ADD CONSTRAINT `testinfo_tb_ibfk_4` FOREIGN KEY (`teacher_ID`) REFERENCES `teacher_tb` (`teacher_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
