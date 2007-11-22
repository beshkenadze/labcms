DROP TABLE IF EXISTS ?_folio;
CREATE TABLE ?_folio (
  `folio_id` int(3) NOT NULL auto_increment,
  `folio_date` date default '0000-00-00',
  `folio_title` varchar(150) NOT NULL default '',
  `folio_text` text,
  PRIMARY KEY  (`folio_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO ?_config VALUES ('folio_at_page', '10', 'Количество работ на странице');
INSERT INTO ?_config VALUES ('folio_anonce_length', '0', 'Длина анонса  (0 - полностью)');
INSERT INTO ?_config VALUES ('folio_anonce_tag', '[anonce]', 'Тег, для анонса. none- тега нет.');