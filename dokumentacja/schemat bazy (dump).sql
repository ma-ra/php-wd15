-- MySQL dump 10.13  Distrib 5.5.40, for CYGWIN (x86_64)
--
-- Host: 127.0.0.1    Database: wd15
-- ------------------------------------------------------
-- Server version	5.6.19
-- mysqldump -d wd15 |  sed 's/AUTO_INCREMENT=[0-9][0-9]*//' > schemat\ bazy\ \(dump\).sql

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
-- Table structure for table `article`
--

DROP TABLE IF EXISTS `article`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `article_number` varchar(50) NOT NULL,
  `model_name` varchar(100) NOT NULL,
  `model_type` varchar(100) NOT NULL,
  `article_colli` int(11) NOT NULL DEFAULT '1',
  `article_all_textile_amount` int(11) DEFAULT NULL,
  `article_first_textile_amount` int(11) DEFAULT NULL,
  `article_second_textile_amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `broker`
--

DROP TABLE IF EXISTS `broker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `broker` (
  `broker_id` int(11) NOT NULL AUTO_INCREMENT,
  `broker_name` varchar(100) NOT NULL,
  PRIMARY KEY (`broker_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `buyer`
--

DROP TABLE IF EXISTS `buyer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buyer` (
  `buyer_id` int(11) NOT NULL AUTO_INCREMENT,
  `buyer_name_1` varchar(150) NOT NULL,
  `buyer_name_2` varchar(150) DEFAULT NULL,
  `buyer_street` varchar(150) NOT NULL,
  `buyer_zip_code` varchar(150) NOT NULL,
  PRIMARY KEY (`buyer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `configuration`
--

DROP TABLE IF EXISTS `configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuration` (
  `name` varchar(45) NOT NULL,
  `value` varchar(45) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin2;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `leg`
--

DROP TABLE IF EXISTS `leg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leg` (
  `leg_id` int(11) NOT NULL AUTO_INCREMENT,
  `leg_type` varchar(45) NOT NULL,
  PRIMARY KEY (`leg_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `manufacturer`
--

DROP TABLE IF EXISTS `manufacturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `manufacturer` (
  `manufacturer_id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer_number` varchar(50) NOT NULL,
  `manufacturer_name` varchar(100) NOT NULL,
  PRIMARY KEY (`manufacturer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` varchar(50) NOT NULL,
  `order_date` datetime DEFAULT NULL,
  `buyer_order_number` varchar(50) DEFAULT NULL,
  `buyer_comments` varchar(150) DEFAULT NULL,
  `order_reference` varchar(150) DEFAULT NULL,
  `order_term` varchar(50) NOT NULL,
  `article_amount` int(11) NOT NULL,
  `buyer_buyer_id` int(11) NOT NULL,
  `broker_broker_id` int(11) NOT NULL,
  `manufacturer_manufacturer_id` int(11) NOT NULL,
  `leg_leg_id` int(11) NOT NULL,
  `article_article_id` int(11) NOT NULL,
  `textil_pair` int(11) DEFAULT NULL,
  `textilpair_price_group` int(11) DEFAULT NULL,
  `textile1_textile_id` int(11) NOT NULL,
  `textile2_textile_id` int(11) DEFAULT NULL,
  `printed_minilabel` datetime DEFAULT NULL,
  `printed_shipping_label` datetime DEFAULT NULL,
  `textile_prepared` int(11) NOT NULL DEFAULT '0',
  `article_manufactured` int(11) NOT NULL DEFAULT '0',
  `article_exported` varchar(50) DEFAULT NULL,
  `article_canceled` int(11) NOT NULL DEFAULT '0',
  `order_error` varchar(50) DEFAULT NULL,
  `order_add_date` datetime NOT NULL,
  `checked` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_id`),
  KEY `fk_order_buyer_idx` (`buyer_buyer_id`),
  KEY `fk_order_broker1_idx` (`broker_broker_id`),
  KEY `fk_order_manufacturer1_idx` (`manufacturer_manufacturer_id`),
  KEY `fk_order_leg1_idx` (`leg_leg_id`),
  KEY `fk_order_article1_idx` (`article_article_id`),
  KEY `fk_order_textile1_idx` (`textile1_textile_id`),
  KEY `fk_order_textile2_idx` (`textile2_textile_id`),
  CONSTRAINT `fk_order_article1` FOREIGN KEY (`article_article_id`) REFERENCES `article` (`article_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_broker1` FOREIGN KEY (`broker_broker_id`) REFERENCES `broker` (`broker_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_buyer` FOREIGN KEY (`buyer_buyer_id`) REFERENCES `buyer` (`buyer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_leg1` FOREIGN KEY (`leg_leg_id`) REFERENCES `leg` (`leg_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_manufacturer1` FOREIGN KEY (`manufacturer_manufacturer_id`) REFERENCES `manufacturer` (`manufacturer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_textile1` FOREIGN KEY (`textile1_textile_id`) REFERENCES `textile` (`textile_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_textile2` FOREIGN KEY (`textile2_textile_id`) REFERENCES `textile` (`textile_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB  DEFAULT CHARSET=latin2;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(150) NOT NULL,
  `supplier_tel` varchar(45) DEFAULT NULL,
  `supplier_email` varchar(45) DEFAULT NULL,
  `textile_textile_id` int(11) NOT NULL,
  PRIMARY KEY (`supplier_id`),
  KEY `fk_supplier_textile1_idx` (`textile_textile_id`),
  CONSTRAINT `fk_supplier_textile1` FOREIGN KEY (`textile_textile_id`) REFERENCES `textile` (`textile_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin2;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `textile`
--

DROP TABLE IF EXISTS `textile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `textile` (
  `textile_id` int(11) NOT NULL AUTO_INCREMENT,
  `textile_number` varchar(50) NOT NULL,
  `textile_name` varchar(150) NOT NULL,
  `textile_price_group` int(11) NOT NULL,
  PRIMARY KEY (`textile_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-04-15  8:33:36
