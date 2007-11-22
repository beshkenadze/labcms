DROP TABLE IF EXISTS ?_todo;
CREATE TABLE IF NOT EXISTS `labcms_todo` (
  `todo_id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `descr` text NOT NULL,
  `status` enum('0','1') NOT NULL default '0',
  `author` varchar(100) NOT NULL default '',
  `type` enum('*','+','?','-') NOT NULL default '*',
  `task` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`todo_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
