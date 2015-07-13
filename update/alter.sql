-- dzięki temu działa filtr ">0" na kolumnie błąd; ma to związek z porównaniem znaku "|" do "0"; w latin2 |>0, co nie sprawdza się w UTF
ALTER TABLE `order` CHANGE `order_error` `order_error` VARCHAR(50) CHARACTER SET latin2 COLLATE latin2_general_ci NULL DEFAULT NULL;

-- dodajemy kolumnę
ALTER TABLE `textile` ADD `pattern` BOOLEAN NULL DEFAULT NULL ;

-- jednodeseniowe ustawiamy jako wzór
UPDATE `textile` SET pattern=1 WHERE `textile_price_group` != 0;

-- występujące tylko w wersji wielodeseniowej ustawiamy ręcznie
INSERT INTO `wd15`.`textile` (`textile_number`, `supplier_supplier_id`, `textile_name`, `textile_price_group`, `pattern`, `textile_id`) VALUES ('4008','3','Livorno 45200-16','0','1',NULL);
INSERT INTO `wd15`.`textile` (`textile_number`, `supplier_supplier_id`, `textile_name`, `textile_price_group`, `pattern`, `textile_id`) VALUES ('4009','1','Antara Plus 2010','0','1',NULL);
INSERT INTO `wd15`.`textile` (`textile_number`, `supplier_supplier_id`, `textile_name`, `textile_price_group`, `pattern`, `textile_id`) VALUES ('4011','1','Antara Plus 1011','0','1',NULL);
INSERT INTO `wd15`.`textile` (`textile_number`, `supplier_supplier_id`, `textile_name`, `textile_price_group`, `pattern`, `textile_id`) VALUES ('4019','1','Artemis 01 ivory','0','1',NULL);
INSERT INTO `wd15`.`textile` (`textile_number`, `supplier_supplier_id`, `textile_name`, `textile_price_group`, `pattern`, `textile_id`) VALUES ('4029','4','Twitter Col. 01','0','1',NULL);
INSERT INTO `wd15`.`textile` (`textile_number`, `supplier_supplier_id`, `textile_name`, `textile_price_group`, `pattern`, `textile_id`) VALUES ('4032','5','Baltic 25','0','1',NULL);
INSERT INTO `wd15`.`textile` (`textile_number`, `supplier_supplier_id`, `textile_name`, `textile_price_group`, `pattern`, `textile_id`) VALUES ('4034','1','Oakland 08 brown','0','1',NULL);
INSERT INTO `wd15`.`textile` (`textile_number`, `supplier_supplier_id`, `textile_name`, `textile_price_group`, `pattern`, `textile_id`) VALUES ('4036','1','Oakland 45 grey','0','1',NULL);
INSERT INTO `wd15`.`textile` (`textile_number`, `supplier_supplier_id`, `textile_name`, `textile_price_group`, `pattern`, `textile_id`) VALUES ('4038','1','Magma AP 06 cream','0','1',NULL);
INSERT INTO `wd15`.`textile` (`textile_number`, `supplier_supplier_id`, `textile_name`, `textile_price_group`, `pattern`, `textile_id`) VALUES ('4039','1','Magma AP 04 cappu','0','1',NULL);
INSERT INTO `wd15`.`textile` (`textile_number`, `supplier_supplier_id`, `textile_name`, `textile_price_group`, `pattern`, `textile_id`) VALUES ('4042','1','Magma AP 08 anthr','0','1',NULL);
INSERT INTO `wd15`.`textile` (`textile_number`, `supplier_supplier_id`, `textile_name`, `textile_price_group`, `pattern`, `textile_id`) VALUES ('4065','1','Corona Col. 85 bl','0','1',NULL);
INSERT INTO `wd15`.`textile` (`textile_number`, `supplier_supplier_id`, `textile_name`, `textile_price_group`, `pattern`, `textile_id`) VALUES ('4066','1','Corona Col. 79 da','0','1',NULL);
INSERT INTO `wd15`.`textile` (`textile_number`, `supplier_supplier_id`, `textile_name`, `textile_price_group`, `pattern`, `textile_id`) VALUES ('4068','1','Corona Col. 63 mo','0','1',NULL);
INSERT INTO `wd15`.`textile` (`textile_number`, `supplier_supplier_id`, `textile_name`, `textile_price_group`, `pattern`, `textile_id`) VALUES ('4088','1','Artemis 02 beige','0','1',NULL);
INSERT INTO `wd15`.`textile` (`textile_number`, `supplier_supplier_id`, `textile_name`, `textile_price_group`, `pattern`, `textile_id`) VALUES ('4090','1','Corona 4 beige','0','1',NULL);
INSERT INTO `wd15`.`textile` (`textile_number`, `supplier_supplier_id`, `textile_name`, `textile_price_group`, `pattern`, `textile_id`) VALUES ('5000','8','Avon 96','0','1',NULL);
INSERT INTO `wd15`.`textile` (`textile_number`, `supplier_supplier_id`, `textile_name`, `textile_price_group`, `pattern`, `textile_id`) VALUES ('5102','8','Loriga 9033 rot','0','1',NULL);

-- numery materiałów nigdy nie występujące jako jednodeseniowe
SELECT textile_number, MIN(textile_name), GROUP_CONCAT(textile_price_group), SUM(textile_price_group), MIN(pattern) FROM `textile` GROUP BY textile_number HAVING SUM(textile_price_group)=0 ORDER BY SUM(textile_price_group) ASC 

-- dodajemy ceny do tabeli Order
ALTER TABLE `order` ADD `order_price` DECIMAL(9,2) NULL AFTER `textile2_textile_id`, ADD `order_total_price` DECIMAL(9,2) NULL AFTER `order_price`;

-- dodajemy datę aktualizacji do tableli Order
ALTER TABLE `order` ADD `order_storno_date` DATETIME NULL DEFAULT NULL AFTER `order_add_date`;
