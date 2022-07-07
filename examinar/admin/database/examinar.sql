-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2018 at 08:52 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `examinar`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `aid` int(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`aid`, `lastname`, `firstname`, `middlename`, `username`, `password`) VALUES
(1, 'Real', 'Crown', '', 'RealCrown', '12345');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `dept` varchar(255) NOT NULL,
  `falc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `dept`, `falc`) VALUES
(1, 'Agricultural Economics', 'FAG'),
(2, 'Agricultural Extension and Rural Development', 'FAG'),
(3, 'Animal Production and Health', 'FAG'),
(4, 'Animal Nutrition and Biotechnology', 'FAG'),
(5, 'Crop Production and Soil Sciences', 'FAG'),
(6, 'Crop Enviromental Protection', 'FAG'),
(7, 'Architecture', 'FEN'),
(8, 'Fine and Applied Arts', 'FEN'),
(9, 'Urban and Regional Planning', 'FEN'),
(10, 'Agricultural Engineering', 'FET'),
(11, 'Chemical Engineering', 'FET'),
(12, 'Civil Engineering', 'FET'),
(13, 'Computer Science and Engineering', 'FET'),
(14, 'Electronic and Electrical Engineering', 'FET'),
(15, 'Food Science and Engineering', 'FET'),
(16, 'Mechanical Engineering', 'FET'),
(17, 'Pure and Applied Biology', 'FAPAS'),
(18, 'Pure and Applied Chemistry', 'FAPAS'),
(19, 'Earth Sciences', 'FAPAS'),
(20, 'Pure and Applied Mathematics', 'FAPAS'),
(21, 'Pure and Applied Physics', 'FAPAS'),
(22, 'Science Laboratory Technology', 'FAPAS'),
(23, 'Statistics', 'FAPAS'),
(24, 'General Studies', 'FAPAS'),
(25, 'Management and Accounting', 'FAMASA'),
(26, 'Transport Management', 'FAMASA'),
(27, 'Marketing Management', 'FAMASA'),
(28, 'Anatomy', 'FABAMSA'),
(29, 'Medical Microbiology and Parasitology', 'FABAMSA'),
(30, 'Physiology', 'FABAMSA'),
(31, 'Biochemistry', 'FABAMSA'),
(32, 'Biomedical Science', 'FABAMSA'),
(33, 'Morbid Anatomy/Histophathology', 'FABAMSA'),
(34, 'Haemathology and Blood Transfusion', 'FABAMSA'),
(35, 'Chemical Pathology', 'FABAMSA'),
(36, 'Pharmacology and Therapeutics', 'FABAMSA'),
(37, 'Medicine', 'FACS'),
(38, 'Nursing', 'FACS'),
(39, 'Surgery', 'FACS'),
(40, 'Radiology', 'FACS'),
(41, 'Paediatrics', 'FACS'),
(42, 'Obstetrics and Gynaecology', 'FACS'),
(43, 'Opthalmology', 'FACS'),
(44, 'Psychiatry', 'FACS'),
(45, 'Anaesthesia', 'FACS'),
(46, 'Ear, Nose and Throat', 'FACS');

-- --------------------------------------------------------

--
-- Table structure for table `exam_type`
--

CREATE TABLE `exam_type` (
  `id` int(11) NOT NULL,
  `course_code` varchar(50) NOT NULL,
  `course_title` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL DEFAULT '-----',
  `type` varchar(50) NOT NULL,
  `exam_session` varchar(11) NOT NULL,
  `active` varchar(50) NOT NULL DEFAULT 'no',
  `department` varchar(100) NOT NULL DEFAULT '----------',
  `level` varchar(50) NOT NULL DEFAULT '----------'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exam_type`
--

