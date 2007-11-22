DROP TABLE IF EXISTS ?_articles;
CREATE TABLE IF NOT EXISTS ?_blog (
  `blog_id` int(3) NOT NULL auto_increment,
  `user_id` int(3) NOT NULL default '0',
  `tree_id` int(3) NOT NULL default '0',
  `blog_date` timestamp default '0000-00-00 00:00:00',
  `blog_title` varchar(150) NOT NULL default '',
  `blog_text` text,
  PRIMARY KEY  (`blog_id`),
  KEY `tree_id` (`tree_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT IGNORE INTO ?_config VALUES ('blog_anonce_length', '0', 'Длина анонса блога (0 - новость полностью)');
INSERT IGNORE INTO ?_config VALUES ('blog_at_page', '10', 'Количество записей блога на странице');
