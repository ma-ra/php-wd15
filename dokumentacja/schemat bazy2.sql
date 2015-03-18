-- MySQL Script generated by MySQL Workbench
-- 03/18/15 20:55:30
-- Model: New Model    Version: 1.0
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema wd15
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `wd15` DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci ;
USE `wd15` ;

-- -----------------------------------------------------
-- Table `wd15`.`buyer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wd15`.`buyer` (
  `buyer_id` INT NOT NULL AUTO_INCREMENT,
  `buyer_name_1` VARCHAR(150) NOT NULL,
  `buyer_name_2` VARCHAR(150) NULL,
  `buyer_street` VARCHAR(150) NOT NULL,
  `buyer_zip_code` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`buyer_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wd15`.`broker`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wd15`.`broker` (
  `broker_id` INT NOT NULL AUTO_INCREMENT,
  `broker_name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`broker_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wd15`.`manufacturer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wd15`.`manufacturer` (
  `manufacturer_id` INT NOT NULL AUTO_INCREMENT,
  `manufacturer_number` VARCHAR(50) NOT NULL,
  `manufacturer_name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`manufacturer_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wd15`.`leg`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wd15`.`leg` (
  `leg_id` INT NOT NULL AUTO_INCREMENT,
  `leg_type` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`leg_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wd15`.`article`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wd15`.`article` (
  `article_id` INT NOT NULL AUTO_INCREMENT,
  `article_number` VARCHAR(50) NOT NULL,
  `model_name` VARCHAR(100) NOT NULL,
  `model_type` VARCHAR(100) NOT NULL,
  `article_colli` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`article_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wd15`.`order`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wd15`.`order` (
  `order_id` INT NOT NULL AUTO_INCREMENT,
  `order_number` VARCHAR(15) NOT NULL,
  `order_date` DATETIME NULL,
  `buyer_order_number` VARCHAR(50) NULL,
  `buyer_comments` VARCHAR(150) NULL,
  `order_reference` VARCHAR(150) NULL,
  `order_term` VARCHAR(50) NOT NULL,
  `article_amount` INT NOT NULL,
  `buyer_buyer_id` INT NOT NULL,
  `broker_broker_id` INT NOT NULL,
  `manufacturer_manufacturer_id` INT NOT NULL,
  `leg_leg_id` INT NOT NULL,
  `article_article_id` INT NOT NULL,
  `textile_order` INT NULL,
  `printed_minilabel` INT NOT NULL DEFAULT 0,
  `printed_shipping_label` INT NOT NULL DEFAULT 0,
  `article_manufactured` INT NOT NULL DEFAULT 0,
  `article_exported` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`order_id`),
  CONSTRAINT `fk_order_buyer`
    FOREIGN KEY (`buyer_buyer_id`)
    REFERENCES `wd15`.`buyer` (`buyer_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_broker1`
    FOREIGN KEY (`broker_broker_id`)
    REFERENCES `wd15`.`broker` (`broker_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_manufacturer1`
    FOREIGN KEY (`manufacturer_manufacturer_id`)
    REFERENCES `wd15`.`manufacturer` (`manufacturer_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_leg1`
    FOREIGN KEY (`leg_leg_id`)
    REFERENCES `wd15`.`leg` (`leg_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_article1`
    FOREIGN KEY (`article_article_id`)
    REFERENCES `wd15`.`article` (`article_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_order_buyer_idx` ON `wd15`.`order` (`buyer_buyer_id` ASC);

CREATE INDEX `fk_order_broker1_idx` ON `wd15`.`order` (`broker_broker_id` ASC);

CREATE INDEX `fk_order_manufacturer1_idx` ON `wd15`.`order` (`manufacturer_manufacturer_id` ASC);

CREATE INDEX `fk_order_leg1_idx` ON `wd15`.`order` (`leg_leg_id` ASC);

CREATE INDEX `fk_order_article1_idx` ON `wd15`.`order` (`article_article_id` ASC);


-- -----------------------------------------------------
-- Table `wd15`.`textile`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wd15`.`textile` (
  `textile_id` INT NOT NULL AUTO_INCREMENT,
  `textile_number` VARCHAR(50) NOT NULL,
  `textile_name` VARCHAR(150) NOT NULL,
  `textile_price_group` INT NOT NULL,
  PRIMARY KEY (`textile_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wd15`.`order_has_textile`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wd15`.`order_has_textile` (
  `order_order_id` INT NOT NULL,
  `textile_textile_id` INT NOT NULL,
  PRIMARY KEY (`order_order_id`, `textile_textile_id`),
  CONSTRAINT `fk_order_has_textile_order1`
    FOREIGN KEY (`order_order_id`)
    REFERENCES `wd15`.`order` (`order_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_has_textile_textile1`
    FOREIGN KEY (`textile_textile_id`)
    REFERENCES `wd15`.`textile` (`textile_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_order_has_textile_textile1_idx` ON `wd15`.`order_has_textile` (`textile_textile_id` ASC);

CREATE INDEX `fk_order_has_textile_order1_idx` ON `wd15`.`order_has_textile` (`order_order_id` ASC);


-- -----------------------------------------------------
-- Table `wd15`.`supplier`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wd15`.`supplier` (
  `supplier_id` INT NOT NULL AUTO_INCREMENT,
  `supplier_name` VARCHAR(150) NOT NULL,
  `supplier_tel` VARCHAR(45) NULL,
  `supplier_email` VARCHAR(45) NULL,
  `textile_textile_id` INT NOT NULL,
  PRIMARY KEY (`supplier_id`),
  CONSTRAINT `fk_supplier_textile1`
    FOREIGN KEY (`textile_textile_id`)
    REFERENCES `wd15`.`textile` (`textile_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE INDEX `fk_supplier_textile1_idx` ON `wd15`.`supplier` (`textile_textile_id` ASC);


-- -----------------------------------------------------
-- Table `wd15`.`configuration`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wd15`.`configuration` (
  `name` VARCHAR(45) NOT NULL,
  `value` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`name`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
