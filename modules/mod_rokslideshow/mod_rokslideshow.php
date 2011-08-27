<?php
/**
 * RokSlideshow Module
 *
 * @package RocketTheme
 * @subpackage rokslideshow
 * @version   4.2 August 23, 2010
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2010 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */


// no direct access
defined('_JEXEC') or die('Restricted access');
// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$imagePath 	= modRokSlideshowHelper::cleanDir($params->get( 'imagePath', 'images/stories/fruit' ));
$sortCriteria = $params->get( 'sortCriteria', 0);
$sortOrder = $params->get( 'sortOrder', 'asc');
$sortOrderManual = $params->get( 'sortOrderManual', '');

if (trim($sortOrderManual) != "")
	$images = explode(",", $sortOrderManual);
else
	$images = modRokSlideshowHelper::imageList($imagePath, $sortCriteria, $sortOrder);

if (count($images) > 0) modRokSlideshowHelper::loadScripts($params, $imagePath, $images);
require(JModuleHelper::getLayoutPath('mod_rokslideshow'));