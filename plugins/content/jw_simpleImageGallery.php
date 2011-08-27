<?php
/**
 * @version		2.1
 * @package		Simple Image Gallery (plugin)
 * @author    JoomlaWorks - http://www.joomlaworks.gr
 * @copyright	Copyright (c) 2006 - 2011 JoomlaWorks, a business unit of Nuevvo Webware Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.plugin.plugin' );

class plgContentJw_simpleImageGallery extends JPlugin {

  // JoomlaWorks reference parameters
	var $plg_name								= "jw_simpleImageGallery";
	var $plg_copyrights_start		= "\n\n<!-- JoomlaWorks \"Simple Image Gallery\" Plugin (v2.1) starts here -->\n";
	var $plg_copyrights_end			= "\n<!-- JoomlaWorks \"Simple Image Gallery\" Plugin (v2.1) ends here -->\n\n";
	var $plg_tag								= "gallery";

	function plgContentJw_simpleImageGallery( &$subject, $params ){
		parent::__construct( $subject, $params );
	}

	// Joomla! 1.5
	function onPrepareContent( &$row, &$params, $page=0 ){
		require(dirname(__FILE__).DS.'jw_simpleImageGallery_1.5.php');
	}
	
	// Joomla! 1.6
	function onContentPrepare($context, &$row, &$params, $page = 0){
		require(dirname(__FILE__).DS.'jw_simpleImageGallery_1.6.php');
	}
	
} // End class
