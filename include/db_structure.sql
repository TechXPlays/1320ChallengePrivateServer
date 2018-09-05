-- Nitto 1320 Performance Challenge Datbase Structure
DROP DATABASE `nitto`;
CREATE DATABASE `nitto` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `nitto`;

-- The settings table
-- DROP TABLE `nt_settings`;
CREATE TABLE `nt_settings` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(45) NOT NULL,
	`value` varchar(45) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- The cars table
-- DROP TABLE `nt_car_stock`;
CREATE TABLE `nt_car_stock` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(45) NOT NULL,
	`price` int(11) unsigned NOT NULL,
	`color` varchar(6) NOT NULL DEFAULT '000000',
	`local_image` varchar(45) NOT NULL,
	`remote_image` varchar(45) NOT NULL,
	`logo_local_image` varchar(45) NOT NULL,
	`logo_remote_image` varchar(45) NOT NULL,
	`starter` tinyint(1) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `nt_car_stock` VALUES (1, 'Viper SRT10', '100', '000000', 'viperSRT10', 'viperSRT10', 'viperSRT10', 'viperSRT10', '1');
INSERT INTO `nt_car_stock` VALUES (2, 'Supra Turbo', '100', '000000', 'supraTurbo', 'supraTurbo', 'supraTurbo', 'supraTurbo', '1');
INSERT INTO `nt_car_stock` VALUES (3, 'Mustang SVT Cobra', '100', '000000', 'mustangSVTCobra', 'mustangSVTCobra', 'mustangSVTCobra', 'mustangSVTCobra', '0');
INSERT INTO `nt_car_stock` VALUES (4, 'Skyline GTR', '100', '000000', 'skylineGTR', 'skylineGTR', 'skylineGTR', 'skylineGTR', '1');
INSERT INTO `nt_car_stock` VALUES (5, 'Acura RSX', '100', '000000', 'acuraRSX', 'acuraRSX', 'acuraRSX', 'acuraRSX', '1');
INSERT INTO `nt_car_stock` VALUES (6, 'Choice F1', '100', '000000', 'choiceF1', 'choiceF1', 'choiceF1', 'choiceF1', '1');
INSERT INTO `nt_car_stock` VALUES (7, 'RAM STR 10', '100', '000000', 'ramSRT10', 'ramSRT10', 'ramSRT10', 'ramSRT10', '1');
INSERT INTO `nt_car_stock` VALUES (8, '1320 Funny Car', '100', '000000', '1320FunnyCar', '1320FunnyCar', '1320FunnyCar', '1320FunnyCar', '1');
INSERT INTO `nt_car_stock` VALUES (9, 'NSX', '100', '000000', 'NSX', 'NSX', 'NSX', 'NSX', '1');
INSERT INTO `nt_car_stock` VALUES (10, 'SRT4', '100', '000000', 'SRT4', 'SRT4', 'SRT4', 'SRT4', '1');
INSERT INTO `nt_car_stock` VALUES (11, 'Nitto Dragster', '100', '000000', 'nittoDragster', 'nittoDragster', 'nittoDragster', 'nittoDragster', '1');
INSERT INTO `nt_car_stock` VALUES (12, 'Charger', '100', '000000', 'charger', 'charger', 'charger', 'charger', '1');
INSERT INTO `nt_car_stock` VALUES (13, 'Civic Si', '100', '000000', 'civicSi', 'civicSi', 'civicSi', 'civicSi', '1');
INSERT INTO `nt_car_stock` VALUES (14, 'Lancer EVO VII', '100', '000000', 'lancerEVOVII', 'lancerEVOVII', 'lancerEVOVII', 'lancerEVOVII', '1');
INSERT INTO `nt_car_stock` VALUES (15, 'RX8', '100', '000000', 'RX8', 'RX8', 'RX8', 'RX8', '1');
INSERT INTO `nt_car_stock` VALUES (16, 'Challenger', '100', '000000', 'challenger', 'challenger', 'challenger', 'challenger', '1');
INSERT INTO `nt_car_stock` VALUES (17, 'Mopar Drag Car', '100', '000000', 'moparDragCar', 'moparDragCar', 'moparDragCar', 'moparDragCar', '1');

