ALTER TABLE `user`
	ADD COLUMN `title` VARCHAR(24) AFTER `lastname`,
	ADD COLUMN `avatar` VARCHAR(255) AFTER `title`
;

ALTER TABLE `info`
	ADD UNIQUE INDEX (`userid`,`software`)
;

CREATE TABLE `socialnetworks` (
	`shortname` VARCHAR(24) NOT NULL,
	`icon` VARCHAR(255),
	PRIMARY KEY (`shortname`)
);

CREATE TABLE `links` (
	`id` BIGINT(20) NOT NULL AUTO_INCREMENT,
	`userid` INT(11) NOT NULL,
	`network` VARCHAR(24) NOT NULL,
	`url` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`id`),
	KEY (`userid`),
	CONSTRAINT FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE
);