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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

