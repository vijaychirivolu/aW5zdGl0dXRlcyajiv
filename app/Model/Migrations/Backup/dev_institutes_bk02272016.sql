-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2016 at 07:15 PM
-- Server version: 10.1.9-MariaDB
-- PHP Version: 5.6.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dev_institutes`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetEmployeeCountByInstituteId` (IN `instituteId` INT)  NO SQL
SELECT count(1) as EmpCount FROM employees WHERE institute_id =instituteId and row_status=1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetNewMsgByReceiverId` (IN `instituteId` INT, IN `receiverId` INT)  NO SQL
SELECT mr.receiver_id,mr.message_id,mr.status,mr.student_id,mr.time_created
 ,msg.institute_id,msg.sender_id,msg.subject,msg.body,msg.time_created
 ,CONCAT(us.first_name,' ',us.last_name) as SenderName,
DATE_FORMAT(mr.time_created, '%d-%b-%Y') RecivedOnDate,
DATE_FORMAT(mr.time_created,'%r') RecivedOnTime,
DATEDIFF(now(),mr.time_created) as RecivedDays ,
TIMEDIFF(now(),mr.time_created) as RecivedTime
 FROM message_receivers mr 
 join messages msg on mr.message_id=msg.id and msg.status=2001
 join users u on mr.receiver_id=u.id and u.status=2001
 join users us on msg.sender_id=us.id and u.status=2001
 inner join institutes ins on msg.institute_id=ins.id
 where mr.receiver_id=receiverId and mr.status=10002 and msg.institute_id= instituteId limit 0,5$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetStudentCountByInstituteId` (IN `InstituteId` INT)  NO SQL
SELECT count(1) as StdCount FROM students WHERE institute_id=InstituteId
 and row_status=1$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `spGetUnreadMsgByReceiverId` (IN `instituteId` INT, IN `receiverId` INT)  NO SQL
SELECT count(1) as MsgCount,'New' as msg
 FROM message_receivers mr 
 join messages msg on mr.message_id=msg.id and msg.status=2001
 join users u on mr.receiver_id=u.id and u.status=2001 
 where mr.receiver_id=receiverId and mr.status=10002 and mr.row_status=1 and msg.row_status=1 and msg.institute_id=instituteId
 UNION
 select count(1) as MsgCount,'Draft' as msg from messages msg
 join users u on msg.sender_id=u.id and u.status=2001
 where msg.sender_id=receiverId and msg.id not in (select distinct message_id from message_receivers where institute_id=instituteId)
 and msg.status=2001 and msg.row_status=1 and msg.institute_id=instituteId$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `assign_teachers`
--

CREATE TABLE `assign_teachers` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT '0',
  `subject_id` int(11) NOT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `class_infos`
--

CREATE TABLE `class_infos` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `fee` float DEFAULT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class_infos`
--

INSERT INTO `class_infos` (`id`, `institute_id`, `name`, `fee`, `row_status`, `time_created`, `time_updated`, `requested_by`, `user_session_id`) VALUES
(1, 1, 'Nursery', 3000, 1, '2016-02-09 13:01:47', '2016-02-09 07:32:47', 2, 9),
(2, 1, 'L.K.G', 5000, 0, '2016-02-09 13:03:12', '2016-02-09 07:33:22', 2, 9),
(3, 1, 'L.K.G', 10000, 1, '2016-02-09 13:23:01', '2016-02-09 07:53:01', 2, 9);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `gender` enum('M','F','O') DEFAULT NULL,
  `joining_date` date DEFAULT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `institute_id`, `user_id`, `qualification`, `image`, `gender`, `joining_date`, `row_status`, `time_created`, `time_updated`, `requested_by`, `user_session_id`) VALUES
(1, 1, 3, 'B.tech', NULL, 'M', '2010-02-10', 1, NULL, '2016-02-16 06:54:38', 0, 0),
(2, 1, 4, 'B.A', NULL, 'M', '2001-02-16', 1, NULL, '2016-02-16 06:54:41', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `employee_attendances`
--

CREATE TABLE `employee_attendances` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `attendence_date` date NOT NULL,
  `morning_shift` tinyint(1) DEFAULT '0',
  `afternoon_shift` tinyint(1) DEFAULT '0',
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `employee_skills`
--

CREATE TABLE `employee_skills` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `skill` int(11) NOT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_skills`
--

