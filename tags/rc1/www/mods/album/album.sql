DROP TABLE IF EXISTS ?_album;
CREATE TABLE IF NOT EXISTS ?_album (
  `album_id` int(11) NOT NULL auto_increment,
  `tree_id` int(11) NOT NULL default '0',
  `album_name` varchar(255) NOT NULL default '',
  `album_descr` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`album_id`),
  UNIQUE KEY `tree_id` (`tree_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ?_album_comments;
CREATE TABLE IF NOT EXISTS ?_album_comments (
  `comment_id` int(11) NOT NULL auto_increment,
  `img_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `msg` text NOT NULL,
  `putdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `ip` bigint(20) NOT NULL,
  PRIMARY KEY  (`comment_id`),
  FULLTEXT KEY `msg` (`msg`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ?_album_img;
CREATE TABLE IF NOT EXISTS ?_album_img (
  `img_id` int(11) NOT NULL auto_increment,
  `album_id` int(11) NOT NULL default '0',
  `img_title` varchar(255) NOT NULL default '',
  `img_descr` text NOT NULL,
  `img_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `file_name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`img_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT IGNORE INTO ?_config VALUES ('catcher', 'tmp', 'Название поля противоспаммерского модуля (tmp)');