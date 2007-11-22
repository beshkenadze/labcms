DROP TABLE IF EXISTS ?_comments;
CREATE TABLE IF NOT EXISTS ?_comments (
  `comment_id` int(11) NOT NULL auto_increment,
  `module_id` int(11) NOT NULL default '0',
  `item_id` int(11) NOT NULL default '0',
  `user_id` int(255) NOT NULL default '0',
  `name` varchar(30) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `msg` text NOT NULL,
  `putdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `ip` bigint(20) NOT NULL default '0',
  PRIMARY KEY  (`comment_id`),
  FULLTEXT KEY `msg` (`msg`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT IGNORE INTO ?_config VALUES ('catcher', 'tmp', 'Название поля противоспаммерского модуля (tmp)');