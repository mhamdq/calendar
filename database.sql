CREATE SCHEMA `calendarevents` DEFAULT CHARACTER SET utf8 ;

CREATE TABLE `calendarevents`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `calendarevents`.`events` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `description` TEXT NULL,
  `start` DATETIME NOT NULL,
  `end` DATETIME NOT NULL,
  `createdBy` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_evt_user`
    FOREIGN KEY (`createdBy`)
    REFERENCES `calendarevents`.`user` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

INSERT INTO `calendarevents`.`user` (`username`, `password`) VALUES ('stonecode', 'stonecode');
INSERT INTO `calendarevents`.`user` (`username`, `password`) VALUES ('karim', 'karim');
INSERT INTO `calendarevents`.`user` (`username`, `password`) VALUES ('samuel', 'samuel');

INSERT INTO `calendarevents`.`events` (`name`, `description`, `start`, `end`, `createdBy`) VALUES ('Holidays sunday', ?, '2020-12-31 23:59:59', '2021-01-31 23:59:59', '1');
INSERT INTO `calendarevents`.`events` (`name`, `description`, `start`, `end`, `createdBy`) VALUES ('Adoration Le', ?, '2022-04-24 18:30:30', '2022-04-25 18:30:30', '2');
INSERT INTO `calendarevents`.`events` (`name`, `description`, `start`, `end`) VALUES ('Solar System', ?, '2022-04-24 15:30:30', '2022-04-24 22:30:30');

