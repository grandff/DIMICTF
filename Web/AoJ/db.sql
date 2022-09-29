CREATE DATABASE IF NOT EXISTS `aijudger`;

use `aijudger`;

CREATE TABLE IF NOT EXISTS `all_community`(
    `idx` INT(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `id` INT(4) NOT NULL,
    `comment` TEXT
);

CREATE TABLE IF NOT EXISTS `defendant_community`(
    `idx` INT(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `id` INT(4) NOT NULL,
    `comment` TEXT
);

CREATE TABLE IF NOT EXISTS `delator_community`(
    `idx` INT(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `id` INT(4) NOT NULL,
    `comment` TEXT
);

CREATE TABLE IF NOT EXISTS `courtmakes`(
    `idx` INT(4) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `title` TEXT,
    `content` MEDIUMTEXT,
    `defendant` VARCHAR(30),
    `delator` VARCHAR(30),
    `deadline` VARCHAR(30),
    `defendant_point` INT(4),
    `delator_point` INT(4)
);

CREATE TABLE IF NOT EXISTS `users`(
    `id` VARCHAR(512) NOT NULL PRIMARY KEY,
    `pw` VARCHAR(64),
    `name` VARCHAR(512)
);

CREATE TABLE IF NOT EXISTS `flag`(
    `flag` VARCHAR(512)
);

INSERT INTO `flag` VALUE("DIMI{EXAMPLE_FLAG}");
