<?php
/*
// "bretteleben.de Simple Picture Slideshow" Plugin for Joomla 1.5 - Version 1.5.5
// License: GNU General Public License version 2 or later; see LICENSE.txt
// Author: Andreas Berger - andreas_berger@bretteleben.de
// Copyright (C) 2011 Andreas Berger - http://www.bretteleben.de. All rights reserved.
// Project page and Demo at http://www.bretteleben.de
// ***Last update: 2011-01-11***
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

class JElementbexml extends JElement{
	var	$_name = 'Simple Picture Slideshow';
	var $_version = '1.5.5';

	function fetchElement($name, $value, &$node, $control_name){
		$view =  $node->attributes('view');

		switch ($view){

		case 'intro':
            $html="<div style='background-color:#c3d2e5;margin:-4px;padding:2px;'>";
            $html.="<b>".$this->_name." Version: ".$this->_version."</b><br />";
            $html.="for support and updates visit:&nbsp;";
            $html.="<a href='http://www.bretteleben.de' target='_blank'>www.bretteleben.de</a>";
            $html.="</div>";
		break;

		case 'slideshow':
            $html="<div style='background-color:#c3d2e5;margin:-4px;padding:2px;'>";
            $html.="<b>Slideshow</b><br />Settings regarding the slideshow in general.";
            $html.="</div>";
		break;

		case 'animation':
            $html="<div style='background-color:#c3d2e5;margin:-4px;padding:2px;'>";
            $html.="<b>Animation</b><br />Settings regarding the animation (duration, steps, ... see <a href='http://www.bretteleben.de/lang-en/joomla/simple-picture-slideshow/installation-and-usage-plugin.html' target='_blank'>Howto Plugin</a>).";
            $html.="</div>";
		break;

		case 'captions':
            $html="<div style='background-color:#c3d2e5;margin:-4px;padding:2px;'>";
            $html.="<b>Captions</b><br />Show title and/or text for images. Captions are set in the article using the code {besps_c}parameters{besps_c} (see <a href='http://www.bretteleben.de/lang-en/joomla/simple-picture-slideshow/-anleitung-plugin-code.html' target='_blank'>Howto Plugin Code</a>).";
            $html.="</div>";
		break;

		case 'links':
            $html="<div style='background-color:#c3d2e5;margin:-4px;padding:2px;'>";
            $html.="<b>Links</b><br />Link images to any target (default or selective). Links are set in the article using the code {besps_l}parameters{besps_l} (see <a href='http://www.bretteleben.de/lang-en/joomla/simple-picture-slideshow/-anleitung-plugin-code.html' target='_blank'>Howto Plugin Code</a>).";
            $html.="</div>";
		break;

		case 'controls':
            $html="<div style='background-color:#c3d2e5;margin:-4px;padding:2px;'>";
            $html.="<b>Controls</b><br />Set which navigation elements you want to show, the labels, their sort order (see <a href='http://www.bretteleben.de/lang-en/joomla/simple-picture-slideshow/installation-and-usage-plugin.html' target='_blank'>Howto Plugin</a>).";
            $html.="</div>";
		break;

		default:
            $html="<div style='background-color:#c3d2e5;margin:-4px;padding:2px;'>";
            $html.="<b>Other settings</b>";
            $html.="</div>";
		break;

		}
		return $html;
	}
}