<?php
/**
* @version		$Id: mod_random_image.php 10381 2008-06-01 03:35:53Z pasamio $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$document =& JFactory::getDocument();
$nombrebox="Webpsilon".rand(99, 99999);
$document->addCustomTag('<link href="'.JURI::root( true ).'/modules/mod_matrix3d_gallery/inc/a.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="'.JURI::root( true ).'/modules/mod_matrix3d_gallery/inc/shadowbox.css" />
		
	');


   $document->addScript(JURI::root( true ) . '/modules/mod_matrix3d_gallery/inc/swfobject.js'); 
   $document->addScript(JURI::root( true ) . '/modules/mod_matrix3d_gallery/inc/jquery.js');
   $document->addScript(JURI::root( true ) . '/modules/mod_matrix3d_gallery/inc/shadowbox-jquery.js');
$document->addScript(JURI::root( true ) . '/modules/mod_matrix3d_gallery/inc/shadowbox.js');

$document->addCustomTag('<script type="text/javascript">
		$(document).ready(function(){
		    var options = {
		        resizeLgImages:     true, loadingImage: "'.JURI::root( true ).'/modules/mod_matrix3d_gallery/images/loading.gif",
		        displayNav:         true, handleUnsupported:  \'remove\',
		        keysClose:          [\'c\', 27], // c or esc
		        autoplayMovies:     false,
				 text:           {

            cancel:     \'Cancel\',

            loading:    \'loading\',

            close:      \'<img src="'.JURI::root( true ).'/modules/mod_matrix3d_gallery/images/close.png" width="16" height="16" />\',

            next:      \'<img src="'.JURI::root( true ).'/modules/mod_matrix3d_gallery/images/next.png" width="16" height="16" />\',

            prev:      \'<img src="'.JURI::root( true ).'/modules/mod_matrix3d_gallery/images/previous.png" width="16" height="16" />\',

            errors:     {
                single: \'You must install the <a href="{0}">{1}</a> browser plugin to view this content.\',
                shared: \'You must install both the <a href="{0}">{1}</a> and <a href="{2}">{3}</a> browser plugins to view this content.\',
                either: \'You must install either the <a href="{0}">{1}</a> or the <a href="{2}">{3}</a> browser plugin to view this content.\'
            }

        }
		    };
		    Shadowbox.init(options);
		});
		
		function abrirSB(type, title, url)
			 {
			     Shadowbox.init({skipSetup: true});
			     Shadowbox.open({type: type, title: title, content: url, gallery:  "'.$nombrebox.'"});
		}; 
		
		
	</script>
	');

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$link 	 = $params->get( 'link' );

$folder	= mod_matrix3d_gallery::getFolder($params);
$images	= mod_matrix3d_gallery::getImages($params, $folder);

if (!count($images)) {
	echo JText::_( 'No Images');
	return;
}


require(JModuleHelper::getLayoutPath('mod_matrix3d_gallery'));
