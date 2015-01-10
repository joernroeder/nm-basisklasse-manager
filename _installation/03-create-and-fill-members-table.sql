CREATE TABLE IF NOT EXISTS `nm-basis`.`members` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing member_id of each member, unique index',
  `fullname` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'member''s name, unique',
  `workshops` TEXT COLLATE utf8_unicode_ci NOT NULL COMMENT 'member''s workshops',
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `fullname` (`fullname`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';