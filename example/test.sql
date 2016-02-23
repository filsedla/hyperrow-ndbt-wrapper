-- Adminer 4.2.0 MySQL dump

SET NAMES utf8mb4;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `author`;
CREATE TABLE `author` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `web` varchar(255) DEFAULT NULL,
  `born` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `author` (`id`, `name`, `web`, `born`) VALUES
(1,	'Jan Novák',	NULL,	1980),
(2,	'Vladimír Krátký',	NULL,	1975);

DROP TABLE IF EXISTS `book`;
CREATE TABLE `book` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(11) unsigned NOT NULL,
  `translator_id` int(11) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `web` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `translator_id` (`translator_id`),
  CONSTRAINT `book_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `author` (`id`),
  CONSTRAINT `book_ibfk_2` FOREIGN KEY (`translator_id`) REFERENCES `author` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `book` (`id`, `author_id`, `translator_id`, `title`, `web`) VALUES
(1,	1,	NULL,	'První kniha',	NULL),
(2,	1,	NULL,	'Druhá kniha',	NULL),
(3,	2,	NULL,	'Jiná kniha',	NULL);

DROP TABLE IF EXISTS `book_tag`;
CREATE TABLE `book_tag` (
  `book_id` int(11) unsigned NOT NULL,
  `tag_id` int(11) unsigned NOT NULL,
  KEY `book_id` (`book_id`),
  KEY `tag_id` (`tag_id`),
  CONSTRAINT `book_tag_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `book` (`id`),
  CONSTRAINT `book_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `book_tag` (`book_id`, `tag_id`) VALUES
(1,	1),
(3,	1),
(2,	2),
(3,	2);

DROP TABLE IF EXISTS `empty`;
CREATE TABLE `empty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tag` (`id`, `name`) VALUES
(1,	'životopis'),
(2,	'bestseller');

-- 2016-02-23 07:44:15
