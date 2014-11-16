ALTER TABLE `user`
	ADD COLUMN `id` INT(11) NOT NULL AUTO_INCREMENT FIRST,
	DROP COLUMN `password`,
	ADD COLUMN `password` CHAR(60) NOT NULL AFTER `username`,
	ADD COLUMN `firstname` VARCHAR(32) NOT NULL AFTER `password`,
	ADD COLUMN `lastname` VARCHAR(32) NOT NULL AFTER `firstname`,
	ADD PRIMARY KEY (`id`),
	ADD UNIQUE KEY (`username`)
;

DROP TABLE `info`;
CREATE TABLE `info` (
	`id` BIGINT(20) NOT NULL AUTO_INCREMENT,
	`userid` INT(11) NOT NULL,
	`software` VARCHAR(24) NOT NULL,
	`time` BIGINT(20) NOT NULL DEFAULT 0,
	`clicks` BIGINT(20) NOT NULL DEFAULT 0,
	`keystrokes` BIGINT(20) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY (`userid`),
  CONSTRAINT FOREIGN KEY (`userid`) REFERENCES `user` (`id`) ON DELETE CASCADE
) Engine=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `software` (
	`shortname` VARCHAR(32) NOT NULL,
	`displayname` VARCHAR(48),
	`badge` VARCHAR(255),
	`icon` VARCHAR(255),
	PRIMARY KEY (`shortname`)
) Engine=InnoDB;

INSERT INTO `software` (`shortname`,`displayname`,`badge`,`icon`) VALUES
	('AfterEffects', 'After Effects', null, 'PNG/Adobe_After_Effects_CS6_Icon.png'),
	('Illustrator', 'Illustrator', null, 'PNG/Adobe_Illustrator_Icon_CS6.png'),
	('Photoshop', 'Photoshop', 'PNG/BADGE PS.png', 'PNG/Adobe_Photoshop_CS6_icon.png'),
	('InDesign', 'InDesign', null, 'PNG/Adobe_InDesign_icon.png')
;