-- przygotowanie pod plany
ALTER TABLE `order` CHANGE `article_planed` `article_planed` INT(11) NULL DEFAULT '0';
UPDATE `order` SET article_planed=null;
ALTER TABLE `order` CHANGE `article_planed` `article_planed` DATETIME NULL;

-- oznaczanie materiałów do ponownego użycia
ALTER TABLE `order` ADD `textile_for_reuse` INT(11) NOT NULL DEFAULT '0' AFTER `textile_prepared`;
