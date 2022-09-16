-- Adminer 4.8.1 MySQL 5.5.5-10.9.2-MariaDB-1:10.9.2+maria~ubu2204 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

CREATE TABLE `config` (
  `id_cfg` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id_cfg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `config` (`id_cfg`, `name`, `value`) VALUES
(1,	'USER_PASSWORD',	'userpass'),
(2,	'ADMIN_PASSWORD',	'adminpass'),
(3,	'FORCE_HTTPS',	'false');

CREATE TABLE `date` (
  `id_date` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


CREATE TABLE `document` (
  `id_doc` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_music` int(11) NOT NULL,
  `url` varchar(120) NOT NULL,
  `name` varchar(30) NOT NULL DEFAULT 'Partition',
  PRIMARY KEY (`id_doc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


CREATE TABLE `folder` (
  `id_fld` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `icon` varchar(30) NOT NULL DEFAULT 'music',
  `header` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_fld`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


CREATE TABLE `folder_music` (
  `id_folder_music` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_music` int(10) unsigned NOT NULL,
  `id_fld` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_folder_music`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;


CREATE TABLE `homepage` (
  `id_hp` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` longtext NOT NULL,
  PRIMARY KEY (`id_hp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `music` (
  `id_music` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) COLLATE utf8mb3_bin NOT NULL,
  `directory` varchar(120) COLLATE utf8mb3_bin NOT NULL,
  PRIMARY KEY (`id_music`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;


CREATE TABLE `version` (
  `id_version` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_music` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `url` varchar(120) NOT NULL,
  `number` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- 2022-09-16 08:48:54
