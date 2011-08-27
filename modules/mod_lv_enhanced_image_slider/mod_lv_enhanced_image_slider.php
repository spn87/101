<?php

/**
 * LV ENHANCED image slider - An AJAX image slider
 *
 * @version 1.0
 * @package LV ENHANCED image slider
 * @author Juergen Koller
 * @copyright (C) http://www.lernvid.com
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 **/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
$mosConfig_absolute_path = JPATH_SITE;
$mosConfig_live_site = JURI :: base();
if(substr($mosConfig_live_site, -1)=="/") { $mosConfig_live_site = substr($mosConfig_live_site, 0, -1); }

// get parameters from the module's configuration
	$imageFolder	= $params->get( 'imageFolder', "" );
	$fade_duration	= $params->get( 'fade_duration', "" );
	$speed = $params->get( 'speed',"" );
	$useNav = $params->get( 'useNav',"" );
	$nextbutton = $params->get( 'nextbutton',"" );
	$prevbutton = $params->get( 'prevbutton',"" );
	$lveisindex = $params->get( 'lveisindex',"" );
	$timeout = $params->get( 'timeout',"" );
	$effectFx = $params->get( 'effectFx',"" );
	$pause = $params->get( 'pause',"" );
	$random = $params->get( 'random',"" );
	$stretchImages	= $params->get( 'stretchImages', "" );
	$imageCentered	= $params->get( 'imageCentered', "" );
	$lveisFloat	= $params->get( 'lveisFloat', "" );
	$lveisWidth	= $params->get( 'lveisWidth', "" );
	$imageWidth = $params->get( 'lveisWidth', "" );
	$ulHeight	= $params->get( 'ulHeight', "" );
	$imageHeight	= $params->get( 'ulHeight', "" );
	$navHeight	= $params->get( 'navHeight', "" );
	$uselinks	= $params->get( 'uselinks', "" );
	$linktarget	= $params->get( 'linktarget', "" );
	$useModalbox	= $params->get( 'useModalbox', "" );
	$useCompression = $params->get( 'useCompression',"" );
	$slider_id = $params->get( 'slider_id',"" );

	//	colors
	$transparentBgColor	= $params->get( 'transparentBgColor', "" );
	$lveis_bgcolor	= $params->get( 'lveis_bgcolor', "" );
	$lveisnav_bgcolor	= $params->get( 'lveisnav_bgcolor', "" );
	$lveisnav_bordercolor	= $params->get( 'lveisnav_bordercolor', "" );
	$lveisnav_a = $params->get( 'lveisnav_a', "" );
	$lveisnav_ahover = $params->get( 'lveisnav_ahover', "" );
	$lveisnav_aborder	= $params->get( 'lveisnav_aborder', "" );
	$lveisnav_aact = $params->get( 'lveisnav_aact', "" );
	$lveisnav_aactbg = $params->get( 'lveisnav_aactbg', "" );
	$lveisnav_aactborder = $params->get( 'lveisnav_aactborder', "" );


require(JModuleHelper::getLayoutPath('mod_lv_enhanced_image_slider'));
?>