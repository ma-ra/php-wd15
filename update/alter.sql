ALTER TABLE `order` CHANGE `article_planed` `article_planed` INT(11) NULL DEFAULT '0';
UPDATE `order` SET article_planed=null;
ALTER TABLE `order` CHANGE `article_planed` `article_planed` DATETIME NULL;
