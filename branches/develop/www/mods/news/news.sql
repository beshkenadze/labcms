DROP TABLE IF EXISTS ?_news;
CREATE TABLE ?_news (
  `news_id` int(3) NOT NULL auto_increment,
  `news_date` date default '0000-00-00',
  `news_title` varchar(150) NOT NULL default '',
  `news_text` text,
  `lang_id` int(3) NOT NULL,
  PRIMARY KEY  (`news_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT IGNORE INTO ?_config VALUES ('news_rss', '5', 'Количество новостей экспортируемых в rss');