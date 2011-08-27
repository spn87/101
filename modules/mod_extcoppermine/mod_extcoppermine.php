<?php
/**
 *  
 * @package    Joomla
 * @subpackage Modules
 * @license    GNU/GPL version 3
 * 
 */
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Include the syndicate functions only once
require_once( dirname(__FILE__).DS.'helper.php' );

$cpm = mod_helper::getcpm( $params );
require( JModuleHelper::getLayoutPath( 'mod_extcoppermine' ) );
?>