-- The car details table
-- DROP TABLE `nt_car_stock_performance`;
CREATE TABLE `nt_car_stock_performance` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`car_id` int(10) unsigned NOT NULL,
	`engine` varchar(45) NOT NULL,
	`hp` int(10) NOT NULL,
	`torque` int(10) NOT NULL,
	`redline` int(10) NOT NULL,
	`revlimiter` int(10) NOT NULL,
	`boost` int(10) NOT NULL,
	`width` int(10) NOT NULL,
	`length` int(10) NOT NULL,
	`height` int(10) NOT NULL,
	`weight` int(10) NOT NULL,
	`gear_ratios` TEXT NOT NULL,
	`engine_demage_factor` FLOAT unsigned NOT NULL,
	`clutch_wear_factor` FLOAT unsigned NOT NULL,
	`tire_grip` FLOAT unsigned NOT NULL,
	`tire_radius` FLOAT unsigned NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `car_UNIQUE` (`car_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `nt_car_stock_performance` VALUES (NULL, 1, 'V8', 200, 5000, 8000, 7000, 1000, 3000, 5000, 1300, 1250, '3|2.5|2|1.5|1|0.5|0.3', 1, 1, 10, 0.84);
INSERT INTO `nt_car_stock_performance` VALUES (NULL, 2, 'V8', 200, 5000, 8000, 7000, 1000, 3000, 5000, 1300, 1250, '3|2.5|2|1.5|1|0.5|0.3', 1, 1, 10, 0.84);
INSERT INTO `nt_car_stock_performance` VALUES (NULL, 3, 'V8', 200, 5000, 8000, 7000, 1000, 3000, 5000, 1300, 1250, '3|2.5|2|1.5|1|0.5|0.3', 1, 1, 10, 0.84);
INSERT INTO `nt_car_stock_performance` VALUES (NULL, 5, 'V8', 200, 5000, 8000, 7000, 1000, 3000, 5000, 1300, 1250, '3|2.5|2|1.5|1|0.5|0.3', 1, 1, 10, 0.84);
INSERT INTO `nt_car_stock_performance` VALUES (NULL, 6, 'V8', 200, 5000, 8000, 7000, 1000, 3000, 5000, 1300, 1250, '3|2.5|2|1.5|1|0.5|0.3', 1, 1, 10, 0.84);
INSERT INTO `nt_car_stock_performance` VALUES (NULL, 7, 'V8', 200, 5000, 8000, 7000, 1000, 3000, 5000, 1300, 1250, '3|2.5|2|1.5|1|0.5|0.3', 1, 1, 10, 0.84);
INSERT INTO `nt_car_stock_performance` VALUES (NULL, 8, 'V8', 200, 5000, 8000, 7000, 1000, 3000, 5000, 1300, 1250, '3|2.5|2|1.5|1|0.5|0.3', 1, 1, 10, 0.84);
INSERT INTO `nt_car_stock_performance` VALUES (NULL, 9, 'V8', 200, 5000, 8000, 7000, 1000, 3000, 5000, 1300, 1250, '3|2.5|2|1.5|1|0.5|0.3', 1, 1, 10, 0.84);
INSERT INTO `nt_car_stock_performance` VALUES (NULL, 10, 'V8', 200, 5000, 8000, 7000, 1000, 3000, 5000, 1300, 1250, '3|2.5|2|1.5|1|0.5|0.3', 1, 1, 10, 0.84);
INSERT INTO `nt_car_stock_performance` VALUES (NULL, 11, 'V8', 200, 5000, 8000, 7000, 1000, 3000, 5000, 1300, 1250, '3|2.5|2|1.5|1|0.5|0.3', 1, 1, 10, 0.84);
INSERT INTO `nt_car_stock_performance` VALUES (NULL, 12, 'V8', 200, 5000, 8000, 7000, 1000, 3000, 5000, 1300, 1250, '3|2.5|2|1.5|1|0.5|0.3', 1, 1, 10, 0.84);
INSERT INTO `nt_car_stock_performance` VALUES (NULL, 13, 'V8', 200, 5000, 8000, 7000, 1000, 3000, 5000, 1300, 1250, '3|2.5|2|1.5|1|0.5|0.3', 1, 1, 10, 0.84);
INSERT INTO `nt_car_stock_performance` VALUES (NULL, 14, 'V8', 200, 5000, 8000, 7000, 1000, 3000, 5000, 1300, 1250, '3|2.5|2|1.5|1|0.5|0.3', 1, 1, 10, 0.84);
INSERT INTO `nt_car_stock_performance` VALUES (NULL, 15, 'V8', 200, 5000, 8000, 7000, 1000, 3000, 5000, 1300, 1250, '3|2.5|2|1.5|1|0.5|0.3', 1, 1, 10, 0.84);
INSERT INTO `nt_car_stock_performance` VALUES (NULL, 16, 'V8', 200, 5000, 8000, 7000, 1000, 3000, 5000, 1300, 1250, '3|2.5|2|1.5|1|0.5|0.3', 1, 1, 10, 0.84);
INSERT INTO `nt_car_stock_performance` VALUES (NULL, 17, 'V8', 200, 5000, 8000, 7000, 1000, 3000, 5000, 1300, 1250, '3|2.5|2|1.5|1|0.5|0.3', 1, 1, 10, 0.84);

-- The car colors
-- DROP TABLE `nt_car_stock_color`;
CREATE TABLE `nt_car_stock_color` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`car_id` int(10) unsigned NOT NULL,
	`color` varchar(6) NOT NULL DEFAULT '000000',
	PRIMARY KEY (`id`),
	INDEX `car_id_index` (`car_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `nt_car_stock_color` VALUES (NULL, 1, '000000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 1, 'FF0000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 2, '000000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 2, 'FF0000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 3, '000000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 3, 'FF0000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 4, '000000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 4, 'FF0000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 5, '000000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 5, 'FF0000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 6, '000000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 6, 'FF0000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 7, '000000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 7, 'FF0000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 8, '000000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 8, 'FF0000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 9, '000000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 9, 'FF0000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 10, '000000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 10, 'FF0000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 11, '000000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 11, 'FF0000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 12, '000000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 12, 'FF0000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 13, '000000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 13, 'FF0000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 14, '000000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 14, 'FF0000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 15, '000000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 15, 'FF0000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 16, '000000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 16, 'FF0000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 17, '000000');
INSERT INTO `nt_car_stock_color` VALUES (NULL, 17, 'FF0000');

-- The accounts table
-- DROP TABLE `nt_account`;
CREATE TABLE `nt_account` (
	`id` INT(10) unsigned NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(64) UNIQUE NOT NULL,
	`password` VARCHAR(32) NOT NULL,
	`email` VARCHAR(128) UNIQUE NOT NULL,
	`location` VARCHAR(128) NOT NULL,
	`ethnicity` VARCHAR(128) NOT NULL,
	`birthyear` INT(4) unsigned NOT NULL,
	`gender` ENUM('M', 'F') NOT NULL,
	`activation_code` VARCHAR(8) NOT NULL,
	`active` TINYINT(1) NOT NULL DEFAULT 0,
	`terms_accepted` TINYINT(1) NOT NULL DEFAULT 0,
	`level` TEXT, -- unknown for now
	`type` TEXT, -- unknown for now
	`class` TEXT, -- unknown for now
	`bracketET` TEXT, -- unknown for now (possible not for here)
	`balance` INT(10) NOT NULL DEFAULT 0,
	`points` INT(10) NOT NULL DEFAULT 0,
	`email_notification` TINYINT(1) NOT NULL DEFAULT 1,
	`team_id` INT(10) unsigned NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`),
	INDEX `team_id_index` (`team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- The player cars table
-- DROP TABLE `nt_player_car`;
CREATE TABLE `nt_player_car` (
	`id` INT(10) unsigned NOT NULL AUTO_INCREMENT,
	`car_id` INT(10) unsigned NOT NULL,
	`account_id` INT(10) unsigned NOT NULL,
	`car_number` INT(10) unsigned NOT NULL,
	`locked` TINYINT(1) NOT NULL DEFAULT 0,
	`team_id` INT(10) unsigned NOT NULL DEFAULT 0,
	`selected` TINYINT(1) NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`),
	INDEX `car_id_index` (`car_id`),
	INDEX `account_id_index` (`account_id`),
	INDEX `team_id_index` (`team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Player car visuals
-- DROP TABLE `nt_player_car_visual`;
CREATE TABLE `nt_player_car_visual` (
	`id` INT(10) unsigned NOT NULL AUTO_INCREMENT,
	`player_car_id` INT(10) unsigned UNIQUE NOT NULL,
	`color` VARCHAR(6) NOT NULL DEFAULT '000000',
	`hood` TEXT,
	`graphic` TEXT,
	`graphic_color` VARCHAR(6),
	`numeral` INT(3) unsigned,
	`numeral_color` VARCHAR(6),
	`numeral_shadow` TINYINT(1) DEFAULT 0,
	`ride_height` INT(3) unsigned,
	`wing_id` INT(10) unsigned, -- most probably in parts
	`wheels_id` INT(10) unsigned, -- most probably in parts
	`guages` TEXT,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Player car condition
-- DROP TABLE `nt_player_car_condition`;
CREATE TABLE `nt_player_car_condition` (
	`id` INT(10) unsigned NOT NULL AUTO_INCREMENT,
	`player_car_id` INT(10) unsigned UNIQUE NOT NULL,
	`nitrous_remaining` INT(3) unsigned DEFAULT 0,
	`oil_life_remaining` INT(3) unsigned DEFAULT 0,
	`oil_type` TEXT,
	`engine_damage` INT(3) unsigned DEFAULT 0,
	`clutch_wear` INT(3) unsigned DEFAULT 0,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Player car performance
-- DROP TABLE `nt_player_car_performance`;
CREATE TABLE `nt_player_car_performance` (
	`id` INT(10) unsigned NOT NULL AUTO_INCREMENT,
	`player_car_id` INT(10) unsigned UNIQUE NOT NULL,
	`tire_grip` FLOAT unsigned NOT NULL,
	`hp` INT(10) unsigned NOT NULL,
	`redline` INT(10) unsigned NOT NULL,
	`revlimiter` INT(10) unsigned NOT NULL,
	`weight` INT(10) unsigned NOT NULL,
	`engine_damage_factor` FLOAT unsigned NOT NULL,
	`clutch_wear_factor` FLOAT unsigned NOT NULL,
	`hp_increase` INT(10) unsigned,
	`boost_setting` INT(10) unsigned,
	`boost_increase` INT(10) unsigned,
	`shift_light` INT(10) unsigned,
	`bracket_et` INT(10) unsigned,
	`average_et` INT(10) unsigned,
	`tire_radius` FLOAT unsigned DEFAULT 1,
	`gear_ratios` TEXT,
	`nitrous_shot_size` INT(10) unsigned DEFAULT 0,
	`boost_controller` TINYINT(1) DEFAULT 0,
	`suspension_controller` TINYINT(1) DEFAULT 0,
	`magic_gearbox` TINYINT(1) DEFAULT 0,
	`supercharger` TINYINT(1) DEFAULT 0,
	`blowoffvalve` TINYINT(1) DEFAULT 0,	
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Player car parts
-- DROP TABLE `nt_player_cart_part`;
CREATE TABLE `nt_player_cart_part` (
	`id` INT(10) unsigned NOT NULL AUTO_INCREMENT,
	`player_car_id` INT(10) unsigned NOT NULL,
	`part_id` INT(10) unsigned NOT NULL,
	`installed` TINYINT(1) NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`),
	INDEX player_car_id_index (`player_car_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Team table
-- DROP TABLE `nt_team`;
CREATE TABLE `nt_team` (
	`id` INT(10) unsigned NOT NULL AUTO_INCREMENT,
	`name` TEXT NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `nt_team` VALUES (NULL, 'Street Kings');

-- Messages table
-- DROP TABLE `nt_message`;
CREATE TABLE `nt_message` (
	`id` INT(10) unsigned NOT NULL AUTO_INCREMENT,
	`from_id` INT(10) unsigned NOT NULL,
	`to_id` INT(10) unsigned NOT NULL,
	`date` DATETIME NOT NULL,
	`read` TINYINT(1) NOT NULL DEFAULT 0,
	`content` TEXT,
	`subject` TEXT,
	PRIMARY KEY (`id`),
	INDEX `to_id_index` (`to_id`),
	INDEX `from_id_index` (`from_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `nt_message` VALUES (NULL, 1, 1, '2011-06-20 11:05:20', 0, 'This is a hard-coded private message stored in the database for user ID 1', 'Thanks for popping in!');
INSERT INTO `nt_message` VALUES (NULL, 1, 2, '2011-06-20 11:05:20', 0, 'This is a hard-coded private message stored in the database for user ID 2', 'Thanks for popping in!');
INSERT INTO `nt_message` VALUES (NULL, 1, 3, '2011-06-20 11:05:20', 0, 'This is a hard-coded private message stored in the database for user ID 3', 'Thanks for popping in!');
INSERT INTO `nt_message` VALUES (NULL, 1, 4, '2011-06-20 11:05:20', 0, 'This is a hard-coded private message stored in the database for user ID 4', 'Thanks for popping in!');
INSERT INTO `nt_message` VALUES (NULL, 1, 5, '2011-06-20 11:05:20', 0, 'This is a hard-coded private message stored in the database for user ID 5', 'Thanks for popping in!');
INSERT INTO `nt_message` VALUES (NULL, 1, 6, '2011-06-20 11:05:20', 0, 'This is a hard-coded private message stored in the database for user ID 6', 'Thanks for popping in!');