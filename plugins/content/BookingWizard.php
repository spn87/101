<?php
/**
 * @version		bookingWizard 2009-11-09 
 * @package		Joomla
 * @subpackage	Content
 * @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
*/

// no direct access
defined( '_JEXEC' ) or die( 'Direct Access not allowed.' );

jimport('joomla.environment.uri' );

/**
 * Booking Wizard is a multi-widget plugin which provides access to all
 * the components necessary to operate a fully enabled Self-Catering
 * Accommodation website.  Components include a unique Booking Calendar
 * Wizard (with transition effects), Availability Search Widget and
 * Administration Centre, all ajax enabled.  Each of the widgets has a
 * selection of configuration options to enable you to operate it all from
 * within your own or your clients website.  
 *
**/

class plgContentBookingWizard extends JPlugin {

	function plgContentBookingWizard( &$subject, $params ) {
		parent::JPlugin( $subject, $params );
 	}

	function onPrepareContent( &$row, &$params, $limitstart=0 ) {
		$plugin =& JPluginHelper::getPlugin('content', 'BookingWizard');
		$pluginParams = new JParameter( $plugin->params );
		$param = new stdClass;
		
		// detect laguage if demanded
		if ($pluginParams->get('use_page_language','true')) {		
			if ($row->attribs) { // get content-page language
				$pageAttribs = new JParameter( $row->attribs );
				$param->booking_language = $pageAttribs->get('language'); 
			} 			
			if (! isset($param->booking_language)) { // get browser language	
				require_once JPATH_SITE.DS.'libraries'.DS.'joomla'.DS.'language'.DS.'helper.php'; 
				$param->booking_language = JLanguageHelper::detectLanguage();
			}
			$param->booking_language = substr($param->booking_language,0,2);	
		} else {
			$param->booking_language = $pluginParams->get('booking_language','en');	
		}

		$config['lang']=$param->booking_language;
		$config['account']=$pluginParams->get('account');
		$config['layout']=$pluginParams->get('layout');
		$config['debug']=$pluginParams->get('debug');
		$config['classid']=$pluginParams->get('classid');

		$row->text=booking_filterContent($row->text, '/\{booking (.*)\}/', $config);

		return true;
	}
}



function booking_filterContent($content, $expression, $config) {

		switch($config['layout']) {
			default:
			case "classic":
				$config['height']="420";
				$config['width']="630";
				break;

			case "banner":
				$config['height']="220";
				$config['width']="700";
				break;

			case "tower":
				$config['height']="550";
				$config['width']="210";
				break;
		}

		$runLocal=false;
		$subDom="www";
		if ($runLocal) {
			$subDom="loc";
		}
		$scriptExtra='';

		$output='<script type="text/javascript" src="http://'.$subDom.'.bookingwizard.net/js/Calendar.js?ver=1"></script>';
				
		// find tags in content-text
		preg_match_all($expression, $content, $matches);
		$cnt=0;
		if ( isset($matches[1])) {
			foreach($matches[1] as $wparam ) {
				@list(, $replStr) = each($matches[0]);
				@list($type,$code,$style) =  split(",",$wparam,3);
				$type=trim($type);
				$code=trim($code);
				$style=trim($style);

				switch($type) {

					case "administration":
						if ( $runLocal ) {
							$scriptExtra='admin.setSub("loc");';
						}
						$output = '<div class='.$config['classid'].'_admin style="'.$code.'" id=targ_admin></div>
							<script type="text/javascript" src="http://'.$subDom.'.bookingwizard.net/js/Admin.js"></script>
			<script type="text/javascript">
			<!--
				var admin = new Admin(720, 600, "'.$config['account'].'");
				admin.setTarget("targ_admin");
				admin.setFrameBorder('.$config['debug'].');
				'.$scriptExtra.'
				admin.show();
			-->
			</script>';
					break;

					case "availability":
						if ( $runLocal ) {
							$scriptExtra='avail.setSub("loc");';
						}
						$output .= '<div class='.$config['classid'].'_avail style="'.$code.'" id=targ_avail></div>
			<script type="text/javascript">
			<!--
			var avail = new Availability(180, 550, "'.$config['account'].'" );
				avail.setFrameBorder('.$config['debug'].');
				'.$scriptExtra.'
				avail.setLanguage("'.$config['lang'].'");
				avail.setTarget("targ_avail");
				avail.show();
			-->
			</script>';
					break;

					case "property":

						$cnt++;
						if ( $runLocal ) {
							$scriptExtra='cal'.$cnt.'.setSub("loc");';
						}

						$output .= '<div class='.$config['classid'].'_property  style="'.$style.'" id=targ_'.$code.'></div>
			<script type="text/javascript">
			<!--
				//
				var cal'.$cnt.' = new Calendar('.$config['width'].', '.$config['height'].', "'.$code.'", "'.$config['account'].'");
				cal'.$cnt.'.layout("'.$config['layout'].'");
				cal'.$cnt.'.setFrameBorder('.$config['debug'].');
				'.$scriptExtra.'
				cal'.$cnt.'.setLanguage("'.$config['lang'].'");
				cal'.$cnt.'.setTarget("targ_'.$code.'");
				cal'.$cnt.'.show();
			-->
			</script>';
					break;

				default:
					$output.="<div style='color:red; font-weight: bold;'>Booking Error: Unkown type entered into the Plugin environment : $replStr<br>Check Syntax.</div>";
					break;

				}
						
				
				$content = str_replace($replStr, $output, $content);			
				$output="";

			}	
		}

	return $content;


}

?>