INSERT INTO `employee_skills` (`id`, `institute_id`, `employee_id`, `skill`, `row_status`, `time_created`, `time_updated`, `requested_by`, `user_session_id`) VALUES
(1, 1, 1, 1, 1, '2016-02-17 14:28:00', '2016-02-17 12:42:14', 2, 24),
(2, 1, 1, 2, 1, '2016-02-17 14:29:00', '2016-02-17 12:42:14', 1, 24),
(3, 1, 2, 3, 1, '2016-02-17 14:28:00', '2016-02-17 12:42:28', 2, 24),
(4, 1, 2, 4, 1, '2016-02-17 14:29:00', '2016-02-17 12:42:28', 2, 24);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_allday` tinyint(1) DEFAULT '1',
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `entry_fee` float(10,2) DEFAULT '0.00',
  `all_class` tinyint(1) DEFAULT '0',
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `event_attendances`
--

CREATE TABLE `event_attendances` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT '0',
  `student_id` int(11) NOT NULL,
  `is_paid` tinyint(1) DEFAULT '0',
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `year` int(5) DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `description` text,
  `is_all` tinyint(1) DEFAULT '0',
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `galleries`
--

INSERT INTO `galleries` (`id`, `institute_id`, `user_id`, `year`, `name`, `description`, `is_all`, `row_status`, `time_created`, `time_updated`, `requested_by`, `user_session_id`) VALUES
(1, 1, 2, 0, 'Independence Day', 'afs afs afsf af', 0, 1, '2016-02-10 16:31:41', '2016-02-10 11:01:41', 2, 15),
(2, 1, 2, 0, 'Holy', 'Holy Holy', 0, 1, '2016-02-10 18:12:40', '2016-02-10 12:42:40', 2, 15),
(3, 1, 2, 0, 'Section A', 'Section A Section A Section A Section A', 0, 1, '2016-02-10 18:13:14', '2016-02-10 12:43:14', 2, 15),
(4, 1, 2, 0, 'Section C', 'Section C Section C Section C Section C Section C ', 0, 1, '2016-02-10 18:13:42', '2016-02-10 12:43:42', 2, 15),
(5, 1, 2, 0, 'Nursery A', 'Nursery A Nursery A Nursery A', 0, 1, '2016-02-10 18:14:05', '2016-02-10 12:44:05', 2, 15),
(6, 1, 2, 2016, 'Jan 1', 'fad ljfs fdsjflasfj klajf dljfak ldjsakfljdkfajdklj kajf kdjfksj kdjfkj kfjksjfkjskafjd ksjfak jkfjakdsj akfjklsajfklsdjk jfkaljkd jklafkl', 0, 1, '2016-02-21 15:10:16', '2016-02-21 09:40:16', 2, 59);

-- --------------------------------------------------------

--
-- Table structure for table `gallery_accesses`
--

CREATE TABLE `gallery_accesses` (
  `id` int(11) NOT NULL,
  `gallery_id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT '0',
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallery_accesses`
--

INSERT INTO `gallery_accesses` (`id`, `gallery_id`, `section_id`, `row_status`, `time_created`, `time_updated`, `requested_by`, `user_session_id`) VALUES
(1, 1, 2, 1, '2016-02-10 16:31:41', '2016-02-10 11:01:41', 2, 15),
(2, 1, 4, 1, '2016-02-10 16:31:41', '2016-02-10 11:01:41', 2, 15),
(3, 2, 3, 1, '2016-02-10 18:12:40', '2016-02-10 12:42:40', 2, 15),
(4, 3, 2, 1, '2016-02-10 18:13:14', '2016-02-10 12:43:14', 2, 15),
(5, 4, 4, 1, '2016-02-10 18:13:42', '2016-02-10 12:43:42', 2, 15),
(6, 5, 3, 1, '2016-02-10 18:14:05', '2016-02-10 12:44:05', 2, 15),
(7, 6, 3, 1, '2016-02-21 15:10:16', '2016-02-21 09:40:16', 2, 59),
(8, 6, 2, 1, '2016-02-21 15:10:16', '2016-02-21 09:40:16', 2, 59),
(9, 6, 4, 1, '2016-02-21 15:10:16', '2016-02-21 09:40:16', 2, 59);

-- --------------------------------------------------------

--
-- Table structure for table `gallery_images`
--

CREATE TABLE `gallery_images` (
  `id` int(11) NOT NULL,
  `gallery_id` int(11) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `gallery_id`, `original_filename`, `filename`, `row_status`, `time_created`, `time_updated`, `requested_by`, `user_session_id`) VALUES
(1, 1, 'avatar9.jpg', '1455106638_1_0.jpg', 1, '2016-02-10 17:47:18', '2016-02-10 12:17:18', 2, 15),
(2, 1, 'avatar8.jpg', '1455106638_1_1.jpg', 1, '2016-02-10 17:47:18', '2016-02-10 12:17:18', 2, 15),
(3, 1, 'avatar7.jpg', '1455106638_1_2.jpg', 1, '2016-02-10 17:47:18', '2016-02-10 12:17:18', 2, 15),
(4, 1, 'avatar6.jpg', '1455106638_1_3.jpg', 1, '2016-02-10 17:47:18', '2016-02-10 12:17:18', 2, 15),
(5, 1, 'avatar5.jpg', '1455106638_1_4.jpg', 1, '2016-02-10 17:47:18', '2016-02-10 12:17:18', 2, 15),
(6, 1, 'avatar4.jpg', '1455106638_1_5.jpg', 1, '2016-02-10 17:47:18', '2016-02-10 12:17:18', 2, 15),
(7, 1, 'avatar1.jpg', '1455107212_1_0.jpg', 1, '2016-02-10 17:56:52', '2016-02-10 12:26:52', 2, 15),
(8, 1, 'avatar2.jpg', '1455107212_1_1.jpg', 1, '2016-02-10 17:56:52', '2016-02-10 12:26:52', 2, 15),
(9, 1, 'avatar3.jpg', '1455107212_1_2.jpg', 1, '2016-02-10 17:56:52', '2016-02-10 12:26:52', 2, 15),
(10, 1, 'avatar2.jpg', '1455107381_1_0.jpg', 1, '2016-02-10 17:59:41', '2016-02-10 12:29:41', 2, 15),
(11, 1, 'avatar5.jpg', '1455107429_1_0.jpg', 1, '2016-02-10 18:00:29', '2016-02-10 12:30:29', 2, 15),
(12, 1, 'avatar1.jpg', '1455107571_1_0.jpg', 1, '2016-02-10 18:02:51', '2016-02-10 12:32:51', 2, 15),
(13, 4, 'avatar7.jpg', '1455109003_1_0.jpg', 1, '2016-02-10 18:26:43', '2016-02-10 12:56:43', 2, 15),
(14, 4, 'avatar6.jpg', '1455109003_1_1.jpg', 1, '2016-02-10 18:26:43', '2016-02-10 12:56:43', 2, 15),
(15, 5, 'avatar8.jpg', '1455109567_1_0.jpg', 1, '2016-02-10 18:36:07', '2016-02-10 13:06:07', 2, 15);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `row_status`, `time_created`, `time_updated`) VALUES
(1000, 'User Roles', 'User Roles', 1, '2016-01-28 18:05:00', '2016-02-02 02:19:15'),
(2000, 'User Status', 'User Status', 1, '2016-01-28 18:05:00', '2016-02-02 02:19:33'),
(3000, 'Upload Histories Types', 'Upload History Types', 1, '2016-01-28 21:41:00', '2016-01-28 10:42:00'),
(4000, 'School Types', 'School Types', 1, '2016-02-02 13:21:00', '2016-02-02 02:24:37'),
(5000, 'Sections', 'Sections', 1, '2016-02-02 13:21:00', '2016-02-02 02:24:47'),
(6000, 'School System', 'School System', 1, '2016-02-02 13:21:00', '2016-02-02 03:09:37'),
(7000, 'Classes', 'Classes', 1, '2016-02-02 14:34:00', '2016-02-02 03:34:27'),
(8000, 'Gender', 'User Gender', 1, '2016-03-02 23:37:00', '2016-02-03 17:08:05'),
(9000, 'Week Days', 'Week Days', 1, '2016-02-08 20:25:00', '2016-02-08 14:57:17'),
(10000, 'Message Read Or Unread', 'Message readed or unreaded', 1, '2016-02-22 09:39:11', '2016-02-22 04:09:11'),
(11000, 'Message Type', 'Message inbox or outbox', 1, '2016-02-22 09:40:14', '2016-02-22 04:10:14'),
(12000, 'Default Skills', 'Default Skills', 1, '2016-02-20 18:43:00', '2016-02-22 04:06:48');

-- --------------------------------------------------------

--
-- Table structure for table `group_values`
--

CREATE TABLE `group_values` (
  `id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_values`
--

INSERT INTO `group_values` (`id`, `group_id`, `name`, `description`, `row_status`, `time_created`, `time_updated`) VALUES
(1001, 1000, 'Super Admin', 'User Roles', 1, '2016-01-28 18:09:00', '2016-01-28 07:09:27'),
(1002, 1000, 'Admin', 'User Roles', 1, '2016-01-28 18:09:00', '2016-01-28 07:11:50'),
(1003, 1000, 'School Admin', 'User Roles', 1, '2016-01-28 18:09:00', '2016-01-28 07:12:23'),
(1004, 1000, 'Branch Admin', 'User Roles', 1, '2016-01-28 18:09:00', '2016-01-28 07:12:35'),
(1005, 1000, 'Teacher', 'User Roles', 1, '2016-01-28 18:09:00', '2016-01-28 07:12:50'),
(1006, 1000, 'Accountant', 'User Roles', 1, '2016-01-28 18:09:00', '2016-01-28 07:13:05'),
(1007, 1000, 'Parent', 'User Roles', 1, '2016-01-28 18:09:00', '2016-01-28 07:38:16'),
(2001, 2000, 'Active', 'User Status', 1, '2016-01-28 18:09:00', '2016-01-28 07:14:48'),
(2002, 2000, 'In Active', 'User Status', 1, '2016-01-28 18:09:00', '2016-01-28 07:15:01'),
(2003, 2000, 'Blocked', 'User Status', 1, '2016-01-28 18:09:00', '2016-01-28 07:15:13'),
(3001, 3000, 'Schools', 'Upload History Types', 1, '2016-01-28 21:44:00', '2016-01-28 10:45:00'),
(3002, 3000, 'Employees', 'Upload History Types', 1, '2016-01-28 21:44:00', '2016-01-28 10:45:00'),
(3003, 3000, 'Users', 'Upload History Types', 1, '2016-01-28 21:44:00', '2016-01-28 10:45:00'),
(4001, 4000, 'Public Schools', 'School Types', 1, '2016-02-02 14:00:00', '2016-02-02 03:08:47'),
(4002, 4000, 'Private Schools', 'School Types', 1, '2016-02-02 14:00:00', '2016-02-02 03:08:47'),
(4003, 4000, 'International Schools', 'School Types', 1, '2016-02-02 14:05:00', '2016-02-02 03:08:47'),
(5001, 5000, 'A', 'Sections', 1, '2016-02-02 14:00:00', '2016-02-02 03:14:40'),
(5002, 5000, 'B', 'Sections', 1, '2016-02-02 14:00:00', '2016-02-02 03:14:40'),
(5003, 5000, 'C', 'Sections', 1, '2016-02-02 14:05:00', '2016-02-02 03:14:40'),
(5004, 5000, 'D', 'Sections', 1, '2016-02-02 14:10:00', '2016-02-02 03:14:40'),
(5005, 5000, 'E', 'Sections', 1, '2015-02-02 14:15:00', '2016-02-02 03:14:40'),
(5006, 5000, 'F', 'Sections', 1, '2016-02-02 14:15:00', '2016-02-02 03:14:40'),
(5007, 5000, 'G', 'Sections', 1, '2016-02-02 14:10:00', '2016-02-02 03:14:40'),
(5008, 5000, 'H', 'Sections', 1, '2016-02-02 14:00:00', '2016-02-02 03:16:06'),
(5009, 5000, 'I', 'Sections', 1, '2016-02-02 14:00:00', '2016-02-02 03:16:06'),
(5010, 5000, 'J', 'Sections', 1, '2016-02-02 14:05:00', '2016-02-02 03:16:06'),
(5011, 5000, 'K', 'Sections', 1, '2016-02-02 14:10:00', '2016-02-02 03:16:06'),
(5012, 5000, 'L', 'Sections', 1, '2015-02-02 14:15:00', '2016-02-02 03:16:06'),
(5013, 5000, 'M', 'Sections', 1, '2016-02-02 14:15:00', '2016-02-02 03:16:06'),
(5014, 5000, 'N', 'Sections', 1, '2016-02-02 14:10:00', '2016-02-02 03:16:06'),
(5015, 5000, 'O', 'Sections', 1, '2016-02-02 14:00:00', '2016-02-02 03:17:32'),
(5016, 5000, 'P', 'Sections', 1, '2016-02-02 14:00:00', '2016-02-02 03:17:32'),
(5017, 5000, 'Q', 'Sections', 1, '2016-02-02 14:05:00', '2016-02-02 03:17:32'),
(5018, 5000, 'R', 'Sections', 1, '2016-02-02 14:10:00', '2016-02-02 03:17:32'),
(5019, 5000, 'S', 'Sections', 1, '2015-02-02 14:15:00', '2016-02-02 03:17:32'),
(5020, 5000, 'T', 'Sections', 1, '2016-02-02 14:15:00', '2016-02-02 03:17:32'),
(5021, 5000, 'U', 'Sections', 1, '2016-02-02 14:10:00', '2016-02-02 03:17:32'),
(5022, 5000, 'V', 'Sections', 1, '2016-02-02 14:00:00', '2016-02-02 03:18:38'),
(5023, 5000, 'W', 'Sections', 1, '2016-02-02 14:00:00', '2016-02-02 03:18:38'),
(5024, 5000, 'X', 'Sections', 1, '2016-02-02 14:05:00', '2016-02-02 03:18:38'),
(5025, 5000, 'Y', 'Sections', 1, '2016-02-02 14:10:00', '2016-02-02 03:18:38'),
(5026, 5000, 'Z', 'Sections', 1, '2015-02-02 14:15:00', '2016-02-02 03:18:38'),
(6001, 6000, 'Pre-School', 'School Systems', 1, '2016-02-02 14:00:00', '2016-02-02 03:26:36'),
(6002, 6000, 'Play School', 'School Systems', 1, '2016-02-02 14:00:00', '2016-02-02 03:26:36'),
(6003, 6000, 'Primary School', 'School Systems', 1, '2016-02-02 14:05:00', '2016-02-02 03:26:36'),
(6004, 6000, 'High School', 'School Systems', 1, '2016-02-02 14:10:00', '2016-02-02 03:26:36'),
(7001, 7000, 'Nursery', 'Classes', 1, '2016-02-02 14:35:00', '2016-02-02 03:39:28'),
(7002, 7000, 'L.K.G', 'Classes', 1, '2016-02-02 14:36:00', '2016-02-02 03:39:28'),
(7003, 7000, 'U.K.G', 'Classes', 1, '2016-02-02 14:37:00', '2016-02-02 03:39:28'),
(7004, 7000, '1', 'Classes', 1, '2016-02-02 14:38:00', '2016-02-02 03:39:28'),
(7005, 7000, '2', 'Classes', 1, '2016-02-02 14:35:00', '2016-02-02 03:47:10'),
(7006, 7000, '3', 'Classes', 1, '2016-02-02 14:36:00', '2016-02-02 03:47:10'),
(7007, 7000, '4', 'Classes', 1, '2016-02-02 14:37:00', '2016-02-02 03:47:10'),
(7008, 7000, '5', 'Classes', 1, '2016-02-02 14:38:00', '2016-02-02 03:47:10'),
(7009, 7000, '6', 'Classes', 1, '2016-02-02 14:35:00', '2016-02-02 03:47:06'),
(7010, 7000, '7', 'Classes', 1, '2016-02-02 14:36:00', '2016-02-02 03:46:40'),
(7011, 7000, '8', 'Classes', 1, '2016-02-02 14:37:00', '2016-02-02 03:46:27'),
(7012, 7000, '9', 'Classes', 1, '2016-02-02 14:38:00', '2016-02-02 03:46:19'),
(7013, 7000, '10', 'Classes', 1, '2016-02-02 14:45:00', '2016-02-02 03:46:12'),
(8001, 8000, 'Male', 'User Gender', 1, '2016-02-03 23:41:00', '2016-02-03 17:11:58'),
(8002, 8000, 'Female', 'User Gender', 1, '2016-03-02 23:47:00', '2016-02-03 17:11:58'),
(9001, 9000, 'Monday', 'Week Days', 1, '2016-02-08 20:28:00', '2016-02-08 15:08:00'),
(9002, 9000, 'Tuesday', 'Week Days', 1, '2016-02-08 20:28:00', '2016-02-08 15:08:00'),
(9003, 9000, 'Wednesday', 'Week Days', 1, '2016-02-08 20:28:00', '2016-02-08 15:08:00'),
(9004, 9000, 'Thursday', 'Week Days', 1, '2016-02-08 20:31:00', '2016-02-08 15:08:00'),
(9005, 9000, 'Friday', 'Week Days', 1, '2016-02-08 20:28:00', '2016-02-08 15:08:00'),
(9006, 9000, 'Saturday', 'Week Days', 1, '2016-02-08 20:28:00', '2016-02-08 15:08:00'),
(10001, 10000, 'Read', 'Message readed', 1, '2016-02-22 09:39:11', '2016-02-22 04:09:11'),
(10002, 10000, 'Unread', 'Message Unreaded', 1, '2016-02-22 09:39:11', '2016-02-22 04:09:11'),
(11001, 11000, 'Inbox', 'Message Inbox', 1, '2016-02-22 09:40:50', '2016-02-22 04:10:50'),
(11002, 11000, 'Outbox', 'Message Inbox', 1, '2016-02-22 09:41:16', '2016-02-22 04:11:16'),
(11003, 11000, 'Trash', 'Message Inbox', 1, '2016-02-22 09:41:35', '2016-02-22 04:11:35'),
(12001, 12000, 'Telugu', 'Default Skills', 1, '2016-02-20 18:45:00', '2016-02-22 04:07:50'),
(12002, 12000, 'Hindi', 'Default Skills', 1, '2016-02-20 18:48:00', '2016-02-22 04:07:57'),
(12003, 12000, 'English', 'Default Skills', 1, '2016-02-20 18:48:00', '2016-02-22 04:08:03'),
(12004, 12000, 'Maths', 'Default Skills', 1, '2016-02-20 18:45:00', '2016-02-22 04:08:12'),
(12005, 12000, 'Science', 'Default Skills', 1, '2016-02-20 18:48:00', '2016-02-22 04:08:22'),
(12006, 12000, 'Social', 'Default Skills', 1, '2016-02-20 18:48:00', '2016-02-22 04:08:34');

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `holidays`
--

INSERT INTO `holidays` (`id`, `institute_id`, `name`, `description`, `start_date`, `end_date`, `row_status`, `time_created`, `time_updated`, `requested_by`, `user_session_id`) VALUES
(1, 1, 'Valentines Day', 'Valentines Day Valentines Day', '2016-02-14', '2016-02-14', 0, '2016-02-09 00:18:55', '2016-02-09 12:39:11', 2, 2),
(2, 1, 'Summer Holidays', 'Summer Holidays', '2016-05-01', '2016-06-01', 1, '2016-02-09 00:26:42', '2016-02-09 12:39:11', 2, 2),
(3, 1, '', '', NULL, NULL, 0, '2016-02-09 14:16:09', '2016-02-09 12:39:11', 2, 2),
(4, 1, 'Pongal', 'Pongal Pongal Pongal Pongal', '2016-01-11', '2016-01-18', 1, '2016-02-09 18:07:30', '2016-02-09 12:44:14', 2, 10);

-- --------------------------------------------------------

--
-- Table structure for table `institutes`
--

CREATE TABLE `institutes` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` longtext,
  `logo` varchar(255) DEFAULT NULL,
  `phone_no` varchar(50) DEFAULT NULL,
  `landline_no` varchar(50) DEFAULT NULL,
  `registration_no` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT '0',
  `system_type` int(11) DEFAULT '0',
  `address` text,
  `street_address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `fb_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `linkedin_url` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT '0',
  `is_publish` tinyint(1) DEFAULT '0',
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `institutes`
--

