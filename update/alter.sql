-- zmiana typu atrybutów w tabeli article z przeliczeniem wartości pod nowy typ
ALTER TABLE `article` CHANGE `article_all_textile_amount` `article_all_textile_amount` DECIMAL(9,2) NULL DEFAULT NULL;
UPDATE article SET article_all_textile_amount=article_all_textile_amount/10 WHERE 1;

ALTER TABLE `article` CHANGE `article_first_textile_amount` `article_first_textile_amount` DECIMAL(9,2) NULL DEFAULT NULL;
UPDATE article SET article_first_textile_amount=article_first_textile_amount/10 WHERE 1;

ALTER TABLE `article` CHANGE `article_second_textile_amount` `article_second_textile_amount` DECIMAL(9,2) NULL DEFAULT NULL;
UPDATE article SET article_second_textile_amount=article_second_textile_amount/10 WHERE 1;

-- dodanie atrybutów do order
ALTER TABLE `order` ADD `shopping_shopping_id` INT(11) NULL DEFAULT NULL AFTER `textile2_textile_id`;
ALTER TABLE `order` ADD `article_planed` INT(11) NOT NULL DEFAULT '0' AFTER `textile_prepared`;
ALTER TABLE `order` ADD `article_prepared_to_export` INT(11) NOT NULL DEFAULT '0' AFTER `article_manufactured`;

ALTER TABLE `order` ADD INDEX `fk_order_shopping1_idx` (`shopping_shopping_id`);
ALTER TABLE `order` ADD CONSTRAINT `fk_order_shopping1` FOREIGN KEY (`shopping_shopping_id`) REFERENCES `shopping`(`shopping_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

-- dodanie i usunięcie atrybutów do i z supplier; zmiana relacji z textile
ALTER TABLE `supplier` ADD `supplier_lang` VARCHAR(45) NOT NULL ;

ALTER TABLE `supplier` DROP FOREIGN KEY `fk_supplier_textile1`;
ALTER TABLE `supplier` DROP INDEX fk_supplier_textile1_idx;
ALTER TABLE `supplier` DROP `textile_textile_id`;

-- dodanie atrybutów do textile; zmiana relacji z supplier i index pod nową relację z warehouse
ALTER TABLE `textile` ADD `supplier_supplier_id` INT(11) NULL ;

ALTER TABLE `textile` ADD INDEX `fk_textile_supplier1_idx` (`supplier_supplier_id`);
ALTER TABLE `textile` ADD CONSTRAINT `fk_textile_supplier1` FOREIGN KEY (`supplier_supplier_id`) REFERENCES `supplier`(`supplier_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE `textile` ADD INDEX `fk_textile_warehouse1_idx` (`textile_number`);

-- dodanie tabeli log
CREATE TABLE `log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `creation_time` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `route` varchar(50) NOT NULL,
  `actionaction` varchar(50) NOT NULL,
  `params` varchar(500) DEFAULT NULL,
  `info` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`log_id`)
);

-- dodanie tabeli shoping
CREATE TABLE `shopping` (
  `shopping_id` int(11) NOT NULL AUTO_INCREMENT,
  `shopping_type` varchar(50) NOT NULL,
  `textile_textile_id` int(11) NOT NULL,
  `article_amount` decimal(9,2) DEFAULT NULL,
  `article_calculated_amount` varchar(50) NOT NULL,
  `shopping_term` datetime DEFAULT NULL,
  `shopping_status` varchar(50) DEFAULT NULL,
  `shopping_printed` datetime DEFAULT NULL,
  `creation_time` datetime NOT NULL,
  PRIMARY KEY (`shopping_id`),
  KEY `fk_shopping_textile1_idx` (`textile_textile_id`),
  CONSTRAINT `fk_shopping_textile1` FOREIGN KEY (`textile_textile_id`) REFERENCES `textile` (`textile_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
);

-- dodanie tabeli warehouse
CREATE TABLE `warehouse` (
  `warehouse_id` INT NOT NULL AUTO_INCREMENT,
  `warehouse_type` VARCHAR(50) NOT NULL,
  `article_number` VARCHAR(50) NOT NULL,
  `article_name` VARCHAR(50) NOT NULL,
  `article_count` DECIMAL(9,2) NOT NULL,
  `article_price` DECIMAL(9,2) NULL,
  `document_name` VARCHAR(50) NOT NULL,
  `warehouse_error` VARCHAR(50) NULL,
  `shopping_shopping_id` INT NULL,
  `creation_date` DATETIME NOT NULL,
  PRIMARY KEY (`warehouse_id`),
  KEY `fk_warehouse_shopping1_idx` (`shopping_shopping_id`),
  CONSTRAINT `fk_warehouse_shopping1` FOREIGN KEY (`shopping_shopping_id`) REFERENCES `shopping` (`shopping_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  KEY `fk_warehouse_textile1_idx` (`article_number`),
  CONSTRAINT `fk_warehouse_textile1` FOREIGN KEY (`article_number`) REFERENCES `textile` (`textile_number`) ON DELETE NO ACTION ON UPDATE NO ACTION
  
);
