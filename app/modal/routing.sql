CREATE TABLE `short_urls` (
	`id` INT(245) NOT NULL AUTO_INCREMENT,
	`long_url` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`short_code` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`hits` INT(255) NOT NULL DEFAULT '0',
	`created` DATE NOT NULL DEFAULT (CURRENT_DATE),
	UNIQUE KEY `code` (`short_code`),
	PRIMARY KEY (`id`,`short_code`)
);