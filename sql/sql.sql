CREATE TABLE `dayzstats` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`pid` TEXT NULL,
	`login` TEXT NULL,
	`password` VARCHAR(50) NULL DEFAULT NULL,
	`salt` VARCHAR(3) NOT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=0;

CREATE TABLE `dayzstats_boards` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`owner_userid` TEXT NOT NULL,
	`name` TEXT NOT NULL,
	`pids` TEXT NOT NULL,
	PRIMARY KEY (`id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=0;
