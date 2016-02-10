-- MySQL dump 10.13  Distrib 5.5.44, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: dev_institutes
-- ------------------------------------------------------
-- Server version	5.5.44-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `assign_teachers`
--

DROP TABLE IF EXISTS `assign_teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assign_teachers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `institute_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT '0',
  `subject_id` int(11) NOT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assign_teachers`
--

LOCK TABLES `assign_teachers` WRITE;
/*!40000 ALTER TABLE `assign_teachers` DISABLE KEYS */;
/*!40000 ALTER TABLE `assign_teachers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `class_infos`
--

DROP TABLE IF EXISTS `class_infos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class_infos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `institute_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `fee` float DEFAULT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_infos`
--

LOCK TABLES `class_infos` WRITE;
/*!40000 ALTER TABLE `class_infos` DISABLE KEYS */;
INSERT INTO `class_infos` VALUES (1,1,'Nursery',3000,1,'2016-02-09 13:01:47','2016-02-09 07:32:47',2,9),(2,1,'L.K.G',5000,0,'2016-02-09 13:03:12','2016-02-09 07:33:22',2,9),(3,1,'L.K.G',10000,1,'2016-02-09 13:23:01','2016-02-09 07:53:01',2,9);
/*!40000 ALTER TABLE `class_infos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_skills`
--

DROP TABLE IF EXISTS `employee_skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `institute_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `skill` int(11) NOT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_skills`
--

