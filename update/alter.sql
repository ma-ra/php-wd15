ALTER TABLE `order` ADD `order_notes` VARCHAR(50) NULL AFTER `order_error`;

ALTER TABLE `shopping` CHANGE `shopping_term` `shopping_term` VARCHAR(50) NULL DEFAULT NULL;
ALTER TABLE `shopping` ADD `shopping_date_of_shipment` VARCHAR(50) NULL AFTER `shopping_term`, ADD `shopping_scheduled_delivery` VARCHAR(50) NULL AFTER `shopping_date_of_shipment`, ADD `shopping_notes` VARCHAR(50) NULL AFTER `shopping_scheduled_delivery`;

ALTER TABLE `warehouse` ADD `warehouse_delivery_date` VARCHAR(50) NULL AFTER `shopping_shopping_id`;
ALTER TABLE `warehouse` CHANGE `warehouse_delivery_date` `warehouse_delivery_date` DATETIME NULL DEFAULT NULL;
