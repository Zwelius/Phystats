-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2024 at 07:24 PM
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
-- Database: `phystatsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `gradesection`
--

CREATE TABLE `gradesection` (
  `t_id` int(11) NOT NULL DEFAULT 0,
  `grade` varchar(25) NOT NULL DEFAULT '',
  `section` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gradesection`
--

INSERT INTO `gradesection` (`t_id`, `grade`, `section`) VALUES
(1, 'Six', 'Integrity');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `email` varchar(75) NOT NULL,
  `pass` varchar(75) NOT NULL,
  `t_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`email`, `pass`, `t_id`) VALUES
('josh@gmail.com', 'josh', 1);

-- --------------------------------------------------------

--
-- Table structure for table `principal`
--

CREATE TABLE `principal` (
  `p_id` int(11) NOT NULL,
  `name` varchar(75) NOT NULL,
  `email` varchar(75) NOT NULL,
  `pass` varchar(75) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `principal`
--

INSERT INTO `principal` (`p_id`, `name`, `email`, `pass`) VALUES
(1, ' testadmin', 'seasideadmin@gmail.com', 'seasideelemschool');

-- --------------------------------------------------------

--
-- Table structure for table `quarter`
--

CREATE TABLE `quarter` (
  `q_id` int(11) NOT NULL,
  `quarter` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quarter`
--

INSERT INTO `quarter` (`q_id`, `quarter`) VALUES
(1, '1st Quarter'),
(2, '2nd Quarter'),
(3, '3rd Quarter'),
(4, '4th Quarter');

-- --------------------------------------------------------

--
-- Table structure for table `resultinterpretation`
--

CREATE TABLE `resultinterpretation` (
  `resultID` int(11) NOT NULL,
  `tr_ID` int(11) NOT NULL,
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
  `fitnessResult` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resultinterpretation`
--

INSERT INTO `resultinterpretation` (`resultID`, `tr_ID`, `bodyComposition`, `cardiovascularEndurance`, `strength`, `flexibility`, `coordination`, `agility`, `speed`, `power`, `balance`, `reactionTime`, `fitnessResult`) VALUES
(2, 9, 'Normal', 'Excellent', 'Excellent', 'Excellent', 'Good', 'Fair', 'Excellent', 'Needs Improvement', 'Excellent', 'Very Good', 'Physically Fit'),
(5, 11, 'Normal', 'Fair', 'Needs Improvement', 'Good', 'Needs Improvement', 'Fair', 'Needs Improvement', 'Needs Improvement', 'Needs Improvement', 'Fair', 'Not Physically Fit');

-- --------------------------------------------------------

--
-- Table structure for table `schoolyear`
--

CREATE TABLE `schoolyear` (
  `sy_id` int(11) NOT NULL,
  `year` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schoolyear`
--

INSERT INTO `schoolyear` (`sy_id`, `year`) VALUES
(1, '2023 - 2024'),
(2, '2024 - 2025');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `s_id` int(11) NOT NULL,
  `tdID` int(11) NOT NULL,
  `name` varchar(75) NOT NULL,
  `birthdate` date NOT NULL,
  `height` decimal(10,2) NOT NULL,
  `weight` decimal(10,2) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `age` int(11) NOT NULL,
  `BMI` double NOT NULL,
  `nutritional status` varchar(50) NOT NULL,
  `heightforage` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`s_id`, `tdID`, `name`, `birthdate`, `height`, `weight`, `sex`, `age`, `BMI`, `nutritional status`, `heightforage`) VALUES
