-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 21, 2019 at 12:34 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `liftdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `church`
--

CREATE TABLE `church` (
  `ChurchID` int(16) NOT NULL,
  `ChurchName` varchar(64) NOT NULL,
  `Address` varchar(96) NOT NULL,
  `Pastor` varchar(64) NOT NULL,
  `Coordinator` varchar(64) NOT NULL,
  `MainEmail` varchar(64) NOT NULL,
  `CoordEmail` varchar(64) NOT NULL,
  `Phone` varchar(12) NOT NULL,
  `CoordPhone` varchar(12) NOT NULL,
  `ChurchWeb` varchar(64) NOT NULL,
  `ChurchStatus` enum('Active','Converting','Interested','NoContact','NoInterest') NOT NULL DEFAULT 'NoContact'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `church`
--

INSERT INTO `church` (`ChurchID`, `ChurchName`, `Address`, `Pastor`, `Coordinator`, `MainEmail`, `CoordEmail`, `Phone`, `CoordPhone`, `ChurchWeb`, `ChurchStatus`) VALUES
(1, 'Baptist Test Church', '1234 Testing Lane', 'Jim Cary', 'Joanna Blue', 'Jim@Gmail.com', '', '231-459-6657', '', 'Bapitist1.com', 'Active'),
(11, 'Methodist Test Church', '345 England Avenue', 'Mike Fergetful', 'Amanda Litely', 'Baconator@gmail.com', 'Amanda2299@yahoo.com', '231-559-7897', '234-776-5231', 'GrandRapidsMethodist.com', 'NoContact');

-- --------------------------------------------------------

--
-- Table structure for table `correspondence`
--

CREATE TABLE `correspondence` (
  `Cor_ID` int(12) NOT NULL,
  `ChurchID` int(12) NOT NULL,
  `Purpose` varchar(50) NOT NULL,
  `Type_Cor` enum('Email','Facebook','Twitter','LinkedIn','InPerson','Text','Phone') NOT NULL,
  `C_Date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `C_Notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `correspondence`
--

INSERT INTO `correspondence` (`Cor_ID`, `ChurchID`, `Purpose`, `Type_Cor`, `C_Date`, `C_Notes`) VALUES
(1, 1, 'Obtain Information about Church ', 'Facebook', '2019-05-23 04:36:04', 'Spoke with Jim.'),
(2, 1, 'Set up Baptist Test Church in Database.', 'InPerson', '2019-06-09 03:38:54', 'I came to their office and set up their accounts on the website.'),
(3, 1, 'Check In', 'Email', '0000-00-00 00:00:00', 'test'),
(4, 1, 'Check In', 'Email', '2019-06-09 19:35:44', 'test'),
(5, 1, 'Check In', 'Twitter', '2019-06-09 19:37:00', 'I messaged Jim over Twitter to see how the website is going for them, and if they finding it easy to use.'),
(6, 1, 'Baptist Test Church changed to Converting', 'Phone', '2019-06-09 19:39:06', 'I had a conversation over the phone with Jim, some memebers of the church have not fully switched over yet, so we are changing their status as a Church to \"Converting\".'),
(7, 1, 'Test', 'Text', '2019-06-09 19:40:03', 'I texted Jim to ask him how he is doing, he says he is doing well.'),
(8, 1, 'Active', 'LinkedIn', '2019-06-09 19:41:08', 'We finally converted everything over, and Baptist Test Church has been changed to \"Active\"');

-- --------------------------------------------------------

--
-- Table structure for table `recipient`
--

CREATE TABLE `recipient` (
  `RecID` int(11) NOT NULL,
  `ChurchID` int(16) NOT NULL,
  `R_Name` varchar(64) NOT NULL,
  `R_Address` varchar(96) NOT NULL,
  `R_Phone` varchar(12) NOT NULL,
  `R_Email` varchar(64) NOT NULL,
  `R_Notes` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `recipient`
--

INSERT INTO `recipient` (`RecID`, `ChurchID`, `R_Name`, `R_Address`, `R_Phone`, `R_Email`, `R_Notes`) VALUES
(1, 1, 'Kelly Ann', '1235 Smile Avenue', '231-413-7295', 'Kelly@Gmail.com', 'Kelly is in need of help watering her plants.'),
(2, 1, 'John Mackey', '452 Treverton Lane', '231-652-6525', 'Mackey@Gmail.com', ''),
(3, 1, 'Jerry Longhorn', '234 Pennygrove Lane', '291-323-4956', 'JerryLong@protonmail.com', 'He used to be an astrophysicist.');

-- --------------------------------------------------------

--
-- Table structure for table `skill`
--

CREATE TABLE `skill` (
  `Skill_ID` int(12) NOT NULL,
  `Vol_ID` int(12) NOT NULL,
  `Skill_Name` varchar(64) NOT NULL,
  `Skill_Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `skill`
