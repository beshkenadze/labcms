ALTER TABLE ?_modules DROP `feed`;
ALTER TABLE ?_modules CHANGE `multiple` `component` TINYINT( 1 ) NULL DEFAULT '0';
ALTER TABLE ?_tree_val CHANGE `hide` `show` TINYINT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE ?_users CHANGE `referal` `referral` INT( 1 ) NOT NULL DEFAULT '0';


ALTER TABLE `alna_tree_val` CHANGE `hide` `show` TINYINT( 1 ) NOT NULL DEFAULT '0';
ALTER TABLE `alna_modules` CHANGE `multiple` `component` TINYINT( 1 ) NOT NULL DEFAULT '0';