INSERT INTO `exam_type` (`id`, `course_code`, `course_title`, `time`, `type`, `exam_session`, `active`, `department`, `level`) VALUES
(1, 'CSE 201', 'INTRODUCTION TO PASCAL PROGRAMMING', '-----', '', '', 'no', '----------', '----------'),
(2, 'CSE 203', 'BASIC COMPUTER PROGRAMMING', '-----', '', '', 'no', '----------', '----------'),
(3, 'CSE 401', 'PRINCIPLES OF PROGRAMMING LANGUAGE', '-----', '', '', 'no', '----------', '----------'),
(4, 'CSE 407', 'ARTIFICIAL INTELLIGENCE', '-----', '', '', 'no', '----------', '----------'),
(5, 'CSE 413', 'COMPUTER COMPILER', '-----', '', '', 'no', '----------', '----------'),
(6, 'CSE 403', 'OPERATING SYSTEMS', '-----', '', '', 'no', '----------', '----------'),
(7, 'CSE 405', 'PROGRAMMING PROJECT', '-----', '', '', 'no', '----------', '----------'),
(8, 'CSE 409', 'SIMULATION AND MODELLING', '-----', '', '', 'no', '----------', '----------'),
(9, 'CSE 411', 'USER INTRERFACES DESIGN', '-----', '', '', 'no', '----------', '----------'),
(10, 'CSE 419', 'COMPUTER ARCHITECTURE', '-----', '', '', 'no', '----------', '----------'),
(11, 'CSE 202', 'OVERVIEW OF COMPUTER SCIENCE', '-----', '', '', 'no', '----------', '----------'),
(12, 'CSE 204', 'INTRODUCTION TO APPLICATIONS', '-----', '', '', 'no', '----------', '----------'),
(13, 'CSE 206', 'DISCRETE MATHEMATICS', '-----', '', '', 'no', '----------', '----------'),
(14, 'CSE 301', 'COMPUTER PROGRAMMING I', '-----', '', '', 'no', '----------', '----------'),
(15, 'CSE 303', 'COMPUTER LOGIC I', '-----', '', '', 'no', '----------', '----------'),
(16, 'CSE 305', 'DATABASE MANAGEMENT SYSTEM', '-----', '', '', 'no', '----------', '----------'),
(17, 'CSE 307', 'NUMERICAL COMPUTATION I', '-----', '', '', 'no', '----------', '----------'),
(18, 'CSE 311', 'AUTOMATA THEORY & COMPUTABILITY', '-----', '', '', 'no', '----------', '----------'),
(19, 'CSE 331', 'ENGINEERING STATISTICS', '-----', '', '', 'no', '----------', '----------'),
(20, 'CSE 302', 'COMPUTER PROGRAMMING II', '-----', '', '', 'no', '----------', '----------'),
(21, 'CSE 304', 'COMPUTER LOGIC II', '-----', '', '', 'no', '----------', '----------'),
(22, 'CSE 308', 'ASSEMBLY LANGUAGE PROGRAMMING', '-----', '', '', 'no', '----------', '----------'),
(23, 'CSE 310', 'NUMERICAL COMPUTATION II', '-----', '', '', 'no', '----------', '----------'),
(24, 'CSE 312', 'DATA STRUCTURES & ALGORITHMS', '-----', '', '', 'no', '----------', '----------'),
(25, 'CSE 314', 'SOFTWARE ENGINEERING', '-----', '', '', 'no', '----------', '----------');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(50) NOT NULL,
  `falc_full` varchar(255) NOT NULL,
  `falc_abbr` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `falc_full`, `falc_abbr`) VALUES
(1, 'FACULTY OF ENGINEERING AND TECHNOLOGY', 'FET'),
(2, 'FACULTY OF AGRICULTURAL SCIENCES', 'FAG'),
(3, 'FACULTY OF ENVIROMENTAL SCIENCES', 'FEN'),
(4, 'FACULTY OF PURE AND APPLIED SCIENCES', 'FPAS'),
(5, 'FACULTY OF MANAGEMENT SCIENCES', 'FAMASA'),
(6, 'FACULTY OF BASIC MEDICAL SCIENCES', 'FABAMSA'),
(7, 'FACULTY OF CLINICAL SCIENCES', 'FACS');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE `question` (
  `id` int(11) NOT NULL,
  `c_code` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `exam_session` varchar(10) NOT NULL,
  `qid` int(50) NOT NULL,
  `question` varchar(10000) NOT NULL,
  `option_a` varchar(200) NOT NULL,
  `option_b` varchar(200) NOT NULL,
  `option_c` varchar(200) NOT NULL,
  `option_d` varchar(200) NOT NULL,
  `correct` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `result`
--

CREATE TABLE `result` (
  `id` int(255) NOT NULL,
  `session` varchar(255) NOT NULL,
  `course` varchar(255) NOT NULL,
  `m_num` int(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `faculty` varchar(255) NOT NULL,
  `depart` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL,
  `test` int(255) NOT NULL,
  `exam` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `score_sheet`
--

CREATE TABLE `score_sheet` (
  `id` int(11) NOT NULL,
  `session` varchar(10) NOT NULL,
  `course` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `m_num` int(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `mname` varchar(100) NOT NULL,
  `faculty` varchar(100) NOT NULL,
  `depart` varchar(100) NOT NULL,
  `level` varchar(255) NOT NULL,
  `qid` varchar(255) NOT NULL,
  `coropt` varchar(50) NOT NULL,
  `usropt` varchar(50) NOT NULL,
  `correct` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` int(11) NOT NULL,
  `session` varchar(50) NOT NULL,
  `active_sess` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `session`
--

INSERT INTO `session` (`id`, `session`, `active_sess`) VALUES
(1, '2017/2018', '1');

-- --------------------------------------------------------

--
-- Table structure for table `student_login`
--

CREATE TABLE `student_login` (
  `id` int(11) NOT NULL,
  `mat_no` varchar(50) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `middlename` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `contact` varchar(13) NOT NULL,
  `password` varchar(100) NOT NULL,
  `faculty` varchar(100) NOT NULL,
  `department` varchar(100) NOT NULL,
  `level` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_type`
--
ALTER TABLE `exam_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_code` (`course_code`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `result`
--
ALTER TABLE `result`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `score_sheet`
--
ALTER TABLE `score_sheet`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_login`
--
ALTER TABLE `student_login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `aid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `exam_type`
--
ALTER TABLE `exam_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `result`
--
ALTER TABLE `result`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `score_sheet`
--
ALTER TABLE `score_sheet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_login`
--
ALTER TABLE `student_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
