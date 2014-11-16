-- Host: localhost    Database: hacker
-- ------------------------------------------------------

DROP TABLE IF EXISTS `info`;
CREATE TABLE `info` (
	`username` varchar(20) DEFAULT NULL,
	`software` varchar(20) DEFAULT NULL,
	`time` varchar(20) DEFAULT NULL,
	`clicks` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
	`username` varchar(20) NOT NULL,
	`password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
