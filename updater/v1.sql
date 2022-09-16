CREATE TABLE `config` (
  `id_cfg` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id_cfg`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `config` (`id_cfg`, `name`, `value`) VALUES
(1,	'USER_PASSWORD',	'userpass'),
(2,	'ADMIN_PASSWORD',	'adminpass'),
(3,	'FORCE_HTTPS',	'false'),
(4,	'VERSION',	'1');

CREATE TABLE `homepage` (
  `id_hp` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `content` longtext NOT NULL,
  PRIMARY KEY (`id_hp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `music`
ADD `directory` varchar(120) NOT NULL;
