<?php
/*
// "Very Simple Image Gallery" Plugin for Joomla 1.5 - Version 1.6.5
// License: http://www.gnu.org/copyleft/gpl.html
// Author: Andreas Berger - http://www.bretteleben.de
// Copyright (c) 2011 Andreas Berger - andreas_berger@bretteleben.de
// Project page and Demo at http://www.bretteleben.de
// ***Last update: 2011-03-06***
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

class JElementbexml extends JElement{
	var	$_name = 'Very Simple Image Gallery';
	var $_version = '1.6.5';

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

		case 'gallery':
            $html="<div style='background-color:#c3d2e5;margin:-4px;padding:2px;'>";
            $html.="<b>Gallery</b><br />Settings regarding the gallery in general.";
            $html.="</div>";
		break;

		case 'thumbs':
            $html="<div style='background-color:#c3d2e5;margin:-4px;padding:2px;'>";
            $html.="<b>Thumbnails</b><br />Settings regarding the thumbnails (size, quality, position, ...).";
            $html.="</div>";
		break;

		case 'captions':
            $html="<div style='background-color:#c3d2e5;margin:-4px;padding:2px;'>";
            $html.="<b>Captions</b><br />Show title and/or text for images. Captions are set in the article using the code {vsig_c}parameters{vsig_c} (see <a href='http://www.bretteleben.de/lang-en/joomla/very-simple-image-gallery/-anleitung-plugin-code.html' target='_blank'>Howto Plugin Code</a>).";
            $html.="</div>";
		break;

		case 'links':
            $html="<div style='background-color:#c3d2e5;margin:-4px;padding:2px;'>";
            $html.="<b>Links</b><br />Link images to any target (default or selective). Links are set in the article using the code {vsig_l}parameters{vsig_l} (see <a href='http://www.bretteleben.de/lang-en/joomla/very-simple-image-gallery/-anleitung-plugin-code.html' target='_blank'>Howto Plugin Code</a>).";
            $html.="</div>";
		break;

		case 'sets':
            $html="<div style='background-color:#c3d2e5;margin:-4px;padding:2px;'>";
            $html.="<b>Sets</b><br />This feature allows to split galleries to multiple sets and enables necessary navigation (see <a href='http://www.bretteleben.de/lang-en/joomla/very-simple-image-gallery/-anleitung-plugin.html' target='_blank'>Howto</a>).";
            $html.="</div>";
		break;

		case 'gd':
            $html="<div style='background-color:#c3d2e5;margin:-4px;padding:2px;'>";
            $html.="<b>GD library</b><br />Information about the PHP GD library on your server. The plugin uses this PHP extension to create thumbnails.";
            $html.="</div><div>";
						if(function_exists("gd_info")){
            	$html.="<br />GD is supported by your server!<br /><br />";
							$gd = gd_info();
							$be_gdarray=array(
										"gd" => "<span style='color:red'>unknown</span>",
										"jpg" => "<span style='color:red'>not enabled</span>",
										"png" => "<span style='color:red'>not enabled</span>",
										"gifr" => "<span style='color:red'>not enabled</span>",
										"gifw" => "<span style='color:red'>not enabled</span>");
							foreach ($gd as $k => $v) {
								if(stristr($k,"gd")!=FALSE){$be_gdarray["gd"]=$v;}
								if((stristr($k,"jpg")!=FALSE||stristr($k,"jpeg")!=FALSE)&&$v==1&&function_exists("imagecreatefromjpeg")){$be_gdarray["jpg"]="enabled";}
								if(stristr($k,"png")!=FALSE&&$v==1&&function_exists("imagecreatefrompng")){$be_gdarray["png"]="enabled";}
								if(stristr($k,"gif read")!=FALSE&&$v==1){$be_gdarray["gifr"]="enabled";}
								if(stristr($k,"gif create")!=FALSE&&$v==1&&function_exists("imagecreatefromgif")){$be_gdarray["gifw"]="enabled";}
							}
            	$html.="GD Version: ".$be_gdarray["gd"]."<br />";
            	$html.="JPG Support: ".$be_gdarray["jpg"]."<br />";
            	$html.="PNG Support: ".$be_gdarray["png"]."<br />";
            	$html.="GIF read Support: ".$be_gdarray["gifr"]."<br />";
            	$html.="GIF create Support: ".$be_gdarray["gifw"]."<br />";
						}else{
            	$html.="<br /><span style='color:red'>GD is not supported by your server!</span><br />";
						}
            $html.="<br /><a href='http://www.bretteleben.de/lang-en/joomla/very-simple-image-gallery/faq-a-troubleshooting.html#faq01' target='_blank'>Very Simple Image Gallery FAQ&Troubleshooting</a>";
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