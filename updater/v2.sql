ALTER TABLE `version`
ADD `soprano` tinyint unsigned NOT NULL DEFAULT '0',
ADD `alto` tinyint unsigned NOT NULL DEFAULT '0' AFTER `soprano`,
ADD `tenor` tinyint unsigned NOT NULL DEFAULT '0' AFTER `alto`,
ADD `basse` tinyint unsigned NOT NULL DEFAULT '0' AFTER `tenor`,
ADD `tutti` tinyint unsigned NOT NULL DEFAULT '0' AFTER `basse`;

UPDATE `config` SET `value` = '2' WHERE `id_cfg` = '4';