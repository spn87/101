#
# Joom!Fish - Multi Lingual extention and translation manager for Joomla!
# Copyright (C) 2003-2007 Think Network GmbH, Munich
#
# @license The "GNU General Public License" (GPL) is available at http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
# @version $Id: joomfish.sql 567 2007-07-17 05:53:43Z akede $
# -----------------------------------------------------------------------------
#


/** SQL Script to create the structure and main information of JoomFish **/

DROP TABLE IF EXISTS `#__jf_content`;
CREATE TABLE IF NOT EXISTS `#__jf_content` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `language_id` int(11) NOT NULL default '0',
  `reference_id` int(11) NOT NULL default '0',
  `reference_table` varchar(100) NOT NULL default '',
  `reference_field` varchar(100) NOT NULL default '',
  `value` text NOT NULL,
  `original_value` varchar(255) default NULL,
  `original_text` text,
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) unsigned NOT NULL default '0',
  `published` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

ALTER TABLE `#__jf_content` ADD INDEX `jfContent` ( `language_id` , `reference_id` , `reference_table` ) ;
ALTER TABLE `#__jf_content` ADD INDEX `jfContentPublished` (`reference_id`, `reference_field`, `reference_table`, `language_id`, `published`);

DROP TABLE IF EXISTS `#__languages`;
CREATE TABLE `#__languages` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `active` tinyint(1) NOT NULL default '0',
  `iso` varchar(20) default NULL,
  `code` varchar(20) NOT NULL default '',
  `shortcode` varchar(20) default NULL,
  `image` varchar(100) default NULL,
  `fallback_code` varchar(20) NOT NULL default '',
  `params` text,
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;


DROP TABLE IF EXISTS `#__jf_tableinfo`;
CREATE TABLE IF NOT EXISTS `#__jf_tableinfo` (
  `id` int(11) NOT NULL auto_increment,
  `joomlatablename` varchar(100) NOT NULL default '',
  `tablepkID` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
