DROP TABLE IF EXISTS ?_articles;
CREATE TABLE IF NOT EXISTS ?_articles (
  `art_id` int(11) NOT NULL auto_increment,
  `tree_id` int(11) NOT NULL default '0',
  `art_date` datetime NOT NULL default '0000-00-00 00:00:00',
  `art_title` varchar(255) NOT NULL default '',
  `art_name` varchar(255) NOT NULL default '',
  `art_content` text NOT NULL,
  PRIMARY KEY  (`art_id`),
  FULLTEXT KEY `art_name` (`art_name`,`art_content`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;