<?php
/*
 * ARI Image Slider Joomla! module
 *
 * @package		ARI Image Slider Joomla! module.
 * @version		1.0.0
 * @author		ARI Soft
 * @copyright	Copyright (c) 2010 www.ari-soft.com. All rights reserved
 * @license		GNU/GPL (http://www.gnu.org/copyleft/gpl.html)
 * 
 */

defined('_JEXEC') or die('Restricted access');

if (version_compare(PHP_VERSION, '5.3.0') >= 0)
{
	$error_reporting = ini_get('error_reporting');
	$error_reporting &= ~E_STRICT;
	error_reporting($error_reporting);
}

require_once dirname(__FILE__) . '/mod_ariimageslider/kernel/class.AriKernel.php';

AriKernel::import('ImageSlider.ImageSlider');
AriKernel::import('Web.HtmlHelper');

$sliderId = uniqid('ais_', false);
AriImageSliderHelper::initSlider($sliderId, $params);

$slides = AriImageSliderHelper::prepareSlides(
	AriImageSliderHelper::getSlides($params),
	$params);

require JModuleHelper::getLayoutPath('mod_ariimageslider');
?>