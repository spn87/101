<?php
/**
* YOOslider Joomla! Module
*
* @version   1.5.0
* @author    yootheme.com
* @copyright Copyright (C) 2007 YOOtheme Ltd. & Co. KG. All rights reserved.
* @license	 GNU/GPL
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

global $mainframe;

// count instances
if (!isset($GLOBALS['yoo_sliders'])) {
	$GLOBALS['yoo_sliders'] = 1;
} else {
	$GLOBALS['yoo_sliders']++;
}

// include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

// disable edit ability icon
$access = new stdClass();
$access->canEdit	= 0;
$access->canEditOwn = 0;
$access->canPublish = 0;

$list = modYOOsliderHelper::getList($params, $access);

// check if any results returned
$items = count($list);
if (!$items) {
	return;
}

// init vars
$mode           = $params->get('mode', 'drawer');
$style          = $params->get('style', 'drawer-v-a');
$layout         = $params->get('layout', 'vertical');
$module_height  = $params->get('module_height', '150');
$item_size      = $params->get('item_size', '150');
$item_minimized = $params->get('item_minimized', '50');

switch ($mode) {
	case 'drawer':
		$item_pos   = ($layout == 'vertical') ? 'top' : 'left';
		$item_shift = $item_size - $item_minimized - 10;
		$container  = $item_size + ($items-1) * $item_minimized;
		$js_items	= " .item";
		$js_options = ", shiftSize: " . $item_shift;
		break;

	case 'slider':
		$item_style    = ($layout == 'vertical') ? 'float: left; height: ' . $item_size . 'px; width: 100%;' : 'float: left; height: ' . $module_height . 'px;';
		$item_expanded = intval($items * $item_size - ($items - 1) * $item_minimized);
		$container     = $items * $item_size;
		$js_items      = " .item .toggler";
		$js_options    = ", sizeNormal: " . $item_size . ", sizeSmall: " . $item_minimized . ", sizeFull: " . $item_expanded;
		break;
}

$slider_id       = 'yoo-slider-' . $GLOBALS['yoo_sliders'];
$container_class = $style;
$container_style = ($layout == 'vertical') ? 'height: ' . $container . 'px;' : 'height: ' . $module_height . 'px;';
$javascript      = "new YOOslider('" . $slider_id . "', '#" . $slider_id . $js_items . "', { mode: '" . $mode . "', layout: '" . $layout . "'" . $js_options . " });";
$module_base     = JURI::base() . 'modules/mod_yoo_slider/';

require(JModuleHelper::getLayoutPath('mod_yoo_slider', 'default'));

$document =& JFactory::getDocument();
$document->addStyleSheet($module_base . 'mod_yoo_slider.css');
$document->addStyleSheet($module_base . 'styles/' . $style . '/style.css');
$document->addCustomTag('<!--[if IE 6]><link href="'. $module_base . 'styles/' . $style . '/ie6hacks.css" rel="stylesheet" type="text/css" /><![endif]-->');
$document->addScript($module_base . 'mod_yoo_slider.js');
echo "<script type=\"text/javascript\">\n// <!--\n$javascript\n// -->\n</script>\n";
