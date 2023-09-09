ALTER TABLE `folder`
ADD `header_title` text;

ALTER TABLE `homepage`
ADD `header_title` text;

UPDATE `config` SET `value` = '3' WHERE `id_cfg` = '4';