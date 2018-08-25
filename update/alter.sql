ALTER TABLE `article` ADD `model_description` VARCHAR(450) DEFAULT NULL AFTER `model_type`;

ALTER TABLE `buyer` ADD `buyer_city` VARCHAR(150) NOT NULL AFTER `buyer_zip_code`;
ALTER TABLE `buyer` ADD `buyer_contact` VARCHAR(150) DEFAULT NULL AFTER `buyer_city`;

ALTER TABLE `order` ADD `order_EAN_number` VARCHAR(150) DEFAULT NULL AFTER `order_reference`;
ALTER TABLE `order` ADD `delivery_address_delivery_address_id` INT(11) DEFAULT NULL AFTER `buyer_buyer_id`;
ALTER TABLE `order` ADD `textile3_textile_id` INT(11) DEFAULT NULL AFTER `textile2_textile_id`;
ALTER TABLE `order` ADD `textile4_textile_id` INT(11) DEFAULT NULL AFTER `textile3_textile_id`;
ALTER TABLE `order` ADD `textile5_textile_id` INT(11) DEFAULT NULL AFTER `textile4_textile_id`;
ALTER TABLE `order` ADD `shopping3_shopping_id` INT(11) DEFAULT NULL AFTER `shopping2_shopping_id`;
ALTER TABLE `order` ADD `shopping4_shopping_id` INT(11) DEFAULT NULL AFTER `shopping3_shopping_id`;
ALTER TABLE `order` ADD `shopping5_shopping_id` INT(11) DEFAULT NULL AFTER `shopping4_shopping_id`;

ALTER TABLE `order` ADD INDEX `fk_order_textile3_idx` ( `textile3_textile_id` ) COMMENT '';
ALTER TABLE `order` ADD INDEX `fk_order_textile4_idx` ( `textile4_textile_id` ) COMMENT '';
ALTER TABLE `order` ADD INDEX `fk_order_textile5_idx` ( `textile5_textile_id` ) COMMENT '';
ALTER TABLE `order` ADD INDEX `fk_order_shopping3_idx` ( `shopping3_shopping_id` ) COMMENT '';
ALTER TABLE `order` ADD INDEX `fk_order_shopping4_idx` ( `shopping4_shopping_id` ) COMMENT '';
ALTER TABLE `order` ADD INDEX `fk_order_shopping5_idx` ( `shopping5_shopping_id` ) COMMENT '';
ALTER TABLE `order` ADD INDEX `fk_order_delivery_address1_idx` ( `delivery_address_delivery_address_id` ) COMMENT '';

ALTER TABLE `order` ADD CONSTRAINT `fk_order_textile3` FOREIGN KEY ( `textile3_textile_id` ) REFERENCES `textile` (`textile_id`) ON DELETE NO ACTION ON UPDATE NO ACTION ;
ALTER TABLE `order` ADD CONSTRAINT `fk_order_textile4` FOREIGN KEY ( `textile4_textile_id` ) REFERENCES `textile` (`textile_id`) ON DELETE NO ACTION ON UPDATE NO ACTION ;
ALTER TABLE `order` ADD CONSTRAINT `fk_order_textile5` FOREIGN KEY ( `textile5_textile_id` ) REFERENCES `textile` (`textile_id`) ON DELETE NO ACTION ON UPDATE NO ACTION ;
ALTER TABLE `order` ADD CONSTRAINT `fk_order_shopping3` FOREIGN KEY ( `shopping3_shopping_id` ) REFERENCES `shopping` (`shopping_id`) ON DELETE NO ACTION ON UPDATE NO ACTION ;
ALTER TABLE `order` ADD CONSTRAINT `fk_order_shopping4` FOREIGN KEY ( `shopping4_shopping_id` ) REFERENCES `shopping` (`shopping_id`) ON DELETE NO ACTION ON UPDATE NO ACTION ;
ALTER TABLE `order` ADD CONSTRAINT `fk_order_shopping5` FOREIGN KEY ( `shopping5_shopping_id` ) REFERENCES `shopping` (`shopping_id`) ON DELETE NO ACTION ON UPDATE NO ACTION ;
ALTER TABLE `order` ADD CONSTRAINT `fk_order_delivery_address1` FOREIGN KEY ( `delivery_address_delivery_address_id` ) REFERENCES `delivery_address` (`delivery_address_id`) ON DELETE NO ACTION ON UPDATE NO ACTION ;

ALTER TABLE `textile` ADD `textile_description` VARCHAR(150) DEFAULT NULL AFTER `textile_name`;
