DROP TABLE IF EXISTS ?_forum_forums;
CREATE TABLE IF NOT EXISTS ?_forum_forums (
  `forum_id` int(11) NOT NULL auto_increment,
  `forum_name` varchar(255) NOT NULL default '',
  `descr` text,
  `total_posts` int(11) NOT NULL default '0',
  `total_themes` int(11) NOT NULL default '0',
  `last_post` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_user` varchar(255) default NULL,
  `closed` tinyint(1) NOT NULL,
  PRIMARY KEY  (`forum_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ?_forum_posts;
CREATE TABLE IF NOT EXISTS ?_forum_posts (
  `post_id` int(11) NOT NULL auto_increment,
  `theme_id` int(11) NOT NULL default '0',
  `user_name` varchar(50) default NULL,
  `msg` text NOT NULL,
  `email` varchar(30) default NULL,
  `putdate` datetime default '0000-00-00 00:00:00',
  `ip` bigint(20) default '0',
  PRIMARY KEY  (`post_id`),
  FULLTEXT KEY `name` (`user_name`,`msg`)
) ENGINE=MyISAM AUTO_INCREMENT=786 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ?_forum_themes;
CREATE TABLE IF NOT EXISTS ?_forum_themes (
  `theme_id` int(11) NOT NULL auto_increment,
  `forum_id` int(11) default NULL,
  `author` varchar(32) NOT NULL default '',
  `subject` varchar(60) NOT NULL default '',
  `total_posts` int(11) NOT NULL default '0',
  `last_post` datetime default '0000-00-00 00:00:00',
  `last_user` varchar(32) NOT NULL default '',
  PRIMARY KEY  (`theme_id`),
  FULLTEXT KEY `subject` (`subject`)
) ENGINE=MyISAM AUTO_INCREMENT=303 DEFAULT CHARSET=utf8;

INSERT IGNORE INTO ?_config VALUES ('catcher', 'tmp', 'Название поля противоспаммерского модуля (tmp)');
INSERT IGNORE INTO ?_config VALUES ('forum_themes_at_page', '10', 'Количество тем форума на странице');
INSERT IGNORE INTO ?_config VALUES ('forum_posts_at_page', '10', 'Количествопостов форума на странице');