DROP TABLE IF EXISTS ?_access;
CREATE TABLE IF NOT EXISTS ?_access (
  `group_id` int(11) NOT NULL default '0',
  `module_id` int(11) NOT NULL default '0',
  `permis` set('read','add','edit','delete','msg_read','msg_add','msg_edit','msg_delete','moderator','admin') default NULL,
  PRIMARY KEY  (`group_id`,`module_id`),
  KEY module_id (module_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS ?_config;
CREATE TABLE IF NOT EXISTS ?_config (
  `name` varchar(255) NOT NULL default '',
  `value` mediumtext NOT NULL,
  `describe` mediumtext NOT NULL,
  PRIMARY KEY  (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO ?_config VALUES ('skin', 'default', 'Название скина (default)');
INSERT INTO ?_config VALUES ('site_name', 'LabCMS Site', 'Название сайта');
INSERT INTO ?_config VALUES ('site_desc', 'Fast, Flexible, Free CMS', 'Описание сайта');
INSERT INTO ?_config VALUES ('debug_mode', '1', 'Включение режима отладки');
INSERT INTO ?_config VALUES ('debug_console', '0', 'Использование отладочной консоли. В случае конфликта с JS - отключить.');
INSERT INTO ?_config VALUES ('default_lang', 'ru', 'Язык по умолчанию (ru)');
INSERT INTO ?_config VALUES ('top_news', '2', 'Количество новостей отображаемых модулем top_news');
INSERT INTO ?_config VALUES ('news_at_page', '10', 'Количество новостей на странице');
INSERT INTO ?_config VALUES ('news_anonce_length', '0', 'Длина анонса новостей (0 - новость полностью)');
INSERT INTO ?_config VALUES ('bbcode_word_length', '30', 'Ограничение на длину слов в комментариях (0 - отключено)');
INSERT INTO ?_config VALUES ('bbcode_link_length', '20', 'Ограничение на отображаемую длину ссылок в комментариях (0 - отключено)');
INSERT INTO ?_config VALUES ('referral_live', '10080', 'Время запоминания реферальной ссылки в минутах (10080 - неделя)');
INSERT INTO ?_config VALUES ('ext', '/', 'Дефолтное расширение в конце url');
INSERT INTO ?_config VALUES ('news_rss', '5', 'Количество новостей экспортируемых в rss');

DROP TABLE IF EXISTS ?_group_inc;
CREATE TABLE IF NOT EXISTS ?_group_inc (
  `group_id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ?_groups;
CREATE TABLE IF NOT EXISTS ?_groups (
  `group_id` tinyint(4) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL,
  `group_name` varchar(50) default NULL,
  PRIMARY KEY  (`group_id`),
  KEY parent_id (parent_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS ?_includes;
CREATE TABLE IF NOT EXISTS ?_includes (
  `id` int(11) NOT NULL auto_increment,
  `tree_id` int(11) default NULL,
  `group_id` int(11) default NULL,
  `module_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY tree_id (tree_id),
  KEY group_id (group_id),
  KEY module_id (module_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO ?_includes VALUES (20, 5, NULL, 1);
INSERT INTO ?_includes VALUES (17, 7, NULL, 4);
INSERT INTO ?_includes VALUES (16, 8, NULL, 5);
INSERT INTO ?_includes VALUES (15, 9, NULL, 6);
INSERT INTO ?_includes VALUES (14, 1, NULL, 8);
INSERT INTO ?_includes VALUES (12, 6, NULL, 3);
INSERT INTO ?_includes VALUES (9, 4, NULL, 2);
INSERT INTO ?_includes VALUES (32, 13, NULL, 12);
INSERT INTO ?_includes VALUES (31, 2, NULL, 8);
INSERT INTO ?_includes VALUES (25, 11, NULL, 10);
INSERT INTO ?_includes VALUES (29, 14, NULL, 6);
INSERT INTO ?_includes VALUES (30, 14, NULL, 11);
INSERT INTO ?_includes VALUES (34, 2, NULL, 13);

DROP TABLE IF EXISTS ?_modules;
CREATE TABLE IF NOT EXISTS ?_modules (
  `module_id` int(11) NOT NULL auto_increment,
  `module` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `section` varchar(60) NOT NULL default '',
  `component` tinyint(1) default '0',
  `static` tinyint(1) default '0',
  `search` tinyint(1) default '0',
  `disable` tinyint(1) default '0',
  PRIMARY KEY  (`module_id`),
  KEY `component` (`component`),
  KEY `static` (`static`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO ?_modules (`module_id`, `module`, `name`, `section`, `component`, `static`, `search`, `disable`) VALUES 
(1, 'login/', 'авторизация', 'login', 0, 0, 0, 0),
(2, 'tree/', 'главное дерево', 'tree', 1, 0, 0, 0),
(3, 'modules/', 'модули', 'modules', 1, 0, 0, 0),
(4, 'config/', 'настройки', 'config', 1, 0, 0, 0),
(5, 'users/', 'пользователи', 'users', 1, 0, 0, 0),
(6, 'pages/', 'статические страницы', 'pages', 1, 0, 1, 0),
(8, 'menu_level_1/', 'главное меню', 'menu_level_1', 0, 1, 0, 0),
(10, 'news/', 'новости', 'news', 1, 0, 0, 0),
(11, 'top_news/', 'топ новостей', 'news', 0, 0, 0, 0),
(12, 'sitemap/', 'карта сайта', 'sitemap', 1, 0, 0, 0),
(13, 'path/', 'навигационный путь', '', 0, 1, 0, 0),
(14, 'reg/', 'Регистрация пользователей', 'users', 1, 0, 0, 0);

INSERT INTO ?_access (`group_id`, `module_id`, `permis`) VALUES 
(0, 1, 'read'),
(0, 6, 'read'),
(0, 8, 'read'),
(0, 10, 'read'),
(0, 11, 'read'),
(0, 12, 'read'),
(0, 2, NULL),
(0, 3, NULL),
(0, 13, 'read'),
(0, 4, NULL),
(0, 5, NULL),
(0, 14, NULL),
(2, 1, 'read'),
(2, 2, NULL),
(2, 8, 'read'),
(2, 12, 'read'),
(2, 3, NULL),
(2, 13, 'read'),
(2, 4, NULL),
(2, 10, 'read'),
(2, 5, NULL),
(2, 14, NULL),
(2, 6, 'read'),
(2, 11, 'read');


DROP TABLE IF EXISTS ?_news;
CREATE TABLE IF NOT EXISTS ?_news (
	  news_id int(3) NOT NULL auto_increment,
	  news_date date default '0000-00-00',
	  news_title varchar(150) NOT NULL default '',
	  news_text text,
	  lang_id int(3) NOT NULL,
	  PRIMARY KEY  (news_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO ?_news VALUES (1, NOW(), 'Запуск нового движка!', '<p>Свершилось!</p>\r\n<p>Сегодня, наконец-то, установил новую CMS</p>\r\n<p>Теперь заживем по новому!</p>\r\n<p>LAB CMS - RULEZ FOREVER!!!</p>', 1);

DROP TABLE IF EXISTS ?_pages;
CREATE TABLE IF NOT EXISTS ?_pages (
  `page_id` int(11) NOT NULL auto_increment,
  `tree_id` int(11) NOT NULL default '0',
  `page_title` varchar(255) NOT NULL default '',
  `page_text` text NOT NULL,
  PRIMARY KEY  (`page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO ?_pages VALUES (1, 14, 'Вас приветствует LAB CMS!', '<p>Привет!</p>\r\n<p>&nbsp;</p>\r\n<ul>\r\n    <li>Для начала вам нужно <a href="/login">авторизоваться.</a></li>\r\n    <li>После этого вам станут доступны страницы управления:\r\n    <ul>\r\n        <li><a href="/tree">главное дерево</a></li>\r\n        <li><a href="/modules">модули</a></li>\r\n        <li><a href="/config">конфигурация</a></li>\r\n        <li><a href="/users">пользователи</a></li>\r\n        <li><a href="/pages">cтатические страницы</a></li>\r\n    </ul>\r\n    </li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<p>Админский логин: admin</p>\r\n<p>Админский пароль: admin</p>');

DROP TABLE IF EXISTS ?_tree;
CREATE TABLE IF NOT EXISTS ?_tree (
  `tree_id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`tree_id`),
  KEY parent_id (parent_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO ?_tree VALUES (1, 0);
INSERT INTO ?_tree VALUES (2, 0);
INSERT INTO ?_tree VALUES (11, 2);
INSERT INTO ?_tree VALUES (4, 1);
INSERT INTO ?_tree VALUES (5, 2);
INSERT INTO ?_tree VALUES (6, 1);
INSERT INTO ?_tree VALUES (7, 1);
INSERT INTO ?_tree VALUES (8, 1);
INSERT INTO ?_tree VALUES (9, 1);
INSERT INTO ?_tree VALUES (13, 2);
INSERT INTO ?_tree VALUES (14, 2);

DROP TABLE IF EXISTS ?_tree_val;
CREATE TABLE IF NOT EXISTS ?_tree_val (
  `tree_id` int(11) NOT NULL default '0',
  `tree_name` tinytext NOT NULL,
  `params` varchar(255) NOT NULL default '',
  `group_id` int(11) default NULL,
  `template` varchar(255) NOT NULL default '',
  `menu` tinyint(1) NOT NULL default '0',
  `sitemap` tinyint(4) NOT NULL default '0',
  `path` varchar(255) default NULL,
  `pos` int(11) NOT NULL default '0',
  `show` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`tree_id`),
  KEY group_id (group_id),
  KEY pos (pos),
  KEY `show` (`show`),
  KEY menu (menu),
  KEY sitemap (sitemap)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO ?_tree_val VALUES (1, 'админка', '', 0, 'default', 0, 0, '', 1, 0);
INSERT INTO ?_tree_val VALUES (2, 'корень сайта', '', 0, 'default', 0, 1, NULL, 0, 0);
INSERT INTO ?_tree_val VALUES (4, 'главное дерево', '', 0, '', 1, 0, '/tree', 0, 1);
INSERT INTO ?_tree_val VALUES (5, 'авторизация', '', 0, '', 1, 1, '/login', 3, 1);
INSERT INTO ?_tree_val VALUES (6, 'модули', '', 0, '0', 1, 0, '/modules', 0, 1);
INSERT INTO ?_tree_val VALUES (7, 'конфигурация', '', 0, '0', 1, 0, '/config', 0, 1);
INSERT INTO ?_tree_val VALUES (8, 'пользователи', '', 0, '0', 1, 0, '/users', 0, 1);
INSERT INTO ?_tree_val VALUES (9, 'cтатические страницы', '', 0, '0', 1, 0, '/pages', 0, 1);
INSERT INTO ?_tree_val VALUES (11, 'новости', '', 0, '', 1, 1, '/news', 1, 1);
INSERT INTO ?_tree_val VALUES (13, 'карта сайта', '', 0, '', 1, 1, '/sitemap', 2, 1);
INSERT INTO ?_tree_val VALUES (14, 'главная', '', 0, '0', 1, 1, '/', 0, 1);

DROP TABLE IF EXISTS ?_users;
CREATE TABLE IF NOT EXISTS ?_users (
  `user_id` int(11) NOT NULL auto_increment,
  `group_id` tinyint(4) NOT NULL default '2',
  `login` varchar(20) NOT NULL default '',
  `pass` varchar(32) NOT NULL default '',
  `email` varchar(50) NOT NULL default '',
  `register_date` datetime NULL DEFAULT '0000-00-00 00:00:00',
	`last_visit` datetime NULL DEFAULT '0000-00-00 00:00:00',
	`last_session` datetime NULL DEFAULT '0000-00-00 00:00:00',
	`avatar` varchar(100) NULL DEFAULT '',
	`icq` varchar(12) NULL DEFAULT '',
	`website` varchar(100) NULL DEFAULT '',
	`aim` varchar(255) NULL DEFAULT '',
	`yim` varchar(255) NULL DEFAULT '',
	`jabber` varchar(255) NULL DEFAULT '',
	`msnm` varchar(255) NULL DEFAULT '',
	`skype` varchar(120) NULL DEFAULT '',
	`status` int(11) NULL DEFAULT '0',
	`actkey` varchar(32) NULL DEFAULT '',
	`new_pass` varchar(32) NULL DEFAULT '',
	`realname` varchar(120)  NULL DEFAULT '',
	`referral` int(11) NULL DEFAULT '0',
	`custom1` varchar(255) NULL DEFAULT '',
	`custom2` varchar(255) NULL DEFAULT '',
	`custom3` varchar(255) NULL DEFAULT '',
  PRIMARY KEY  (`user_id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO ?_groups VALUES  (1, 0, 'Супер Администратор');
INSERT INTO ?_groups VALUES  (2, 0, 'Пользователи');

INSERT INTO ?_users ( `user_id` , `group_id` , `login` , `pass` , `email` , `register_date` , `last_visit` , `last_session` , `avatar` , `icq` , `website` , `aim` , `yim` , `jabber` , `msnm` , `skype` , `status` , `actkey` , `new_pass` , `realname` , `custom1` , `custom2` , `custom3` )
VALUES (
'-1', '0', '', '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', ''
);
INSERT INTO ?_users ( `user_id` , `group_id` , `login` , `pass` , `email` , `register_date` , `last_visit` , `last_session` , `avatar` , `icq` , `website` , `aim` , `yim` , `jabber` , `msnm` , `skype` , `status` , `actkey` , `new_pass` , `realname` , `custom1` , `custom2` , `custom3` )
VALUES (
'1', '1', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@domain.com', NOW(), '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', '', '', '', '', '', '', '', '1', '', '', '', '', '', ''
);

DROP TABLE IF EXISTS ?_langs;
CREATE TABLE IF NOT EXISTS ?_langs (
  lang_id int(11) NOT NULL auto_increment,
  lang_name varchar(100) NOT NULL default '',
  `key` varchar(5) NOT NULL default '',
  PRIMARY KEY  (lang_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO ?_langs (lang_id, lang_name, `key`) VALUES 
(1, 'Русский', 'ru'),
(2, 'English', 'en');

DROP TABLE IF EXISTS ?_tree_langs;
CREATE TABLE IF NOT EXISTS ?_tree_langs (
  tree_id int(11) NOT NULL default '0',
  lang_id int(11) NOT NULL default '0',
  PRIMARY KEY  (tree_id,lang_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO ?_tree_langs (`tree_id`, `lang_id`) VALUES (1, 1), (2, 1);

DROP TABLE IF EXISTS ?_translate;
CREATE TABLE ?_translate (
  text_id int(11) NOT NULL default '0',
  lang_id int(11) NOT NULL default '0',
  `text` text NOT NULL,
  PRIMARY KEY  (text_id,lang_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS ?_translate_keys;
CREATE TABLE ?_translate_keys (
  text_id int(11) NOT NULL auto_increment,
  text_key text NOT NULL,
  text_descr varchar(255) NOT NULL default '',
  PRIMARY KEY  (text_id),
  UNIQUE KEY text_key (text_key(333))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;