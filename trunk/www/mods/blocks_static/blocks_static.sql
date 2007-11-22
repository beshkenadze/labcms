DROP TABLE IF EXISTS ?_blocks_static;
CREATE TABLE ?_blocks_static (
  block_id int(11) NOT NULL auto_increment,
  name varchar(255) NOT NULL default '',
  `data` text NOT NULL,
  visible tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (block_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;