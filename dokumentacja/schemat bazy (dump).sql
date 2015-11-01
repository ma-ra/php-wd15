-- MySQL dump 10.13  Distrib 5.5.35, for CYGWIN (x86_64)
--
-- Host: 127.0.0.1    Database: wd15
-- ------------------------------------------------------
-- Server version	5.6.14

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
  `article_number` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `model_name` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `model_type` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `article_colli` int(11) NOT NULL DEFAULT '1',
  `article_all_textile_amount` decimal(9,2) DEFAULT NULL,
  `article_first_textile_amount` decimal(9,2) DEFAULT NULL,
  `article_second_textile_amount` decimal(9,2) DEFAULT NULL,
  `price_in_pg1` decimal(9,2) DEFAULT NULL,
  `price_in_pg2` decimal(9,2) DEFAULT NULL,
  `price_in_pg3` decimal(9,2) DEFAULT NULL,
  `price_in_pg4` decimal(9,2) DEFAULT NULL,
  `price_in_pg5` decimal(9,2) DEFAULT NULL,
  `price_in_pg6` decimal(9,2) DEFAULT NULL,
  `price_in_pg7` decimal(9,2) DEFAULT NULL,
  PRIMARY KEY (`article_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `broker`
--

DROP TABLE IF EXISTS `broker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `broker` (
  `broker_id` int(11) NOT NULL AUTO_INCREMENT,
  `broker_name` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`broker_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `buyer`
--

DROP TABLE IF EXISTS `buyer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `buyer` (
  `buyer_id` int(11) NOT NULL AUTO_INCREMENT,
  `buyer_name_1` varchar(150) COLLATE utf8_polish_ci NOT NULL,
  `buyer_name_2` varchar(150) COLLATE utf8_polish_ci DEFAULT NULL,
  `buyer_street` varchar(150) COLLATE utf8_polish_ci NOT NULL,
  `buyer_zip_code` varchar(150) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`buyer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `configuration`
--

DROP TABLE IF EXISTS `configuration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `configuration` (
  `name` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  `value` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fabric_collection`
--

DROP TABLE IF EXISTS `fabric_collection`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fabric_collection` (
  `fabric_id` int(11) NOT NULL AUTO_INCREMENT,
  `fabric_number` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `fabric_name` varchar(150) COLLATE utf8_polish_ci NOT NULL,
  `fabric_price_group` int(11) NOT NULL,
  `supplier_supplier_id` int(11) DEFAULT NULL,
  `fabric_price` decimal(9,2) NOT NULL,
  PRIMARY KEY (`fabric_id`),
  UNIQUE KEY `fabric_number_UNIQUE` (`fabric_number`),
  KEY `fk_fabric_collection_supplier1_idx` (`supplier_supplier_id`),
  CONSTRAINT `fk_fabric_collection_supplier1` FOREIGN KEY (`supplier_supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `for_reuse`
--

DROP TABLE IF EXISTS `for_reuse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `for_reuse` (
  `for_reuse_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `article_number` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `textile1_number` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `textile2_number` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`for_reuse_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `leg`
--

DROP TABLE IF EXISTS `leg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `leg` (
  `leg_id` int(11) NOT NULL AUTO_INCREMENT,
  `leg_type` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`leg_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_time` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `route` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `actionaction` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `params` varchar(500) COLLATE utf8_polish_ci DEFAULT NULL,
  `info` varchar(500) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `manufacturer`
--

DROP TABLE IF EXISTS `manufacturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `manufacturer` (
  `manufacturer_id` int(11) NOT NULL AUTO_INCREMENT,
  `manufacturer_number` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `manufacturer_name` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`manufacturer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `order_date` datetime DEFAULT NULL,
  `buyer_order_number` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `buyer_comments` varchar(150) COLLATE utf8_polish_ci DEFAULT NULL,
  `order_reference` varchar(150) COLLATE utf8_polish_ci DEFAULT NULL,
  `order_term` varchar(50) COLLATE utf8_polish_ci NOT NULL,
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
  `order_price` decimal(9,2) DEFAULT NULL,
  `order_total_price` decimal(9,2) DEFAULT NULL,
  `shopping1_shopping_id` int(11) DEFAULT NULL,
  `shopping2_shopping_id` int(11) DEFAULT NULL,
  `printed_minilabel` datetime DEFAULT NULL,
  `printed_shipping_label` datetime DEFAULT NULL,
  `textile_prepared` int(11) NOT NULL DEFAULT '0',
  `article_planed` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `article_manufactured` int(11) NOT NULL DEFAULT '0',
  `article_prepared_to_export` int(11) NOT NULL DEFAULT '0',
  `article_exported` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `article_canceled` int(11) NOT NULL DEFAULT '0',
  `order_error` varchar(50) CHARACTER SET latin2 DEFAULT NULL,
  `order_notes` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `order_add_date` datetime NOT NULL,
  `order_storno_date` datetime DEFAULT NULL,
  `checked` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`order_id`),
  KEY `fk_order_buyer_idx` (`buyer_buyer_id`),
  KEY `fk_order_broker1_idx` (`broker_broker_id`),
  KEY `fk_order_manufacturer1_idx` (`manufacturer_manufacturer_id`),
  KEY `fk_order_leg1_idx` (`leg_leg_id`),
  KEY `fk_order_article1_idx` (`article_article_id`),
  KEY `fk_order_textile1_idx` (`textile1_textile_id`),
  KEY `fk_order_textile2_idx` (`textile2_textile_id`),
  KEY `fk_order_shopping1_idx` (`shopping1_shopping_id`),
  KEY `fk_order_shopping2_idx` (`shopping2_shopping_id`),
  CONSTRAINT `fk_order_article1` FOREIGN KEY (`article_article_id`) REFERENCES `article` (`article_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_broker1` FOREIGN KEY (`broker_broker_id`) REFERENCES `broker` (`broker_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_buyer` FOREIGN KEY (`buyer_buyer_id`) REFERENCES `buyer` (`buyer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_leg1` FOREIGN KEY (`leg_leg_id`) REFERENCES `leg` (`leg_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_manufacturer1` FOREIGN KEY (`manufacturer_manufacturer_id`) REFERENCES `manufacturer` (`manufacturer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_shopping1` FOREIGN KEY (`shopping1_shopping_id`) REFERENCES `shopping` (`shopping_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_shopping2` FOREIGN KEY (`shopping2_shopping_id`) REFERENCES `shopping` (`shopping_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_textile1` FOREIGN KEY (`textile1_textile_id`) REFERENCES `textile` (`textile_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_textile2` FOREIGN KEY (`textile2_textile_id`) REFERENCES `textile` (`textile_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `rap_shopping`
--

DROP TABLE IF EXISTS `rap_shopping`;
/*!50001 DROP VIEW IF EXISTS `rap_shopping`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `rap_shopping` (
  `textile_number` tinyint NOT NULL,
  `article_amount_sum` tinyint NOT NULL,
  `article_calculated_amount_sum` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `rap_textile`
--

DROP TABLE IF EXISTS `rap_textile`;
/*!50001 DROP VIEW IF EXISTS `rap_textile`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `rap_textile` (
  `textil_pair` tinyint NOT NULL,
  `supplier1_name` tinyint NOT NULL,
  `supplier1_number` tinyint NOT NULL,
  `supplier2_name` tinyint NOT NULL,
  `supplier2_number` tinyint NOT NULL,
  `textile1_selected` tinyint NOT NULL,
  `textile2_selected` tinyint NOT NULL,
  `order_number` tinyint NOT NULL,
  `order_reference` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `rap_textile2`
--

DROP TABLE IF EXISTS `rap_textile2`;
/*!50001 DROP VIEW IF EXISTS `rap_textile2`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `rap_textile2` (
  `supplier_name` tinyint NOT NULL,
  `textile_number` tinyint NOT NULL,
  `textile_name` tinyint NOT NULL,
  `order1_id` tinyint NOT NULL,
  `order1_number` tinyint NOT NULL,
  `order1_checked` tinyint NOT NULL,
  `order2_id` tinyint NOT NULL,
  `order2_number` tinyint NOT NULL,
  `order2_checked` tinyint NOT NULL,
  `textile1_selected` tinyint NOT NULL,
  `textile2_selected` tinyint NOT NULL,
  `textiles_selected` tinyint NOT NULL,
  `textile1_warehouse` tinyint NOT NULL,
  `textiles_ordered` tinyint NOT NULL,
  `textile_yet_need` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `rap_textile2-1`
--

DROP TABLE IF EXISTS `rap_textile2-1`;
/*!50001 DROP VIEW IF EXISTS `rap_textile2-1`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `rap_textile2-1` (
  `supplier_name` tinyint NOT NULL,
  `textile_number` tinyint NOT NULL,
  `textile_name` tinyint NOT NULL,
  `textiles_selected` tinyint NOT NULL,
  `textile1_warehouse` tinyint NOT NULL,
  `textiles_ordered` tinyint NOT NULL,
  `textile_yet_need` tinyint NOT NULL,
  `textile_yet_remained` tinyint NOT NULL,
  `order_ids` tinyint NOT NULL,
  `order1_ids` tinyint NOT NULL,
  `order2_ids` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `rap_warehouse`
--

DROP TABLE IF EXISTS `rap_warehouse`;
/*!50001 DROP VIEW IF EXISTS `rap_warehouse`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `rap_warehouse` (
  `article_number` tinyint NOT NULL,
  `article_count_sum` tinyint NOT NULL,
  `article_price_sum` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `shopping`
--

DROP TABLE IF EXISTS `shopping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shopping` (
  `shopping_id` int(11) NOT NULL AUTO_INCREMENT,
  `shopping_number` int(11) NOT NULL,
  `shopping_type` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `textile_textile_id` int(11) NOT NULL,
  `article_amount` decimal(9,2) DEFAULT NULL,
  `article_calculated_amount` decimal(9,2) NOT NULL,
  `shopping_term` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `shopping_date_of_shipment` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `shopping_scheduled_delivery` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `shopping_notes` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `shopping_status` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `shopping_printed` datetime DEFAULT NULL,
  `creation_time` datetime NOT NULL,
  PRIMARY KEY (`shopping_id`),
  KEY `fk_shopping_textile1_idx` (`textile_textile_id`),
  CONSTRAINT `fk_shopping_textile1` FOREIGN KEY (`textile_textile_id`) REFERENCES `textile` (`textile_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `supplier`
--

DROP TABLE IF EXISTS `supplier`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `supplier` (
  `supplier_id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_name` varchar(150) COLLATE utf8_polish_ci NOT NULL,
  `supplier_tel` varchar(45) COLLATE utf8_polish_ci DEFAULT NULL,
  `supplier_email` varchar(45) COLLATE utf8_polish_ci DEFAULT NULL,
  `supplier_lang` varchar(45) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `textile`
--

DROP TABLE IF EXISTS `textile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `textile` (
  `textile_id` int(11) NOT NULL AUTO_INCREMENT,
  `textile_number` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `textile_name` varchar(150) COLLATE utf8_polish_ci NOT NULL,
  `textile_price_group` int(11) NOT NULL,
  `supplier_supplier_id` int(11) DEFAULT NULL,
  `pattern` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`textile_id`),
  KEY `fk_textile_supplier1_idx` (`supplier_supplier_id`),
  KEY `fk_textile_warehouse1_idx` (`textile_number`),
  CONSTRAINT `fk_textile_supplier1` FOREIGN KEY (`supplier_supplier_id`) REFERENCES `supplier` (`supplier_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `warehouse`
--

DROP TABLE IF EXISTS `warehouse`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `warehouse` (
  `warehouse_id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse_type` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `article_number` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `article_name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `article_count` decimal(9,2) NOT NULL,
  `article_price` decimal(9,2) DEFAULT NULL,
  `document_name` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `warehouse_error` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL,
  `shopping_shopping_id` int(11) DEFAULT NULL,
  `warehouse_delivery_date` datetime DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  PRIMARY KEY (`warehouse_id`),
  KEY `fk_warehouse_shopping1_idx` (`shopping_shopping_id`),
  KEY `fk_warehouse_textile1_idx` (`article_number`),
  CONSTRAINT `fk_warehouse_shopping1` FOREIGN KEY (`shopping_shopping_id`) REFERENCES `shopping` (`shopping_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_warehouse_textile1` FOREIGN KEY (`article_number`) REFERENCES `textile` (`textile_number`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Final view structure for view `rap_shopping`
--

/*!50001 DROP TABLE IF EXISTS `rap_shopping`*/;
/*!50001 DROP VIEW IF EXISTS `rap_shopping`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`mara`@`localhost` SQL SECURITY INVOKER */
/*!50001 VIEW `rap_shopping` AS select `textile`.`textile_number` AS `textile_number`,sum(`shopping`.`article_amount`) AS `article_amount_sum`,sum(`shopping`.`article_calculated_amount`) AS `article_calculated_amount_sum` from ((`shopping` left join `textile` on((`shopping`.`textile_textile_id` = `textile`.`textile_id`))) left join `warehouse` on((`shopping`.`shopping_id` = `warehouse`.`shopping_shopping_id`))) where isnull(`warehouse`.`article_count`) group by `textile`.`textile_number` order by `textile`.`textile_number` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `rap_textile`
--

/*!50001 DROP TABLE IF EXISTS `rap_textile`*/;
/*!50001 DROP VIEW IF EXISTS `rap_textile`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`mara`@`localhost` SQL SECURITY INVOKER */
/*!50001 VIEW `rap_textile` AS select `order`.`textil_pair` AS `textil_pair`,`supplier1`.`supplier_name` AS `supplier1_name`,`textile1`.`textile_number` AS `supplier1_number`,`supplier2`.`supplier_name` AS `supplier2_name`,`textile2`.`textile_number` AS `supplier2_number`,sum(if(`order`.`textil_pair`,(`article`.`article_first_textile_amount` * `order`.`article_amount`),(`article`.`article_all_textile_amount` * `order`.`article_amount`))) AS `textile1_selected`,sum(if(`order`.`textil_pair`,(`article`.`article_second_textile_amount` * `order`.`article_amount`),NULL)) AS `textile2_selected`,group_concat(concat(' ',cast(`order`.`article_amount` as char charset utf8),'x ',`order`.`order_number`) separator ',') AS `order_number`,group_concat(concat(' (',`textile1`.`textile_name`,ifnull(concat(' ',`textile2`.`textile_name`,')'),')')) separator ',') AS `order_reference` from ((((((`order` left join `article` on((`order`.`article_article_id` = `article`.`article_id`))) left join `textile` `textile1` on((`order`.`textile1_textile_id` = `textile1`.`textile_id`))) left join `supplier` `supplier1` on((`textile1`.`supplier_supplier_id` = `supplier1`.`supplier_id`))) left join `textile` `textile2` on((`order`.`textile2_textile_id` = `textile2`.`textile_id`))) left join `supplier` `supplier2` on((`textile2`.`supplier_supplier_id` = `supplier2`.`supplier_id`))) left join `rap_warehouse` on((`rap_warehouse`.`article_number` = `textile1`.`textile_number`))) where (`order`.`checked` = 1) group by `order`.`textil_pair`,`supplier1`.`supplier_name`,`textile1`.`textile_number`,`supplier2`.`supplier_name`,`textile2`.`textile_number` order by `supplier1`.`supplier_name`,`supplier2`.`supplier_name`,`textile1`.`textile_number`,`textile2`.`textile_number` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `rap_textile2`
--

/*!50001 DROP TABLE IF EXISTS `rap_textile2`*/;
/*!50001 DROP VIEW IF EXISTS `rap_textile2`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`mara`@`localhost` SQL SECURITY INVOKER */
/*!50001 VIEW `rap_textile2` AS select `supplier`.`supplier_name` AS `supplier_name`,`textile`.`textile_number` AS `textile_number`,`textile`.`textile_name` AS `textile_name`,`order1`.`order_id` AS `order1_id`,`order1`.`order_number` AS `order1_number`,`order1`.`checked` AS `order1_checked`,`order2`.`order_id` AS `order2_id`,`order2`.`order_number` AS `order2_number`,`order2`.`checked` AS `order2_checked`,if(`order1`.`textil_pair`,(`article1`.`article_first_textile_amount` * `order1`.`article_amount`),(`article1`.`article_all_textile_amount` * `order1`.`article_amount`)) AS `textile1_selected`,(`article2`.`article_second_textile_amount` * `order2`.`article_amount`) AS `textile2_selected`,(ifnull(if(`order1`.`textil_pair`,(`article1`.`article_first_textile_amount` * `order1`.`article_amount`),(`article1`.`article_all_textile_amount` * `order1`.`article_amount`)),0) + ifnull((`article2`.`article_second_textile_amount` * `order2`.`article_amount`),0)) AS `textiles_selected`,ifnull(`rap_warehouse`.`article_count_sum`,0) AS `textile1_warehouse`,ifnull(`rap_shopping`.`article_amount_sum`,0) AS `textiles_ordered`,(((ifnull(if(`order1`.`textil_pair`,(`article1`.`article_first_textile_amount` * `order1`.`article_amount`),(`article1`.`article_all_textile_amount` * `order1`.`article_amount`)),0) + ifnull((`article2`.`article_second_textile_amount` * `order2`.`article_amount`),0)) - ifnull(`rap_warehouse`.`article_count_sum`,0)) - ifnull(`rap_shopping`.`article_amount_sum`,0)) AS `textile_yet_need` from (((((((`textile` left join `supplier` on((`textile`.`supplier_supplier_id` = `supplier`.`supplier_id`))) left join `rap_warehouse` on((`textile`.`textile_number` = `rap_warehouse`.`article_number`))) left join `rap_shopping` on((`textile`.`textile_number` = `rap_shopping`.`textile_number`))) left join `order` `order1` on((`textile`.`textile_id` = `order1`.`textile1_textile_id`))) left join `article` `article1` on((`order1`.`article_article_id` = `article1`.`article_id`))) left join `order` `order2` on((`textile`.`textile_id` = `order2`.`textile2_textile_id`))) left join `article` `article2` on((`order2`.`article_article_id` = `article2`.`article_id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `rap_textile2-1`
--

/*!50001 DROP TABLE IF EXISTS `rap_textile2-1`*/;
/*!50001 DROP VIEW IF EXISTS `rap_textile2-1`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`mara`@`localhost` SQL SECURITY INVOKER */
/*!50001 VIEW `rap_textile2-1` AS select `rap_textile2`.`supplier_name` AS `supplier_name`,`rap_textile2`.`textile_number` AS `textile_number`,max(`rap_textile2`.`textile_name`) AS `textile_name`,sum(`rap_textile2`.`textiles_selected`) AS `textiles_selected`,`rap_textile2`.`textile1_warehouse` AS `textile1_warehouse`,`rap_textile2`.`textiles_ordered` AS `textiles_ordered`,if((((sum(`rap_textile2`.`textiles_selected`) - `rap_textile2`.`textile1_warehouse`) - `rap_textile2`.`textiles_ordered`) > 0),((sum(`rap_textile2`.`textiles_selected`) - `rap_textile2`.`textile1_warehouse`) - `rap_textile2`.`textiles_ordered`),NULL) AS `textile_yet_need`,if((((sum(`rap_textile2`.`textiles_selected`) - `rap_textile2`.`textile1_warehouse`) - `rap_textile2`.`textiles_ordered`) < 0),(((sum(`rap_textile2`.`textiles_selected`) - `rap_textile2`.`textile1_warehouse`) - `rap_textile2`.`textiles_ordered`) * -(1)),NULL) AS `textile_yet_remained`,concat(ifnull(group_concat(`rap_textile2`.`order1_id` separator ','),''),if(group_concat(`rap_textile2`.`order1_id` separator ','),',',''),ifnull(group_concat(`rap_textile2`.`order2_id` separator ','),'')) AS `order_ids`,concat(ifnull(group_concat(`rap_textile2`.`order1_id` separator ','),''),if(group_concat(`rap_textile2`.`order1_id` separator ','),',','')) AS `order1_ids`,concat(ifnull(group_concat(`rap_textile2`.`order2_id` separator ','),''),if(group_concat(`rap_textile2`.`order2_id` separator ','),',','')) AS `order2_ids` from `rap_textile2` where ((`rap_textile2`.`order1_checked` = 1) or (`rap_textile2`.`order2_checked` = 1)) group by `rap_textile2`.`supplier_name`,`rap_textile2`.`textile_number`,`rap_textile2`.`textile1_warehouse`,`rap_textile2`.`textiles_ordered` order by `rap_textile2`.`textile_number` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `rap_warehouse`
--

/*!50001 DROP TABLE IF EXISTS `rap_warehouse`*/;
/*!50001 DROP VIEW IF EXISTS `rap_warehouse`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`mara`@`localhost` SQL SECURITY INVOKER */
/*!50001 VIEW `rap_warehouse` AS select `warehouse`.`article_number` AS `article_number`,sum(`warehouse`.`article_count`) AS `article_count_sum`,sum(`warehouse`.`article_price`) AS `article_price_sum` from `warehouse` group by `warehouse`.`article_number` order by `warehouse`.`article_number` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-11-01 21:08:36
