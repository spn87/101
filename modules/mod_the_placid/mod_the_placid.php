<?php
/**
 *
 * This program is free software: you can redistribute it and/or modify it under the terms
 * of the GNU General Public License as published by the Free Software Foundation,
 * either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *@author Neerav Dobaria
 *@link http://www.vareen.co.cc/ Official website
 **/
defined('_JEXEC') or die('Restricted access!');

$width = $params->get("width");
$height = $params->get("height");

$document = &JFactory::getDocument();
$swfjsurl = $realw . "modules/mod_the_placid/js/swfobject.js";
$swmacjsurl = $realw . "modules/mod_the_placid/js/swfmacmousewheel.js";
$swfurl = $realw . "modules/mod_the_placid/js/expressInstall.swf";

if($params->get('swfobject')){
  $document->addScript($swfjsurl);
}
$document->addScript($swmacjsurl);

$xmlfile = JPATH_BASE . "/modules/mod_the_placid/banner/xml/banner" . $module->id . ".xml";


if ($params->get('cache') or !file_exists($xmlfile)) {

  global $mainframe;
  jimport('joomla.filesystem.file');
  $realw = JURI::base();

//params
  $startWith = $params->get("startWith");
  $randomSlideshow = strtolower($params->get("randomSlideshow"));
  $backgroundColor = str_replace('#', '', $params->get("backgroundColor"));
  $backgroundTransparency = (int) $params->get("backgroundTransparency");
  $loop = strtolower($params->get("loop"));

  $playlist = <<<EOP
<?xml version="1.0" encoding="UTF-8"?>
<!-- Configuration panel -->
<slideshow width = "$width" height = "$height"
    startWith = "$startWith" 
    randomSlideshow = "$randomSlideshow"
		
    backgroundColor = "0x$backgroundColor"
    backgroundTransparency = "$backgroundTransparency"

    loop = "$loop">
<!-- End panel -->

EOP;
  $path = explode(CHR(10), trim($params->get('path')));
  $link = explode(CHR(10), trim($params->get('link')));
  $target = explode(CHR(10), trim($params->get('target')));
  $transitionTime = explode(CHR(10), trim($params->get('transitionTime')));
  $slideShowTime = explode(CHR(10), trim($params->get('slideShowTime')));

  $count = count($path);

  for ($i = 0; $i < $count; $i++)
  {
    $playlist .= <<<EOQ
  <item>
		<path>$path[$i]</path>
		<link>$link[$i]</link>
		<target>$target[$i]</target>

		<transitionTime>$transitionTime[$i]</transitionTime>
		<slideShowTime>$slideShowTime[$i]</slideShowTime>
	</item>

EOQ;
  }

  $playlist .= '</slideshow>';

  $compat = '';
  if (!@JFile::write($xmlfile, $playlist)) {
    printf('<div style="background-color: red;">
<center><span style="font-size: small; color: white;"><strong>Unable to create <span STYLE="color: yellow">
' . str_replace(JPATH_BASE, "", $xmlfile) . '</span> configuration file. <br/>
Please check your permissions!</strong></div>');
  }
}
?>
<?php ob_start(); ?>
// JAVASCRIPT VARS
// cache buster
var cacheBuster = "?t=" + Date.parse(new Date());
// stage dimensions
var stageW = "<?php echo $width; ?>";//"100%";
var stageH = "<?php echo $height; ?>";//"100%";


// ATTRIBUTES
var attributes = {};
attributes.id = 'placid<?php echo $module->id; ?>';
attributes.name = 'placid<?php echo $module->id; ?>';

// PARAMS
var params = {};
params.bgcolor = "#ffffff";
params.menu = "false";
params.scale = 'noScale';
params.wmode = "opaque";
params.allowfullscreen = "true";
params.allowScriptAccess = "always";


/* FLASH VARS */
var flashvars = {};

/// if commented / delete these lines, the component will take the stage dimensions defined
/// above in "JAVASCRIPT SECTIONS" section or those defined in the settings xml
flashvars.componentWidth = stageW;
flashvars.componentHeight = stageH;

/// path to the content folder(where the xml files, images or video are nested)
/// if you want to use absolute paths(like "http://domain.com/images/....") then leave it empty("")
flashvars.pathToFiles = "";

// path to content XML
flashvars.xmlPath = "modules/mod_the_placid/banner/xml/banner<?php echo $module->id; ?>.xml";

/** EMBED THE SWF**/
swfobject.embedSWF("modules/mod_the_placid/preview.swf"+cacheBuster, attributes.id, stageW, stageH, "9.0.124", "modules/mod_the_placid/js/expressInstall.swf", flashvars, params, attributes);
<?php $script = ob_get_clean();
$document->addScriptDeclaration($script);
?>
<table width="100%" height="100%" cellpadding="0" cellspacing="0">
  <td align="center">
    <!-- this div will be overwritten by SWF object -->
    <div id="placid<?php echo $module->id;?>">
      <p>In order to view this object you need Flash Player 9+ support!</p>
      <a href="http://www.adobe.com/go/getflashplayer">
        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif"
             alt="Get Adobe Flash player"/>
      </a>
    </div>
  </td>
</table>