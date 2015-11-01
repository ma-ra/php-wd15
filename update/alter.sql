ALTER TABLE `fabric_collection` DROP INDEX `fabric_number`;
ALTER TABLE fabric_collection ADD UNIQUE `fabric_number_UNIQUE` (`fabric_number`) COMMENT '';
ALTER TABLE `fabric_collection` ADD INDEX `fk_fabric_collection_supplier1_idx` ( `supplier_supplier_id` ) COMMENT '';
ALTER TABLE `fabric_collection` ADD CONSTRAINT `fk_fabric_collection_supplier1` FOREIGN KEY ( `supplier_supplier_id` ) REFERENCES `wd15`.`supplier` (`supplier_id`) ON DELETE NO ACTION ON UPDATE NO ACTION ;

ALTER TABLE `supplier` ADD `bank_account` VARCHAR( 100 ) NULL AFTER `supplier_email` ;

ALTER TABLE `textile` DROP FOREIGN KEY `fk_textile_supplier1` ;
ALTER TABLE `textile` DROP INDEX `fk_textile_supplier1_idx` ;
ALTER TABLE `textile` DROP `supplier_supplier_id`, DROP `pattern`;

ALTER TABLE `warehouse` DROP FOREIGN KEY `fk_warehouse_textile1` ;
ALTER TABLE `warehouse` DROP FOREIGN KEY `fk_warehouse_shopping1` ;
DROP TABLE `warehouse`;
ALTER TABLE `textile` DROP INDEX `fk_textile_warehouse1_idx` ;

ALTER TABLE `shopping` DROP FOREIGN KEY `fk_shopping_textile1` ;
ALTER TABLE `shopping` CHANGE `textile_textile_id` `fabric_collection_fabric_id` INT( 11 ) NOT NULL ;
ALTER TABLE `shopping` CHANGE `article_amount` `article_amount` DECIMAL( 9, 2 ) NOT NULL ;
ALTER TABLE `shopping` ADD `article_delivered_amount` DECIMAL( 9, 2 ) NULL AFTER `shopping_scheduled_delivery` ;
ALTER TABLE `shopping` ADD `article_price` DECIMAL( 9, 2 ) NULL AFTER `article_delivered_amount` ;
ALTER TABLE `shopping` ADD `document_name` VARCHAR( 150 ) NULL AFTER `article_price` , ADD `invoice_name` VARCHAR( 150 ) NULL AFTER `document_name` ;
ALTER TABLE `shopping` ADD `shopping_delivery_date` DATETIME NULL AFTER `shopping_date_of_shipment` ;
ALTER TABLE `shopping` ADD `paid` INT NOT NULL DEFAULT '0' AFTER `shopping_status` ;
ALTER TABLE `shopping` CHANGE `article_calculated_amount` `article_calculated_amount` DECIMAL( 9, 2 ) NULL ;
ALTER TABLE `shopping` CHANGE `shopping_status` `shopping_status` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL ;

ALTER TABLE shopping DROP INDEX fk_shopping_textile1_idx ;
ALTER TABLE `wd15`.`shopping` ADD INDEX `fk_shopping_fabric_collection1_idx` ( `fabric_collection_fabric_id` ) COMMENT '';

ALTER TABLE `wd15`.`textile` ADD INDEX `fk_textile_fabric_collection1_idx` ( `textile_number` ) COMMENT '';
