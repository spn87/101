DROP TABLE IF EXISTS jos_ttbooking;

CREATE TABLE jos_ttbooking (
  `id` int(10) unsigned NOT NULL auto_increment,
  `fullname` varchar(250) NOT NULL,
  `address` varchar(500) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` date default NULL,
  `countries` varchar(150) default NULL,
  `mail` varchar(250) default NULL,
  `tcode` varchar(50) default NULL,
  `hotel` varchar(50) default NULL,
  `idt` int(4) default NULL,
  `departuredate` date default NULL,
  `rp_single` tinyint(4) default NULL,
  `rp_double` tinyint(4) default NULL,
  `rp_twin` tinyint(4) default NULL,
  `np_adult` tinyint(4) default NULL,
  `np_child` tinyint(4) default NULL,
  `detail` varchar(500) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