INSERT INTO `institutes` (`id`, `name`, `description`, `logo`, `phone_no`, `landline_no`, `registration_no`, `type`, `system_type`, `address`, `street_address`, `city`, `state`, `country`, `postal_code`, `landmark`, `lat`, `lng`, `fb_url`, `twitter_url`, `linkedin_url`, `status`, `is_publish`, `row_status`, `time_created`, `time_updated`, `requested_by`, `user_session_id`) VALUES
(1, 'Sri Sai Ram High Schools', 'test', NULL, NULL, NULL, NULL, 0, 0, 'H.No:220', 'Krishna Nagar', 'Hyderabad', 'Telengana', 'India', '500045', 'Opp stadium', NULL, NULL, NULL, NULL, NULL, 2001, 0, 1, '2016-02-08 17:37:00', '2016-02-17 15:43:59', 1, 1),
(2, 'L R Kishore High School', '', '1455721823_logo.jpg', '8008374974', '04012456', 'LR0011', 0, 0, 'H.No:100', 'Karmika Nagar', 'Hyderabad', 'Telengana', 'India', '500045', 'Opp ground', '', '', '', '', '', 0, 0, 1, NULL, '2016-02-17 15:43:54', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `institute_settings`
--

CREATE TABLE `institute_settings` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `max_periods_allowed` int(5) DEFAULT '7',
  `period_time` int(5) DEFAULT '45',
  `break_time` int(5) DEFAULT '15',
  `lunch_time` int(5) DEFAULT '45',
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `institute_settings`
--

INSERT INTO `institute_settings` (`id`, `institute_id`, `max_periods_allowed`, `period_time`, `break_time`, `lunch_time`, `row_status`, `time_created`, `time_updated`, `requested_by`, `user_session_id`) VALUES
(1, 1, 7, 60, 15, 45, 1, '2016-02-20 20:29:22', '2016-02-20 14:59:22', 1, 51);

-- --------------------------------------------------------

--
-- Table structure for table `institute_timings`
--

CREATE TABLE `institute_timings` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `week_id` int(11) NOT NULL,
  `opening_hours` time DEFAULT NULL,
  `closing_hours` time DEFAULT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `institute_timings`
--

INSERT INTO `institute_timings` (`id`, `institute_id`, `week_id`, `opening_hours`, `closing_hours`, `row_status`, `time_created`, `time_updated`, `requested_by`, `user_session_id`) VALUES
(1, 1, 9001, '05:00:00', '12:00:00', 1, '2016-02-20 20:28:50', '2016-02-20 14:58:51', 1, 51),
(2, 1, 9002, '06:00:00', '13:00:00', 1, '2016-02-20 20:28:50', '2016-02-20 14:58:51', 1, 51),
(3, 1, 9005, '07:00:00', '14:00:00', 1, '2016-02-20 20:28:50', '2016-02-20 14:58:51', 1, 51),
(4, 2, 9002, '06:30:00', '08:00:00', 1, '2016-02-20 20:30:09', '2016-02-20 15:00:09', 1, 51),
(5, 2, 9004, '07:30:00', '09:00:00', 1, '2016-02-20 20:30:09', '2016-02-20 15:00:09', 1, 51),
(6, 2, 9006, '09:30:00', '12:30:00', 1, '2016-02-20 20:30:09', '2016-02-20 15:00:09', 1, 51);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` longtext,
  `has_attechments` tinyint(1) DEFAULT '0',
  `status` int(11) NOT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `institute_id`, `sender_id`, `subject`, `body`, `has_attechments`, `status`, `row_status`, `time_created`, `time_updated`, `requested_by`, `user_session_id`) VALUES
(1, 1, 2, 'ddddd', '<p>dddddd dddd ddd dd<br></p>', 0, 2001, 1, '2016-02-22 10:02:25', '2016-02-22 04:55:17', 2, 0),
(2, 1, 2, '', '<p> vijay vijay vijay <br></p><p>vijay vijay vijay<br></p><p>vijay vijay vijay<br></p><p>vijay vijay vijay<br></p><p>vijay vijay vijay<br></p><p>vijay vijay vijay<br></p><p>vijay vijay vijay<br></p>', 1, 2001, 1, '2016-02-22 10:02:26', '2016-02-22 04:56:47', 2, 0),
(3, 1, 2, 'sample mail', 'ajfd skajfkds jkafjdk sjkfasdj kajfklsdj kfajkds jkafjs kdjfaks<br><p><br></p>', 1, 2001, 1, '2016-02-22 10:02:29', '2016-02-22 04:59:37', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `message_attachments`
--

CREATE TABLE `message_attachments` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message_attachments`
--

INSERT INTO `message_attachments` (`id`, `message_id`, `original_filename`, `filename`, `status`, `row_status`, `time_created`, `time_updated`, `requested_by`, `user_session_id`) VALUES
(1, 3, 'SampleStudents.xlsx', '14561171782090950123.xlsx', 0, 1, '2016-02-22 10:29:37', '2016-02-22 04:59:37', 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `message_receivers`
--

CREATE TABLE `message_receivers` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT '0',
  `receiver_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `type` int(11) DEFAULT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0',
  `institute_id` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `message_receivers`
--

INSERT INTO `message_receivers` (`id`, `message_id`, `student_id`, `receiver_id`, `status`, `type`, `row_status`, `time_created`, `time_updated`, `requested_by`, `user_session_id`, `institute_id`) VALUES
(1, 1, 0, 6, 10002, 12001, 1, '2016-02-22 10:02:25', '2016-02-22 05:13:52', 2, 0, 1),
(2, 1, 0, 1, 10002, 12001, 1, '2016-02-22 10:02:25', '2016-02-22 05:13:52', 2, 0, 1),
(3, 1, 0, 6, 10002, 12001, 1, '2016-02-22 10:02:25', '2016-02-22 05:13:52', 2, 0, 1),
(4, 1, 0, 2, 10001, 12002, 1, '2016-02-22 10:02:25', '2016-02-22 05:13:42', 2, 0, 1),
(5, 2, 0, 1, 10002, 12001, 1, '2016-02-22 10:02:26', '2016-02-22 05:13:52', 2, 0, 1),
(6, 2, 0, 4, 10002, 12001, 1, '2016-02-22 10:02:26', '2016-02-22 05:13:52', 2, 0, 1),
(7, 2, 0, 2, 10002, 12002, 1, '2016-02-22 10:02:26', '2016-02-22 05:13:42', 2, 0, 1),
(8, 3, 0, 1, 10002, 12001, 1, '2016-02-22 10:02:29', '2016-02-22 05:13:52', 2, 0, 1),
(9, 3, 0, 2, 10001, 12002, 1, '2016-02-22 10:02:29', '2016-02-22 05:13:42', 2, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `message` text NOT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `parent_infos`
--

CREATE TABLE `parent_infos` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mother_first_name` varchar(255) DEFAULT NULL,
  `mother_last_name` varchar(255) DEFAULT NULL,
  `mother_email` varchar(255) DEFAULT NULL,
  `mother_mobile_no` varchar(50) DEFAULT NULL,
  `address` text,
  `street_address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `landmark` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `landline_no` varchar(50) DEFAULT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `institute_id`, `class_id`, `name`, `row_status`, `time_created`, `time_updated`, `requested_by`, `user_session_id`) VALUES
(1, 1, 3, 'A', 0, '2016-02-09 14:03:07', '2016-02-09 08:37:29', 2, 9),
(2, 1, 3, 'A', 1, '2016-02-09 14:07:41', '2016-02-09 08:37:41', 2, 9),
(3, 1, 1, 'A', 1, '2016-02-09 14:07:52', '2016-02-09 08:38:13', 2, 9),
(4, 1, 3, 'C', 1, '2016-02-09 14:08:02', '2016-02-09 08:38:02', 2, 9);

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `institute_id`, `name`, `row_status`, `time_created`, `time_updated`, `requested_by`, `user_session_id`) VALUES
(1, 2, 'Telugu', 0, NULL, '2016-02-20 15:07:45', 1, 51),
(2, 2, 'Hindi', 0, NULL, '2016-02-20 15:07:45', 1, 51),
(3, 2, 'Maths', 0, NULL, '2016-02-20 15:07:45', 1, 51),
(4, 2, 'Telugu', 0, NULL, '2016-02-20 15:08:41', 1, 51),
(5, 2, 'Hindi', 0, NULL, '2016-02-20 15:08:41', 1, 51),
(6, 2, 'Hindi', 1, NULL, '2016-02-20 15:11:55', 1, 51),
(7, 1, 'Telugu', 0, NULL, '2016-02-20 15:40:28', 1, 51),
(8, 1, 'Hindi', 0, NULL, '2016-02-20 15:40:28', 1, 51),
(9, 1, 'English', 0, NULL, '2016-02-20 15:40:28', 1, 51),
(10, 1, 'Maths', 0, NULL, '2016-02-20 15:40:28', 1, 51),
(11, 1, 'Science', 0, NULL, '2016-02-20 15:40:28', 1, 51),
(12, 1, 'Social', 0, NULL, '2016-02-20 15:40:28', 1, 51),
(13, 1, 'Telugu', 1, NULL, '2016-02-20 15:40:28', 1, 53),
(14, 1, 'Hindi', 1, NULL, '2016-02-20 15:40:28', 1, 53),
(15, 1, 'English', 1, NULL, '2016-02-20 15:40:28', 1, 53),
(16, 1, 'Maths', 1, NULL, '2016-02-20 15:40:28', 1, 53),
(17, 1, 'Science', 1, NULL, '2016-02-20 15:40:28', 1, 53),
(18, 1, 'Social', 1, NULL, '2016-02-20 15:40:28', 1, 53);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `current_class_id` int(11) NOT NULL,
  `current_section_id` int(11) DEFAULT '0',
  `parent_id` int(11) DEFAULT '0',
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `iamge` varchar(255) DEFAULT NULL,
  `admission_no` varchar(255) NOT NULL,
  `date_of_joining` date DEFAULT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `institute_id`, `user_id`, `current_class_id`, `current_section_id`, `parent_id`, `first_name`, `last_name`, `iamge`, `admission_no`, `date_of_joining`, `row_status`, `time_created`, `time_updated`, `requested_by`, `user_session_id`) VALUES
(1, 1, 0, 1, 0, 0, 'Vijay', 'Kumar', NULL, 'SRI001', '1989-07-20', 1, '2016-02-09 22:54:19', '2016-02-09 17:36:17', 2, 11),
(2, 1, 0, 1, 0, 0, 'Sudheer', 'Kumar', NULL, 'SRI002', '2016-02-09', 1, '2016-02-10 13:40:38', '2016-02-10 08:10:38', 2, 13);

-- --------------------------------------------------------

--
-- Table structure for table `student_attendances`
--

CREATE TABLE `student_attendances` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `attendence_date` date NOT NULL,
  `morning_shift` tinyint(1) DEFAULT '0',
  `afternoon_shift` tinyint(1) DEFAULT '0',
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `student_classes`
--

CREATE TABLE `student_classes` (
  `id` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT '0',
  `student_id` int(11) NOT NULL,
  `rank` varchar(50) DEFAULT NULL,
  `passed_year` date DEFAULT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `test_dates`
--

CREATE TABLE `test_dates` (
  `id` int(11) NOT NULL,
  `name` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `upload_histories`
--

CREATE TABLE `upload_histories` (
  `id` int(11) NOT NULL,
  `upload_type` int(11) DEFAULT '0',
  `original_filename` varchar(255) NOT NULL,
  `uploaded_filename` varchar(255) NOT NULL,
  `error_filename` varchar(255) DEFAULT NULL,
  `error_message` varchar(255) DEFAULT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0',
  `institute_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) DEFAULT '0',
  `login_attempts` int(11) DEFAULT '0',
  `last_login_date` datetime DEFAULT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_session_id` int(11) DEFAULT '0',
  `requested_by` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `username`, `email`, `mobile_no`, `password`, `status`, `login_attempts`, `last_login_date`, `row_status`, `time_created`, `time_updated`, `user_session_id`, `requested_by`) VALUES
(1, 'Super', 'Admin', 'superadmin', 'vijay.ch1405@gmail.com', '8008374974', '73c6f70b1e52853eff0eef8964cf00d33a707793', 2001, 0, '2016-02-21 14:47:27', 1, '2016-02-07 10:45:00', '2016-02-21 09:17:27', 58, 0),
(2, 'mahesh', 'kumar', 'maheshkumar', 'mahesh@gmail.com', '9052467551', '73c6f70b1e52853eff0eef8964cf00d33a707793', 2001, 0, '2016-02-27 16:27:29', 1, '2016-02-08 17:32:00', '2016-02-27 15:27:29', 63, 1),
(3, 'Devi', 'Prasad', 'deviprasad', 'deviprasad@gmail.com', '9866072487', '73c6f70b1e52853eff0eef8964cf00d33a707793', 2001, 0, NULL, 1, '2016-02-16 12:14:00', '2016-02-16 06:45:27', 20, 1),
(4, 'Bharath', 'kumar', 'bharathkumar', 'bharath@gmail.com', '9676988614', '73c6f70b1e52853eff0eef8964cf00d33a707793', 2001, 0, NULL, 1, '2016-02-16 12:15:00', '2016-02-16 06:45:27', 20, 1),
(6, 'Sudheer', 'Kumar', NULL, 'sudheerkumar109@gmail.com', '', '73c6f70b1e52853eff0eef8964cf00d33a707793', 2001, 0, '2016-02-18 22:31:15', 1, '2016-02-18 14:22:57', '2016-02-18 17:01:15', 43, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_levels`
--

CREATE TABLE `user_access_levels` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_role` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access_levels`
--

INSERT INTO `user_access_levels` (`id`, `user_id`, `user_role`, `institute_id`, `row_status`, `time_created`, `time_updated`, `requested_by`, `user_session_id`) VALUES
(1, 1, 1001, 0, 1, '2016-02-07 10:49:00', '2016-02-07 07:48:05', 0, 0),
(2, 2, 1003, 1, 1, '2016-02-08 17:34:00', '2016-02-08 12:05:04', 1, 1),
(3, 3, 1005, 1, 1, '2016-02-16 12:19:00', '2016-02-16 06:50:36', 1, 20),
(4, 4, 1005, 1, 1, '2016-02-16 12:20:00', '2016-02-17 08:49:23', 1, 20),
(5, 6, 1003, 2, 1, NULL, '2016-02-18 08:52:58', 1, 0),
(6, 6, 1004, 2, 1, NULL, '2016-02-18 09:14:45', 1, 0),
(7, 6, 1005, 2, 1, NULL, '2016-02-18 09:20:00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `login_time` datetime NOT NULL,
  `logout_time` datetime DEFAULT NULL,
  `login_ip` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `os` varchar(255) DEFAULT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_sessions`
--

INSERT INTO `user_sessions` (`id`, `user_id`, `login_time`, `logout_time`, `login_ip`, `browser`, `os`, `row_status`, `time_created`, `time_updated`) VALUES
(1, 1, '2016-02-07 13:24:57', '2016-02-07 13:25:06', '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-07 13:24:57', '2016-02-07 07:55:06'),
(2, 1, '2016-02-07 14:22:36', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-07 14:22:36', '2016-02-07 08:52:36'),
(3, 2, '2016-02-08 17:40:58', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-08 17:40:58', '2016-02-08 12:10:58'),
(4, 2, '2016-02-08 20:10:35', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-08 20:10:35', '2016-02-08 14:40:35'),
(5, 2, '2016-02-08 23:21:35', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-08 23:21:35', '2016-02-08 17:51:35'),
(6, 2, '2016-02-08 23:22:32', '2016-02-08 23:22:53', '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-08 23:22:32', '2016-02-08 17:52:53'),
(7, 2, '2016-02-08 23:22:58', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-08 23:22:58', '2016-02-08 17:52:58'),
(8, 2, '2016-02-08 23:24:10', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-08 23:24:10', '2016-02-08 17:54:10'),
(9, 2, '2016-02-09 12:29:57', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-09 12:29:57', '2016-02-09 06:59:57'),
(10, 2, '2016-02-09 18:08:32', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-09 18:08:32', '2016-02-09 12:38:32'),
(11, 2, '2016-02-09 22:33:06', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-09 22:33:06', '2016-02-09 17:03:06'),
(12, 2, '2016-02-10 10:48:19', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-10 10:48:19', '2016-02-10 05:18:19'),
(13, 2, '2016-02-10 11:44:45', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-10 11:44:45', '2016-02-10 06:14:45'),
(14, 2, '2016-02-10 15:25:01', '2016-02-10 15:30:03', '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-10 15:25:01', '2016-02-10 10:00:03'),
(15, 2, '2016-02-10 15:34:43', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-10 15:34:43', '2016-02-10 10:04:43'),
(16, 2, '2016-02-10 22:46:03', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-10 22:46:03', '2016-02-10 17:16:03'),
(17, 2, '2016-02-10 23:45:41', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-10 23:45:41', '2016-02-10 18:15:41'),
(18, 2, '2016-02-11 10:08:41', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-11 10:08:41', '2016-02-11 04:38:41'),
(19, 2, '2016-02-11 14:56:58', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-11 14:56:58', '2016-02-11 09:26:58'),
(20, 2, '2016-02-11 18:01:15', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-11 18:01:15', '2016-02-11 12:31:15'),
(21, 2, '2016-02-11 18:14:39', NULL, '127.0.0.1', 'Chrome', 'Linux', 1, '2016-02-11 18:14:39', '2016-02-11 12:44:39'),
(22, 2, '2016-02-15 17:51:46', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-15 17:51:46', '2016-02-15 12:21:46'),
(23, 2, '2016-02-16 10:18:50', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-16 10:18:51', '2016-02-16 04:48:51'),
(24, 2, '2016-02-17 14:16:09', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-17 14:16:09', '2016-02-17 08:46:09'),
(25, 2, '2016-02-17 17:56:05', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-17 17:56:05', '2016-02-17 12:26:05'),
(26, 1, '2016-02-17 20:11:29', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-17 20:11:30', '2016-02-17 14:41:30'),
(27, 1, '2016-02-18 13:21:55', '2016-02-18 15:22:40', '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-18 13:21:55', '2016-02-18 09:52:40'),
(28, 6, '2016-02-18 15:30:36', '2016-02-18 15:30:49', '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-18 15:30:36', '2016-02-18 10:00:49'),
(29, 2, '2016-02-18 15:50:02', '2016-02-18 15:51:12', '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-18 15:50:02', '2016-02-18 10:21:12'),
(30, 6, '2016-02-18 15:51:30', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-18 15:51:30', '2016-02-18 10:21:30'),
(31, 6, '2016-02-18 15:53:02', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-18 15:53:02', '2016-02-18 10:23:02'),
(32, 6, '2016-02-18 15:54:38', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-18 15:54:38', '2016-02-18 10:24:38'),
(33, 6, '2016-02-18 16:52:17', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-18 16:52:17', '2016-02-18 11:22:17'),
(34, 6, '2016-02-18 16:52:54', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-18 16:52:54', '2016-02-18 11:22:54'),
(35, 6, '2016-02-18 16:53:53', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-18 16:53:53', '2016-02-18 11:23:53'),
(36, 6, '2016-02-18 16:57:04', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-18 16:57:04', '2016-02-18 11:27:04'),
(37, 6, '2016-02-18 16:58:47', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-18 16:58:47', '2016-02-18 11:28:47'),
(38, 2, '2016-02-18 17:53:39', '2016-02-18 18:02:31', '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-18 17:53:39', '2016-02-18 12:32:31'),
(39, 6, '2016-02-18 18:02:43', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-18 18:02:43', '2016-02-18 12:32:43'),
(40, 6, '2016-02-18 19:44:00', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-18 19:44:00', '2016-02-18 14:14:00'),
(41, 2, '2016-02-18 20:25:16', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-18 20:25:16', '2016-02-18 14:55:16'),
(42, 6, '2016-02-18 21:39:34', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-18 21:39:34', '2016-02-18 16:09:34'),
(43, 6, '2016-02-18 22:31:15', '2016-02-18 22:45:33', '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-18 22:31:15', '2016-02-18 17:15:33'),
(44, 2, '2016-02-18 22:45:36', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-18 22:45:36', '2016-02-18 17:15:36'),
(45, 2, '2016-02-19 10:18:15', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-19 10:18:15', '2016-02-19 04:48:15'),
(46, 2, '2016-02-19 12:28:39', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-19 12:28:39', '2016-02-19 06:58:39'),
(47, 1, '2016-02-19 13:55:26', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-19 13:55:26', '2016-02-19 08:25:26'),
(48, 1, '2016-02-20 17:13:25', '2016-02-20 17:37:01', '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-20 17:13:25', '2016-02-20 12:07:01'),
(49, 1, '2016-02-20 17:37:05', '2016-02-20 18:11:12', '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-20 17:37:05', '2016-02-20 12:41:12'),
(50, 1, '2016-02-20 18:11:17', '2016-02-20 18:15:28', '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-20 18:11:17', '2016-02-20 12:45:28'),
(51, 1, '2016-02-20 18:15:50', '2016-02-20 20:58:12', '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-20 18:15:50', '2016-02-20 15:28:12'),
(52, 2, '2016-02-20 20:58:17', '2016-02-20 21:10:02', '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-20 20:58:17', '2016-02-20 15:40:02'),
(53, 1, '2016-02-20 21:10:07', '2016-02-20 21:10:57', '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-20 21:10:07', '2016-02-20 15:40:58'),
(54, 2, '2016-02-20 21:11:25', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-20 21:11:25', '2016-02-20 15:41:25'),
(55, 2, '2016-02-20 23:06:27', '2016-02-20 23:06:42', '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-20 23:06:27', '2016-02-20 17:36:42'),
(56, 1, '2016-02-20 23:06:48', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-20 23:06:48', '2016-02-20 17:36:48'),
(57, 2, '2016-02-21 14:19:23', '2016-02-21 14:47:21', '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-21 14:19:23', '2016-02-21 09:17:21'),
(58, 1, '2016-02-21 14:47:27', '2016-02-21 14:57:12', '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-21 14:47:27', '2016-02-21 09:27:12'),
(59, 2, '2016-02-21 14:57:23', '2016-02-21 16:22:28', '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-21 14:57:23', '2016-02-21 10:52:28'),
(60, 2, '2016-02-21 16:22:33', '2016-02-21 17:20:01', '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-21 16:22:33', '2016-02-21 11:50:01'),
(61, 2, '2016-02-21 17:20:09', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-21 17:20:09', '2016-02-21 11:50:09'),
(62, 2, '2016-02-22 09:31:28', NULL, '127.0.0.1', 'Firefox', 'Ubuntu', 1, '2016-02-22 09:31:28', '2016-02-22 04:01:28'),
(63, 2, '2016-02-27 16:27:28', NULL, '::1', 'Chrome', 'Windows 7', 1, '2016-02-27 16:27:28', '2016-02-27 15:27:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assign_teachers`
--
ALTER TABLE `assign_teachers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `class_infos`
--
ALTER TABLE `class_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_attendances`
--
ALTER TABLE `employee_attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_skills`
--
ALTER TABLE `employee_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_attendances`
--
ALTER TABLE `event_attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_accesses`
--
ALTER TABLE `gallery_accesses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery_images`
--
ALTER TABLE `gallery_images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index2` (`name`),
  ADD KEY `index3` (`row_status`);

--
-- Indexes for table `group_values`
--
ALTER TABLE `group_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_group_values_1_idx` (`group_id`),
  ADD KEY `index3` (`name`),
  ADD KEY `index4` (`row_status`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `institutes`
--
ALTER TABLE `institutes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `institute_settings`
--
ALTER TABLE `institute_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `institute_timings`
--
ALTER TABLE `institute_timings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_attachments`
--
ALTER TABLE `message_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message_receivers`
--
ALTER TABLE `message_receivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parent_infos`
--
ALTER TABLE `parent_infos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_attendances`
--
ALTER TABLE `student_attendances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_classes`
--
ALTER TABLE `student_classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upload_histories`
--
ALTER TABLE `upload_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_access_levels`
--
ALTER TABLE `user_access_levels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assign_teachers`
--
ALTER TABLE `assign_teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `class_infos`
--
ALTER TABLE `class_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `employee_attendances`
--
ALTER TABLE `employee_attendances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee_skills`
--
ALTER TABLE `employee_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `event_attendances`
--
ALTER TABLE `event_attendances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `gallery_accesses`
--
ALTER TABLE `gallery_accesses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `gallery_images`
--
ALTER TABLE `gallery_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12001;
--
-- AUTO_INCREMENT for table `group_values`
--
ALTER TABLE `group_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12007;
--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `institutes`
--
ALTER TABLE `institutes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `institute_settings`
--
ALTER TABLE `institute_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `institute_timings`
--
ALTER TABLE `institute_timings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `message_attachments`
--
ALTER TABLE `message_attachments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `message_receivers`
--
ALTER TABLE `message_receivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `parent_infos`
--
ALTER TABLE `parent_infos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `student_attendances`
--
ALTER TABLE `student_attendances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `student_classes`
--
ALTER TABLE `student_classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `upload_histories`
--
ALTER TABLE `upload_histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `user_access_levels`
--
ALTER TABLE `user_access_levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `group_values`
--
ALTER TABLE `group_values`
  ADD CONSTRAINT `fk_group_values_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
