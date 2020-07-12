CREATE TABLE `xoBile_plugins` (
  `id`          smallint(5) unsigned    NOT NULL auto_increment,
  `name`        varchar(150)            NOT NULL default '',
  `version`     smallint(5) unsigned    NOT NULL default '100',
  `weight`      smallint(3) unsigned    NOT NULL default '0',
  `isactive`    tinyint(1) unsigned     NOT NULL default '1',
  `isvisible`   tinyint(1) unsigned     NOT NULL default '1',
  `plugdir`     varchar(25)             NOT NULL,
  `moddir`      varchar(25)             NOT NULL,
  `hasadmin`    tinyint(1) unsigned     NOT NULL default '0',
  
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;

INSERT INTO `xoBile_plugins` (`id`, `name`, `version`, `weight`, `isactive`, `isvisible`, `plugdir`, `moddir`, `hasadmin`) VALUES
(1, 'Home', 100, 0, 1, 0, 'sytem', 'xobile', 0),
(2, 'About', 100, 1, 1, 1, 'about', 'xobile', 0);
