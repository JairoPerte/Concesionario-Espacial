-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema Infinity&Beyond
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema Infinity&Beyond
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `Infinity&Beyond` DEFAULT CHARACTER SET utf8 ;
USE `Infinity&Beyond` ;

-- -----------------------------------------------------
-- Table `Infinity&Beyond`.`Planet`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Infinity&Beyond`.`Planet` ;

CREATE TABLE IF NOT EXISTS `Infinity&Beyond`.`Planet` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `system` VARCHAR(50) NOT NULL,
  `moons` INT UNSIGNED NOT NULL,
  `area` INT UNSIGNED NOT NULL,
  `habitable` TINYINT UNSIGNED NOT NULL check(`habitable` IN(0,1)),
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `Infinity&Beyond`.`Company`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Infinity&Beyond`.`Company` ;

CREATE TABLE IF NOT EXISTS `Infinity&Beyond`.`Company` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `creation` DATE NOT NULL,
  `icon` VARCHAR(150) NULL,
  `description` VARCHAR(500) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE UNIQUE INDEX `name_UNIQUE` ON `Infinity&Beyond`.`Company` (`name` ASC);


-- -----------------------------------------------------
-- Table `Infinity&Beyond`.`User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Infinity&Beyond`.`User` ;

CREATE TABLE IF NOT EXISTS `Infinity&Beyond`.`User` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nickname` VARCHAR(20) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(254) NOT NULL,
  `image` VARCHAR(255) NOT NULL DEFAULT '/img/profile_user/default.png',
  `creddits` BIGINT NOT NULL DEFAULT 0,
  `validated` TINYINT UNSIGNED NOT NULL DEFAULT 0 check(`validated` IN(0,1)),
  `validated_code` CHAR(5) NOT NULL,
  `cookie` CHAR(64) NULL,
  `Company_id` INT UNSIGNED NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_User_Company1`
    FOREIGN KEY (`Company_id`)
    REFERENCES `Infinity&Beyond`.`Company` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_User_Company1_idx` ON `Infinity&Beyond`.`User` (`Company_id` ASC);

CREATE UNIQUE INDEX `nickname_UNIQUE` ON `Infinity&Beyond`.`User` (`nickname` ASC);
CREATE UNIQUE INDEX `email_UNIQUE` ON `Infinity&Beyond`.`User` (`email` ASC);


-- -----------------------------------------------------
-- Table `Infinity&Beyond`.`SpaceShip`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Infinity&Beyond`.`SpaceShip` ;

CREATE TABLE IF NOT EXISTS `Infinity&Beyond`.`SpaceShip` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `license_plate` VARCHAR(12) NOT NULL,
  `name` VARCHAR(25) NOT NULL,
  `speed` INT UNSIGNED NOT NULL,
  `sale` TINYINT UNSIGNED NOT NULL DEFAULT 1 check(`sale` IN(0,1)),
  `creddits` BIGINT UNSIGNED NOT NULL,
  `Company_id` INT UNSIGNED NOT NULL,
  `Planet_id` INT UNSIGNED NULL,
  `User_id` INT UNSIGNED NULL,
  PRIMARY KEY (`id`, `Company_id`),
  CONSTRAINT `fk_SpaceShip_Company1`
    FOREIGN KEY (`Company_id`)
    REFERENCES `Infinity&Beyond`.`Company` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_SpaceShip_Planet1`
    FOREIGN KEY (`Planet_id`)
    REFERENCES `Infinity&Beyond`.`Planet` (`id`)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT `fk_SpaceShip_User1`
    FOREIGN KEY (`User_id`)
    REFERENCES `Infinity&Beyond`.`User` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO action)
ENGINE = InnoDB;

CREATE INDEX `fk_SpaceShip_Planet1_idx` ON `Infinity&Beyond`.`SpaceShip` (`Planet_id` ASC);

CREATE INDEX `fk_SpaceShip_Company1_idx` ON `Infinity&Beyond`.`SpaceShip` (`Company_id` ASC);

CREATE UNIQUE INDEX `license_plate_UNIQUE` ON `Infinity&Beyond`.`SpaceShip` (`license_plate` ASC);

CREATE INDEX `fk_SpaceShip_User1_idx` ON `Infinity&Beyond`.`SpaceShip` (`User_id` ASC);


-- -----------------------------------------------------
-- Table `Infinity&Beyond`.`Crewmate`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Infinity&Beyond`.`Crewmate` ;

CREATE TABLE IF NOT EXISTS `Infinity&Beyond`.`Crewmate` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(30) NOT NULL,
  `surname` VARCHAR(40) NOT NULL,
  `job` VARCHAR(70) NOT NULL,
  `portrait` VARCHAR(150) NULL,
  `SpaceShip_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `SpaceShip_id`),
  CONSTRAINT `fk_Crewmate_SpaceShip1`
    FOREIGN KEY (`SpaceShip_id`)
    REFERENCES `Infinity&Beyond`.`SpaceShip` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_Crewmate_SpaceShip1_idx` ON `Infinity&Beyond`.`Crewmate` (`SpaceShip_id` ASC);


