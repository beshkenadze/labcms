DROP TABLE IF EXISTS ?_count_ip;
CREATE TABLE IF NOT EXISTS ?_count_ip (
  `id_ip` int(32) NOT NULL auto_increment,
  `ip` bigint(20) default NULL,
  `putdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `id_page` int(10) NOT NULL default '0',
  `browsers` enum('none','msie','opera','netscape','firefox','myie','mozilla') character set utf8 default 'none',
  `systems` enum('none','windows','unix','macintosh','robot_yandex','robot_google','robot_rambler','robot_aport','robot_msnbot') character set utf8 default 'none',
  PRIMARY KEY  (`id_ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ?_count_links;
CREATE TABLE IF NOT EXISTS ?_count_links (
  `id_links` int(8) NOT NULL auto_increment,
  `name` text,
  `comment` text,
  PRIMARY KEY  (`id_links`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ?_count_pages;
CREATE TABLE IF NOT EXISTS ?_count_pages (
  `id_page` int(10) NOT NULL auto_increment,
  `name` text,
  `title` text,
  `id_site` int(4) default NULL,
  PRIMARY KEY  (`id_page`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ?_count_refferer;
CREATE TABLE IF NOT EXISTS ?_count_refferer (
  `id_refferer` int(16) NOT NULL auto_increment,
  `name` tinytext,
  `putdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `ip` bigint(20) default NULL,
  `id_page` int(8) NOT NULL default '0',
  PRIMARY KEY  (`id_refferer`),
  FULLTEXT KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ?_count_searchquerys;
CREATE TABLE IF NOT EXISTS ?_count_searchquerys (
  `quer_id` int(11) NOT NULL auto_increment,
  `query` tinytext,
  `putdate` datetime NOT NULL default '0000-00-00 00:00:00',
  `ip` bigint(20) NOT NULL default '0',
  `id_page` int(11) NOT NULL default '0',
  `searches` enum('yandex','google','rambler','aport','mail','msn') character set utf8 default 'yandex',
  PRIMARY KEY  (`quer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
