CREATE TABLE `delivery_address` (
  `delivery_address_id` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_address_name_1` varchar(150) COLLATE utf8_polish_ci NOT NULL,
  `delivery_address_name_2` varchar(150) COLLATE utf8_polish_ci DEFAULT NULL,
  `delivery_address_street` varchar(150) COLLATE utf8_polish_ci NOT NULL,
  `delivery_address_zip_code` varchar(150) COLLATE utf8_polish_ci NOT NULL,
  `delivery_address_city` varchar(150) COLLATE utf8_polish_ci NOT NULL,
  `delivery_address_contact` varchar(150) COLLATE utf8_polish_ci DEFAULT NULL,
  PRIMARY KEY (`delivery_address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;