-- -----------------------------------------------------
-- Table `Infinity&Beyond`.`Life_forms`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `Infinity&Beyond`.`Life_forms` ;

CREATE TABLE IF NOT EXISTS `Infinity&Beyond`.`Life_forms` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `iq` INT UNSIGNED NOT NULL,
  `life_span` INT UNSIGNED NOT NULL,
  `aggressive` TINYINT UNSIGNED NOT NULL check(`aggressive` IN(0,1)),
  `portrait` VARCHAR(150) NULL,
  `Planet_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`, `Planet_id`),
  CONSTRAINT `fk_Life_forms_Planet1`
    FOREIGN KEY (`Planet_id`)
    REFERENCES `Infinity&Beyond`.`Planet` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE INDEX `fk_Life_forms_Planet1_idx` ON `Infinity&Beyond`.`Life_forms` (`Planet_id` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO `infinity&beyond`.`company` (`name`, `creation`) VALUES ('Alterra Corporation', '2018-01-23');
INSERT INTO `infinity&beyond`.`company` (`name`, `creation`) VALUES ('Weyland-Yutani', '1979-04-12');
INSERT INTO `infinity&beyond`.`company` (`name`, `creation`) VALUES ('Lethal Company', '2020-11-29');
INSERT INTO `infinity&beyond`.`planet` (`name`, `system`, `moons`, `area`, `habitable`) VALUES ('4546B', 'Ariadne Arm', '2', '200', '1');
INSERT INTO `infinity&beyond`.`planet` (`name`, `system`, `moons`, `area`, `habitable`) VALUES ('Unkown Planet 1', 'Cabbli12', '1', '1203', '0');
INSERT INTO `infinity&beyond`.`planet` (`name`, `system`, `moons`, `area`, `habitable`) VALUES ('Nilhd', 'Guiso', '1', '400', '1');
INSERT INTO `infinity&beyond`.`user` (`nickname`, `password`, `email`, `creddits`, `validated`, `validated_code`) VALUES ('Usuario Prueba', 'dasdasdasddasdad', 'jpercar@gmail.com', '1231231', '1', '11111');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('HVA62H', 'Aurora', '2900', '1', '2900', '1', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('FBSAH23', 'Nostrono', '1223', '1', '4000', '2', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('HVA62DH', 'Aurora', '2900', '0', '2900', '1', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('FBSAHD23', 'Nostrono', '1223', '0', '4000', '2', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('HVA62SH', 'Aurora', '2900', '0', '2900', '1', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('FBSAH2S3', 'Nostrono', '1223', '0', '4000', '2', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('HVA62HA', 'Aurora', '2900', '0', '2900', '1', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('FBSAHV23', 'Nostrono', '1223', '0', '4000', '2', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('HVA62WH', 'Aurora', '2900', '0', '2900', '1', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('FBSAH223', 'Nostrono', '1223', '0', '4000', '2', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('HVA623H', 'Aurora', '2900', '0', '2900', '1', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('FBSA1H23', 'Nostrono', '1223', '0', '4000', '2', '1');

INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('HV2A623H', 'Aurora', '2900', '0', '2900', '1', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('FBS5A1H23', 'Nostrono', '1223', '0', '4000', '2', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('HVA4623H', 'Aurora', '2900', '0', '2900', '1', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('FBStA1H23', 'Nostrono', '1223', '0', '4000', '2', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('HVAA623H', 'Aurora', '2900', '0', '2900', '1', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('FBSAf1H23', 'Nostrono', '1223', '0', '4000', '2', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('HVAS623H', 'Aurora', '2900', '0', '2900', '1', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('FBSAD1H23', 'Nostrono', '1223', '0', '4000', '2', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('HXVA623H', 'Aurora', '2900', '0', '2900', '1', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('FBSVA1H23', 'Nostrono', '1223', '0', '4000', '2', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('HVOA623H', 'Aurora', '2900', '0', '2900', '1', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('FBSCA1H23', 'Nostrono', '1223', '0', '4000', '2', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('HVA6P23H', 'Aurora', '2900', '0', '2900', '1', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('FBSA1OJH23', 'Nostrono', '1223', '0', '4000', '2', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('HVA623HJK', 'Aurora', '2900', '0', '2900', '1', '1');
INSERT INTO `infinity&beyond`.`spaceship` (`license_plate`, `name`, `speed`, `sale`, `creddits`, `Company_id`, `User_id`) VALUES ('FBSA1H23J', 'Nostrono', '1223', '0', '4000', '2', '1');