LOCK TABLES `employee_skills` WRITE;
/*!40000 ALTER TABLE `employee_skills` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `institute_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `qualification` varchar(255) DEFAULT NULL,
  `iamge` varchar(255) DEFAULT NULL,
  `gender` int(11) DEFAULT '0',
  `joining_date` date DEFAULT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event_attendence`
--

DROP TABLE IF EXISTS `event_attendence`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event_attendence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event_attendence`
--

LOCK TABLES `event_attendence` WRITE;
/*!40000 ALTER TABLE `event_attendence` DISABLE KEYS */;
/*!40000 ALTER TABLE `event_attendence` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `events`
--

LOCK TABLES `events` WRITE;
/*!40000 ALTER TABLE `events` DISABLE KEYS */;
/*!40000 ALTER TABLE `events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `galleries`
--

DROP TABLE IF EXISTS `galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `galleries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `institute_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `is_all` tinyint(1) DEFAULT '0',
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `galleries`
--

LOCK TABLES `galleries` WRITE;
/*!40000 ALTER TABLE `galleries` DISABLE KEYS */;
INSERT INTO `galleries` VALUES (1,1,2,'Independence Day','afs afs afsf af',0,1,'2016-02-10 16:31:41','2016-02-10 11:01:41',2,15),(2,1,2,'Holy','Holy Holy',0,1,'2016-02-10 18:12:40','2016-02-10 12:42:40',2,15),(3,1,2,'Section A','Section A Section A Section A Section A',0,1,'2016-02-10 18:13:14','2016-02-10 12:43:14',2,15),(4,1,2,'Section C','Section C Section C Section C Section C Section C ',0,1,'2016-02-10 18:13:42','2016-02-10 12:43:42',2,15),(5,1,2,'Nursery A','Nursery A Nursery A Nursery A',0,1,'2016-02-10 18:14:05','2016-02-10 12:44:05',2,15);
/*!40000 ALTER TABLE `galleries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_accesses`
--

DROP TABLE IF EXISTS `gallery_accesses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gallery_accesses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) NOT NULL,
  `section_id` int(11) DEFAULT '0',
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_accesses`
--

LOCK TABLES `gallery_accesses` WRITE;
/*!40000 ALTER TABLE `gallery_accesses` DISABLE KEYS */;
INSERT INTO `gallery_accesses` VALUES (1,1,2,1,'2016-02-10 16:31:41','2016-02-10 11:01:41',2,15),(2,1,4,1,'2016-02-10 16:31:41','2016-02-10 11:01:41',2,15),(3,2,3,1,'2016-02-10 18:12:40','2016-02-10 12:42:40',2,15),(4,3,2,1,'2016-02-10 18:13:14','2016-02-10 12:43:14',2,15),(5,4,4,1,'2016-02-10 18:13:42','2016-02-10 12:43:42',2,15),(6,5,3,1,'2016-02-10 18:14:05','2016-02-10 12:44:05',2,15);
/*!40000 ALTER TABLE `gallery_accesses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery_images`
--

DROP TABLE IF EXISTS `gallery_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gallery_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gallery_id` int(11) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery_images`
--

LOCK TABLES `gallery_images` WRITE;
/*!40000 ALTER TABLE `gallery_images` DISABLE KEYS */;
INSERT INTO `gallery_images` VALUES (1,1,'avatar9.jpg','1455106638_1_0.jpg',1,'2016-02-10 17:47:18','2016-02-10 12:17:18',2,15),(2,1,'avatar8.jpg','1455106638_1_1.jpg',1,'2016-02-10 17:47:18','2016-02-10 12:17:18',2,15),(3,1,'avatar7.jpg','1455106638_1_2.jpg',1,'2016-02-10 17:47:18','2016-02-10 12:17:18',2,15),(4,1,'avatar6.jpg','1455106638_1_3.jpg',1,'2016-02-10 17:47:18','2016-02-10 12:17:18',2,15),(5,1,'avatar5.jpg','1455106638_1_4.jpg',1,'2016-02-10 17:47:18','2016-02-10 12:17:18',2,15),(6,1,'avatar4.jpg','1455106638_1_5.jpg',1,'2016-02-10 17:47:18','2016-02-10 12:17:18',2,15),(7,1,'avatar1.jpg','1455107212_1_0.jpg',1,'2016-02-10 17:56:52','2016-02-10 12:26:52',2,15),(8,1,'avatar2.jpg','1455107212_1_1.jpg',1,'2016-02-10 17:56:52','2016-02-10 12:26:52',2,15),(9,1,'avatar3.jpg','1455107212_1_2.jpg',1,'2016-02-10 17:56:52','2016-02-10 12:26:52',2,15),(10,1,'avatar2.jpg','1455107381_1_0.jpg',1,'2016-02-10 17:59:41','2016-02-10 12:29:41',2,15),(11,1,'avatar5.jpg','1455107429_1_0.jpg',1,'2016-02-10 18:00:29','2016-02-10 12:30:29',2,15),(12,1,'avatar1.jpg','1455107571_1_0.jpg',1,'2016-02-10 18:02:51','2016-02-10 12:32:51',2,15),(13,4,'avatar7.jpg','1455109003_1_0.jpg',1,'2016-02-10 18:26:43','2016-02-10 12:56:43',2,15),(14,4,'avatar6.jpg','1455109003_1_1.jpg',1,'2016-02-10 18:26:43','2016-02-10 12:56:43',2,15),(15,5,'avatar8.jpg','1455109567_1_0.jpg',1,'2016-02-10 18:36:07','2016-02-10 13:06:07',2,15);
/*!40000 ALTER TABLE `gallery_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_values`
--

DROP TABLE IF EXISTS `group_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_group_values_1_idx` (`group_id`),
  KEY `index3` (`name`),
  KEY `index4` (`row_status`),
  CONSTRAINT `fk_group_values_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9007 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_values`
--

LOCK TABLES `group_values` WRITE;
/*!40000 ALTER TABLE `group_values` DISABLE KEYS */;
INSERT INTO `group_values` VALUES (1001,1000,'Super Admin','User Roles',1,'2016-01-28 18:09:00','2016-01-28 07:09:27'),(1002,1000,'Admin','User Roles',1,'2016-01-28 18:09:00','2016-01-28 07:11:50'),(1003,1000,'School Admin','User Roles',1,'2016-01-28 18:09:00','2016-01-28 07:12:23'),(1004,1000,'Branch Admin','User Roles',1,'2016-01-28 18:09:00','2016-01-28 07:12:35'),(1005,1000,'Teacher','User Roles',1,'2016-01-28 18:09:00','2016-01-28 07:12:50'),(1006,1000,'Accountant','User Roles',1,'2016-01-28 18:09:00','2016-01-28 07:13:05'),(1007,1000,'Parent','User Roles',1,'2016-01-28 18:09:00','2016-01-28 07:38:16'),(2001,2000,'Active','User Status',1,'2016-01-28 18:09:00','2016-01-28 07:14:48'),(2002,2000,'In Active','User Status',1,'2016-01-28 18:09:00','2016-01-28 07:15:01'),(2003,2000,'Blocked','User Status',1,'2016-01-28 18:09:00','2016-01-28 07:15:13'),(3001,3000,'Schools','Upload History Types',1,'2016-01-28 21:44:00','2016-01-28 10:45:00'),(3002,3000,'Employees','Upload History Types',1,'2016-01-28 21:44:00','2016-01-28 10:45:00'),(3003,3000,'Users','Upload History Types',1,'2016-01-28 21:44:00','2016-01-28 10:45:00'),(4001,4000,'Public Schools','School Types',1,'2016-02-02 14:00:00','2016-02-02 03:08:47'),(4002,4000,'Private Schools','School Types',1,'2016-02-02 14:00:00','2016-02-02 03:08:47'),(4003,4000,'International Schools','School Types',1,'2016-02-02 14:05:00','2016-02-02 03:08:47'),(5001,5000,'A','Sections',1,'2016-02-02 14:00:00','2016-02-02 03:14:40'),(5002,5000,'B','Sections',1,'2016-02-02 14:00:00','2016-02-02 03:14:40'),(5003,5000,'C','Sections',1,'2016-02-02 14:05:00','2016-02-02 03:14:40'),(5004,5000,'D','Sections',1,'2016-02-02 14:10:00','2016-02-02 03:14:40'),(5005,5000,'E','Sections',1,'2015-02-02 14:15:00','2016-02-02 03:14:40'),(5006,5000,'F','Sections',1,'2016-02-02 14:15:00','2016-02-02 03:14:40'),(5007,5000,'G','Sections',1,'2016-02-02 14:10:00','2016-02-02 03:14:40'),(5008,5000,'H','Sections',1,'2016-02-02 14:00:00','2016-02-02 03:16:06'),(5009,5000,'I','Sections',1,'2016-02-02 14:00:00','2016-02-02 03:16:06'),(5010,5000,'J','Sections',1,'2016-02-02 14:05:00','2016-02-02 03:16:06'),(5011,5000,'K','Sections',1,'2016-02-02 14:10:00','2016-02-02 03:16:06'),(5012,5000,'L','Sections',1,'2015-02-02 14:15:00','2016-02-02 03:16:06'),(5013,5000,'M','Sections',1,'2016-02-02 14:15:00','2016-02-02 03:16:06'),(5014,5000,'N','Sections',1,'2016-02-02 14:10:00','2016-02-02 03:16:06'),(5015,5000,'O','Sections',1,'2016-02-02 14:00:00','2016-02-02 03:17:32'),(5016,5000,'P','Sections',1,'2016-02-02 14:00:00','2016-02-02 03:17:32'),(5017,5000,'Q','Sections',1,'2016-02-02 14:05:00','2016-02-02 03:17:32'),(5018,5000,'R','Sections',1,'2016-02-02 14:10:00','2016-02-02 03:17:32'),(5019,5000,'S','Sections',1,'2015-02-02 14:15:00','2016-02-02 03:17:32'),(5020,5000,'T','Sections',1,'2016-02-02 14:15:00','2016-02-02 03:17:32'),(5021,5000,'U','Sections',1,'2016-02-02 14:10:00','2016-02-02 03:17:32'),(5022,5000,'V','Sections',1,'2016-02-02 14:00:00','2016-02-02 03:18:38'),(5023,5000,'W','Sections',1,'2016-02-02 14:00:00','2016-02-02 03:18:38'),(5024,5000,'X','Sections',1,'2016-02-02 14:05:00','2016-02-02 03:18:38'),(5025,5000,'Y','Sections',1,'2016-02-02 14:10:00','2016-02-02 03:18:38'),(5026,5000,'Z','Sections',1,'2015-02-02 14:15:00','2016-02-02 03:18:38'),(6001,6000,'Pre-School','School Systems',1,'2016-02-02 14:00:00','2016-02-02 03:26:36'),(6002,6000,'Play School','School Systems',1,'2016-02-02 14:00:00','2016-02-02 03:26:36'),(6003,6000,'Primary School','School Systems',1,'2016-02-02 14:05:00','2016-02-02 03:26:36'),(6004,6000,'High School','School Systems',1,'2016-02-02 14:10:00','2016-02-02 03:26:36'),(7001,7000,'Nursery','Classes',1,'2016-02-02 14:35:00','2016-02-02 03:39:28'),(7002,7000,'L.K.G','Classes',1,'2016-02-02 14:36:00','2016-02-02 03:39:28'),(7003,7000,'U.K.G','Classes',1,'2016-02-02 14:37:00','2016-02-02 03:39:28'),(7004,7000,'1','Classes',1,'2016-02-02 14:38:00','2016-02-02 03:39:28'),(7005,7000,'2','Classes',1,'2016-02-02 14:35:00','2016-02-02 03:47:10'),(7006,7000,'3','Classes',1,'2016-02-02 14:36:00','2016-02-02 03:47:10'),(7007,7000,'4','Classes',1,'2016-02-02 14:37:00','2016-02-02 03:47:10'),(7008,7000,'5','Classes',1,'2016-02-02 14:38:00','2016-02-02 03:47:10'),(7009,7000,'6','Classes',1,'2016-02-02 14:35:00','2016-02-02 03:47:06'),(7010,7000,'7','Classes',1,'2016-02-02 14:36:00','2016-02-02 03:46:40'),(7011,7000,'8','Classes',1,'2016-02-02 14:37:00','2016-02-02 03:46:27'),(7012,7000,'9','Classes',1,'2016-02-02 14:38:00','2016-02-02 03:46:19'),(7013,7000,'10','Classes',1,'2016-02-02 14:45:00','2016-02-02 03:46:12'),(8001,8000,'Male','User Gender',1,'2016-02-03 23:41:00','2016-02-03 17:11:58'),(8002,8000,'Female','User Gender',1,'2016-03-02 23:47:00','2016-02-03 17:11:58'),(9001,9000,'Monday','Week Days',1,'2016-02-08 20:28:00','2016-02-08 15:08:00'),(9002,9000,'Tuesday','Week Days',1,'2016-02-08 20:28:00','2016-02-08 15:08:00'),(9003,9000,'Wednesday','Week Days',1,'2016-02-08 20:28:00','2016-02-08 15:08:00'),(9004,9000,'Thursday','Week Days',1,'2016-02-08 20:31:00','2016-02-08 15:08:00'),(9005,9000,'Friday','Week Days',1,'2016-02-08 20:28:00','2016-02-08 15:08:00'),(9006,9000,'Saturday','Week Days',1,'2016-02-08 20:28:00','2016-02-08 15:08:00');
/*!40000 ALTER TABLE `group_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `index2` (`name`),
  KEY `index3` (`row_status`)
) ENGINE=InnoDB AUTO_INCREMENT=9001 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1000,'User Roles','User Roles',1,'2016-01-28 18:05:00','2016-02-02 02:19:15'),(2000,'User Status','User Status',1,'2016-01-28 18:05:00','2016-02-02 02:19:33'),(3000,'Upload Histories Types','Upload History Types',1,'2016-01-28 21:41:00','2016-01-28 10:42:00'),(4000,'School Types','School Types',1,'2016-02-02 13:21:00','2016-02-02 02:24:37'),(5000,'Sections','Sections',1,'2016-02-02 13:21:00','2016-02-02 02:24:47'),(6000,'School System','School System',1,'2016-02-02 13:21:00','2016-02-02 03:09:37'),(7000,'Classes','Classes',1,'2016-02-02 14:34:00','2016-02-02 03:34:27'),(8000,'Gender','User Gender',1,'2016-03-02 23:37:00','2016-02-03 17:08:05'),(9000,'Week Days','Week Days',1,'2016-02-08 20:25:00','2016-02-08 14:57:17');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `holidays`
--

DROP TABLE IF EXISTS `holidays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `holidays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `institute_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `holidays`
--

LOCK TABLES `holidays` WRITE;
/*!40000 ALTER TABLE `holidays` DISABLE KEYS */;
INSERT INTO `holidays` VALUES (1,1,'Valentines Day','Valentines Day Valentines Day','2016-02-14','2016-02-14',0,'2016-02-09 00:18:55','2016-02-09 12:39:11',2,2),(2,1,'Summer Holidays','Summer Holidays','2016-05-01','2016-06-01',1,'2016-02-09 00:26:42','2016-02-09 12:39:11',2,2),(3,1,'','',NULL,NULL,0,'2016-02-09 14:16:09','2016-02-09 12:39:11',2,2),(4,1,'Pongal','Pongal Pongal Pongal Pongal','2016-01-11','2016-01-18',1,'2016-02-09 18:07:30','2016-02-09 12:44:14',2,10);
/*!40000 ALTER TABLE `holidays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `institute_settings`
--

DROP TABLE IF EXISTS `institute_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `institute_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `institute_id` int(11) NOT NULL,
  `max_periods_allowed` int(5) DEFAULT '7',
  `period_time` int(5) DEFAULT '45',
  `break_time` int(5) DEFAULT '15',
  `lunch_time` int(5) DEFAULT '45',
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `institute_settings`
--

LOCK TABLES `institute_settings` WRITE;
/*!40000 ALTER TABLE `institute_settings` DISABLE KEYS */;
INSERT INTO `institute_settings` VALUES (1,1,7,60,15,60,1,'2016-02-08 23:29:24','2016-02-08 18:04:31',2,8);
/*!40000 ALTER TABLE `institute_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `institute_timings`
--

DROP TABLE IF EXISTS `institute_timings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `institute_timings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `institute_id` int(11) NOT NULL,
  `week_id` int(11) NOT NULL,
  `opening_hours` time DEFAULT NULL,
  `closing_hours` time DEFAULT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `institute_timings`
--

LOCK TABLES `institute_timings` WRITE;
/*!40000 ALTER TABLE `institute_timings` DISABLE KEYS */;
/*!40000 ALTER TABLE `institute_timings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `institutes`
--

DROP TABLE IF EXISTS `institutes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `institutes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT '0',
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
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `institutes`
--

LOCK TABLES `institutes` WRITE;
/*!40000 ALTER TABLE `institutes` DISABLE KEYS */;
INSERT INTO `institutes` VALUES (1,0,'Sri Sai Ram High Schools','test',NULL,NULL,NULL,NULL,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2001,0,1,'2016-02-08 17:37:00','2016-02-08 12:06:44',1,1);
/*!40000 ALTER TABLE `institutes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message`
--

DROP TABLE IF EXISTS `message`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message`
--

LOCK TABLES `message` WRITE;
/*!40000 ALTER TABLE `message` DISABLE KEYS */;
/*!40000 ALTER TABLE `message` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message_attachments`
--

DROP TABLE IF EXISTS `message_attachments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `original_filename` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message_attachments`
--

LOCK TABLES `message_attachments` WRITE;
/*!40000 ALTER TABLE `message_attachments` DISABLE KEYS */;
/*!40000 ALTER TABLE `message_attachments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message_receivers`
--

DROP TABLE IF EXISTS `message_receivers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message_receivers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT '0',
  `receiver_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message_receivers`
--

LOCK TABLES `message_receivers` WRITE;
/*!40000 ALTER TABLE `message_receivers` DISABLE KEYS */;
/*!40000 ALTER TABLE `message_receivers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `institute_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `message` text NOT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parent_infos`
--

DROP TABLE IF EXISTS `parent_infos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parent_infos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parent_infos`
--

LOCK TABLES `parent_infos` WRITE;
/*!40000 ALTER TABLE `parent_infos` DISABLE KEYS */;
/*!40000 ALTER TABLE `parent_infos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sections`
--

DROP TABLE IF EXISTS `sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `institute_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sections`
--

LOCK TABLES `sections` WRITE;
/*!40000 ALTER TABLE `sections` DISABLE KEYS */;
INSERT INTO `sections` VALUES (1,1,3,'A',0,'2016-02-09 14:03:07','2016-02-09 08:37:29',2,9),(2,1,3,'A',1,'2016-02-09 14:07:41','2016-02-09 08:37:41',2,9),(3,1,1,'A',1,'2016-02-09 14:07:52','2016-02-09 08:38:13',2,9),(4,1,3,'C',1,'2016-02-09 14:08:02','2016-02-09 08:38:02',2,9);
/*!40000 ALTER TABLE `sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `institute_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills`
--

LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_attendences`
--

DROP TABLE IF EXISTS `student_attendences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_attendences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `institute_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `attendence_date` date NOT NULL,
  `morning_shift` tinyint(1) DEFAULT '0',
  `afternoon_shift` tinyint(1) DEFAULT '0',
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_attendences`
--

LOCK TABLES `student_attendences` WRITE;
/*!40000 ALTER TABLE `student_attendences` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_attendences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_classes`
--

DROP TABLE IF EXISTS `student_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_classes`
--

LOCK TABLES `student_classes` WRITE;
/*!40000 ALTER TABLE `student_classes` DISABLE KEYS */;
/*!40000 ALTER TABLE `student_classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,1,0,1,0,0,'Vijay','Kumar',NULL,'SRI001','1989-07-20',1,'2016-02-09 22:54:19','2016-02-09 17:36:17',2,11),(2,1,0,1,0,0,'Sudheer','Kumar',NULL,'SRI002','2016-02-09',1,'2016-02-10 13:40:38','2016-02-10 08:10:38',2,13);
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teacher_attendences`
--

DROP TABLE IF EXISTS `teacher_attendences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teacher_attendences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `institute_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `attendence_date` date NOT NULL,
  `morning_shift` tinyint(1) DEFAULT '0',
  `afternoon_shift` tinyint(1) DEFAULT '0',
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teacher_attendences`
--

LOCK TABLES `teacher_attendences` WRITE;
/*!40000 ALTER TABLE `teacher_attendences` DISABLE KEYS */;
/*!40000 ALTER TABLE `teacher_attendences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `upload_histories`
--

DROP TABLE IF EXISTS `upload_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `upload_histories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
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
  `institute_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `upload_histories`
--

LOCK TABLES `upload_histories` WRITE;
/*!40000 ALTER TABLE `upload_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `upload_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_access_levels`
--

DROP TABLE IF EXISTS `user_access_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_access_levels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_role` int(11) NOT NULL,
  `institute_id` int(11) NOT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `requested_by` int(11) DEFAULT '0',
  `user_session_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_access_levels`
--

LOCK TABLES `user_access_levels` WRITE;
/*!40000 ALTER TABLE `user_access_levels` DISABLE KEYS */;
INSERT INTO `user_access_levels` VALUES (1,1,1001,0,1,'2016-02-07 10:49:00','2016-02-07 07:48:05',0,0),(2,2,1003,1,1,'2016-02-08 17:34:00','2016-02-08 12:05:04',1,1);
/*!40000 ALTER TABLE `user_access_levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_sessions`
--

DROP TABLE IF EXISTS `user_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `login_time` datetime NOT NULL,
  `logout_time` datetime DEFAULT NULL,
  `login_ip` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `os` varchar(255) DEFAULT NULL,
  `row_status` tinyint(1) DEFAULT '1',
  `time_created` datetime DEFAULT NULL,
  `time_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_sessions`
--

LOCK TABLES `user_sessions` WRITE;
/*!40000 ALTER TABLE `user_sessions` DISABLE KEYS */;
INSERT INTO `user_sessions` VALUES (1,1,'2016-02-07 13:24:57','2016-02-07 13:25:06','127.0.0.1','Firefox','Ubuntu',1,'2016-02-07 13:24:57','2016-02-07 07:55:06'),(2,1,'2016-02-07 14:22:36',NULL,'127.0.0.1','Firefox','Ubuntu',1,'2016-02-07 14:22:36','2016-02-07 08:52:36'),(3,2,'2016-02-08 17:40:58',NULL,'127.0.0.1','Firefox','Ubuntu',1,'2016-02-08 17:40:58','2016-02-08 12:10:58'),(4,2,'2016-02-08 20:10:35',NULL,'127.0.0.1','Firefox','Ubuntu',1,'2016-02-08 20:10:35','2016-02-08 14:40:35'),(5,2,'2016-02-08 23:21:35',NULL,'127.0.0.1','Firefox','Ubuntu',1,'2016-02-08 23:21:35','2016-02-08 17:51:35'),(6,2,'2016-02-08 23:22:32','2016-02-08 23:22:53','127.0.0.1','Firefox','Ubuntu',1,'2016-02-08 23:22:32','2016-02-08 17:52:53'),(7,2,'2016-02-08 23:22:58',NULL,'127.0.0.1','Firefox','Ubuntu',1,'2016-02-08 23:22:58','2016-02-08 17:52:58'),(8,2,'2016-02-08 23:24:10',NULL,'127.0.0.1','Firefox','Ubuntu',1,'2016-02-08 23:24:10','2016-02-08 17:54:10'),(9,2,'2016-02-09 12:29:57',NULL,'127.0.0.1','Firefox','Ubuntu',1,'2016-02-09 12:29:57','2016-02-09 06:59:57'),(10,2,'2016-02-09 18:08:32',NULL,'127.0.0.1','Firefox','Ubuntu',1,'2016-02-09 18:08:32','2016-02-09 12:38:32'),(11,2,'2016-02-09 22:33:06',NULL,'127.0.0.1','Firefox','Ubuntu',1,'2016-02-09 22:33:06','2016-02-09 17:03:06'),(12,2,'2016-02-10 10:48:19',NULL,'127.0.0.1','Firefox','Ubuntu',1,'2016-02-10 10:48:19','2016-02-10 05:18:19'),(13,2,'2016-02-10 11:44:45',NULL,'127.0.0.1','Firefox','Ubuntu',1,'2016-02-10 11:44:45','2016-02-10 06:14:45'),(14,2,'2016-02-10 15:25:01','2016-02-10 15:30:03','127.0.0.1','Firefox','Ubuntu',1,'2016-02-10 15:25:01','2016-02-10 10:00:03'),(15,2,'2016-02-10 15:34:43',NULL,'127.0.0.1','Firefox','Ubuntu',1,'2016-02-10 15:34:43','2016-02-10 10:04:43');
/*!40000 ALTER TABLE `user_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
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
  `requested_by` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Super','Admin','superadmin','vijay.ch1405@gmail.com','8008374974','73c6f70b1e52853eff0eef8964cf00d33a707793',2001,0,'2016-02-07 14:22:36',1,'2016-02-07 10:45:00','2016-02-07 08:52:36',2,0),(2,'mahesh','kumar','maheshkumar','mahesh@gmail.com','9052467551','73c6f70b1e52853eff0eef8964cf00d33a707793',2001,0,'2016-02-10 15:34:43',1,'2016-02-08 17:32:00','2016-02-10 10:04:43',15,1);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-10 19:05:26