--

INSERT INTO `skill` (`Skill_ID`, `Vol_ID`, `Skill_Name`, `Skill_Description`) VALUES
(1, 1, 'Watering Plants', 'Janey likes to water plants and is skilled at it.');

-- --------------------------------------------------------

--
-- Table structure for table `visit`
--

CREATE TABLE `visit` (
  `VisitID` int(16) NOT NULL,
  `ChurchID` int(16) NOT NULL,
  `Vol_ID` int(11) NOT NULL,
  `RecID` int(12) NOT NULL,
  `Purpose` varchar(32) NOT NULL,
  `Category` enum('RESPITE','MEAL','FINANCIAL','HOUSE','YARD','TRANSPORT','PET','SOCIAL','OTHER') NOT NULL,
  `V_Year` int(4) NOT NULL,
  `V_Month` int(2) NOT NULL,
  `V_Day` int(2) NOT NULL,
  `V_Time` varchar(10) NOT NULL,
  `V_Complete` tinyint(1) NOT NULL,
  `V_Notes` text NOT NULL,
  `Counted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visit`
--

INSERT INTO `visit` (`VisitID`, `ChurchID`, `Vol_ID`, `RecID`, `Purpose`, `Category`, `V_Year`, `V_Month`, `V_Day`, `V_Time`, `V_Complete`, `V_Notes`, `Counted`) VALUES
(1, 1, 1, 1, 'Helping to Water Plants Today', 'RESPITE', 2019, 5, 29, '4:30pm', 1, 'Going to help water Kelly\'s plants. Great!', 0),
(9, 1, 3, 2, 'Help Mackey with his Dogs', 'RESPITE', 2019, 7, 2, '4:00pm', 0, 'Mackey needs his dogs taken the the vet, someone needs to help him get them in the car.', 0),
(13, 1, 1, 1, 'Watering Plants', 'RESPITE', 2019, 6, 28, '2:00pm', 0, 'I am going to help Kelly water her plants today.', 0),
(14, 1, 2, 2, 'Dig up Bushes', 'RESPITE', 2019, 6, 28, '6:00pm', 0, 'Mackey needs someone to help him dig up some rose bushes in his garden.', 0),
(15, 1, 2, 1, 'Watering Plants', 'RESPITE', 2019, 6, 28, '6:30pm', 0, 'Kelly needs someone to water her plants again today.', 0),
(21, 1, 1, 3, 'Walk dog', 'RESPITE', 2019, 6, 6, '5:30pm', 0, 'Jerry has a Irish setter.', 0),
(22, 1, 3, 3, 'Walk dog', 'RESPITE', 2019, 6, 10, '5:30pm', 0, '', 0),
(23, 1, 1, 3, 'Doing Laundry', 'HOUSE', 2019, 7, 18, '2:00pm', 1, 'I\'m going to help with Laundry!', 0),
(25, 1, 1, 2, 'watev', 'RESPITE', 2019, 6, 6, '6:00pm', 1, '', 0),
(26, 1, 1, 3, 'Doing Laundry', 'HOUSE', 2019, 7, 18, '2:00pm', 1, 'I\'m going to help with Laundry!', 0);

-- --------------------------------------------------------

--
-- Table structure for table `visitcomments`
--

CREATE TABLE `visitcomments` (
  `CommentID` int(16) NOT NULL,
  `VisitID` int(16) NOT NULL,
  `Vol_ID` int(12) NOT NULL,
  `Comment` varchar(1024) NOT NULL,
  `Com_Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `visitcomments`
--

INSERT INTO `visitcomments` (`CommentID`, `VisitID`, `Vol_ID`, `Comment`, `Com_Date`) VALUES
(1, 21, 1, 'Can\'t wait to walk the dog!', '2019-06-11'),
(3, 21, 1, 'Just commenting to let everyone know that I was a little late walking Jerry\'s Irish Setter and it will have to be postponed until later.', '2019-06-11');

-- --------------------------------------------------------

--
-- Table structure for table `volunteer`
--

CREATE TABLE `volunteer` (
  `Vol_ID` int(12) NOT NULL,
  `ChurchID` int(12) NOT NULL,
  `V_Name` varchar(64) NOT NULL,
  `V_Password` varchar(64) NOT NULL,
  `V_Clearance` enum('VOLUNTEER','ADMIN','SUPERADMIN','') NOT NULL,
  `V_Address` varchar(96) NOT NULL,
  `V_Email` varchar(64) NOT NULL,
  `V_Notes` text NOT NULL,
  `V_Phone` varchar(12) NOT NULL,
  `V_Score` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `volunteer`
--

INSERT INTO `volunteer` (`Vol_ID`, `ChurchID`, `V_Name`, `V_Password`, `V_Clearance`, `V_Address`, `V_Email`, `V_Notes`, `V_Phone`, `V_Score`) VALUES
(1, 1, 'Janey Veeher', 'Password1', 'VOLUNTEER', '345 Grand Avenue', 'Janey@Gmail.com', 'Janey likes to water plants.', '231-999-9999', 4),
(2, 1, 'Pastor Jim', 'Password123', 'ADMIN', '34 clearance lane', 'Jim@Gmail.com', '', '231-459-6657', 0),
(3, 1, 'None', 'DefaultAccountPasswordisnotsupposedtobeknown999555%*##donotenter', '', '', '########################%###########################', '', '', 0),
(8, 1, 'Kimmy Nelson', 'OrangeOstrich9', 'VOLUNTEER', '23 Ostrich Avenue', 'Kimmy@yahoo.com', 'Kimmy\'s favorite animal is an Ostrich.', '291-323-4956', 0),
(9, 1, 'Kendra Nelson', 'Kendra\'sbird97', 'VOLUNTEER', '251 Bird Lane', 'Kendra@gmail.com', 'Kendra\'s animal skills are great. she does well with taking animals to the vet.', '231-777-6997', 0),
(10, 1, 'Bob Catt', 'shorthair', 'VOLUNTEER', '789 Feline Ave', 'bcatt@hotmail.com', '', '231-222-5678', 0),
(11, 1, 'Eric Verstraete', 'LIFT#matters7', 'SUPERADMIN', '3158, Grand Rapids, MI 49501', 'superadmin@exampleemail.com', 'President of the Website.', '616-745-1495', 0),
(14, 11, 'Mike Fergetful', 'Password1', 'ADMIN', '345 England Avenue', 'Baconator@gmail.com', 'Head of Methodist Test Church', '231-559-7897', 0),
(15, 11, 'Amanda Litely', 'Password1', 'ADMIN', '345 England Avenue', 'Amanda2299@yahoo.com', 'Coordinator of the LIFT program for Methodist Test Church', '234-776-5231', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `church`
--
ALTER TABLE `church`
  ADD PRIMARY KEY (`ChurchID`);

--
-- Indexes for table `correspondence`
--
ALTER TABLE `correspondence`
  ADD PRIMARY KEY (`Cor_ID`),
  ADD KEY `ChurchID` (`ChurchID`);

--
-- Indexes for table `recipient`
--
ALTER TABLE `recipient`
  ADD PRIMARY KEY (`RecID`),
  ADD KEY `ChurchID` (`ChurchID`);

--
-- Indexes for table `skill`
--
ALTER TABLE `skill`
  ADD PRIMARY KEY (`Skill_ID`),
  ADD KEY `Vol_ID` (`Vol_ID`);

--
-- Indexes for table `visit`
--
ALTER TABLE `visit`
  ADD PRIMARY KEY (`VisitID`),
  ADD KEY `RecID` (`RecID`),
  ADD KEY `Vol_ID` (`Vol_ID`),
  ADD KEY `ChurchID` (`ChurchID`);

--
-- Indexes for table `visitcomments`
--
ALTER TABLE `visitcomments`
  ADD PRIMARY KEY (`CommentID`),
  ADD KEY `VisitID` (`VisitID`),
  ADD KEY `Vol_ID` (`Vol_ID`);

--
-- Indexes for table `volunteer`
--
ALTER TABLE `volunteer`
  ADD PRIMARY KEY (`Vol_ID`),
  ADD KEY `ChurchID` (`ChurchID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `church`
--
ALTER TABLE `church`
  MODIFY `ChurchID` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `correspondence`
--
ALTER TABLE `correspondence`
  MODIFY `Cor_ID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `recipient`
--
ALTER TABLE `recipient`
  MODIFY `RecID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `skill`
--
ALTER TABLE `skill`
  MODIFY `Skill_ID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `visit`
--
ALTER TABLE `visit`
  MODIFY `VisitID` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `visitcomments`
--
ALTER TABLE `visitcomments`
  MODIFY `CommentID` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `volunteer`
--
ALTER TABLE `volunteer`
  MODIFY `Vol_ID` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `correspondence`
--
ALTER TABLE `correspondence`
  ADD CONSTRAINT `correspondence_ibfk_1` FOREIGN KEY (`ChurchID`) REFERENCES `church` (`ChurchID`);

--
-- Constraints for table `recipient`
--
ALTER TABLE `recipient`
  ADD CONSTRAINT `recipient_ibfk_1` FOREIGN KEY (`ChurchID`) REFERENCES `church` (`ChurchID`);

--
-- Constraints for table `skill`
--
ALTER TABLE `skill`
  ADD CONSTRAINT `skill_ibfk_1` FOREIGN KEY (`Vol_ID`) REFERENCES `volunteer` (`Vol_ID`);

--
-- Constraints for table `visit`
--
ALTER TABLE `visit`
  ADD CONSTRAINT `visit_ibfk_2` FOREIGN KEY (`Vol_ID`) REFERENCES `volunteer` (`Vol_ID`),
  ADD CONSTRAINT `visit_ibfk_3` FOREIGN KEY (`RecID`) REFERENCES `recipient` (`RecID`),
  ADD CONSTRAINT `visit_ibfk_4` FOREIGN KEY (`ChurchID`) REFERENCES `church` (`ChurchID`);

--
-- Constraints for table `visitcomments`
--
ALTER TABLE `visitcomments`
  ADD CONSTRAINT `visitcomments_ibfk_1` FOREIGN KEY (`VisitID`) REFERENCES `visit` (`VisitID`),
  ADD CONSTRAINT `visitcomments_ibfk_2` FOREIGN KEY (`Vol_ID`) REFERENCES `volunteer` (`Vol_ID`);

--
-- Constraints for table `volunteer`
--
ALTER TABLE `volunteer`
  ADD CONSTRAINT `volunteer_ibfk_1` FOREIGN KEY (`ChurchID`) REFERENCES `church` (`ChurchID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
