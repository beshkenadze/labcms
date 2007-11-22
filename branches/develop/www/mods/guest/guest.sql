DROP TABLE IF EXISTS ?_guest;
CREATE TABLE IF NOT EXISTS ?_guest (
  `msg_id` int(8) NOT NULL auto_increment,
  `user_id` int NOT NULL,
  `name` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `msg` mediumtext NOT NULL,
  `answer` mediumtext NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `ip` bigint(20) NOT NULL,
  PRIMARY KEY  (`msg_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    
INSERT IGNORE INTO ?_config VALUES ('guestbook_posts_at_page', '10', 'Количество сообщений на странице гостевой книги');    
INSERT IGNORE INTO ?_config VALUES ('catcher', 'tmp', 'Название поля противоспаммерского модуля (tmp)');
INSERT IGNORE INTO ?_config (`name`, `value`, `describe`) VALUES ('guestbook_admin_name', 'admin', 'Имя админа, которое будет отображаться в ответах гостевой книги.');
INSERT IGNORE INTO ?_config (`name`, `value`, `describe`) VALUES ('guestbook_email_notify', '0', 'Уведомления о новых сообщениях в гостевой книге.');
INSERT IGNORE INTO ?_config (`name`, `value`, `describe`) VALUES ('admin_mail', '', 'E-mail для сообщений сайта');
