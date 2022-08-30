-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: bank_db2
-- ------------------------------------------------------
-- Server version	5.7.18-log

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

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `gender` char(1) NOT NULL,
  `dob` date NOT NULL,
  `relationship` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `login_id` varchar(255) NOT NULL,
  `pwd` varchar(32) NOT NULL,
  `lastlogin` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`login_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','M','1994-01-01','unmarried','developer','globsyn kolkata','18003004000','admin','admin','0000-00-00 00:00:00'),(3,'admin3','M','2018-07-26','married','developer','karaoli 3','6988803942','admin3','A312345678!','2018-07-27 00:00:00'),(4,'admin2','M','2018-07-03','married','finance','karaoli 52','698885454','admin2','A212345678!','2018-07-29 00:00:00'),(5,'admin4','F','2018-07-16','unmarried','finance','zirias 11','6988803212','admin4','Aa412345678!','2018-07-30 00:00:00');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `atm`
--

DROP TABLE IF EXISTS `atm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `atm` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cust_name` varchar(255) NOT NULL,
  `account_no` int(10) NOT NULL,
  `atm_status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `atm`
--

LOCK TABLES `atm` WRITE;
/*!40000 ALTER TABLE `atm` DISABLE KEYS */;
/*!40000 ALTER TABLE `atm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beneficiary1`
--

DROP TABLE IF EXISTS `beneficiary1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beneficiary1` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `sender_id` int(10) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `reciever_id` int(10) NOT NULL,
  `reciever_name` varchar(255) NOT NULL,
  `status` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beneficiary1`
--

LOCK TABLES `beneficiary1` WRITE;
/*!40000 ALTER TABLE `beneficiary1` DISABLE KEYS */;
INSERT INTO `beneficiary1` VALUES (21,47,'Marilena',48,'Dimitris','ACTIVE'),(22,48,'Dimitris',47,'Marilena','ACTIVE');
/*!40000 ALTER TABLE `beneficiary1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cheque_book`
--

DROP TABLE IF EXISTS `cheque_book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cheque_book` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `cust_name` varchar(255) NOT NULL,
  `account_no` int(10) NOT NULL,
  `cheque_book_status` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cheque_book`
--

LOCK TABLES `cheque_book` WRITE;
/*!40000 ALTER TABLE `cheque_book` DISABLE KEYS */;
INSERT INTO `cheque_book` VALUES (1,'',0,'PENDING'),(2,'',0,'PENDING');
/*!40000 ALTER TABLE `cheque_book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `gender` char(1) NOT NULL,
  `dob` date NOT NULL,
  `nominee` varchar(255) NOT NULL,
  `account` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `mobile` varchar(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `ifsc` varchar(255) NOT NULL,
  `lastlogin` datetime NOT NULL,
  `accstatus` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (47,'Marilena','F','1993-11-23','Alexis','current','irinis','6988888888','marilena@gmail.com','dbbfac62310ea57dbdb41684456f729e6540e652','THESSALONIKI','B6A9E','2018-07-30 07:28:54','ACTIVE'),(48,'Dimitris','M','1993-04-26','Katerina','current','zirias','6988888889','dimgiatz@gmail.com','f1bbe8c65ab5beb02353dcd4e3ef2585f79b08f0','ATHENS','K421A','2018-07-30 10:13:10','ACTIVE'),(50,'Kostas','M','1990-07-17','Giorgos','current','karaoli 32','6988809996','kostas@gmail.com','433e26ad64c9fd4c31049b9dc7f5057cdca6495c','PATRA','D30AC','2018-07-29 07:55:30','ACTIVE'),(51,'Natalia','M','1990-07-16','Giorgos','savings','irakleiou 5','6988809999','natalia@gmail.com','112a474f20f234c80a0f516fcab1d4a0b711c47e','ATHENS','K421A','2018-07-29 07:55:08','ACTIVE');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `passbook47`
--

DROP TABLE IF EXISTS `passbook47`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `passbook47` (
  `transactionid` int(5) NOT NULL AUTO_INCREMENT,
  `transactiondate` date DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `ifsc` varchar(255) DEFAULT NULL,
  `credit` int(10) DEFAULT NULL,
  `debit` int(10) DEFAULT NULL,
  `amount` float(10,2) DEFAULT NULL,
  `narration` varchar(255) NOT NULL,
  PRIMARY KEY (`transactionid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `passbook47`
--

LOCK TABLES `passbook47` WRITE;
/*!40000 ALTER TABLE `passbook47` DISABLE KEYS */;
INSERT INTO `passbook47` VALUES (1,'2018-01-01','Marilena','THESSALONIKI','B6A9E',1000,0,1000.00,'Account Open'),(2,'2018-07-29','Marilena','THESSALONIKI','B6A9E',100,0,1100.00,'BY Dimitris');
/*!40000 ALTER TABLE `passbook47` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `passbook48`
--

DROP TABLE IF EXISTS `passbook48`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `passbook48` (
  `transactionid` int(5) NOT NULL AUTO_INCREMENT,
  `transactiondate` date DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `ifsc` varchar(255) DEFAULT NULL,
  `credit` int(10) DEFAULT NULL,
  `debit` int(10) DEFAULT NULL,
  `amount` float(10,2) DEFAULT NULL,
  `narration` varchar(255) NOT NULL,
  PRIMARY KEY (`transactionid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `passbook48`
--

LOCK TABLES `passbook48` WRITE;
/*!40000 ALTER TABLE `passbook48` DISABLE KEYS */;
INSERT INTO `passbook48` VALUES (1,'2018-01-01','Dimitris','ATHENS','K421A',1000,0,1000.00,'Account Open'),(2,'2018-07-29','Dimitris','ATHENS','K421A',0,100,900.00,'TO Marilena');
/*!40000 ALTER TABLE `passbook48` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `passbook50`
--

DROP TABLE IF EXISTS `passbook50`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `passbook50` (
  `transactionid` int(5) NOT NULL AUTO_INCREMENT,
  `transactiondate` date DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `ifsc` varchar(255) DEFAULT NULL,
  `credit` int(10) DEFAULT NULL,
  `debit` int(10) DEFAULT NULL,
  `amount` float(10,2) DEFAULT NULL,
  `narration` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`transactionid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `passbook50`
--

LOCK TABLES `passbook50` WRITE;
/*!40000 ALTER TABLE `passbook50` DISABLE KEYS */;
INSERT INTO `passbook50` VALUES (1,'2018-07-29','Kostas','PATRA','D30AC',1000,0,1000.00,'Account Open');
/*!40000 ALTER TABLE `passbook50` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `passbook51`
--

DROP TABLE IF EXISTS `passbook51`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `passbook51` (
  `transactionid` int(5) NOT NULL AUTO_INCREMENT,
  `transactiondate` date DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `ifsc` varchar(255) DEFAULT NULL,
  `credit` int(10) DEFAULT NULL,
  `debit` int(10) DEFAULT NULL,
  `amount` float(10,2) DEFAULT NULL,
  `narration` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`transactionid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `passbook51`
--

LOCK TABLES `passbook51` WRITE;
/*!40000 ALTER TABLE `passbook51` DISABLE KEYS */;
INSERT INTO `passbook51` VALUES (1,'2018-07-29','Natalia','ATHENS','K421A',1000,0,1000.00,'Account Open');
/*!40000 ALTER TABLE `passbook51` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-08-01 18:16:32
