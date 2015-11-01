ALTER TABLE `fabric_collection` DROP INDEX `fabric_number`;
ALTER TABLE fabric_collection ADD UNIQUE `fabric_number_UNIQUE` (`fabric_number`) COMMENT '';
ALTER TABLE `fabric_collection` ADD INDEX `fk_fabric_collection_supplier1_idx` ( `supplier_supplier_id` ) COMMENT '';
ALTER TABLE `fabric_collection` ADD CONSTRAINT `fk_fabric_collection_supplier1` FOREIGN KEY ( `supplier_supplier_id` ) REFERENCES `wd15`.`supplier` (`supplier_id`) ON DELETE NO ACTION ON UPDATE NO ACTION ;
