# ************************************************************
#
# Host: localhost (MySQL 5.7.39)
# Database: aged_care_test
# ************************************************************

SET NAMES utf8mb4;


# Dump of table call_headers
# ------------------------------------------------------------
DROP TABLE IF EXISTS `call_headers`;
CREATE TABLE `call_headers` (
  `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `it_person` varchar(32) DEFAULT NULL,
  `user_name` varchar(32) DEFAULT NULL,
  `subject` varchar(64) DEFAULT NULL,
  `details` text COMMENT 'Details of response to call',
  `status` enum('New','In Progress','Completed') DEFAULT 'New',
  PRIMARY KEY (`id`),
  KEY `it_person` (`it_person`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table call_details
# ------------------------------------------------------------
DROP TABLE IF EXISTS `call_details`;
CREATE TABLE `call_details` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `call_id` bigint(10) unsigned DEFAULT NULL,
  `date` datetime DEFAULT CURRENT_TIMESTAMP,
  `details` text,
  `hours` int(11) unsigned NOT NULL DEFAULT '0',
  `minutes` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `call_id` (`call_id`),
  CONSTRAINT `call_details_ibfk_1` FOREIGN KEY (`call_id`) REFERENCES `call_headers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Dump of view v_calls
# ------------------------------------------------------------
DROP TABLE IF EXISTS `v_calls`; DROP VIEW IF EXISTS `v_calls`;
CREATE VIEW `v_calls`
AS SELECT
   `h`.`id` AS `id`,
   `h`.`it_person` AS `it_person`,
   `h`.`user_name` AS `user_name`,
   `h`.`subject` AS `subject`,
   `h`.`details` AS `header_details`,date_format(sec_to_time((sum(((`d`.`hours` * 60) + `d`.`minutes`)) * 60)),'%H') AS `total_hours`,date_format(sec_to_time((sum(((`d`.`hours` * 60) + `d`.`minutes`)) * 60)),'%i') AS `total_minutes`,date_format(`h`.`date`,'%Y-%m-%d') AS `date_formated`,
   `h`.`status` AS `status`
FROM (`call_headers` `h` left join `call_details` `d` on((`h`.`id` = `d`.`call_id`))) group by `h`.`it_person` order by `h`.`date`;