(11, 1, 'Jugemu Jugemu Gokkoro no Surikke Furaimatsu Unraimatsu Yabrakojji Brakkojji', '2014-11-26', 1.56, 47.00, 'Female', 9, 19.31, 'Normal', 'Normal'),
(13, 1, 'Nico Mark A. Andales', '2012-08-30', 1.48, 55.00, 'Male', 11, 25.11, 'Normal', 'Normal');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE `teacher` (
  `t_id` int(11) NOT NULL,
  `t_fname` varchar(75) NOT NULL,
  `t_lname` varchar(75) NOT NULL,
  `position` varchar(50) NOT NULL,
  `p_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`t_id`, `t_fname`, `t_lname`, `position`, `p_id`) VALUES
(1, 'Josh', 'Ragas', 'Teacher I', 1);

-- --------------------------------------------------------

--
-- Table structure for table `test`
--

CREATE TABLE `test` (
  `testID` int(11) NOT NULL,
  `testtype` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `test`
--

INSERT INTO `test` (`testID`, `testtype`) VALUES
(1, 'Pre-test'),
(2, 'Post-test');

-- --------------------------------------------------------

--
-- Table structure for table `testdate`
--

CREATE TABLE `testdate` (
  `tdID` int(11) NOT NULL,
  `sy_id` int(11) NOT NULL,
  `q_id` int(11) NOT NULL,
  `testID` int(11) NOT NULL,
  `t_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testdate`
--

INSERT INTO `testdate` (`tdID`, `sy_id`, `q_id`, `testID`, `t_id`) VALUES
(1, 1, 1, 1, 1),
(2, 2, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `testresult`
--

CREATE TABLE `testresult` (
  `tr_ID` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `tdID` int(11) NOT NULL,
  `HRbefore` decimal(10,2) NOT NULL,
  `HRafter` decimal(10,2) NOT NULL,
  `pushupsNo` int(11) NOT NULL,
  `plankTime` int(11) NOT NULL,
  `zipperRight` decimal(10,2) NOT NULL,
  `zipperLeft` decimal(10,2) NOT NULL,
  `SaR1` decimal(10,2) NOT NULL,
  `SaR2` decimal(10,2) NOT NULL,
  `juggling` int(11) NOT NULL,
  `hexagonClockwise` int(11) NOT NULL,
  `hexagonCounter` int(11) NOT NULL,
  `sprintTime` decimal(10,2) NOT NULL,
  `SLJ1` decimal(10,2) NOT NULL,
  `SLJ2` decimal(10,2) NOT NULL,
  `storkRight` int(11) NOT NULL,
  `storkLeft` int(11) NOT NULL,
  `stick1` decimal(10,2) NOT NULL,
  `stick2` decimal(10,2) NOT NULL,
  `stick3` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `testresult`
--

INSERT INTO `testresult` (`tr_ID`, `s_id`, `tdID`, `HRbefore`, `HRafter`, `pushupsNo`, `plankTime`, `zipperRight`, `zipperLeft`, `SaR1`, `SaR2`, `juggling`, `hexagonClockwise`, `hexagonCounter`, `sprintTime`, `SLJ1`, `SLJ2`, `storkRight`, `storkLeft`, `stick1`, `stick2`, `stick3`) VALUES
(9, 11, 1, 60.00, 80.00, 25, 60, 5.00, 7.00, 100.00, 94.00, 25, 15, 18, 6.90, 100.00, 98.00, 57, 46, 5.00, 7.80, 9.40),
(11, 13, 1, 96.00, 204.00, 0, 0, 0.10, 10.00, 28.00, 28.00, 1, 23, 16, 13.80, 71.50, 62.10, 3, 2, 0.00, 21.00, 22.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gradesection`
--
ALTER TABLE `gradesection`
  ADD KEY `t_id` (`t_id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD KEY `t_id` (`t_id`);

--
-- Indexes for table `principal`
--
ALTER TABLE `principal`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `quarter`
--
ALTER TABLE `quarter`
  ADD PRIMARY KEY (`q_id`);

--
-- Indexes for table `resultinterpretation`
--
ALTER TABLE `resultinterpretation`
  ADD PRIMARY KEY (`resultID`),
  ADD KEY `tr_ID` (`tr_ID`);

--
-- Indexes for table `schoolyear`
--
ALTER TABLE `schoolyear`
  ADD PRIMARY KEY (`sy_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`s_id`),
  ADD KEY `tdID` (`tdID`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`t_id`),
  ADD KEY `p_id` (`p_id`);

--
-- Indexes for table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`testID`);

--
-- Indexes for table `testdate`
--
ALTER TABLE `testdate`
  ADD PRIMARY KEY (`tdID`),
  ADD KEY `sy_id` (`sy_id`),
  ADD KEY `q_id` (`q_id`),
  ADD KEY `testID` (`testID`),
  ADD KEY `t_id` (`t_id`);

--
-- Indexes for table `testresult`
--
ALTER TABLE `testresult`
  ADD PRIMARY KEY (`tr_ID`),
  ADD KEY `s_id` (`s_id`),
  ADD KEY `tdID` (`tdID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `principal`
--
ALTER TABLE `principal`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `quarter`
--
ALTER TABLE `quarter`
  MODIFY `q_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `resultinterpretation`
--
ALTER TABLE `resultinterpretation`
  MODIFY `resultID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `schoolyear`
--
ALTER TABLE `schoolyear`
  MODIFY `sy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `teacher`
--
ALTER TABLE `teacher`
  MODIFY `t_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `test`
--
ALTER TABLE `test`
  MODIFY `testID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `testdate`
--
ALTER TABLE `testdate`
  MODIFY `tdID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `testresult`
--
ALTER TABLE `testresult`
  MODIFY `tr_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gradesection`
--
ALTER TABLE `gradesection`
  ADD CONSTRAINT `gradesection_ibfk_1` FOREIGN KEY (`t_id`) REFERENCES `teacher` (`t_id`);

--
-- Constraints for table `login`
--
ALTER TABLE `login`
  ADD CONSTRAINT `login_ibfk_1` FOREIGN KEY (`t_id`) REFERENCES `teacher` (`t_id`);

--
-- Constraints for table `resultinterpretation`
--
ALTER TABLE `resultinterpretation`
  ADD CONSTRAINT `resultinterpretation_ibfk_1` FOREIGN KEY (`tr_ID`) REFERENCES `testresult` (`tr_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`tdID`) REFERENCES `testdate` (`tdID`);

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
  ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`p_id`) REFERENCES `principal` (`p_id`);

--
-- Constraints for table `testdate`
--
ALTER TABLE `testdate`
  ADD CONSTRAINT `testdate_ibfk_1` FOREIGN KEY (`testID`) REFERENCES `test` (`testID`),
  ADD CONSTRAINT `testdate_ibfk_2` FOREIGN KEY (`t_id`) REFERENCES `teacher` (`t_id`),
  ADD CONSTRAINT `testdate_ibfk_3` FOREIGN KEY (`sy_id`) REFERENCES `schoolyear` (`sy_id`),
  ADD CONSTRAINT `testdate_ibfk_4` FOREIGN KEY (`q_id`) REFERENCES `quarter` (`q_id`);

--
-- Constraints for table `testresult`
--
ALTER TABLE `testresult`
  ADD CONSTRAINT `testresult_ibfk_1` FOREIGN KEY (`s_id`) REFERENCES `student` (`s_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `testresult_ibfk_2` FOREIGN KEY (`tdID`) REFERENCES `testdate` (`tdID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
