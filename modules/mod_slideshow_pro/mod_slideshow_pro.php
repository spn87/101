<?php
/**
* @version		$Id: default.php 00005 2009-11-10 00:00:00 umitkenan $
* @package		Joomla
* @subpackage	SlideShow Pro Module
* @link 		http://www.jt.gen.tr
* @copyright	Copyright (C) Joomla Türkçe Eðitim ve Destek Sitesi. http://www.jt.gen.tr 
* @license		GNU/GPL
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );

$preparing = modSlideShowProHelper::getParameterList($params);

$path = JModuleHelper::getLayoutPath('mod_slideshow_pro', 'default');
if (file_exists($path)) {
	require($path);
}